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
                                <td>
                                    @if($provider->persona_inquiry_id || $provider->persona_status)
                                        <span class="badge badge-info"><i class="fas fa-shield-alt mr-1"></i> Persona (Gov ID + Selfie)</span>
                                    @elseif($provider->kyc_id_type)
                                        {{ ucfirst(str_replace('_', ' ', $provider->kyc_id_type)) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
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
                        <h3 class="card-title">KYC Documents & Verification</h3>
                    </div>
                    <div class="card-body">
                        @if($provider->persona_inquiry_id || $provider->persona_status)
                            <div class="mb-3">
                                <h5><i class="fas fa-shield-alt text-info mr-1"></i> Persona Verification Details</h5>
                                <table class="table table-sm table-borderless mb-2">
                                    <tr>
                                        <th style="width:130px;">Inquiry ID</th>
                                        <td><code>{{ $provider->persona_inquiry_id ?? 'N/A' }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Persona Status</th>
                                        <td>
                                            <span class="badge badge-{{ ($provider->persona_status === 'approved' || $provider->persona_status === 'completed') ? 'success' : ($provider->persona_status === 'failed' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($provider->persona_status ?? 'Unknown') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @php $fields = json_decode($provider->persona_fields, true); @endphp
                                    @if($fields)
                                        @if(!empty($fields['name_first']) || !empty($fields['name_last']))
                                        <tr>
                                            <th>Verified Name</th>
                                            <td><strong>{{ trim(($fields['name_first'] ?? '') . ' ' . ($fields['name_last'] ?? '')) }}</strong></td>
                                        </tr>
                                        @endif
                                        @if(!empty($fields['birthdate']))
                                        <tr>
                                            <th>Birthdate</th>
                                            <td>{{ \Carbon\Carbon::parse($fields['birthdate'])->format('d M Y') }}</td>
                                        </tr>
                                        @endif
                                    @endif
                                </table>
                                @if($provider->persona_inquiry_id)
                                    <a href="https://app.withpersona.com/dashboard/inquiries/{{ $provider->persona_inquiry_id }}" target="_blank" rel="noopener" class="btn btn-outline-info btn-sm mt-1">
                                        <i class="fas fa-external-link-alt mr-1"></i> View on Persona Dashboard
                                    </a>
                                @endif
                            </div>
                        @elseif($provider->kyc_id_document)
                            <div class="mb-3">
                                <h5>ID Document</h5>
                                <a href="{{ route('admin.kyc.document', [$provider->id, 'id']) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-eye mr-1"></i> View ID Document (Protected)
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No ID document or Persona inquiry recorded.</p>
                        @endif

                        <hr>

                        {{-- Right to Work Section —  Share Code or Document --}}
                        @if(($provider->kyc_rtw_method ?? 'document') === 'share_code')
                            <div class="mb-3">
                                <h5><i class="fas fa-shield-alt text-success mr-1"></i> Right to Work — UK Share Code</h5>
                                <p class="text-muted mb-2" style="font-size:0.85rem;">The vendor provided a UK GOV Share Code. Verify it on the official GOV.UK portal.</p>
                                <table class="table table-sm table-borderless mb-3">
                                    <tr>
                                        <th style="width:120px;">Share Code</th>
                                        <td><code style="font-size:1.1rem;font-weight:700;letter-spacing:2px;">{{ $provider->kyc_rtw_share_code ?? 'N/A' }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $provider->kyc_rtw_dob ? \Carbon\Carbon::parse($provider->kyc_rtw_dob)->format('d M Y') : 'N/A' }}</td>
                                    </tr>
                                </table>
                                <a href="https://www.gov.uk/check-immigration-status" target="_blank" rel="noopener" class="btn btn-success btn-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i> Verify on GOV.UK
                                </a>
                                <p class="text-muted mt-2" style="font-size:0.75rem;">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Enter the Share Code and Date of Birth on the GOV.UK portal to verify right to work status. This is a free official UK Government service.
                                </p>
                            </div>
                        @elseif($provider->kyc_rtw_document)
                            <div class="mb-3">
                                <h5>Right to Work Document</h5>
                                <a href="{{ route('admin.kyc.document', [$provider->id, 'rtw']) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-eye mr-1"></i> View RTW Document (Protected)
                                </a>
                            </div>
                        @else
                            <p class="text-muted">No Right to Work verification provided.</p>
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
