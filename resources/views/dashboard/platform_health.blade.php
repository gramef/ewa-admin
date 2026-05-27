@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0"><i class="fas fa-heartbeat mr-2"></i>Platform Health</h1></div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Health Status Cards -->
        <div class="row">
            @foreach($health as $key => $item)
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card {{ $item['status'] === 'operational' ? 'card-success' : ($item['status'] === 'degraded' ? 'card-warning' : 'card-danger') }} card-outline h-100">
                    <div class="card-body d-flex align-items-start">
                        <div class="mr-3">
                            @if($item['status'] === 'operational')
                                <i class="fas fa-check-circle text-success" style="font-size:28px;"></i>
                            @elseif($item['status'] === 'degraded')
                                <i class="fas fa-exclamation-triangle text-warning" style="font-size:28px;"></i>
                            @else
                                <i class="fas fa-times-circle text-danger" style="font-size:28px;"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-1" style="text-transform:capitalize;">{{ str_replace('_', ' ', $key) }}</h5>
                            <p class="mb-0 text-sm {{ $item['status'] === 'failed' ? 'text-danger font-weight-bold' : 'text-muted' }}">{{ $item['message'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Platform Stats -->
        <div class="card">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Platform Statistics</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6 text-center border-right">
                        <h2 class="font-weight-bold text-primary">{{ $stats['total_providers'] }}</h2>
                        <p class="text-muted">Total Vendors</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center border-right">
                        <h2 class="font-weight-bold text-success">{{ $stats['active_providers'] }}</h2>
                        <p class="text-muted">Active Vendors</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center border-right">
                        <h2 class="font-weight-bold text-info">{{ $stats['total_users'] }}</h2>
                        <p class="text-muted">Total Users</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center">
                        <h2 class="font-weight-bold text-warning">{{ $stats['total_bookings'] }}</h2>
                        <p class="text-muted">Total Bookings</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4 col-6 text-center">
                        <h3>{{ $stats['bookings_today'] }}</h3>
                        <p class="text-muted">Bookings Today</p>
                    </div>
                    <div class="col-lg-4 col-6 text-center">
                        <h3>£{{ number_format($stats['total_revenue'], 2) }}</h3>
                        <p class="text-muted">Total Revenue</p>
                    </div>
                    <div class="col-lg-4 col-6 text-center">
                        <h3>{{ $stats['pending_kyc'] }}</h3>
                        <p class="text-muted">Pending KYC</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
