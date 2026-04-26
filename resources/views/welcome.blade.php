<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacare Hub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        :root {
        --navy:    #0B1354;
        --navy-90: rgba(11,19,84,0.92);
        --teal:    #3DBDAA;
        --teal-lt: #E8F8F5;
        --teal-dk: #2a9e8d;
        --cream:   #FAFAF7;
        --ink:     #1A1A2E;
        --muted:   #6B7280;
        --border:  #E5E7EB;
        --white:   #ffffff;
        --radius:  14px;
        --shadow-sm: 0 1px 4px rgba(0,0,0,0.07);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.09);
        --shadow-lg: 0 12px 40px rgba(0,0,0,0.12);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
        font-family: 'Sora', sans-serif;
        background: var(--cream);
        color: var(--ink);
        margin: 0;
        }

        /* ── NAV ── */
        .ph-nav {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 1000;
        background: var(--navy-90);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 0 2rem;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        }

        .ph-nav-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        }

        .ph-nav-brand img { width: 38px; height: 38px; object-fit: contain; }

        .ph-nav-brand span {
        font-size: 20px;
        font-weight: 600;
        color: white;
        letter-spacing: -0.3px;
        }

        .ph-nav-brand span em {
        font-style: normal;
        color: var(--teal);
        }

        .ph-nav-links {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        }

        .ph-nav-links a {
        font-size: 14px;
        font-weight: 400;
        color: rgba(255,255,255,0.78);
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 8px;
        transition: color 0.15s, background 0.15s;
        }

        .ph-nav-links a:hover, .ph-nav-links a.active {
        color: white;
        background: rgba(255,255,255,0.1);
        }

        .ph-btn-shop {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink) !important;
        background: var(--teal) !important;
        border-radius: 8px !important;
        padding: 7px 18px !important;
        transition: background 0.15s !important;
        }

        .ph-btn-shop:hover { background: var(--teal-dk) !important; color: white !important; }

        .ph-btn-outline {
        font-size: 14px;
        font-weight: 500;
        color: white !important;
        border: 1px solid rgba(255,255,255,0.3) !important;
        border-radius: 8px !important;
        padding: 6px 16px !important;
        transition: background 0.15s, border-color 0.15s !important;
        }

        .ph-btn-outline:hover {
        background: rgba(255,255,255,0.08) !important;
        border-color: rgba(255,255,255,0.55) !important;
        }

        /* ── HERO ── */
        .ph-hero {
        margin-top: 68px;
        position: relative;
        height: 600px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .ph-hero-slides { position: absolute; inset: 0; }

        .ph-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.9s ease;
        }

        .ph-slide.active { opacity: 1; }

        .ph-slide img {
        width: 100%; height: 100%;
        object-fit: cover;
        filter: blur(5px) brightness(0.55);
        transform: scale(1.06);
        }

        .ph-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        color: white;
        padding: 0 1.5rem;
        max-width: 720px;
        }

        .ph-hero-tag {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        background: rgba(61,189,170,0.25);
        border: 1px solid rgba(61,189,170,0.5);
        color: #7eedd9;
        padding: 5px 14px;
        border-radius: 99px;
        margin-bottom: 1.25rem;
        }

        .ph-hero-content h1 {
        font-family: 'Lora', serif;
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 600;
        line-height: 1.2;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
        }

        .ph-hero-content p {
        font-size: 16px;
        color: rgba(255,255,255,0.75);
        margin-bottom: 2rem;
        line-height: 1.7;
        }

        .ph-hero-btns {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        }

        .ph-hero-btns a {
        font-size: 14px;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.15s;
        }

        .ph-hero-btns .btn-primary-hero {
        background: var(--teal);
        color: var(--ink);
        border: 2px solid var(--teal);
        }

        .ph-hero-btns .btn-primary-hero:hover {
        background: var(--teal-dk);
        border-color: var(--teal-dk);
        color: white;
        }

        .ph-hero-btns .btn-ghost-hero {
        background: rgba(255,255,255,0.12);
        color: white;
        border: 2px solid rgba(255,255,255,0.35);
        backdrop-filter: blur(4px);
        }

        .ph-hero-btns .btn-ghost-hero:hover {
        background: rgba(255,255,255,0.22);
        border-color: rgba(255,255,255,0.6);
        }

        /* Slide indicators */
        .ph-hero-dots {
        position: absolute;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 20;
        }

        .ph-dot {
        width: 8px; height: 8px;
        border-radius: 99px;
        background: rgba(255,255,255,0.35);
        cursor: pointer;
        transition: background 0.2s, width 0.25s;
        border: none;
        padding: 0;
        }

        .ph-dot.active {
        background: var(--teal);
        width: 24px;
        }

        /* ── SEARCH ── */
        .ph-search {
        background: white;
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        }

        .ph-search-bar {
        display: flex;
        border: 1.5px solid var(--teal);
        border-radius: 12px;
        overflow: hidden;
        height: 54px;
        box-shadow: 0 0 0 4px rgba(61,189,170,0.1);
        }

        .ph-search-bar select {
        border: none;
        border-right: 1.5px solid var(--border);
        background: #f8faf9;
        color: var(--ink);
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        padding: 0 16px;
        min-width: 155px;
        outline: none;
        cursor: pointer;
        }

        .ph-search-bar input {
        flex: 1;
        border: none;
        background: white;
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        padding: 0 18px;
        outline: none;
        color: var(--ink);
        }

        .ph-search-bar input::placeholder { color: #adb5bd; }

        .ph-search-bar button {
        border: none;
        background: var(--teal);
        color: white;
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        font-weight: 600;
        padding: 0 28px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: background 0.15s;
        }

        .ph-search-bar button:hover { background: var(--teal-dk); }

        /* ── STATS STRIP ── */
        .ph-stats {
        background: var(--navy);
        padding: 1.25rem 0;
        }

        .ph-stat-item {
        text-align: center;
        color: white;
        border-right: 1px solid rgba(255,255,255,0.12);
        padding: 0.5rem 0;
        }

        .ph-stat-item:last-child { border-right: none; }

        .ph-stat-num {
        font-family: 'Lora', serif;
        font-size: 26px;
        font-weight: 600;
        color: var(--teal);
        display: block;
        line-height: 1.2;
        }

        .ph-stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        margin-top: 2px;
        }

        /* ── MAP SECTION ── */
        .ph-map-section { padding: 3rem 0; }

        .ph-section-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--teal-dk);
        margin-bottom: 6px;
        }

        .ph-section-title {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 1.5rem;
        letter-spacing: -0.3px;
        }

        #pharmacyMap {
        height: 420px;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        }

        /* Pharmacy list card */
        .ph-pharmacy-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        height: 100%;
        box-shadow: var(--shadow-sm);
        }

        .ph-pharmacy-card-header {
        background: var(--navy);
        padding: 1rem 1.25rem;
        color: white;
        }

        .ph-pharmacy-card-header h5 {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        }

        .ph-pharmacy-card-header p {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        margin: 4px 0 0;
        }

        .ph-pharmacy-list { padding: 0.5rem 0; }

        .ph-pharmacy-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.12s;
        }

        .ph-pharmacy-item:last-child { border-bottom: none; }
        .ph-pharmacy-item:hover { background: var(--teal-lt); }

        .ph-pharmacy-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 2px;
        }

        .ph-pharmacy-dist {
        font-size: 12px;
        color: var(--muted);
        }

        .ph-stock-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 99px;
        white-space: nowrap;
        }

        .stock-high  { background: #D1FAE5; color: #065F46; }
        .stock-med   { background: #FEF9C3; color: #854D0E; }
        .stock-low   { background: #FEE2E2; color: #991B1B; }

        /* Legend */
        .ph-map-legend {
        display: flex;
        gap: 16px;
        margin-top: 12px;
        flex-wrap: wrap;
        }

        .ph-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--muted);
        }

        .ph-legend-dot {
        width: 12px; height: 12px;
        border-radius: 50%;
        border: 2px solid rgba(0,0,0,0.2);
        }

        /* ── SERVICES ── */
        .ph-services { padding: 3.5rem 0; background: white; }

        .ph-service-card {
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem 1.5rem;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        position: relative;
        overflow: hidden;
        }

        .ph-service-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--teal);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.25s;
        }

        .ph-service-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(61,189,170,0.3);
        }

        .ph-service-card:hover::before { transform: scaleX(1); }

        .ph-service-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: var(--teal-lt);
        color: var(--teal-dk);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 1.25rem;
        transition: background 0.2s, color 0.2s;
        }

        .ph-service-card:hover .ph-service-icon {
        background: var(--teal);
        color: white;
        }

        .ph-service-card h5 {
        font-size: 16px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 8px;
        }

        .ph-service-card p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.65;
        margin-bottom: 1.25rem;
        }

        .ph-service-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--teal-dk);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.15s;
        }

        .ph-service-link:hover { gap: 10px; color: var(--teal-dk); }

        /* ── FOOTER ── */
        .ph-footer {
        background: var(--navy);
        color: rgba(255,255,255,0.75);
        padding: 3.5rem 0 0;
        }

        .ph-footer-brand {
        font-family: 'Lora', serif;
        font-size: 20px;
        font-weight: 600;
        color: white;
        margin-bottom: 12px;
        }

        .ph-footer-brand em { font-style: normal; color: var(--teal); }

        .ph-footer p { font-size: 13px; line-height: 1.75; }

        .ph-footer-title {
        font-size: 13px;
        font-weight: 700;
        color: white;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        }

        .ph-footer-links { list-style: none; padding: 0; margin: 0; }

        .ph-footer-links li { margin-bottom: 8px; }

        .ph-footer-links a {
        font-size: 13px;
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        transition: color 0.15s;
        }

        .ph-footer-links a:hover { color: var(--teal); }

        .ph-footer-contact { list-style: none; padding: 0; margin: 0; }

        .ph-footer-contact li {
        display: flex;
        gap: 10px;
        font-size: 13px;
        color: rgba(255,255,255,0.6);
        margin-bottom: 12px;
        line-height: 1.5;
        }

        .ph-footer-contact i {
        color: var(--teal);
        font-size: 15px;
        flex-shrink: 0;
        margin-top: 2px;
        }

        .ph-social { display: flex; gap: 10px; margin-top: 1.25rem; }

        .ph-social a {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.65);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        }

        .ph-social a:hover { background: var(--teal); color: var(--ink); }

        .ph-footer-bottom {
        margin-top: 2.5rem;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 1.25rem 0;
        }

        .ph-footer-bottom p, .ph-footer-bottom a {
        font-size: 12px;
        color: rgba(255,255,255,0.4);
        }

        .ph-footer-bottom a { text-decoration: none; transition: color 0.15s; }
        .ph-footer-bottom a:hover { color: var(--teal); }

        /* Responsive tweaks */
        @media (max-width: 768px) {
        .ph-nav-links { display: none; }
        .ph-hero { height: 500px; }
        .ph-stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.12); }
        .ph-stat-item:last-child { border-bottom: none; }
        }
    </style>
    </head>
    <body>

    <!-- ── NAVBAR ── -->
    <header class="ph-nav">
        <a href="/" class="ph-nav-brand">
        <img src="images/logo.png" alt="Logo" onerror="this.style.display='none'">
        <span>Pharmacare<em>Hub</em></span>
        </a>

        <ul class="ph-nav-links">
        <li><a href="/">Home</a></li>
        <li><a href="/services" class="active">Services</a></li>
        <li><a href="/shop" class="ph-btn-shop">Shop</a></li>
        <!-- Auth links (Laravel Blade) -->
        @auth
        <li><a href="{{ url('/dashboard') }}" class="ph-btn-outline">Dashboard</a></li>
        @else
        <li><a href="{{ route('login') }}">Log in</a></li>
        <li><a href="{{ route('register') }}" class="ph-btn-outline">Register</a></li>
        @endauth 
        </ul>
    </header>

    <!-- ── HERO ── -->
    <section class="ph-hero">
        <div class="ph-hero-slides">
        <div class="ph-slide active">
            <img src="images/carousel_1.jpg" alt="Hero 1" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=1400&q=80'">
        </div>
        <div class="ph-slide">
            <img src="images/carousel_3.jpg" alt="Hero 2" onerror="this.src='https://images.unsplash.com/photo-1576602976047-174e57a47881?w=1400&q=80'">
        </div>
        </div>

        <div class="ph-hero-content">
        <span class="ph-hero-tag">Trusted Healthcare Platform</span>
        <h1>Healthy Medicine,<br>Right Where You Need It</h1>
        <p>Find real-time stock at pharmacies near you, manage prescriptions,<br>and never miss a dose again.</p>
        <div class="ph-hero-btns">
            <a href="/shop" class="btn-primary-hero">Shop Now</a>
            <a href="/services" class="btn-ghost-hero">Our Services</a>
        </div>
        </div>

        <div class="ph-hero-dots">
        <button class="ph-dot active" onclick="goSlide(0)"></button>
        <button class="ph-dot" onclick="goSlide(1)"></button>
        </div>
    </section>

    <!-- ── SEARCH ── -->
    <section class="ph-search">
        <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
            <form action="search_results.php" method="GET">
                <div class="ph-search-bar">
                <select name="category">
                    <option value="">All Categories</option>
                    <option value="Medicine">Medicine</option>
                    <option value="Wellness">Wellness</option>
                    <option value="Diagnostics">Diagnostics</option>
                    <option value="Supplements">Supplements</option>
                </select>
                <input type="text" name="query" placeholder="Search for medicine, device, or supplement...">
                <button type="submit">
                    <i class="bi bi-search"></i> Find Medicine
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </section>

    <!-- ── STATS STRIP ── -->
    <div class="ph-stats">
        <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">Real-time</span>
            <div class="ph-stat-label">Stock accuracy</div>
            </div>
            <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">100%</span>
            <div class="ph-stat-label">Report accuracy</div>
            </div>
            <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">500+</span>
            <div class="ph-stat-label">Partner pharmacies</div>
            </div>
            <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">24/7</span>
            <div class="ph-stat-label">Stock monitoring</div>
            </div>
        </div>
        </div>
    </div>

    <!-- ── MAP + PHARMACY LIST ── -->
    <section class="ph-map-section">
        <div class="container">
        <p class="ph-section-label">Live Availability</p>
        <h2 class="ph-section-title">Nearby Pharmacies in Stock</h2>

        <div class="row g-4 align-items-stretch">
            <!-- Map -->
            <div class="col-lg-7">
            <div id="pharmacyMap"></div>
            <div class="ph-map-legend mt-3">
                <div class="ph-legend-item">
                <div class="ph-legend-dot" style="background:#22c55e;"></div> Plenty in stock
                </div>
                <div class="ph-legend-item">
                <div class="ph-legend-dot" style="background:#f59e0b;"></div> Low stock
                </div>
                <div class="ph-legend-item">
                <div class="ph-legend-dot" style="background:#ef4444;"></div> Out of stock
                </div>
                <div class="ph-legend-item">
                <div class="ph-legend-dot" style="background:#3B82F6; border-radius:2px;"></div> You
                </div>
            </div>
            </div>

            <!-- Pharmacy list -->
            <div class="col-lg-5">
            <div class="ph-pharmacy-card">
                <div class="ph-pharmacy-card-header">
                <h5><i class="bi bi-capsule me-2" style="color:var(--teal)"></i>Paracetamol — Nearby Stock</h5>
                <p>Sorted by distance from your location</p>
                </div>
                <div class="ph-pharmacy-list">
                <div class="ph-pharmacy-item">
                    <div>
                    <div class="ph-pharmacy-name">HealthFirst Pharmacy</div>
                    <div class="ph-pharmacy-dist"><i class="bi bi-geo-alt me-1"></i>123 Main St. &middot; 0.5 km</div>
                    </div>
                    <span class="ph-stock-badge stock-high">12 in stock</span>
                </div>
                <div class="ph-pharmacy-item">
                    <div>
                    <div class="ph-pharmacy-name">Mercury Drug (Panabo NHwy)</div>
                    <div class="ph-pharmacy-dist"><i class="bi bi-geo-alt me-1"></i>National Highway &middot; 0.9 km</div>
                    </div>
                    <span class="ph-stock-badge stock-high">10 in stock</span>
                </div>
                <div class="ph-pharmacy-item">
                    <div>
                    <div class="ph-pharmacy-name">CityMed Drugstore</div>
                    <div class="ph-pharmacy-dist"><i class="bi bi-geo-alt me-1"></i>456 Oak Ave. &middot; 1.2 km</div>
                    </div>
                    <span class="ph-stock-badge stock-med">5 in stock</span>
                </div>
                <div class="ph-pharmacy-item">
                    <div>
                    <div class="ph-pharmacy-name">HB1 Pharmacy (Santo Niño)</div>
                    <div class="ph-pharmacy-dist"><i class="bi bi-geo-alt me-1"></i>Sto. Niño St. &middot; 1.6 km</div>
                    </div>
                    <span class="ph-stock-badge stock-med">6 in stock</span>
                </div>
                <div class="ph-pharmacy-item">
                    <div>
                    <div class="ph-pharmacy-name">WellCare Pharmacy</div>
                    <div class="ph-pharmacy-dist"><i class="bi bi-geo-alt me-1"></i>789 Pine Rd. &middot; 2.0 km</div>
                    </div>
                    <span class="ph-stock-badge stock-low">2 in stock</span>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- ── SERVICES ── -->
    <section class="ph-services">
        <div class="container">
        <div class="text-center mb-5">
            <p class="ph-section-label">What We Offer</p>
            <h2 class="ph-section-title" style="margin-bottom:0.5rem;">Our Services</h2>
            <p style="font-size:15px; color:var(--muted); max-width:480px; margin:0 auto;">Everything you need to manage medication and healthcare — all in one place.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-sm-6 col-lg-3">
            <div class="ph-service-card">
                <div class="ph-service-icon"><i class="bi bi-capsule"></i></div>
                <h5>Medicine</h5>
                <p>Browse and order trusted medicines. Check real-time stock at pharmacies near you.</p>
                <a href="#" class="ph-service-link">Explore <i class="bi bi-arrow-right"></i></a>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
            <div class="ph-service-card">
                <div class="ph-service-icon"><i class="bi bi-heart-pulse"></i></div>
                <h5>Wellness</h5>
                <p>Discover vitamins, supplements, and wellness products for a healthier lifestyle.</p>
                <a href="#" class="ph-service-link">Explore <i class="bi bi-arrow-right"></i></a>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
            <div class="ph-service-card">
                <div class="ph-service-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                <h5>Diagnostics</h5>
                <p>Access diagnostic tools, test kits, and health check services with ease.</p>
                <a href="#" class="ph-service-link">Explore <i class="bi bi-arrow-right"></i></a>
            </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
            <div class="ph-service-card">
                <div class="ph-service-icon"><i class="bi bi-journal-medical"></i></div>
                <h5>Health Corner</h5>
                <p>Read expert tips, medication guides, and daily health advice from our team.</p>
                <a href="#" class="ph-service-link">Explore <i class="bi bi-arrow-right"></i></a>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- ── FOOTER ── -->
    <footer class="ph-footer">
        <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
            <div class="ph-footer-brand">Pharmacare<em>Hub</em></div>
            <p>Your trusted partner for healthcare solutions. Quality medicines, wellness products, and services to keep you healthy.</p>
            <div class="ph-social">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
            <p class="ph-footer-title">Quick Links</p>
            <ul class="ph-footer-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about_us">About Us</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/shop">Shop</a></li>
            </ul>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
            <p class="ph-footer-title">Services</p>
            <ul class="ph-footer-links">
                <li><a href="/prescription">Prescription</a></li>
                <li><a href="/consultation">Consultation</a></li>
                <li><a href="/diagnostics">Diagnostics</a></li>
                <li><a href="/wellness">Wellness</a></li>
            </ul>
            </div>
        </div>

        <div class="ph-footer-bottom">
            <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <p class="mb-0">&copy; 2025 Pharmacare Hub. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#">Privacy Policy</a>
                <span class="mx-2" style="color:rgba(255,255,255,0.2)">|</span>
                <a href="#">Terms of Service</a>
                <span class="mx-2" style="color:rgba(255,255,255,0.2)">|</span>
                <a href="#">Cookie Policy</a>
            </div>
            </div>
        </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        /* ── Hero Slideshow ── */
        const slides = document.querySelectorAll('.ph-slide');
        const dots   = document.querySelectorAll('.ph-dot');
        let current  = 0, timer;

        function goSlide(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
        clearInterval(timer);
        timer = setInterval(() => goSlide(current + 1), 5000);
        }

        timer = setInterval(() => goSlide(current + 1), 5000);

        /* ── Leaflet Map ── */
        const pharmacies = [
        { name: "Mercury Drug (Panabo NHwy)",  lat: 7.3100, lng: 125.6820, stock: 10 },
        { name: "Cris Lou Pharmacy",           lat: 7.3055, lng: 125.6855, stock: 3  },
        { name: "Generika DDN",                lat: 7.3070, lng: 125.6830, stock: 0  },
        { name: "HB1 Pharmacy (Santo Niño)",   lat: 7.3090, lng: 125.6860, stock: 6  },
        ];

        const fallbackLat = 7.30806, fallbackLng = 125.68417;

        const map = L.map('pharmacyMap').setView([fallbackLat, fallbackLng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '© OpenStreetMap'
        }).addTo(map);

        function addUserMarker(lat, lng) {
        L.marker([lat, lng], {
            icon: L.divIcon({
            className: '',
            html: `<div style="width:16px;height:16px;border-radius:50%;background:#3B82F6;border:3px solid white;box-shadow:0 0 0 3px rgba(59,130,246,0.35);"></div>`,
            iconSize: [16, 16], iconAnchor: [8, 8]
            })
        }).addTo(map).bindPopup('<b>📍 You are here</b>').openPopup();
        map.setView([lat, lng], 14);
        }

        function showPharmacies(list) {
        list.forEach(ph => {
            const color = ph.stock > 7 ? '#22c55e' : ph.stock > 0 ? '#f59e0b' : '#ef4444';
            L.circleMarker([ph.lat, ph.lng], {
            radius: 10, fillColor: color, color: 'white',
            weight: 2, opacity: 1, fillOpacity: 0.9
            }).addTo(map).bindPopup(
            `<b>${ph.name}</b><br>${ph.stock > 0 ? ph.stock + ' units available' : 'Out of stock'}`
            );
        });
        }

        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => { addUserMarker(pos.coords.latitude, pos.coords.longitude); showPharmacies(pharmacies); },
            ()  => { addUserMarker(fallbackLat, fallbackLng); showPharmacies(pharmacies); }
        );
        } else {
        addUserMarker(fallbackLat, fallbackLng);
        showPharmacies(pharmacies);
        }
    </script>
</body>
</html>