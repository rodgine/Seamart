@extends('layouts.app')

@section('content')
    <div class="container my-5 contact-page">
        <nav class="mb-4 d-flex align-items-center checkout-nav">
            <a href="{{ url('/cart') }}" class="me-2 mx-2">SHOPPING CART</a>
            <i class="bi bi-arrow-right mx-2"></i>

            <a href="#" class="me-2 current mx-2">CHECKOUT</a>
            <i class="bi bi-arrow-right mx-2"></i>

            @auth('customer')
                <a href="{{ url('/customer/orders') }}" class="ms-2">COMPLETE ORDER</a>
            @else
                <a class="ms-2 disabled text-muted" style="pointer-events: none; cursor: not-allowed;">COMPLETE ORDER</a>
            @endauth
        </nav>

        <div class="row">
            @guest('customer')
                <div class="text-start py-3 mb-5">
                    <i class="bi bi-person-lock text-muted display-1 mb-4"></i>
                    <h3 class="mb-3">Please log in to proceed with checkout</h3>
                    <p class="text-muted mb-4">You need to be signed in to complete your purchase.</p>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">Login
                        to Continue</a>
                </div>
            @endguest

            @auth('customer')
                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf

                    <div class="row">
                        @foreach ($addresses as $address)
                            <div class="col-md-5 border rounded mx-3 p-3 mb-4 address-option {{ $address->default ? 'selected-address' : '' }}"
                                data-address='@json($address)' onclick="selectAddress(this)">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-geo-alt-fill"></i>
                                        &nbsp;&nbsp;
                                        <strong>
                                            {{ $address->first_name }} {{ $address->middle_name }} {{ $address->last_name }}
                                        </strong>
                                        (+63)
                                        {{ substr($address->phone, 0, 2) . str_repeat('*', strlen($address->phone) - 4) . substr($address->phone, -2) }}<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $address->address }}, {{ $address->address2 }}<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Brgy. {{ $address->brgy }}, {{ $address->town }}, Cagayan<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Email: {{ $address->email }}
                                    </div>
                                    <div>
                                        @if ($address->default)
                                            <span class="badge bg-success">Default</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        {{-- Billing Details --}}
                        <div class="col-md-7">
                            <h4 class="mb-4">Billing Details</h4>
                            <div class="row">
                                <input type="hidden" name="cart_data" id="cart_data_input">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="first_name" name="first_name" class="form-control"
                                        value="{{ old('first_name', $defaultAddress?->first_name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="last_name" name="last_name" class="form-control"
                                        value="{{ old('last_name', $defaultAddress?->last_name) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Country / Region <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Philippines" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Street address <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="address" name="address" class="form-control mb-2"
                                    placeholder="House number and street name or Purok number"
                                    value="{{ old('address', $defaultAddress?->address) }}" required>
                                <input type="text" name="address2" class="form-control"
                                    placeholder="Any landmark available (optional)"
                                    value="{{ old('address2', $defaultAddress?->address2) }}">
                            </div>

                            <div class="mb-3">
                                <label for="brgy" class="form-label">Barangay <span class="text-danger">*</span></label>
                                <input type="text" id="brgy" name="brgy" class="form-control"
                                    value="{{ old('brgy', $defaultAddress?->brgy) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="town" class="form-label">Town / City <span class="text-danger">*</span></label>
                                <select id="town" name="town" class="form-select" required onchange="updateZip()">
                                    <option value="">Select an option…</option>
                                    @php
                                        $towns = [
                                            'Abulog' => '3517',
                                            'Alcala' => '3507',
                                            'Allacapan' => '3523',
                                            'Amulung' => '3505',
                                            'Aparri' => '3515',
                                            'Baggao' => '3506',
                                            'Ballesteros' => '3516',
                                            'Buguey' => '3511',
                                            'Calayan' => '3520',
                                            'Camalaniugan' => '3510',
                                            'Claveria' => '3519',
                                            'Enrile' => '3501',
                                            'Gattaran' => '3508',
                                            'Gonzaga' => '3513',
                                            'Iguig' => '3504',
                                            'Lal-lo' => '3509',
                                            'Lasam' => '3524',
                                            'Pamplona' => '3522',
                                            'Peñablanca' => '3502',
                                            'Piat' => '3527',
                                            'Rizal' => '3526',
                                            'Sanchez Mira' => '3518',
                                            'Solana' => '3503',
                                            'Sta. Ana' => '3514',
                                            'Sta. Praxedes' => '3521',
                                            'Sta. Teresita' => '3512',
                                            'Sto. Niño' => '3525',
                                            'Tuao' => '3528',
                                            'Tuguegarao' => '3500',
                                        ];
                                        $selectedTown = old('town', $defaultAddress?->town);
                                    @endphp
                                    @foreach ($towns as $town => $zip)
                                        <option value="{{ $town }}|{{ $zip }}"
                                            {{ $selectedTown == $town ? 'selected' : '' }}>
                                            {{ $town }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="zip" class="form-label">Postcode / ZIP <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="zip" name="zip" class="form-control"
                                    value="{{ old('zip', $defaultAddress?->zip) }}" readonly required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('phone', $defaultAddress?->phone) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address <span
                                        class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email', $defaultAddress?->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="order_notes" class="form-label">Order notes (optional)</label>
                                <textarea id="order_notes" name="order_notes" class="form-control" rows="4"
                                    placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>

                        {{-- Order Summary --}}
                        <div class="col-md-5">
                            <div class="border rounded p-4">
                                <h5 class="mb-4">Your Order</h5>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <strong>PRODUCT</strong>
                                    <strong>SUBTOTAL</strong>
                                </div>

                                {{-- Injected Cart Items --}}
                                <div id="order-summary-container">
                                    {{-- Ideally populated via backend or JS --}}
                                </div>

                                {{-- Subtotal --}}
                                <div class="d-flex justify-content-between border-top pt-2 mt-3">
                                    <span>Subtotal</span>
                                    <strong class="text-danger" id="cart-subtotal">₱0.00</strong>
                                </div>

                                {{-- Shipping Notice --}}
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Shipping</span>
                                    <span class="text-muted">Enter your address to view shipping options.</span>
                                </div>

                                {{-- Total --}}
                                <div class="d-flex justify-content-between border-top pt-3 mt-3">
                                    <strong>Total</strong>
                                    <strong class="text-danger fs-5" id="cart-total">₱0.00</strong>
                                </div>

                                {{-- Payment Methods --}}
                                <div class="mt-4">
                                    <h6 class="mb-3">Choose a payment method</h6>

                                    <div class="row g-2">
                                        {{-- COD --}}
                                        <div class="col-md-6">
                                            <label for="cod"
                                                class="w-100 border rounded p-3 d-flex align-items-center justify-content-between payment-option">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="mode_of_payment" id="cod" value="Cash on Delivery"
                                                        {{ old('mode_of_payment', 'Cash on Delivery') == 'Cash on Delivery' ? 'checked' : '' }}>
                                                    <span class="fw-bold">Cash/COD</span>
                                                </div>
                                                <div class="payment-logo-wrapper">
                                                    <img src="{{ asset('admin-assets/assets/images/logos/cod3.png') }}"
                                                        alt="COD">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- GCash --}}
                                        <div class="col-md-6">
                                            <label for="gcash"
                                                class="w-100 border rounded p-3 d-flex align-items-center justify-content-between payment-option">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="mode_of_payment" id="gcash" value="GCash"
                                                        {{ old('mode_of_payment') == 'GCash' ? 'checked' : '' }}>
                                                    <span>GCash</span>
                                                </div>
                                                <div class="payment-logo-wrapper">
                                                    <img src="{{ asset('admin-assets/assets/images/logos/gcash.png') }}"
                                                        alt="GCash">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- GrabPay --}}
                                        <div class="col-md-6">
                                            <label for="grabpay"
                                                class="w-100 border rounded p-3 d-flex align-items-center justify-content-between payment-option">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="mode_of_payment" id="grabpay" value="GrabPay"
                                                        {{ old('mode_of_payment') == 'GrabPay' ? 'checked' : '' }}>
                                                    <span>GrabPay</span>
                                                </div>
                                                <div class="payment-logo-wrapper">
                                                    <img src="{{ asset('admin-assets/assets/images/logos/grabpay.png') }}"
                                                        alt="GrabPay">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- Maya --}}
                                        <div class="col-md-6">
                                            <label for="maya"
                                                class="w-100 border rounded p-3 d-flex align-items-center justify-content-between payment-option">
                                                <div class="d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="mode_of_payment" id="maya" value="Maya"
                                                        {{ old('mode_of_payment') == 'Maya' ? 'checked' : '' }}>
                                                    <span>PayMaya&nbsp;</span>
                                                </div>
                                                <div class="payment-logo-wrapper">
                                                    <img src="{{ asset('admin-assets/assets/images/logos/maya.avif') }}"
                                                        alt="Maya">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Validation Error Message --}}
                                    @error('mode_of_payment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-4">Place Order</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stateSelect = document.getElementById('town');
                const zipInput = document.getElementById('zip');

                stateSelect.addEventListener('change', function() {
                    const selected = this.value;
                    if (selected.includes('|')) {
                        const zip = selected.split('|')[1];
                        zipInput.value = zip;
                    } else {
                        zipInput.value = '';
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form#checkoutForm');
                if (!form) return;

                const cartDataInput = document.getElementById('cart_data_input');
                if (!cartDataInput) return;

                form.addEventListener('submit', function(e) {
                    const cart = JSON.parse(localStorage.getItem('cart') || '{}');

                    if (Object.keys(cart).length === 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart is empty',
                            text: 'Please add items to your cart before checking out.',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    cartDataInput.value = JSON.stringify(cart);

                    const currentInput = {
                        first_name: document.getElementById('first_name').value,
                        last_name: document.getElementById('last_name').value,
                        address: document.getElementById('address').value,
                        address2: document.getElementsByName('address2')[0].value,
                        brgy: document.getElementById('brgy').value,
                        town: document.getElementById('town').value.split('|')[0],
                        zip: document.getElementById('zip').value,
                        phone: document.getElementById('phone').value,
                        email: document.getElementById('email').value
                    };

                    const normalize = val => (val ?? '').toString().trim().toLowerCase();

                    const existingAddresses = @json($addresses);
                    console.log('📦 Existing Addresses:', existingAddresses);

                    const fieldsToCheck = ['address', 'address2', 'brgy', 'town'];

                    console.log('📝 Current Input:', currentInput);

                    // Log normalized comparison for each address
                    existingAddresses.forEach((addr, index) => {
                        console.log(`🔍 Checking Address #${index + 1}`);
                        fieldsToCheck.forEach(field => {
                            const inputVal = normalize(currentInput[field]);
                            const dbVal = normalize(addr[field]);
                            console.log(`   - Field: ${field}`);
                            console.log(`     → Current Input: '${inputVal}'`);
                            console.log(`     → DB Address:    '${dbVal}'`);
                            console.log(`     → Match? ${inputVal === dbVal}`);
                        });
                    });

                    const isDuplicate = existingAddresses.some(addr =>
                        fieldsToCheck.every(field =>
                            normalize(addr[field]) === normalize(currentInput[field])
                        )
                    );

                    console.log('✅ Is Duplicate Address:', isDuplicate);

                    if (existingAddresses.length > 0 && !isDuplicate) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Save new address?',
                            text: 'This address is different from your saved ones. Do you want to add it?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#aaa',
                            confirmButtonText: 'Yes, save it'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'confirm_new_address';
                                input.value = '1';
                                form.appendChild(input);
                                form.submit();
                            } else {
                                form.submit();
                            }
                        });
                    }
                });
            });
        </script>
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const cart = JSON.parse(localStorage.getItem('cart')) || {};

                    // Remove only items where selected === true
                    Object.keys(cart).forEach(key => {
                        if (cart[key].selected === true) {
                            delete cart[key];
                        }
                    });

                    localStorage.setItem('cart', JSON.stringify(cart)); // Save updated cart

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: @json(session('success')),
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        window.location.href = '/customer/orders';
                    });
                });
            </script>
        @endif
        <script>
            function selectAddress(element) {
                const address = JSON.parse(element.dataset.address);

                // Remove "selected" highlight from all
                document.querySelectorAll('.address-option').forEach(opt => opt.classList.remove('selected-address'));
                element.classList.add('selected-address');

                // Fill in the form fields
                document.getElementById('first_name').value = address.first_name;
                document.getElementById('last_name').value = address.last_name;
                document.getElementById('address').value = address.address;
                document.getElementsByName('address2')[0].value = address.address2;
                document.getElementById('brgy').value = address.brgy;
                document.getElementById('town').value = address.town + '|' + getZip(address.town);
                document.getElementById('zip').value = address.zip;
                document.getElementById('phone').value = address.phone;
                document.getElementById('email').value = address.email;
            }

            function getZip(town) {
                const zipMap = {
                    'Abulog': '3517',
                    'Alcala': '3507',
                    'Allacapan': '3523',
                    'Amulung': '3505',
                    'Aparri': '3515',
                    'Baggao': '3506',
                    'Ballesteros': '3516',
                    'Buguey': '3511',
                    'Calayan': '3520',
                    'Camalaniugan': '3510',
                    'Claveria': '3519',
                    'Enrile': '3501',
                    'Gattaran': '3508',
                    'Gonzaga': '3513',
                    'Iguig': '3504',
                    'Lal-lo': '3509',
                    'Lasam': '3524',
                    'Pamplona': '3522',
                    'Peñablanca': '3502',
                    'Piat': '3527',
                    'Rizal': '3526',
                    'Sanchez Mira': '3518',
                    'Solana': '3503',
                    'Sta. Ana': '3514',
                    'Sta. Praxedes': '3521',
                    'Sta. Teresita': '3512',
                    'Sto. Niño': '3525',
                    'Tuao': '3528',
                    'Tuguegarao': '3500'
                };

                return zipMap[town] || '';
            }

            // Optional: preload ZIP on first load
            document.addEventListener('DOMContentLoaded', () => {
                const townField = document.getElementById('town');
                if (townField.value) {
                    const town = townField.value.split('|')[0];
                    document.getElementById('zip').value = getZip(town);
                }
            });
        </script>
    @endpush
@endsection
