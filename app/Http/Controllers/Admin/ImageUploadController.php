<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    /**
     * Upload image for CKEditor
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:10240' // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'message' => 'Tệp tải lên không hợp lệ. Vui lòng chọn file ảnh (JPG, PNG, GIF, WEBP) nhỏ hơn 10MB.'
                ]
            ], 400);
        }

        try {
            $image = $request->file('upload');
            
            // Tạo tên file unique
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            
            // Đường dẫn lưu file  
            $directory = 'assets/uploads/articles';
            $fullPath = public_path($directory);
            
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
            
            // Tối ưu hóa và nén ảnh trước khi lưu
            $optimizedPath = $this->optimizeImage($image, $fullPath . '/' . $filename);
            
            // URL để trả về
            $url = asset($directory . '/' . $filename);

            return response()->json([
                'url' => $url,
                'uploaded' => true,
                'filename' => $filename
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Có lỗi xảy ra khi tải ảnh lên: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Tối ưu hóa và nén ảnh
     */
    private function optimizeImage($uploadedFile, $destinationPath)
    {
        $imageInfo = getimagesize($uploadedFile->getPathname());
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $imageType = $imageInfo[2];
        
        // Kích thước tối đa cho website (có thể điều chỉnh)
        $maxWidth = 1200;
        $maxHeight = 800;
        $quality = 85; // Chất lượng nén (85% là tốt cho web)
        
        // Tính toán kích thước mới nếu cần
        if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
            $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
            $newWidth = intval($originalWidth * $ratio);
            $newHeight = intval($originalHeight * $ratio);
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }
        
        // Tạo canvas mới
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        
        // Tạo image từ file upload
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($uploadedFile->getPathname());
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($uploadedFile->getPathname());
                // Preserve transparency for PNG
                imagealphablending($canvas, false);
                imagesavealpha($canvas, true);
                $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
                imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($uploadedFile->getPathname());
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($uploadedFile->getPathname());
                break;
            default:
                throw new \Exception('Định dạng ảnh không được hỗ trợ');
        }
        
        // Resize ảnh
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Lưu ảnh đã tối ưu
        $extension = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($canvas, $destinationPath, $quality);
                break;
            case 'png':
                // PNG quality is 0-9, convert from 0-100
                $pngQuality = intval((100 - $quality) / 10);
                imagepng($canvas, $destinationPath, $pngQuality);
                break;
            case 'gif':
                imagegif($canvas, $destinationPath);
                break;
            case 'webp':
                imagewebp($canvas, $destinationPath, $quality);
                break;
        }
        
        // Giải phóng bộ nhớ
        imagedestroy($canvas);
        imagedestroy($source);
        
        return $destinationPath;
    }

    /**
     * Upload multiple images
     */
    public function uploadMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Một hoặc nhiều file không hợp lệ.'
            ], 400);
        }

        $uploadedFiles = [];
        
        try {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $directory = 'assets/uploads/articles';
                $fullPath = public_path($directory);
                
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                
                $file->move($fullPath, $filename);
                
                $uploadedFiles[] = [
                    'filename' => $filename,
                    'url' => asset($directory . '/' . $filename),
                    'size' => $file->getSize()
                ];
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles,
                'message' => 'Tất cả ảnh đã được tải lên thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải ảnh: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filename' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Tên file không hợp lệ.'
            ], 400);
        }

        try {
            $filename = $request->input('filename');
            $filePath = public_path('assets/uploads/articles/' . $filename);

            if (file_exists($filePath)) {
                unlink($filePath);
                return response()->json([
                    'success' => true,
                    'message' => 'Ảnh đã được xóa thành công!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy file.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa ảnh: ' . $e->getMessage()
            ], 500);
        }
    }
}
