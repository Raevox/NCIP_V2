<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — NCIP Admin</title>

    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles

    <style>
    /* ── Variables ────────────────────────────────────────────────── */
    :root {
        --sb-w:      248px;
        --sb-mini:   68px;
        --tb-h:      62px;

        --forest:    #1a3d22;
        --green-500: #3E7B27;
        --green-400: #52a033;
        --green-100: #e8f5e2;
        --green-50:  #f4fbf0;
        --gold:      #c9a84c;
        --gold-soft: #e8c97a;

        --bg:        #f0f4f1;
        --white:     #ffffff;
        --border:    #dde6da;
        --border-s:  #edf2ea;
        --ink:       #111a0e;
        --ink-2:     #2f3d2b;
        --ink-3:     #5a6b55;
        --ink-4:     #8fa087;
        --red:       #d93025;
        --red-soft:  #fdecea;

        --shadow-xs: 0 1px 2px rgba(0,0,0,.05);
        --shadow-sm: 0 2px 6px rgba(0,0,0,.07);
        --shadow-lg: 0 12px 40px rgba(0,0,0,.14);
        --ease:      all .22s cubic-bezier(.4,0,.2,1);
        --r-sm:      8px;
        --r-md:      12px;
        --r-lg:      16px;
    }

    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
        background: var(--bg);
        font-family: 'Poppins', sans-serif;
        color: var(--ink-2);
        overflow-x: hidden;
    }

    /* ── Mobile overlay ─────────────────────────────────────────── */
    .sb-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,20,12,.5);
        backdrop-filter: blur(3px);
        z-index: 998;
    }
    .sb-overlay.show { display: block; }

    /* ══════════════════════════════════════════════════════════
       SIDEBAR — clean, simple dark green, no effects
    ══════════════════════════════════════════════════════════ */
    .sidebar {
        width: var(--sb-w);
        height: 100vh;
        background: #1a3d22;
        position: fixed; left:0; top:0;
        z-index: 999;
        display: flex; flex-direction: column;
        transition: var(--ease);
        overflow: hidden;
    }

    /* Thin gold top stripe */
    .sidebar::before {
        content: '';
        position: absolute; top:0; left:0; right:0; height:2px;
        background: linear-gradient(90deg, transparent, var(--gold), var(--gold-soft), var(--gold), transparent);
        z-index: 1;
    }

    /* ── Collapsed ── */
    .sidebar.collapsed { width: var(--sb-mini); }

    .sidebar.collapsed .sb-logo-text,
    .sidebar.collapsed .sb-nav-label,
    .sidebar.collapsed .sb-section,
    .sidebar.collapsed .sb-logout-text,
    .sidebar.collapsed .sb-badge        { display: none; }

    .sidebar.collapsed .sb-logo-wrap    { padding: 14px 0; justify-content: center; }
    .sidebar.collapsed .sb-nav-link     { justify-content: center; padding: 10px 0; margin: 0 10px; }
    .sidebar.collapsed .sb-nav-link .sb-nav-icon { margin: 0; }
    .sidebar.collapsed .sb-logout-btn   { justify-content: center; padding: 10px 0; margin: 0 10px; }
    .sidebar.collapsed .sb-logout-btn i { margin: 0; }

    /* ── Logo ── */
    .sb-logo-wrap {
        display: flex; align-items: center; gap: 11px;
        padding: 16px 16px 14px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        flex-shrink: 0;
        transition: var(--ease);
    }
    .sb-logo-img {
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 2px solid rgba(201,168,76,.4);
        background: white;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(201,168,76,.1);
        transition: var(--ease);
    }
    .sb-logo-text { overflow: hidden; }
    .sb-logo-title {
        font-family: 'Sora', sans-serif;
        font-size: 13px; font-weight: 700;
        color: #fff; line-height: 1.3;
    }
    .sb-logo-sub {
        font-size: 9.5px;
        color: rgba(255,255,255,.35);
        font-weight: 400;
        margin-top: 2px;
    }

    /* ── Nav ── */
    .sb-nav { flex: 1; padding: 10px 0 6px; overflow-y: auto; scrollbar-width: none; }
    .sb-nav::-webkit-scrollbar { display: none; }

    .sb-section {
        font-size: 9px; font-weight: 700;
        letter-spacing: 1.6px; text-transform: uppercase;
        color: rgba(255,255,255,.22);
        padding: 10px 16px 5px;
    }

    .sb-nav-list { list-style: none; padding: 0 8px; margin: 0 0 4px; }
    .sb-nav-list li { margin-bottom: 1px; }

    .sb-nav-link {
        display: flex; align-items: center;
        padding: 10px 12px;
        border-radius: var(--r-sm);
        color: rgba(255,255,255,.62);
        text-decoration: none;
        font-size: 13px; font-weight: 500;
        transition: var(--ease);
        white-space: nowrap;
        overflow: hidden;
    }
    .sb-nav-link:hover {
        background: rgba(255,255,255,.08);
        color: #fff;
    }
    .sb-nav-link.active {
        background: rgba(255,255,255,.12);
        color: #fff;
        box-shadow: inset 3px 0 0 var(--gold);
    }
    .sb-nav-link.active .sb-nav-icon { color: var(--gold-soft); }

    .sb-nav-icon {
        width: 18px; font-size: 13px;
        margin-right: 11px;
        text-align: center; flex-shrink: 0;
        transition: color .18s;
    }
    .sb-nav-label { flex: 1; }

    /* Sidebar notif badge */
    .sb-badge {
        background: var(--red); color: white;
        font-size: 9px; font-weight: 700;
        padding: 1px 5px; border-radius: 10px;
        min-width: 17px; text-align: center; line-height: 1.4;
        display: none; flex-shrink: 0;
    }
    .sb-badge.show { display: inline-block; }

    /* Sidebar red dot badge for Applicant menu */
    .sb-nav-dot {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        margin-left: auto;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25);
        animation: pulse-red-dot 2s infinite ease-in-out;
        display: none;
    }
    .sb-nav-dot.show {
        display: inline-block !important;
    }

    .sidebar.collapsed .sb-nav-link {
        position: relative;
    }
    .sidebar.collapsed .sb-nav-dot {
        position: absolute;
        top: 6px;
        right: 14px;
        margin: 0;
    }

    @keyframes pulse-red-dot {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.25);
            opacity: 0.8;
        }
    }

    /* Divider */
    .sb-divider {
        height: 1px;
        background: rgba(255,255,255,.07);
        margin: 6px 16px;
    }

    /* ── Sidebar footer — logout only ── */
    .sb-footer {
        padding: 10px 8px 14px;
        border-top: 1px solid rgba(255,255,255,.07);
        flex-shrink: 0;
    }

    .sb-logout-btn {
        display: flex; align-items: center; width: 100%;
        padding: 10px 12px;
        background: rgba(217,48,37,.12);
        border: 1px solid rgba(217,48,37,.22);
        border-radius: var(--r-sm);
        color: #ff8a80;
        font-size: 12.5px; font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: var(--ease);
        white-space: nowrap;
    }
    .sb-logout-btn i { font-size: 12px; margin-right: 9px; flex-shrink: 0; }
    .sb-logout-btn:hover {
        background: rgba(217,48,37,.24);
        border-color: rgba(217,48,37,.4);
        color: #ffb3ae;
    }

    /* ══════════════════════════════════════════════════════════
       TOPBAR
    ══════════════════════════════════════════════════════════ */
    .topbar {
        position: fixed; top:0;
        left: var(--sb-w);
        width: calc(100% - var(--sb-w));
        height: var(--tb-h);
        background: var(--white);
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px;
        z-index: 997;
        transition: var(--ease);
        box-shadow: var(--shadow-xs);
    }
    .topbar.expanded {
        left: var(--sb-mini);
        width: calc(100% - var(--sb-mini));
    }

    .tb-left { display: flex; align-items: center; gap: 12px; }

    /* Hamburger — always visible, toggles sidebar on all screen sizes */
    .tb-hamburger {
        width: 36px; height: 36px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: var(--ease);
        flex-shrink: 0;
    }
    .tb-hamburger:hover { background: var(--green-500); border-color: var(--green-500); }
    .tb-hamburger:hover i { color: #fff; }
    .tb-hamburger i { font-size: 13.5px; color: var(--ink-3); transition: var(--ease); }

    .tb-title {
        font-family: 'Sora', sans-serif;
        font-size: 15px; font-weight: 700;
        color: var(--ink); letter-spacing: -.2px;
    }
    .tb-breadcrumb {
        font-size: 10px; color: var(--ink-4);
        margin-top: 1px;
    }

    .tb-right { display: flex; align-items: center; gap: 8px; }

    /* ── Bell button ── */
    .tb-icon-btn {
        width: 36px; height: 36px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: var(--ease);
        position: relative;
        flex-shrink: 0;
    }
    .tb-icon-btn:hover { background: var(--white); border-color: var(--green-500); }
    .tb-icon-btn i { font-size: 14px; color: var(--ink-3); transition: var(--ease); }
    .tb-icon-btn:hover i { color: var(--green-500); }

    @keyframes bellRing {
        0%,100% { transform: rotate(0); }
        15%,55%  { transform: rotate(-14deg); }
        35%,75%  { transform: rotate(14deg); }
    }
    .tb-icon-btn.has-notif i { animation: bellRing 1.8s ease 0.5s 2; }

    .tb-notif-badge {
        position: absolute; top: -5px; right: -5px;
        background: var(--red); color: #fff;
        font-size: 9px; font-weight: 700;
        padding: 2px 5px; border-radius: 10px; min-width: 17px;
        text-align: center; line-height: 1.4;
        border: 2px solid var(--white);
        display: none;
        box-shadow: 0 2px 6px rgba(217,48,37,.4);
    }
    .tb-notif-badge.show { display: block; }

    /* ── Notif dropdown ── */
    .tb-dropdown {
        position: absolute; top: calc(100% + 8px); right: 0;
        width: 340px;
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border);
        z-index: 1001;
        display: none; flex-direction: column;
        overflow: hidden;
        animation: dropDown .2s cubic-bezier(.22,1,.36,1);
    }
    .tb-dropdown.show { display: flex; }

    @keyframes dropDown {
        from { opacity:0; transform: translateY(-8px) scale(.97); }
        to   { opacity:1; transform: translateY(0) scale(1); }
    }

    .tb-dropdown__head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border-s);
        background: var(--bg);
        display: flex; justify-content: space-between; align-items: center;
        flex-shrink: 0;
    }
    .tb-dropdown__head h6 {
        margin: 0;
        font-family: 'Sora', sans-serif;
        font-size: 13px; font-weight: 700;
        color: var(--ink);
        display: flex; align-items: center; gap: 6px;
    }
    .tb-dropdown__head h6 i { color: var(--green-500); font-size: 12px; }

    .tb-mark-all-btn {
        background: none; border: none;
        color: var(--green-500);
        font-size: 11px; font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        padding: 3px 8px; border-radius: 6px;
        transition: var(--ease);
        display: none;
    }
    .tb-mark-all-btn:hover { background: var(--green-50); }

    .tb-dropdown__body {
        flex: 1; overflow-y: auto;
        max-height: 330px;
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }

    .tb-notif-item {
        display: flex; gap: 11px; align-items: flex-start;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-s);
        cursor: pointer;
        transition: background .15s;
    }
    .tb-notif-item:hover { background: var(--bg); }
    .tb-notif-item:last-child { border-bottom: none; }
    .tb-notif-item.unread { background: var(--green-50); border-left: 3px solid var(--green-500); }
    .tb-notif-item.unread:hover { background: #ecf8e4; }

    .tb-notif-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 13px; flex-shrink: 0;
    }
    .tb-notif-body { flex: 1; min-width: 0; }
    .tb-notif-title {
        font-size: 12px; font-weight: 700;
        color: var(--ink);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .tb-notif-msg {
        font-size: 11px; color: var(--ink-3); line-height: 1.45;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .tb-notif-time { font-size: 9.5px; color: var(--ink-4); margin-top: 4px; font-weight: 500; }

    .tb-dropdown__foot {
        padding: 11px 16px;
        border-top: 1px solid var(--border-s);
        background: var(--bg); text-align: center; flex-shrink: 0;
    }
    .tb-dropdown__foot a {
        color: var(--green-500); font-size: 12px; font-weight: 700;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .tb-dropdown__foot a:hover { color: var(--forest); }

    .tb-notif-empty, .tb-notif-loading {
        padding: 36px 16px; text-align: center; color: var(--ink-4);
    }
    .tb-notif-empty i { font-size: 28px; margin-bottom: 8px; display: block; opacity:.35; }
    .tb-notif-empty p { font-size: 12px; margin: 0; }
    .tb-spinner {
        width: 24px; height: 24px;
        border: 3px solid var(--border); border-top-color: var(--green-500);
        border-radius: 50%;
        animation: spin .7s linear infinite;
        margin: 0 auto 10px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── User button (topbar) — avatar only, no name/role ── */
    .tb-user-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--border);
        cursor: pointer;
        transition: var(--ease);
        flex-shrink: 0;
        background: var(--bg);
    }
    .tb-user-btn:hover { border-color: var(--green-500); }
    .tb-user-btn img { width: 100%; height: 100%; object-fit: cover; display: block; }

    /* ── User dropdown ── */
    .tb-user-dropdown {
        position: absolute; top: calc(100% + 8px); right: 0;
        width: 200px;
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border);
        z-index: 1001; overflow: hidden;
        display: none;
        animation: dropDown .2s cubic-bezier(.22,1,.36,1);
    }
    .tb-user-dropdown.show { display: block; }

    .tb-user-dropdown__head {
        padding: 13px 15px;
        background: var(--bg);
        border-bottom: 1px solid var(--border-s);
    }
    .tb-user-dropdown__head p    { font-size: 10px; color: var(--ink-4); margin: 0; }
    .tb-user-dropdown__head strong {
        font-size: 13px; color: var(--ink);
        display: block; margin-top: 2px; font-weight: 700;
    }
    .tb-user-dropdown__head span {
        font-size: 10px; color: var(--ink-3);
    }

    .tb-user-menu-item {
        display: flex; align-items: center; gap: 9px;
        padding: 10px 15px;
        color: var(--ink-2); text-decoration: none;
        font-size: 13px; font-weight: 500;
        background: none; border: none; width: 100%;
        text-align: left; cursor: pointer;
         font-family: 'Poppins', sans-serif;
        transition: background .15s;
    }
    .tb-user-menu-item i { width: 14px; text-align: center; font-size: 12px; color: var(--ink-4); }
    .tb-user-menu-item:hover { background: var(--bg); color: var(--ink); }
    .tb-user-menu-item:hover i { color: var(--green-500); }
    .tb-user-menu-item.danger { color: var(--red); border-top: 1px solid var(--border-s); }
    .tb-user-menu-item.danger i { color: var(--red); }
    .tb-user-menu-item.danger:hover { background: var(--red-soft); }

    /* ══════════════════════════════════════════════════════════
       MAIN
    ══════════════════════════════════════════════════════════ */
    .main-content {
        margin-left: var(--sb-w);
        margin-top: var(--tb-h);
        padding: 20px 22px;
        min-height: calc(100vh - var(--tb-h));
        width: calc(100% - var(--sb-w));
        transition: var(--ease);
    }
    .main-content.expanded {
        margin-left: var(--sb-mini);
        width: calc(100% - var(--sb-mini));
    }
    .main-content .container-fluid { padding: 0; }

    /* ── Responsive ── */
    @media (max-width: 1024px) { :root { --sb-w: 220px; } }

    @media (max-width: 768px) {
        .sidebar { left: calc(-1 * var(--sb-w)); }
        .sidebar.mobile-open { left: 0; box-shadow: var(--shadow-lg); }
        .topbar { left: 0 !important; width: 100% !important; padding: 0 14px; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 14px; }
        .tb-dropdown { width: 300px; }
        .tb-breadcrumb { display: none; }
    }

    @media (max-width: 420px) {
        .tb-dropdown { width: calc(100vw - 20px); right: -46px; }
        .main-content { padding: 12px; }
    }
    </style>
</head>
<body>

<div class="sb-overlay" id="sbOverlay" onclick="closeMobileSidebar()"></div>

{{-- ════════════════════════════
     SIDEBAR
════════════════════════════ --}}
<aside class="sidebar" id="sidebar">

    {{-- Logo --}}
    <div class="sb-logo-wrap">
        <img src="{{ asset('images/ncip logo.png') }}"
             alt="NCIP" class="sb-logo-img"
             onerror="this.src='{{ asset('images/ncip_logo.jpg') }}'">
        <div class="sb-logo-text">
            <div class="sb-logo-title">NCIP</div>
            <div class="sb-logo-sub">Central Luzon · Nueva Ecija</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sb-nav">

        {{-- ── Overview ── --}}
        <div class="sb-section">Overview</div>
        <ul class="sb-nav-list">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-chart-pie"></i>
                    <span class="sb-nav-label">Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="sb-divider"></div>

        {{-- ── Records ── --}}
        <div class="sb-section">Records</div>
        <ul class="sb-nav-list">
            <li>
                <a href="{{ route('ip_records.index') }}"
                   class="sb-nav-link {{ request()->routeIs('ip_records.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-id-card"></i>
                    <span class="sb-nav-label">IP Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.applicants.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}"
                   id="adminApplicantsNavLink">
                    <i class="sb-nav-icon fas fa-user-check"></i>
                    <span class="sb-nav-label">Applicants</span>
                    <span class="sb-nav-dot {{ (!empty($applicantBadge['main_dot'])) ? 'show' : '' }}" id="applicantsNavDot" title="New or pending applicant updates"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.archive.ip_records') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.archive.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-box-archive"></i>
                    <span class="sb-nav-label">Archives</span>
                </a>
            </li>
        </ul>

        <div class="sb-divider"></div>

        {{-- ── Content ── --}}
        <div class="sb-section">Content</div>
        <ul class="sb-nav-list">
            <li>
                <a href="{{ route('admin.news.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-newspaper"></i>
                    <span class="sb-nav-label">News & Updates</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.accomplishments.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.accomplishments.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-trophy"></i>
                    <span class="sb-nav-label">Accomplishments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tribes.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.tribes.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-people-group"></i>
                    <span class="sb-nav-label">Tribes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.partners.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-handshake"></i>
                    <span class="sb-nav-label">Partners</span>
                </a>
            </li>
        </ul>

        <div class="sb-divider"></div>

        {{-- ── Administration ── --}}
        <div class="sb-section">Administration</div>
        <ul class="sb-nav-list">
            <li>
                <a href="{{ route('admin.accounts.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-user-shield"></i>
                    <span class="sb-nav-label">User Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.audit.trail') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-clipboard-list"></i>
                    <span class="sb-nav-label">Audit Trail</span>
                </a>
            </li>
        </ul>

    </nav>

    {{-- Footer: logout only --}}
    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
            @csrf
            <button type="submit" class="sb-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="sb-logout-text">Log Out</span>
            </button>
        </form>
    </div>

