<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Updated Title -->
    <title>{{ __('National Commission on Indigenous Peoples - Nueva Ecija') }}</title>
    
    <!-- Meta Description for Google Search -->
    <meta name="description" content="Official NCIP Nueva Ecija - Certificate of Confirmation (COC) requests, indigenous rights, programs, and community resources for ICCs/IPs groups.">
    
    <!-- Open Graph Tags for Social Media -->
    <meta property="og:title" content="NCIP Nueva Ecija - Indigenous Peoples Commission">
    <meta property="og:description" content="Request COC online, access indigenous resources, and connect with ICCs/IPs communities in Nueva Ecija.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/ncip_logo.jpg') }}" type="image/jpeg">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    
    <!-- Rest of your existing code -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v=1.1">

    <style>
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
        @media (max-width: 768px) {
            .lang-switcher-nav {
                margin: 10px 0;
            }
        }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lang-switcher-mobile {
            display: none;
        }

        @media (max-width: 768px) {
            .nav-actions {
                display: none;
            }
            .lang-switcher-mobile {
                display: block;
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
                            <a
                href="#landingpage"
                class="active"
                >{{ __('Home') }} </a>
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
                        <li><a href="{{ url('news') }}">{{ __('News') }}</a></li>
                        <li class="mobile-login"><a href="{{ route('login') }}" class="login-btn">{{ __('Login') }}</a></li>
                        <!-- <li class="lang-switcher-nav">
                            <button type="button" onclick="document.getElementById('navLangDropdown').classList.toggle('show')">
                                <i class="fas fa-globe"></i> {{ app()->getLocale() === 'tl' ? 'Filipino' : 'English' }}
                            </button>
                            <div id="navLangDropdown" class="lang-dropdown-nav">
                                <a href="{{ route('lang.switch', 'en') }}">English</a>
                                <a href="{{ route('lang.switch', 'tl') }}">Filipino</a>
                            </div>
                        </li> -->

                    </ul>
                        <!-- <a href="{{ route('login') }}" class="login-btn desktop-login">{{ __('Login') }}</a> -->
                        <div class="nav-actions">
                        <a href="{{ route('login') }}" class="login-btn desktop-login">{{ __('Login') }}</a>

                        <div class="lang-switcher-nav lang-switcher-desktop">
                            <button type="button" onclick="document.getElementById('navLangDropdownDesktop').classList.toggle('show')">
                                <i class="fas fa-globe"></i> {{ app()->getLocale() === 'tl' ? 'Filipino' : 'English' }}
                            </button>
                            <div id="navLangDropdownDesktop" class="lang-dropdown-nav">
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
        <div class="logo" style="background-image: url('{{ asset('content/IP_logo.jpg') }}');"></div>
        <div class="org-title">
            <h1>{{ __('National Commission on Indigenous Peoples') }}</h1>
            <p>{{ __('Nueva Ecija Provincial Office') }}</p>
        </div>
    </div>
</header>

        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-container">
                <div class="hero-text">
                 <h2 style="color:#000000; font-size:clamp(1.8rem,5vw,2.5rem); font-weight:800; text-align:center;">
                        {{ __('Recognizing') }} <span style="color:#3E7B27;">{{ __('Indigenous People') }}</span> {{ __('of Nueva Ecija') }}</h2>

                    <p>{{ __('Request for your Certificate of Confirmation (COC) online, access important resources, and stay connected with your community.') }}</p>
                    <a href="{{ route('login') }}" class="cta-button">{{ __('Request COC') }}</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('content/bg.jpg') }}" alt="Indigenous People of Nueva Ecija">
                </div>
            </div>
        </section>

        <!-- Carousel Section -->
        <section class="carousel">
            <div class="carousel-container">
                <div class="carousel-slide fade">
                    <img src="{{ asset('content/Sliders_05-scaled.jpg') }}" alt="Slide 2">
                </div>
                <div class="carousel-slide fade">
                    <img src="{{ asset('content/Banner_02-scaled.jpg') }}" alt="Slide 1">
                </div>
                <div class="carousel-slide fade">
                    <img src="{{ asset('content/Banner_04-scaled.jpg') }}" alt="Slide 3">
                </div>

                <!-- Prev/Next Buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>

            <div class="dots">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </section>

        <!-- Quote Section -->
        <section class="quote-section">
            <div class="quote-content">
                <div>
                    <div class="quote-text">{{ __('"Indigenous People made huge contributions to this country. The biggest is in sharing the land and resources. People need to see that, understand that. Indigenous People should be viewed as the founding peoples of this land."') }}</div>
                    <div class="quote-author">- Perry Bellegarde</div>
                </div>
                <!-- ADD inline style attribute here -->
                <div class="quote-image" style="background-image: url('{{ asset('content/indigenous-children-traditional-attire-rice-paddy-field-vibrant-image-showcasing-children-indigenous-group-dressed-393401719.webp') }}');"></div>
            </div>
        </section>

      <!-- ICCs/IPs Groups -->
        <section class="groups-section" id="iccs-ips-groups">
            <div class="section-header">
            <h2> <span class="highlight-green">{{ __('ICCs/IPs Group') }} </span> {{ __('in the Province of Nueva Ecija') }}</h2>
                <p class="section-subtitle">{{ __('Nueva Ecija is home to diverse indigenous groups with rich cultural heritage and traditional practices') }}</p>
            </div>
            <div class="groups-grid" id="groupsList">

                @forelse($tribes as $tribe)
                <div class="group-card">
                    @if($tribe->photo)
                        <div class="group-image" style="background-image: url('{{ asset('storage/' . $tribe->photo) }}');"></div>
                    @else
                        <div class="group-image" style="background: linear-gradient(135deg, #2E7D46 0%, #52a033 100%); display:flex; align-items:center; justify-content:center;">
                            <span style="font-size:3rem; font-weight:800; color:rgba(255,255,255,0.35); letter-spacing:-2px; user-select:none;">
                                {{ strtoupper(substr($tribe->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif
                    <div class="group-content">
                        <h3 class="group-title">{{ $tribe->name }}</h3>
                        <p class="group-description">{{ $tribe->description ?: __('An indigenous people group recognized in the province of Nueva Ecija.') }}</p>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:40px; color:#666; grid-column:1/-1;">
                    <i class="fas fa-flag" style="font-size:2rem; opacity:0.3; margin-bottom:10px; display:block;"></i>
                    <p>{{ __('No tribes have been added yet.') }}</p>
                </div>
                @endforelse

            </div>
            <!-- Pagination Controls -->
            <div class="pagination">
                <button id="prevBtn" disabled>{{ __('Previous') }}</button>
                <span id="pageNumbers"></span>
                <button id="nextBtn">{{ __('Next') }}</button>
            </div>
        </section>

        <!-- Livelihood -->
        <section class="livelihood-section">
            <div class="section-header">
                <h2> <span class="highlight-green">{{ __('Indigenous People') }} </span> {{ __('Livelihood & Economic Contributions') }}</h2>
                <p class="section-subtitle">{{ __('The indigenous people of Nueva Ecija play a significant role in agriculture and traditional crafts') }}</p>
            </div>
            <div class="livelihood-cards">
                <div class="livelihood-card">
                    <div class="livelihood-icon"><i class="fa-solid fa-seedling"></i></div>
                    <div class="livelihood-content">
                        <h3>✓ {{ __('Sustainable Farming') }}</h3>
                        <p>{{ __('Many Aetas practice organic agriculture, growing root crops like cassava, sweet potatoes, and yams') }}</p>
                    </div>
                </div>
                <div class="livelihood-card">
                    <div class="livelihood-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <div class="livelihood-content">
                        <h3>✓ {{ __('Handicrafts & Weaving') }}</h3>
                        <p>{{ __('Indigenous artisans produce woven baskets, rattan furniture, and tribal accessories') }}</p>
                    </div>
                </div>
                <div class="livelihood-card">
                    <div class="livelihood-icon"><i class="fa-solid fa-fish-fins"></i></div>
                    <div class="livelihood-content">
                        <h3>✓ {{ __('Fishing & Hunting') }}</h3>
                        <p>{{ __('Dumagat groups continue river fishing and hunting using traditional techniques') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Certificate of Confirmation Section -->
        <section class="coc-section">
            <div class="coc-intro">
                <h2> <span class="highlight-green">{{ __('Certificate of Confirmation') }}</span> {{ __('for Indigenous People') }}</h2>
                <p>
                    {{ __("We provide assistance with applications for Certificates of Confirmation, an official document that confirms an individual's Indigenous identity and status. This certificate is important for accessing various programs, services, and rights specifically designated for Indigenous peoples.") }}
                </p>
                <p>
                    {{ __('Our experienced team guides applicants through the entire process, from documentation preparation to submission and follow-up with relevant authorities.') }}
                </p>
            </div>

            <div class="coc-process">
                <h3>{{ __('COC Application Process') }}</h3>
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number"><i class="fas fa-file-alt"></i></div>
                        <h4>{{ __('Document Preparation') }}</h4>
                        <p>{{ __('Gather all required documents including ID photos, birth certificate, and obtain certification from your tribal chieftain.') }}</p>
                    </div>
                    <div class="step">
                        <div class="step-number"><i class="fas fa-pen"></i></div>
                        <h4>{{ __('Form Completion') }}</h4>
                        <p>{{ __('Fill out the Information Index Form and Genealogy Form completely and accurately with all required information.') }}</p>
                    </div>
                    <div class="step">
                        <div class="step-number"><i class="fas fa-check"></i></div>
                        <h4>{{ __('Application Submission') }}</h4>
                        <p>{{ __('Submit your completed application form with all supporting documents.') }}</p>
                    </div>
                </div>
            </div>

            <div class="data-privacy-short">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                <strong>{{ __('Data Privacy Notice:') }}</strong> {{ __('All personal information collected through this system is kept secure and used only for processing your') }} <strong>{{ __('Certificate of Confirmation (COC)') }}</strong> 
                {{ __('in compliance with the') }} <em>{{ __('Data Privacy Act of 2012') }}</em>.
            </p>
            </div>

        </section>
        

        <!-- Our Heritage Section -->
        <section class="our-heritage">
        <div class="heritage-container">
            <!-- Left Side: Image -->
            <div class="heritage-image">
            <img src="{{ asset('content/filipino-indigenous-elders-teaching-traditional-we.jpg') }}" alt="Indigenous Heritage">
            </div>

            <!-- Right Side: Text -->
            <div class="heritage-text">
            <h2><span class="highlight-green">{{ __('Our Heritage') }}</span> {{ __('and Cultural Legacy') }}</h2>
            <p>
                {{ __('The Indigenous Peoples of Nueva Ecija proudly preserve their unique traditions, ancestral wisdom, and deep connection to nature. Their heritage stands as a testament to centuries of cultural resilience, craftsmanship, and communal harmony.') }}
            </p>

            <div class="heritage-features">
                <div class="heritage-card">
                <i class="fa-solid fa-palette"></i>
                <h3>{{ __('Traditional Arts & Crafts') }}</h3>
                <p>{{ __('Handwoven fabrics, beadwork, and pottery reflect the identity and creativity of each tribe.') }}</p>
                </div>

                <div class="heritage-card">
                <i class="fa-solid fa-drum"></i>
                <h3>{{ __('Music & Dance') }}</h3>
                <p>{{ __('Indigenous dances and songs celebrate harvests, community unity, and ancestral stories.') }}</p>
                </div>

            </div>
            </div>
        </div>
        </section>

        <!-- News -->
        <section class="news-preview-section" id="news-preview">
        <div class="section-wrapper">
            <div class="section-header">
            <h2 class="section-title">
                <span class="highlight-green">{{ __('Stay Informed') }}</span>
                {{ __('About NCIP Nueva Ecija Through') }}
                <span class="highlight-green">{{ __('Our News') }}</span>
            </h2>
            </div>

            <div class="news-grid">
            @foreach($latestNews as $news)
            <article class="news-card">
                <div class="news-card-image">
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                </div>
                <div class="news-card-content">
                <div class="news-date">
                    <i class="fa-regular fa-calendar-days"></i>
                    {{ \Carbon\Carbon::parse($news->created_at)->format('F d, Y') }} /
                    <span>NCIP Nueva Ecija</span>
                </div>

                <h3 class="news-title">{{ $news->title }}</h3>
                <p class="news-excerpt">
                    {{ \Illuminate\Support\Str::limit($news->description, 200, '...') }}
                </p>
                <a href="{{ route('news.show', $news->id) }}" class="read-more-btn">{{ __('Read More') }}</a>
                </div>
            </article>
            @endforeach
            </div>

            <div class="view-more-wrapper">
            <a href="{{ url('news') }}" class="view-more-btn">{{ __('View More') }}</a>
            </div>
        </div>
        </section>


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
</div>

<script>
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.lang-switcher-nav')) {
            document.getElementById('navLangDropdownDesktop')?.classList.remove('show');
            document.getElementById('navLangDropdownMobile')?.classList.remove('show');
        }
    });

    let slideIndex = 1;
    showSlides(slideIndex);

    // Next/Prev controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Dots controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("carousel-slide");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
    }

    function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        navMenu.classList.toggle('active');
    }


    // Toggle dropdown in mobile view
    function toggleDropdown(event, parent) {
        if (window.innerWidth <= 768) {
            event.preventDefault();
            const dropdown = parent.querySelector('.dropdown');
            dropdown.classList.toggle('active');
            
            // Rotate arrow
            const arrow = parent.querySelector('.arrow');
            arrow.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    // Groups Pagination functionality
    // ===================================
// Groups Pagination functionality
const groupsItemsPerPage = 3;
const groupCards = document.querySelectorAll("#groupsList .group-card");
const groupsTotalPages = Math.ceil(groupCards.length / groupsItemsPerPage);
let groupsCurrentPage = 1;

function showGroupsPage(page) {
    groupCards.forEach((card, index) => {
        card.style.display = (index >= (page - 1) * groupsItemsPerPage && index < page * groupsItemsPerPage) ? "block" : "none";
    });
    document.getElementById("prevBtn").disabled = (page === 1);
    document.getElementById("nextBtn").disabled = (page === groupsTotalPages);
    renderGroupsPageNumbers(page);
}

function renderGroupsPageNumbers(activePage) {
    const pageNumbers = document.getElementById("pageNumbers");
    pageNumbers.innerHTML = "";
    
    // ✅ ENSURE FLEX DISPLAY
    pageNumbers.style.display = "flex";
    pageNumbers.style.gap = "8px";
    pageNumbers.style.flexWrap = "wrap";
    pageNumbers.style.justifyContent = "center";
    pageNumbers.style.alignItems = "center";
    
    if (groupsTotalPages <= 5) {
        // Show all pages if 5 or fewer
        for (let i = 1; i <= groupsTotalPages; i++) {
            createPageButton(i, activePage === i, pageNumbers, 'groups');
        }
    } else {
        // Always show first page
        createPageButton(1, activePage === 1, pageNumbers, 'groups');
        
        if (activePage > 3) {
            // Show ellipsis after first page
            const ellipsis = document.createElement("span");
            ellipsis.textContent = "...";
            ellipsis.className = "ellipsis";
            ellipsis.style.padding = "8px 10px";
            ellipsis.style.color = "#888";
            ellipsis.style.fontWeight = "bold";
            ellipsis.style.userSelect = "none";
            pageNumbers.appendChild(ellipsis);
        }
        
        // Show pages around current page
        let start = Math.max(2, activePage - 1);
        let end = Math.min(groupsTotalPages - 1, activePage + 1);
        
        for (let i = start; i <= end; i++) {
            createPageButton(i, activePage === i, pageNumbers, 'groups');
        }
        
        if (activePage < groupsTotalPages - 2) {
            // Show ellipsis before last page
            const ellipsis = document.createElement("span");
            ellipsis.textContent = "...";
            ellipsis.className = "ellipsis";
            ellipsis.style.padding = "8px 10px";
            ellipsis.style.color = "#888";
            ellipsis.style.fontWeight = "bold";
            ellipsis.style.userSelect = "none";
            pageNumbers.appendChild(ellipsis);
        }
        
        // Always show last page
        if (groupsTotalPages > 1) {
            createPageButton(groupsTotalPages, activePage === groupsTotalPages, pageNumbers, 'groups');
        }
    }
}

function createPageButton(pageNum, isActive, container, type) {
    const btn = document.createElement("button");
    btn.textContent = pageNum;
    btn.type = "button"; // Prevent form submission
    
    // ✅ ADD PROPER STYLING
    btn.style.backgroundColor = isActive ? "#3E7B27" : "#e5e5e5";
    btn.style.color = isActive ? "#fff" : "#333";
    btn.style.border = isActive ? "1px solid #3E7B27" : "1px solid #ccc";
    btn.style.padding = "10px 16px";
    btn.style.borderRadius = "6px";
    btn.style.cursor = "pointer";
    btn.style.fontWeight = isActive ? "700" : "500";
    btn.style.fontSize = "0.9rem";
    btn.style.minWidth = "45px";
    btn.style.transition = "all 0.3s ease";
    btn.style.boxShadow = isActive ? "0 3px 8px rgba(62, 123, 39, 0.3)" : "0 2px 4px rgba(0,0,0,0.05)";
    
    // ✅ ADD SPACING BETWEEN BUTTONS
    btn.style.margin = "0"; // Remove default margin
    
    if (isActive) {
        btn.classList.add("active-page");
    }
    
    // Hover effect
    btn.addEventListener("mouseenter", function() {
        if (!isActive) {
            this.style.backgroundColor = "#d5d5d5";
            this.style.borderColor = "#bbb";
            this.style.transform = "translateY(-1px)";
            this.style.boxShadow = "0 3px 6px rgba(0,0,0,0.1)";
        }
    });
    
    btn.addEventListener("mouseleave", function() {
        if (!isActive) {
            this.style.backgroundColor = "#e5e5e5";
            this.style.borderColor = "#ccc";
            this.style.transform = "translateY(0)";
            this.style.boxShadow = "0 2px 4px rgba(0,0,0,0.05)";
        }
    });
    
    btn.addEventListener("click", () => {
        if (type === 'groups') {
            groupsCurrentPage = pageNum;
            showGroupsPage(groupsCurrentPage);
        } else {
            newsCurrentPage = pageNum;
            showNewsPage(newsCurrentPage);
        }
    });
    
    container.appendChild(btn);
}

// Previous button
document.getElementById("prevBtn").addEventListener("click", () => {
    if (groupsCurrentPage > 1) {
        groupsCurrentPage--;
        showGroupsPage(groupsCurrentPage);
    }
});

// Next button
document.getElementById("nextBtn").addEventListener("click", () => {
    if (groupsCurrentPage < groupsTotalPages) {
        groupsCurrentPage++;
        showGroupsPage(groupsCurrentPage);
    }
});

// Initialize pagination
showGroupsPage(groupsCurrentPage);

// ===================================
// RESPONSIVE: Adjust on window resize
// ===================================
window.addEventListener('resize', function() {
    const pageNumbers = document.getElementById("pageNumbers");
    if (window.innerWidth <= 480) {
        pageNumbers.style.gap = "5px";
    } else if (window.innerWidth <= 768) {
        pageNumbers.style.gap = "6px";
    } else {
        pageNumbers.style.gap = "8px";
    }
});
</script>
@include('partials.website-chatbot')
</body>
</html>