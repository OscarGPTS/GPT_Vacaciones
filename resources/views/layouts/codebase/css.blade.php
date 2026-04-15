<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<!-- Codebase framework -->
<link rel="stylesheet" id="css-main" href="{{ asset('css/codebase.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.css') }}"> --}}

<!-- Custom Notifications CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom-notifications.css') }}">

{{-- WireUI --}}
@wireUiScripts
@stack('css')

{{-- ── Corporate Navbar & Sidebar Styles (Material Design 3 inspired) ── --}}
<style>
/* ── Sidebar ─────────────────────────────────── */
#sidebar {
    box-shadow: 2px 0 12px rgba(0,0,0,.07);
}

/* Top logo strip: clean white, elevation via shadow — no colored border */
#sidebar .content-header {
    padding: .75rem 1.25rem;
    background: #fff;
    min-height: 62px;
    box-shadow: 0 1px 0 rgba(0,0,0,.08);
}

/* Mini mode single-letter logo */
.gpt-mini-logo {
    color: #CF0A2C;
    font-size: 1.15rem;
    font-weight: 900;
    letter-spacing: -.03em;
    line-height: 1;
}

/* Sidebar user panel */
.content-side-user {
    border-bottom: 1px solid rgba(0,0,0,.06);
    padding: 1rem .75rem !important;
    background: #fafafa;
}

.content-side-user .img-avatar {
    border: 2px solid rgba(207,10,44,.25) !important;
}

.content-side-user .link-fx {
    font-size: .83rem !important;
    font-weight: 600;
    letter-spacing: .02em;
}

/* Nav section headings — neutral/muted, Material Design label style */
.nav-main-heading {
    color: #78716c;
    font-size: .66rem;
    font-weight: 700;
    letter-spacing: .09em;
    padding-top: 1rem;
}

/* Nav link hover — tinted surface pill (MD3 NavigationDrawerItem) */
.nav-main-link:hover {
    background: rgba(0,0,0,.04) !important;
    border-radius: .375rem;
    color: #CF0A2C !important;
}

.nav-main-link:hover .nav-main-link-icon {
    color: #CF0A2C !important;
}

/* Active state: red tinted container */
.nav-main-link.active {
    background: rgba(207,10,44,.07) !important;
    border-radius: .375rem;
    color: #CF0A2C !important;
    border-left: none !important;
}

.nav-main-link.active .nav-main-link-icon {
    color: #CF0A2C !important;
}

/* ── Top Header ─────────────────────────────── */
#page-header {
    background: #fff !important;
    border-bottom: 1px solid rgba(0,0,0,.08) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,.06) !important;
    /* Sticky: stays at the top of the viewport while scrolling */
    position: sticky !important;
    top: 0 !important;
    z-index: 1031 !important; /* below sidebar (1032) so mobile drawer overlays it */
}

/* Remove the page-header-modern extra top-only padding that causes
   the "too much space above, none below" misalignment */
#page-container.page-header-modern #page-header > .content-header {
    padding-top: 0 !important;
}

/* Remove horizontal content-header padding so the buttons sit
   flush at the very edge of the header */
#page-header .content-header {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

/* Restore edge spacing inside each button group */
#page-header .space-x-1:first-child {
    padding-left: .625rem;
}
#page-header .space-x-1:last-child {
    padding-right: .625rem;
}

/* Hamburger toggle button */
#page-header .space-x-1:first-child .btn {
    background: transparent;
    border-color: transparent;
    color: #555;
    border-radius: .4rem;
    transition: background .15s, color .15s;
}

#page-header .space-x-1:first-child .btn:hover {
    background: rgba(207,10,44,.06);
    color: #CF0A2C;
}

/* User avatar chip in header */
.hdr-user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid rgba(0,0,0,.12);
    flex-shrink: 0;
    display: block;
}

/* Dropdown header card — dark charcoal (Material Design on-surface) */
.hdr-dropdown-head {
    background: linear-gradient(145deg, #18181b 0%, #27272a 100%);
    border-radius: .375rem .375rem 0 0;
    padding: .85rem 1rem;
}

/* Dropdown items */
.dropdown-menu .dropdown-item:hover {
    background: rgba(207,10,44,.06);
    color: #CF0A2C;
}
</style>

