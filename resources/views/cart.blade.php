@extends('layouts.app')

@section('content')
    <div class="container my-5 contact-page">
        <nav class="mb-4 d-flex align-items-center checkout-nav">
            <a href="#" class="me-2 current mx-2">SHOPPING CART</a>
            <i class="bi bi-arrow-right mx-2"></i>

            <a href="{{ url('/checkout') }}" class="me-2"
                @guest('customer')
                        style="pointer-events: none; cursor: not-allowed;"
                    @endguest>CHECKOUT</a>
            <i class="bi bi-arrow-right mx-2"></i>

            @auth
                <a href="{{ url('/cart') }}" class="ms-2">COMPLETE ORDER</a>
            @else
                <a class="ms-2 disabled text-muted" style="pointer-events: none; cursor: not-allowed;">COMPLETE ORDER</a>
            @endauth
        </nav>

        <div class="row">
            <div class="col-md-8">
                {{-- Free Shipping Message --}}
                <div class="p-3 mb-4 border-dashed">
                    <p class="mb-2 text-muted">Your order qualifies for free shipping!</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: 100%; background-image: repeating-linear-gradient(45deg, rgb(12, 76, 125), rgb(12, 76, 125) 13px, #fff 10px, #fff 20px);">
                        </div>
                    </div>
                </div>

                {{-- Add Select All Checkbox --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="select-all" checked>
                    <label class="form-check-label" for="select-all">
                        Select All Items
                    </label>
                </div>

                {{-- Table Headings --}}
                <div
                    class="d-none d-md-flex border-bottom text-align-center pb-2 mb-2 fw-semibold text-uppercase text-muted">
                    <div class="col-md-6">Product</div>
                    <div class="col-md-2">Price</div>
                    <div class="col-md-2">Quantity</div>
                    <div class="col-md-2">Subtotal</div>
                </div>

                {{-- Dynamic Cart Items --}}
                <div id="cart-items-container"></div>
            </div>

            {{-- Cart Totals --}}
            <div class="col-md-4">
                <div class="border p-4">
                    <h5 class="fw-bold">CART TOTALS</h5>
                    <div class="row my-2">
                        <div class="col-6 text-start fw-normal">Subtotal</div>
                        <div class="col-6 text-end fw-semibold" id="cart-subtotal">₱580.00</div>
                    </div>
                    <div class="row my-2">
                        <div class="col-6 text-start fw-normal">Shipping</div>
                        <div class="col-6 text-end text-muted small">Shipping costs are calculated during checkout.</div>
                    </div>

                    <hr />
                    <div class="d-flex justify-content-between my-2 fw-bold text-danger fs-5">
                        <span>Total</span>
                        <span id="cart-total">₱580.00</span>
                    </div>
                    <a href="/checkout" id="checkoutBtn"
                        class="btn btn-dark w-100 mt-3 
                        @guest('customer') disabled @endguest">
                        PROCEED TO CHECKOUT
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutBtn = document.getElementById('checkoutBtn');

        checkoutBtn.addEventListener('click', function(event) {
            @guest('customer')
                return; // Don't do anything if guest
            @else
                const cart = JSON.parse(localStorage.getItem('cart')) || {};
                const hasSelectedItems = Object.values(cart).some(item => item.selected === true);

                if (!hasSelectedItems) {
                    event.preventDefault(); // Stop the redirect
                    Swal.fire({
                        icon: 'warning',
                        title: 'No items selected',
                        text: 'Please select at least one item to proceed to checkout.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            @endguest
        });
    });
</script>
