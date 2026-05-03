@extends('layouts.layout-master')

@section('title', 'Chi tiết Liên hệ #' . $contact->id)

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chi tiết Liên hệ #{{ $contact->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Quản lý Liên hệ</a></li>
                    <li class="breadcrumb-item active">Chi tiết #{{ $contact->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope mr-2"></i>
                            {{ $contact->subject }}
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $contact->status_color }} badge-lg">
                                {{ $contact->status_label }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Contact Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Người gửi:</strong><br>
                                <span class="h5">{{ $contact->name }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Ngày gửi:</strong><br>
                                {{ $contact->created_at->format('d/m/Y H:i:s') }}
                                <small class="text-muted">({{ $contact->created_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </div>
                            <div class="col-md-6">
                                <strong>Điện thoại:</strong><br>
                                @if($contact->phone)
                                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Message Content -->
                        <div class="mb-4">
                            <strong>Nội dung:</strong>
                            <div class="mt-2 p-3 bg-light rounded">
                                {!! nl2br(e($contact->message)) !!}
                            </div>
                        </div>

                        <!-- Admin Reply -->
                        @if($contact->admin_reply)
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-reply"></i> Phản hồi của Admin</h5>
                                <div class="mt-2">
                                    {!! nl2br(e($contact->admin_reply)) !!}
                                </div>
                                @if($contact->replied_at && $contact->repliedBy)
                                    <hr>
                                    <small class="text-muted">
                                        <strong>Phản hồi bởi:</strong> {{ $contact->repliedBy->name }} 
                                        vào {{ $contact->replied_at->format('d/m/Y H:i:s') }}
                                    </small>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reply Form -->
                @if(!$contact->admin_reply || $contact->status !== 'resolved')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-reply mr-2"></i>
                            {{ $contact->admin_reply ? 'Cập nhật phản hồi' : 'Phản hồi liên hệ' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
                            @csrf
                            <div class="form-group">
                                <label for="admin_reply">Nội dung phản hồi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('admin_reply') is-invalid @enderror" 
                                          id="admin_reply" 
                                          name="admin_reply" 
                                          rows="8" 
                                          placeholder="Nhập nội dung phản hồi..."
                                          required>{{ old('admin_reply', $contact->admin_reply) }}</textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái sau khi phản hồi</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="replied" {{ old('status', $contact->status) == 'replied' ? 'selected' : '' }}>
                                        Đã phản hồi
                                    </option>
                                    <option value="resolved" {{ old('status', $contact->status) == 'resolved' ? 'selected' : '' }}>
                                        Đã giải quyết
                                    </option>
                                </select>
                                <small class="form-text text-muted">
                                    Chọn "Đã giải quyết" nếu không cần theo dõi thêm
                                </small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    {{ $contact->admin_reply ? 'Cập nhật phản hồi' : 'Gửi phản hồi' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="text-center">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                    </a>
                </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="col-md-4">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thao tác nhanh</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <!-- Email Action -->
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                               class="btn btn-outline-primary btn-block">
                                <i class="fas fa-envelope mr-2"></i>
                                Gửi Email
                            </a>

                            <!-- Phone Action -->
                            @if($contact->phone)
                            <a href="tel:{{ $contact->phone }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-phone mr-2"></i>
                                Gọi điện
                            </a>
                            @endif

                            <!-- Status Updates -->
                            @if($contact->status !== 'resolved')
                            <div class="dropdown">
                                <button class="btn btn-outline-info btn-block dropdown-toggle" 
                                        type="button" data-toggle="dropdown">
                                    <i class="fas fa-edit mr-2"></i>
                                    Cập nhật trạng thái
                                </button>
                                <div class="dropdown-menu w-100">
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

                            <!-- Delete -->
                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-block">
                                    <i class="fas fa-trash mr-2"></i>
                                    Xóa liên hệ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin liên hệ</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">ID:</th>
                                <td>#{{ $contact->id }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    <span class="badge badge-{{ $contact->status_color }}">
                                        {{ $contact->status_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày gửi:</th>
                                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($contact->replied_at)
                            <tr>
                                <th>Ngày phản hồi:</th>
                                <td>{{ $contact->replied_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                            @if($contact->repliedBy)
                            <tr>
                                <th>Người phản hồi:</th>
                                <td>{{ $contact->repliedBy->name }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Recent Contacts from Same Email -->
                @php
                    $recentContacts = App\Models\Contact::where('email', $contact->email)
                        ->where('id', '!=', $contact->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentContacts->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liên hệ khác từ email này</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($recentContacts as $recent)
                            <li class="list-group-item">
                                <a href="{{ route('admin.contacts.show', $recent) }}" class="text-decoration-none">
                                    <strong>#{{ $recent->id }}</strong> - {{ Str::limit($recent->subject, 25) }}
                                    <br>
                                    <small class="text-muted">{{ $recent->created_at->format('d/m/Y') }}</small>
                                    <span class="badge badge-{{ $recent->status_color }} badge-sm float-right">
                                        {{ $recent->status_label }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.badge-lg {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.bg-light {
    background-color: #f8f9fa !important;
}

.list-group-item a {
    display: block;
    color: inherit;
}

.list-group-item a:hover {
    color: #007bff;
    text-decoration: none;
}

.d-grid {
    display: grid;
    gap: 0.5rem;
}

.btn-block {
    width: 100%;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-resize textarea
    $('#admin_reply').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush