@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-id-card mr-2"></i>KYC Verification Centre</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner"><h3>{{ $pending->count() }}</h3><p>Pending Review</p></div>
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner"><h3>{{ $verified->count() }}</h3><p>Verified</p></div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner"><h3>{{ $rejected->count() }}</h3><p>Rejected</p></div>
                    <div class="icon"><i class="fas fa-times-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- Pending Reviews -->
        @if($pending->count() > 0)
        <div class="card card-warning card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-clock mr-1"></i> Pending Review ({{ $pending->count() }})</h3></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Vendor</th>
                            <th>ID Type</th>
                            <th>Submitted</th>
                            <th>ID Document</th>
                            <th>Right to Work</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pending as $p)
                        <tr>
                            <td>
                                <strong>{{ is_array($p->name) ? ($p->name['en'] ?? '') : $p->name }}</strong><br>
                                <small class="text-muted">{{ optional($p->user->first())->email ?? 'N/A' }}</small>
                            </td>
                            <td><span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $p->kyc_id_type)) }}</span></td>
                            <td>{{ $p->kyc_submitted_at ? \Carbon\Carbon::parse($p->kyc_submitted_at)->diffForHumans() : 'N/A' }}</td>
                            <td>
                                @if($p->kyc_id_document)
                                    <a href="{{ route('admin.kyc.document', [$p->id, 'id']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($p->kyc_rtw_document)
                                    <a href="{{ route('admin.kyc.document', [$p->id, 'rtw']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.kyc.approve', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve KYC for this vendor?')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $p->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.kyc.reject', $p->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject KYC — {{ is_array($p->name) ? ($p->name['en'] ?? '') : $p->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Rejection Reason <span class="text-danger">*</span></label>
                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="e.g. Document expired, image unclear, wrong document type..."></textarea>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-check-circle text-success" style="font-size:48px;"></i>
                <h5 class="mt-3">No pending KYC reviews</h5>
                <p class="text-muted">All submissions have been reviewed</p>
            </div>
        </div>
        @endif

        <!-- Verified Vendors -->
        @if($verified->count() > 0)
        <div class="card card-success card-outline collapsed-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle mr-1"></i> Verified ({{ $verified->count() }})</h3>
                <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button></div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead><tr><th>Vendor</th><th>ID Type</th><th>Verified</th></tr></thead>
                    <tbody>
                        @foreach($verified as $v)
                        <tr>
                            <td>{{ is_array($v->name) ? ($v->name['en'] ?? '') : $v->name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $v->kyc_id_type)) }}</td>
                            <td>{{ $v->kyc_reviewed_at ? \Carbon\Carbon::parse($v->kyc_reviewed_at)->format('d M Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Rejected -->
        @if($rejected->count() > 0)
        <div class="card card-danger card-outline collapsed-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-times-circle mr-1"></i> Rejected ({{ $rejected->count() }})</h3>
                <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button></div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead><tr><th>Vendor</th><th>Reason</th><th>Rejected</th></tr></thead>
                    <tbody>
                        @foreach($rejected as $r)
                        <tr>
                            <td>{{ is_array($r->name) ? ($r->name['en'] ?? '') : $r->name }}</td>
                            <td><small>{{ $r->kyc_rejection_reason }}</small></td>
                            <td>{{ $r->kyc_reviewed_at ? \Carbon\Carbon::parse($r->kyc_reviewed_at)->format('d M Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
