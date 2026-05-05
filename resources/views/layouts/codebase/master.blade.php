<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>RRHH</title>

    <meta name="description" content="SATECH ">
    <meta name="author" content="SATECH">
    <meta name="robots" content="index">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @includeIf('layouts.codebase.css')
</head>

<body>
    <x-notifications />
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
        
        <nav id="sidebar">
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="content-header justify-content-lg-center">
                    <!-- Logo -->
                    <div>
                        <!-- Mini mode: single letter -->
                        <span class="smini-visible">
                            <span class="gpt-mini-logo">G</span>
                        </span>
                        <!-- Normal mode: company logo -->
                        <a class="smini-hidden d-block" href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo/logo_GPT.png') }}" alt="GPT Services"
                                 style="height:36px; max-width:138px; object-fit:contain; display:block;">
                        </a>
                    </div>
                    <!-- END Logo -->

                    <!-- Options -->
                    <div>
                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout"
                            data-action="sidebar_close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Options -->
                </div>
                <!-- END Side Header -->

                <!-- Sidebar Scrolling -->
                <div class="js-sidebar-scroll">
                    <!-- Side User -->
                    <div class="px-0 py-0 content-side content-side-user">
                        <!-- Visible only in mini mode -->
                        <div class="px-3 smini-visible-block animated fadeIn">
                            aa
                            <img class="img-avatar img-avatar32" src="{{ auth()->user()->profile_image?? 'default-avatar.png' }}" >
                        </div>
                        <!-- END Visible only in mini mode -->

                        <!-- Visible only in normal mode -->
                        <div class="mx-auto text-center smini-hidden">
                            <a class="img-link" href="{{ route('perfil.show') }}">
                                <img class="img-avatar" src="{{ auth()->user()->profile_image ?? asset('assets/images/default-avatar.svg') }}" >
                            </a>
                            <ul class="mt-3 mb-0 list-inline">
                                <li class="list-inline-item">
                                    <a class="link-fx text-dual fs-sm fw-semibold text-uppercase"
                                        href="{{ route('perfil.show') }}">{{ auth()->user()->first_name ?? 'Usuario' }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="link-fx text-dual" href="{{ route('login.logout') }}">
                                        <i class="fa fa-sign-out-alt"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Visible only in normal mode -->
                    </div>
                    <!-- END Side User -->

                    <!-- Side Navigation -->
                    @include('layouts.codebase.sidebar')
                    <!-- END Side Navigation -->
                </div>
                <!-- END Sidebar Scrolling -->
            </div>
            <!-- Sidebar Content -->
        </nav>
        <!-- END Sidebar -->
        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="space-x-1">
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <!-- END Toggle Sidebar -->
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="space-x-1">
                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-sm d-flex align-items-center gap-2" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="border:1px solid rgba(0,0,0,.1); border-radius:.45rem; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,.06); padding:.3rem .7rem;">
                            <img src="{{ auth()->user()->profile_image ?? asset('assets/images/default-avatar.svg') }}"
                                 class="hdr-user-avatar" alt="">
                            <span class="d-none d-sm-inline-block fw-semibold"
                                  style="font-size:.83rem; color:#2d3748; max-width:110px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                {{ auth()->user()->first_name ?? 'Usuario' }}
                            </span>
                            <i class="fa fa-angle-down" style="opacity:.4; font-size:.72rem;"></i>
                        </button>
                        <div class="p-0 dropdown-menu dropdown-menu-md dropdown-menu-end"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="hdr-dropdown-head">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ auth()->user()->profile_image ?? asset('assets/images/default-avatar.svg') }}"
                                         class="rounded-circle flex-shrink-0" width="40" height="40"
                                         style="object-fit:cover; border:2px solid rgba(249,190,0,.7);">
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-white lh-sm"
                                             style="font-size:.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ trim((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? '')) ?: 'Usuario' }}
                                        </div>
                                        <div class="text-white mt-1"
                                             style="font-size:.72rem; opacity:.75; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ auth()->user()->job?->name ?? 'Colaborador' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <a class="space-x-1 dropdown-item d-flex align-items-center justify-content-between"
                                    href="{{ route('perfil.show') }}">
                                    <span>Mi Perfil</span>
                                    <i class="opacity-25 fa fa-fw fa-user"></i>
                                </a>
                                {{-- <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="be_pages_generic_inbox.html">
                                    <span>Inbox</span>
                                    <i class="opacity-25 fa fa-fw fa-envelope-open"></i>
                                </a> --}}
                                {{-- <a class="space-x-1 dropdown-item d-flex align-items-center justify-content-between"
                                    href="be_pages_generic_invoice.html">
                                    <span>Invoices</span>
                                    <i class="opacity-25 fa fa-fw fa-file"></i>
                                </a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}

                                <!-- Toggle Side Overlay -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                {{-- <a class="space-x-1 dropdown-item d-flex align-items-center justify-content-between"
                                    href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                                    <span>Settings</span>
                                    <i class="opacity-25 fa fa-fw fa-wrench"></i>
                                </a> --}}
                                <!-- END Side Overlay -->

                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="space-x-1 dropdown-item d-flex align-items-center justify-content-between"
                                    href="{{ route('login.logout') }}">
                                    <span>Salir</span>
                                    <i class="opacity-25 fa fa-fw fa-sign-out-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END User Dropdown -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->
            <!-- Impersonation banner — shown inside the header so it persists across tabs -->
            @if(session('impersonate_user_id'))
                @php $impersonatedUser = \App\Models\User::find(session('impersonate_user_id')); @endphp
                @if($impersonatedUser)
                <div style="background:#fd7e14;color:#fff;padding:6px 20px;display:flex;align-items:center;justify-content:space-between;font-size:.85rem;border-top:1px solid rgba(0,0,0,.12);">
                    <span>
                        <i class="fas fa-user-secret me-2"></i>
                        <strong>MODO PRUEBA</strong> — Visualizando como
                        <strong>{{ $impersonatedUser->first_name }} {{ $impersonatedUser->last_name }}</strong>
                        (ID: {{ $impersonatedUser->id }})
                        &nbsp;·&nbsp; Todas las acciones afectan datos reales de este usuario.
                    </span>
                    <form method="POST" action="{{ route('admin.impersonate.stop') }}" style="margin:0;">
                        @csrf
                        <button type="submit"
                            style="background:rgba(0,0,0,.25);border:1px solid rgba(255,255,255,.5);color:#fff;padding:3px 12px;border-radius:4px;cursor:pointer;font-size:.8rem;">
                            <i class="fas fa-times me-1"></i> Salir del modo prueba
                        </button>
                    </form>
                </div>
                @endif
            @endif
            <!-- END Impersonation banner -->
            <!-- Header Loader -->
            <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-primary">
                <div class="content-header">
                    <div class="text-center w-100">
                        <i class="text-white far fa-sun fa-spin"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="" class="mb-4">
            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
    @includeIf('layouts.codebase.js')
</body>

</html>
