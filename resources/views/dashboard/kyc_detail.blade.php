@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-user-check mr-2"></i>KYC Detail</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.kyc.index')}}">KYC Verification</a></li>
                    <li class="breadcrumb-item active">{{ $provider->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Provider Info --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Vendor Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th>Business Name</th>
                                <td>{{ $provider->name }}</td>
                            </tr>
                            <tr>
                                <th>Owner</th>
                                <td>{{ optional($provider->user)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ optional($provider->user)->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $provider->phone_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @php $status = $provider->kyc_status ?? 'not_submitted'; @endphp
                                    @if($status === 'verified')
                                        <span class="badge badge-success">Verified</span>
                                    @elseif($status === 'pending')
                                        <span class="badge badge-warning">Pending Review</span>
                                    @elseif($status === 'rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                    @else
                                        <span class="badge badge-secondary">Not Submitted</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>ID Type</th>
                                <td>{{ $provider->kyc_id_type ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Submitted</th>
                                <td>{{ $provider->kyc_submitted_at ? \Carbon\Carbon::parse($provider->kyc_submitted_at)->format('d M Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Reviewed</th>
                                <td>{{ $provider->kyc_reviewed_at ? \Carbon\Carbon::parse($provider->kyc_reviewed_at)->format('d M Y H:i') : 'N/A' }}</td>
                            </tr>
                            @if($provider->kyc_rejection_reason)
                            <tr>
                                <th>Rejection Reason</th>
                                <td class="text-danger">{{ $provider->kyc_rejection_reason }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">KYC Documents</h3>
                    </div>
                    <div class="card-body">
                        @if($provider->kyc_id_document)
                            <div class="mb-3">
                                <h5>ID Document</h5>
                                <a href="{{ route('admin.kyc.document', [$provider->id, 'id']) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-eye mr-1"></i> View ID Document (Protected)
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No ID document uploaded.</p>
                        @endif

                        @if($provider->kyc_rtw_document)
                            <div class="mb-3">
                                <h5>Right to Work Document</h5>
                                <a href="{{ route('admin.kyc.document', [$provider->id, 'rtw']) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-eye mr-1"></i> View RTW Document (Protected)
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No Right to Work document uploaded.</p>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                @php $status = $provider->kyc_status ?? 'not_submitted'; @endphp
                @if($status === 'pending')
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.kyc.approve', $provider->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success mr-2">
                                <i class="fas fa-check mr-1"></i> Approve KYC
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times mr-1"></i> Reject KYC
                        </button>

                        {{-- Reject Modal --}}
                        <div class="modal fade" id="rejectModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.kyc.reject', $provider->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject KYC</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="reason">Rejection Reason</label>
                                                <textarea name="reason" id="reason" class="form-control" rows="3" required
                                                    placeholder="Explain why the KYC submission was rejected..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <a href="{{ route('admin.kyc.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left mr-1"></i> Back to KYC List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
