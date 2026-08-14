<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $news->title }} | NCIP Nueva Ecija</title>
    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
    body { background:#f5f5f5; line-height:1.6; color:#333; }
    
    /* Main Container */
    .main-container {
        max-width: 100%;
        margin: 0 auto;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        min-height: 100vh;
    }

    /* Navigation - Enhanced */
    .lang-switcher-nav {
        position: relative;
        margin-left: 12px;
    }
    .lang-switcher-nav button {
        background: none;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: #333;
        cursor: pointer;
    }
    .lang-switcher-nav button:hover {
        border-color: #3E7B27;
        color: #3E7B27;
    }
    .lang-switcher-nav .lang-dropdown-nav {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 6px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 130px;
        z-index: 1100;
    }
    .lang-switcher-nav .lang-dropdown-nav.show {
        display: block;
    }
    .lang-switcher-nav .lang-dropdown-nav a {
        display: block;
        padding: 10px 14px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }
    .lang-switcher-nav .lang-dropdown-nav a:hover {
        background: #f5f5f5;
        color: #3E7B27;
    }
    .nav-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    @media (max-width: 768px) {
        .nav-actions {
            display: none;
        }
    }
    .nav-bar {
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2rem;
        position: relative;
    }

    /* Logo NCIP */
    .Logo {
        display: flex;
        align-items: center;
        gap: 5px; 
    }

    .Logo img {
        height: 50px; 
        width: auto;
        margin: 10px;
    }

    .Logo-text {
        font-size: 18px;
        font-weight: bold;
        color: #222; 
        font-weight: 800;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 0.5rem;
    }
    
    .nav-menu > li {
        position: relative;
    }
    
    .nav-menu > li > a {
        color: #333;
        text-decoration: none;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
        border-bottom: 3px solid transparent;
    }
    
    .nav-menu > li > a:hover,
    .nav-menu > li > a.active {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom-color: #2c5530;
        color: #222;
    }
    
    .arrow {
        margin-left: 5px;
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }
    
    .dropdown-item:hover .arrow {
        transform: rotate(180deg);
    }

    /* Dropdown */
    .dropdown {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        min-width: 280px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateX(-50%) translateY(-15px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 10px;
        z-index: 1000;
        border: 1px solid rgba(44, 85, 48, 0.1);
    }
    
    .nav-menu li:hover .dropdown {
        opacity: 1;
        visibility: visible;
        margin-top: 15px;
    }
    
    .dropdown a {
        display: block;
        padding: 1rem 1.5rem;
        color: #222;
        text-decoration: none;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .dropdown a:last-child {
        border-bottom: none;
    }
    
    .dropdown a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #222;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .dropdown a:hover {
        color: #222;
        padding-left: 2rem;
    }
    
    .dropdown a:hover::before {
        transform: translateX(0);
    }
    
    .dropdown a:first-child {
        border-radius: 12px 12px 0 0;
    }
    
    .dropdown a:last-child {
        border-radius: 0 0 12px 12px;
    }

    /* Login Button */
    .login-btn {
        padding: 5px 8px;
        background: transparent; 
        color: #222; 
        text-decoration: none;
        border: 1px solid #222;
        border-radius: 5px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: none; 
    } 

    .login-btn:hover {
        background: #3E7B27;
        color: #fff;          
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        border-radius: 8px;
    }
    
    .mobile-menu-btn:hover {
        background: #f8f9fa;
        color: #2c5530;
    }

    .mobile-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        z-index: 1001;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .mobile-close-btn:hover {
        background: #f8f9fa;
        color: #2c5530;
    }
    
    .mobile-login {
        display: none;
        padding: 1rem;
        border-top: 1px solid #f0f0f0;
    }
    
    .desktop-login {
        display: block;
    }

    /* Header */
    .header { background:#e5e5e5; padding:1rem 1rem; border-bottom:1px solid #ddd; }
    .header-container { max-width:1200px; margin:0 auto; display:flex; align-items:center; gap:1rem; flex-wrap:wrap; }
    .logo { width:80px; height:80px; background:url('../content/IP_logo.jpg') no-repeat center; background-size:contain; border-radius:3px; }
    .org-title h1 { font-size:clamp(1.2rem,4vw,1.8rem); font-weight:700; color:#333; }
    .org-title p { font-size:clamp(0.8rem,2vw,1rem); color:#666; }

    /* Container */
    .container { max-width:1200px; margin:2rem auto; padding:0 1rem; }

    /* News Card */
    .news-show { background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); padding:2rem; }
    .news-show h2 { font-size:clamp(1.5rem,4vw,2rem); font-weight:800; margin-bottom:15px; color:#222; }
    .news-show img { width:100%; height:auto; border-radius:8px; margin-bottom:20px; object-fit:cover; max-height:500px; }
    .news-show small { display:block; color:#888; margin-bottom:15px; }
    .news-show p { font-size:1rem; line-height:1.8; color:#555; margin-bottom:20px; }
    .back-btn { display:inline-block; padding:10px 18px; background:#3E7B27; color:#fff; border-radius:6px; text-decoration:none; font-weight:600; transition:all 0.3s ease; }
    .back-btn:hover { background:#2c5530; }

    /* Footer */
    .footer { background:linear-gradient(135deg,#333,#2c2c2c); color:#fff; padding:3rem 1rem 1rem; }
    .footer-content { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:3rem; }
    .footer-links h3, .footer-social h3, .footer-logo h3 { margin-bottom:1rem; color:#fff; font-size:1.2rem; font-weight:600; }
    .footer-links ul { list-style:none; }
    .footer-links li { margin-bottom:0.8rem; }
    .footer-links a { color:#ccc; text-decoration:none; transition:all 0.3s ease; }
    .footer-links a:hover { color:#fff; padding-left:0.5rem; }
    .footer-social p { color:#ccc; margin-bottom:1rem; line-height:1.6; }
    .social-icons a { font-size:1.5rem; color:#ccc; margin-right:1rem; transition:all 0.3s ease; }
    .social-icons a:hover { color:#00acee; transform:scale(1.2); }
    .footer-logo img { width:150px; margin-top:1rem; border-radius:10px; }
    .footer-bottom { text-align:center; margin-top:2rem; padding-top:2rem; border-top:1px solid #555; color:#ccc; font-size:14px; }

    /* Responsive */
    @media (max-width: 1024px) {
        .nav-container {
            padding: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            box-shadow: none;
        }
        
        .header-container {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
            padding: 1rem;
        }
        
        .mobile-menu-btn {
            display: block;
            position: absolute;
            right: 20px;
            top: 15px;
        }
        
        .nav-container {
            flex-direction: column;
            align-items: stretch;
            position: relative;
            padding: 0;
        }
        
        /* Universal dropdown panel for all screen sizes */
        .nav-menu {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px; /* below header */
            right: 10px;
            width: 100%;
            max-width: 100%; 
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 999;
            padding: 1rem;
            margin-top: 9px;
        }

        .nav-menu.active {
            display: flex;
        }

        /* Menu items */
        .nav-menu li {
            border-bottom: 1px solid #ddd;
            margin: 0.3rem 0;
            padding: 0.5rem 0;
        }

        .nav-menu li:last-child {
            border-bottom: none;
        }

        /* Login button inside menu */
        .mobile-login .login-btn {
            display: block;
            width: 100%;
            margin-top: 1rem;
            text-align: center;
            padding: 12px;
            background: #2c5530;
            color: #fff !important;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .nav-menu > li {
            border-bottom: 1px solid #f0f0f0;
            width: 100%;
        }
        
        .nav-menu > li:last-child {
            border-bottom: none;
        }
        
        .nav-menu > li > a {
            padding: 1rem 1.5rem;
            border-bottom: none;
        }
        
        .dropdown {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            background: #f8f9fa;
            margin: 0;
            border-radius: 0;
            width: 100%;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .dropdown.active {
            max-height: 500px;
        }
        
        .dropdown a {
            padding-left: 3rem;
            font-size: 0.9rem;
        }
        
        .mobile-login {
            display: block;
        }
        
        .desktop-login {
            display: none;
        }
        
        .mobile-login .login-btn {
            margin: 0;
            display: block;
            text-align: center;
            width: calc(100% - 2rem);
            margin: 0 1rem;
        }
        
        .news-show { padding:1.5rem; }
    }

    @media (max-width: 480px) {
        .nav-menu {
            width: 90%;
            right: 5%;
        }
        
        .header-container {
            padding: 0.5rem;
        }
    }
</style>
</head>
<body>
<div class="main-container">
    <!-- Navigation -->
    <nav class="nav-bar">
        <div class="nav-container">
            <div class="Logo">
                 <img src="{{ asset('images/ncip_logo.jpg') }}" alt="NCIP Logo" />
                 <span class="logo-text">NCIP NEPO</span>
            </div> 
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li>
                    <a href="{{ route('landingpage') }}">{{ __('Home') }}</a>
                </li>
                <li class="dropdown-item">
                    <a href="#about" onclick="toggleDropdown(event, this.parentNode)">{{ __('About') }} <i class="fa-solid fa-chevron-down arrow"></i></a>
                    <div class="dropdown">
                        <a href="{{ url('about-us') }}">{{ __('About Us') }}</a>
                        <a href="{{ url('iccs-ips-rights') }}">{{ __('ICCs/IPs Rights') }}</a>
                    </div>
                </li>
                <li class="dropdown-item">
                    <a href="#program" onclick="toggleDropdown(event, this.parentNode)">
                        {{ __('Program') }} <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>
                    <div class="dropdown">
                        <a href="{{ url('programs-pps') }}">{{ __('Project, Programs & Services (PPS)') }}</a>
                        <a href="{{ url('accomplishments') }}">{{ __('Accomplishments') }}</a>
                    </div>
                </li>
                <li><a href="{{ url('partnership') }}">{{ __('Partnership') }}</a></li>
                <li><a href="{{ url('contacts') }}">{{ __('Contact Us') }}</a></li>
                <li><a href="#new-show"class="active">{{ __('News') }} </a></li>
                <li class="mobile-login"><a href="{{ route('login') }}" class="login-btn">{{ __('Login') }}</a></li>
            </ul>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="login-btn desktop-login">{{ __('Login') }}</a>
                <div class="lang-switcher-nav lang-switcher-desktop">
                    <button type="button" onclick="document.getElementById('navLangDropdownNewsShow').classList.toggle('show')">
                        <i class="fas fa-globe"></i> {{ app()->getLocale() === 'tl' ? 'Filipino' : 'English' }}
                    </button>
                    <div id="navLangDropdownNewsShow" class="lang-dropdown-nav">
                        <a href="{{ route('lang.switch', 'en') }}">English</a>
                        <a href="{{ route('lang.switch', 'tl') }}">Filipino</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo"></div>
            <div class="org-title">
                <h1>{{ __('NCIP Nueva Ecija Provincial Office') }}</h1>
                <p>{{ __('News & Updates') }}</p>
            </div>
        </div>
    </header>

    <!-- News Content -->
    <div class="container">
        <div class="news-show">
            <h2>{{ $news->title }}</h2>
            @if($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
            @endif
            <small>📅 {{ \Carbon\Carbon::parse($news->date)->format('F d, Y') }}</small>
            <p>{!! nl2br(e($news->description)) !!}</p>
            <a href="{{ url('news') }}" class="back-btn">{{ __('← Back to News') }}</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <h3>{{ __('Quick Links') }}</h3>
                <ul>
                <li><a href="{{ route('landingpage') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ url('about-us') }}">{{ __('About Us') }}</a></li>
                <li><a href="{{ url('iccs-ips-rights') }}">{{ __('ICCs/IPs Rights') }}</a></li>
                <li><a href="{{ url('programs-pps') }}">{{ __('Programs, Projects & Services') }}</a></li>
                <li><a href="{{ url('accomplishments') }}">{{ __('Accomplishments') }}</a></li>
                <li><a href="{{ url('partnership') }}">{{ __('Partnership') }}</a></li>
                <li><a href="{{ url('contacts') }}">{{ __('Contact Us') }}</a></li>
                <li><a href="{{ url('news') }}">{{ __('News') }}</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h3>{{ __('Connect With Us') }}</h3>
                <p>{{ __('Stay updated with our latest news and activities:') }}</p>
                <div class="social-icons">
                    <a href="https://facebook.com/NCIPNuevaEcija" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="viber://chat?number=+639176543210" target="_blank"><i class="fab fa-viber"></i></a>
                    <a href="https://instagram.com/ncip_nuevaecija" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/639189876543" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://t.me/NCIPNuevaEcija" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                </div>
            </div>
            <div class="footer-logo">
                <h3>NCIP NEPO</h3>
                <img src="{{ asset('content/IP_logo.jpg') }}" alt="NCIP NEPO Logo">
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 {{ __('National Commission on Indigenous Peoples - Nueva Ecija. All Rights Reserved.') }}</p>
        </div>
    </footer>
</div>

<script>
    // Toggle mobile menu
    function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        const mobileBtn = document.querySelector('.mobile-menu-btn');
        const icon = mobileBtn.querySelector('i');

        navMenu.classList.toggle('active');

        // Change hamburger to X and vice versa
        if (navMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }

    // Toggle dropdown in mobile view only
    function toggleDropdown(event, parent) {
        if (window.innerWidth <= 768) {
            event.preventDefault();
            const dropdown = parent.querySelector('.dropdown');
            dropdown.classList.toggle('active');
            const arrow = parent.querySelector('.arrow');
            arrow.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.lang-switcher-nav')) {
            document.getElementById('navLangDropdownNewsShow')?.classList.remove('show');
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const navMenu = document.getElementById('navMenu');
        const mobileBtn = document.querySelector('.mobile-menu-btn');
        const icon = mobileBtn.querySelector('i');

        if (!navMenu.contains(event.target) && !mobileBtn.contains(event.target)) {
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    });

    // Reset menu on window resize
    window.addEventListener('resize', function() {
        const navMenu = document.getElementById('navMenu');
        const mobileBtn = document.querySelector('.mobile-menu-btn');
        const icon = mobileBtn.querySelector('i');

        if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
</script>
</body>
</html>
