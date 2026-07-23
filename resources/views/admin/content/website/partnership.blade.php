<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | NCIP Nueva Ecija</title>
    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
            color: #222;
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
            color: #222;
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
            background: url("{{ asset('content/IP_logo.jpg') }}") no-repeat center;
            background-size: contain;
            flex-shrink: 0;
            border-radius: 3px;
        }
        
        .org-title h1 {
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            font-weight: 700;
            color: #222;
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
            background: url("{{ asset('content/partnership-banner.jpg') }}") no-repeat center center/cover;
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
            color: #f8f9fa;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6); 
        }


        /* Info Section - Enhanced Responsiveness */
        .info-section {
            background: #ffffff;
            border: 2px solid #e5e5e5;
            padding: clamp(20px, 5vw, 40px);
            border-radius: 12px;
            margin: clamp(20px, 4vw, 30px) auto;
            max-width: 1200px;
        }

        .info-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: clamp(20px, 4vw, 30px);
            flex-wrap: wrap;
        }

        .info-text {
            flex: 1;
            min-width: 0;
        }

        .info-text p {
            font-size: clamp(14px, 2.5vw, 16px);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 700;
            margin-bottom: clamp(10px, 2vw, 15px);
            color: #000000;
        }

        .section-title span {
            color: #3E7B27; 
        }

        .info-logo {
            flex-shrink: 0;
        }

        .info-logo img {
            max-width: clamp(120px, 20vw, 180px);
            border-radius: 12px;
            margin: 0 auto;
        }

        /* Partners Section - Fully Responsive */
        .partners-section {
            padding: clamp(30px, 6vw, 50px) clamp(10px, 3vw, 20px);
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            margin-bottom: clamp(2rem, 4vw, 3rem);
            width: 100%; 
            
        }

        .partners-section h2 {
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 600;
            margin-bottom: clamp(1rem, 3vw, 2rem);
            color: #000000;
            margin-top: clamp(20px, 4vw, 40px);
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(clamp(100px, 15vw, 150px), 1fr));
            gap: clamp(15px, 3vw, 25px);
            justify-items: center;
            align-items: center;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1rem;
            gap: 40px;
        }

        .partner-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: clamp(10px, 2.5vw, 20px);
            width: 100%;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin: 15px;
        }

        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .partner-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .partner-card:hover img {
            transform: scale(1.05);
        }

        /* Invitation Section - Enhanced Responsiveness */
        .invitation-wrapper {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            max-width: 100%;
            margin: clamp(2rem, 4vw, 3rem) auto;
            padding: 0 clamp(1rem, 3vw, 2rem);
        }
        .section-title {
        text-align: center;
        padding-top: 20px;
        }

        .invitation-wrapper .section-subtitle {
            font-size: clamp(14px, 2.2vw, 16px);
            color: #000000;
            max-width: 700px;
            margin: 0 auto clamp(1.5rem, 3vw, 2.5rem);
            line-height: 1.6;
            text-align: center;
            padding: 0 1rem;
            
        }

        .invitation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(250px, 40vw, 300px), 1fr));
            gap: clamp(1.5rem, 3vw, 2rem);
            margin-top: clamp(1.5rem, 3vw, 2rem);
        }

        .invitation-box {
            background: #fff;
            border-radius: 10px;
            padding: clamp(1.5rem, 4vw, 2rem);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #eee;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 20px;
        }

        .invitation-box:hover {
            border-color: #3E7B27;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(62, 123, 39, 0.15);
        }

        .invitation-box i {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            color: #3E7B27;
            margin-bottom: clamp(0.8rem, 2vw, 1rem);
            transition: color 0.3s ease;
        }

        .invitation-box:hover i {
            color: #2c5530;
        }

        .invitation-box h2 {
            font-size: clamp(1rem, 3vw, 1.4rem);
            color: #3E7B27;
            margin-bottom: clamp(0.5rem, 1.5vw, 0.8rem);
            font-weight: 600;
        }

        .invitation-box p {
            font-size: clamp(13px, 2.2vw, 16px);
            color: #000000;
            line-height: 1.6;
            text-align: left;
        }

        /* VMGO Section - Enhanced Responsiveness */
        .vmgo-section {
            background: #fff;
            border: 2px solid #e5e5e5;
            padding: clamp(25px, 5vw, 50px) clamp(15px, 3vw, 20px);
            border-radius: 10px;
            margin: clamp(30px, 5vw, 40px) auto;
            max-width: 1200px;
        }

        .intro {
            margin-bottom: clamp(15px, 3vw, 25px);
            font-size: clamp(14px, 2.5vw, 16px);
            line-height: 1.6;
        }

        .vmgo-box {
            margin-bottom: clamp(20px, 4vw, 30px);
        }

        .vmgo-box h3 {
            color: #3E7B27;
            margin-bottom: clamp(8px, 2vw, 10px);
            font-size: clamp(1rem, 3vw, 1.3rem);
        }

        .vmgo-box p {
            font-size: clamp(14px, 2.5vw, 16px);
            line-height: 1.6;
        }

        .vmgo-box ul {
            list-style: disc;
            padding-left: clamp(15px, 4vw, 20px);
        }

        .vmgo-box ul li {
            margin-bottom: clamp(6px, 1.5vw, 8px);
            line-height: 1.6;
            font-size: clamp(14px, 2.5vw, 16px);
        }

        .objective-group {
            margin-bottom: clamp(15px, 3vw, 20px);
        }

        .objective-group h4 {
            color: #2c662d;
            font-size: clamp(16px, 3vw, 18px);
            margin-bottom: clamp(6px, 1.5vw, 8px);
        }

        .objective-group ul {
            list-style: circle;
            padding-left: clamp(20px, 4vw, 25px);
        }

        .highlight-green {
            color: #3E7B27;
        }

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

        /* Mobile Navigation Improvements */
        .mobile-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: clamp(1.2rem, 3vw, 1.5rem);
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

        /* Enhanced Mobile Breakpoints */
        @media (max-width: 1024px) {
            .nav-container {
                padding: 0 1.5rem;
            }

            .info-container {
                flex-direction: column;
                text-align: center;
            }

            .partners-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 20px;
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
                top: 50%;
                transform: translateY(-50%);
            }
            
            .nav-container {
                flex-direction: column;
                align-items: stretch;
                position: relative;
                padding: 0;
                min-height: 60px;
            }
            
            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                width: 100%;
                background: rgba(255, 255, 255, 0.98);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 999;
                padding: 1rem;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-menu li {
                border-bottom: 1px solid #ddd;
                margin: 0.3rem 0;
                padding: 0.5rem 0;
            }

            .nav-menu li:last-child {
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

            .partners-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                max-width: 400px;
            }

            .invitation-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: start;
            }
        }

        @media (max-width: 480px) {
            .partners-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                max-width: 300px;
            }

            .partner-card {
                padding: 8px;
            }

            .container {
                padding: 1.5rem 0.8rem;
            }
        }

        @media (max-width: 360px) {
            .Logo img {
                height: 30px;
                margin: 3px;
            }

            .Logo-text {
                font-size: 12px;
            }

            .partners-grid {
                max-width: 280px;
                gap: 10px;
            }
        }

        /* Extra small screens and orientation changes */
        @media (max-width: 320px) {
            .partners-grid {
                grid-template-columns: 1fr 1fr;
                max-width: 260px;
            }
            
            .invitation-box {
                padding: 1rem;
            }
            
            .page-title h2 {
                font-size: 1.2rem;
            }
        }

        /* Landscape phone optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .page-title {
                height: 200px;
            }
            
            .header-container {
                flex-direction: row;
                gap: 1rem;
            }
        }

        /* Print styles */
        @media print {
            .nav-bar, .mobile-menu-btn, .login-btn {
                display: none;
            }
            
            .main-container {
                box-shadow: none;
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
                        <li>  <a href="#partnership"class="active">Partnership </a></li>
                        <li><a href="{{ url('contacts') }}">Contact Us</a></li>
                        <li><a href="{{ url('news') }}">News</a></li>
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
                    <p>I'M PART Inter-Agency/Indigenous Multi-Stakeholders Partnership</p>
                </div>
            </div>
        </header>

        <!-- Page Title Section -->
            <div class="page-title">
                <div class="overlay">
                    <h2>PARTNERSHIP</h2>
                    <p>A provincial whole of nation convergence in Nueva Ecija for Sustainable Development of ICCs/IPs</p>
                </div>
            </div>

        <!-- Main Content -->
        <div class="container">
            
            <!-- Section 1: I'M PART Logo -->
            <section class="info-section">
                <div class="info-container">
                    <div class="info-text">
                        <h2 class="section-title"> Inter-Agency/Indigenous Multi-Stakeholders Partnership <span>I'M PART</span></h2>
                        <p>
                            The I'M PART LOGO above simply showed in the center WILING TO BE PART (I'M PART) PEOPLE WORKING TOGETHER FROM THE THREE MAJOR MULTI-STAKEHOLDERS WITH ICCs/IPs (INDIGENOUS PEOPLES) as MAIN ACTORS OF THE PARTNERSHIP. This is because they are the very reason why I'M PART was organized because of their difficult and their poorest-of-the poor situations that needed to be responded urgently as a fulfillment of their four bundles of rights.
                        </p>
                    </div>
                    <div class="info-logo">
                       <img src="{{ asset('content/impart-logo.png') }}" alt="I'M PART Logo">

                    </div>
                </div>
            </section>

            <!-- Section 2: Brief Profile of I'M PART -->
            <section class="info-section">
                <div class="info-container">
                    <div class="info-text">
                        <h2 class="section-title">Brief Profile of <span>I'M PART</span></h2>
                        <p>
                            The Inter-Agency/Indigenous Multi-Stakeholders Partnership (I'M PART) is a
                            Provincial Whole-Of-Nation (WON) Council/Convergence in the Province of Nueva
                            Ecija. It was in May–September 2017 when the Indigenous Multi-Stakeholders
                            Partnership (I'M PART) of Nueva Ecija was conceptualized and operationalized by
                            Provincial Officer Dr. Donato B. Bumacas.
                        </p>
                        <p>
                            On October 29, 2021 was the formal launching of the Indigenous Multi-Stakeholders
                            Partnership (I'M PART) during the PADIT-SUBKAL FESTIVAL of Nueva Ecija held at
                            the NEUST Sumacab Campus, Cabanatuan City. This was attended by key officials
                            including PCOO Usec. Atty. Anna Marie Banaag, NCIP Commissioner Atty. Basilio A.
                            Wandag, NEUST President Engr. Feliciana P. Jacoba, and other provincial
                            government officers.
                        </p>
                        <p>
                            During the International Day of the World's Indigenous Peoples (August 9, 2021)
                            with the theme <b>"Leaving no one behind: Indigenous peoples and the call for a new
                            social contract"</b>, I'M PART was further enhanced to promote inclusivity. The
                            re-launching was celebrated on October 29, 2021 during the National IP Day and the
                            PADIT–SUBKAL FESTIVAL 2021 <b>"AMING TRIBO NOVO ECIJANO"</b>.
                        </p>
                    </div>
                </div>
            </section>
        </div>

            <!-- Partners Section -->
            <section class="partners-section">
                <h2 class="section-title">Our <span class="highlight-green"> Government Sector Partners</span></h2>
                <div class="partners-grid">
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-clsu.webp') }}" alt="CLSU Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-neust.png') }}" alt="NEUST Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-pia.png') }}" alt="PIA Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-philhealth.png') }}" alt="PhilHealth Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-doh.png') }}" alt="DOH Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-dilg.png') }}" alt="DILG Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-gov.ne.jpg') }}" alt="Government NE Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-muni-aliaga.png') }}" alt="Aliaga Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-muni-bongabon.jpg') }}" alt="Bongabon Partner">
                    </div>
                    <div class="partner-card">
                        <img src="{{ asset('content/ps-muni-cabanatuan.png') }}" alt="Cabanatuan Partner">
                    </div>

                </div>
              
                <h2 class="section-title">Our <span class="highlight-green"> Private/Business and Civil Society Organization Sector </span></h2>
                <div class="partners-grid">
                    <div class="partner-card">
                            <img src="{{ asset('content/ps-iped.png') }}" alt="IPED">
                        </div>
                        <div class="partner-card">
                            <img src="{{ asset('content/ps-KAMICYDI.png') }}" alt="KAMICYDI Partner">
                        </div>
                        <div class="partner-card">
                            <img src="{{ asset('content/ps-haribon.svg') }}" alt="Haribon Partner">
                        </div>
                        <div class="partner-card">
                            <img src="{{ asset('content/ps-katutubobg-novo.png') }}" alt="Katutubo NE Partner">
                        </div>
                            
                </div>
            </section>

            <!-- Section: I'M PART VMGO -->
             <div class="vgmo-container">
            <section class="vmgo-section">
                <div class="vmgo-container">
                    <h2 class="section-title">I'M PART <span>Vision, Mission, Goals & Objectives</span></h2>
                    <p class="intro">
                        The I'M PART vision, mission, goals and objectives (VMGO) are the following
                        anchored on the principles of public service by all the multi-stakeholders:
                    </p>

                    <!-- Vision -->
                    <div class="vmgo-box">
                        <h3>COMMON VISION</h3>
                        <p>
                            We aim for a resilient and sustainably developed ICCs/IPs in the Province of
                            Nueva Ecija through convergence of technical and financial resources by all
                            multi-stakeholders partners from the government sectors, private/business
                            sectors and civil society organizations.
                        </p>
                    </div>

                    <!-- Mission -->
                    <div class="vmgo-box">
                        <h3>COMMON MISSION</h3>
                        <p>
                            Our passion is to be a catalyst for a resilient and sustainable development of
                            ICCs/IPs in the Province of Nueva Ecija championing the principle of
                            <b>"Malasakit Katutubong Paglilingkod".</b>
                        </p>
                    </div>

                    <!-- Goals -->
                    <div class="vmgo-box">
                        <h3>COMMON GOALS</h3>
                        <ul>
                            <li><b>MEMBERSHIP:</b> Establish a broad membership from major multi-stakeholders from the government sectors, business/private sectors and civil society organizations;</li>
                            <li><b>PROVINCIAL COUNCIL/NETWORK:</b> Make I'M PART as an operational, functional and sustainable strong formal provincial council/network for a resilient and sustainable development of ICCs/IPs in Nueva Ecija;</li>
                            <li><b>PROGRAMS, PROJECTS AND SERVICES:</b> Each multi-stakeholders partners to implement programs, projects and services to ICCs/IPs in Nueva Ecija based on their legal mandates;</li>
                            <li><b>MANAGEMENT:</b> Establish an adaptive partnership/network knowledge management approach actively participated/involved by all multi-stakeholders partners.</li>
                        </ul>
                    </div>

                    <!-- Objectives -->
                    <div class="vmgo-box">
                        <h3>COMMON OBJECTIVES</h3>
                        <p>Specifically, the objectives are the following based on the above stated goals:</p>

                        <div class="objective-group">
                            <h4>1. MEMBERSHIP</h4>
                            <ul>
                                <li>Launch the Inter-Agency/Indigenous Multi-Stakeholders Partnership (I'M PART) on October 29, 2021;</li>
                                <li>Encourage potential and willing partners from the government sector, business/private sectors, and CSOs to fill up Membership Form, sign Memorandum of Agreement (MOA);</li>
                                <li>Award a Five Year Certificate of Partnership to partners who signed a MOA;</li>
                                <li>Continuously increase membership; and</li>
                                <li>Offer additional membership to willing and committed individuals.</li>
                            </ul>
                        </div>

                        <div class="objective-group">
                            <h4>2. PROVINCIAL COUNCIL/NETWORK</h4>
                            <ul>
                                <li>Advocate for the accreditation or establishment of I'M PART to be part of the Provincial Council of Nueva Ecija;</li>
                                <li>Advocate for the accreditation or establishment of I'M PART to be part of the City/Municipal Councils of each cities and municipalities of Nueva Ecija;</li>
                                <li>Register I'M PART as a formal Provincial Network of Multi-Stakeholders in the Province of Nueva Ecija at the DOLE or SEC; and</li>
                                <li>Establish an iVolunteer Network of individual members of I'M PART.</li>
                            </ul>
                        </div>

                        <div class="objective-group">
                            <h4>3. PROGRAMS, PROJECTS AND SERVICES</h4>
                            <ul>
                                <li>Check their mandated programs, projects and services as an agency or organization;</li>
                                <li>Each member of I'M PART to fill up Membership Form where their possible programs, projects and services are listed for ICCs/IPs in the Province of Nueva Ecija;</li>
                                <li>Commit programs, projects and services to I'M PART for specific ICCs/IPs in the Province of Nueva Ecija every year ready for implementation;</li>
                                <li>Implement, manage, and direct programs, projects and services to specific ICCs/IPs in the Province of Nueva Ecija every year; and</li>
                                <li>Conduct regular Monitoring, Learning, Evaluation and Reflection (MLER) every year.</li>
                            </ul>
                        </div>

                        <div class="objective-group">
                            <h4>4. MANAGEMENT</h4>
                            <ul>
                                <li>Design an adaptive partnership/network knowledge management approach framework and operations within 2021-2022;</li>
                                <li>Conduct Strategic Planning Workshop and come up with a 27-year I'M PART STRATEGIC PLAN which will become the basis of annual plan within 2022;</li>
                                <li>Conduct Annual Planning every 2nd Quarter (June) of each year for the finalization of plans for the upcoming fiscal year;</li>
                                <li>Implement the four functions of management every year: Planning, organizing/staffing, leading/directing, controlling e.g. regular MLER; and</li>
                                <li>Manage risks and sustainability plan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
             </div>

       <!-- Invitation Section -->
            <div class="invitation-wrapper">
                <h2 class="section-title">Be a <span class="highlight-green">Partner</span></h2>
                <p class="section-subtitle">
                    Partnering with NCIP NEPO means contributing to sustainable development, preserving cultural heritage, 
                    and creating more opportunities for Indigenous Peoples. Together, we can build a stronger, more inclusive future.
                </p>

                <div class="invitation-grid">
                    <!-- Box 1 -->
                    <div class="invitation-box">
                        <i class="fa-solid fa-people-group"></i>
                        <h2>Empower Indigenous Communities</h2>
                        <p>
                            By partnering with NCIP NEPO, you help strengthen the voices of Indigenous Peoples, ensuring they 
                            have access to resources, education, and opportunities for a brighter future.
                        </p>
                    </div>

                    <!-- Box 2 -->
                    <div class="invitation-box">
                        <i class="fa-solid fa-landmark"></i>
                        <h2>Preserve Culture and Heritage</h2>
                        <p>
                            Collaborating with us means playing a vital role in protecting traditions, practices, and cultural 
                            heritage of Indigenous Peoples, keeping their identity alive for generations to come.
                        </p>
                    </div>

                    <!-- Box 3 -->
                    <div class="invitation-box">
                        <i class="fa-solid fa-handshake-angle"></i>
                        <h2>Promote Inclusive Growth</h2>
                        <p>
                            Your partnership creates pathways for inclusive development, where Indigenous communities thrive 
                            alongside others, fostering equality, resilience, and shared progress.
                        </p>
                    </div>
                </div>
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
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            const icon = mobileBtn.querySelector('i');
            
            navMenu.classList.toggle('active');
            
            if (navMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
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
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-bars');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
