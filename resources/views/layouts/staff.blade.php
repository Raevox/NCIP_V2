<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Dashboard') — NCIP Staff</title>

    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- All layout + component styles live here --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
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
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.25); opacity: 0.8; }
        }
    </style>
</head>
<body>

@php
    $authUser   = Auth::user();
    $userName   = $authUser?->name   ?? 'Staff';
    $userRole   = ucfirst($authUser?->role ?? 'Staff');
    $profilePic = $authUser?->profile_picture
                    ? asset('storage/' . $authUser->profile_picture)
                    : asset('images/adminprofile.png');
@endphp

<div class="sb-overlay" id="sbOverlay" onclick="closeMobileSidebar()"></div>

{{-- ════════════ SIDEBAR ════════════ --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-logo-wrap">
        <img src="{{ asset('images/ncip logo.png') }}"
             alt="NCIP" class="sb-logo-img"
             onerror="this.src='{{ asset('images/ncip_logo.jpg') }}'">
        <div class="sb-logo-text">
            <div class="sb-logo-title">NCIP</div>
            <div class="sb-logo-sub">Central Luzon · Nueva Ecija</div>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Staff Menu</div>
        <ul class="sb-nav-list">
            {{-- <li>
                <a href="{{ route('staff.dashboard') }}"
                   class="sb-nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-chart-pie"></i>
                    <span class="sb-nav-label">Dashboard</span>
                </a>
            </li> --}}
             <li>
                <a href="{{ route('staff.profile') }}"
                   class="sb-nav-link {{ request()->routeIs('staff.profile') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-user"></i>
                    <span class="sb-nav-label">Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.review') }}"
                   class="sb-nav-link {{ request()->routeIs('staff.review*') ? 'active' : '' }}"
                   id="staffReviewNavLink">
                    <i class="sb-nav-icon fas fa-tasks"></i>
                    <span class="sb-nav-label">Review Applications</span>
                    <span class="sb-nav-dot {{ (!empty($applicantBadge['main_dot'])) ? 'show' : '' }}" id="staffReviewNavDot" title="New or pending applicant updates"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications.index') }}"
                   class="sb-nav-link {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}">
                    <i class="sb-nav-icon fas fa-bell"></i>
                    <span class="sb-nav-label">Notifications</span>
                    <span class="sb-nav-dot" id="staffNotificationNavDot" title="Unread notifications"></span>
                </a>
            </li>
           
        </ul>
    </nav>

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

{{-- ════════════ TOPBAR ════════════ --}}
<header class="topbar" id="topbar">

    <div class="tb-left">
        <button class="tb-hamburger" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        {{-- <div>
            <div class="tb-title">@yield('title', 'Dashboard')</div>
            <div class="tb-breadcrumb">NCIP Staff &rsaquo; @yield('title', 'Dashboard')</div>
        </div> --}}
    </div>

    <div class="tb-right">

        <a href="{{ route('admin.notifications.index') }}" class="tb-icon-btn text-decoration-none"
           id="staffNotificationBell" title="Notifications" aria-label="Notifications">
            <i class="fas fa-bell"></i>
            <span class="tb-notif-badge" id="staffNotificationBadge"></span>
        </a>

        <span class="tb-role-pill">
            <i class="fas fa-id-badge"></i> Staff
        </span>

        <div style="position:relative;">
            <button class="tb-user-btn" onclick="toggleUserMenu()"
                    title="{{ $userName }}">
                <img src="{{ $profilePic }}"
                     alt="{{ $userName }}"
                     onerror="this.onerror=null;this.src='{{ asset('images/adminprofile.png') }}'">
            </button>

            <div class="tb-user-dropdown" id="tbUserDropdown">
                <div class="tb-user-dropdown__head">
                    <p>Signed in as</p>
                    <strong>{{ $userName }}</strong>
                    <span>{{ $userRole }}</span>
                </div>
                <a href="{{ route('staff.profile') }}" class="tb-user-menu-item">
                    <i class="fas fa-user"></i> My Profile
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

{{-- ════════════ MAIN ════════════ --}}
<main class="main-content" id="mainContent">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const isMob = () => window.innerWidth <= 768;
let sbCollapsed  = false;
let userMenuOpen = false;

function toggleSidebar() {
    if (isMob()) {
        const open = document.getElementById('sidebar').classList.toggle('mobile-open');
        document.getElementById('sbOverlay').classList.toggle('show', open);
    } else {
        sbCollapsed = !sbCollapsed;
        document.getElementById('sidebar').classList.toggle('collapsed',    sbCollapsed);
        document.getElementById('topbar').classList.toggle('expanded',      sbCollapsed);
        document.getElementById('mainContent').classList.toggle('expanded', sbCollapsed);
        localStorage.setItem('staffSbCollapsed', sbCollapsed);
    }
}

function closeMobileSidebar() {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sbOverlay').classList.remove('show');
}

function toggleUserMenu() {
    userMenuOpen = !userMenuOpen;
    document.getElementById('tbUserDropdown').classList.toggle('show', userMenuOpen);
}

document.addEventListener('click', e => {
    if (!e.target.closest('.tb-user-btn') && !e.target.closest('#tbUserDropdown')) {
        userMenuOpen = false;
        document.getElementById('tbUserDropdown').classList.remove('show');
    }
});

window.addEventListener('resize', () => { if (!isMob()) closeMobileSidebar(); });

document.addEventListener('DOMContentLoaded', () => {
    if (!isMob() && localStorage.getItem('staffSbCollapsed') === 'true') {
        sbCollapsed = true;
        document.getElementById('sidebar').classList.add('collapsed');
        document.getElementById('topbar').classList.add('expanded');
        document.getElementById('mainContent').classList.add('expanded');
    }

    refreshStaffBadges();
    refreshStaffNotifications();
    setInterval(refreshStaffBadges, 30000);
    setInterval(refreshStaffNotifications, 30000);
});

async function refreshStaffNotifications() {
    try {
        const res = await fetch('{{ route('api.admin.notifications.unread-count') }}', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        if (!res.ok) return;

        const data = await res.json();
        const count = Number(data.unreadCount || 0);
        const badge = document.getElementById('staffNotificationBadge');
        const navDot = document.getElementById('staffNotificationNavDot');
        const bell = document.getElementById('staffNotificationBell');

        if (badge) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.toggle('show', count > 0);
        }
        navDot?.classList.toggle('show', count > 0);
        bell?.classList.toggle('has-notif', count > 0);
    } catch {}
}

async function refreshStaffBadges() {
    try {
        const res = await fetch('/api/admin/notifications/badge-status', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        const data = await res.json();
        const dot = document.getElementById('staffReviewNavDot');
        if (dot && data.badgeStatus) {
            if (data.badgeStatus.main_dot) {
                dot.classList.add('show');
            } else {
                dot.classList.remove('show');
            }
        }
        const appDot = document.getElementById('dotStaffApproved');
        if (appDot && data.badgeStatus) {
            if (data.badgeStatus.has_unread_approved) {
                appDot.classList.add('show');
            } else {
                appDot.classList.remove('show');
            }
        }
        const revDot = document.getElementById('dotStaffUnderReview');
        if (revDot && data.badgeStatus) {
            if (data.badgeStatus.has_under_review) {
                revDot.classList.add('show');
            } else {
                revDot.classList.remove('show');
            }
        }
    } catch {}
}
</script>

@stack('scripts')
</body>
</html>
