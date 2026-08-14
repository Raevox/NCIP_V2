<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accomplishments | NCIP Nueva Ecija</title>
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
background-size: contain; /* optional, depende sa layout */

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

        .section-title {
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 700;
            margin-bottom: clamp(10px, 2vw, 15px);
            color: #000000;
        }

        .section-title span {
            color: #3E7B27; 
        }
         .highlight-green {
            color: #3E7B27;
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
            background: url("{{ asset('content/banner-accomplishment.jpg') }}") no-repeat center center;
background-size: cover;

            filter: blur(5px);  
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

        /* Accomplishment Sections - Enhanced Responsiveness */
        .accomplishment-section {
            margin-bottom: clamp(2rem, 5vw, 4rem);
        }

        .accomplishment-container {
            max-width: 1250px;
            margin: 0 auto;
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1rem, 3vw, 2rem);
        }

        /* Layout 1: Left Image, Right Content */
        .accomplishment-1 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: clamp(1.5rem, 4vw, 3rem);
            align-items: center;
            background: white;
            padding: clamp(1.5rem, 4vw, 3rem);
            border-radius: 3px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .accomplishment-1 .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .accomplishment-1 img {
            width: 100%;
            height: clamp(200px, 30vw, 280px);
            object-fit: cover;
            transition: transform 0.3s ease;
        }

       

        .accomplishment-1 .content h2 {
            font-size: clamp(1.2rem, 3vw, 2.2rem);
            margin-bottom: clamp(0.8rem, 2vw, 1rem);
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            line-height: 1.3;
        }

        .accomplishment-1 .content .icon {
            color: #3E7B27;
            font-size: clamp(1.1rem, 2.5vw, 1.8rem);
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .accomplishment-1 .content .date {
            color: #666;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            margin-bottom: clamp(0.8rem, 1.5vw, 1rem);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .accomplishment-1 .content p {
            font-size: clamp(13px, 2.2vw, 16px);
            line-height: 1.7;
            color: #000000;
        }

                /* Layout 2: Right Image, Left Content */
        .accomplishment-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: clamp(1.5rem, 4vw, 3rem);
            align-items: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: clamp(1.5rem, 4vw, 3rem);
            border-radius: 10px;
        }

        .accomplishment-2 .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            max-height: 350px; /* para hindi masyadong mataas */
        }

        .accomplishment-2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;  /* para laging proportion kahit anong size */
            display: block;

        }

        .accomplishment-2 .content h2 {
            font-size: clamp(1.2rem, 3vw, 2.2rem);

            margin-bottom: clamp(0.8rem, 2vw, 1rem);
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            line-height: 1.3;
        }

        .accomplishment-2 .content .icon {
            color: #3E7B27;
            font-size: clamp(1.1rem, 2.5vw, 1.8rem);
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .accomplishment-2 .content .date {
            color: #666;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            margin-bottom: clamp(0.8rem, 1.5vw, 1rem);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .accomplishment-2 .content p {
            font-size: clamp(13px, 2.2vw, 16px);
            line-height: 1.7;
            color: #000000;
        }

        /* Layout 4: Card Style */
        .accomplishment-4 {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            overflow: hidden;
            padding: clamp(15px, 3vw, 20px);
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .accomplishment-4 .image-container {
            position: relative;
            min-height: clamp(200px, 35vw, 300px);
            max-height: clamp(300px, 45vw, 450px);
            overflow: hidden;
            padding: 0;
            border-radius: 10px;
        }

        .accomplishment-4 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .accomplishment-4 .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.7));
            display: flex;
            align-items: flex-end;
            padding: clamp(1rem, 3vw, 1.5rem);
        }

        .accomplishment-4 .overlay-date {
            color: white;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .accomplishment-4 .content {
            padding: clamp(1.5rem, 3vw, 2rem);
        }

        .accomplishment-4 .content h2 {
            font-size: clamp(1.1rem, 2.8vw, 1.8rem);
            margin-bottom: clamp(0.8rem, 1.5vw, 1rem);
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            line-height: 1.3;
        }

        .accomplishment-4 .content .icon {
            color: #3E7B27;
            font-size: clamp(1rem, 2.2vw, 1.5rem);
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .accomplishment-4 .content p {
            font-size: clamp(13px, 2.2vw, 15px);
            line-height: 1.7;
            color: #000000;
        }

        /* Layout 5: Two Column Grid */
        .accomplishment-5 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: clamp(1.5rem, 3vw, 2rem);
            background: white;
            padding: clamp(1.5rem, 4vw, 3rem);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .accomplishment-5 .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: clamp(0.8rem, 2vw, 1rem);
        }

        .accomplishment-5 .image-grid img {
            width: 100%;
            height: clamp(120px, 20vw, 200px);
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .accomplishment-5 .image-grid img:hover {
            transform: scale(1.05);
        }

        .accomplishment-5 .content h2 {
            font-size: clamp(1.2rem, 3vw, 2rem);

            margin-bottom: clamp(0.8rem, 2vw, 1rem);
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            line-height: 1.3;
        }


        .accomplishment-5 .content .date {
            color: #666;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            margin-bottom: clamp(0.8rem, 1.5vw, 1rem);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .accomplishment-5 .content p {
            font-size: clamp(13px, 2.2vw, 16px);
            line-height: 1.7;
            color: #000000;
        }

        /* Quote Section - Enhanced Responsiveness */
        .quote-title {
            position: relative;
            height: clamp(250px, 40vh, 480px);
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            overflow: hidden;
            margin-bottom: clamp(2rem, 4vw, 3rem);
        }

        .quote-title::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('content/quotebg.jpg') }}") no-repeat center center/cover;
            filter: blur(0px);
            z-index: 0;
        }

        .quote-title .overlay {
            position: relative;
            z-index: 1;
            padding: clamp(20px, 5vw, 40px);
            border-radius: 12px;
            max-width: 95%;
            background: rgba(0,0,0,0.45);
        }

        .quote-title h2 {
            font-size: clamp(1.5rem, 6vw, 3rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: clamp(1px, 0.3vw, 2px);
            color: #70e645;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
            margin-bottom: clamp(0.5rem, 2vw, 1rem);
        }

        .quote-title p {
            font-size: clamp(13px, 2.5vw, 18px);
            font-weight: 400;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto;
            color: #f8f9fa;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
            font-style: italic;
        }

        /* Year Section Headers */
        .year-section {
            margin-bottom: clamp(3rem, 6vw, 4rem);
        }

        .year-header {
            margin-bottom: clamp(2rem, 4vw, 3rem);
        }

        .year-title {
            font-size: clamp(2.4rem, 6vw, 3.2rem); 
            color: #3E7B27;
            font-weight: 800;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .year-subtitle {
            font-size: clamp(1.2rem, 3vw, 2rem); 
            color: #000000;
            text-align: center;
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

        /* Mobile Navigation */
        .mobile-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            color: #000000;
            cursor: pointer;
            z-index: 1001;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .mobile-close-btn:hover {
            background: #f8f9fa;
            color: #3E7B27;
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
                padding: 0 1.5rem;
            }

            .accomplishment-1,
            .accomplishment-2 {
                grid-template-columns: 1fr;
            }

            .accomplishment-2 .content {
                order: -1;
            }

            .accomplishment-5 .image-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Tablet and Mobile */
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
            
            /* Enhanced Mobile Navigation */
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
                backdrop-filter: blur(10px);
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
                font-size: 16px;
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
                background: #3E7B27;
                color: #fff !important;
                border-color: #3E7B27;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.95rem;
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            }

            /* Mobile Accomplishment Layouts */
            .accomplishment-1,
            .accomplishment-2,
            .accomplishment-5 {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: clamp(1rem, 3vw, 2rem);
            }

            .accomplishment-2 .content {
                order: -1;
            }

            .accomplishment-5 .image-grid {
                order: -1;
                grid-template-columns: 1fr;
            }

            .accomplishment-4 {
                padding: 15px;
            }

            .accomplishment-1 .content,
            .accomplishment-2 .content {
                padding: 0;
            }

            .accomplishment-2 .content h2,
            .accomplishment-2 .content .date,
            .accomplishment-2 .content p {
                padding-left: 0;
            }

            /* Footer mobile */
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: start;
            }
        }

        /* Mobile Phone Responsiveness */
        @media (max-width: 480px) {
            .container {
                padding: clamp(1rem, 3vw, 1.5rem) clamp(0.8rem, 2vw, 1rem);
            }

            .accomplishment-1,
            .accomplishment-2,
            .accomplishment-4,
            .accomplishment-5 {
                padding: clamp(1rem, 3vw, 1.5rem);
            }
            
            .nav-menu {
                width: 95%;
                left: 2.5%;
                right: 2.5%;
            }

            .accomplishment-5 .image-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Very Small Mobile */
        @media (max-width: 360px) {
            .Logo img {
                height: 30px;
                margin: 3px;
            }

            .Logo-text {
                font-size: 12px;
            }

            .nav-menu > li > a {
                padding: 0.8rem 1rem;
                font-size: 14px;
            }

            .page-title h2 {
                font-size: 1.3rem;
            }

            .page-title p {
                font-size: 12px;
            }

            .accomplishment-1 .content h2,
            .accomplishment-2 .content h2,
            .accomplishment-4 .content h2,
            .accomplishment-5 .content h2 {
                font-size: 1rem;
            }
        }

        /* Landscape phone optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .page-title {
                height: 200px;
            }
            
            .quote-title {
                height: 200px;
            }
            
            .header-container {
                flex-direction: row;
                gap: 1rem;
            }
        }

        /* Print styles */
        @media print {
            .nav-bar, 
            .mobile-menu-btn, 
            .login-btn {
                display: none;
            }
            
            .main-container {
                box-shadow: none;
            }

            .accomplishment-1,
            .accomplishment-2,
            .accomplishment-4,
            .accomplishment-5 {
                break-inside: avoid;
                margin-bottom: 2rem;
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
                              <a
                href="#accomplishments"
                class="active"
                onclick="toggleDropdown(event, this.parentNode)"
                >{{ __('Program') }} <i class="fa-solid fa-chevron-down arrow"></i
              ></a>
                            <div class="dropdown">
                                <a href="{{ url('programs-pps') }}">{{ __('Project, Programs & Services (PPS)') }}</a>
                                <a href="{{ url('accomplishments') }}">{{ __('Accomplishments') }}</a>
                            </div>
                        </li>
                        <li><a href="{{ url('partnership') }}">{{ __('Partnership') }}</a></li>
                        <li><a href="{{ url('contacts') }}">{{ __('Contact Us') }}</a></li>
                        <li><a href="{{ url('news') }}">{{ __('News') }}</a></li>
                        <li class="mobile-login"><a href="{{ route('login') }}" class="login-btn">{{ __('Login') }}</a></li>
                    </ul>
                        <div class="nav-actions">
                            <a href="{{ route('login') }}" class="login-btn desktop-login">{{ __('Login') }}</a>
                            <div class="lang-switcher-nav lang-switcher-desktop">
                                <button type="button" onclick="document.getElementById('navLangDropdownAccomplishments').classList.toggle('show')">
                                    <i class="fas fa-globe"></i> {{ app()->getLocale() === 'tl' ? 'Filipino' : 'English' }}
                                </button>
                                <div id="navLangDropdownAccomplishments" class="lang-dropdown-nav">
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
                    <p>{{ __('Accomplishments') }}</p>
                </div>
            </div>
        </header>

        <!-- Page Title Section -->
        <div class="page-title">
            <div class="overlay">
                <h2>{{ __('NCIP NEPO Accomplishments') }}</h2>
                <p>{{ __("Celebrating our achievements in protecting Indigenous Peoples' rights, preserving cultural heritage, and fostering community empowerment across Nueva Ecija.") }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            <!-- Dynamic Accomplishments -->
            @forelse($accomplishments as $item)
                <section class="accomplishment-section">

                    @php
                        $imgSrc = $item->image
                            ? (str_starts_with($item->image, 'content/')
                                ? asset($item->image)
                                : asset('storage/' . $item->image))
                            : '';
                    @endphp

                    @if($item->layout_type == 1)
                        {{-- Layout 1: Left image, right content --}}
                        <div class="accomplishment-1">
                            <div class="image-container">
                                <img src="{{ $imgSrc }}" alt="{{ $item->title }}">
                            </div>
                            <div class="content">
                                <h2 class="section-title">{{ $item->title }}</h2>
                                @if($item->date_label)
                                    <div class="date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $item->date_label }}
                                    </div>
                                @endif
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>

                    @elseif($item->layout_type == 2)
                        {{-- Layout 2: Right image, left content --}}
                        <div class="accomplishment-2">
                            <div class="content">
                                <h2 class="section-title">{{ $item->title }}</h2>
                                @if($item->date_label)
                                    <div class="date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $item->date_label }}
                                    </div>
                                @endif
                                <p>{{ $item->description }}</p>
                            </div>
                            <div class="image-container">
                                <img src="{{ $imgSrc }}" alt="{{ $item->title }}">
                            </div>
                        </div>

                    @elseif($item->layout_type == 4)
                        {{-- Layout 4: Card with date overlay --}}
                        <div class="accomplishment-4">
                            <div class="image-container">
                                <img src="{{ $imgSrc }}" alt="{{ $item->title }}">
                                @if($item->date_label)
                                    <div class="image-overlay">
                                        <div class="overlay-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $item->date_label }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                <h2 class="section-title">{{ $item->title }}</h2>
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>

                    @elseif($item->layout_type == 5)
                        {{-- Layout 5: Image grid + content --}}
                        @php
                            $gridImages = $item->extra_images ?? [$item->image];
                        @endphp
                        <div class="accomplishment-5">
                            <div class="image-grid">
                                @foreach($gridImages as $gi)
                                    @php
                                        $giSrc = str_starts_with($gi, 'content/')
                                            ? asset($gi)
                                            : asset('storage/' . $gi);
                                    @endphp
                                    <img src="{{ $giSrc }}" alt="{{ $item->title }}">
                                @endforeach
                            </div>
                            <div class="content">
                                <h2 class="section-title">{{ $item->title }}</h2>
                                @if($item->date_label)
                                    <div class="date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $item->date_label }}
                                    </div>
                                @endif
                                <p>{{ $item->description }}</p>
                            </div>
                        </div>
                    @endif

                </section>
            @empty
                <div style="text-align:center; padding: 4rem 2rem; color: #666;">
                    <i class="fas fa-trophy" style="font-size: 3rem; opacity: 0.2; display: block; margin-bottom: 1rem;"></i>
                    <p>{{ __('No accomplishments available at this time.') }}</p>
                </div>
            @endforelse

            <!-- Section Quote: Malasakit sa Katutubo -->
            <section class="quote-title">
                <div class="overlay">
                    <h2>{{ __('Malasakit sa Katutubo') }}</h2>
                    <p>
                        {{ __("\"If we take on responsibility, there's no reason for every indigenous peoples not to have a peaceful, healthy, developed, progressive, and empowered community where culture, rights, and heritage are respected and sustained for future generations.\"") }}
                    </p>
                    <p style="margin-top:1rem; font-weight:600; font-size:clamp(14px,2vw,18px); color:#ffd166;">
                        — NCIP NEPO
                    </p>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="footer" id="contact">
            <div class="footer-content">
               <!-- Quick Links -->
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

                <!-- Social Media -->
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

                <!-- Logo Column -->
                <div class="footer-logo">
                    <h3>NCIP NEPO</h3>
                    <img src="{{ asset('content/IP_logo.jpg') }}" alt="NCIP NEPO Logo" />
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
                document.getElementById('navLangDropdownAccomplishments')?.classList.remove('show');
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
