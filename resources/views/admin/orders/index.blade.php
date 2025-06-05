@extends('layouts.admin')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 border border-light">
                    <h2 class="mb-4">Customer Orders</h2>

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}',
                                confirmButtonColor: '#3085d6',
                            });
                        </script>
                    @endif
                    <div class="mb-3">
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="form-inline">
                            <label for="status" class="me-2 fw-bold">Filter by Status:</label>
                            <select name="status" id="status" class="form-select w-auto d-inline"
                                onchange="this.form.submit()">
                                <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All</option>
                                <option value="Pending"
                                    {{ request('status') === null || request('status') == 'Pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total (₱)</th>
                                    <th>Status</th>
                                    <th>Ordered At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>ORD-{{ $order->created_at->format('Ymd-H') }}{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $order->customer->email ?? 'N/A' }}</td>
                                        <td>{{ $order->phone ?? 'N/A' }}</td>
                                        <td>₱{{ number_format($order->items->sum(fn($item) => $item->quantity * $item->price), 2) }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $order->status === 'Completed' ? 'success' : ($order->status === 'Cancelled' ? 'danger' : 'warning') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#orderModal{{ $order->id }}">
                                                <i
                                                    class="ti {{ $order->status === 'Pending' ? 'ti-settings' : 'ti-eye' }} me-1"></i>
                                                {{ $order->status === 'Pending' ? 'Process' : 'Review' }}
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable text-dark">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="orderModalLabel{{ $order->id }}">Order
                                                                #{{ $order->id }} Review</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 mt-0">
                                                                @if ($order->status === 'Completed' || $order->status === 'Cancelled')
                                                                    <span
                                                                        class="badge bg-{{ $order->status === 'Completed' ? 'success' : 'danger' }} ms-2">
                                                                        {{ $order->status }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="row mb-4">
                                                                <!-- Customer Details -->
                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="border rounded p-3 h-100 bg-light text-dark">
                                                                        <h6 class="border-bottom pb-2 mb-3">
                                                                            CUSTOMER DETAILS
                                                                        </h6>
                                                                        <ul class="list-unstyled mb-0">
                                                                            <li class="mb-2"><b>Name:</b>
                                                                                {{ $order->customer->name ?? 'N/A' }}</li>
                                                                            <li class="mb-2"><b>Email:</b>
                                                                                {{ $order->customer->email ?? 'N/A' }}</li>
                                                                            <li class="mb-2"><b>Phone:</b>
                                                                                {{ $order->phone ?? 'N/A' }}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <!-- Billing Address -->
                                                                <div class="col-md-6 mt-4 mt-md-0">
                                                                    <div
                                                                        class="border rounded p-3 h-100 bg-light text-dark">
                                                                        <h6 class="border-bottom pb-2 mb-3 text-dark">
                                                                            BILLING ADDRESS
                                                                        </h6>
                                                                        <ul class="list-unstyled mb-0">
                                                                            <li class="mb-2">
                                                                                <b>Address:</b>
                                                                                {{ $order->address ?? '' }},
                                                                                {{ $order->brgy ?? '' }},
                                                                                {{ $order->town ?? '' }}, Cagayan
                                                                            </li>
                                                                            <li class="mb-2"><b>Landmark:</b>
                                                                                {{ $order->address2 ?? 'None' }}</li>
                                                                            <li class="mb-2"><b>ZipCode:</b>
                                                                                {{ $order->zip ?? 'N/A' }}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <h6>ORDER ITEMS</h6>
                                                            <table class="table table-sm table-bordered">
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
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                                            alt="{{ $item->product->name }}"
                                                                                            class="rounded me-2"
                                                                                            width="50">
                                                                                        <span>{{ $item->product->name }}</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $item->quantity }}</td>
                                                                                <td class="text-center">
                                                                                    ₱{{ number_format($item->price, 2) }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    ₱{{ number_format($item->quantity * $item->price, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>

                                                            <div class="text-end mt-3">
                                                                <strong>Total:
                                                                    ₱{{ number_format($order->items->sum(fn($item) => $item->quantity * $item->price), 2) }}
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if ($order->status === 'Pending')
                                                                <form
                                                                    action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="Cancelled">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Deny</button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="Completed">
                                                                    <button type="submit"
                                                                        class="btn btn-success">Approve</button>
                                                                </form>
                                                            @endif

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
