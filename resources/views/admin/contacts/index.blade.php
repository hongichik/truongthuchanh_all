@extends('layouts.layout-master')

@section('title', 'Quản lý Liên hệ')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Liên hệ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quản lý Liên hệ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="total-contacts">{{ $stats['total'] ?? 0 }}</h3>
                        <p>Tổng liên hệ</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-email"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="pending-contacts">{{ $stats['pending'] ?? 0 }}</h3>
                        <p>Chờ xử lý</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="replied-contacts">{{ $stats['replied'] ?? 0 }}</h3>
                        <p>Đã phản hồi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3 id="resolved-contacts">{{ $stats['resolved'] ?? 0 }}</h3>
                        <p>Đã giải quyết</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-archive"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách liên hệ</h3>
                        <div class="card-tools">
                            <form method="GET" action="{{ route('admin.contacts.index') }}" class="form-inline">
                                <div class="input-group input-group-sm mr-2">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Tìm kiếm..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Đã giải quyết</option>
                                </select>
                                
                                <select name="sort" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Tiêu đề</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày gửi</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if($contact->status === 'pending')
                                            <span class="badge badge-warning badge-xs ml-1">Mới</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </td>
                                    <td>
                                        @if($contact->phone)
                                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span title="{{ $contact->subject }}">
                                            {{ Str::limit($contact->subject, 30) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $contact->status_color }}">
                                            {{ $contact->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $contact->created_at->format('d/m/Y H:i') }}
                                            <br>
                                            <span class="text-muted">{{ $contact->created_at->diffForHumans() }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($contact->status !== 'resolved')
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($contact->status === 'pending')
                                                        <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="replied">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-reply mr-2"></i>Đánh dấu đã phản hồi
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if(in_array($contact->status, ['pending', 'replied']))
                                                        <form method="POST" action="{{ route('admin.contacts.update-status', $contact) }}" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="resolved">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check mr-2"></i>Đánh dấu đã giải quyết
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Chưa có liên hệ nào</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contacts->hasPages())
                    <div class="card-footer clearfix">
                        <div class="float-right">
                            {{ $contacts->appends(request()->query())->links() }}
                        </div>
                        <div class="float-left">
                            <small class="text-muted">
                                Hiển thị {{ $contacts->firstItem() }}-{{ $contacts->lastItem() }} 
                                trên tổng số {{ $contacts->total() }} kết quả
                            </small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.badge-xs {
    font-size: 0.6em;
}

.small-box {
    border-radius: 10px;
}

.small-box .icon {
    top: -10px;
    right: 10px;
}

.table td {
    vertical-align: middle;
}

.btn-group .dropdown-menu {
    min-width: auto;
}

.dropdown-item {
    font-size: 0.875rem;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}
</style>
@endpush

@push('scripts')
<script>
// Auto refresh statistics every 30 seconds
setInterval(function() {
    $.get('{{ route("admin.contacts.stats") }}')
        .done(function(data) {
            $('#total-contacts').text(data.total || 0);
            $('#pending-contacts').text(data.pending || 0);
            $('#replied-contacts').text(data.replied || 0);
            $('#resolved-contacts').text(data.resolved || 0);
        });
}, 30000);

// Clear search
function clearSearch() {
    window.location.href = '{{ route("admin.contacts.index") }}';
}
</script>
@endpush