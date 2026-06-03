@extends('layouts.settings.default')
@push('css_lib')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('settings_title','Platform Settings')
@section('settings_content')
    @include('flash::message')
    @include('adminlte-templates::common.errors')
    <div class="clearfix"></div>
    <div class="card shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs d-flex flex-row align-items-start card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{!! url()->current() !!}"><i class="fas fa-sliders-h mr-2"></i>Platform Settings</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            {!! Form::open(['url' => ['settings/update'], 'method' => 'patch']) !!}
            <div class="row">

                {{-- ─── Stripe / Payments ─── --}}
                <h5 class="col-12 pb-4"><i class="mr-3 fas fa-credit-card"></i>Stripe & Payment Settings</h5>

                <!-- stripe_key Field -->
                <div class="form-group row col-6">
                    {!! Form::label('stripe_key', 'Stripe Publishable Key', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="col-8">
                        {!! Form::text('stripe_key', setting('stripe_key'), ['class' => 'form-control', 'placeholder' => 'pk_live_... or pk_test_...']) !!}
                        <div class="form-text text-muted">
                            Your Stripe publishable key (starts with <code>pk_</code>).
                        </div>
                    </div>
                </div>

                <!-- stripe_secret Field -->
                <div class="form-group row col-6">
                    {!! Form::label('stripe_secret', 'Stripe Secret Key', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="col-8">
                        {!! Form::text('stripe_secret', setting('stripe_secret'), ['class' => 'form-control', 'placeholder' => 'sk_live_... or sk_test_...']) !!}
                        <div class="form-text text-muted">
                            Your Stripe secret key (starts with <code>sk_</code>). Used for Featured Service payments and regular Stripe checkout.
                        </div>
                    </div>
                </div>

                <!-- enable_stripe Field -->
                <div class="form-group row col-6">
                    {!! Form::label('enable_stripe', 'Enable Stripe Payments', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="checkbox icheck">
                        <label class="w-100 ml-2 form-check-inline">
                            {!! Form::hidden('enable_stripe', null) !!}
                            {!! Form::checkbox('enable_stripe', 1, setting('enable_stripe', false)) !!}
                            <span class="ml-2">Enable Stripe as a payment method for bookings</span>
                        </label>
                    </div>
                </div>

                <!-- featured_service_price Field -->
                <div class="form-group row col-6">
                    {!! Form::label('featured_service_price', 'Featured Service Price (£)', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="col-8">
                        {!! Form::number('featured_service_price', setting('featured_service_price', '9.99'), ['class' => 'form-control', 'placeholder' => '9.99', 'step' => '0.01', 'min' => '0']) !!}
                        <div class="form-text text-muted">
                            How much vendors pay (via Stripe) to feature a service on the homepage. Default: £9.99
                        </div>
                    </div>
                </div>

                <hr class="col-12">

                {{-- ─── Google / Social Auth ─── --}}
                <h5 class="col-12 pb-4 mt-3"><i class="mr-3 fab fa-google"></i>Google Authentication</h5>

                <!-- google_app_id Field -->
                <div class="form-group row col-12">
                    {!! Form::label('google_app_id', 'Google OAuth Client ID', ['class' => 'col-2 control-label text-right']) !!}
                    <div class="col-8">
                        {!! Form::text('google_app_id', setting('google_app_id'), ['class' => 'form-control', 'placeholder' => '123456789-xxxx.apps.googleusercontent.com']) !!}
                        <div class="form-text text-muted">
                            Your Google OAuth 2.0 Client ID from the <a href="https://console.cloud.google.com/apis/credentials" target="_blank">Google Cloud Console</a>. Must match the Client ID used in both PWAs and Flutter apps.
                        </div>
                    </div>
                </div>

                <!-- enable_google Field -->
                <div class="form-group row col-6">
                    {!! Form::label('enable_google', 'Enable Google Sign-In', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="checkbox icheck">
                        <label class="w-100 ml-2 form-check-inline">
                            {!! Form::hidden('enable_google', null) !!}
                            {!! Form::checkbox('enable_google', 1, setting('enable_google', false)) !!}
                            <span class="ml-2">Allow users to sign in with their Google account</span>
                        </label>
                    </div>
                </div>

                <hr class="col-12">

                {{-- ─── Platform Behaviour ─── --}}
                <h5 class="col-12 pb-4 mt-3"><i class="mr-3 fas fa-cogs"></i>Platform Behaviour</h5>

                <!-- enable_subscription Field -->
                <div class="form-group row col-6">
                    {!! Form::label('enable_subscription', 'Enable Subscription Module', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="checkbox icheck">
                        <label class="w-100 ml-2 form-check-inline">
                            {!! Form::hidden('enable_subscription', null) !!}
                            {!! Form::checkbox('enable_subscription', 1, setting('enable_subscription', true)) !!}
                            <span class="ml-2">Require vendors to have an active subscription to accept bookings</span>
                        </label>
                    </div>
                </div>

                <!-- auto_trial_on_approval Field -->
                <div class="form-group row col-6">
                    {!! Form::label('auto_trial_on_approval', 'Auto-Start Free Trial', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="checkbox icheck">
                        <label class="w-100 ml-2 form-check-inline">
                            {!! Form::hidden('auto_trial_on_approval', null) !!}
                            {!! Form::checkbox('auto_trial_on_approval', 1, setting('auto_trial_on_approval', true)) !!}
                            <span class="ml-2">Automatically start a free trial subscription when a vendor is approved</span>
                        </label>
                    </div>
                </div>

                <!-- booking_reminder_minutes Field -->
                <div class="form-group row col-6">
                    {!! Form::label('booking_reminder_minutes', 'Booking Reminder (minutes before)', ['class' => 'col-4 control-label text-right']) !!}
                    <div class="col-8">
                        {!! Form::number('booking_reminder_minutes', setting('booking_reminder_minutes', '60'), ['class' => 'form-control', 'placeholder' => '60', 'min' => '5']) !!}
                        <div class="form-text text-muted">
                            How many minutes before a booking to send a reminder notification. Default: 60 minutes.
                        </div>
                    </div>
                </div>

                <!-- Submit Field -->
                <div class="form-group mt-4 col-12 text-right">
                    <button type="submit" class="btn bg-{{setting('theme_color')}} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
                        <i class="fas fa-save"></i> Save Platform Settings
                    </button>
                    <a href="{!! route('users.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i> {{trans('lang.cancel')}}</a>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="clearfix"></div>
        </div>
    </div>
    @include('layouts.media_modal',['collection'=>null])
@endsection
@push('scripts_lib')
    <!-- select2 -->
    <script src="{{asset('vendor/select2/js/select2.full.min.js')}}"></script>
@endpush
