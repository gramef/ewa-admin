@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0"><i class="fas fa-bell mr-2"></i>Notifications Centre</h1></div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Quick Stats -->
        <div class="row">
            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner"><h3>{{ $stats['total_vendors'] }}</h3><p>Total Vendors</p></div>
                    <div class="icon"><i class="fas fa-store"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner"><h3>{{ $stats['active_vendors'] }}</h3><p>Active Vendors</p></div>
                    <div class="icon"><i class="fas fa-check"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-primary">
                    <div class="inner"><h3>{{ $stats['total_users'] }}</h3><p>Total Users</p></div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-warning">
                    <div class="inner"><h3>{{ $stats['bookings_today'] }}</h3><p>Today's Bookings</p></div>
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner"><h3>{{ $stats['bookings_week'] }}</h3><p>This Week</p></div>
                    <div class="icon"><i class="fas fa-calendar-week"></i></div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner"><h3>£{{ number_format($stats['revenue_month'], 0) }}</h3><p>Month Revenue</p></div>
                    <div class="icon"><i class="fas fa-pound-sign"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pending Vendor Applications -->
            <div class="col-lg-6">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-clock mr-1"></i> Pending Vendor Applications ({{ $pendingVendors->count() }})</h3>
                    </div>
                    <div class="card-body p-0" style="max-height:400px;overflow-y:auto;">
                        @if($pendingVendors->count() > 0)
                        <table class="table table-sm table-hover">
                            <tbody>
                                @foreach($pendingVendors as $v)
                                <tr>
                                    <td>
                                        <strong>{{ is_array($v->name) ? ($v->name['en'] ?? '') : $v->name }}</strong><br>
                                        <small class="text-muted">{{ $v->user->email ?? '' }} · {{ $v->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('eProviders.edit', $v->id) }}" class="btn btn-xs btn-primary">Review</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-4 text-muted"><i class="fas fa-check-circle"></i> No pending applications</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- KYC Pending -->
            <div class="col-lg-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-id-card mr-1"></i> KYC Pending Review ({{ $pendingKyc->count() }})</h3>
                    </div>
                    <div class="card-body p-0" style="max-height:400px;overflow-y:auto;">
                        @if($pendingKyc->count() > 0)
                        <table class="table table-sm table-hover">
                            <tbody>
                                @foreach($pendingKyc as $k)
                                <tr>
                                    <td>
                                        <strong>{{ is_array($k->name) ? ($k->name['en'] ?? '') : $k->name }}</strong><br>
                                        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $k->kyc_id_type)) }} · {{ $k->kyc_submitted_at ? \Carbon\Carbon::parse($k->kyc_submitted_at)->diffForHumans() : '' }}</small>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ url('admin/kyc') }}" class="btn btn-xs btn-warning">Review</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-4 text-muted"><i class="fas fa-check-circle"></i> All KYC reviewed</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check mr-1"></i> Recent Bookings (Last 7 Days)</h3>
            </div>
            <div class="card-body table-responsive p-0" style="max-height:400px;overflow-y:auto;">
                <table class="table table-sm table-hover">
                    <thead><tr><th>ID</th><th>Client</th><th>Provider</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($recentBookings as $b)
                        <tr>
                            <td>#{{ $b->id }}</td>
                            <td>{{ $b->user->name ?? 'N/A' }}</td>
                            <td>{{ is_array($b->eProvider->name ?? '') ? ($b->eProvider->name['en'] ?? '') : ($b->eProvider->name ?? 'N/A') }}</td>
                            <td>{{ $b->created_at->format('d M H:i') }}</td>
                            <td><span class="badge badge-{{ $b->payment ? 'success' : 'secondary' }}">{{ $b->bookingStatus->status ?? 'Unknown' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
