{{-- resources/views/shop.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop — PharmacareHub</title>

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

        /* Cart badge */
        .ph-cart-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: rgba(255,255,255,0.78) !important;
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 8px;
            transition: color 0.15s, background 0.15s;
        }

        .ph-cart-link:hover { color: white !important; background: rgba(255,255,255,0.1); }

        .ph-cart-count {
            position: absolute;
            top: 0px;
            right: 4px;
            background: var(--teal);
            color: white;
            border-radius: 50%;
            width: 17px;
            height: 17px;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* ── HERO ── */
        .ph-hero {
            margin-top: 68px;
            position: relative;
            height: 320px;
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
            filter: blur(5px) brightness(0.4);
            transform: scale(1.06);
        }

        .ph-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(11,19,84,0.7) 0%, rgba(11,19,84,0.25) 60%, rgba(61,189,170,0.15) 100%);
        }

        .ph-hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            padding: 0 1.5rem;
            max-width: 620px;
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
            margin-bottom: 1rem;
            animation: fadeUp 0.6s ease both;
        }

        .ph-hero-content h1 {
            font-family: 'Lora', serif;
            font-size: clamp(28px, 5vw, 48px);
            font-weight: 600;
            line-height: 1.15;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .ph-hero-content p {
            font-size: 15px;
            color: rgba(255,255,255,0.72);
            margin-bottom: 0;
            line-height: 1.7;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        .ph-hero-wave {
            position: absolute;
            bottom: -1px; left: 0; right: 0;
            z-index: 11;
            line-height: 0;
        }

        .ph-hero-wave svg { width: 100%; height: 50px; display: block; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── SEARCH BAR ── */
        .ph-search-bar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 0;
            position: sticky;
            top: 68px;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .ph-search-bar .form-control,
        .ph-search-bar .form-select {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            color: var(--ink);
            padding: 10px 16px;
            transition: border-color 0.15s, box-shadow 0.15s;
            background: var(--cream);
        }

        .ph-search-bar .form-control:focus,
        .ph-search-bar .form-select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(61,189,170,0.15);
            outline: none;
        }

        .ph-search-btn {
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .ph-search-btn:hover { background: #162b8a; color: white; }

        /* ── SHOP LAYOUT ── */
        .ph-shop-section { padding: 3rem 0 5rem; }

        /* Active filter pills */
        .ph-filter-pills {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .ph-filter-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .ph-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            background: var(--teal-lt);
            color: var(--teal-dk);
            padding: 4px 12px;
            border-radius: 99px;
            border: 1px solid rgba(61,189,170,0.35);
        }

        .ph-pill a {
            color: var(--teal-dk);
            text-decoration: none;
            font-weight: 700;
            opacity: 0.7;
            transition: opacity 0.15s;
        }

        .ph-pill a:hover { opacity: 1; }

        /* Results header */
        .ph-results-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .ph-results-count {
            font-size: 13px;
            color: var(--muted);
        }

        .ph-results-count strong {
            color: var(--ink);
            font-weight: 600;
        }

        /* ── PRODUCT CARDS ── */
        .ph-product-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
            height: 100%;
            position: relative;
        }

        .ph-product-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--teal);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.28s ease;
        }

        .ph-product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(61,189,170,0.3);
        }

        .ph-product-card:hover::after { transform: scaleX(1); }

        .ph-product-image {
            height: 190px;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .ph-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .ph-product-card:hover .ph-product-image img { transform: scale(1.05); }

        .ph-product-image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #c4c9d4;
            gap: 8px;
            width: 100%; height: 100%;
        }

        .ph-product-image-placeholder i { font-size: 44px; }
        .ph-product-image-placeholder span { font-size: 11px; font-weight: 500; letter-spacing: 0.04em; }

        .ph-category-chip {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: rgba(11,19,84,0.82);
            color: white;
            padding: 3px 9px;
            border-radius: 99px;
            backdrop-filter: blur(4px);
        }

        .ph-product-body {
            padding: 1.1rem 1.25rem 1.35rem;
        }

        .ph-product-brand {
            font-size: 11px;
            font-weight: 600;
            color: var(--teal-dk);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }

        .ph-product-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 10px;
            line-height: 1.35;
        }

        .ph-product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.9rem;
        }

        .ph-product-price {
            font-family: 'Lora', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--navy);
        }

        .ph-stock-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 99px;
        }

        .ph-stock-ok {
            background: #D1FAE5;
            color: #065F46;
        }

        .ph-stock-low {
            background: #FEE2E2;
            color: #991B1B;
        }

        .ph-btn-cart {
            width: 100%;
            background: var(--teal);
            color: white;
            border: none;
            border-radius: 9px;
            padding: 9px 0;
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }

        .ph-btn-cart:hover { background: var(--teal-dk); }
        .ph-btn-cart:active { transform: scale(0.98); }
        .ph-btn-cart:disabled { background: #d1d5db; cursor: not-allowed; transform: none; }

        /* ── EMPTY STATE ── */
        .ph-empty {
            text-align: center;
            padding: 5rem 1rem;
        }

        .ph-empty-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--teal-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--teal-dk);
            margin: 0 auto 1.5rem;
        }

        .ph-empty h4 {
            font-family: 'Lora', serif;
            font-size: 22px;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .ph-empty p { font-size: 14px; color: var(--muted); }

        /* ── TOAST ── */
        .ph-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            background: var(--navy);
            color: white;
            padding: 13px 20px;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            display: none;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            min-width: 220px;
            border-left: 4px solid var(--teal);
            animation: slideIn 0.3s ease;
        }

        .ph-toast.show { display: flex; }

        .ph-toast i { font-size: 18px; color: var(--teal); flex-shrink: 0; }

        @keyframes slideIn {
            from { transform: translateX(110%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

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

        /* ── PAGINATION ── */
        .pagination .page-link {
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            color: var(--navy);
            border-color: var(--border);
            border-radius: 8px;
            margin: 0 2px;
            padding: 7px 13px;
        }
        .pagination .page-item.active .page-link {
            background: var(--teal);
            border-color: var(--teal);
            color: white;
        }
        .pagination .page-link:hover { background: var(--teal-lt); color: var(--teal-dk); border-color: var(--teal); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .ph-nav-links { display: none; }
            .ph-hero { height: 260px; }
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
        <li><a href="/services">Services</a></li>
        <li><a href="/shop" class="active ph-btn-shop">Shop</a></li>
        @auth
            <li><a href="/dashboard">Dashboard</a></li>
            <li>
                <a href="/cart" class="ph-cart-link">
                    <i class="bi bi-cart3" style="font-size: 18px;"></i>
                    <span id="cart-count" class="ph-cart-count">{{ $cartCount }}</span>
                </a>
            </li>
        @else
            <li><a href="{{ route('login') }}">Log in</a></li>
            <li><a href="{{ route('register') }}" class="ph-btn-outline">Register</a></li>
        @endauth
    </ul>
</header>

<!-- ── HERO ── -->
<section class="ph-hero">
    <div class="ph-hero-bg">
        <img src="images/carousel_1.jpg" alt="Shop Hero"
             onerror="this.src='https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=1400&q=80'">
    </div>
    <div class="ph-hero-overlay"></div>

    <div class="ph-hero-content">
        <span class="ph-hero-tag">Trusted Medicines</span>
        <h1>Browse Our Shop</h1>
        <p>Real-time availability, verified medicines, and wellness products — all in one place.</p>
    </div>

    <div class="ph-hero-wave">
        <svg viewBox="0 0 1440 50" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,25 C360,50 1080,0 1440,25 L1440,50 L0,50 Z" fill="#FAFAF7"/>
        </svg>
    </div>
</section>

<!-- ── STICKY SEARCH BAR ── -->
<div class="ph-search-bar">
    <div class="container">
        <form method="GET" action="{{ route('shop') }}" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-7">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; pointer-events: none;"></i>
                    <input type="text" name="search" class="form-control" style="padding-left: 40px;"
                           placeholder="Search medicines, brands, categories…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="ph-search-btn w-100">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ── SHOP SECTION ── -->
<section class="ph-shop-section">
    <div class="container">

        <!-- Active filters & results count -->
        <div class="ph-results-header">
            <div>
                @if(request('search') || request('category'))
                    <div class="ph-filter-pills mb-2">
                        <span class="ph-filter-label">Filters:</span>
                        @if(request('category'))
                            <span class="ph-pill">
                                <i class="bi bi-tag-fill" style="font-size:10px;"></i>
                                {{ request('category') }}
                                <a href="{{ route('shop', array_merge(request()->except('category'))) }}">×</a>
                            </span>
                        @endif
                        @if(request('search'))
                            <span class="ph-pill">
                                <i class="bi bi-search" style="font-size:10px;"></i>
                                "{{ request('search') }}"
                                <a href="{{ route('shop', array_merge(request()->except('search'))) }}">×</a>
                            </span>
                        @endif
                    </div>
                @endif
                <p class="ph-results-count mb-0">
                    Showing <strong>{{ $medicines->firstItem() }}–{{ $medicines->lastItem() }}</strong>
                    of <strong>{{ $medicines->total() }}</strong> products
                </p>
            </div>
            <a href="{{ route('shop') }}" class="text-decoration-none" style="font-size:13px; color:var(--teal-dk); font-weight:500;">
                <i class="bi bi-arrow-counterclockwise"></i> Clear all
            </a>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            @forelse($medicines as $medicine)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="ph-product-card">
                        <div class="ph-product-image">
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}">
                            @else
                                <div class="ph-product-image-placeholder">
                                    <i class="bi bi-capsule"></i>
                                    <span>No image</span>
                                </div>
                            @endif

                            @if($medicine->category ?? false)
                                <span class="ph-category-chip">{{ $medicine->category }}</span>
                            @endif
                        </div>

                        <div class="ph-product-body">
                            <div class="ph-product-brand">{{ $medicine->brand ?? 'Generic' }}</div>
                            <h5 class="ph-product-name">{{ $medicine->name }}</h5>

                            <div class="ph-product-footer">
                                <div class="ph-product-price">₱{{ number_format($medicine->price, 2) }}</div>
                                @if($medicine->stock <= ($medicine->reorder_level ?? 10))
                                    <span class="ph-stock-badge ph-stock-low">
                                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 9px;"></i>
                                        Low stock
                                    </span>
                                @else
                                    <span class="ph-stock-badge ph-stock-ok">
                                        <i class="bi bi-check-circle-fill" style="font-size: 9px;"></i>
                                        In stock
                                    </span>
                                @endif
                            </div>

                            <button class="ph-btn-cart" data-id="{{ $medicine->id }}" onclick="addToCart(this)"
                                {{ $medicine->stock == 0 ? 'disabled' : '' }}>
                                @if($medicine->stock == 0)
                                    <i class="bi bi-x-circle"></i> Out of Stock
                                @else
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="ph-empty">
                        <div class="ph-empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4>No medicines found</h4>
                        <p>Try a different search term or browse all categories.</p>
                        <a href="{{ route('shop') }}" class="btn mt-2" style="background: var(--teal); color: white; border-radius: 10px; font-size: 14px; font-weight: 600; padding: 10px 24px;">
                            <i class="bi bi-arrow-left"></i> Browse all products
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($medicines->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $medicines->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</section>

<!-- ── LOGIN MODAL ── -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
            <div class="modal-header border-0" style="background: var(--navy); padding: 1.5rem 2rem 1rem;">
                <h5 class="modal-title text-white" style="font-family: 'Lora', serif; font-size: 18px;">
                    Login Required
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4 px-4">
                <div style="width: 72px; height: 72px; border-radius: 50%; background: var(--teal-lt); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-size: 30px; color: var(--teal-dk);">
                    <i class="bi bi-cart-plus"></i>
                </div>
                <h5 style="font-family: 'Lora', serif; color: var(--navy); margin-bottom: 0.5rem;">Please Login First</h5>
                <p style="font-size: 14px; color: var(--muted);">You need to be logged in to add items to your cart.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4 gap-3">
                <a href="{{ route('login') }}" class="btn" style="background: var(--navy); color: white; border-radius: 10px; font-weight: 600; padding: 10px 24px; font-size: 14px;">
                    <i class="bi bi-box-arrow-in-right"></i> Login Now
                </a>
                <a href="{{ route('register') }}" class="btn" style="border: 1.5px solid var(--border); color: var(--ink); border-radius: 10px; font-weight: 600; padding: 10px 24px; font-size: 14px;">
                    <i class="bi bi-person-plus"></i> Create Account
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ── TOAST ── -->
<div id="ph-toast" class="ph-toast">
    <i class="bi bi-check-circle-fill" id="toast-icon"></i>
    <span id="toast-message">Added to cart!</span>
</div>

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
    function showToast(message, isError = false) {
        const toast = document.getElementById('ph-toast');
        const icon  = document.getElementById('toast-icon');
        document.getElementById('toast-message').textContent = message;
        icon.className = isError ? 'bi bi-x-circle-fill' : 'bi bi-check-circle-fill';
        icon.style.color = isError ? '#f87171' : 'var(--teal)';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3200);
    }

    function updateCartCount(count) {
        const el = document.getElementById('cart-count');
        if (el) el.textContent = count;
    }

    function addToCart(button) {
        fetch('{{ route("check.login") }}')
            .then(r => r.json())
            .then(data => {
                if (!data.logged_in) {
                    new bootstrap.Modal(document.getElementById('loginModal')).show();
                    return;
                }

                const medicineId = button.getAttribute('data-id');
                button.disabled = true;
                button.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding…';

                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ medicine_id: medicineId, quantity: 1 })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message);
                        updateCartCount(data.cart_count);
                    } else {
                        showToast(data.message, true);
                    }
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-cart-plus"></i> Add to Cart';
                })
                .catch(() => {
                    showToast('Error adding to cart', true);
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-cart-plus"></i> Add to Cart';
                });
            });
    }
</script>
</body>
</html>