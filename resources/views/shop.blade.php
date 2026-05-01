{{-- resources/views/shop.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop - PharmacareHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --navy: #0B1354;
            --teal: #3DBDAA;
            --teal-lt: #E8F8F5;
            --teal-dk: #2a9e8d;
            --cream: #FAFAF7;
            --ink: #1A1A2E;
            --muted: #6B7280;
            --border: #E5E7EB;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--cream);
            color: var(--ink);
            margin: 0;
        }

        /* Product Cards */
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 1.25rem;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--ink);
        }

        .product-brand {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--teal);
            margin-bottom: 0.5rem;
        }

        .product-stock {
            font-size: 0.75rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .product-stock.low-stock {
            color: #dc3545;
        }

        .btn-add-cart {
            background: var(--teal);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            width: 100%;
            transition: background 0.15s;
        }

        .btn-add-cart:hover {
            background: var(--teal-dk);
            cursor: pointer;
        }

        .btn-add-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .cart-badge {
            position: relative;
            display: inline-block;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--teal);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background: var(--teal);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="ph-nav" style="position: relative; background: var(--navy);">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <a href="/" class="text-white text-decoration-none">
                <h3 class="mb-0">Pharmacare<span style="color: var(--teal);">Hub</span></h3>
            </a>
            
            <div class="d-flex gap-3 align-items-center">
                <a href="/" class="text-white text-decoration-none">Home</a>
                <a href="/shop" class="text-white text-decoration-none" style="color: var(--teal) !important;">Shop</a>
                @auth
                    <a href="/dashboard" class="text-white text-decoration-none">Dashboard</a>
                    <a href="/cart" class="cart-badge text-white text-decoration-none">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span id="cart-count" class="cart-count">{{ $cartCount }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Search Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <form method="GET" action="{{ route('shop') }}" class="row g-3">
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
                    <input type="text" name="search" class="form-control" placeholder="Search medicines..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="background: var(--teal); border-color: var(--teal);">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($medicines as $medicine)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="product-image">
                                @if($medicine->image && $medicine->image)
                                    <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}">
                                @else
                                    <div style="width: 100%; height: 100%; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 14px;">
                                        <i class="bi bi-capsule" style="font-size: 48px;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">{{ $medicine->name }}</h5>
                                <div class="product-brand">{{ $medicine->brand ?? 'Generic' }}</div>
                                <div class="product-price">₱{{ number_format($medicine->price, 2) }}</div>
                                <div class="product-stock {{ $medicine->stock <= $medicine->reorder_level ? 'low-stock' : '' }}">
                                    <i class="bi bi-box-seam"></i> Stock: {{ $medicine->stock }} units
                                </div>
                                <button class="btn-add-cart" data-id="{{ $medicine->id }}" onclick="addToCart(this)">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                        <h4 class="mt-3">No medicines found</h4>
                        <p class="text-muted">Try adjusting your search or browse all categories.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-5">
                {{ $medicines->appends(request()->query())->links() }}
            </div>
        </div>
    </section>

    <!-- Login Required Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--teal); color: white;">
                    <h5 class="modal-title">
                        <i class="bi bi-box-arrow-in-right"></i> Login Required
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-cart-plus" style="font-size: 64px; color: var(--teal);"></i>
                    <h4 class="mt-3">Please Login First</h4>
                    <p class="text-muted">You need to be logged in to add items to your cart.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('login') }}" class="btn" style="background: var(--teal); color: white;">
                        <i class="bi bi-box-arrow-in-right"></i> Login Now
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-person-plus"></i> Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast-notification">
        <i class="bi bi-check-circle"></i> <span id="toast-message">Added to cart!</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        
        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = message;
            toast.style.background = isError ? '#dc3545' : '#3DBDAA';
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function updateCartCount(count) {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
            }
        }

        function addToCart(button) {
        // Check if user is logged in via a fetch call
        fetch('{{ route("check.login") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.logged_in) {
                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                    return;
                }
                
                // Proceed with adding to cart
                const medicineId = button.getAttribute('data-id');
                button.disabled = true;
                button.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding...';
                
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        medicine_id: medicineId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
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
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error adding to cart', true);
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-cart-plus"></i> Add to Cart';
                });
            });
        }
    </script>
</body>
</html>