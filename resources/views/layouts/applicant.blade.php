<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Applicant Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/applicant.css') }}">
    @stack('styles')
    <style>
    /* --- Base Styles --- */
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #f9f9f9;
        font-size: clamp(14px, 1.2vw, 16px); /* global responsive font */
        line-height: 1.5;
    }

    /* --- Sidebar --- */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 280px;
        background: #fff;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease;
        z-index: 1050;
        overflow-y: auto;
        
    }

    .sidebar .logo {
        text-align: center;
        padding: 1rem;
        border-bottom: 1px solid #ddd;
    }

    .sidebar .logo img {
        width: clamp(50px, 6vw, 70px);
        margin-bottom: 0.5rem;
    }

    .sidebar .logo h6 {
        font-weight: 600;
        margin: 0;
        font-size: clamp(14px, 1.5vw, 18px);
    }

    .sidebar .logo small {
        font-size: clamp(12px, 1.2vw, 14px);
        color: #555;
    }

    .sidebar ul.nav {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    .sidebar ul.nav li a {
        display: flex;
        align-items: center;
        padding: 0.8rem 1.2rem;
        margin: 5px 10px;
        color: #333;
        font-weight: 500;
        border-radius: 8px;
        font-size: clamp(14px, 1.2vw, 16px);
        text-decoration: none;
        transition: 0.2s;
    }

    .sidebar ul.nav li a i {
        margin-right: 10px;
        font-size: clamp(16px, 1.5vw, 20px);
        width: 20px;
        text-align: center;
    }

    .sidebar ul.nav li a:hover {
        background: #f5f5f5;
           color: #3e7b27;
        
    }
     .sidebar ul.nav li.active a{
           background: #3e7b27;
            color: #fff;
            font-weight: 500;
     }

    .sidebar .user-info {
        text-align: center;
        padding: 10px;
    }

    .sidebar .user-info .fw-bold {
        font-weight: 600;
        font-size: clamp(14px, 1.2vw, 16px);
    }

    .sidebar .user-info small {
        color: #6c757d;
        font-size: clamp(12px, 1vw, 14px);
    }

    .sidebar .logout {
        border-top: 1px solid #ddd;
        padding: 1rem;
        display: flex;
        justify-content: center;
    }

    .sidebar .btn-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        max-width: 200px;
        padding: 0.6rem 1.2rem;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: clamp(14px, 1.2vw, 16px);
        cursor: pointer;
        transition: 0.2s;
    }

    .sidebar .btn-logout:hover {
        background-color: #c82333;
    }

   /* --- Hamburger --- */ .hamburger { 
    position: fixed; 
    top: 15px; 
    left: 15px; 
    z-index: 1100; 
    cursor: pointer; 
    padding: 0; /* tanggalin padding */ 
    background: none; /* walang background */ 
    border: none; /* walang border */ 
    border-radius: 0; 
    padding-top: 16px; 
    margin-left:18px; 
    } 
    .hamburger i { 
        font-size: 20px; /* mas kitang-kita */ 
        color: #222; /* kulay ng icon */ }

    /* --- Overlay --- */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        z-index: 1040;
    }

    .sidebar-overlay.active {
        display: block;
    }

    /* --- Topbar --- */
    .topbar-wrapper {
        background: #fff;
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #ddd;
        position: fixed;
        top: 0;
        left: 280px;
        right: 0;
        height: 60px;
        display: flex;
        align-items: center;
        z-index: 1000;
        margin: 20px; 
    }

    .topbar-wrapper h2 {
        font-size: clamp(18px, 2vw, 24px);
        font-weight: 600;
        margin-left: 30px;
    }

    /* --- Main Content --- */
    .main {
        transition: margin-left 0.3s ease, width 0.3s ease;
        padding: 1.2rem;
        padding-top: 80px;
        font-size: clamp(14px, 1.2vw, 16px); /* content text responsive */
    }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .sidebar {
            width: 250px;
            transform: translateX(-100%);
        }
        .sidebar.active {
            transform: translateX(0);
        }
        .topbar-wrapper {
            left: 0;
        }
        .main {
            margin-left: 0;
            width: 100%;
            padding-top: 80px;
        }
    }

    @media (min-width: 992px) {
        .sidebar {
            transform: translateX(0);
        }
        .main {
            margin-left: 280px;
            width: calc(100% - 280px);
        }
        .hamburger {
            display: none;
        }
    }
    </style>
</head>
<body>

    <!-- Hamburger -->
    <div class="hamburger d-lg-none" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="{{ asset('images/ncip logo.png') }}" alt="NCIP Logo">
            <h6>Central Luzon</h6>
            <small>Nueva Ecija</small>
        </div>

        <ul class="nav mt-3">
            <li class="{{ request()->routeIs('applicant.dashboard') ? 'active' : '' }}">
                <a href="{{ route('applicant.dashboard') }}"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="{{ request()->routeIs('applicant.profile') ? 'active' : '' }}">
                <a href="{{ route('applicant.profile') }}"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="{{ request()->routeIs('applicant.history') ? 'active' : '' }}">
                <a href="{{ route('applicant.history') }}"><i class="fas fa-history"></i> COC History</a>
            </li>
            <li class="{{ request()->routeIs('applicant.coc.application') ? 'active' : '' }}">
                <a href="{{ route('applicant.coc.application') }}"><i class="fas fa-file-alt"></i> COC Application</a>
            </li>
        </ul>

        <div class="user-info">
            <div class="fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
            <small>Applicant</small>
        </div>

        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-logout"><i class="fas fa-sign-out-alt"></i> Log Out</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div class="topbar-wrapper">
            <h2>@yield('page-title', 'Dashboard')</h2>
        </div>

        <div class="container-fluid px-3 py-3">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
           const isActive = sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // hide hamburger kapag open sidebar
        if (isActive) {
            hamburger.style.display = "none";
        } else {
            hamburger.style.display = "block";
        }
    }
        hamburger.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.APP_BASE_URL = "{{ asset('') }}";
    </script>
    <script src="{{ asset('js/origin-picker.js') }}"></script>
    @stack('scripts')
</body>
</html>