</aside>

{{-- ════════════════════════════
     TOPBAR
════════════════════════════ --}}
<header class="topbar" id="topbar">

    <div class="tb-left">
        {{-- Hamburger — always visible on all screens --}}
        <button class="tb-hamburger" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div>
            <div class="tb-title">@yield('title', 'Dashboard')</div>
            <div class="tb-breadcrumb">NCIP Admin &rsaquo; @yield('title', 'Dashboard')</div>
        </div>
    </div>

    <div class="tb-right">

        {{-- Bell --}}
        <div style="position:relative;">
            <button class="tb-icon-btn" id="tbBellBtn"
                    onclick="toggleNotifDropdown()"
                    title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="tb-notif-badge" id="tbNotifBadge"></span>
            </button>

            <div class="tb-dropdown" id="tbNotifDropdown">
                <div class="tb-dropdown__head">
                    <h6><i class="fas fa-bell"></i> Notifications</h6>
                    <button class="tb-mark-all-btn" id="tbMarkAllBtn"
                            onclick="markAllReadFromDropdown()">
                        <i class="fas fa-check-double"></i> Mark all read
                    </button>
                </div>
                <div class="tb-dropdown__body" id="tbNotifBody">
                    <div class="tb-notif-loading">
                        <div class="tb-spinner"></div>
                        <p style="font-size:12px;margin:0;color:var(--ink-4);">Loading…</p>
                    </div>
                </div>
                <div class="tb-dropdown__foot">
                    <a href="{{ route('admin.notifications.index') }}">
                        View all notifications
                        <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- User avatar only — no name/role shown --}}
        <div style="position:relative;">
            <button class="tb-user-btn" onclick="toggleUserMenu()"
                    title="{{ Auth::user()->name }}">
                <img src="{{ Auth::user()->profile_picture
                            ? asset('storage/' . Auth::user()->profile_picture)
                            : asset('images/adminprofile.png') }}"
                     alt="{{ Auth::user()->name }}">
            </button>

            <div class="tb-user-dropdown" id="tbUserDropdown">
                <div class="tb-user-dropdown__head">
                    <p>Signed in as</p>
                    <strong>{{ Auth::user()->name }}</strong>
                    <span>{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="tb-user-menu-item">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a href="#" class="tb-user-menu-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <button class="tb-user-menu-item danger"
                        onclick="document.getElementById('logout-form-topbar').submit()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>

    </div>
</header>

<form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

{{-- ════════════════════════════
     MAIN
════════════════════════════ --}}
<main class="main-content" id="mainContent">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts

<script>
const csrf  = () => document.querySelector('meta[name="csrf-token"]').content;
const isMob = () => window.innerWidth <= 768;

/* ── Sidebar toggle (hamburger — works desktop + mobile) ──── */
let sbCollapsed = false;

function toggleSidebar() {
    if (isMob()) {
        // Mobile: slide in/out
        const open = document.getElementById('sidebar').classList.toggle('mobile-open');
        document.getElementById('sbOverlay').classList.toggle('show', open);
    } else {
        // Desktop: collapse/expand
        sbCollapsed = !sbCollapsed;
        document.getElementById('sidebar').classList.toggle('collapsed', sbCollapsed);
        document.getElementById('topbar').classList.toggle('expanded', sbCollapsed);
        document.getElementById('mainContent').classList.toggle('expanded', sbCollapsed);
        localStorage.setItem('sbCollapsed', sbCollapsed);
    }
}

function closeMobileSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sbOverlay').classList.remove('show');
}

