@extends('layouts.layout-master')

@section('title', 'Master Admin Password Generator')
@section('page_title', 'Master Admin Password Generator')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-key"></i> Master Admin Password Generator</h2>
                <p class="text-muted">Generate daily passwords for Master Admin access</p>
            </div>
        </div>
    </div>
</div>

<!-- Today's Password -->
<div class="alert alert-success border-left-success shadow-sm mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="alert-heading mb-2">
                <i class="fas fa-calendar-day"></i> Today's Password
            </h5>
            <p class="mb-2">
                <strong>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</strong>
            </p>
            <div class="input-group">
                <input type="text" class="form-control font-monospace" value="{{ $todayPassword }}" id="todayPassword" readonly>
                <button class="btn btn-outline-success" type="button" onclick="copyToClipboard('todayPassword')">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access URLs -->
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-external-link-alt"></i> Quick Access Today
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Master Admin Dashboard</h6>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ get_master_admin_url() }}" id="dashboardUrl" readonly>
                    <button class="btn btn-primary" type="button" onclick="copyToClipboard('dashboardUrl')">
                        <i class="fas fa-copy"></i>
                    </button>
                    <a href="{{ get_master_admin_url() }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Open
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Log Viewer</h6>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ get_master_admin_url('logs/view') }}" id="logsUrl" readonly>
                    <button class="btn btn-primary" type="button" onclick="copyToClipboard('logsUrl')">
                        <i class="fas fa-copy"></i>
                    </button>
                    <a href="{{ get_master_admin_url('logs/view') }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Open
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Passwords -->
<div class="card shadow">
    <div class="card-header bg-info text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-calendar-week"></i> Next 7 Days Passwords
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th><i class="fas fa-calendar"></i> Date</th>
                        <th><i class="fas fa-calendar-day"></i> Day</th>
                        <th><i class="fas fa-key"></i> Password</th>
                        <th><i class="fas fa-link"></i> Dashboard URL</th>
                        <th><i class="fas fa-file-text"></i> Logs URL</th>
                        <th><i class="fas fa-tools"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($passwords as $item)
                    <tr class="{{ $item['is_today'] ? 'table-success' : '' }}">
                        <td>
                            @if($item['is_today'])
                                <strong>{{ $item['date'] }}</strong>
                                <span class="badge badge-success ml-2">Today</span>
                            @else
                                {{ $item['date'] }}
                            @endif
                        </td>
                        <td>{{ $item['day_name'] }}</td>
                        <td>
                            <code class="font-monospace">{{ $item['password'] }}</code>
                        </td>
                        <td>
                            <small class="text-truncate d-block" style="max-width: 200px;">
                                {{ $item['url'] }}
                            </small>
                        </td>
                        <td>
                            <small class="text-truncate d-block" style="max-width: 200px;">
                                {{ $item['logs_url'] }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" 
                                        onclick="copyToClipboard('password-{{ $loop->index }}')" 
                                        title="Copy Password">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <a href="{{ $item['url'] }}" class="btn btn-sm btn-primary" target="_blank" title="Open Dashboard">
                                    <i class="fas fa-tachometer-alt"></i>
                                </a>
                                <a href="{{ $item['logs_url'] }}" class="btn btn-sm btn-info" target="_blank" title="Open Logs">
                                    <i class="fas fa-file-text"></i>
                                </a>
                            </div>
                            <input type="hidden" id="password-{{ $loop->index }}" value="{{ $item['password'] }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Password Generation Info -->
<div class="card shadow mt-4">
    <div class="card-header bg-warning text-dark">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-info-circle"></i> Password Generation Information
        </h6>
    </div>
    <div class="card-body">
        <h6>How passwords are generated:</h6>
        <ol>
            <li>Take the string: <code>"hong" + day + "/" + month + "/" + year</code></li>
            <li>Example for {{ now()->format('d/m/Y') }}: <code>hong{{ now()->day }}/{{ now()->month }}/{{ now()->year }}</code></li>
            <li>Generate MD5 hash: <code>{{ $todayPassword }}</code></li>
        </ol>
        
        <h6 class="mt-4">Usage:</h6>
        <ul>
            <li>Add <code>?pass=PASSWORD</code> to any Master Admin URL</li>
            <li>Passwords change daily at midnight</li>
            <li>Each password is only valid for its specific date</li>
        </ul>
        
        <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Security Note:</strong> Keep these passwords confidential. They provide full access to Master Admin functions.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    element.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        
        // Show success message
        const btn = event.target.closest('button');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-success');
        }, 2000);
        
    } catch (err) {
        console.error('Failed to copy: ', err);
        alert('Failed to copy to clipboard');
    }
}

// Auto-refresh every hour to keep passwords current
setTimeout(() => {
    location.reload();
}, 3600000); // 1 hour
</script>
@endpush