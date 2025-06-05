@extends('layouts.app')

@section('content')
    <div class="container my-5 contact-page">
        <nav class="mb-4 d-flex align-items-center checkout-nav">
            <a href="{{ url('/cart') }}" class="me-2 mx-2">SHOPPING CART</a>
            <i class="bi bi-arrow-right mx-2"></i>

            <a href="{{ url('/checkout') }}" class="me-2 mx-2">CHECKOUT</a>
            <i class="bi bi-arrow-right mx-2"></i>

            <a href="#" class="ms-2 current">ORDERS</a>
        </nav>

        <div class="row">
            @guest('customer')
                <div class="text-start py-3 mb-5">
                    <i class="bi bi-person-lock text-muted display-1 mb-4"></i>
                    <h3 class="mb-3">Please log in to view your orders</h3>
                    <p class="text-muted mb-4">You need to be signed in to see your order history.</p>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">Login
                        to Continue</a>
                </div>
            @endguest

            @auth('customer')
                <div class="col-12">
                    <h3 class="mb-4">My Orders</h3>

                    @if ($orders->isEmpty())
                        <div class="alert alert-info">
                            You have no orders yet.
                        </div>
                    @else
                        <div class="row">
                            @foreach ($orders as $order)
                                <div class="col-md-6">
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0">Order #{{ $order->id }}</h5>
                                                <span
                                                    class="badge 
                                            @if ($order->status === 'Pending') bg-warning 
                                            @elseif($order->status === 'Processing') bg-info 
                                            @elseif($order->status === 'Completed') bg-success 
                                            @elseif($order->status === 'Cancelled') bg-danger 
                                            @else bg-secondary @endif">
                                                    {{ $order->status }}
                                                </span>
                                            </div>

                                            <p class="mb-1"><strong>Placed on:</strong>
                                                {{ $order->created_at->format('F j, Y') }}</p>
                                            <p class="mb-1"><strong>Shipping Address:</strong> {{ $order->address }}</p>
                                            <p class="mb-3"><strong>Town:</strong> {{ $order->town }}, <strong>ZIP:</strong>
                                                {{ $order->zip }}</p>

                                            @php
                                                $grandTotal = 0;
                                            @endphp

                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">Price</th>
                                                            <th class="text-center">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->items as $item)
                                                            @if ($item->product)
                                                                @php
                                                                    $itemTotal = $item->quantity * $item->price;
                                                                    $grandTotal += $itemTotal;
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                                alt="{{ $item->product->name }}"
                                                                                class="rounded me-2" width="50">
                                                                            <span>{{ $item->product->name }}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                                    <td class="text-center">
                                                                        ₱{{ number_format($item->price, 2) }}</td>
                                                                    <td class="text-center">₱{{ number_format($itemTotal, 2) }}
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td colspan="4" class="text-danger">Product not found
                                                                        (may have
                                                                        been deleted)
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="text-end mt-3">
                                                <strong>Grand Total: ₱{{ number_format($grandTotal, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endauth
        </div>
    </div>
@endsection
