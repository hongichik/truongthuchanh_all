<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Cập nhật ảnh header của website
     */
    public function updateHeaderImage(Request $request)
    {
        try {
            $config = config('website.header_image');
            
            // Validate request
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:' . implode(',', $config['allowed_types']) . '|max:' . $config['max_size'],
            ], [
                'image.required' => 'Vui lòng chọn file ảnh',
                'image.image' => 'File phải là định dạng ảnh',
                'image.mimes' => 'Ảnh phải có định dạng: ' . implode(', ', $config['allowed_types']),
                'image.max' => 'Kích thước ảnh không được vượt quá ' . ($config['max_size']/1024) . 'MB',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $image = $request->file('image');
            $admin = auth()->guard('admin')->user();
            
            // Tạo tên file unique
            $timestamp = time();
            $extension = $image->getClientOriginalExtension();
            $imageName = 'bg_header_' . $timestamp . '.' . $extension;
            
            // Lưu ảnh vào thư mục public
            $publicPath = public_path($config['path']);
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            
            $imagePath = $image->move($publicPath, $imageName);
            
            // Backup ảnh cũ nếu được kích hoạt
            if ($config['backup_enabled']) {
                $oldImagePath = public_path($config['path'] . $config['current']);
                if (file_exists($oldImagePath) && $config['current'] !== $imageName) {
                    $backupName = 'bg_header_backup_' . $timestamp . '.' . pathinfo($config['current'], PATHINFO_EXTENSION);
                    copy($oldImagePath, public_path($config['path'] . $backupName));
                }
            }
            
            // Xóa ảnh cũ (trừ ảnh mặc định)
            $oldImagePath = public_path($config['path'] . $config['current']);
            if (file_exists($oldImagePath) && $config['current'] !== $config['default']) {
                unlink($oldImagePath);
            }
            
            // Rename ảnh mới thành tên chuẩn
            $finalImageName = 'bg_header.' . $extension;
            $finalPath = public_path($config['path'] . $finalImageName);
            rename(public_path($config['path'] . $imageName), $finalPath);
            
            // Cập nhật config
            $this->updateWebsiteConfig('header_image', [
                'current' => $finalImageName,
                'last_updated' => now()->toDateTimeString(),
                'updated_by' => $admin->id,
                'updated_by_name' => $admin->name,
            ]);
            
            // Clear config cache
            \Artisan::call('config:clear');

            return response()->json([
                'success' => true,
                'message' => 'Ảnh header đã được cập nhật thành công!',
                'imageUrl' => asset($config['path'] . $finalImageName) . '?v=' . $timestamp,
                'config' => $this->getHeaderImageConfig()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating header image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật ảnh. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    /**
     * Lấy thông tin ảnh header hiện tại
     */
    public function getCurrentHeaderImage()
    {
        try {
            $config = $this->getHeaderImageConfig();
            $imagePath = public_path($config['path'] . $config['current']);
            
            if (!file_exists($imagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy ảnh header'
                ], 404);
            }

            $imageInfo = [
                'url' => asset($config['path'] . $config['current']),
                'filename' => $config['current'],
                'size' => filesize($imagePath),
                'lastModified' => filemtime($imagePath),
                'lastUpdated' => $config['last_updated'],
                'updatedBy' => $config['updated_by_name'],
                'config' => $config
            ];

            return response()->json([
                'success' => true,
                'data' => $imageInfo
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting current header image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy thông tin ảnh'
            ], 500);
        }
    }

    /**
     * Reset ảnh header về mặc định
     */
    public function resetHeaderImage()
    {
        try {
            $config = config('website.header_image');
            $admin = auth()->guard('admin')->user();
            
            $currentImagePath = public_path($config['path'] . $config['current']);
            $defaultImagePath = public_path($config['path'] . $config['default']);
            
            // Kiểm tra ảnh mặc định có tồn tại không
            if (!file_exists($defaultImagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy ảnh mặc định'
                ], 404);
            }

            // Backup ảnh hiện tại nếu cần
            if ($config['backup_enabled'] && file_exists($currentImagePath)) {
                $backupName = 'bg_header_backup_' . time() . '.' . pathinfo($config['current'], PATHINFO_EXTENSION);
                copy($currentImagePath, public_path($config['path'] . $backupName));
            }
            
            // Copy ảnh mặc định thành ảnh hiện tại
            copy($defaultImagePath, $currentImagePath);
            
            // Cập nhật config
            $this->updateWebsiteConfig('header_image', [
                'current' => $config['default'],
                'last_updated' => now()->toDateTimeString(),
                'updated_by' => $admin->id,
                'updated_by_name' => $admin->name,
            ]);
            
            // Clear config cache
            \Artisan::call('config:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Đã khôi phục ảnh header mặc định',
                'imageUrl' => asset($config['path'] . $config['default']) . '?v=' . time(),
                'config' => $this->getHeaderImageConfig()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error resetting header image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi khôi phục ảnh mặc định'
            ], 500);
        }
    }

    /**
     * Lấy cấu hình ảnh header
     */
    private function getHeaderImageConfig()
    {
        return config('website.header_image');
    }

    /**
     * Cập nhật cấu hình website
     */
    private function updateWebsiteConfig(string $key, array $data)
    {
        $configPath = config_path('website.php');
        $config = include $configPath;

        // Merge dữ liệu mới vào config hiện tại
        $config[$key] = array_merge($config[$key], $data);

        // Ghi lại file config
        $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        file_put_contents($configPath, $configContent);
    }

    /**
     * Lấy toàn bộ cấu hình website
     */
    public function getWebsiteConfig()
    {
        try {
            $settings = HomeSetting::current();
            
            $config = [
                'header_image' => [
                    'current' => $settings->header_image,
                    'path' => 'assets/image/',
                ],
                'logo' => [
                    'current' => $settings->logo,
                    'path' => 'assets/image/',
                ],
                'contact_info' => $settings->contact_info ?? [],
                'school_info' => $settings->school_info ?? [],
                'social_links' => $settings->social_links ?? []
            ];
            
            return response()->json([
                'success' => true,
                'data' => $config
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting website config: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy cấu hình website'
            ], 500);
        }
    }

    /**
     * Cập nhật cấu hình website tổng thể
     */
    public function updateWebsiteConfigGeneral(Request $request)
    {
        try {
            $admin = auth()->guard('admin')->user();
            $validator = Validator::make($request->all(), [
                'section' => 'required|string|in:contact_info,school_info,social_links',
                'data' => 'required|array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $section = $request->input('section');
            $data = $request->input('data');

            // Lấy home setting hiện tại
            $settings = HomeSetting::current();

            // Cập nhật section tương ứng
            switch ($section) {
                case 'contact_info':
                    $settings->contact_info = array_merge($settings->contact_info ?? [], $data);
                    break;
                case 'school_info':
                    $settings->school_info = array_merge($settings->school_info ?? [], $data);
                    break;
                case 'social_links':
                    $settings->social_links = array_merge($settings->social_links ?? [], $data);
                    break;
            }

            $settings->save();

            return response()->json([
                'success' => true,
                'message' => 'Cấu hình đã được cập nhật thành công!',
                'data' => $settings->{$section}
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating website config: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật cấu hình'
            ], 500);
        }
    }
}