<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Programs, Projects and Services | NCIP Nueva Ecija</title>
      <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"
      rel="stylesheet"
    />
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
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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
        content: "";
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
        background: #3e7b27;
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
        background: url("/content/IP_logo.jpg") no-repeat center center;
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
        background: url("/content/arts.jpg") no-repeat center center;
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

      /* Programs Grid */
      .programs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
      }

      /* Program Card */
      .program-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
      }

      .program-card:hover {
        /* transform: translateY(-8px); */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
      }

      .program-header {
        background: linear-gradient(135deg, #3e7b27, #2c5530);
        /* background-color: #e5e5e5; */
        color: #fff;
        padding: 2rem;
        text-align: center;
        position: relative;
      }

      .program-number {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 1rem;
        font-weight: 600;
      }

      .program-header h3 {
        font-size: 1.4rem;
        font-weight: 600;
        line-height: 1.3;
      }

      .program-content {
        padding: 2.5rem;
      }

      .sub-programs-list {
        list-style: none;
        counter-reset: sub-program-counter;
      }

      .sub-programs-list li {
        counter-increment: sub-program-counter;
        position: relative;
        padding: 1.5rem 0 1.5rem 4rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
      }

      .sub-programs-list li:last-child {
        border-bottom: none;
      }

      .sub-programs-list li::before {
        content: counter(sub-program-counter);
        position: absolute;
        left: 0;
        top: 1.5rem;
        background: linear-gradient(135deg, #3e7b27, #2c5530);
        color: white;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
      }

      .sub-programs-list li:hover {
        background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
        border-radius: 8px;
      }

      .sub-program-title {
        font-weight: 600;
        color: #2c5530;
        margin-bottom: 0.5rem;
        font-size: 18px;
      }

      .sub-program-description {
        color: #000000;
        font-size: 0.95rem;
        line-height: 1.6;
      }

      /* Partnership Section */
      .partnership-section {
        margin-top: 4rem;
        padding: 3rem 0;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
      }

      .partnership-section h3 {
        text-align: center;
        font-size: 2rem;
        color: #2c5530;
        margin-bottom: 2rem;
      }

      .partnership-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        padding: 0 3rem;
      }

      .partnership-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid #3e7b27;
      }

      .partnership-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      }

      .partnership-card h4 {
        color: #2c5530;
        font-size: 1.3rem;
        margin-bottom: 1rem;
        font-weight: 600;
      }

      .partnership-card p {
        color: #666;
        line-height: 1.6;
      }

      .partnership-card .partner-icon {
        font-size: 2rem;
        color: #3e7b27;
        margin-bottom: 1rem;
      }

      /* Statistics Section */
      .stats-section {
        background: linear-gradient(135deg, #2c5530, #3e7b27);
        color: white;
        padding: 3rem 2rem;
        margin: 3rem 0;
        border-radius: 15px;
        text-align: center;
      }

      .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
      }

      .stat-item {
        padding: 1rem;
      }

      .stat-number {
        font-size: 3rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.5rem;
      }

      .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
      }
      /* Footer */
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

        .programs-grid {
          grid-template-columns: 1fr;
        }

        .partnership-grid {
          padding: 0 2rem;
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

        .programs-grid {
          grid-template-columns: 1fr;
          gap: 1.5rem;
        }

        .partnership-grid {
          grid-template-columns: 1fr;
          padding: 0 1rem;
        }

        .partnership-section {
          margin: 2rem 0;
          padding: 2rem 0;
        }

        .stats-grid {
          grid-template-columns: repeat(2, 1fr);
          gap: 1rem;
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
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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
        } /* Universal dropdown panel for all screen sizes */
        .nav-menu {
          display: none;
          flex-direction: column;
          position: absolute;
          top: 60px; /* below header */
          right: 10px;
          width: 100%;
          max-width: 100%;
          background: rgba(255, 255, 255, 0.98);
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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

        .program-content {
          padding: 1.5rem;
        }

        .sub-programs-list li {
          padding-left: 3.5rem;
        }

        .sub-programs-list li::before {
          width: 2rem;
          height: 2rem;
          font-size: 0.9rem;
        }

        .stats-grid {
          grid-template-columns: 1fr;
        }

        .partnership-grid {
          grid-template-columns: 1fr;
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

      .program-card {
        animation: fadeInUp 0.6s ease-out;
      }

      .program-card:nth-child(1) {
        animation-delay: 0.1s;
      }
      .program-card:nth-child(2) {
        animation-delay: 0.2s;
      }
      .program-card:nth-child(3) {
        animation-delay: 0.3s;
      }
      .program-card:nth-child(4) {
        animation-delay: 0.4s;
      }
    </style>
  </head>
  <body>
    <div class="main-container">
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
                href="#programs-pps"
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
                                <button type="button" onclick="document.getElementById('navLangDropdownPps').classList.toggle('show')">
                                    <i class="fas fa-globe"></i> {{ app()->getLocale() === 'tl' ? 'Filipino' : 'English' }}
                                </button>
                                <div id="navLangDropdownPps" class="lang-dropdown-nav">
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
            <p>{{ __('Program, Projects & Services (PPS)') }}</p>
          </div>
        </div>
      </header>

      <!-- Page Title Section -->
      <div class="page-title">
        <div class="overlay">
          <h2>{{ __('NCIP Rights-Based Programs, Projects and Services') }}</h2>
          <p>{{ __('Comprehensive programs designed to protect and promote the rights of Indigenous Cultural Communities and Indigenous Peoples') }}</p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="container">
        <!-- Statistics Section -->
        <div class="stats-section">
          <h3>{{ __('Program Overview') }}</h3>
          <div class="stats-grid">
            <div class="stat-item">
              <span class="stat-number">4</span>
              <span class="stat-label">{{ __('Mandated Programs') }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">20+</span>
              <span class="stat-label">{{ __('Sub-Programs') }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">{{ __('Multiple') }}</span>
              <span class="stat-label">{{ __('Partnership Programs') }}</span>
            </div>
          </div>
        </div>

        <!-- Programs Grid -->
        <div class="programs-grid">
          <!-- Program 1: Rights to Ancestral Domains -->
          <div class="program-card">
            <div class="program-header">
              <div class="program-number">{{ __('Program 1') }}</div>
              <h3>{{ __('Rights to Ancestral Domains: Ancestral Domain And Land Security Development Program Services') }}</h3>
            </div>
            <div class="program-content">
              <ol class="sub-programs-list">
                <li>
                  <div class="sub-program-title">{{ __('Certificate of Ancestral Domain Title (CADT) Delineation, Registration and Recognition') }}</div>
                  <div class="sub-program-description">{{ __('Comprehensive mapping, documentation, and legal recognition of ancestral domains through proper surveying and titling processes.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Certificate of Ancestral Land Title (CALT) Delineation, Registration and Recognition') }}</div>
                  <div class="sub-program-description">{{ __('Individual ancestral land titling services ensuring legal ownership and protection of traditional lands.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Ancestral Domain Sustainable Development and Protection Plan (ADSDPP) Formulation Assistance') }}</div>
                  <div class="sub-program-description">{{ __('Technical assistance in developing sustainable management plans for ancestral domains balancing development and conservation.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Community Resources and Development Plan (CRDP) Formulation Assistance') }}</div>
                  <div class="sub-program-description">{{ __('Collaborative planning for community resource management and sustainable development initiatives.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Free Prior & Informed Consent (FPIC) Processes and MOA Facilitation') }}</div>
                  <div class="sub-program-description">{{ __('Ensuring proper consultation and consent processes for projects affecting ancestral domains and communities.') }}</div>
                </li>
              </ol>
            </div>
          </div>

          <!-- Program 2: Rights to Self-Governance -->
          <div class="program-card">
            <div class="program-header">
              <div class="program-number">{{ __('Program 2') }}</div>
              <h3>{{ __('Rights to Self-Governance and Empowerment: Indigenous Peoples Self-Governance, Empowerment and Protection Program Services') }}</h3>
            </div>
            <div class="program-content">
              <ol class="sub-programs-list">
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Participation and Representation (IPS, IPO, IPMR) Advocacy, Processing, and Installation') }}</div>
                  <div class="sub-program-description">{{ __('Supporting indigenous participation in governance through Indigenous Peoples Senators, Organizations, and Mandatory Representatives.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Establishment and Maintenance of Ancestral Domain Management Office (ADMO)') }}</div>
                  <div class="sub-program-description">{{ __('Creating and supporting local offices for effective ancestral domain management and governance.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Ancestral Domain Defense System (ADDS) Security Establishment') }}</div>
                  <div class="sub-program-description">{{ __('Developing community-based security systems to protect ancestral domains from encroachment and illegal activities.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Legal Assistance (IPLA)') }}</div>
                  <div class="sub-program-description">{{ __('Providing legal support and representation for indigenous peoples in various legal matters and disputes.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Adjudication Services') }}</div>
                  <div class="sub-program-description">{{ __('Traditional and formal dispute resolution services respecting customary laws and practices.') }}</div>
                </li>
              </ol>
            </div>
          </div>

          <!-- Program 3: Rights to Social Justice -->
          <div class="program-card">
            <div class="program-header">
              <div class="program-number">{{ __('Program 3') }}</div>
              <h3>{{ __('Rights to Social Justice and Human Rights: Indigenous Peoples-Based Socio-Economic Development, Environmental and Human Rights Program Services') }}</h3>
            </div>
            <div class="program-content">
              <ol class="sub-programs-list">
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Economic Development and Cooperative Program') }}</div>
                  <div class="sub-program-description">{{ __('Supporting economic empowerment through cooperative development, livelihood programs, and sustainable enterprise initiatives.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Disaster Risks, Climate Change, and Environmental Protection Project') }}</div>
                  <div class="sub-program-description">{{ __('Building resilience against disasters and climate change while promoting environmental conservation and protection.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Education and Advocacy (IP EAP) Project') }}</div>
                  <div class="sub-program-description">{{ __("Promoting culturally appropriate education programs and advocacy for indigenous peoples' educational rights.") }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Emergency Medical and Financial Assistance') }}</div>
                  <div class="sub-program-description">{{ __('Providing immediate medical and financial support during emergencies and critical situations affecting indigenous communities.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Rights Advocacy, Monitoring Treaty Obligations Project') }}</div>
                  <div class="sub-program-description">{{ __('Monitoring implementation of indigenous rights and ensuring compliance with national and international obligations.') }}</div>
                </li>
              </ol>
            </div>
          </div>

          <!-- Program 4: Rights to Cultural Integrity -->
          <div class="program-card">
            <div class="program-header">
              <div class="program-number">{{ __('Program 4') }}</div>
              <h3>{{ __('Rights to Cultural Integrity: Indigenous Peoples Culture Program Services') }}</h3>
            </div>
            <div class="program-content">
              <ol class="sub-programs-list">
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Research and Documentation Project') }}</div>
                  <div class="sub-program-description">{{ __('Supporting economic empowerment through cooperative development, livelihood programs, and sustainable enterprise initiatives.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Cultural Advocacy and Intergeneration Project') }}</div>
                  <div class="sub-program-description">{{ __('Building resilience against disasters and climate change while promoting environmental conservation and protection.') }}</div>
                </li>
                <li>
                  <div class="sub-program-title">{{ __('Indigenous Peoples Cultural Protection Project') }}</div>
                  <div class="sub-program-description">{{ __("Promoting culturally appropriate education programs and advocacy for indigenous peoples' educational rights.") }}</div>
                </li>
              </ol>
            </div>
          </div>
        </div>
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
              <a href="https://facebook.com/NCIPNuevaEcija" target="_blank"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a href="viber://chat?number=+639176543210" target="_blank"
                ><i class="fab fa-viber"></i
              ></a>
              <a href="https://instagram.com/ncip_nuevaecija" target="_blank"
                ><i class="fab fa-instagram"></i
              ></a>
              <a href="https://wa.me/639189876543" target="_blank"
                ><i class="fab fa-whatsapp"></i
              ></a>
              <a href="https://t.me/NCIPNuevaEcija" target="_blank"
                ><i class="fab fa-telegram-plane"></i
              ></a>
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
        const navMenu = document.getElementById("navMenu");
        navMenu.classList.toggle("active");
      }

      // Toggle dropdown in mobile view only
      function toggleDropdown(event, parent) {
        if (window.innerWidth <= 768) {
          event.preventDefault();
          const dropdown = parent.querySelector(".dropdown");
          dropdown.classList.toggle("active");
          const arrow = parent.querySelector(".arrow");
          arrow.style.transform = dropdown.classList.contains("active")
            ? "rotate(180deg)"
            : "rotate(0deg)";
        }
      }

      document.addEventListener("click", function (event) {
        if (!event.target.closest('.lang-switcher-nav')) {
          document.getElementById('navLangDropdownPps')?.classList.remove('show');
        }
      });

      // Close menu when clicking outside
      document.addEventListener("click", function (event) {
        const navMenu = document.getElementById("navMenu");
        const mobileBtn = document.querySelector(".mobile-menu-btn");
        const icon = mobileBtn.querySelector("i");

        if (
          !navMenu.contains(event.target) &&
          !mobileBtn.contains(event.target)
        ) {
          if (navMenu.classList.contains("active")) {
            navMenu.classList.remove("active");
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars");
          }
        }
      });

      // Reset menu on window resize
      window.addEventListener("resize", function () {
        const navMenu = document.getElementById("navMenu");
        const mobileBtn = document.querySelector(".mobile-menu-btn");
        const icon = mobileBtn.querySelector("i");

        if (window.innerWidth > 768 && navMenu.classList.contains("active")) {
          navMenu.classList.remove("active");
          icon.classList.remove("fa-times");
          icon.classList.add("fa-bars");
        }
      });
    </script>
  </body>
</html>
