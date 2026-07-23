<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | NCIP Nueva Ecija</title>
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
            background: url('../content/old-capitol.jpg') no-repeat center center/cover;
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

        /*Get in touchh*/
        .contact-wrapper {
        padding: 2rem 1rem;
        }

        .contact-container {
        max-width: 800px;
        margin: 0 auto;
        }

        .contact-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
        background: #fff;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-radius: 10px;
        }


        .contact-container p {
        margin-bottom: 2rem;
        color: #222;
        }

        .contact-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        }

        .form-group {
        display: flex;
        flex-direction: column;
        }

        .form-group.full-width {
        grid-column: span 2;
        }

        .input-icon {
        position: relative;
        }

        .input-icon i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #3E7B27;
        }

        .input-icon input {
        width: 100%;
        padding: 0.8rem 0.8rem 0.8rem 2.5rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
        }

        textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
        }

        input:focus, textarea:focus {
        border-color: #3E7B27;
        box-shadow: 0 0 0 2px rgba(10, 47, 53, 0.1);
        }

        .submit-btn {
        grid-column: span 2;
        background: #3E7B27;
        color: white;
        border: none;
        padding: 0.9rem;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        }

        .submit-btn:hover {
        background: linear-gradient(135deg, #2c5530, #1a3d1f);
        }

        /* Office Information */
        .office-info-section {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin: 3rem 0;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .section-header {
            background: linear-gradient(135deg, #3E7B27, #2c5530);
            color: white;
            padding: 2rem;
            text-align: center;
        }

    
        .section-header i {
            font-size: 24px;
            opacity: 0.9;
            margin: 5px;
            margin-bottom: 3px;
        }

        .section-header h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .section-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Contact Items - Horizontal List Layout */
        .contact-items-grid {
            padding: 3rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-item:hover {
            background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
            padding-left: 1rem;
            border-radius: 8px;
        }

        .contact-icon {
            background: linear-gradient(135deg, #3E7B27, #2c5530);
            color: white;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-details {
            flex: 1;
        }

        .contact-label {
            font-weight: 700;
            color: #2c5530;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .contact-value {
            color: #666;
            font-size: 1rem;
            line-height: 1.5;
        }

        .contact-value a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-value a:hover {
            color: #3E7B27;
            font-weight: 600;
        }
       
        /* Send button */
        @media (min-width: 992px) {
        .submit-btn {
            width: 40%;
            justify-self: center;
            font-size: 0.95rem;
            padding: 0.7rem 1.2rem;
        }
        }

        @media (min-width: 768px) and (max-width: 991px) {
        .submit-btn {
            width: 60%;
            justify-self: center;
            font-size: 1rem;
            padding: 0.8rem 1.5rem;
        }
        }

        @media (max-width: 767px) {
        .submit-btn {
            width: 100%;
        }
        }

        @media (max-width: 768px) {
        .contact-form {
            grid-template-columns: 1fr !important;
            gap: 1rem;
        }

        .form-group,
        .form-group.full-width {
            grid-column: 1 !important;
            width: 100%;
        }

        .input-icon input,
        textarea {
            font-size: 1rem;
            padding: 0.9rem 0.9rem 0.9rem 2.6rem;
        }

        .input-icon i {
            left: 10px;
            font-size: 1rem;
        }

        .contact-container {
            padding: 1.5rem;
        }

        .submit-btn {
            grid-column: 1 !important;
            width: 100%;
            font-size: 1.05rem;
        }

        .contact-container h2 {
            font-size: 1.6rem;
        }

        .contact-container p {
            font-size: 1rem;
        }
        }

        @media (max-width: 480px) {
        .contact-container {
            padding: 1rem;
        }

        .input-icon input,
        textarea {
            font-size: 0.95rem;
            padding: 0.8rem 0.8rem 0.8rem 2.4rem;
        }

        .input-icon i {
            font-size: 0.9rem;
        }

        .submit-btn {
            font-size: 1rem;
            padding: 0.8rem;
        }
        }


        /* Office Hours */
        .hours-section {
            background: linear-gradient(135deg, #2c5530, #3E7B27);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            margin: 3rem 0;
        }

        .hours-section h3 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .hours-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .hours-item {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .hours-day {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .hours-time {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Map Section */
        .map-section {
            margin: 3rem 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        .map-header {
            background: linear-gradient(135deg, #3E7B27, #2c5530);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .map-header h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .map-content {
            padding: 3rem;
        }

        .map-placeholder {
            background: #f8f9fa;
            height: 400px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.2rem;
            border: 2px dashed #ddd;
            flex-direction: column;
            gap: 1rem;
        }

        .map-placeholder i {
            font-size: 4rem;
            color: #3E7B27;
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
            
            .contact-items-grid {
                padding: 1.5rem;
            }
            
            .contact-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
                padding: 1rem 0;
            }
            
            
            .hours-content {
                grid-template-columns: 1fr;
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
            
            .contact-items-grid {
                padding: 1rem;
            }
            
            .contact-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
        
        /* Alert Styles - IDAGDAG SA STYLE SECTION */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-weight: 500;
        border-left: 4px solid;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left-color: #28a745;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border-left-color: #dc3545;
    }

    .alert i {
        margin-right: 0.5rem;
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
                        <li><a href="#contacts"class="active">Contact Us </a></li>
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
                    <p>Contact Us</p>
                </div>
            </div>
        </header>

        <!-- Page Title Section -->
        <div class="page-title">
            <div class="overlay">
                <h2>Get In Touch With Us</h2>
                <p>We're here to serve and assist Indigenous Cultural Communities and Indigenous Peoples</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">

        <!-- Contact Form -->
        <div class="contact-wrapper">
            <div class="contact-container">
                <h2>Get In Touch</h2>
                <p>We welcome inquiries from individuals, organizations, and government agencies interested in supporting indigenous communities and cultural preservation efforts.</p>

            @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-icon">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" placeholder="Full Name" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-icon">
                <i class="fas fa-phone"></i>
                <input type="tel" id="phone" name="phone" placeholder="+63 912 345 6789">
            </div>
        </div>
        
        <div class="form-group">
            <label for="subject">Subject</label>
            <div class="input-icon">
                <i class="fas fa-file"></i>
                <input type="text" id="subject" name="subject" placeholder="What's this about?">
            </div>
        </div>

        <div class="form-group full-width">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="6" placeholder="Write your message..." required></textarea>
        </div>

        <button type="submit" class="submit-btn">
            Send <i class="fas fa-paper-plane"></i>
        </button>
    </form>
            </div>
            </div>
                    
            <!-- Office Information Section -->
            <div class="office-info-section">
                <div class="section-header">
                    <h3><i class="fas fa-building"></i>Office Information </i></h3>
                    <p>Complete contact details and location information</p>
                </div>
                <div class="contact-items-grid">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Physical Address</div>
                            <div class="contact-value">
                                NCIP Nueva Ecija Provincial Office<br>
                                1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, 3100 Nueva Ecija, Philippines
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Telephone Numbers</div>
                            <div class="contact-value">
                                <a href="tel:+63449792365">(044) 979-2365</a><br>

                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Mobile Numbers</div>
                            <div class="contact-value">
                                <a href="tel:+639176543210">+63 9123456789</a><br>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Email Address</div>
                            <div class="contact-value">
                                <a href="mailto:ncip.nuevaecija@gmail.com">ncip.nuevaecija@gmail.com</a><br>
                                <a href="mailto:info.ncipne@gov.ph">info.ncipne@gov.ph</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Office Hours Section -->
            <div class="hours-section">
                <h3><i class="fas fa-clock"></i> Office Hours & Services</h3>
                <div class="hours-content">
                    <div class="hours-item">
                        <div class="hours-day">Monday - Friday</div>
                        <div class="hours-time">8:00 AM - 5:00 PM</div>
                    </div>
                    
                    <div class="hours-item">
                        <div class="hours-day">Saturday</div>
                        <div class="hours-time">8:00 AM - 12:00 PM<br></div>
                    </div>
                    
                </div>
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <div class="map-header">
                    <h3><i class="fas fa-map"></i> Find Our Location</h3>
                    <p>Visit us at our office in Burgos Avenue, Old Capitol, Cabanatuan City, Nueva Ecija</p>
                </div>
                <div class="map-content">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3844.896612714691!2d120.96425118147884!3d15.489992346712429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33972921247092db%3A0xc8dc5a5d38a06429!2sBahay%20-%20Pamahalaan%20Lalawigan%20ng%20Nueva%20Ecija!5e0!3m2!1sen!2sph!4v1758167818131!5m2!1sen!2sph" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
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