window.addEventListener('resize', () => {
    if (!isMob()) closeMobileSidebar();
});

// Restore desktop collapse preference
document.addEventListener('DOMContentLoaded', () => {
    if (!isMob() && localStorage.getItem('sbCollapsed') === 'true') {
        sbCollapsed = true;
        document.getElementById('sidebar').classList.add('collapsed');
        document.getElementById('topbar').classList.add('expanded');
        document.getElementById('mainContent').classList.add('expanded');
    }
});

/* ── Notification dropdown ─────────────────────────────────── */
let notifOpen = false;

function toggleNotifDropdown() {
    notifOpen = !notifOpen;
    document.getElementById('tbNotifDropdown').classList.toggle('show', notifOpen);
    if (notifOpen) { closeUserMenu(); loadDropdownNotifications(); }
}

async function loadDropdownNotifications() {
    const body = document.getElementById('tbNotifBody');
    body.innerHTML = `<div class="tb-notif-loading"><div class="tb-spinner"></div><p style="font-size:12px;margin:0;color:var(--ink-4);">Loading…</p></div>`;
    try {
        const res  = await fetch('/api/admin/notifications?type=all&page=1&per_page=6', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        const data = await res.json();
        if (!data.success || !data.data?.length) {
            body.innerHTML = `<div class="tb-notif-empty"><i class="fas fa-inbox"></i><p>No notifications yet</p></div>`;
            return;
        }
        const hasUnread = data.data.some(n => !n.is_read);
        const markBtn = document.getElementById('tbMarkAllBtn');
        if (markBtn) markBtn.style.display = hasUnread ? 'inline-block' : 'none';
        body.innerHTML = data.data.map(n => `
            <div class="tb-notif-item ${!n.is_read ? 'unread' : ''}"
                 onclick="handleNotifClick(${n.id}, ${JSON.stringify(n.action_url || '')})">
                <div class="tb-notif-icon" style="background:${notifColor(n.type)};">
                    <i class="fas fa-${notifIcon(n.type)}"></i>
                </div>
                <div class="tb-notif-body">
                    <div class="tb-notif-title">${esc(n.title)}</div>
                    <div class="tb-notif-msg">${esc(n.message)}</div>
                    <div class="tb-notif-time">${timeAgo(n.created_at)}</div>
                </div>
            </div>`).join('');
    } catch {
        body.innerHTML = `<div class="tb-notif-empty"><i class="fas fa-exclamation-circle" style="color:var(--red);opacity:1;"></i><p>Failed to load.</p></div>`;
    }
}

function handleNotifClick(id, url) {
    fetch(`/api/admin/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() }
    })
    .then(() => {
        refreshBadges();
        if (url && url !== 'null' && url !== '') window.location.href = url;
        else loadDropdownNotifications();
    })
    .catch(console.error);
}

function markAllReadFromDropdown() {
    fetch('/api/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() }
    })
    .then(() => { refreshBadges(); loadDropdownNotifications(); })
    .catch(console.error);
}

/* ── Badge refresh ─────────────────────────────────────────── */
async function refreshBadges() {
    try {
        const res  = await fetch('/api/admin/notifications/unread-count', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        const data = await res.json();
        const count = data.unreadCount || 0;

        const tbBadge = document.getElementById('tbNotifBadge');
        const tbBell  = document.getElementById('tbBellBtn');
        if (count > 0) {
            tbBadge.textContent = count > 99 ? '99+' : count;
            tbBadge.classList.add('show');
            tbBell.classList.add('has-notif');
        } else {
            tbBadge.classList.remove('show');
            tbBell.classList.remove('has-notif');
        }

        const sbBadge = document.getElementById('sbNotifBadge');
        if (count > 0) {
            sbBadge.textContent = count > 99 ? '99+' : count;
            sbBadge.classList.add('show');
        } else {
            sbBadge.classList.remove('show');
        }

        // Refresh Applicants menu red dot
        const appDot = document.getElementById('applicantsNavDot');
        if (appDot && data.applicantBadge) {
            if (data.applicantBadge.main_dot) {
                appDot.classList.add('show');
            } else {
                appDot.classList.remove('show');
            }
        }
    } catch {}
}

/* ── User dropdown ─────────────────────────────────────────── */
let userMenuOpen = false;

function toggleUserMenu() {
    userMenuOpen = !userMenuOpen;
    document.getElementById('tbUserDropdown').classList.toggle('show', userMenuOpen);
    if (userMenuOpen) closeNotifDropdown();
}
function closeUserMenu()     { userMenuOpen = false; document.getElementById('tbUserDropdown').classList.remove('show'); }
function closeNotifDropdown(){ notifOpen = false;    document.getElementById('tbNotifDropdown').classList.remove('show'); }

document.addEventListener('click', e => {
    if (!e.target.closest('#tbBellBtn')   && !e.target.closest('#tbNotifDropdown')) closeNotifDropdown();
    if (!e.target.closest('.tb-user-btn') && !e.target.closest('#tbUserDropdown'))  closeUserMenu();
});

/* ── Notification helpers ──────────────────────────────────── */
const NOTIF_COLORS = {
    pending_account: '#3E7B27', account_approved: '#10b981',
    coc_approval: '#0284c7', coc_returned: '#d97706', application_forwarded: '#7c3aed',
};
const NOTIF_ICONS = {
    pending_account: 'user-clock', account_approved: 'check-circle',
    coc_approval: 'file-alt', coc_returned: 'undo', application_forwarded: 'share',
};
function notifColor(t) { return NOTIF_COLORS[t] || '#6b7280'; }
function notifIcon(t)  { return NOTIF_ICONS[t]  || 'bell'; }

function timeAgo(d) {
    try {
        const s = Math.floor((Date.now() - new Date(d)) / 1000);
        if (s < 60)     return 'Just now';
        if (s < 3600)   return Math.floor(s / 60) + 'm ago';
        if (s < 86400)  return Math.floor(s / 3600) + 'h ago';
        if (s < 604800) return Math.floor(s / 86400) + 'd ago';
        return new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    } catch { return 'Recently'; }
}

function esc(t) {
    if (!t) return '';
    const d = document.createElement('div');
    d.textContent = t;
    return d.innerHTML;
}

/* ── Init ──────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    refreshBadges();
    setInterval(refreshBadges, 30_000);

    const appNavLink = document.getElementById('adminApplicantsNavLink');
    if (appNavLink) {
        appNavLink.addEventListener('click', () => {
            const tbBadge = document.getElementById('tbNotifBadge');
            const tbBell  = document.getElementById('tbBellBtn');
            if (tbBadge) tbBadge.classList.remove('show');
            if (tbBell) tbBell.classList.remove('has-notif');

            const sbBadge = document.getElementById('sbNotifBadge');
            if (sbBadge) sbBadge.classList.remove('show');

            const appDot = document.getElementById('applicantsNavDot');
            if (appDot) appDot.classList.remove('show');

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/api/admin/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                keepalive: true
            }).catch(() => {});
        });
    }
});
</script>

@stack('scripts')
</body>
</html>