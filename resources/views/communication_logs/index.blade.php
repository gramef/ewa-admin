@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-bold"><i class="fas fa-phone-alt text-primary mr-2"></i> Communication Logs</h1>
                <small class="text-muted">Track client-vendor call attempts, contact triggers, and direct communications</small>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-white px-3 py-2 rounded-pill shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Communication Logs</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content px-3">
    <!-- Stat KPI Cards -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-phone-volume"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Calls Initiated</span>
                    <span class="info-box-number text-bold">{{ number_format($stats['total_calls'] ?? 0) }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-day"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Calls Today</span>
                    <span class="info-box-number text-bold">{{ number_format($stats['today_calls'] ?? 0) }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Client Initiated</span>
                    <span class="info-box-number text-bold">{{ number_format($stats['client_calls'] ?? 0) }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-store"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vendor Initiated</span>
                    <span class="info-box-number text-bold">{{ number_format($stats['vendor_calls'] ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <form method="GET" action="{{ route('admin.communication-logs.index') }}" class="form-inline d-flex flex-wrap gap-2">
                <div class="input-group mr-2 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Search phone, user, or vendor..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <select name="caller_role" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="client" {{ request('caller_role') === 'client' ? 'selected' : '' }}>Client</option>
                    <option value="vendor" {{ request('caller_role') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                </select>
                <select name="type" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                    <option value="">All Channels</option>
                    <option value="phone_call" {{ request('type') === 'phone_call' ? 'selected' : '' }}>Phone Call</option>
                    <option value="whatsapp" {{ request('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    <option value="sms" {{ request('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                </select>
                @if(request()->anyFilled(['search', 'caller_role', 'type', 'booking_id']))
                    <a href="{{ route('admin.communication-logs.index') }}" class="btn btn-default mb-2"><i class="fas fa-times mr-1"></i> Reset</a>
                @endif
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0 text-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Timestamp</th>
                        <th>Type</th>
                        <th>Caller (Initiator)</th>
                        <th>Receiver / Vendor</th>
                        <th>Dialed Number</th>
                        <th>Related Booking</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td><span class="badge badge-light">#{{ $log->id }}</span></td>
                            <td>
                                <span class="text-bold">{{ $log->created_at->format('d M Y, H:i') }}</span>
                                <small class="text-muted d-block">{{ $log->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                @if($log->type === 'phone_call')
                                    <span class="badge badge-primary"><i class="fas fa-phone-alt mr-1"></i> Phone Call</span>
                                @elseif($log->type === 'whatsapp')
                                    <span class="badge badge-success"><i class="fab fa-whatsapp mr-1"></i> WhatsApp</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($log->type) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($log->caller)
                                    <strong>{{ $log->caller->name }}</strong>
                                    <span class="badge badge-pill {{ $log->caller_role === 'client' ? 'badge-info' : 'badge-warning' }} ml-1">
                                        {{ ucfirst($log->caller_role) }}
                                    </span>
                                    <small class="text-muted d-block">{{ $log->caller->phone_number ?: $log->caller->email }}</small>
                                @else
                                    <span class="text-muted">Guest / Anonymous</span>
                                    <span class="badge badge-pill badge-secondary ml-1">{{ ucfirst($log->caller_role) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($log->eProvider)
                                    <span class="text-bold text-dark">{{ $log->eProvider->name }}</span>
                                @elseif($log->receiver)
                                    <span>{{ $log->receiver->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->phone_dialed)
                                    <a href="tel:{{ $log->phone_dialed }}" class="text-primary"><i class="fas fa-phone-square-alt mr-1"></i>{{ $log->phone_dialed }}</a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->booking_id)
                                    <a href="{{ route('bookings.show', $log->booking_id) }}" class="badge badge-outline-primary" style="border:1px solid #c8956c;color:#c8956c;padding:4px 8px;">
                                        <i class="fas fa-calendar-check mr-1"></i> Booking #{{ $log->booking_id }}
                                    </a>
                                @else
                                    <span class="text-muted">Profile / Direct</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> {{ ucfirst($log->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-phone-slash fa-3x mb-3 text-secondary d-block"></i>
                                <h5>No communication logs recorded yet</h5>
                                <p class="small">When clients or vendors initiate calls from the app, records will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="card-footer bg-white clearfix">
                <div class="float-right">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
