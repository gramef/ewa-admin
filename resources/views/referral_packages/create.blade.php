@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-gift mr-2 text-primary"></i>Create Referral Package</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('referralPackages.index') }}">Referral Packages</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content pb-5">
    <div class="container-fluid">
        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">New Promotional Campaign Rules</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('referralPackages.store') }}" method="POST">
                    @csrf
                    @include('referral_packages.fields')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
