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
            'guardian_name', 'status', 'created_at',
            'registration_form_path'
        ])->orderBy('created_at', 'desc');
        
        return DataTables::of($applications)
            ->addColumn('action', function($row) {
                $exportUrl = route('admin.applications.lop1.export.excel', ['id' => $row->id]);
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(1, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <a href="'.$exportUrl.'" class="btn btn-sm btn-warning" target="_blank">
                            <i class="fas fa-file-export"></i> Xuất mẫu
                        </a>
                        <button type="button" class="btn btn-sm btn-success" onclick="approveApplication(1, '.$row->id.')">
                            <i class="fas fa-check"></i> Duyệt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectApplication(1, '.$row->id.')">
                            <i class="fas fa-times"></i> Từ chối
                        </button>
                    </div>
                ';
            })
            ->addColumn('documents', function($row) {
                if (empty($row->registration_form_path)) {
                    return '<span class="text-muted">Chưa có file</span>';
                }

                $downloadUrl = route('admin.applications.download', [
                    'type' => 'registration',
                    'id' => $row->id,
                    'grade' => 1,
                ]);

                return '<a href="'.$downloadUrl.'" class="btn btn-sm btn-primary" target="_blank">\
                    <i class="fas fa-download"></i> Tải đơn\
                </a>';
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
            ->rawColumns(['action', 'documents', 'status'])
            ->make(true);
    }

    // Xuất danh sách học sinh đăng ký lớp 1 theo khoảng thời gian
    public function lop1ExportList(Request $request)
    {
        return $this->exportList($request, 'lop1', DangKyLop1::class, 1);
    }

    // Xuất 1 hồ sơ lớp 1 ra file Excel theo mẫu phiếu đăng ký
    public function lop1ExportExcel($id)
    {
        $app = DangKyLop1::findOrFail($id);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Phieu xet tuyen');

        $sheet->getPageSetup()
            ->SetOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true);
        $sheet->getPageMargins()->setTop(1)->setRight(0.75)->setBottom(1)->setLeft(0.75);

        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(13);
        $sheet->getDefaultRowDimension()->setRowHeight(20);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(35);

        $r = 1;

        $sheet->setCellValue("A{$r}", 'Mẫu Phiếu đăng kí xét tuyển vào lớp 1');
        $sheet->getStyle("A{$r}")->getFont()->setItalic(true);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Độc lập - Tự do - Hạnh phúc');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '___________________________');
        $sheet->getRowDimension($r)->setRowHeight(2);
        $sheet->getStyle("A{$r}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $r += 2;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'PHIẾU ĐĂNG KÍ XÉT TUYỂN VÀO LỚP 1 NĂM HỌC 2026 - 2027');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r += 2;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Kính gửi: Hội đồng tuyển sinh Trường TH, THCS và THPT Thực hành Sư phạm');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $fullname = mb_strtoupper((string) ($app->fullname ?? ''), 'UTF-8');
        $birthdate = optional($app->birthdate)->format('d/m/Y') ?? '';
        $isDisabledText = !empty($app->is_disabled) ? $app->is_disabled : 'Không';

        $addFullRow = function(string $text) use ($sheet, &$r) {
            $sheet->mergeCells("A{$r}:B{$r}");
            $sheet->setCellValue("A{$r}", $text);
            $sheet->getStyle("A{$r}")->getAlignment()->setWrapText(true);
            $r++;
        };

        $addFullRow("1) Họ và tên học sinh (VIẾT CHỮ IN HOA): {$fullname}");
        $sheet->setCellValue("A{$r}", '- Giới tính (Nam/Nữ): ' . ($app->gender ?? ''));
        $sheet->setCellValue("B{$r}", '2) Dân tộc: ' . ($app->ethnicity ?? ''));
        $r++;
        $addFullRow('– Ngày tháng năm sinh: ' . $birthdate);
        $addFullRow('– Nơi sinh (Tỉnh/Thành phố): ' . ($app->birthplace ?? ''));
        $addFullRow('– Nơi thường trú: ' . ($app->address ?? ''));
        $addFullRow('– Số định danh cá nhân: ' . ($app->citizen_id ?? ''));
        $addFullRow('– Số điện thoại liên hệ: ' . ($app->phone ?? ''));
        $addFullRow('– Học sinh khuyết tật (Ghi rõ dạng tật): ' . $isDisabledText);

        $sheet->setCellValue("A{$r}", '3) Họ tên cha: ' . ($app->father_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->father_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->father_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->father_occupation ?? ''));
        $r++;

        $sheet->setCellValue("A{$r}", '4) Họ tên mẹ: ' . ($app->mother_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->mother_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->mother_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->mother_occupation ?? ''));
        $r++;

        $sheet->setCellValue("A{$r}", '5) Họ tên người giám hộ: ' . ($app->guardian_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->guardian_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Nghề nghiệp: ' . ($app->guardian_occupation ?? ''));
        $r++;
        $camket = 'Cha mẹ/người giám hộ học sinh cam kết những thông tin kê khai trong phiếu này là đúng sự thật; nếu không đúng cha mẹ/ người giám hộ học sinh hoàn toàn chịu trách nhiệm về kết quả của học sinh.Cam kết cho con tham gia  học tập đầy đủ các nội dung theo chương trình Giáo dục phổ thông  hiện hành và các chương trình giáo dục thực nghiệm sư phạm theo kế hoạch giáo dục của nhà trường.';
        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '        ' . $camket);
        $sheet->getStyle("A{$r}")->applyFromArray([
            'alignment' => ['wrapText' => true, 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY],
        ]);
        $sheet->getRowDimension($r)->setRowHeight(90);
        $r++;

        $sheet->setCellValue("A{$r}", 'CHA MẸ/ NGƯỜI GIÁM HỘ HỌC SINH');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue("B{$r}", '......., ngày ..... tháng .......... năm 2026');
        $sheet->getStyle("B{$r}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filename = 'phieu_xet_tuyen_lop_1_' . $app->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
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
            'current_school', 'status', 'created_at',
            'academic_transcript_path', 'additional_documents_paths',
            'documents_uploaded_at'
        ])->orderBy('created_at', 'desc');
        
        return DataTables::of($applications)
            ->addColumn('action', function($row) {
                $exportUrl = route('admin.applications.lop6.export.excel', ['id' => $row->id]);
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(6, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <a href="'.$exportUrl.'" class="btn btn-sm btn-warning" target="_blank">
                            <i class="fas fa-file-export"></i> Xuất mẫu
                        </a>
                        <button type="button" class="btn btn-sm btn-success" onclick="approveApplication(6, '.$row->id.')">
                            <i class="fas fa-check"></i> Duyệt
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="rejectApplication(6, '.$row->id.')">
                            <i class="fas fa-times"></i> Từ chối
                        </button>
                    </div>
                ';
            })
            ->addColumn('documents', function($row) {
                $html = '';

                $academicData = $row->academic_transcript_path;
                if ($academicData) {
                    if (is_string($academicData)) {
                        $academicPaths = json_decode($academicData, true) ?: [];
                    } elseif (is_array($academicData)) {
                        $academicPaths = $academicData;
                    } else {
                        $academicPaths = [];
                    }

                    if (!empty($academicPaths)) {
                        $html .= '<a href="'.route('admin.applications.download', ['type' => 'academic', 'id' => $row->id, 'grade' => 6]).'" class="btn btn-sm btn-primary mb-1" target="_blank">
                            <i class="fas fa-download"></i> Học bạ ('.count($academicPaths).' file)
                        </a><br>';
                    }
                }

                $additionalData = $row->additional_documents_paths;
                if ($additionalData) {
                    if (is_string($additionalData)) {
                        $additionalPaths = json_decode($additionalData, true) ?: [];
                    } elseif (is_array($additionalData)) {
                        $additionalPaths = $additionalData;
                    } else {
                        $additionalPaths = [];
                    }

                    if (!empty($additionalPaths)) {
                        $html .= '<a href="'.route('admin.applications.download', ['type' => 'additional', 'id' => $row->id, 'grade' => 6]).'" class="btn btn-sm btn-secondary mb-1" target="_blank">
                            <i class="fas fa-download"></i> File bổ sung ('.count($additionalPaths).')
                        </a>';
                    }
                }

                return $html ?: '<span class="text-muted">Chưa có file</span>';
            })
            ->addColumn('documents_preview', function($row) {
                $html = '';

                $academicData = $row->academic_transcript_path;
                if ($academicData) {
                    if (is_string($academicData)) {
                        $academicPaths = json_decode($academicData, true) ?: [];
                    } elseif (is_array($academicData)) {
                        $academicPaths = $academicData;
                    } else {
                        $academicPaths = [];
                    }

                    if (!empty($academicPaths)) {
                        $html .= '<a href="'.route('admin.applications.view', ['type' => 'academic', 'id' => $row->id, 'grade' => 6]).'" class="btn btn-sm btn-success mb-1" target="_blank">
                            <i class="fas fa-eye"></i> Xem học bạ ('.count($academicPaths).' file)
                        </a><br>';
                    }
                }

                $additionalData = $row->additional_documents_paths;
                if ($additionalData) {
                    if (is_string($additionalData)) {
                        $additionalPaths = json_decode($additionalData, true) ?: [];
                    } elseif (is_array($additionalData)) {
                        $additionalPaths = $additionalData;
                    } else {
                        $additionalPaths = [];
                    }

                    if (!empty($additionalPaths)) {
                        $html .= '<a href="'.route('admin.applications.view', ['type' => 'additional', 'id' => $row->id, 'grade' => 6]).'" class="btn btn-sm btn-info mb-1" target="_blank">
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
                $exportUrl = route('admin.applications.lop10.export.excel', ['id' => $row->id]);
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(10, '.$row->id.')">
                            <i class="fas fa-eye"></i> Xem
                        </button>
                        <a href="'.$exportUrl.'" class="btn btn-sm btn-warning" target="_blank">
                            <i class="fas fa-file-export"></i> Xuất mẫu
                        </a>
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

    // Xuất danh sách học sinh đăng ký lớp 6 theo khoảng thời gian
    public function lop6ExportList(Request $request)
    {
        return $this->exportList($request, 'lop6', DangKyLop6::class, 6);
    }

    // Xuất 1 hồ sơ lớp 6 ra file Excel theo mẫu phiếu đăng ký
    public function lop6ExportExcel($id)
    {
        $app = DangKyLop6::findOrFail($id);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Phieu xet tuyen');

        $sheet->getPageSetup()
            ->SetOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true);
        $sheet->getPageMargins()->setTop(1)->setRight(0.75)->setBottom(1)->setLeft(0.75);

        $spreadsheet->getDefaultStyle()->getFont()
            ->setName('Times New Roman')->setSize(13);
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(35);

        $sheet->getRowDimension(1)->setRowHeight(20);
        for ($row = 8; $row <= 25; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        $r = 1;

        $sheet->setCellValue("A{$r}", 'Mẫu Phiếu đăng kí xét tuyển vào lớp 6');
        $sheet->getStyle("A{$r}")->getFont()->setItalic(true);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Độc lập - Tự do - Hạnh phúc');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '___________________________');
        $sheet->getRowDimension($r)->setRowHeight(2);
        $sheet->getStyle("A{$r}")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $r++;

        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'PHIẾU ĐĂNG KÍ XÉT TUYỂN VÀO LỚP 6 NĂM HỌC 2026 - 2027');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Kính gửi: Hội đồng tuyển sinh Trường TH, THCS và THPT Thực hành Sư phạm');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $fullname = mb_strtoupper((string) ($app->fullname ?? ''), 'UTF-8');
        $birthdate = optional($app->birthdate)->format('d/m/Y') ?? '';

        $addFullRow = function (string $text) use ($sheet, &$r) {
            $sheet->mergeCells("A{$r}:B{$r}");
            $sheet->setCellValue("A{$r}", $text);
            $sheet->getStyle("A{$r}")->getAlignment()->setWrapText(true);
            $r++;
        };

        $addFullRow("1) Họ và tên học sinh (VIẾT CHỮ IN HOA): {$fullname}");

        $sheet->setCellValue("A{$r}", '- Giới tính (Nam/Nữ): ' . ($app->gender ?? ''));
        $sheet->setCellValue("B{$r}", '3) Dân tộc: ' . ($app->ethnicity ?? ''));
        $r++;

        $addFullRow("– Ngày tháng năm sinh: {$birthdate}");
        $addFullRow("– Nơi sinh (Tỉnh/Thành phố): " );
        $addFullRow("     " . ($app->birthplace ?? ''));
        $isDisabledText = !empty($app->is_disabled) ? $app->is_disabled : 'Không';
        $addFullRow("– Học sinh khuyết tật (Ghi rõ dạng tật): {$isDisabledText}");
        $addFullRow("– Nơi thường trú (Tổ, Khu, Phường/Xã, Tỉnh): " );
        $addFullRow("     " . ($app->address ?? ''));
        $addFullRow("– Số định danh cá nhân của học sinh (Gồm 12 số do cơ quan Công an cấp): " . ($app->citizen_id ?? ''));
        $addFullRow("2) Được phân tuyến tuyển sinh vào: " . ($app->current_school ?? ''));

        $sheet->setCellValue("A{$r}", '3) Họ tên cha: ' . ($app->father_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->father_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->father_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->father_occupation ?? ''));
        $r++;

        $sheet->setCellValue("A{$r}", '4) Họ tên mẹ: ' . ($app->mother_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->mother_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->mother_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->mother_occupation ?? ''));
        $r++;

        $sheet->setCellValue("A{$r}", '5) Họ tên người giám hộ: ' . ($app->guardian_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->guardian_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Nghề nghiệp: ' . ($app->guardian_occupation ?? ''));
        $r++;

        $sheet->setCellValue("A{$r}", '6) Số điện thoại liên hệ: ' . ($app->phone ?? ''));
        $sheet->setCellValue("B{$r}", 'Email (nếu có): ');
        $r++;
        $camket = 'Cha mẹ/người giám hộ học sinh cam kết những thông tin kê khai trong phiếu này là đúng sự thật; nếu không đúng cha mẹ/người giám hộ học sinh hoàn toàn chịu trách nhiệm về kết quả của học sinh.';
        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '        ' . $camket);
        $sheet->getStyle("A{$r}")->applyFromArray([
            'alignment' => ['wrapText' => true, 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY],
        ]);
        $sheet->getRowDimension($r)->setRowHeight(80);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '        Trân trọng cảm ơn!');
        $r++;

        $r++;

        $sheet->setCellValue("A{$r}", 'CHA MẸ/ NGƯỜI GIÁM HỘ HỌC SINH');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue("B{$r}", '......., ngày ..... tháng .......... năm 2026');
        $sheet->getStyle("B{$r}")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $r++;

        $sheet->setCellValue("A{$r}", '(Ký và ghi rõ họ tên)');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue("B{$r}", 'NGƯỜI NHẬN HỒ SƠ');
        $sheet->getStyle("B{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->setCellValue("B{$r}", '(ký và ghi rõ họ tên)');
        $sheet->getStyle("B{$r}")->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $filename = 'phieu_xet_tuyen_lop_6_' . $app->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    // Xuất danh sách học sinh đăng ký lớp 10 theo khoảng thời gian
    public function lop10ExportList(Request $request)
    {
        return $this->exportList($request, 'lop10', DangKyLop10::class, 10);
    }

    // Xuất 1 hồ sơ lớp 10 ra file Excel theo mẫu phiếu đăng ký
    public function lop10ExportExcel($id)
    {
        $app = DangKyLop10::findOrFail($id);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Phieu xet tuyen');

        // Page setup A4, portrait
        $sheet->getPageSetup()
            ->SetOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true);
        $sheet->getPageMargins()->setTop(1)->setRight(0.75)->setBottom(1)->setLeft(0.75);

        // Default font cho toàn sheet
        $spreadsheet->getDefaultStyle()->getFont()
            ->setName('Times New Roman')->setSize(13);
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        // Cố định độ rộng 2 cột chính (A rộng 65%, B rộng 35%)
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(35);

        $sheet->getRowDimension(1)->setRowHeight(20);
        for ($row = 8; $row <= 25; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }
        $r = 1; // row counter
        $sheet->getRowDimension(14)->setRowHeight(40);
        // --- Dòng mẫu ---
        $sheet->setCellValue("A{$r}", 'Mẫu Phiếu đăng kí xét tuyển vào lớp 10');
        $sheet->getStyle("A{$r}")->getFont()->setItalic(true);
        $r++;

        // --- Quốc hiệu ---
        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Độc lập - Tự do - Hạnh phúc');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '___________________________');
        $sheet->getRowDimension($r)->setRowHeight(2);
        $sheet->getStyle("A{$r}")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $r++;

        // khoảng cách
        $r++;

        // --- Tiêu đề ---
        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'PHIẾU ĐĂNG KÍ XÉT TUYỂN VÀO LỚP 10 NĂM HỌC 2026 - 2027');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", 'Kính gửi: Hội đồng tuyển sinh Trường TH, THCS và THPT Thực hành Sư phạm');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        // --- Thông tin ---
        $fullname = mb_strtoupper((string) ($app->fullname ?? ''), 'UTF-8');
        $birthdate = optional($app->birthdate)->format('d/m/Y') ?? '';

        // Helper: dòng trải dài cả 2 cột
        $addFullRow = function(string $text) use ($sheet, &$r) {
            $sheet->mergeCells("A{$r}:B{$r}");
            $sheet->setCellValue("A{$r}", $text);
            $sheet->getStyle("A{$r}")->getAlignment()->setWrapText(true);
            $r++;
        };

        $addFullRow("1) Họ và tên học sinh (VIẾT CHỮ IN HOA): {$fullname}");

        // Giới tính | Dân tộc — 2 cột tách biệt
        $sheet->setCellValue("A{$r}", '- Giới tính (Nam/Nữ): ' . ($app->gender ?? ''));
        $sheet->setCellValue("B{$r}", '3) Dân tộc: ' . ($app->ethnicity ?? ''));
        $r++;

        $addFullRow("– Ngày tháng năm sinh: {$birthdate}");
        $addFullRow("– Nơi sinh (Tỉnh/Thành phố): ");
        $addFullRow("    ".($app->birthplace ?? ''));
        $addFullRow("– Đối tượng chính sách (Hộ nghèo/GĐ liệt sĩ/ GĐ có công với cách mạng/ GĐ có người là lão thành cách mạng/ GĐ tham gia kháng chiến.):");
        $is_disabled_text = $app->is_disabled ? $app->is_disabled : 'Không';
        $addFullRow("– Học sinh khuyết tật (Ghi rõ dạng tật): {$is_disabled_text}");
        $addFullRow("– Nơi thường trú (Tổ, Khu, Phường/Xã, Tỉnh): ");
        $addFullRow("    ".($app->address ?? ''));
        $addFullRow("– Nơi ở hiện tại (Số nhà, Tổ, Khu, Phường/Xã, Tỉnh): " );
        $addFullRow("    ".($app->address ?? ''));
        $addFullRow("– Số định danh cá nhân của học sinh (Gồm 12 số do cơ quan Công an cấp): " . ($app->citizen_id ?? ''));
        $addFullRow("2) Được phân tuyển tuyển sinh vào: " . ($app->current_school ?? ''));

        // Cha
        $sheet->setCellValue("A{$r}", '3) Họ tên cha: ' . ($app->father_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->father_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->father_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->father_occupation ?? ''));
        $r++;

        // Mẹ
        $sheet->setCellValue("A{$r}", '4) Họ tên mẹ: ' . ($app->mother_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->mother_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Dân tộc: ' . ($app->mother_ethnicity ?? 'Kinh'));
        $sheet->setCellValue("B{$r}", 'Nghề nghiệp: ' . ($app->mother_occupation ?? ''));
        $r++;

        // Người giám hộ
        $sheet->setCellValue("A{$r}", '5) Họ tên người giám hộ: ' . ($app->guardian_name ?? ''));
        $sheet->setCellValue("B{$r}", 'Năm sinh: ' . ($app->guardian_birthyear ?? ''));
        $r++;
        $sheet->setCellValue("A{$r}", '- Nghề nghiệp: ' . ($app->guardian_occupation ?? ''));
        $r++;

        // SĐT liên hệ
        $sheet->setCellValue("A{$r}", '6) Số điện thoại liên hệ: ' . ($app->phone ?? ''));
        $sheet->setCellValue("B{$r}", 'Email (nếu có): ');
        $r++;
        // --- Cam kết ---
        $camket = 'Cha mẹ/người giám hộ học sinh cam kết những thông tin kê khai trong phiếu này là đúng sự thật; nếu không đúng cha mẹ/ người giám hộ học sinh hoàn toàn chịu trách nhiệm về kết quả của học sinh. Gia đình cam kết cho con tham gia học tập đầy đủ các nội dung theo chương trình Giáo dục phổ thông hiện hành và các chương trình giáo dục thực nghiệm sư phạm theo kế hoạch giáo dục của nhà trường.';
        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '        ' . $camket);
        $sheet->getStyle("A{$r}")->applyFromArray([
            'alignment' => ['wrapText' => true, 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY],
        ]);
        $sheet->getRowDimension($r)->setRowHeight(90);
        $r++;

        $sheet->mergeCells("A{$r}:B{$r}");
        $sheet->setCellValue("A{$r}", '        Trân trọng cảm ơn!');
        $r++;

        $r++;

        // --- Ký tên ---
        $sheet->setCellValue("A{$r}", 'CHA MẸ/ NGƯỜI GIÁM HỘ  HỌC SINH');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue("B{$r}", '......., ngày ..... tháng .......... năm 2026');
        $sheet->getStyle("B{$r}")->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $r++;

        $sheet->setCellValue("A{$r}", '(Ký và ghi rõ họ tên)');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->setCellValue("B{$r}", 'NGƯỜI NHẬN HỒ SƠ');
        $sheet->getStyle("B{$r}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $sheet->setCellValue("B{$r}", '(ký và ghi rõ họ tên)');
        $sheet->getStyle("B{$r}")->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;


        // Xuất file
        $filename = 'phieu_xet_tuyen_lop_10_' . $app->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
    
    // Hàm dùng chung: xuất danh sách học sinh đăng ký theo khoảng thời gian
    private function exportList(Request $request, string $grade, string $modelClass, int $gradeNum)
    {
        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');
        $status   = $request->query('status', 'all');

        $query = $modelClass::query()->orderBy('created_at', 'asc');

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $list = $query->get();

        // Build spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Danh sach lop {$gradeNum}");

        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(0.5)->setRight(0.5)->setBottom(0.5)->setLeft(0.5);

        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);

        // ---- Cấu hình cột theo khối lớp ----
        if ($gradeNum == 1) {
            $headers = ['STT', 'Họ và tên', 'Ngày sinh', 'Giới tính', 'Dân tộc', 'CCCD', 'Địa chỉ', 'Điện thoại', 'Họ tên cha', 'Họ tên mẹ', 'Trạng thái', 'Ngày nộp'];
            $cols = ['A','B','C','D','E','F','G','H','I','J','K','L'];
            $widths = [5, 25, 12, 10, 10, 14, 30, 13, 22, 22, 12, 14];
        } elseif ($gradeNum == 6) {
            $headers = ['STT', 'Họ và tên', 'Ngày sinh', 'Giới tính', 'Dân tộc', 'Trường tiểu học', 'CCCD', 'Địa chỉ', 'Điện thoại', 'Học lực L5', 'Hạnh kiểm L5', 'Trạng thái', 'Ngày nộp'];
            $cols = ['A','B','C','D','E','F','G','H','I','J','K','L','M'];
            $widths = [5, 25, 12, 10, 10, 22, 14, 28, 13, 12, 12, 12, 14];
        } else {
            $headers = ['STT', 'Họ và tên', 'Ngày sinh', 'Giới tính', 'Dân tộc', 'Trường THCS', 'CCCD', 'Địa chỉ', 'Điện thoại', 'Học lực L9', 'Hạnh kiểm L9', 'Trạng thái', 'Ngày nộp'];
            $cols = ['A','B','C','D','E','F','G','H','I','J','K','L','M'];
            $widths = [5, 25, 12, 10, 10, 22, 14, 28, 13, 12, 12, 12, 14];
        }
        $lastCol = end($cols);

        // ---- Thiết lập độ rộng cột ----
        foreach ($cols as $i => $col) {
            $sheet->getColumnDimension($col)->setWidth($widths[$i]);
        }

        // ---- Tiêu đề ----
        $r = 1;
        $sheet->mergeCells("A{$r}:{$lastCol}{$r}");
        $sheet->setCellValue("A{$r}", 'DANH SÁCH HỌC SINH ĐĂNG KÝ VÀO LỚP ' . $gradeNum . ' NĂM HỌC 2026 - 2027');
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 13],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;

        $rangeText = '';
        if ($dateFrom && $dateTo) {
            $rangeText = 'Từ ngày ' . \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') . ' đến ' . \Carbon\Carbon::parse($dateTo)->format('d/m/Y');
        } elseif ($dateFrom) {
            $rangeText = 'Từ ngày ' . \Carbon\Carbon::parse($dateFrom)->format('d/m/Y');
        } elseif ($dateTo) {
            $rangeText = 'Đến ngày ' . \Carbon\Carbon::parse($dateTo)->format('d/m/Y');
        } else {
            $rangeText = 'Tất cả';
        }
        $statusText = match($status) {
            'pending'  => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'rejected' => 'Từ chối',
            default    => 'Tất cả trạng thái',
        };

        $sheet->mergeCells("A{$r}:{$lastCol}{$r}");
        $sheet->setCellValue("A{$r}", "Thời gian: {$rangeText} | Trạng thái: {$statusText} | Tổng: {$list->count()} học sinh");
        $sheet->getStyle("A{$r}")->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        $r++;
        $r++;

        // ---- Header bảng ----

        foreach ($cols as $i => $col) {
            $sheet->setCellValue("{$col}{$r}", $headers[$i]);
        }

        $headerRange = "A{$r}:{$lastCol}{$r}";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension($r)->setRowHeight(30);
        $r++;

        // ---- Data rows ----
        $statusMap = ['pending' => 'Chờ duyệt', 'approved' => 'Đã duyệt', 'rejected' => 'Từ chối'];
        foreach ($list as $i => $app) {
            $rowData = [];
            if ($gradeNum == 1) {
                $rowData = [
                    $i + 1,
                    $app->fullname ?? '',
                    optional($app->birthdate)->format('d/m/Y') ?? '',
                    $app->gender ?? '',
                    $app->ethnicity ?? '',
                    $app->citizen_id ?? '',
                    $app->address ?? '',
                    $app->phone ?? '',
                    $app->father_name ?? '',
                    $app->mother_name ?? '',
                    $statusMap[$app->status] ?? $app->status,
                    optional($app->created_at)->format('d/m/Y') ?? '',
                ];
            } elseif ($gradeNum == 6) {
                $rowData = [
                    $i + 1,
                    $app->fullname ?? '',
                    optional($app->birthdate)->format('d/m/Y') ?? '',
                    $app->gender ?? '',
                    $app->ethnicity ?? '',
                    $app->current_school ?? '',
                    $app->citizen_id ?? '',
                    $app->address ?? '',
                    $app->phone ?? '',
                    $app->grade5_academic ?? '',
                    $app->grade5_conduct ?? '',
                    $statusMap[$app->status] ?? $app->status,
                    optional($app->created_at)->format('d/m/Y') ?? '',
                ];
            } else {
                $rowData = [
                    $i + 1,
                    $app->fullname ?? '',
                    optional($app->birthdate)->format('d/m/Y') ?? '',
                    $app->gender ?? '',
                    $app->ethnicity ?? '',
                    $app->current_school ?? '',
                    $app->citizen_id ?? '',
                    $app->address ?? '',
                    $app->phone ?? '',
                    $app->grade9_academic ?? '',
                    $app->grade9_conduct ?? '',
                    $statusMap[$app->status] ?? $app->status,
                    optional($app->created_at)->format('d/m/Y') ?? '',
                ];
            }

            foreach ($cols as $j => $col) {
                $sheet->setCellValue("{$col}{$r}", $rowData[$j]);
            }

            $rowRange = "A{$r}:{$lastCol}{$r}";
            $fillColor = ($i % 2 === 0) ? 'FFFFFF' : 'F2F2F2';
            $sheet->getStyle($rowRange)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            ]);
            $sheet->getStyle("A{$r}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($r)->setRowHeight(20);
            $r++;
        }

        // ---- Merge tiêu đề theo số cột thực tế ----
        // ---- Save & download ----
        $filename = "danh_sach_lop_{$gradeNum}_" . now()->format('Ymd_His') . '.xlsx';
        $tempPath = storage_path('app/temp/' . $filename);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
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
    public function downloadFile(Request $request, $type, $id)
    {
        $grade = (int) $request->query('grade', 10);
        $model = match ($grade) {
            1 => DangKyLop1::class,
            6 => DangKyLop6::class,
            default => DangKyLop10::class,
        };
        $application = $model::findOrFail($id);
        
        switch ($type) {
            case 'registration':
                if ($grade !== 1) {
                    abort(404, 'Loại file không hợp lệ');
                }

                $registrationPath = $application->registration_form_path;
                if (empty($registrationPath)) {
                    abort(404, 'Không có file đơn đăng ký');
                }

                $filePath = storage_path('app/public/' . $registrationPath);
                if (!file_exists($filePath)) {
                    abort(404, 'File đơn đăng ký không tìm thấy trên server');
                }

                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $downloadName = 'don_dang_ky_lop_1_' . $application->id . '.' . $extension;

                return response()->download($filePath, $downloadName);

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
    public function viewFile(Request $request, $type, $id)
    {
        $grade = (int) $request->query('grade', 10);
        $model = $grade === 6 ? DangKyLop6::class : DangKyLop10::class;
        $application = $model::findOrFail($id);
        
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
                    'type' => 'academic',
                    'grade' => $grade
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
                    'type' => 'additional',
                    'grade' => $grade
                ]);
                
            default:
                abort(404, 'Loại file không hợp lệ');
        }
    }
    
    // Xem single file trực tiếp (để hiển thị ảnh/PDF trong browser)
    public function viewSingleFile(Request $request, $type, $id, $fileIndex = 0)
    {
        $grade = (int) $request->query('grade', 10);
        $model = $grade === 6 ? DangKyLop6::class : DangKyLop10::class;
        $application = $model::findOrFail($id);
        
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
        if ($size <= 0) {
            return '0 B';
        }

        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
        $index = (int) floor($base);

        return round(pow(1024, $base - $index), $precision) . ' ' . $suffixes[$index];
    }
}
