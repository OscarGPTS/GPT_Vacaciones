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
        <!-- Sidebar -->
        <!--
        Helper classes

        Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
          If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

        Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
        Adding .smini-visible to an element will show it only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
      -->
        <nav id="sidebar">
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Side Header -->
                <div class="content-header justify-content-lg-center">
                    <!-- Logo -->
                    <div>
                        <span class="tracking-wide smini-visible fw-bold fs-lg">
                            s<span class="text-primary">t</span>
                        </span>
                        <a class="mx-auto tracking-wide link-fx fw-bold" href="index.html">
                            <span class="smini-hidden">
                                <span class="fs-4 text-dark">RR</span><span class="fs-4 text-danger">HH</span>
                            </span>
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
                            <img class="img-avatar img-avatar32" src="{{ auth()->user()->profile_image?? 'default-avatar.png' }}" >
                        </div>
                        <!-- END Visible only in mini mode -->

                        <!-- Visible only in normal mode -->
                        <div class="mx-auto text-center smini-hidden">
                            <a class="img-link" href="be_pages_generic_profile.html">
                                <img class="img-avatar" src="{{ auth()->user()->profile_image?? 'default-avatar.png' }}" >
                            </a>
                            <ul class="mt-3 mb-0 list-inline">
                                <li class="list-inline-item">
                                    <a class="link-fx text-dual fs-sm fw-semibold text-uppercase"
                                        href="be_pages_generic_profile.html">{{ auth()->user()->first_name }}</a>
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
                        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user d-sm-none"></i>
                            <span class="d-none d-sm-inline-block fw-semibold">Menu</span>
                            <i class="opacity-50 fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="p-0 dropdown-menu dropdown-menu-md dropdown-menu-end"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="px-2 py-3 bg-body-light rounded-top">
                                <h5 class="mb-0 text-center h6">
                                    {{ auth()->user()->name }}
                                </h5>
                            </div>
                            <div class="p-2">
                                {{-- <a class="space-x-1 dropdown-item d-flex align-items-center justify-content-between"
                                    href="be_pages_generic_profile.html">
                                    <span>Profile</span>
                                    <i class="opacity-25 fa fa-fw fa-user"></i>
                                </a> --}}
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
