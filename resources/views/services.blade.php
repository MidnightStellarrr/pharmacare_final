<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Services — Pharmacare Hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
        --navy:    #0B1354;
        --navy-90: rgba(11,19,84,0.94);
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
        --shadow-lg: 0 12px 40px rgba(0,0,0,0.13);
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
    
        .ph-nav-brand span em { font-style: normal; color: var(--teal); }
    
        .ph-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
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
    
        .ph-nav-links a:hover,
        .ph-nav-links a.active {
        color: white;
        background: rgba(255,255,255,0.1);
        }
    
        .ph-btn-shop {
        font-weight: 600 !important;
        color: var(--ink) !important;
        background: var(--teal) !important;
        border-radius: 8px !important;
        transition: background 0.15s !important;
        }
    
        .ph-btn-shop:hover { background: var(--teal-dk) !important; color: white !important; }
    
        .ph-btn-outline {
        font-weight: 500 !important;
        color: white !important;
        border: 1px solid rgba(255,255,255,0.3) !important;
        border-radius: 8px !important;
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
        height: 480px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        }
    
        .ph-hero-bg {
        position: absolute;
        inset: 0;
        }
    
        .ph-hero-bg img {
        width: 100%; height: 100%;
        object-fit: cover;
        filter: blur(5px) brightness(0.45);
        transform: scale(1.06);
        }
    
        /* Gradient tint for depth */
        .ph-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(11,19,84,0.65) 0%, rgba(11,19,84,0.2) 60%, rgba(61,189,170,0.15) 100%);
        }
    
        .ph-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        color: white;
        padding: 0 1.5rem;
        max-width: 700px;
        }
    
        .ph-hero-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        background: rgba(61,189,170,0.22);
        border: 1px solid rgba(61,189,170,0.5);
        color: #7eedd9;
        padding: 5px 16px;
        border-radius: 99px;
        margin-bottom: 1.25rem;
        animation: fadeUp 0.6s ease both;
        }
    
        .ph-hero-content h1 {
        font-family: 'Lora', serif;
        font-size: clamp(36px, 6vw, 60px);
        font-weight: 600;
        line-height: 1.15;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
        animation: fadeUp 0.6s 0.1s ease both;
        }
    
        .ph-hero-content p {
        font-size: 16px;
        color: rgba(255,255,255,0.72);
        margin-bottom: 0;
        line-height: 1.7;
        animation: fadeUp 0.6s 0.2s ease both;
        }
    
        /* Decorative bottom wave */
        .ph-hero-wave {
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        z-index: 11;
        line-height: 0;
        }
    
        .ph-hero-wave svg { width: 100%; height: 60px; display: block; }
    
        @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
        }
    
        /* ── STATS STRIP ── */
        .ph-stats {
        background: var(--navy);
        padding: 1.5rem 0;
        }
    
        .ph-stat-item {
        text-align: center;
        color: white;
        border-right: 1px solid rgba(255,255,255,0.1);
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
        color: rgba(255,255,255,0.55);
        margin-top: 2px;
        }
    
        /* ── SECTION HEADERS ── */
        .ph-section-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.13em;
        text-transform: uppercase;
        color: var(--teal-dk);
        margin-bottom: 6px;
        }
    
        .ph-section-title {
        font-family: 'Lora', serif;
        font-size: 28px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0.5rem;
        letter-spacing: -0.3px;
        }
    
        /* ── TABS ── */
        .ph-tabs-wrap {
        background: white;
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 68px;
        z-index: 100;
        box-shadow: var(--shadow-sm);
        }
    
        .ph-tabs {
        display: flex;
        gap: 0;
        list-style: none;
        margin: 0;
        padding: 0 1rem;
        overflow-x: auto;
        scrollbar-width: none;
        }
    
        .ph-tabs::-webkit-scrollbar { display: none; }
    
        .ph-tabs li a {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 500;
        color: var(--muted);
        text-decoration: none;
        padding: 16px 20px;
        border-bottom: 2.5px solid transparent;
        transition: color 0.15s, border-color 0.15s;
        white-space: nowrap;
        }
    
        .ph-tabs li a i {
        font-size: 15px;
        transition: color 0.15s;
        }
    
        .ph-tabs li a:hover {
        color: var(--ink);
        }
    
        .ph-tabs li a.active {
        color: var(--navy);
        border-bottom-color: var(--teal);
        font-weight: 600;
        }
    
        .ph-tabs li a.active i { color: var(--teal); }
    
        /* ── SERVICES GRID ── */
        .ph-services-section { padding: 4rem 0; }
    
        .ph-service-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 2rem 1.75rem 1.75rem;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
        }
    
        .ph-service-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--teal);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.28s ease;
        }
    
        .ph-service-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(61,189,170,0.3);
        }
    
        .ph-service-card:hover::after { transform: scaleX(1); }
    
        .ph-service-icon {
        width: 54px; height: 54px;
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
        line-height: 1.7;
        margin-bottom: 1.5rem;
        }
    
        .ph-service-badge {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 99px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        }
    
        .badge-new { background: #DBEAFE; color: #1D4ED8; }
        .badge-popular { background: #D1FAE5; color: #065F46; }
        .badge-soon { background: #FEF3C7; color: #92400E; }
    
        .ph-service-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--teal-dk);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.15s, color 0.15s;
        }
    
        .ph-service-link:hover { gap: 10px; color: var(--navy); }
    
        /* ── HOW IT WORKS ── */
        .ph-how {
        background: white;
        padding: 4rem 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        }
    
        .ph-step-track {
        display: flex;
        align-items: flex-start;
        gap: 0;
        position: relative;
        }
    
        .ph-step {
        flex: 1;
        text-align: center;
        padding: 0 1rem;
        position: relative;
        }
    
        /* Connector line */
        .ph-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 27px;
        left: calc(50% + 20px);
        right: calc(-50% + 20px);
        height: 1px;
        background: linear-gradient(to right, var(--teal), var(--border));
        z-index: 0;
        }
    
        .ph-step-num {
        width: 54px; height: 54px;
        border-radius: 50%;
        background: var(--teal-lt);
        border: 2px solid var(--teal);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Lora', serif;
        font-size: 20px;
        font-weight: 600;
        color: var(--teal-dk);
        margin: 0 auto 1rem;
        position: relative;
        z-index: 1;
        transition: background 0.2s, color 0.2s;
        }
    
        .ph-step:hover .ph-step-num {
        background: var(--teal);
        color: white;
        }
    
        .ph-step strong {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 6px;
        }
    
        .ph-step span {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.6;
        display: block;
        }
    
        /* ── HIGHLIGHT BAND ── */
        .ph-highlight {
        background: linear-gradient(135deg, var(--navy) 0%, #162b8a 100%);
        padding: 3.5rem 0;
        position: relative;
        overflow: hidden;
        }
    
        .ph-highlight::before {
        content: '';
        position: absolute;
        width: 350px; height: 350px;
        border-radius: 50%;
        background: rgba(61,189,170,0.08);
        top: -80px; right: -80px;
        pointer-events: none;
        }
    
        .ph-highlight::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(61,189,170,0.06);
        bottom: -60px; left: -40px;
        pointer-events: none;
        }
    
        .ph-highlight-text h2 {
        font-family: 'Lora', serif;
        font-size: 30px;
        font-weight: 600;
        color: white;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        }
    
        .ph-highlight-text p {
        font-size: 14px;
        color: rgba(255,255,255,0.65);
        line-height: 1.75;
        margin-bottom: 0;
        }
    
        .ph-highlight-features {
        list-style: none;
        padding: 0;
        margin: 0;
        }
    
        .ph-highlight-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: rgba(255,255,255,0.82);
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        }
    
        .ph-highlight-features li:last-child { border-bottom: none; }
    
        .ph-highlight-features li i {
        color: var(--teal);
        font-size: 16px;
        flex-shrink: 0;
        }
    
        /* ── FAQ ── */
        .ph-faq { padding: 4rem 0; }
    
        .ph-faq-item {
        border-bottom: 1px solid var(--border);
        }
    
        .ph-faq-item:first-child { border-top: 1px solid var(--border); }
    
        .ph-faq-btn {
        width: 100%;
        background: none;
        border: none;
        padding: 1.1rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        text-align: left;
        transition: color 0.15s;
        }
    
        .ph-faq-btn:hover { color: var(--navy); }
    
        .ph-faq-icon {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--cream);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        line-height: 1;
        font-weight: 300;
        color: var(--muted);
        flex-shrink: 0;
        transition: transform 0.22s, background 0.15s, color 0.15s;
        }
    
        .ph-faq-item.open .ph-faq-icon {
        transform: rotate(45deg);
        background: var(--teal);
        color: white;
        border-color: var(--teal);
        }
    
        .ph-faq-answer {
        display: none;
        font-size: 14px;
        color: var(--muted);
        line-height: 1.8;
        padding-bottom: 1.25rem;
        max-width: 680px;
        }
    
        .ph-faq-item.open .ph-faq-answer { display: block; }
    
        /* ── CTA ── */
        .ph-cta {
        background: var(--cream);
        padding: 4rem 0;
        }
    
        .ph-cta-box {
        background: white;
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 3rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        flex-wrap: wrap;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
        }
    
        .ph-cta-box::before {
        content: '';
        position: absolute;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(61,189,170,0.08) 0%, transparent 70%);
        top: -60px; right: -60px;
        pointer-events: none;
        }
    
        .ph-cta-box h2 {
        font-family: 'Lora', serif;
        font-size: 26px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 8px;
        }
    
        .ph-cta-box p {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
        }
    
        .ph-btn {
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        font-weight: 600;
        padding: 12px 26px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s;
        cursor: pointer;
        border: none;
        }
    
        .ph-btn-primary {
        background: var(--navy);
        color: white;
        }
    
        .ph-btn-primary:hover { background: #162b8a; color: white; }
    
        .ph-btn-teal {
        background: var(--teal);
        color: var(--ink);
        }
    
        .ph-btn-teal:hover { background: var(--teal-dk); color: white; }
    
        .ph-btn-ghost {
        background: transparent;
        color: var(--ink);
        border: 1.5px solid var(--border);
        }
    
        .ph-btn-ghost:hover { border-color: var(--teal); color: var(--teal-dk); }
    
        /* ── FOOTER ── */
        .ph-footer {
        background: var(--navy);
        color: rgba(255,255,255,0.7);
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
        font-size: 11px;
        font-weight: 700;
        color: white;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        }
    
        .ph-footer-links { list-style: none; padding: 0; margin: 0; }
    
        .ph-footer-links li { margin-bottom: 8px; }
    
        .ph-footer-links a {
        font-size: 13px;
        color: rgba(255,255,255,0.55);
        text-decoration: none;
        transition: color 0.15s;
        }
    
        .ph-footer-links a:hover { color: var(--teal); }
    
        .ph-footer-contact { list-style: none; padding: 0; margin: 0; }
    
        .ph-footer-contact li {
        display: flex;
        gap: 10px;
        font-size: 13px;
        color: rgba(255,255,255,0.55);
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
        color: rgba(255,255,255,0.6);
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
    
        .ph-footer-bottom p,
        .ph-footer-bottom a {
        font-size: 12px;
        color: rgba(255,255,255,0.38);
        }
    
        .ph-footer-bottom a { text-decoration: none; transition: color 0.15s; }
        .ph-footer-bottom a:hover { color: var(--teal); }
    
        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
        .ph-nav-links { display: none; }
        .ph-hero { height: 400px; }
        .ph-step:not(:last-child)::after { display: none; }
        .ph-stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .ph-stat-item:last-child { border-bottom: none; }
        .ph-cta-box { padding: 2rem 1.5rem; }
        .ph-step-track { flex-direction: column; align-items: center; }
        .ph-step { width: 100%; max-width: 260px; }
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
        <li><a href="/login">Log in</a></li>
        <li><a href="/register" class="ph-btn-outline">Register</a></li>
    </ul>
    </header>
    
    <!-- ── HERO ── -->
    <section class="ph-hero">
    <div class="ph-hero-bg">
        <img src="images/carousel_1.jpg" alt="Services Hero"
        onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=1400&q=80'">
    </div>
    <div class="ph-hero-overlay"></div>
    
    <div class="ph-hero-content">
        <span class="ph-hero-tag">Everything You Need</span>
        <h1>Our Services</h1>
        <p>Your trusted partner in health &amp; wellness — from real-time medicine availability to expert diagnostics, all in one place.</p>
    </div>
    
    <!-- Wave -->
    <div class="ph-hero-wave">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#0B1354"/>
        </svg>
    </div>
    </section>
    
    <!-- ── STATS STRIP ── -->
    <div class="ph-stats">
    <div class="container">
        <div class="row">
        <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">6</span>
            <div class="ph-stat-label">Core services</div>
        </div>
        <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">500+</span>
            <div class="ph-stat-label">Partner pharmacies</div>
        </div>
        <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">Real-time</span>
            <div class="ph-stat-label">Stock monitoring</div>
        </div>
        <div class="col-6 col-md-3 ph-stat-item">
            <span class="ph-stat-num">24/7</span>
            <div class="ph-stat-label">Support access</div>
        </div>
        </div>
    </div>
    </div>
    
    <!-- ── STICKY TABS ── -->
    <nav class="ph-tabs-wrap d-flex justify-content-center w-100">
        <ul class="ph-tabs d-flex justify-content-center gap-4 list-unstyled m-0 flex-wrap">
            <li><a href="#medicine" class="active"><i class="bi bi-capsule"></i> Medicine</a></li>
            <li><a href="#wellness"><i class="bi bi-heart-pulse"></i> Wellness</a></li>
            <li><a href="#diagnostics"><i class="bi bi-clipboard2-pulse"></i> Diagnostics</a></li>
            <li><a href="#prescription"><i class="bi bi-prescription2"></i> Prescription</a></li>
            <li><a href="#delivery"><i class="bi bi-truck"></i> Delivery</a></li>
            <li><a href="#health-corner"><i class="bi bi-journal-medical"></i> Health Corner</a></li>
        </ul>
    </nav>
    
    <!-- ── SERVICES GRID ── -->
    <section class="ph-services-section" id="medicine">
    <div class="container">
        <div class="mb-5">
        <p class="ph-section-label">What We Offer</p>
        <h2 class="ph-section-title">All Services at a Glance</h2>
        <p style="font-size:14px; color:var(--muted); max-width:480px;">Comprehensive healthcare solutions designed around your everyday needs.</p>
        </div>
    
        <div class="row g-4">
    
        <!-- 1. Medicine -->
        <div class="col-12 col-sm-6 col-lg-4" id="medicine">
            <div class="ph-service-card">
            <span class="ph-service-badge badge-popular">Popular</span>
            <div class="ph-service-icon"><i class="bi bi-capsule"></i></div>
            <h5>Medicine</h5>
            <p>Browse thousands of trusted medicines and check real-time stock availability at pharmacies near you — no more wasted trips.</p>
            <a href="/shop" class="ph-service-link">Shop medicines <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        <!-- 2. Wellness -->
        <div class="col-12 col-sm-6 col-lg-4" id="wellness">
            <div class="ph-service-card">
            <div class="ph-service-icon"><i class="bi bi-heart-pulse"></i></div>
            <h5>Wellness Products</h5>
            <p>Discover vitamins, supplements, personal care essentials, and wellness products carefully curated for a healthier lifestyle.</p>
            <a href="/shop" class="ph-service-link">Explore wellness <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        <!-- 3. Diagnostics -->
        <div class="col-12 col-sm-6 col-lg-4" id="diagnostics">
            <div class="ph-service-card">
            <div class="ph-service-icon"><i class="bi bi-clipboard2-pulse"></i></div>
            <h5>Diagnostics</h5>
            <p>Access diagnostic tools, rapid test kits, blood glucose monitors, and health check services from verified suppliers.</p>
            <a href="/shop" class="ph-service-link">See diagnostics <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        <!-- 4. Prescription Management -->
        <div class="col-12 col-sm-6 col-lg-4" id="prescription">
            <div class="ph-service-card">
            <span class="ph-service-badge badge-new">New</span>
            <div class="ph-service-icon"><i class="bi bi-prescription2"></i></div>
            <h5>Prescription Management</h5>
            <p>Upload your prescription, track refill schedules, and receive reminders so you never miss a dose again.</p>
            <a href="/register" class="ph-service-link">Get started <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        <!-- 5. Home Delivery -->
        <div class="col-12 col-sm-6 col-lg-4" id="delivery">
            <div class="ph-service-card">
            <div class="ph-service-icon"><i class="bi bi-truck"></i></div>
            <h5>Home Delivery</h5>
            <p>Order medicine and wellness products online and have them delivered straight to your door — fast, safe, and convenient.</p>
            <a href="/shop" class="ph-service-link">Order now <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        <!-- 6. Health Corner -->
        <div class="col-12 col-sm-6 col-lg-4" id="health-corner">
            <div class="ph-service-card">
            <span class="ph-service-badge badge-soon">Coming Soon</span>
            <div class="ph-service-icon"><i class="bi bi-journal-medical"></i></div>
            <h5>Health Corner</h5>
            <p>Expert-written guides on medication use, drug interactions, nutrition tips, and daily health advice tailored for you.</p>
            <a href="#" class="ph-service-link">Read articles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    
        </div>
    </div>
    </section>
    
    <!-- ── HOW IT WORKS ── -->
    <section class="ph-how">
    <div class="container">
        <div class="text-center mb-5">
        <p class="ph-section-label">Simple Process</p>
        <h2 class="ph-section-title">How It Works</h2>
        <p style="font-size:14px; color:var(--muted);">From search to doorstep in four easy steps.</p>
        </div>
    
        <div class="ph-step-track">
        <div class="ph-step">
            <div class="ph-step-num">1</div>
            <strong>Search</strong>
            <span>Enter a medicine name or browse by category to find exactly what you need.</span>
        </div>
        <div class="ph-step">
            <div class="ph-step-num">2</div>
            <strong>Find Nearby</strong>
            <span>See real-time stock at pharmacies near you on an interactive live map.</span>
        </div>
        <div class="ph-step">
            <div class="ph-step-num">3</div>
            <strong>Order Online</strong>
            <span>Add to cart, choose pick-up or delivery, and checkout securely.</span>
        </div>
        <div class="ph-step">
            <div class="ph-step-num">4</div>
            <strong>Stay Healthy</strong>
            <span>Track your orders, manage prescriptions, and get timely refill reminders.</span>
        </div>
        </div>
    </div>
    </section>
    
    <!-- ── HIGHLIGHT BAND ── -->
    <section class="ph-highlight">
    <div class="container">
        <div class="row g-5 align-items-center">
        <div class="col-lg-5">
            <div class="ph-highlight-text">
            <p class="ph-section-label" style="color: #7eedd9;">Why Choose Us</p>
            <h2>Healthcare, Simplified for Everyone</h2>
            <p>We bridge the gap between patients and pharmacies — giving you real-time visibility, convenience, and peace of mind.</p>
            </div>
        </div>
        <div class="col-lg-7">
            <ul class="ph-highlight-features">
            <li><i class="bi bi-check-circle-fill"></i> Real-time pharmacy stock — no more calling ahead or wasted trips</li>
            <li><i class="bi bi-check-circle-fill"></i> Verified medicines from licensed partner pharmacies only</li>
            <li><i class="bi bi-check-circle-fill"></i> Prescription upload and automated refill reminders</li>
            <li><i class="bi bi-check-circle-fill"></i> Same-day delivery available in select areas</li>
            <li><i class="bi bi-check-circle-fill"></i> Expert health content written by licensed pharmacists</li>
            <li><i class="bi bi-check-circle-fill"></i> Secure, encrypted checkout with multiple payment options</li>
            </ul>
        </div>
        </div>
    </div>
    </section>
    
    <!-- ── FAQ ── -->
    <section class="ph-faq">
    <div class="container">
        <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
            <p class="ph-section-label">Got Questions?</p>
            <h2 class="ph-section-title">Frequently Asked Questions</h2>
            </div>
    
            <div class="ph-faq-item">
            <button class="ph-faq-btn" onclick="toggleFaq(this)">
                How accurate is the real-time stock information?
                <span class="ph-faq-icon">+</span>
            </button>
            <div class="ph-faq-answer">
                Our partner pharmacies sync their inventory systems with PharmacaraHub every few minutes. Stock levels shown are typically accurate within a 15-minute window. We also display the last-updated timestamp on each pharmacy listing so you always know how fresh the data is.
            </div>
            </div>
    
            <div class="ph-faq-item">
            <button class="ph-faq-btn" onclick="toggleFaq(this)">
                Do I need a prescription to order medicines?
                <span class="ph-faq-icon">+</span>
            </button>
            <div class="ph-faq-answer">
                Over-the-counter medicines can be ordered without a prescription. For prescription-only (RX) medicines, you'll be prompted to upload a valid prescription during checkout. Our pharmacists review all prescriptions before orders are confirmed.
            </div>
            </div>
    
            <div class="ph-faq-item">
            <button class="ph-faq-btn" onclick="toggleFaq(this)">
                Which areas do you deliver to?
                <span class="ph-faq-icon">+</span>
            </button>
            <div class="ph-faq-answer">
                We currently deliver within Panabo City and select barangays in the surrounding Davao del Norte area. Coverage is expanding — enter your address at checkout to see if delivery is available at your location.
            </div>
            </div>
    
            <div class="ph-faq-item">
            <button class="ph-faq-btn" onclick="toggleFaq(this)">
                How do I set up prescription refill reminders?
                <span class="ph-faq-icon">+</span>
            </button>
            <div class="ph-faq-answer">
                Create a free account and head to the Prescription Management section in your dashboard. Upload your prescription, enter the dosage schedule, and we'll send you SMS or email reminders before you run out.
            </div>
            </div>
    
            <div class="ph-faq-item">
            <button class="ph-faq-btn" onclick="toggleFaq(this)">
                Is my personal and payment data safe?
                <span class="ph-faq-icon">+</span>
            </button>
            <div class="ph-faq-answer">
                Yes. All data is encrypted in transit and at rest. We do not store raw payment card details — payments are processed through a PCI-DSS compliant gateway. Your prescription data is kept private and only shared with the dispensing pharmacy.
            </div>
            </div>
    
        </div>
        </div>
    </div>
    </section>
    
    <!-- ── CTA ── -->
    <section class="ph-cta">
    <div class="container">
        <div class="ph-cta-box">
        <div>
            <h2>Ready to Take Control of Your Health?</h2>
            <p>Join thousands of patients who manage their medications smarter with PharmacaraHub.</p>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <a href="/register" class="ph-btn ph-btn-teal"><i class="bi bi-person-plus"></i> Create Free Account</a>
            <a href="/shop" class="ph-btn ph-btn-ghost"><i class="bi bi-bag"></i> Browse Shop</a>
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
            <li><a href="/services">Services</a></li>
            <li><a href="/shop">Shop</a></li>
            <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div class="col-lg-2 col-md-3 col-6">
            <p class="ph-footer-title">Services</p>
            <ul class="ph-footer-links">
            <li><a href="#">Medicine</a></li>
            <li><a href="#">Wellness</a></li>
            <li><a href="#">Diagnostics</a></li>
            <li><a href="#">Prescription</a></li>
            <li><a href="#">Home Delivery</a></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-6">
            <p class="ph-footer-title">Contact Us</p>
            <ul class="ph-footer-contact">
            <li><i class="bi bi-geo-alt-fill"></i><span>123 Healthcare Street, Panabo City, Mindanao</span></li>
            <li><i class="bi bi-telephone-fill"></i><span>+63 123 456 7890</span></li>
            <li><i class="bi bi-envelope-fill"></i><span>info@pharmacarehub.com</span></li>
            <li><i class="bi bi-clock-fill"></i><span>Mon – Sat: 8:00 AM – 8:00 PM</span></li>
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
            <span class="mx-2" style="color:rgba(255,255,255,0.15)">|</span>
            <a href="#">Terms of Service</a>
            <span class="mx-2" style="color:rgba(255,255,255,0.15)">|</span>
            <a href="#">Cookie Policy</a>
            </div>
        </div>
        </div>
    </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    /* ── FAQ ── */
    function toggleFaq(btn) {
        const item = btn.closest('.ph-faq-item');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.ph-faq-item.open').forEach(el => el.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    }
    
    /* ── Sticky tab active state on scroll ── */
    const tabLinks = document.querySelectorAll('.ph-tabs a');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
            const id = '#' + entry.target.id;
            tabLinks.forEach(a => {
            a.classList.toggle('active', a.getAttribute('href') === id);
            });
        }
        });
    }, { rootMargin: '-30% 0px -60% 0px' });
    
    ['medicine','wellness','diagnostics','prescription','delivery','health-corner'].forEach(id => {
        const el = document.getElementById(id);
        if (el) observer.observe(el);
    });
    
    /* ── Smooth scroll for tab links ── */
    tabLinks.forEach(a => {
        a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            const offset = 68 + 50;
            const top = target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }
        });
    });
    </script>
</body>
</html>