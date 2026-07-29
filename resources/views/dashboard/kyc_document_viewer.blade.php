@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><i class="fas fa-file-contract mr-2"></i>{{ $docType }} — {{ $providerName }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.kyc.index')}}">KYC Verification</a></li>
                    <li class="breadcrumb-item active">View Document</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm position-relative">
            <div class="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">GDPR Protected View — Confidential</h3>
                <span class="badge badge-warning"><i class="fas fa-lock mr-1"></i> View Only — Download Restricted</span>
            </div>
            <div class="card-body p-0 position-relative" style="min-height: 650px; background: #1a1a1a;">
                <!-- Watermark Overlay for GDPR Compliance -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; z-index: 10; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <div style="transform: rotate(-30deg); font-size: 32px; font-weight: 800; color: rgba(255, 255, 255, 0.12); text-transform: uppercase; letter-spacing: 4px; text-align: center; user-select: none;">
                        CONFIDENTIAL — EWA ADMIN REVIEW<br>
                        AUDITED ACCESS — {{ auth()->user()->email ?? 'ADMIN' }}<br>
                        {{ now()->format('Y-m-d H:i:s T') }}
                    </div>
                </div>

                <!-- Google Drive Embedded Previewer -->
                <iframe src="{{ $viewUrl }}" style="width: 100%; height: 650px; border: 0;" allow="autoplay"></iframe>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fas fa-shield-alt mr-1"></i> Document access is logged for GDPR compliance.</small>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
