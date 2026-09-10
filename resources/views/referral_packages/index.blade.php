@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-gift mr-2 text-primary"></i>Referral & Promotional Packages</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('referralPackages.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> New Referral Package
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content pb-5">
    <div class="container-fluid">
        @include('flash::message')

        <!-- Summary Metrics -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cubes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Total Campaigns</span>
                        <span class="info-box-number font-weight-bold">{{ $stats['total_packages'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Active Campaigns</span>
                        <span class="info-box-number font-weight-bold text-success">{{ $stats['active_packages'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-friends"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Total Invites</span>
                        <span class="info-box-number font-weight-bold">{{ $stats['total_referrals'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-award text-white"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-muted">Successful Bookings</span>
                        <span class="info-box-number font-weight-bold text-warning">{{ $stats['rewarded_referrals'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card with Tabs -->
        <div class="card card-primary card-outline card-outline-tabs shadow-sm">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="packages-tab" data-toggle="pill" href="#packages-content" role="tab">
                            <i class="fas fa-list mr-1"></i> Referral Campaigns ({{ $packages->total() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="activity-tab" data-toggle="pill" href="#activity-content" role="tab">
                            <i class="fas fa-chart-line mr-1"></i> Referral Activity Log ({{ $recentReferrals->total() }})
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-content">
                    <!-- TAB 1: Packages List -->
                    <div class="tab-pane fade show active" id="packages-content" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Campaign Name</th>
                                        <th>Audience</th>
                                        <th>Reward Scheme</th>
                                        <th>Min Spend</th>
                                        <th>Bookings Needed</th>
                                        <th>Total Uses</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($packages as $package)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $package->name }}</div>
                                            <small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                                        </td>
                                        <td>
                                            @if($package->target_role === 'client')
                                                <span class="badge badge-info px-2 py-1"><i class="fas fa-user mr-1"></i>Clients</span>
                                            @elseif($package->target_role === 'vendor')
                                                <span class="badge badge-warning px-2 py-1 text-white"><i class="fas fa-cut mr-1"></i>Vendors</span>
                                            @else
                                                <span class="badge badge-secondary px-2 py-1">All</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge badge-primary">Referrer: £{{ number_format($package->referrer_reward_value, 2) }}</span>
                                                <span class="badge badge-success ml-1">Referee: £{{ number_format($package->referee_reward_value, 2) }}</span>
                                            </div>
                                            <small class="text-muted text-capitalize">{{ str_replace('_', ' ', $package->reward_type) }}</small>
                                        </td>
                                        <td>
                                            {{ $package->min_booking_amount > 0 ? '£' . number_format($package->min_booking_amount, 2) : 'None' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-light border">{{ $package->required_completed_bookings }} booking</span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $package->referrals_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('referralPackages.toggle', $package->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $package->enabled ? 'btn-outline-success' : 'btn-outline-secondary' }}" title="Click to toggle status">
                                                    <i class="fas {{ $package->enabled ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                    {{ $package->enabled ? 'Active' : 'Disabled' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('referralPackages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('referralPackages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fas fa-gift fa-2x mb-2 d-block text-muted"></i>
                                            No referral packages created yet. Click <strong>New Referral Package</strong> above to launch your first promotional campaign!
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $packages->links() }}
                        </div>
                    </div>

                    <!-- TAB 2: Referral Activity Log -->
                    <div class="tab-pane fade" id="activity-content" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Referrer (Inviter)</th>
                                        <th>Referee (Invited)</th>
                                        <th>Referral Code</th>
                                        <th>Campaign</th>
                                        <th>Status</th>
                                        <th>Qualifying Booking</th>
                                        <th>Reward Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentReferrals as $referral)
                                    <tr>
                                        <td>
                                            <div>{{ $referral->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $referral->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($referral->referrer)
                                                <div class="font-weight-bold">{{ $referral->referrer->name }}</div>
                                                <small class="text-muted">{{ $referral->referrer->phone_number ?? $referral->referrer->email }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($referral->referee)
                                                <div class="font-weight-bold">{{ $referral->referee->name }}</div>
                                                <small class="text-muted">{{ $referral->referee->phone_number ?? $referral->referee->email }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $referral->referral_code }}</code>
                                        </td>
                                        <td>
                                            {{ $referral->package->name ?? 'Default Campaign' }}
                                        </td>
                                        <td>
                                            @if($referral->status === 'rewarded')
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Rewarded</span>
                                            @elseif($referral->status === 'qualified')
                                                <span class="badge badge-info px-2 py-1">Qualified</span>
                                            @elseif($referral->status === 'pending')
                                                <span class="badge badge-warning px-2 py-1 text-white">Pending 1st Job</span>
                                            @else
                                                <span class="badge badge-secondary px-2 py-1">{{ ucfirst($referral->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($referral->qualifying_booking_id)
                                                <a href="{{ route('bookings.show', $referral->qualifying_booking_id) }}" class="btn btn-sm btn-outline-info">
                                                    Booking #{{ $referral->qualifying_booking_id }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($referral->referrerCoupon)
                                                <span class="badge badge-light border text-monospace">
                                                    <i class="fas fa-tag mr-1 text-success"></i>{{ $referral->referrerCoupon->code }}
                                                </span>
                                            @elseif($referral->status === 'rewarded')
                                                <span class="text-success font-weight-bold">Issued</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            No referral invites recorded yet. Once users share their codes and invite friends, activity will stream here in real time.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $recentReferrals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
