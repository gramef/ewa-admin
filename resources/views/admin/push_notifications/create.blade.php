@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-family:'Outfit',sans-serif;">
                        <i class="fas fa-bell mr-2" style="color:var(--accent-copper);"></i>
                        Send Push Notification
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- Compose Form --}}
                <div class="col-md-8">
                    <div class="card shadow-sm" style="border-radius:16px;overflow:hidden;">
                        <div class="card-header" style="background:linear-gradient(135deg, #c8956c 0%, #a57a5a 100%);color:#fff;border:none;">
                            <h3 class="card-title" style="font-family:'Outfit',sans-serif;font-weight:600;">
                                <i class="fas fa-paper-plane mr-2"></i> Compose Notification
                            </h3>
                        </div>
                        <div class="card-body" style="padding:2rem;">
                            {!! Form::open(['route' => 'admin.push.send', 'method' => 'POST']) !!}

                            {{-- Title --}}
                            <div class="form-group">
                                <label for="title" style="font-weight:600;">
                                    <i class="fas fa-heading mr-1 text-muted"></i> Notification Title
                                </label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg"
                                       placeholder="e.g. New Feature Available!" required maxlength="200"
                                       style="border-radius:10px;">
                                <small class="form-text text-muted">Short, attention-grabbing title (max 200 characters)</small>
                            </div>

                            {{-- Body --}}
                            <div class="form-group">
                                <label for="body" style="font-weight:600;">
                                    <i class="fas fa-align-left mr-1 text-muted"></i> Message Body
                                </label>
                                <textarea name="body" id="body" class="form-control" rows="4"
                                          placeholder="Write your notification message here..."
                                          required maxlength="1000"
                                          style="border-radius:10px;"></textarea>
                                <small class="form-text text-muted">Notification message (max 1000 characters)</small>
                            </div>

                            {{-- Target Audience --}}
                            <div class="form-group">
                                <label style="font-weight:600;">
                                    <i class="fas fa-users mr-1 text-muted"></i> Target Audience
                                </label>
                                <div class="row mt-2">
                                    <div class="col-md-6 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="target-all" name="target" value="all"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="target-all">
                                                <strong>All Users</strong>
                                                <span class="badge badge-secondary ml-1">{{ $userCount }}</span>
                                                <br><small class="text-muted">Send to everyone with a registered device</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="target-clients" name="target" value="clients"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="target-clients">
                                                <strong>Clients Only</strong>
                                                <span class="badge badge-info ml-1">{{ $clientCount }}</span>
                                                <br><small class="text-muted">Send to client app users only</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="target-vendors" name="target" value="vendors"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="target-vendors">
                                                <strong>Vendors Only</strong>
                                                <span class="badge badge-success ml-1">{{ $vendorCount }}</span>
                                                <br><small class="text-muted">Send to vendor app users only</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="target-specific" name="target" value="specific"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="target-specific">
                                                <strong>Specific User</strong>
                                                <br><small class="text-muted">Send to one specific person</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Specific User Selector (shown conditionally) --}}
                            <div class="form-group" id="specific-user-group" style="display:none;">
                                <label for="user_id" style="font-weight:600;">
                                    <i class="fas fa-user mr-1 text-muted"></i> Select User
                                </label>
                                {!! Form::select('user_id', $users, null, ['class' => 'select2 form-control', 'id' => 'user_id', 'placeholder' => '-- Select a user --']) !!}
                            </div>

                            {{-- Preview --}}
                            <div class="card mt-3 mb-3" style="border-radius:12px;background:rgba(200,149,108,0.05);border:1px dashed rgba(200,149,108,0.3);">
                                <div class="card-body p-3">
                                    <h6 style="font-family:'Outfit',sans-serif;color:#c8956c;margin-bottom:8px;">
                                        <i class="fas fa-eye mr-1"></i> Preview
                                    </h6>
                                    <div style="background:#fff;border-radius:10px;padding:12px 16px;box-shadow:0 1px 4px rgba(0,0,0,0.08);max-width:350px;">
                                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                            <img src="{{ asset('images/logo_default.png') }}" alt="" style="width:20px;height:20px;border-radius:4px;">
                                            <span style="font-size:11px;color:#999;">EWA Hair • now</span>
                                        </div>
                                        <strong id="preview-title" style="font-size:14px;">Notification Title</strong>
                                        <p id="preview-body" style="font-size:13px;color:#666;margin:4px 0 0;line-height:1.4;">Message body will appear here...</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-lg" style="background:linear-gradient(135deg, #c8956c 0%, #a57a5a 100%);color:#fff;border:none;border-radius:10px;padding:12px 32px;"
                                    onclick="return confirm('Send this push notification? This cannot be undone.')">
                                <i class="fas fa-paper-plane mr-2"></i> Send Push Notification
                            </button>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                {{-- Sidebar Stats --}}
                <div class="col-md-4">
                    <div class="card shadow-sm" style="border-radius:16px;overflow:hidden;">
                        <div class="card-header" style="background:rgba(200,149,108,0.1);border:none;">
                            <h5 class="card-title mb-0" style="font-family:'Outfit',sans-serif;">
                                <i class="fas fa-chart-bar mr-2" style="color:#c8956c;"></i> Device Stats
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background:rgba(200,149,108,0.05);border-radius:8px;">
                                <span><i class="fas fa-users text-muted mr-2"></i> Total Devices</span>
                                <strong class="text-lg">{{ $userCount }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background:rgba(23,162,184,0.05);border-radius:8px;">
                                <span><i class="fas fa-mobile-alt text-info mr-2"></i> Clients</span>
                                <strong>{{ $clientCount }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background:rgba(40,167,69,0.05);border-radius:8px;">
                                <span><i class="fas fa-store text-success mr-2"></i> Vendors</span>
                                <strong>{{ $vendorCount }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3" style="border-radius:16px;overflow:hidden;">
                        <div class="card-body">
                            <h6 style="font-family:'Outfit',sans-serif;"><i class="fas fa-lightbulb text-warning mr-2"></i> Tips</h6>
                            <ul style="font-size:13px;color:#666;padding-left:18px;margin:0;">
                                <li class="mb-2">Keep titles under 50 characters for best display</li>
                                <li class="mb-2">Messages over 100 characters may be truncated on some devices</li>
                                <li class="mb-2">Avoid sending more than 2 push notifications per day</li>
                                <li>Use specific targeting for personal messages</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Toggle specific user selector
        document.querySelectorAll('input[name="target"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('specific-user-group').style.display =
                    this.value === 'specific' ? 'block' : 'none';
            });
        });

        // Live preview
        document.getElementById('title')?.addEventListener('input', function() {
            document.getElementById('preview-title').textContent = this.value || 'Notification Title';
        });
        document.getElementById('body')?.addEventListener('input', function() {
            document.getElementById('preview-body').textContent = this.value || 'Message body will appear here...';
        });
    </script>
@endpush
