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
            'current_school', 'status', 'created_at'
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
}
