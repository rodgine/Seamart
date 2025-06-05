@extends('layouts.app')

@section('content')
    <div class="container-fluid home-container">
        <!-- New Arrivals -->
        <section class="new-arrivals">
            <div class="container-fluid">
                <header class="mt-4 mb-2 text-center">
                    <h1 class="fw-bold">Featured Products</h1>
                    <p class="text-muted">Hand-picked selections just for you</p>
                    <nav aria-label="breadcrumb" class="d-flex justify-content-center gap-2">
                        <a href="/" class="text-decoration-none">Home</a> /
                        <a href="{{ url('all-products') }}" class="text-decoration-none">Shop</a> /
                        <span class="text-muted">Featured</span>
                    </nav>
                </header>
                @php
                    $catchOfTheDay = $products->filter(fn($p) => str_contains(strtolower($p->tags ?? ''), 'top catch'));
                    $seasonalDeals = $products->filter(fn($p) => preg_match('/seasonal|limited|hot/i', $p->tags ?? ''));
                    $bestSellers = $products->filter(fn($p) => str_contains(strtolower($p->tags ?? ''), 'best seller'));
                @endphp

                {{-- Catch of the Day Section --}}
                @if ($catchOfTheDay->isNotEmpty())
                    <h3 class="mb-3 mt-5">Catch of the Day</h3>
                    <div class="row">
                        @foreach ($catchOfTheDay as $product)
                            {{-- FULL PRODUCT CARD BLOCK --}}
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="collection-items position-relative">
                                    <a href="#" class="d-block position-relative product-trigger"
                                        data-bs-toggle="modal" data-bs-target="#productModal" data-id="{{ $product->id }}"
                                        data-name="{{ strtoupper($product->name) }}"
                                        data-english-name="{{ $product->english_name ?? 'Not Identified' }}"
                                        data-price="{{ number_format($product->price, 2) }}"
                                        data-discount="{{ $product->discount ?? 0 }}" data-stock="{{ $product->stock }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">

                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                            alt="{{ $product->name }}"
                                            style="object-fit: contain; width: 100%; height: auto;">

                                        @if ($product->stock == 0)
                                            <img src="{{ asset('admin-assets/assets/images/logos/sold.png') }}"
                                                alt="Sold Out"
                                                class="position-absolute top-50 start-50 translate-middle sold-overlay"
                                                style="max-width: 100%;">
                                        @endif

                                        <i class="bi bi-cart-plus position-absolute cart-btn bg-primary text-light fs-5"
                                            title="Add to cart"></i>
                                    </a>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div class="mt-2 text-uppercase">{{ strtoupper($product->name) }}</div>
                                            @php
                                                $category = $product->category->name ?? '';
                                                $badgeClass = match ($category) {
                                                    'Salt Water Fish' => 'success',
                                                    'Fresh Water Fish' => 'primary',
                                                    'Crustaceans' => 'danger',
                                                    'Seaweed' => 'success',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            @if ($product->category)
                                                <span class="badge bg-{{ $badgeClass }} mt-1 category-badge">
                                                    {{ $category }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-1 text-dark fw-bold">{{ $product->english_name ?? 'Not Identified' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @php
                                                $price = $product->price;
                                                $originalPrice = $product->price;
                                                $discount = $product->discount;
                                                if ($discount && $discount > 0) {
                                                    $discountAmount = $price * ($discount / 100);
                                                    $price -= $discountAmount;
                                                }
                                            @endphp
                                            <div>
                                                <span class="text-muted">&#8369; {{ number_format($price, 2) }}/kg</span>
                                                @if ($originalPrice > $price)
                                                    <del class="text-danger ms-1">&#8369;
                                                        {{ number_format($originalPrice, 2) }}/kg</del>
                                                @endif
                                            </div>
                                            <span class="text-muted small">Stocks: {{ $product->stock }}kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Seasonal Deals Section --}}
                @if ($seasonalDeals->isNotEmpty())
                    <h3 class="mb-3 mt-5">Seasonal Deals</h3>
                    <div class="row">
                        @foreach ($seasonalDeals as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="collection-items position-relative">
                                    <a href="#" class="d-block position-relative product-trigger"
                                        data-bs-toggle="modal" data-bs-target="#productModal" data-id="{{ $product->id }}"
                                        data-name="{{ strtoupper($product->name) }}"
                                        data-english-name="{{ $product->english_name ?? 'Not Identified' }}"
                                        data-price="{{ number_format($product->price, 2) }}"
                                        data-discount="{{ $product->discount ?? 0 }}" data-stock="{{ $product->stock }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">

                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                            alt="{{ $product->name }}"
                                            style="object-fit: contain; width: 100%; height: auto;">

                                        @if ($product->stock == 0)
                                            <img src="{{ asset('admin-assets/assets/images/logos/sold.png') }}"
                                                alt="Sold Out"
                                                class="position-absolute top-50 start-50 translate-middle sold-overlay"
                                                style="max-width: 100%;">
                                        @endif

                                        <i class="bi bi-cart-plus position-absolute cart-btn bg-primary text-light fs-5"
                                            title="Add to cart"></i>
                                    </a>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div class="mt-2 text-uppercase">{{ strtoupper($product->name) }}</div>
                                            @php
                                                $category = $product->category->name ?? '';
                                                $badgeClass = match ($category) {
                                                    'Salt Water Fish' => 'success',
                                                    'Fresh Water Fish' => 'primary',
                                                    'Crustaceans' => 'danger',
                                                    'Seaweed' => 'success',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            @if ($product->category)
                                                <span class="badge bg-{{ $badgeClass }} mt-1 category-badge">
                                                    {{ $category }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-1 text-dark fw-bold">{{ $product->english_name ?? 'Not Identified' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @php
                                                $price = $product->price;
                                                $originalPrice = $product->price;
                                                $discount = $product->discount;
                                                if ($discount && $discount > 0) {
                                                    $discountAmount = $price * ($discount / 100);
                                                    $price -= $discountAmount;
                                                }
                                            @endphp
                                            <div>
                                                <span class="text-muted">&#8369; {{ number_format($price, 2) }}/kg</span>
                                                @if ($originalPrice > $price)
                                                    <del class="text-danger ms-1">&#8369;
                                                        {{ number_format($originalPrice, 2) }}/kg</del>
                                                @endif
                                            </div>
                                            <span class="text-muted small">Stocks: {{ $product->stock }}kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Best Sellers Section --}}
                @if ($bestSellers->isNotEmpty())
                    <h3 class="mb-3 mt-5">Best Sellers</h3>
                    <div class="row">
                        @foreach ($bestSellers as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="collection-items position-relative">
                                    <a href="#" class="d-block position-relative product-trigger"
                                        data-bs-toggle="modal" data-bs-target="#productModal" data-id="{{ $product->id }}"
                                        data-name="{{ strtoupper($product->name) }}"
                                        data-english-name="{{ $product->english_name ?? 'Not Identified' }}"
                                        data-price="{{ number_format($product->price, 2) }}"
                                        data-discount="{{ $product->discount ?? 0 }}" data-stock="{{ $product->stock }}"
                                        data-category="{{ $product->category->name }}"
                                        data-image="{{ asset('storage/' . $product->image) }}">

                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                            alt="{{ $product->name }}"
                                            style="object-fit: contain; width: 100%; height: auto;">

                                        @if ($product->stock == 0)
                                            <img src="{{ asset('admin-assets/assets/images/logos/sold.png') }}"
                                                alt="Sold Out"
                                                class="position-absolute top-50 start-50 translate-middle sold-overlay"
                                                style="max-width: 100%;">
                                        @endif

                                        <i class="bi bi-cart-plus position-absolute cart-btn bg-primary text-light fs-5"
                                            title="Add to cart"></i>
                                    </a>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div class="mt-2 text-uppercase">{{ strtoupper($product->name) }}</div>
                                            @php
                                                $category = $product->category->name ?? '';
                                                $badgeClass = match ($category) {
                                                    'Salt Water Fish' => 'success',
                                                    'Fresh Water Fish' => 'primary',
                                                    'Crustaceans' => 'danger',
                                                    'Seaweed' => 'success',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            @if ($product->category)
                                                <span class="badge bg-{{ $badgeClass }} mt-1 category-badge">
                                                    {{ $category }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-1 text-dark fw-bold">{{ $product->english_name ?? 'Not Identified' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @php
                                                $price = $product->price;
                                                $originalPrice = $product->price;
                                                $discount = $product->discount;
                                                if ($discount && $discount > 0) {
                                                    $discountAmount = $price * ($discount / 100);
                                                    $price -= $discountAmount;
                                                }
                                            @endphp
                                            <div>
                                                <span class="text-muted">&#8369; {{ number_format($price, 2) }}/kg</span>
                                                @if ($originalPrice > $price)
                                                    <del class="text-danger ms-1">&#8369;
                                                        {{ number_format($originalPrice, 2) }}/kg</del>
                                                @endif
                                            </div>
                                            <span class="text-muted small">Stocks: {{ $product->stock }}kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Fallback --}}
                @if ($catchOfTheDay->isEmpty() && $seasonalDeals->isEmpty() && $bestSellers->isEmpty())
                    <p class="text-center">No featured products at the moment.</p>
                @endif
            </div>
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-6">
                                    <img id="modalImage" src="" class="img-fluid" alt="Product Image">
                                    <div class="d-flex gap-2 mt-3">
                                        {{-- If you want thumbnails later --}}
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-6">
                                    <h5 class="fw-bold" id="modalName">Product Name</h5>
                                    <p class="text-muted" id="modalEnglishName">English Name</p>
                                    <h4 class="text-danger mb-3" id="modalPrice">₱0.00/kg</h4>

                                    <div class="mb-3">
                                        <span class="badge" id="modalCategory">Category</span>
                                        <span class="ms-2">Stock: <b id="modalStock">0 kg</b></span>
                                    </div>
                                    <input type="hidden" id="modalProductId">
                                    <!-- Quantity Input -->
                                    <div class="input-group mb-3" style="max-width: 150px;">
                                        <span class="input-group-text">Qty</span>
                                        <input type="number" class="form-control" value="1" min="1">
                                    </div>

                                    <!-- Add to Cart Button -->
                                    <button class="btn btn-dark w-100" id="addToCartBtn">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>

                                    <!-- Order Button -->
                                    <button class="btn btn-primary w-100 mt-2">
                                        <i class="bi bi-bag-check me-2"></i> Order Now
                                    </button>

                                    <div class="mt-3">
                                        <small class="text-muted">Unapologetic flavor meets unmatched freshness. Great for
                                            sinigang, grill, or fry.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer py-2 px-3 border-0 mt-0">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
