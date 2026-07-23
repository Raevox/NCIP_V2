<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICCs/IPs Rights | NCIP Nueva Ecija</title>
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
            background: url('/content/IP_logo.jpg') no-repeat center;
background-size: contain;
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
           background: url('/content/sagada.jpg') no-repeat center center;
background-size: cover;

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



        /* Rights Bundles Container */
        .rights-bundles {
            display: block;   /* stacked layout */
            margin-top: 2rem;
        }

        .rights-bundle {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            margin-bottom: 2rem; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .rights-bundle:hover {
            /* transform: translateY(-5px); */
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .bundle-header {
            background: linear-gradient(135deg, #3E7B27, #2c5530);
            color: #fff;
            padding: 1.5rem;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;

        }

        .bundle-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .bundle-header .bundle-number {
            background: rgba(255,255,255,0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 10px;
            font-size: 0.9rem;
            display: inline-block;
        }

        .bundle-content {
            padding: 2rem;
            max-height: none;
            overflow: visible;
        }


        .rights-list {
            list-style: none;
            counter-reset: rights-counter;
        }

        .rights-list li {
            counter-increment: rights-counter;
            position: relative;
            padding-left: 2.5rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .rights-list li:hover {
            background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
            border-radius: 8px;
        }
        .rights-list li:last-child {
            border-bottom: none;
        }

        .rights-list li::before {
            content: counter(rights-counter);
            position: absolute;
            left: 0;
            top: 0;
            background: #3E7B27;
            color: white;
            width: 1.8rem;
            height: 1.8rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .rights-list li strong {
            color: #2c5530;
            display: block;
            margin-bottom: 0.2rem;
            font-size: 18px;
        }

        .rights-list li p {
            color: #000000;
            font-size: 16px;
            line-height: 1.6;
        }


        /* Summary Section */
        .summary-section {
            background: linear-gradient(135deg, #3E7B27, #2c5530);
            border-radius: 12px;
            padding: 2rem;
            margin: 3rem 0;
            text-align: center;
            color: white;
        }

        .summary-section h3 {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .summary-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            display: block;
        }

        .stat-label {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
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

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .nav-container {
                padding: 0 1rem;
            }
            
            .rights-bundles {
                grid-template-columns: 1fr;
            }
            
            .footer {
                padding: 4rem 1.5rem;
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
            
            .container {
                padding: 2rem 1rem;
            }
            
            .page-title h2 {
                font-size: 2rem;
            }
            
            .rights-bundles {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .summary-stats {
                gap: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
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
            }/* Universal dropdown panel for all screen sizes */
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
        }

        @media (max-width: 480px) {
            .footer {
                padding: 3rem 1rem;
            }
            
            .nav-menu {
                width: 90%;
                right: 5%;
            }
            
            .header-container {
                padding: 0.5rem;
            }
            
            .rights-bundles {
                grid-template-columns: 1fr;
            }
            
            .bundle-content {
                padding: 1.5rem;
            }
            
            .summary-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
                       <li>
              <a
                href="#iccs_ips-rights"
                class="active"
                onclick="toggleDropdown(event, this.parentNode)"
                >About <i class="fa-solid fa-chevron-down arrow"></i
              ></a>
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
                    <p>ICCs/IPs Bundles of Rights and 36 Specific Rights</p>
                </div>
            </div>
        </header>
        
         <!-- Page Title Section -->
            <div class="page-title">
                <div class="overlay">
                    <h2>ICCs/IPs Rights Framework</h2>
                    <p>The Rights Framework is anchored on the Indigenous Peoples Rights Act of 1997 (R.A. 8371), ensuring that the voices and traditions of Indigenous Cultural Communities and Indigenous Peoples are recognized and protected.</p>
                </div>
            </div>

        <!-- Main Content -->
        <div class="container">

            <!-- Summary Section -->
            <div class="summary-section">
                <h3>Complete Rights Framework Overview</h3>
                <p>The Indigenous Peoples Rights Act (IPRA) establishes a comprehensive framework that recognizes and protects the rights of Indigenous Cultural Communities and Indigenous Peoples through four fundamental bundles of rights encompassing 36 specific rights.</p>
                
                <div class="summary-stats">
                    <div class="stat-item">
                        <span class="stat-number">4</span>
                        <span class="stat-label">Bundles of Rights</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">36</span>
                        <span class="stat-label">Specific Rights</span>
                    </div>
                </div>
            </div>

            <!-- Rights Bundles -->
            <div class="rights-bundles">
                <!-- Bundle 1: Ancestral Domain Rights -->
                <div class="rights-bundle">
                    <div class="bundle-header">
                        <div class="bundle-number">Bundle 1</div>
                        <h3>Rights to Ancestral Domains/Lands</h3>
                        <p>ICCs/IPs have the right to their ancestral domains, which include lands, waters, and natural resources that they have occupied since time immemorial.</p>
                    </div>
                    <div class="bundle-content">
                        <ol class="rights-list">
                            <li>
                                <strong>Right of ownership</strong>
                                <p>Full ownership rights over ancestral domains and lands with legal recognition and protection.</p>
                            </li>
                            <li>
                                <strong>Right to develop lands and natural resources</strong>
                                <p>Authority to develop and manage natural resources within ancestral territories according to traditional practices.</p>
                            </li>
                            <li>
                                <strong>Right to stay in territories</strong>
                                <p>Guaranteed right to remain and reside in ancestral lands without forced displacement.</p>
                            </li>
                            <li>
                                <strong>Right in case of displacement</strong>
                                <p>Rights to compensation, rehabilitation, and return in cases of involuntary displacement.</p>
                            </li>
                            <li>
                                <strong>Right to regulate entry of migrants</strong>
                                <p>Authority to control and regulate the entry of non-indigenous people into ancestral territories.</p>
                            </li>
                            <li>
                                <strong>Right to safe and clean air and water</strong>
                                <p>Environmental rights ensuring access to clean and safe natural resources.</p>
                            </li>
                            <li>
                                <strong>Right to claim parts of reservation (except those reserved and intended for common and public welfare and service)</strong>
                                <p>Ability to claim ancestral lands within government reservations (except those reserved for public welfare).</p>
                            </li>
                            <li>
                                <strong>Right to resolve conflict</strong>
                                <p>Authority to resolve disputes and conflicts using traditional justice systems and customary laws.</p>
                            </li>
                            <li>
                                <strong>Right to transfer land/property among members of the same ICCs/IPs, subject to customary laws and traditions of the community concerned</strong>
                                <p>Freedom to transfer land and property within the community according to customary laws.</p>
                            </li>
                            <li>
                                <strong>Right to redemption of all transferred to a non-IP</strong>
                                <p>Right to reclaim transferred lands when transfers were made under duress or unfair conditions.</p>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Bundle 2: Self-Governance Rights -->
                <div class="rights-bundle">
                    <div class="bundle-header">
                        <div class="bundle-number">Bundle 2</div>
                        <h3>Rights to Self-Governance and Empowerment</h3>
                        <p>The IPRA empowers ICCs/IPs to govern their own affairs and participate in local governance. </p>
                    </div>
                    <div class="bundle-content">
                        <ol class="rights-list" style="counter-reset: rights-counter 10;">
                            <li>
                                <strong>Authentication of Indigenous leadership titles</strong>
                                <p>Recognition and validation of traditional leadership structures and certificates of tribal membership.</p>
                            </li>
                            <li>
                                <strong>Recognition of socio-political institutions</strong>
                                <p>Formal recognition of indigenous political systems and traditional governance structures.</p>
                            </li>
                            <li>
                                <strong>Right to use traditional justice systems</strong>
                                <p>Authority to implement customary laws, conflict resolution mechanisms, and peace-building processes.</p>
                            </li>
                            <li>
                                <strong>Right to participate in decision-making</strong>
                                <p>Mandatory representation in policy-making bodies and local legislative councils affecting their communities.</p>
                            </li>
                            <li>
                                <strong>Right to determine development priorities</strong>
                                <p>Authority to set and decide priorities for community development initiatives and programs.</p>
                            </li>
                            <li>
                                <strong>Tribal barangays</strong>
                                <p>Right to form or constitute separate barangays in accordance with the Local Government Code.</p>
                            </li>
                            <li>
                                <strong>Right to organize and associate</strong>
                                <p>Freedom to form organizations and associations for collective action and representation.</p>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Bundle 3: Social Justice Rights -->
                <div class="rights-bundle">
                    <div class="bundle-header">
                        <div class="bundle-number">Bundle 3</div>
                        <h3>Social Justice & Human Rights</h3>
                        <p>The act aims to ensure social justice and human rights for ICCs/IPs, addressing historical injustices and promoting their economic and cultural well-being. </p>
                    </div>
                    <div class="bundle-content">
                        <ol class="rights-list" style="counter-reset: rights-counter 17;">
                            <li>
                                <strong>Equal protection and non-discrimination</strong>
                                <p>Constitutional guarantee of equal treatment and protection against all forms of discrimination.</p>
                            </li>
                            <li>
                                <strong>Rights during armed conflict</strong>
                                <p>Special protection and rights during times of armed conflict and military operations.</p>
                            </li>
                            <li>
                                <strong>Freedom from discrimination</strong>
                                <p>Right to equal opportunity and treatment in all aspects of life and governance.</p>
                            </li>
                            <li>
                                <strong>Right to basic services</strong>
                                <p>Access to essential government services including healthcare, education, and infrastructure.</p>
                            </li>
                            <li>
                                <strong>Rights of women</strong>
                                <p>Specific protections and rights for indigenous women including gender equality and empowerment.</p>
                            </li>
                            <li>
                                <strong>Rights of children and youth</strong>
                                <p>Special protection and rights for indigenous children and youth including education and welfare.</p>
                            </li>
                            <li>
                                <strong>Right to integrated system of education</strong>
                                <p>Access to culturally appropriate education that integrates indigenous knowledge systems.</p>
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Bundle 4: Cultural Integrity Rights -->
                <div class="rights-bundle">
                    <div class="bundle-header">
                        <div class="bundle-number">Bundle 4</div>
                        <h3>Rights to Cultural Integrity</h3>
                        <p>The state must respect and protect the rights of ICCs/IPs to preserve and develop their cultures and traditions.</p>
                    </div>
                    <div class="bundle-content">
                        <ol class="rights-list" style="counter-reset: rights-counter 24;">
                            <li>
                                <strong>Protection of indigenous culture and traditions</strong>
                                <p>Comprehensive protection of cultural practices, traditions, and institutions from external threats.</p>
                            </li>
                            <li>
                                <strong>Right to establish educational systems</strong>
                                <p>Authority to create and control indigenous educational and learning systems based on traditional knowledge.</p>
                            </li>
                            <li>
                                <strong>Recognition of cultural diversity</strong>
                                <p>Official recognition and respect for the diversity of indigenous cultures and practices.</p>
                            </li>
                            <li>
                                <strong>Recognition of customary laws</strong>
                                <p>Legal recognition of traditional laws and practices governing civil relations within communities.</p>
                            </li>
                            <li>
                                <strong>Right to name, identity and history</strong>
                                <p>Right to preserve and promote indigenous names, identity, and historical narratives.</p>
                            </li>
                            <li>
                                <strong>Protection of Community Intellectual Rights</strong>
                                <p>Protection of indigenous knowledge, innovations, and cultural expressions from unauthorized use.</p>
                            </li>
                            <li>
                                <strong>Rights to religious and cultural sites</strong>
                                <p>Protection and access to sacred places, burial grounds, and sites of religious significance.</p>
                            </li>
                            <li>
                                <strong>Rights to Indigenous Spiritual Beliefs</strong>
                                <p>Freedom to practice traditional spiritual beliefs and protection of sacred places and ceremonies.</p>
                            </li>
                            <li>
                                <strong>Right to indigenous knowledge systems</strong>
                                <p>Right to develop, practice, and protect traditional sciences and technologies.</p>
                            </li>
                            <li>
                                <strong>Protection of biological and genetic resources</strong>
                                <p>Control and protection of indigenous plant varieties and biological resources within ancestral territories.</p>
                            </li>
                            <li>
                                <strong>Right to sustainable agro-technological development</strong>
                                <p>Right to develop sustainable agricultural practices using traditional and modern technologies.</p>
                            </li>
                            <li>
                                <strong>Right to receive funds for archaeological sites</strong>
                                <p>Entitlement to funding for the preservation and maintenance of archaeological and historical sites.</p>
                            </li>
                        </ol>
                    </div>
                </div>
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
