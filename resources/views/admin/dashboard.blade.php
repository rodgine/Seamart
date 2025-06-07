@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card p-4 h-100 product-overview border border-light">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-4 me-4 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px;">
                        <i class="ti ti-package fs-6"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted fs-5">Total Products</p>
                        <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card p-4 h-100 border border-light">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle p-4 me-4 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px;">
                        <i class="ti ti-shopping-cart fs-6"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted fs-5">Total Orders</p>
                        <h4 class="fw-bold mb-0">{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card p-4 h-100 border border-light">
                <div class="d-flex align-items-center">
                    <div class="bg-warning text-white rounded-circle p-4 me-4 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px;">
                        <i class="ti ti-users fs-6"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted fs-5">Total Customers</p>
                        <h4 class="fw-bold mb-0">{{ $totalCustomers }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100 border-light d-flex flex-column">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-4">
                        <h5 class="card-title fw-semibold">Recent Transactions</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative">
                        @php
                            $colors = ['success', 'danger', 'primary', 'warning'];
                        @endphp

                        @forelse ($logs as $log)
                            @php
                                $color = $colors[$loop->index % count($colors)];
                            @endphp
                            <li class="timeline-item d-flex position-relative overflow-hidden mb-3">
                                <div class="timeline-time text-dark flex-shrink-0 text-end me-3" style="min-width: 100px;">
                                    {{ \Carbon\Carbon::parse($log->date)->format('M d, Y') }}
                                </div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center me-3">
                                    <span
                                        class="timeline-badge border-2 border border-{{ $color }} flex-shrink-0 my-2"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-1">
                                    {!! $log->description !!}
                                </div>
                            </li>
                        @empty
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-time text-muted flex-shrink-0 text-end me-3" style="min-width: 100px;">
                                    N/A
                                </div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center me-3">
                                    <span class="timeline-badge border-2 border border-danger flex-shrink-0 my-2"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-6 text-muted mt-1">
                                    No transactions yet.
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recently Added Products -->
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Recently Added Products</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Id</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Product</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Category</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Stock</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Price</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stockLabels = [
                                        'low' => ['label' => 'Low', 'class' => 'bg-warning'],
                                        'medium' => ['label' => 'Medium', 'class' => 'bg-primary'],
                                        'high' => ['label' => 'High', 'class' => 'bg-success'],
                                    ];
                                @endphp

                                @foreach ($products as $index => $product)
                                    @php
                                        $stockLevel =
                                            $product->stock < 10 ? 'low' : ($product->stock < 50 ? 'medium' : 'high');
                                    @endphp
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $index + 1 }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                    style="width: 70px; height: auto; border-radius: 5px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                                                    <span class="fw-normal"><i>{{ $product->english_name }}</i></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $product->category->name ?? 'N/A' }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge {{ $stockLabels[$stockLevel]['class'] }} rounded-3 fw-semibold">
                                                    {{ $stockLabels[$stockLevel]['label'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4">
                                                &#8369;{{ number_format($product->price) }}/kg</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 m-3">
            <h5 class="most-viewed-products">Best Selling Products</h5>
        </div>

        @forelse ($bestSellingProducts as $product)
            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2 border-light">
                    <div class="position-relative">
                        <a href="#"><img src="{{ asset('storage/' . $product->image) }}"
                                class="card-img-top rounded-0" alt="Product Image"></a>
                        <a href="#"
                            class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                            <i class="ti ti-basket fs-4"></i>
                        </a>
                    </div>
                    <div class="card-body pt-3 p-4">
                        <h6 class="fw-semibold fs-4">{{ $product->name }}</h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="fw-semibold fs-4 mb-0">
                                @if ($product->discount != 0)
                                    &#8369; {{ number_format($product->price - $product->discount, 2) }}/kg
                                    <br>
                                    <span class="ms-2 fw-normal text-danger fs-3">
                                        <del>&#8369; {{ number_format($product->price, 2) }}/kg</del>
                                    </span>
                                @else
                                    &#8369; {{ number_format($product->price, 2) }}/kg
                                @endif
                            </h6>
                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                @for ($i = 0; $i < 5; $i++)
                                    <li><i class="ti ti-star text-warning me-1"></i></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No best selling products found.</p>
            </div>
        @endforelse
    </div>
@endsection
