@extends('layouts.layout-master')

@section('title', 'Quản lý Menu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Danh sách Menu</h3>
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Menu Mới
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="menusTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Menu</th>
                                    <th>Slug</th>
                                    <th>URL</th>
                                    <th>Vị trí</th>
                                    <th>Thứ tự</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-menu">
                                @forelse($menus as $menu)
                                    @include('admin.menus.partials.menu-row', ['menu' => $menu, 'level' => 0])
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có menu nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .menu-level-1 { padding-left: 20px; }
    .menu-level-2 { padding-left: 40px; }
    .menu-level-3 { padding-left: 60px; }
    .sortable-placeholder {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
    .ui-sortable-helper {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    /* Badge styles */
    .badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }
    
    .badge-primary {
        color: #fff;
        background-color: #007bff;
    }
    
    .badge-secondary {
        color: #fff;
        background-color: #6c757d;
    }
    
    .badge-success {
        color: #fff;
        background-color: #28a745;
    }
    
    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }
    
    .badge-warning {
        color: #212529;
        background-color: #ffc107;
    }
    
    .badge-info {
        color: #fff;
        background-color: #17a2b8;
    }
    
    .badge-light {
        color: #212529;
        background-color: #f8f9fa;
    }
    
    .badge-dark {
        color: #fff;
        background-color: #343a40;
    }
    
    .badge-lg {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    // Khởi tạo DataTable
    $('#menusTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        },
        "pageLength": 50,
        "ordering": false
    });

    // Khởi tạo drag & drop
    $("#sortable-menu").sortable({
        placeholder: "sortable-placeholder",
        helper: "clone",
        update: function(event, ui) {
            let items = [];
            $(this).find('tr').each(function(index) {
                let id = $(this).data('id');
                if (id) {
                    items.push({
                        id: id,
                        sort_order: index,
                        parent_id: $(this).data('parent-id') || null
                    });
                }
            });

            // Gửi AJAX để cập nhật thứ tự
            $.ajax({
                url: '{{ route("admin.menus.update-order") }}',
                method: 'POST',
                data: {
                    items: items,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi cập nhật thứ tự menu');
                }
            });
        }
    });

    // Xử lý xóa menu
    $(document).on('click', '.delete-menu', function(e) {
        e.preventDefault();
        
        if (confirm('Bạn có chắc chắn muốn xóa menu này?')) {
            $(this).closest('form').submit();
        }
    });

    // Xử lý thay đổi trạng thái
    $(document).on('click', '.toggle-status', function(e) {
        e.preventDefault();
        
        let url = $(this).attr('href');
        let currentStatus = $(this).find('i').hasClass('fa-check-circle');
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                toastr.error('Có lỗi xảy ra khi thay đổi trạng thái menu');
            }
        });
    });
});
</script>
@endpush