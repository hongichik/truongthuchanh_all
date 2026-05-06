@extends('layouts.layout-master')

@section('title', 'Quản lý đơn xin nhập học lớp 1')
@section('page_title', 'Quản lý đơn xin nhập học lớp 1')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-child"></i> Quản lý đơn xin nhập học lớp 1</h2>
                <p class="text-muted">Danh sách và quản lý tất cả đơn đăng ký vào lớp 1</p>
            </div>
            <div>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại tổng quan
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list"></i> Danh sách đơn đăng ký lớp 1
        </h5>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportListModal">
            <i class="fas fa-file-excel"></i> Xuất danh sách Excel
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="applicationsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>SĐT</th>
                        <th>Người giám hộ</th>
                        <th>Trạng thái</th>
                        <th>Ngày nộp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal xuất danh sách Excel -->
<div class="modal fade" id="exportListModal" tabindex="-1" aria-labelledby="exportListModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exportListModalLabel">
                    <i class="fas fa-file-excel"></i> Xuất danh sách học sinh lớp 1
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Từ ngày</label>
                    <input type="date" class="form-control" id="exportDateFrom">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Đến ngày</label>
                    <input type="date" class="form-control" id="exportDateTo">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select class="form-control" id="exportStatus">
                        <option value="all">Tất cả</option>
                        <option value="pending">Chờ duyệt</option>
                        <option value="approved">Đã duyệt</option>
                        <option value="rejected">Từ chối</option>
                    </select>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Để trống ngày để xuất tất cả học sinh.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success" id="btnExportList">
                    <i class="fas fa-download"></i> Xuất Excel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiết đơn -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết đơn đăng ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Nội dung sẽ được load bằng AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Modal duyệt đơn -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel">Duyệt đơn đăng ký</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn <strong>duyệt</strong> đơn đăng ký này không?</p>
                <div class="mb-3">
                    <label class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea class="form-control" id="approveNotes" rows="3" placeholder="Nhập ghi chú khi duyệt đơn"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-success" id="confirmApprove">Duyệt đơn</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal từ chối đơn -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Từ chối đơn đăng ký</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn <strong>từ chối</strong> đơn đăng ký này không?</p>
                <div class="mb-3">
                    <label class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rejectNotes" rows="3" placeholder="Nhập lý do từ chối đơn" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmReject">Từ chối đơn</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
let currentId = null;
let currentGrade = 1;

$(document).ready(function() {
    $('#applicationsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.applications.lop1.data") }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'fullname', name: 'fullname'},
            {data: 'birthdate', name: 'birthdate'},
            {data: 'gender', name: 'gender'},
            {data: 'phone', name: 'phone'},
            {data: 'guardian_name', name: 'guardian_name'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
        }
    });
    
    // Xử lý duyệt đơn
    $('#confirmApprove').click(function() {
        if (currentId) {
            processApproveApplication(currentId, $('#approveNotes').val());
        }
    });
    
    // Xử lý từ chối đơn
    $('#confirmReject').click(function() {
        if (currentId && $('#rejectNotes').val().trim()) {
            processRejectApplication(currentId, $('#rejectNotes').val());
        } else {
            alert('Vui lòng nhập lý do từ chối!');
        }
    });
});

function viewDetail(grade, id) {
    $.get('/admin/applications/' + grade + '/' + id + '/detail')
        .done(function(data) {
            $('#detailModalBody').html(data);
            var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            detailModal.show();
        })
        .fail(function() {
            alert('Không thể tải chi tiết đơn!');
        });
}

function approveApplication(grade, id) {
    currentId = id;
    currentGrade = grade;
    $('#approveNotes').val('');
    var approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
    approveModal.show();
}

function rejectApplication(grade, id) {
    currentId = id;
    currentGrade = grade;
    $('#rejectNotes').val('');
    var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    rejectModal.show();
}

function processApproveApplication(id, notes) {
    $.ajax({
        url: '/admin/applications/' + currentGrade + '/' + id + '/approve',
        method: 'PUT',
        data: {
            notes: notes,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var approveModal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
            approveModal.hide();
            $('#applicationsTable').DataTable().ajax.reload();
            alert(response.message);
            $('#approveNotes').val('');
            currentId = null;
        },
        error: function() {
            alert('Có lỗi xảy ra khi duyệt đơn!');
        }
    });
}

function processRejectApplication(id, notes) {
    $.ajax({
        url: '/admin/applications/' + currentGrade + '/' + id + '/reject',
        method: 'PUT',
        data: {
            notes: notes,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var rejectModal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
            rejectModal.hide();
            $('#applicationsTable').DataTable().ajax.reload();
            alert(response.message);
            $('#rejectNotes').val('');
            currentId = null;
        },
        error: function() {
            alert('Có lỗi xảy ra khi từ chối đơn!');
        }
    });
}

document.getElementById('btnExportList').addEventListener('click', function() {
    var dateFrom = document.getElementById('exportDateFrom').value;
    var dateTo   = document.getElementById('exportDateTo').value;
    var status   = document.getElementById('exportStatus').value;
    var baseUrl  = '{{ route("admin.applications.lop1.export.list") }}';
    var url = new URL(baseUrl, window.location.origin);
    if (dateFrom) url.searchParams.set('date_from', dateFrom);
    if (dateTo)   url.searchParams.set('date_to', dateTo);
    if (status)   url.searchParams.set('status', status);
    window.open(url.toString(), '_blank');
    bootstrap.Modal.getInstance(document.getElementById('exportListModal')).hide();
});
</script>
@endpush