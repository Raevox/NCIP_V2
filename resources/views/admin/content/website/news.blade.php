<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Updates | NCIP Nueva Ecija</title>
    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"rel="stylesheet"/>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }

        /* Main Container */
        .main-container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            min-height: 100vh;
        }
        /* Navigation */
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

        /* Page Indicator */
        .page-indicator {
            display: none;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-weight: 500;
            color: #222;
            height: 50px;
        }

        /* Header Section */
        .header {
            background-color: #e5e5e5;
            padding: 1rem 2rem;
            border-bottom: 1px solid #ddd;
        }
        
        .header-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: url('../content/IP_logo.jpg') no-repeat center;
            background-size: contain;
            flex-shrink: 0;
            border-radius: 3px;
        }
    
        .org-title h1 {
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            font-weight: 700;
            color: #333;
        }
        
        .org-title p {
            font-size: clamp(0.8rem, 2vw, 1rem);
            color: #666;
        }
         /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1rem, 3vw, 2rem);
        }
        
        /* Page Title Section with blurred background */
        .page-title {
            position: relative;
            height: clamp(300px, 50vw, 480px);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            overflow: hidden; 
            margin-bottom: clamp(2rem, 4vw, 3rem);
        }

        /* Blurred background image */
        .page-title::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('content/newsbg.jpg') }}") no-repeat center center/cover;
            filter: blur(4px);  
            transform: scale(1.1); 
            z-index: 0;
        }

        /* Overlay for readability */
        .page-title .overlay {
            position: relative;
            z-index: 1; 
            padding: clamp(20px, 5vw, 40px);
            border-radius: 12px;
            max-width: 90%;
        }

        .page-title h2 {
            font-size: clamp(1.8rem, 6vw, 3rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: clamp(1px, 0.3vw, 2px);
            color: #ffffff; 
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
            margin-bottom: clamp(0.5rem, 2vw, 1rem);
        }

        .page-title p {
            font-size: clamp(14px, 2.5vw, 18px);
            font-weight: 400;
            line-height: 1.6;
            max-width: 900px;
            margin: 0 auto;
            color: #ffffff;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6); 
        }

        /* Section Headers */
        .section-header {
        text-align: center;
        margin-bottom: clamp(1.5rem, 3vw, 2rem); 
        margin-top: clamp(1rem, 3vw, 1.8rem);   
        padding: 0; 
        }

        .section-title {
        font-size: clamp(2rem, 4vw, 2.5rem); 
        font-weight: 700;
        color: #222;
        line-height: 1.3;
        text-align: center;
        letter-spacing: 0.5px;
        margin: 0 auto 1rem auto !important; 
        }

        .section-title .highlight-green {
        color: #3E7B27;
        font-weight: 700;
        }
                
        h2.section-title {
            color: #222;
            font-size: clamp(1.5rem, 3vw, 25px);
            text-align: left;
            padding-top: 10px;
        }
        
        p.section-subtitle {
            font-size: clamp(0.9rem, 2vw, 15px);
        }
        
        .section-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* News Page - Consistent with Landing Page */
        .news-preview-section {
        background: #fff;
        padding: 4rem 2rem;
        font-family: 'Poppins', sans-serif;
        }

        .section-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        color: #222;
        line-height: 1.4;
        text-align: center;
        margin-bottom: 8px !important ;
        letter-spacing: 0.5px;
        }

        .highlight-green {
        color: #3E7B27;
        font-weight: 700;
        }

        /* News Grid */
        .news-grid {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        }

        /* News Card */
        .news-card {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 1.5rem;
        border-bottom: 2px solid #555;
        }


        /* Image */
        .news-card-image {
        flex: 0 0 280px;
        border-radius: 8px;
        overflow: hidden;
        }

        .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        }

        /* Content */
        .news-card-content {
        flex: 1;
        color: #333;
        }

        .news-date {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        }

        .news-date i {
        color: #555;
        font-size: 1rem;
        }

        .news-date span {
        color: #3E7B27;
        font-weight: 600;
        }

        .news-title {
        font-size: clamp(1.1rem, 2vw, 1.4rem);
        font-weight: 600;
        color: #111;
        margin-bottom: 0.5rem;
        }

        .news-excerpt {
        font-size: clamp(0.9rem, 1.5vw, 1rem);
        color: #444;
        line-height: 1.6;
        margin-bottom: 1rem;
        }

        .read-more-btn {
        background: #3E7B27;
        color: white;
        padding: 8px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        }

        .read-more-btn:hover {
        background: #2e5d1c;
        }

        /* RESPONSIVE DESIGN */

        /* Tablet */
        @media (max-width: 992px) {
        .news-card {
            flex-direction: column;
            text-align: left;
        }

        .news-card-image {
            flex: 1 1 100%;
        }

        .news-card-image img {
            height: auto;
            border-radius: 10px;
        }

        .news-card-content {
            padding-top: 0.5rem;
        }
        }

        /* Mobile */
        @media (max-width: 600px) {
        .section-title {
            text-align: center;
            font-size: 1.6rem;
        }

        .news-card {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }

        .news-card-image {
            flex: 1 1 100%;
            border-radius: 8px;
        }

        .news-card-content {
            text-align: left;
        }

        .read-more-btn {
            font-size: 0.85rem;
            padding: 8px 15px;
        }

        .news-title {
            font-size: 1.1rem;
        }

        .news-excerpt {
            font-size: 0.9rem;
        }
        }


        /* Footer */
         /* Footer - Enhanced Responsiveness */
        .footer {
            background: linear-gradient(135deg, #333, #2c2c2c);
            color: white;
            padding: clamp(2rem, 5vw, 3rem) clamp(1rem, 3vw, 2rem) 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: clamp(2rem, 4vw, 3rem);
        }

        .footer-links h3,
        .footer-social h3,
        .footer-logo h3 {
            margin-bottom: 1rem;
            color: white;
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            font-weight: 600;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.3rem 0;
            display: inline-block;
            font-size: clamp(14px, 2.5vw, 16px);
        }

        .footer-links a:hover {
            color: white;
            padding-left: 0.5rem;
        }

        .footer-social p {
            color: #ccc;
            margin-bottom: 1rem;
            line-height: 1.6;
            font-size: clamp(14px, 2.5vw, 16px);
        }

        .social-icons a {
            font-size: clamp(1.3rem, 4vw, 1.6rem);
            color: #ccc;
            margin-right: 1rem;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: #00acee;
            transform: scale(1.2);
        }

        .footer-logo {
            text-align: center;
        }

        .footer-logo img {
            width: clamp(150px, 25vw, 250px);
            margin-top: 1rem;
            border-radius: 10px;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #555;
            color: #ccc;
            font-size: clamp(12px, 2vw, 14px);
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

        /* Responsive Design */
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
            
            .page-indicator {
                display: block;
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


            /* Always show hamburger button in all devices */
            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                font-size: 1.8rem;
                cursor: pointer;
                color: #333;
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


            /* Always show hamburger button in all devices */
            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                font-size: 1.8rem;
                cursor: pointer;
                color: #333;
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
            
            .news-item {
                flex-direction: column;
                gap: 0;
            }
            
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
                <!-- <div class="page-indicator" id="pageIndicator">Home</div> -->
                    <ul class="nav-menu" id="navMenu">
                        <li>
                            <a href="{{ route('landingpage') }}">Home</a>
                        </li>
                        <li class="dropdown-item">
                            <a href="#about" onclick="toggleDropdown(event, this.parentNode)">About <i class="fa-solid fa-chevron-down arrow"></i></a>
                            <div class="dropdown">
                                <a href="{{ url('about-us') }}">About Us</a>
                                <a href="{{ url('iccs-ips-rights') }}">ICCs/IPs Rights</a>
                            </div>
                        </li>
                

                        <li class="dropdown-item">
                            <a href="#program" onclick="toggleDropdown(event, this.parentNode)">
                                Program <i class="fa-solid fa-chevron-down arrow"></i>
                            </a>
                            <div class="dropdown">
                                <a href="{{ url('programs-pps') }}">Project, Programs & Services (PPS)</a>
                                <a href="{{ url('accomplishments') }}">Accomplishments</a>
                            </div>
                        </li>
                        <li><a href="{{ url('partnership') }}">Partnership</a></li>
                        <li><a href="{{ url('contacts') }}">Contact Us</a></li>
                        <li><a href="#news"class="active">News </a> </li>
                        <li class="mobile-login"><a href="{{ route('login') }}" class="login-btn">Login</a></li>
                    </ul>
                        <a href="{{ route('login') }}" class="login-btn desktop-login">Login</a>

            </div>
        </nav>

        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <div class="logo"></div>
                <div class="org-title">
                    <h1>NCIP Nueva Ecija Provincial Office</h1>
                    <p> News & Updates</p>
                </div>
            </div>
        </header>

          <!-- Page Title Section -->
        <div class="page-title">
            <div class="overlay">
                 <h2>News and Updates</h2>
                <p>Stay informed with the latest news, announcements, and updates from our indigenous communities across Nueva Ecija.</p>
            </div>
        </div>
        
  <!-- Main Content -->
<div class="container">

        <!-- News Section -->
        <section class="news-preview-section" id="news">
        <div class="section-wrapper">
            <div class="section-header">
            <h2 class="section-title">
                <span class="highlight-green">Latest</span> News & Updates
            </h2>
            </div>

            <div class="news-grid">
            @forelse($news as $item)
                @if($item->status === 'Published')
                <article class="news-card">
                <div class="news-card-image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                </div>

                <div class="news-card-content">
                    <div class="news-date">
                    <i class="fa-regular fa-calendar-days"></i>
                    {{ \Carbon\Carbon::parse($item->date)->format('F d, Y') }} /
                    <span>NCIP Nueva Ecija</span>
                    </div>

                    <h3 class="news-title">{{ $item->title }}</h3>
                    <p class="news-excerpt">
                    {{ Str::limit($item->description, 200, '...') }}
                    </p>

                    <a href="{{ route('news.show', $item->id) }}" class="read-more-btn">Read More</a>
                </div>
                </article>
                @endif
            @empty
                <p style="text-align:center; color:#555;">No news available at the moment.</p>
            @endforelse
            </div>
        </div>
        </section>

</div>


    <!-- Pagination -->
    <div style="margin-top: 25px;">
        {{ $news->links() }}
    </div>
</div>

            
        </section>
        </div>
        <!-- Footer -->
        <footer class="footer" id="contact">
        <div class="footer-content">
            <!-- Quick Links -->
            <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                 <li><a href="{{ route('landingpage') }}">Home</a></li>
                <li><a href="{{ url('about-us') }}">About Us</a></li>
                <li><a href="{{ url('iccs-ips-rights') }}">ICCs/IPs Rights</a></li>
                <li><a href="{{ url('programs-pps') }}">Programs, Projects & Services</a></li>
                <li><a href="{{ url('accomplishments') }}">Accomplishments</a></li>
                <li><a href="{{ url('partnership') }}">Partnership</a></li>
                <li><a href="{{ url('contacts') }}">Contact Us</a></li>
                <li><a href="{{ url('news') }}">News</a></li>
            </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-social">
            <h3>Connect With Us</h3>
            <p>Stay updated with our latest news and activities:</p>
            <div class="social-icons">
                <a href="https://facebook.com/NCIPNuevaEcija" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="viber://chat?number=+639176543210" target="_blank"><i class="fab fa-viber"></i></a>
                <a href="https://instagram.com/ncip_nuevaecija" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/639189876543" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href="https://t.me/NCIPNuevaEcija" target="_blank"><i class="fab fa-telegram-plane"></i></a>
            </div>
            </div>

            <!-- Logo Column -->
            <div class="footer-logo">
            <h3>NCIP NEPO</h3>
            <img src="{{ asset('content/IP_logo.jpg') }}" alt="NCIP NEPO Logo" />
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 National Commission on Indigenous Peoples - Nueva Ecija. All Rights Reserved.</p>
        </div>
        </footer>

    </div>

<script>
     // Toggle mobile menu
    function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        navMenu.classList.toggle('active');
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
