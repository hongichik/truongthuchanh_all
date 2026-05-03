@extends('layouts.layout-master')

@section('title', $title)
@section('page_title', $title)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-eye"></i> {{ $title }}</h2>
                <p class="text-muted">
                    Học sinh: <strong>{{ $application->fullname }}</strong> | 
                    Ngày sinh: <strong>{{ $application->birthdate->format('d/m/Y') }}</strong> |
                    Số điện thoại: <strong>{{ $application->phone }}</strong>
                </p>
            </div>
            <div>
                <a href="{{ route('admin.applications.lop10') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
                <a href="{{ route('admin.applications.download', ['type' => $type, 'id' => $application->id]) }}" 
                   class="btn btn-primary" target="_blank">
                    <i class="fas fa-download"></i> Tải về tất cả (ZIP)
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fas fa-file-alt"></i> 
            Tổng cộng {{ count($files) }} file
        </h5>
    </div>
    <div class="card-body">
        @if(count($files) > 0)
        <div class="row">
            @foreach($files as $file)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-file"></i> {{ $file['name'] }}
                        </h6>
                    </div>
                    <div class="card-body p-2">
                        @if(in_array($file['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <!-- Hiển thị ảnh -->
                        <div class="text-center">
                            <img src="{{ $file['url'] }}" 
                                 alt="{{ $file['name'] }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 250px; cursor: pointer;"
                                 onclick="openImageModal('{{ $file['url'] }}', '{{ $file['name'] }}')">
                        </div>
                        @elseif($file['extension'] === 'pdf')
                        <!-- Hiển thị PDF -->
                        <div class="text-center">
                            <i class="fas fa-file-pdf text-danger" style="font-size: 80px;"></i>
                            <br>
                            <small class="text-muted">Tập tin PDF</small>
                        </div>
                        @else
                        <!-- File khác -->
                        <div class="text-center">
                            <i class="fas fa-file text-secondary" style="font-size: 80px;"></i>
                            <br>
                            <small class="text-muted">{{ strtoupper($file['extension']) }}</small>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            <i class="fas fa-hdd"></i> {{ $file['size'] }}
                        </small>
                        <div class="mt-2">
                            <a href="{{ $file['url'] }}" 
                               target="_blank" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-external-link-alt"></i> Mở file
                            </a>
                            <a href="{{ route('admin.applications.download', ['type' => $type, 'id' => $application->id]) }}?single={{ $file['index'] }}" 
                               class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Tải về
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-file-slash text-muted" style="font-size: 64px;"></i>
            <h5 class="text-muted mt-3">Không có file nào</h5>
            <p class="text-muted">Học sinh chưa tải lên file nào.</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal hiển thị ảnh lớn -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Xem ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <a id="downloadImageBtn" href="" class="btn btn-success">
                    <i class="fas fa-download"></i> Tải về ảnh này
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.img-fluid:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease-in-out;
}
</style>
@endpush

@push('scripts')
<script>
function openImageModal(imageUrl, imageName) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalImage').alt = imageName;
    document.getElementById('imageModalLabel').textContent = imageName;
    document.getElementById('downloadImageBtn').href = imageUrl;
    
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}
</script>
@endpush