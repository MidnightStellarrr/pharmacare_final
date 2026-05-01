<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - PharmacareHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
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

        /* Cart Styles */
        .cart-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .cart-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .cart-header {
            background: var(--navy);
            color: white;
            padding: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th {
            text-align: left;
            padding: 15px;
            background: #f8f9fa;
            border-bottom: 2px solid var(--border);
        }

        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-brand {
            font-size: 12px;
            color: var(--muted);
        }

        .quantity-input {
            width: 70px;
            padding: 5px;
            border: 1px solid var(--border);
            border-radius: 6px;
            text-align: center;
        }

        .btn-update {
            background: var(--teal);
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            margin-left: 5px;
        }

        .btn-update:hover {
            background: var(--teal-dk);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .cart-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            position: sticky;
            top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .summary-total {
            font-size: 20px;
            font-weight: 700;
            color: var(--teal);
        }

        .btn-checkout {
            background: var(--teal);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background: var(--teal-dk);
        }

        .btn-continue {
            background: var(--navy);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-continue:hover {
            background: #0f1a6b;
            color: white;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart i {
            font-size: 80px;
            color: var(--muted);
            margin-bottom: 20px;
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
        @else
        <li><a href="{{ route('login') }}">Log in</a></li>
        <li><a href="{{ route('register') }}" class="ph-btn-outline">Register</a></li>
        @endauth 
        </ul>
    </header>

    <div class="cart-container">
        <div class="cart-card">
            <div class="cart-header">
                <h3 class="mb-0"><i class="bi bi-cart3"></i> Your Shopping Cart</h3>
            </div>

            <div id="cart-content">
                <!-- Loading state -->
                <div class="text-center py-5">
                    <div class="spinner-border text-teal" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
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

        function loadCart() {
            fetch('{{ route("cart.view") }}')
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML to get cart data
                    return fetch('/api/cart-data');
                })
                .then(response => response.json())
                .then(data => {
                    displayCart(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadCartFallback();
                });
        }

        function loadCartFallback() {
            // Alternative: get cart data from API endpoint you need to create
            fetch('/pharmacist/inventory-data')
                .then(response => response.json())
                .then(data => {
                    // For demo purposes - replace with actual cart data
                    displayDemoCart();
                });
        }

        function displayCart(cart) {
            const container = document.getElementById('cart-content');
            
            if (!cart.items || cart.items.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <i class="bi bi-cart-x"></i>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="/shop" class="btn-continue">Start Shopping</a>
                    </div>
                `;
                return;
            }

            let itemsHtml = `
                <div class="row">
                    <div class="col-lg-8">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            cart.items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                itemsHtml += `
                    <tr id="cart-item-${item.id}">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                ${item.medicine.image ? 
                                    `<img src="/storage/${item.medicine.image}" class="cart-item-image" alt="${item.medicine.name}">` :
                                    `<div class="cart-item-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-capsule" style="font-size: 24px; color: #999;"></i>
                                    </div>`
                                }
                                <div>
                                    <div class="cart-item-title">${item.medicine.name}</div>
                                    <div class="cart-item-brand">${item.medicine.brand || 'Generic'}</div>
                                </div>
                            </div>
                        </td>
                        <td>₱${parseFloat(item.price).toFixed(2)}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" 
                                    id="qty-${item.id}" 
                                    value="${item.quantity}" 
                                    min="1" 
                                    max="${item.medicine.stock}"
                                    class="quantity-input">
                                <button onclick="updateCartItem(${item.id})" class="btn-update">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                        <td class="item-total-${item.id}">₱${itemTotal.toFixed(2)}</td>
                        <td>
                            <button onclick="deleteCartItem(${item.id})" class="btn-delete">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                `;
            });

            itemsHtml += `
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h5>Order Summary</h5>
                            <div class="summary-row">
                                <span>Subtotal (${cart.item_count} items)</span>
                                <span>₱${cart.total.toFixed(2)}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>Calculated at checkout</span>
                            </div>
                            <div class="summary-row summary-total">
                                <strong>Total</strong>
                                <strong>₱${cart.total.toFixed(2)}</strong>
                            </div>
                            <button class="btn-checkout" onclick="checkout()">
                                Proceed to Checkout
                            </button>
                            <a href="/shop" class="btn-continue" style="display: block; text-align: center;">
                                <i class="bi bi-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            `;

            container.innerHTML = itemsHtml;
        }

        function displayDemoCart() {
            // Demo cart display
            const container = document.getElementById('cart-content');
            container.innerHTML = `
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="/shop" class="btn-continue">Start Shopping</a>
                </div>
            `;
        }

        function updateCartItem(itemId) {
            const quantity = document.getElementById(`qty-${itemId}`).value;
            
            fetch('{{ route("cart.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Cart updated successfully!');
                    // Update the total display
                    document.querySelector(`.item-total-${itemId}`).textContent = `₱${data.item_total.toFixed(2)}`;
                    // Update cart summary
                    updateCartSummary(data.cart_total, data.cart_count);
                } else {
                    showToast(data.message, true);
                    // Reset to original value
                    loadCart();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating cart', true);
            });
        }

        function deleteCartItem(itemId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                fetch(`{{ url("/cart/remove") }}/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Item removed from cart');
                        // Remove the row
                        document.getElementById(`cart-item-${itemId}`).remove();
                        // Update cart summary
                        updateCartSummary(data.cart_total, data.cart_count);
                        // Reload if cart is empty
                        const remainingRows = document.querySelectorAll('#cart-content tbody tr').length;
                        if (remainingRows === 0) {
                            loadCart();
                        }
                    } else {
                        showToast(data.message, true);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Error removing item', true);
                });
            }
        }

        function updateCartSummary(total, count) {
            const summaryDiv = document.querySelector('.cart-summary');
            if (summaryDiv) {
                summaryDiv.innerHTML = `
                    <h5>Order Summary</h5>
                    <div class="summary-row">
                        <span>Subtotal (${count} items)</span>
                        <span>₱${total.toFixed(2)}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <div class="summary-row summary-total">
                        <strong>Total</strong>
                        <strong>₱${total.toFixed(2)}</strong>
                    </div>
                    <button class="btn-checkout" onclick="checkout()">
                        Proceed to Checkout
                    </button>
                    <a href="/shop" class="btn-continue" style="display: block; text-align: center;">
                        <i class="bi bi-arrow-left"></i> Continue Shopping
                    </a>
                `;
            }
            
            // Update cart count in navbar if exists
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
            }
        }

        function checkout() {
            showToast('Checkout feature coming soon!');
            // window.location.href = '/checkout';
        }

        // Load cart when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
        });
    </script>
</body>
</html>