<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us | NCIP Nueva Ecija</title>
      <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
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
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        min-height: 100vh;
      }
      /* Navigation */
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
        background: url("{{ asset('content/banner1.jpg') }}") no-repeat center center/cover;
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

      /* Intro Section */
      .intro-section {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 4rem;
      }

      .intro-container {
        display: flex;
        align-items: center;
        gap: 3rem;
      }

      .intro-text {
        flex: 1;
      }

      .intro-text h3 {
        font-size: 2rem;
        color: #2c5530;
        margin-bottom: 1rem;
        font-weight: 700;
      }

      .intro-text p {
        font-size: 16px;
        color: #000000;
        line-height: 1.7;
      }

      .intro-logo {
        width: 200px;
        height: 200px;
        background: url("{{ asset('content/IP_logo.jpg') }}") no-repeat center;
        background-size: contain;
        flex-shrink: 0;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      }

      /* Content Sections */
      .content-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 3rem;
        border: 1px solid #e9ecef;
      }

      .section-header {
        background: linear-gradient(135deg, #3e7b27, #2c5530);
        color: white;
        padding: 1rem;
        text-align: center;
        position: relative;
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
        font-size: 1rem;
        opacity: 0.9;
      }

      .section-content {
        padding: 2.5rem;
      }

      /* VMGO Cards */
      .vmgo-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
      }

      .vmgo-card {
        border: 2px solid #e5e5e5;
        border-radius: 10px;
        padding: 2rem;
        background-color: #fff;
      }

      .vmgo-card h4 {
        color: #2c5530;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
      }

      .vmgo-card i {
        color: #3e7b27;
        font-size: 1.5rem;
      }

      .vmgo-card p {
        font-size: 16px;
        color: #000000;
        line-height: 1.6;
      }

      .vmgo-card ul {
        color: #000000;
        line-height: 1.6;
        font-size: 16px;
        margin-left: 1rem;
      }

      .vmgo-card li {
        margin-bottom: 0.5rem;
        position: relative;
      }

    /* Ip and Muni*/
    .ip-group,
    .municipality-group {
      background: #fff;
      border-radius: 12px;
      border: 1px solid #e9ecef;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
      margin-bottom: 2.5rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .ip-group:hover,
    .municipality-group:hover {
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.1);
    }

    /* ===== Header Styles ===== */
    .ip-header,
    .municipality-header {
      background: linear-gradient(135deg, #3E7B27, #2c5530);
      color: #fff;
      text-align: center;
      padding: 1.8rem 1rem;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .ip-header h3,
    .municipality-header h3 {
      font-size: clamp(1.4rem, 2.5vw, 1.8rem);
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .ip-header i,
    .municipality-header i {
      font-size: clamp(1.2rem, 2vw, 1.6rem);
    }

    .ip-subtitle,
    .municipality-subtitle {
      display: block;
      margin-top: 0.5rem;
      font-size: clamp(0.85rem, 1.8vw, 1rem);
      padding: 0.3rem 0.8rem;
      border-radius: 10px;
    }

    /* ===== IP GROUP STYLING ===== */
    .ip-content {
      padding: 2rem;
    }

    .ip-list {
      list-style: none;
      counter-reset: ip-counter;
      columns: 2;
      column-gap: 3rem;
      padding-left: 0;

    }

    .ip-list li {
      counter-increment: ip-counter;
      position: relative;
      padding-left: 2.8rem;
      margin-bottom: 1rem;
      /* border-bottom: 1px solid #f0f0f0; */
      font-size: clamp(0.95rem, 2vw, 1rem);
      color: #000;
      line-height: 1.6;
      transition: background 0.3s ease, transform 0.2s ease;
      break-inside: avoid;
      
    }

    .ip-list li:hover {
      background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
      border-radius: 8px;
      transform: translateX(4px);
    }

    .ip-list li::before {
      content: counter(ip-counter);
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%); 
      background: #3E7B27;
      color: white;
      width: 1.6rem;
      height: 1.6rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 12px;
      line-height: 1;
    }

    /* Municipality Section*/
    .municipality-content {
      padding: 2rem;
    }

    .municipality-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .municipality-column h4 {
      font-size: clamp(1.1rem, 2.2vw, 1.3rem);
      font-weight: 600;
      color: #2c5530;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .municipality-list {
      list-style: none;
      padding-left: 0;
    }

    /* Use data-letter attribute to show first letter */
    .municipality-list li {
      position: relative;
      padding-left: 2.8rem;
      margin-bottom: 1rem;
      /* border-bottom: 1px solid #f0f0f0; */
      font-size: clamp(0.95rem, 2vw, 1rem);
      color: #000;
      line-height: 1.6;
      transition: background 0.3s ease, transform 0.2s ease;
      ;
    }

    .municipality-list li:hover {
      background: linear-gradient(135deg, #f8f9fa, #e8f5e8);
      border-radius: 8px;
      transform: translateX(4px);
    }

      .municipality-list li::before {
      content: attr(data-letter);
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%); 
      background: #3E7B27;
      color: white;
      width: 1.6rem;
      height: 1.6rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 12px;
      line-height: 1;
    }

    /* ===== Responsive Design ===== */
    @media (max-width: 900px) {
      .ip-list {
        columns: 1;
      }
    }

    @media (max-width: 768px) {
      .ip-content,
      .municipality-content {
        padding: 1.5rem;
      }

      .municipality-grid {
        grid-template-columns: 1fr;
      }

      .ip-list li,
      .municipality-list li {
        padding-left: 2.3rem;
        font-size: 0.95rem;
      }
    }

    @media (max-width: 480px) {
      .ip-header h3,
      .municipality-header h3 {
        flex-direction: column;
        text-align: center;
      }

      .ip-content,
      .municipality-content {
        padding: 1.2rem;
      }

      .ip-list li,
      .municipality-list li {
        font-size: 0.9rem;
      }
    }


    /* FAQ Section */
    .faq-section {
      background: #ffffff !important;
      border-radius: 0% !important;
    }
  /* FAQ Title Styling */
  .faq-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    color: #222; 
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    text-align: center;
    margin-bottom: 0.5rem;
    animation: fadeInUp 1s ease-in-out;
  }

  .highlight-green {
    color: #3e7b27;
  }

  .faq-title i {
    color: #3e7b27;
    font-size: clamp(1.6rem, 3vw, 2.3rem);
    transition: transform 0.3s ease, color 0.3s ease;
  }

  .faq-title:hover i {
    transform: rotate(10deg);
    color: #2c5530;
  }

  /* Tagline under the title */
  .faq-tagline {
    font-size: clamp(0.9rem, 2vw, 1.1rem);
    color: #555;
    max-width: 900px;
    margin: 0 auto 2rem;
    line-height: 1.6;
    text-align: center;
    animation: fadeInUp 1.2s ease-in-out;
  }

  /* Fade-in animation */
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

  /* Responsiveness Enhancements */
  @media (max-width: 768px) {
    .faq-title {
      font-size: clamp(1.5rem, 4vw, 2rem);
      gap: 6px;
    }

    .faq-title i {
      font-size: clamp(1.4rem, 4vw, 2rem);
    }

    .faq-tagline {
      font-size: clamp(0.85rem, 2.5vw, 1rem);
      padding: 0 1rem;
    }
  }

  @media (max-width: 480px) {
    .faq-title {
      flex-direction: column;
      gap: 5px;
    }

    .faq-tagline {
      font-size: 0.9rem;
    }
  }

      .faq-section .section-header {
        color: #000000;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 2rem 1rem;
      }

      .faq-section .section-header h3 {
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        margin-bottom: 0.5rem;
      }

      .faq-section .section-header p {
        font-size: clamp(0.9rem, 2vw, 1.1rem);
            color: #222;
      }

      .faq-container {
        margin: 2rem auto;
        max-width: 900px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .faq-item {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 2px solid #3e7b27;
      
      }

      .faq-item:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
      }

      .faq-question {
        width: 100%;
        background: #ffffff;
        color: #000000;
        border: none;
        text-align: left;
        font-weight: 500;
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        padding: 1.2rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }

      .faq-question:hover {
        background: #f4f4f4;
      }


      .faq-answer {
        max-height: 0;
        overflow: hidden;
        padding: 0 1.5rem;
        transition: all 0.4s ease;
        text-align: left;
      }

      .faq-answer p,
      .faq-answer li {
        font-size: clamp(0.9rem, 2.3vw, 1rem);
        color: #333;
        line-height: 1.6;
      }

      .faq-answer ul {
        list-style-type: disc;
        margin-left: 2rem;
        margin-bottom: 1rem;
      }

      .faq-item.active .faq-answer {
        max-height: 1000px;
        padding: 1rem 1.5rem;
      }

      .faq-item.active .arrow {
        transform: rotate(180deg);
      }

      @media (max-width: 768px) {
        .faq-container {
          padding: 0 1rem;
        }
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

        .intro-container {
          flex-direction: column;
          text-align: center;
          gap: 2rem;
        }

        .municipalities-grid {
          grid-template-columns: 1fr;
        }

        .iccs-ips-grid {
          grid-template-columns: repeat(2, 1fr);
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

        .intro-section {
          padding: 2rem 1rem;
        }

        .section-content {
          padding: 1.5rem;
        }

        .iccs-ips-grid {
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

        /* Universal dropdown panel  */
        .nav-menu {
          display: none;
          flex-direction: column;
          position: absolute;
          top: 60px;
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

        .intro-section {
          padding: 1.5rem;
        }

        .vmgo-card,
        .municipality-column {
          padding: 1.5rem;
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
              <a href="#about" class="active" onclick="toggleDropdown(event, this.parentNode)">
                About <i class="fa-solid fa-chevron-down arrow"></i>
              </a>
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
            <p>About Us</p>
          </div>
        </div>
      </header>

      <!-- Page Title Section -->
      <div class="page-title">
        <div class="overlay">
          <h2>About NCIP Nueva Ecija</h2>
          <p>
            Mandate, Vision, Mission, Goals & Objectives and the Indigenous
            Communities we serve
          </p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="container">
        <!-- Intro Section -->
        <div class="intro-section">
          <div class="intro-container">
            <div class="intro-text">
              <h3>NCIP Nueva Ecija Provincial Office</h3>
              <p>
                NCIP Nueva Ecija Provincial Office is located in Cabanatuan
                City, Nueva Ecija, serving as the provincial center for programs
                and services dedicated to Indigenous Cultural Communities and
                Indigenous Peoples. We are committed to protecting, promoting,
                and fulfilling the rights and welfare of ICCs/IPs throughout the
                province.
              </p>
            </div>
            <div class="intro-logo"></div>
          </div>
        </div>

        <!-- Republic Act 8371 Section -->
        <div class="content-section">
          <div class="section-header">
            <h3>Republic Act 8371 <i class="fas fa-balance-scale"></i></h3>
            <p>The Indigenous Peoples Rights Act of 1997</p>
          </div>
          <div class="section-content">
            <p style="font-size: 16px; color: #000000; line-height: 1.66">
              Republic Act No. 8371, officially known as the Indigenous Peoples'
              Rights Act of 1997, aims to safeguard the rights of Indigenous
              Peoples (IPs) and Indigenous Cultural Communities (ICCs) in the
              Philippines. This landmark legislation acknowledges their distinct
              identities, cultures, and traditional territories, providing a
              legal framework for the recognition of their rights.
            </p>
          </div>
        </div>

        <!-- NCIP Central Office VMGO -->
        <div class="content-section">
          <div class="section-header">
            <h3>NCIP Central Office <i class="fas fa-building"></i></h3>
            <p>Mandate, Vision and Mission</p>
          </div>
          <div class="section-content">
            <div class="vmgo-grid">
              <div class="vmgo-card">
                <h4><i class="fas fa-gavel"></i>Mandate</h4>
                <p>
                  The NCIP shall protect and promote the interest and well-being
                  of the Indigenous Cultural Communities/Indigenous Peoples with
                  due regard to their beliefs, customs, traditions, and
                  institutions.
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-eye"></i>Vision</h4>
                <p>
                  By 2040, all Philippine Indigenous Cultural
                  Communities/Indigenous Peoples will be fully empowered, their
                  rights genuinely fulfilled and realized, their cultural
                  heritage observed, respected, and preserved, and their
                  ancestral domains and land sustainably protected and
                  developed, ensuring active participation and contribution to
                  nation-building with their identity remaining intact as they
                  adapt to evolving times, and thus securing a lasting legacy
                  for future generations.
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-bullseye"></i>Mission</h4>
                <p>
                  A trusted partner and lead advocate of ICCs/IPs in upholding
                  their rights and well-being as enshrined in the Indigenous
                  Peoples' Rights Act.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- NCIP NEPO VMGO -->
        <div class="content-section">
          <div class="section-header">
            <h3>
              NCIP Nueva Ecija Provincial Office
              <i class="fas fa-map-marked-alt"></i>
            </h3>
            <p>Vision, Mission, Goals, Core Values & Objectives</p>
          </div>
          <div class="section-content">
            <div class="vmgo-grid">
              <div class="vmgo-card">
                <h4><i class="fas fa-eye"></i>Vision</h4>
                <p>
                  We DREAM to be at the HEART OF EVERY INDIGENOUS PEOPLES WOMEN
                  AND MEN, empowering them to live in dignity; and at the CENTER
                  OF EVERY INDIGENOUS CULTURAL COMMUNITIES as a catalyst for
                  culture-based, peaceful, united, resilient, self-reliant,
                  progressive and sustainable developed indigenous cultural
                  communities in Nueva Ecija that contributes to national
                  development and nation building. To this end, we TEAM NEPO
                  strive to ALWAYS AIM FOR EXCELLENCE AND MAKE IT AS A HABIT by
                  continuously IMPROVING OURSELVES to better serve our
                  stakeholders.
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-bullseye"></i>Mission</h4>
                <p>
                  To achieve our vision, we commit with passion to do these
                  FIRST: IMPLEMENT innovative policies, programs and projects
                  REPRESENT indigenous peoples in all levels (local, national &
                  international) SUSTAIN development within ICCs/IPs in the
                  areas of land air, water & services (LAWS) TRANSFORM the
                  problematic situation & lives of indigenous peoples thru
                  empowerment, education & training, capacity building, human
                  resource development, etc. To further achieve our vision, we
                  passionately commit to engage and actively involve all
                  stakeholders WOMEN & MEN where: IPs actively involved, manage,
                  direct their own empowerment and sustainable development; IPMR
                  champion, nurture, lead and take primary responsibility within
                  the community/city/municipality/
                  province; Elders/leaders,
                  family, barangay/community, LGUs and other stakeholders are
                  actively involved, engaged and share responsibilities; NCIP
                  Personnel as stewards of the institution ensure an enabling
                  and supportive environment
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-chart-line"></i> Goals</h4>
                <p>
                  The goals of NCIP NEPO are the following: 1. Document and
                  conduct social, historical, ethnographic, action researches
                  then establish a data bank or IP Family Registry of ICCs/ IPs
                  in Nueva Ecija; 2. Continuously empower and build the
                  capacities of ICCs/ IPs as well as NEPO Staff; 3. Successfully
                  manage the office using Adaptive Strategic Knowledge
                  Management Approach (ASKMA), and continuously design, plan,
                  implement, innovative sustainable development programs,
                  projects and services for IPs; 4. Propose an OPEN UNIVERSITY
                  OF INDIGENOUS PEOPLES HERITAGE AND LIVING TRADITIONS for NCIP
                  Employees and other local and international students who wants
                  to study ICCs/IPs in the Philippines and ICCs/IPs in the
                  world; and 5. Continuously represent IPs and build
                  multi-stakeholders partnerships in the local, national &
                  international level for the benefit of ICCs/ IPs.
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-handshake"></i> Core Values</h4>
                <p>
                  NCIP NEPO adhere to the National Motto under RA 8491, Chapter
                  III, Section 40 and share the values of Maka-Diyos, Maka-Tao,
                  Makakalikasan at Makabansa!
                </p>
              </div>

              <div class="vmgo-card">
                <h4><i class="fas fa-list-check"></i>Objectives</h4>
                <ul>
                  <li>
                    1. Continuously implement the GAA Funded Programs,
                    Activities and Projects (PAPs) of NCIP Nueva Ecija
                    Provincial Office (NEPO)
                  </li>
                  <li>
                    2. Continuously operationalize the Indigenous
                    Multi-Stakeholders Partnership (I’M PART) by increasing its
                    membership base by opening it to both individual membership
                    and organizational membership;
                  </li>
                  <li>
                    3. Continuously manage coordinated Programs, Activities and
                    Projects (PAPs)
                  </li>
                  <li>
                    4. Continuously build the capacities of staff and IPMRs
                    through the Staff Empowerment Trainings (SET) and
                    Staff-IPMRs Development & Empowerment Seminars (SIDES)
                  </li>
                  <li>
                    5. Strengthen the Barangay e-Partnership (BePart) which is a
                    community-based or barangay-based convergence or
                    multistakeholders partnership to operationalize the
                    whole-of-nation approach in the local level
                  </li>
                  <li>
                    6. Officially subscribe a License Zoom Apps as part of
                    adaptive management in times of COVID-19 Pandemic
                  </li>
                  <li>
                    7. Actively conduct a regular Staff Meetings as part of
                    ASKMA
                  </li>
                  <li>
                    8. Issue Memoranda for compliance as part of ASKMA; and
                  </li>
                  <li>
                    9. Actively participate in the Regional and National Zoom
                    Conferences, Meetings and Webinars.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>


        <!-- Indigenous Peoples Group Section -->
          <!-- ICCs/IPs in Nueva Ecija -->
<div class="ip-group">
  <div class="ip-header">
    <h3><i class="fas fa-users"></i> Indigenous Peoples Group</h3>
    <p class="ip-subtitle">Recognized ICCs/IPs in Nueva Ecija Province</p>
  </div>

  <div class="ip-content">
    <ul class="ip-list">
      <li><strong>Aeta</strong></li>
      <li><strong>Alta</strong></li>
      <li><strong>Applai</strong></li>
      <li><strong>Bajaw</strong></li>
      <li><strong>Bag-o</strong></li>
      <li><strong>Bontok</strong></li>
      <li><strong>Dumagat</strong></li>
      <li><strong>Gaddang</strong></li>
      <li><strong>Ibaloi</strong></li>
      <li><strong>Ibanag</strong></li>
      <li><strong>Ifugao</strong></li>
      <li><strong>Ilongot (Bugkalot)</strong></li>
      <li><strong>Itawis</strong></li>
      <li><strong>Itneg</strong></li>
      <li><strong>I-wak</strong></li>
      <li><strong>Kalanguya</strong></li>
      <li><strong>Kalinga</strong></li>
      <li><strong>Kankanaey</strong></li>
      <li><strong>Sinai</strong></li>
      <li><strong>Tingian</strong></li>
    </ul>
  </div>
</div>

<!-- Nueva Ecija Municipalities -->
<!-- Nueva Ecija Municipalities -->
<div class="municipality-group">
  <div class="municipality-header">
    <h3><i class="fas fa-map-marked-alt"></i> Province of Nueva Ecija</h3>
    <p class="municipality-subtitle">Municipalities and Cities under NCIP NEPO Coverage</p>
  </div>

  <div class="municipality-content">
    <div class="municipality-grid">
      <!-- South -->
      <div class="municipality-column">
        <h4><i class="fas fa-map-marker-alt"></i> Nueva Ecija (South)</h4>
        <ul class="municipality-list">
          <li data-letter="A"><strong>Aliaga</strong></li>
          <li data-letter="B"><strong>Bongabon</strong></li>
          <li data-letter="C"><strong>Cabanatuan City</strong></li>
          <li data-letter="G"><strong>Gabaldon</strong></li>
          <li data-letter="G"><strong>Gapan City</strong></li>
          <li data-letter="G"><strong>General Tinio</strong></li>
          <li data-letter="L"><strong>Laur</strong></li>
          <li data-letter="L"><strong>Licab</strong></li>
          <li data-letter="P"><strong>Palayan City</strong></li>
          <li data-letter="Z"><strong>Zaragoza</strong></li>
        </ul>
      </div>

      <!-- North -->
      <div class="municipality-column">
        <h4><i class="fas fa-map-marker-alt"></i> Nueva Ecija (North)</h4>
        <ul class="municipality-list">
          <li data-letter="C"><strong>Caranglan</strong></li>
          <li data-letter="L"><strong>Lupao</strong></li>
          <li data-letter="S"><strong>Science City of Muñoz</strong></li>
          <li data-letter="P"><strong>Pantabangan</strong></li>
          <li data-letter="R"><strong>Rizal</strong></li>
          <li data-letter="S"><strong>San Jose City</strong></li>
        </ul>
      </div>
    </div>
  </div>
</div>

      </div>

    <!-- FAQ Section -->
    <section class="content-section faq-section">
      <div class="section-header">
       <h3 class="faq-title">Frequently <span class="highlight-green">Asked Questions <i class="fas fa-question-circle"></i></span>
      </h3>
      <p class="faq-tagline">
        Find answers to common questions about your COC Request
      </p>

    
      </div>

        <div class="faq-container">
          <!-- Q1 -->
          <div class="faq-item">
            <button class="faq-question">
              What is the Certificate of Confirmation (COC)?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                The Certificate of Confirmation (COC) is an official document issued by the National Commission on Indigenous Peoples (NCIP) that verifies a person’s membership in an Indigenous Cultural Community or Indigenous Peoples (ICC/IP) group. It serves as proof of recognition and allows IPs to avail benefits and services from government programs.
              </p>
            </div>
          </div>

          <!-- Q2 -->
          <div class="faq-item">
            <button class="faq-question">
              </i>How can I request a COC online?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                You can request a COC by creating an account on the website, filling out the COC request form, and uploading the required documents such as:
              </p>
              <ul>
                <li>Birth certificate</li>
                <li>Photo of the applicant</li>
                <li>Certificate issued by the Tribal Chieftain</li>
              </ul>
              <p>
                Once submitted, the NCIP staff will review your application before it is approved by the admin.
              </p>
            </div>
          </div>

          <!-- Q3 -->
          <div class="faq-item">
            <button class="faq-question">
               How long does it take to process my COC request?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                Processing usually takes a few working days after submission. The exact duration depends on the completeness and accuracy of your uploaded documents.
              </p>
            </div>
          </div>

          <!-- Q4 -->
          <div class="faq-item">
            <button class="faq-question">
               How will I know if my COC request is approved?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                You will receive a notification through your account about your application status (Pending, Approved, or Rejected). You can also track your request on your dashboard.
              </p>
            </div>
          </div>

          <!-- Q5 -->
          <div class="faq-item">
            <button class="faq-question">
              What should I do if my application is rejected?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                If your application is rejected, you will receive feedback or remarks explaining the reason. You can edit or re-submit your documents for another review.
              </p>
            </div>
          </div>

          <!-- Q10 -->
          <div class="faq-item">
            <button class="faq-question">
              Is there a fee for requesting a COC online?
              <i class="fa-solid fa-chevron-down arrow"></i>
            </button>
            <div class="faq-answer">
              <p>
                Currently, no fee is required for online submission. However, applicants may need to pay standard government processing fees upon approval (depending on NCIP regulations).
              </p>
            </div>
          </div>
        </div>
    </section>
      
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
          <p>
            &copy; 2025 National Commission on Indigenous Peoples - Nueva Ecija.
            All Rights Reserved.
          </p>
        </div>
      </footer>
    </div>

    <script>

    document.querySelectorAll(".faq-item").forEach(item => {
        item.querySelector(".faq-question").addEventListener("click", () => {
          item.classList.toggle("active");
          document.querySelectorAll(".faq-item").forEach(other => {
            if (other !== item) other.classList.remove("active");
          });
        });
      });

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
