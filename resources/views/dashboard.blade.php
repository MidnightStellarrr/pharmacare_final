<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ph-btn-outline" style="background: none; border: 1px solid rgba(255,255,255,0.3); cursor: pointer;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>
        @else
        <li><a href="{{ route('login') }}">Log in</a></li>
        <li><a href="{{ route('register') }}" class="ph-btn-outline">Register</a></li>
        @endauth 
        </ul>
    </header>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600">You're logged in as a customer.</p>
                        </div>
                    </div>                   
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="/shop" class="block bg-teal-500 hover:bg-teal-700 text-white text-center py-2 rounded">
                            Shop Medicines
                        </a>
                        <a href="/cart" class="block bg-blue-500 hover:bg-blue-700 text-white text-center py-2 rounded">
                            View Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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

</body>
</html>
