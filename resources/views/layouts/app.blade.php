<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Seamart - Fish Market</title>
    <link rel="icon" type="image/png" href="{{ asset('admin-assets/assets/images/logos/logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('App.css') }}" rel="stylesheet" />

</head>
<style>
    .custom-modal-width {
        max-width: 350px;
    }
</style>

<body class="font-sans antialiased">
    <!-- Search Overlay -->
    <div id="searchOverlay" class="search-overlay" style="background-color: white;">
        <div class="container py-4">
            @include('partials.search-results', [
                'results' => collect(),
                'featured' => \App\Models\Product::where('tags', 'LIKE', '%Best Seller%')->take(8)->get(),
                'query' => '',
            ])
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                <img src="{{ asset('admin-assets/assets/images/logos/logo2.png') }}" alt="Logo" height="30"
                    style="height: 50px; width: auto;">
            </a>

            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="/" class="nav-link text-dark">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('all-products') }}" class="nav-link">SHOP</a>
                    </li>

                    <li class="nav-item">
                        <a href="/featured" class="nav-link">FEATURED</a>
                    </li>

                    <li class="nav-item">
                        <a href="/sale" class="nav-link">SALE</a>
                    </li>

                    <li class="nav-item">
                        <a href="/about" class="nav-link">ABOUT</a>
                    </li>

                    <li class="nav-item">
                        <a href="/contact" class="nav-link">CONTACT</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <a href="#" class="text-dark" id="searchToggle" onclick="toggleSearch(event)">
                    <i class="bi bi-search" style="font-size: 25px;"></i>
                </a>

                <a href="/cart" class="btn position-relative text-dark">
                    <i class="bi bi-cart4" style="font-size: 25px;"></i>
                    <span class="position-absolute translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.6rem; top: 30%;" id="cartCount">
                        0
                        <span class="visually-hidden">items in cart</span>
                    </span>
                </a>

                @auth('customer')
                    <div class="dropdown d-inline-block user-dropdown position-relative"
                        onmouseover="clearTimeout(window.userDropdownTimeout); this.querySelector('.dropdown-menu').classList.add('show');"
                        onmouseout="window.userDropdownTimeout = setTimeout(() => { this.querySelector('.dropdown-menu').classList.remove('show'); }, 400);">
                        <span class="text-dark d-inline-block text-truncate dropdown-toggle"
                            style="max-width: 150px; cursor: pointer;" title="{{ Auth::guard('customer')->user()->name }}"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hello, <strong>{{ Auth::guard('customer')->user()->name }}</strong>
                        </span>

                        <ul class="dropdown-menu mt-1">
                            <li>
                                <a class="dropdown-item text-muted text-decoration-none" href="/customer/orders">
                                    <i class="bi bi-bag-check me-2"></i> Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-muted text-decoration-none" href="/customer/profile">
                                    <i class="bi bi-person-circle me-2"></i> My Account
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}" id="logoutForm">
                                    @csrf
                                    <button type="button" class="dropdown-item text-muted text-decoration-none"
                                        id="logoutBtn">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="#" class="text-dark" title="Login / Register" data-bs-toggle="modal"
                        data-bs-target="#loginRegisterModal">
                        <i class="bi bi-person" style="font-size: 25px;"></i>
                    </a>
                @endauth
                &nbsp;&nbsp;&nbsp;
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width">
            <div class="modal-content p-0">
                <div class="modal-body p-0">
                    <div class="card mb-0 border-0 shadow-none">
                        <div class="card-body">
                            <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('admin-assets/assets/images/logos/seamart-banner.png') }}"
                                    width="180" alt="logo">
                            </a>
                            <p class="text-center">Customer Login</p>

                            @if (session('error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ url('/customer/login') }}"> {{-- adjust route as needed --}}
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        required>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember"
                                            name="remember">
                                        <label class="form-check-label text-dark" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a class="text-primary" href="#"><small>Forgot Password?</small></a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 fs-5 mb-4 rounded-2">Sign
                                    In</button>
                            </form>

                            <div class="text-center">
                                <p class="mb-0">Don’t have an account?
                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#registerModal" data-bs-dismiss="modal">
                                        Register
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width">
            <div class="modal-content p-0">
                <div class="modal-body p-0">
                    <div class="card mb-0 border-0 shadow-none">
                        <div class="card-body">
                            <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('admin-assets/assets/images/logos/seamart-banner.png') }}"
                                    width="180" alt="logo">
                            </a>
                            <p class="text-center">Create Account</p>

                            @if (session('error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ url('/customer/register') }}"> {{-- Adjust this route if needed --}}
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="email_register" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email_register"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_register" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        id="password_register" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="password_confirmation" required>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 fs-5 mb-4 rounded-2">Register</button>
                            </form>

                            <div class="text-center">
                                <p class="mb-0">Already have an account?
                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#loginRegisterModal" data-bs-dismiss="modal">Login</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Header End -->
    <div class="container-fluid">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    <script>
        function toggleSearch(event) {
            event.preventDefault();
            const overlay = document.getElementById('searchOverlay');
            overlay.classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('searchForm');
            const input = document.getElementById('searchInput');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop normal submission

                const query = input.value.trim();
                if (!query) return;

                fetch(`/search/results?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('searchOverlay').innerHTML = html;
                    })
                    .catch(error => console.error('Search failed:', error));
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const productLinks = document.querySelectorAll('.product-trigger');

            // Modal trigger setup
            productLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const image = this.getAttribute('data-image');
                    const name = this.getAttribute('data-name');
                    const englishName = this.getAttribute('data-english-name');
                    const price = parseFloat(this.getAttribute('data-price'));
                    const discount = parseFloat(this.getAttribute('data-discount'));
                    const stock = this.getAttribute('data-stock');
                    const category = this.getAttribute('data-category');

                    // Set modal content
                    document.getElementById('modalProductId').value = id;
                    document.getElementById('modalImage').src = image;
                    document.getElementById('modalName').textContent = name;
                    document.getElementById('modalEnglishName').textContent = englishName;
                    document.querySelector('#productModal input[type="number"]').value = 1;
                    document.querySelector('#productModal input[type="number"]').max = stock;

                    let finalPrice = price;
                    let originalPrice = null;

                    if (discount > 0) {
                        originalPrice = price;
                        finalPrice = price - (price * (discount / 100));
                    }

                    const priceHTML = originalPrice ?
                        `₱${finalPrice.toFixed(2)}/kg <del class="text-muted fs-6 ms-2">₱${originalPrice.toFixed(2)}/kg</del>` :
                        `₱${finalPrice.toFixed(2)}/kg`;

                    document.getElementById('modalPrice').innerHTML = priceHTML;
                    document.getElementById('modalStock').textContent = `${stock} kg`;
                    const categoryBadge = document.getElementById('modalCategory');
                    categoryBadge.textContent = category;

                    // Badge color
                    let badgeClass = 'bg-secondary';
                    if (category === 'Salt Water Fish') badgeClass = 'bg-success';
                    else if (category === 'Fresh Water Fish') badgeClass = 'bg-primary';
                    else if (category === 'Crustaceans') badgeClass = 'bg-danger';
                    else if (category === 'Seaweed') badgeClass = 'bg-success';

                    categoryBadge.className = `badge ${badgeClass}`;
                });
            });

            // Add to Cart logic
            function getCart() {
                return JSON.parse(localStorage.getItem('cart')) || {};
            }

            function saveCart(cart) {
                localStorage.setItem('cart', JSON.stringify(cart));
            }

            function updateCartCount() {
                const cart = getCart();
                const count = Object.keys(cart).length;
                document.getElementById('cartCount').textContent = count;
            }

            function addToCart(product) {
                const cart = getCart();
                if (cart[product.id]) {
                    cart[product.id].qty += product.qty;
                } else {
                    cart[product.id] = product;
                }
                saveCart(cart);
                updateCartCount();

                // SweetAlert instead of alert
                Swal.fire({
                    title: 'Added to Cart!',
                    text: `${product.name} has been added to your cart.`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    location.reload(); // reload after alert closes
                });
            }

            // Event for Add to Cart button
            document.getElementById('addToCartBtn').addEventListener('click', function() {
                const id = document.getElementById('modalProductId').value;
                const name = document.getElementById('modalName').textContent;
                const image = document.getElementById('modalImage').src;
                const qty = parseInt(document.querySelector('#productModal input[type="number"]').value);
                const rawPrice = document.getElementById('modalPrice').innerText.match(/₱([\d.]+)/);
                const price = rawPrice ? parseFloat(rawPrice[1]) : 0;

                const product = {
                    id,
                    name,
                    image,
                    qty,
                    price
                };

                addToCart(product);
            });

            updateCartCount(); // initialize cart badge
        });

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('cart-items-container');
            const subtotalEl = document.getElementById('cart-subtotal');
            const totalEl = document.getElementById('cart-total');

            if (!container || !subtotalEl || !totalEl) {
                console.error('Required cart elements are missing.');
                return;
            }

            let cart = JSON.parse(localStorage.getItem('cart')) || {};

            function renderCart() {
                container.innerHTML = '';
                let total = 0;

                if (Object.keys(cart).length === 0) {
                    container.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
                    subtotalEl.textContent = '₱0.00';
                    totalEl.textContent = '₱0.00';
                    return;
                }

                Object.values(cart).forEach(product => {
                    const subtotal = product.price * product.qty;
                    total += subtotal;

                    const row = document.createElement('div');
                    row.className = 'row align-items-center border-bottom pb-3 mb-3';
                    row.innerHTML = `
                        <div class="col-12 col-md-6 d-flex mb-3 mb-md-0">
                            <button class="btn text-dark me-2 p-0 remove-btn" data-id="${product.id}">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <img src="${product.image}" alt="${product.name}" class="me-3 rounded" width="80" />
                            <div>
                                <p class="mb-1 fw-semibold">${product.name}</p>
                                <p class="mb-0 text-muted small">
                                    <strong>Weight:</strong> ${product.weight || '1 kg'} <br />
                                    <strong>Origin:</strong> Ocean/Sea
                                </p>
                            </div>
                        </div>

                        <div class="col-4 col-md-2">
                            <span class="d-block">₱${product.price.toFixed(2)}</span>
                        </div>

                        <div class="col-4 col-md-2">
                            <div class="input-group input-group-sm justify-content-center" style="max-width: 100px;">
                                <button class="btn btn-outline-secondary px-2 change-qty" data-id="${product.id}" data-action="decrease">-</button>
                                <input type="text" class="form-control text-center px-1" style="max-width: 40px;" value="${product.qty}" readonly />
                                <button class="btn btn-outline-secondary px-2 change-qty" data-id="${product.id}" data-action="increase">+</button>
                            </div>
                        </div>

                        <div class="col-4 col-md-2 text-dark fw-semibold">
                            ₱${subtotal.toFixed(2)}
                        </div>
                    `;
                    container.appendChild(row);
                });

                subtotalEl.textContent = `₱${total.toFixed(2)}`;
                totalEl.textContent = `₱${total.toFixed(2)}`;
            }

            container.addEventListener('click', function(e) {
                const btn = e.target.closest('.change-qty, .remove-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                cart = JSON.parse(localStorage.getItem('cart')) || {};

                if (btn.classList.contains('change-qty')) {
                    const action = btn.dataset.action;
                    if (!cart[id]) return;

                    if (action === 'increase') cart[id].qty++;
                    if (action === 'decrease' && cart[id].qty > 1) cart[id].qty--;

                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                }

                if (btn.classList.contains('remove-btn')) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This product will be removed from your cart.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            delete cart[id];
                            localStorage.setItem('cart', JSON.stringify(cart));
                            location.reload(); // or renderCart(); if you're using dynamic rendering
                        }
                    });
                }
            });

            renderCart();
        });

        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            const uniqueCount = Object.keys(cart).length;
            const badge = document.getElementById('cartCount');
            if (badge) {
                badge.textContent = uniqueCount > 0 ? uniqueCount : '';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const summaryContainer = document.getElementById('order-summary-container');
            const subtotalEl = document.getElementById('cart-subtotal');
            const totalEl = document.getElementById('cart-total');

            if (!summaryContainer || !subtotalEl || !totalEl) {
                console.error('Missing summary DOM elements.');
                return;
            }

            const cart = JSON.parse(localStorage.getItem('cart')) || {};
            let subtotal = 0;

            summaryContainer.innerHTML = '';

            if (Object.keys(cart).length === 0) {
                summaryContainer.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
                subtotalEl.textContent = '₱0.00';
                totalEl.textContent = '₱0.00';
                return;
            }

            Object.values(cart).forEach(product => {
                const lineTotal = product.price * product.qty;
                subtotal += lineTotal;

                const div = document.createElement('div');
                div.className = 'd-flex justify-content-between mb-3 align-items-center';
                div.innerHTML = `
                    <div class="d-flex align-items-start">
                        <img src="${product.image}" width="70" class="me-2 rounded" alt="Product Image">
                        <div>
                            <div class="fw-semibold">${product.name}</div>
                            <small>
                                Weight: 
                                <span class="text-muted">
                                    ${product.weight || '1 kg'}
                                </span>
                                <br>
                                Qty: ${product.qty}
                            </small>
                        </div>
                    </div>
                    <div class="text-end">₱${lineTotal.toFixed(2)}</div>
                `;
                summaryContainer.appendChild(div);
            });

            subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
            totalEl.textContent = `₱${subtotal.toFixed(2)}`;
        });

        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sold-trigger').forEach(function(img) {
                img.addEventListener('click', function(e) {
                    e.preventDefault(); // prevent any default action
                    img.classList.remove('sold-zoom'); // reset if it was clicked before
                    void img.offsetWidth; // force reflow to restart animation
                    img.classList.add('sold-zoom');
                });
            });
        });
    </script>
</body>
<footer class="text-white py-5" style="background-color: rgb(12, 76, 125);">
    <div class="container-fluid">
        <div class="d-flex justify-content-center align-items-center flex-wrap gap-5">
            {{-- Logo & Contact --}}
            <div class="d-flex align-items-center gap-4 mb-3 mb-md-0">
                <img src="{{ asset('admin-assets/assets/images/logos/logo3.png') }}" alt="SeaMart"
                    style="width: 220px; height: 60px;" />
                <div>
                    <p class="address mb-1" style="line-height: 1.2;">
                        Cagayan State University - Gonzaga Campus <br>Flourishing, Gonzaga, Cagayan<br />
                        <a href="mailto:customerservice@seamart.com.ph" class="email text-white text-decoration-none">
                            customerservice@seamart.com.ph
                        </a>
                    </p>
                </div>
            </div>

            {{-- Social Links --}}
            <div>
                <ul class="list-unstyled link small mb-0">
                    <li>
                        <a href="#" class="text-white fs-4 d-flex align-items-center gap-2" target="_blank"
                            rel="noopener noreferrer">
                            <i class="bi bi-facebook"></i> <span class="fs-6 fst-italic">SeaMart
                                E-Commerce@facebook.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white fs-4 d-flex align-items-center gap-2" target="_blank"
                            rel="noopener noreferrer">
                            <i class="bi bi-instagram"></i> <span class="fs-6 fst-italic">SeaMart Online
                                Shop@instagram</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- About Us --}}
            <div>
                <h5 class="footer-title mb-2">About Us</h5>
                <ul class="list-unstyled link small mb-0">
                    <li><a href="#" class="text-decoration-none text-white">FAQs</a></li>
                    <li><a href="/privacy" class="text-decoration-none text-white">PRIVACY POLICY</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="container-fluid mt-3">
        <hr />
        <div class="text-center" style="margin-bottom: -30px; margin-top: 10px;">
            <p class="copyright mb-0 small" style="line-height: 1;">
                Copyright 2025 &copy; SeaMart Inc. All rights reserved
            </p>
        </div>
    </div>
</footer>

</html>
