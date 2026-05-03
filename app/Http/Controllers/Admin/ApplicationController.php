<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DangKyLop1;
use App\Models\DangKyLop6;
use App\Models\DangKyLop10;
use Yajra\DataTables\DataTables;

class ApplicationController extends Controller
{
    // Hiển thị trang tổng quan
    public function index()
    {
        $stats = [
            'lop1' => [
                'total' => DangKyLop1::count(),
                'pending' => DangKyLop1::where('status', 'pending')->count(),
                'approved' => DangKyLop1::where('status', 'approved')->count(),
                'rejected' => DangKyLop1::where('status', 'rejected')->count(),
            ],
            'lop6' => [
                'total' => DangKyLop6::count(),
                'pending' => DangKyLop6::where('status', 'pending')->count(),
                'approved' => DangKyLop6::where('status', 'approved')->count(),
                'rejected' => DangKyLop6::where('status', 'rejected')->count(),
            ],
            'lop10' => [
                'total' => DangKyLop10::count(),
                'pending' => DangKyLop10::where('status', 'pending')->count(),
                'approved' => DangKyLop10::where('status', 'approved')->count(),
                'rejected' => DangKyLop10::where('status', 'rejected')->count(),
            ]
        ];
        
        return view('admin.applications.index', compact('stats'));
    }
    
    // Danh sách đơn lớp 1
    public function lop1()
    {
        return view('admin.applications.lop1');
    }
    
