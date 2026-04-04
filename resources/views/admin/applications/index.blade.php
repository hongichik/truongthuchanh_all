@extends('layouts.layout-master')

@section('title', 'Quản lý đơn xin nhập học')
@section('page_title', 'Quản lý đơn xin nhập học')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="hero-title">Quản lý đơn xin nhập học</h1>
                <p class="hero-subtitle">Tổng quan và quản lý tất cả đơn đăng ký nhập học</p>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <!-- Lớp 1 -->
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-child"></i> Đơn vào lớp 1
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-primary">{{ $stats['lop1']['total'] }}</h4>
                            <small class="text-muted">Tổng đơn</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-warning">{{ $stats['lop1']['pending'] }}</h4>
                            <small class="text-muted">Chờ duyệt</small>
                        </div>
                    </div>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-success">{{ $stats['lop1']['approved'] }}</h4>
                            <small class="text-muted">Đã duyệt</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-danger">{{ $stats['lop1']['rejected'] }}</h4>
                            <small class="text-muted">Từ chối</small>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.applications.lop1') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-list"></i> Quản lý đơn lớp 1
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lớp 6 -->
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate"></i> Đơn vào lớp 6
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-info">{{ $stats['lop6']['total'] }}</h4>
                            <small class="text-muted">Tổng đơn</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-warning">{{ $stats['lop6']['pending'] }}</h4>
                            <small class="text-muted">Chờ duyệt</small>
                        </div>
                    </div>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-success">{{ $stats['lop6']['approved'] }}</h4>
                            <small class="text-muted">Đã duyệt</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-danger">{{ $stats['lop6']['rejected'] }}</h4>
                            <small class="text-muted">Từ chối</small>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.applications.lop6') }}" class="btn btn-info btn-block">
                        <i class="fas fa-list"></i> Quản lý đơn lớp 6
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lớp 10 -->
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-graduation-cap"></i> Đơn vào lớp 10
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-success">{{ $stats['lop10']['total'] }}</h4>
                            <small class="text-muted">Tổng đơn</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-warning">{{ $stats['lop10']['pending'] }}</h4>
                            <small class="text-muted">Chờ duyệt</small>
                        </div>
                    </div>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-success">{{ $stats['lop10']['approved'] }}</h4>
                            <small class="text-muted">Đã duyệt</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-item">
                            <h4 class="text-danger">{{ $stats['lop10']['rejected'] }}</h4>
                            <small class="text-muted">Từ chối</small>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.applications.lop10') }}" class="btn btn-success btn-block">
                        <i class="fas fa-list"></i> Quản lý đơn lớp 10
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ thống kê -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-chart-bar"></i> Biểu đồ thống kê trạng thái đơn
                </h5>
            </div>
            <div class="card-body">
                <canvas id="applicationChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stats-item h4 {
    margin-bottom: 5px;
    font-weight: bold;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    text-align: center;
    margin-bottom: 2rem;
}

.hero-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('applicationChart').getContext('2d');
    
    const data = {
        labels: ['Lớp 1', 'Lớp 6', 'Lớp 10'],
        datasets: [
            {
                label: 'Chờ duyệt',
                data: [{{ $stats['lop1']['pending'] }}, {{ $stats['lop6']['pending'] }}, {{ $stats['lop10']['pending'] }}],
                backgroundColor: 'rgba(255, 193, 7, 0.8)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            },
            {
                label: 'Đã duyệt', 
                data: [{{ $stats['lop1']['approved'] }}, {{ $stats['lop6']['approved'] }}, {{ $stats['lop10']['approved'] }}],
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)', 
                borderWidth: 1
            },
            {
                label: 'Từ chối',
                data: [{{ $stats['lop1']['rejected'] }}, {{ $stats['lop6']['rejected'] }}, {{ $stats['lop10']['rejected'] }}],
                backgroundColor: 'rgba(220, 53, 69, 0.8)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Thống kê đơn xin nhập học theo trạng thái'
                },
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endpush