<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="UTF-8">
    <title>{{setting('app_name')}} | {{setting('app_short_description')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" type="image/png" href="{{$app_logo ?? ''}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">

    @stack('css_lib')
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/' . setting("theme_color", "primary") . '.min.css')}}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @if(setting('theme_contrast', '') === 'dark')
        <link rel="stylesheet" href="{{asset('css/dark-theme.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('css/light-theme-fixes.css')}}">
    @endif
    @yield('css_custom')
</head>

<body
    class="@if(in_array(app()->getLocale(), ['ar', 'ku', 'fa', 'ur', 'he', 'ha', 'ks'])) rtl @else ltr @endif layout-fixed {{setting('fixed_header', false) ? "layout-navbar-fixed" : ""}} {{setting('fixed_footer', false) ? "layout-footer-fixed" : ""}} sidebar-mini {{setting('theme_color')}} {{setting('theme_contrast', '')}}-mode"
    data-scrollbar-auto-hide="l" data-scrollbar-theme="os-theme-dark">
    <div class="wrapper">
        <nav
            class="main-header navbar navbar-expand {{setting('nav_color', 'navbar-light navbar-white')}} border-bottom-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('dashboard')}}" class="nav-link">{{trans('lang.dashboard')}}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if(env('APP_CONSTRUCTION', false))
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#"><i class="fas fa-info-circle"></i>
                            {{env('APP_CONSTRUCTION', '') }}</a>
                    </li>
                @endif
                @can('favorites.index')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('favorites*') ? 'active' : '' }}"
                            href="{{route('favorites.index')}}"><i class="fas fa-heart"></i></a>
                    </li>
                @endcan
                @can('notifications.index')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}"
                            href="{!! route('notifications.index') !!}"><i class="fas fa-bell"></i></a>
                    </li>
                @endcan
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#"> <i class="fa fas fa-angle-down"></i>
                        {!! Str::upper(app()->getLocale()) !!}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        {!! Form::open(['url' => ['settings/updateLanguage'], 'method' => 'patch', 'id' => 'languages-form']) !!}
                        {!!  Form::hidden('locale', app()->getLocale(), ['id' => 'current-language'])!!}
                        @foreach(getAvailableLanguages() as $locale => $lang)
                            <a href="#" class="dropdown-item @if(app()->getLocale() == $locale) active @endif"
                                onclick="changeLanguage('{{$locale}}')">
                                <i class="fas fa-circle mr-2"></i> {!! __($lang) !!}
                            </a>
                        @endforeach
                        {!! Form::close() !!}
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{auth()->user()->getFirstMediaUrl('avatar', 'icon')}}"
                            class="brand-image mx-2 img-circle elevation-2" alt="User Image">
                        <i class="fa fas fa-angle-down"></i> {!! auth()->user()->name !!}

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('users.profile')}}" class="dropdown-item"> <i class="fas fa-user mr-2"></i>
                            {{trans('lang.user_profile')}} </a>
                        <div class="dropdown-divider"></div>
                        <a href="{!! url('/logout') !!}" class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-envelope mr-2"></i> {{__('auth.logout')}}
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer border-0 shadow-sm">
            <div class="float-sm-right d-none d-sm-block">
                <b>Version</b> {{implode('.', str_split(substr(config('installer.currentVersion', 'v100'), 1, 3)))}}
            </div>
            <strong>Copyright © {{date('Y')}} <a href="{{url('/')}}">{{setting('app_name')}}</a>.</strong> All rights
            reserved.
        </footer>

    </div>

    <!-- jQuery -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('vendor/bootstrap-v4-rtl/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="{{asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-app.js')}}"></script>

    <script src="{{asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-messaging.js')}}"></script>

    <script type="text/javascript">@include('vendor.notifications.init_firebase')</script>

    <script type="text/javascript">
        const messaging = firebase.messaging();
        navigator.serviceWorker.register("{{url('firebase/sw-js')}}")
            .then((registration) => {
                messaging.useServiceWorker(registration);
                messaging.requestPermission()
                    .then(function () {
                        console.log('Notification permission granted.');
                        getRegToken();

                    })
                    .catch(function (err) {
                        console.log('Unable to get permission to notify.', err);
                    });
                messaging.onMessage(function (payload) {
                    console.log("Message received. ", payload);
                    notificationTitle = payload.data.title;
                    notificationOptions = {
                        body: payload.data.body,
                        icon: payload.data.icon,
                        image: payload.data.image
                    };
                    var notification = new Notification(notificationTitle, notificationOptions);
                });
            });

        function getRegToken(argument) {
            messaging.getToken().then(function (currentToken) {
                if (currentToken) {
                    saveToken(currentToken);
                    console.log(currentToken);
                } else {
                    console.log('No Instance ID token available. Request permission to generate one.');
                }
            })
                .catch(function (err) {
                    console.log('An error occurred while retrieving token. ', err);
                });
        }


        function saveToken(currentToken) {
            $.ajax({
                type: "POST",
                data: { 'device_token': currentToken, 'api_token': '{!! auth()->user()->api_token !!}' },
                url: '{!! url('api/users', ['id' => auth()->id()]) !!}',
                success: function (data) {

                },
                error: function (err) {
                    console.log(err);
                }
            });
        }

        function changeLanguage(locale) {
            event.preventDefault();
            document.getElementById('current-language').value = locale;
            document.getElementById('languages-form').submit();
        }
    </script>

    @stack('scripts_lib')
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('js/scripts.min.js')}}"></script>
    @stack('scripts')

    {{-- Dark Theme: Fix DataTables FixedColumns white patches --}}
    <script>
        (function () {
            var darkBg = '#16161f';
            var darkBgAlt = 'rgba(255,255,255,0.02)';
            var hoverBg = 'rgba(200,149,108,0.1)';
            var borderColor = 'rgba(255,255,255,0.06)';
            var textColor = '#f0ece4';

            function fixDTFC() {
                // Fix wrapper backgrounds
                document.querySelectorAll(
                    '.DTFC_LeftWrapper, .DTFC_RightWrapper, .DTFC_LeftHeadWrapper, .DTFC_RightHeadWrapper, ' +
                    '.DTFC_LeftBodyWrapper, .DTFC_RightBodyWrapper, .DTFC_LeftFootWrapper, .DTFC_RightFootWrapper, ' +
                    '.DTFC_LeftBodyLiner, .DTFC_RightBodyLiner, .DTFC_ScrollWrapper'
                ).forEach(function (el) { el.style.backgroundColor = darkBg; });

                // Fix blockers
                document.querySelectorAll('.DTFC_Blocker').forEach(function (el) {
                    el.style.backgroundColor = darkBg;
                });

                // Fix cloned tables
                document.querySelectorAll('table.DTFC_Cloned').forEach(function (table) {
                    table.style.backgroundColor = darkBg;
                    // Fix all rows in the cloned table
                    table.querySelectorAll('tr').forEach(function (row, i) {
                        row.style.backgroundColor = (i % 2 === 1) ? darkBgAlt : darkBg;
                    });
                    // Fix all cells
                    table.querySelectorAll('td').forEach(function (td) {
                        td.style.color = textColor;
                        td.style.borderTopColor = borderColor;
                    });
                    table.querySelectorAll('th').forEach(function (th) {
                        th.style.backgroundColor = 'rgba(200,149,108,0.08)';
                        th.style.color = 'rgba(240,236,228,0.6)';
                        th.style.borderBottomColor = borderColor;
                    });
                });

                // Fix hover on DTFC rows
                document.querySelectorAll('.DTFC_Cloned tbody tr, .DTFC_RightBodyLiner tr, .DTFC_LeftBodyLiner tr').forEach(function (row) {
                    if (!row._darkHover) {
                        row._darkHover = true;
                        row.addEventListener('mouseenter', function () {
                            this.style.backgroundColor = hoverBg;
                            this.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = hoverBg; });
                        });
                        row.addEventListener('mouseleave', function () {
                            var idx = Array.from(this.parentElement.children).indexOf(this);
                            var bg = (idx % 2 === 1) ? darkBgAlt : darkBg;
                            this.style.backgroundColor = bg;
                            this.querySelectorAll('td').forEach(function (td) { td.style.backgroundColor = ''; });
                        });
                    }
                });
            }

            // Run after DataTables init
            if (document.readyState === 'complete') {
                setTimeout(fixDTFC, 500);
            } else {
                window.addEventListener('load', function () { setTimeout(fixDTFC, 500); });
            }

            // Watch for dynamically created DTFC elements
            var observer = new MutationObserver(function (mutations) {
                var hasDTFC = false;
                mutations.forEach(function (m) {
                    m.addedNodes.forEach(function (n) {
                        if (n.nodeType === 1 && (n.className || '').toString().indexOf('DTFC') !== -1) {
                            hasDTFC = true;
                        }
                    });
                });
                if (hasDTFC) setTimeout(fixDTFC, 100);
            });
            observer.observe(document.body, { childList: true, subtree: true });

            // Also re-run after DataTable draw events
            if (typeof $ !== 'undefined') {
                $(document).on('draw.dt init.dt', function () { setTimeout(fixDTFC, 300); });
            }
        })();
    </script>
</body>

</html>