    // DataTable cho lớp 1
    public function lop1Data()
    {
        $applications = DangKyLop1::select([
            'id', 'fullname', 'birthdate', 'gender', 'phone', 
            'guardian_name', 'status', 'created_at'
        ])->orderBy('created_at', 'desc');
        
        return DataTables::of($applications)
            ->addColumn('action', function($row) {
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(1, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <button type="button" class="btn btn-sm btn-success" onclick="approveApplication(1, '.$row->id.')">
                            <i class="fas fa-check"></i> Duyệt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectApplication(1, '.$row->id.')">
                            <i class="fas fa-times"></i> Từ chối
                        </button>
                    </div>
                ';
            })
            ->editColumn('status', function($row) {
                $badges = [
                    'pending' => '<span class="badge bg-warning text-dark">Chờ duyệt</span>',
                    'approved' => '<span class="badge bg-success">Đã duyệt</span>',
                    'rejected' => '<span class="badge bg-danger">Từ chối</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge bg-secondary">Không xác định</span>';
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->editColumn('birthdate', function($row) {
                return $row->birthdate->format('d/m/Y');
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
    
    // Danh sách đơn lớp 6
    public function lop6()
    {
        return view('admin.applications.lop6');
    }
    
    // DataTable cho lớp 6
    public function lop6Data()
    {
        $applications = DangKyLop6::select([
            'id', 'fullname', 'birthdate', 'gender', 'phone', 
            'current_school', 'status', 'created_at'
        ])->orderBy('created_at', 'desc');
        
        return DataTables::of($applications)
            ->addColumn('action', function($row) {
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(6, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <button type="button" class="btn btn-sm btn-success" onclick="approveApplication(6, '.$row->id.')">
                            <i class="fas fa-check"></i> Duyệt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectApplication(6, '.$row->id.')">
                            <i class="fas fa-times"></i> Từ chối
                        </button>
                    </div>
                ';
            })
            ->editColumn('status', function($row) {
                $badges = [
                    'pending' => '<span class="badge bg-warning text-dark">Chờ duyệt</span>',
                    'approved' => '<span class="badge bg-success">Đã duyệt</span>',
                    'rejected' => '<span class="badge bg-danger">Từ chối</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge bg-secondary">Không xác định</span>';
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->editColumn('birthdate', function($row) {
                return $row->birthdate->format('d/m/Y');
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
    
    // Danh sách đơn lớp 10
    public function lop10()
    {
        return view('admin.applications.lop10');
    }
    
    // DataTable cho lớp 10
    public function lop10Data()
    {
        $applications = DangKyLop10::select([
            'id', 'fullname', 'birthdate', 'gender', 'phone', 
            'current_school', 'status', 'created_at',
            'academic_transcript_path', 'additional_documents_paths',
            'documents_uploaded_at'
        ])->orderBy('created_at', 'desc');
        
        return DataTables::of($applications)
            ->addColumn('action', function($row) {
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(10, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <button type="button" class="btn btn-sm btn-success" onclick="approveApplication(10, '.$row->id.')">
                            <i class="fas fa-check"></i> Duyệt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectApplication(10, '.$row->id.')">
                            <i class="fas fa-times"></i> Từ chối
                        </button>
                    </div>
                ';
            })
            ->addColumn('documents', function($row) {
                $html = '';
                
                // Học bạ chính (có thể nhiều files)
                $academicData = $row->academic_transcript_path;
                if ($academicData) {
                    // Handle both string JSON and actual array
                    if (is_string($academicData)) {
                        $academicPaths = json_decode($academicData, true) ?: [];
                    } elseif (is_array($academicData)) {
                        $academicPaths = $academicData;
                    } else {
                        $academicPaths = [];
                    }
                    
                    if (!empty($academicPaths)) {
                        $academicCount = count($academicPaths);
                        
                        $html .= '<a href="'.route('admin.applications.download', ['type' => 'academic', 'id' => $row->id]).'" class="btn btn-sm btn-primary mb-1" target="_blank">
                            <i class="fas fa-download"></i> Học bạ ('.($academicCount).' file)
                        </a><br>';
                    }
                }
                
                // File bổ sung
                $additionalData = $row->additional_documents_paths;
                if ($additionalData) {
                    // Handle both string JSON and actual array
                    if (is_string($additionalData)) {
                        $additionalPaths = json_decode($additionalData, true) ?: [];
                    } elseif (is_array($additionalData)) {
                        $additionalPaths = $additionalData;
                    } else {
                        $additionalPaths = [];
                    }
                    
                    if (!empty($additionalPaths)) {
                        $html .= '<a href="'.route('admin.applications.download', ['type' => 'additional', 'id' => $row->id]).'" class="btn btn-sm btn-secondary mb-1" target="_blank">
                            <i class="fas fa-download"></i> File bổ sung ('.count($additionalPaths).')
                        </a>';
                    }
                }
                
                return $html ?: '<span class="text-muted">Chưa có file</span>';
            })
            ->addColumn('documents_preview', function($row) {
                $html = '';
                
                // Học bạ chính (có thể nhiều files)
                $academicData = $row->academic_transcript_path;
                if ($academicData) {
                    // Handle both string JSON and actual array
                    if (is_string($academicData)) {
                        $academicPaths = json_decode($academicData, true) ?: [];
                    } elseif (is_array($academicData)) {
                        $academicPaths = $academicData;
                    } else {
                        $academicPaths = [];
                    }
                    
                    if (!empty($academicPaths)) {
                        $academicCount = count($academicPaths);
                        
                        $html .= '<a href="'.route('admin.applications.view', ['type' => 'academic', 'id' => $row->id]).'" class="btn btn-sm btn-success mb-1" target="_blank">
                            <i class="fas fa-eye"></i> Xem học bạ ('.($academicCount).' file)
                        </a><br>';
                    }
                }
                
                // File bổ sung
                $additionalData = $row->additional_documents_paths;
                if ($additionalData) {
                    // Handle both string JSON and actual array
                    if (is_string($additionalData)) {
                        $additionalPaths = json_decode($additionalData, true) ?: [];
                    } elseif (is_array($additionalData)) {
                        $additionalPaths = $additionalData;
                    } else {
                        $additionalPaths = [];
                    }
                    
                    if (!empty($additionalPaths)) {
                        $html .= '<a href="'.route('admin.applications.view', ['type' => 'additional', 'id' => $row->id]).'" class="btn btn-sm btn-info mb-1" target="_blank">
                            <i class="fas fa-eye"></i> Xem file bổ sung ('.count($additionalPaths).')
                        </a>';
                    }
                }
                
                return $html ?: '<span class="text-muted">Chưa có file</span>';
            })
            ->editColumn('status', function($row) {
                $badges = [
                    'pending' => '<span class="badge bg-warning text-dark">Chờ duyệt</span>',
                    'approved' => '<span class="badge bg-success">Đã duyệt</span>',
                    'rejected' => '<span class="badge bg-danger">Từ chối</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge bg-secondary">Không xác định</span>';
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->editColumn('birthdate', function($row) {
                return $row->birthdate->format('d/m/Y');
            })
            ->editColumn('documents_uploaded_at', function($row) {
                return $row->documents_uploaded_at ? $row->documents_uploaded_at->format('d/m/Y H:i') : '<span class="text-muted">Chưa upload</span>';
            })
            ->rawColumns(['action', 'status', 'documents', 'documents_preview', 'documents_uploaded_at'])
            ->make(true);
    }
    
    // Xem chi tiết đơn
    public function detail($grade, $id)
    {
        $model = $this->getModel($grade);
        $application = $model::findOrFail($id);
        
        return view('admin.applications.detail', compact('application', 'grade'));
    }
    
    // Duyệt đơn
    public function approve(Request $request, $grade, $id)
    {
        $model = $this->getModel($grade);
        $application = $model::findOrFail($id);
        
        $application->update([
            'status' => 'approved',
            'notes' => $request->input('notes', 'Đơn đã được duyệt')
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Đơn đăng ký đã được duyệt thành công!'
        ]);
    }
    
    // Từ chối đơn
    public function reject(Request $request, $grade, $id)
    {
        $model = $this->getModel($grade);
        $application = $model::findOrFail($id);
        
        $application->update([
            'status' => 'rejected',
            'notes' => $request->input('notes', 'Đơn bị từ chối')
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Đơn đăng ký đã bị từ chối!'
        ]);
    }
    
    // Helper method để lấy model theo lớp
    private function getModel($grade)
    {
        switch($grade) {
            case 1:
                return DangKyLop1::class;
            case 6:
                return DangKyLop6::class;
            case 10:
                return DangKyLop10::class;
            default:
                abort(404);
        }
    }
    
    // Download file học bạ
    public function downloadFile($type, $id)
    {
        $application = DangKyLop10::findOrFail($id);
        
        switch ($type) {
            case 'academic':
                $academicData = $application->academic_transcript_path;
                
                // Handle both string JSON and actual array
                if (is_string($academicData)) {
                    $academicPaths = json_decode($academicData, true) ?: [];
                } elseif (is_array($academicData)) {
                    $academicPaths = $academicData;
                } else {
                    abort(404, 'Học bạ không tồn tại');
                }
                
                if (empty($academicPaths)) {
                    abort(404, 'Học bạ không tồn tại');
                }
                
                if (count($academicPaths) === 1) {
                    // Single file - direct download
                    $filePath = storage_path('app/public/' . $academicPaths[0]);
                    if (!file_exists($filePath)) {
                        abort(404, 'File học bạ không tìm thấy trên server');
                    }
                    
                    return response()->download($filePath, 'hoc_ba_' . $application->fullname . '_' . $application->id . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
                } else {
                    // Multiple files - create ZIP
                    $zip = new \ZipArchive();
                    $zipFileName = 'hoc_ba_' . $application->fullname . '_' . $application->id . '.zip';
                    $zipPath = storage_path('app/temp/' . $zipFileName);
                    
                    // Tạo thư mục temp nếu chưa có
                    if (!file_exists(dirname($zipPath))) {
                        mkdir(dirname($zipPath), 0755, true);
                    }
                    
                    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                        foreach ($academicPaths as $index => $docPath) {
                            $filePath = storage_path('app/public/' . $docPath);
                            if (file_exists($filePath)) {
                                $fileName = 'hoc_ba_trang_' . ($index + 1) . '_' . basename($filePath);
                                $zip->addFile($filePath, $fileName);
                            }
                        }
                        $zip->close();
                        
                        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
                    } else {
                        abort(500, 'Không thể tạo file ZIP học bạ');
                    }
                }
                
            case 'additional':
                $additionalData = $application->additional_documents_paths;
                
                // Handle both string JSON and actual array
                if (is_string($additionalData)) {
                    $additionalPaths = json_decode($additionalData, true) ?: [];
                } elseif (is_array($additionalData)) {
                    $additionalPaths = $additionalData;
                } else {
                    abort(404, 'Không có file bổ sung');
                }
                
                if (empty($additionalPaths)) {
                    abort(404, 'Không có file bổ sung');
                }
                
                // Tạo file ZIP chứa tất cả file bổ sung
                $zip = new \ZipArchive();
                $zipFileName = 'tai_lieu_bo_sung_' . $application->fullname . '_' . $application->id . '.zip';
                $zipPath = storage_path('app/temp/' . $zipFileName);
                
                // Tạo thư mục temp nếu chưa có
                if (!file_exists(dirname($zipPath))) {
                    mkdir(dirname($zipPath), 0755, true);
                }
                
                if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                    foreach ($additionalPaths as $index => $docPath) {
                        $filePath = storage_path('app/public/' . $docPath);
                        if (file_exists($filePath)) {
                            $fileName = 'tai_lieu_' . ($index + 1) . '_' . basename($filePath);
                            $zip->addFile($filePath, $fileName);
                        }
                    }
                    $zip->close();
                    
                    return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
                } else {
                    abort(500, 'Không thể tạo file ZIP');
                }
                
            default:
                abort(404, 'Loại file không hợp lệ');
        }
    }
    
    // Xem file học bạ (trang tổng quan nhiều file)
    public function viewFile($type, $id)
    {
        $application = DangKyLop10::findOrFail($id);
        
        switch ($type) {
            case 'academic':
                $academicData = $application->academic_transcript_path;
                
                // Handle both string JSON and actual array  
                if (is_string($academicData)) {
                    $academicPaths = json_decode($academicData, true) ?: [];
                } elseif (is_array($academicData)) {
                    $academicPaths = $academicData;
                } else {
                    $academicPaths = [];
                }
                
                if (empty($academicPaths)) {
                    abort(404, 'Học bạ không tồn tại');
                }
                
                $files = [];
                foreach ($academicPaths as $index => $docPath) {
                    $filePath = storage_path('app/public/' . $docPath);
                    if (file_exists($filePath)) {
                        $files[] = [
                            'index' => $index,
                            'path' => $docPath,
                            'url' => asset('storage/' . $docPath),
                            'name' => 'Học bạ trang ' . ($index + 1),
                            'extension' => strtolower(pathinfo($filePath, PATHINFO_EXTENSION)),
                            'size' => $this->formatBytes(filesize($filePath))
                        ];
                    }
                }
                
                return view('admin.applications.view-files', [
                    'files' => $files,
                    'title' => 'Học bạ của ' . $application->fullname,
                    'application' => $application,
                    'type' => 'academic'
                ]);
                
            case 'additional':
                $additionalData = $application->additional_documents_paths;
                
                // Handle both string JSON and actual array
                if (is_string($additionalData)) {
                    $additionalPaths = json_decode($additionalData, true) ?: [];
                } elseif (is_array($additionalData)) {
                    $additionalPaths = $additionalData;
                } else {
                    $additionalPaths = [];
                }
                
                if (empty($additionalPaths)) {
                    abort(404, 'Không có file bổ sung');
                }
                
                $files = [];
                foreach ($additionalPaths as $index => $docPath) {
                    $filePath = storage_path('app/public/' . $docPath);
                    if (file_exists($filePath)) {
                        $files[] = [
                            'index' => $index,
                            'path' => $docPath,
                            'url' => asset('storage/' . $docPath),
                            'name' => 'Tài liệu bổ sung ' . ($index + 1),
                            'extension' => strtolower(pathinfo($filePath, PATHINFO_EXTENSION)),
                            'size' => $this->formatBytes(filesize($filePath))
                        ];
                    }
                }
                
                return view('admin.applications.view-files', [
                    'files' => $files,
                    'title' => 'Tài liệu bổ sung của ' . $application->fullname,
                    'application' => $application,
                    'type' => 'additional'
                ]);
                
            default:
                abort(404, 'Loại file không hợp lệ');
        }
    }
    
    // Xem single file trực tiếp (để hiển thị ảnh/PDF trong browser)
    public function viewSingleFile($type, $id, $fileIndex = 0)
    {
        $application = DangKyLop10::findOrFail($id);
        
        switch ($type) {
            case 'academic':
                $academicData = $application->academic_transcript_path;
                
                // Handle both string JSON and actual array
                if (is_string($academicData)) {
                    $academicPaths = json_decode($academicData, true) ?: [];
                } elseif (is_array($academicData)) {
                    $academicPaths = $academicData;
                } else {
                    abort(404, 'Học bạ không tồn tại');
                }
                
                if (!isset($academicPaths[$fileIndex])) {
                    abort(404, 'File không tồn tại');
                }
                
                $filePath = storage_path('app/public/' . $academicPaths[$fileIndex]);
                break;
                
            case 'additional':
                $additionalData = $application->additional_documents_paths;
                
                // Handle both string JSON and actual array  
                if (is_string($additionalData)) {
                    $additionalPaths = json_decode($additionalData, true) ?: [];
                } elseif (is_array($additionalData)) {
                    $additionalPaths = $additionalData;
                } else {
                    abort(404, 'Không có file bổ sung');
                }
                
                if (!isset($additionalPaths[$fileIndex])) {
                    abort(404, 'File không tồn tại');
                }
                
                $filePath = storage_path('app/public/' . $additionalPaths[$fileIndex]);
                break;
                
            default:
                abort(404, 'Loại file không hợp lệ');
        }
        
        if (!file_exists($filePath)) {
            abort(404, 'File không tìm thấy trên server');
        }
        
        $mimeType = mime_content_type($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
        ]);
    }
    
    // Helper function to format file sizes
    private function formatBytes($size, $precision = 2) 
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}
