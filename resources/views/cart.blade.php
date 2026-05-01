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
            --navy: #0B1354;
            --teal: #3DBDAA;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <header style="position: fixed; top: 0; left: 0; right: 0; background: var(--navy); z-index: 1000;">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <a href="/" class="text-white text-decoration-none">
                <h3 class="mb-0">Pharmacare<span style="color: var(--teal);">Hub</span></h3>
            </a>
            <div class="d-flex gap-3">
                <a href="/shop" class="text-white text-decoration-none">Continue Shopping</a>
                <a href="/dashboard" class="text-white text-decoration-none">Dashboard</a>
            </div>
        </div>
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