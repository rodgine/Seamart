@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card p-4 border-light border">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">PRODUCT MANAGEMENT</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="ti ti-plus"></i> Add Product
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0 text-dark" id="myTable">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Discount</th>
                                <th>Tags</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                width="60">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <div class="input-group input-group-sm" style="width: 130px;">
                                            <button class="btn btn-outline-dark stock-btn" type="button"
                                                data-id="{{ $product->id }}" data-action="decrease">−</button>

                                            <input type="number" class="form-control text-center stock-amount"
                                                id="stock-input-{{ $product->id }}" value="1" min="1"
                                                style="max-width: 65px;">

                                            <button class="btn btn-outline-dark stock-btn" type="button"
                                                data-id="{{ $product->id }}" data-action="increase">+</button>
                                        </div>
                                        <div class="text-center mt-1">
                                            <small>
                                                Current:
                                                <span class="fw-bold"
                                                    id="stock-{{ $product->id }}">{{ $product->stock }}</span>
                                                @php
                                                    $stock = $product->stock;
                                                    $badgeClass = 'bg-success'; // Default: high

                                                    if ($stock == 0) {
                                                        $badgeClass = 'bg-danger';
                                                        $stockLevel = 'No stock';
                                                    } elseif ($stock < 5) {
                                                        $badgeClass = 'bg-warning';
                                                        $stockLevel = 'Low';
                                                    } else {
                                                        $stockLevel = '';
                                                    }
                                                @endphp
                                                <span
                                                    class="badge {{ $badgeClass }} ms-1 fs-1">{{ $stockLevel }}</span>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm discount-select"
                                            data-id="{{ $product->id }}" style="width: 90px;">
                                            @foreach ([0, 5, 10, 15, 20, 25, 30, 50, 70, 80] as $percent)
                                                <option value="{{ $percent }}"
                                                    {{ (int) $product->discount === $percent ? 'selected' : '' }}>
                                                    {{ $percent }}%
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        @if ($product->tags)
                                            @foreach (explode(',', $product->tags) as $tag)
                                                <span
                                                    class="badge bg-success rounded-pill me-1 mt-1"><small>{{ trim($tag) }}</small></span>
                                                <br>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No tags</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-english_name="{{ $product->english_name }}"
                                            data-description="{{ $product->description }}"
                                            data-category="{{ $product->category_id }}" data-price="{{ $product->price }}"
                                            data-stock="{{ $product->stock }}" data-tags="{{ $product->tags }}"
                                            data-url="{{ route('admin.products.update', $product) }}"
                                            data-bs-toggle="modal" data-bs-target="#editProductModal">
                                            <i class="ti ti-edit"></i> Edit
                                        </button>

                                        <button class="btn btn-sm btn-danger delete-btn"
                                            data-url="{{ route('admin.products.destroy', $product) }}">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6 mb-3">
                        <label>Product Name (Local)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Product Name (English)</label>
                        <input type="text" name="english_name" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Price</label>
                        <input type="number" name="price" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" min="0" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tags</label>
                        <input type="text" name="tags" class="form-control" placeholder="Comma separated tags">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editProductForm" method="POST" class="modal-content" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" id="edit-product-id" name="id">
                    <div class="col-md-6 mb-3">
                        <label>Product Name</label>
                        <input type="text" id="edit-product-name" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Product Name (English)</label>
                        <input type="text" id="edit-product-english-name" name="english_name" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Category</label>
                        <select id="edit-product-category" name="category_id" class="form-control" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Price</label>
                        <input type="number" id="edit-product-price" name="price" step="0.01" min="0"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stock</label>
                        <input type="number" id="edit-product-stock" name="stock" min="0"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tags</label>
                        <input type="text" id="edit-product-tags" name="tags" class="form-control"
                            placeholder="Comma separated tags">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea id="edit-product-description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Image (optional)</label>
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
        <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                $(document).ready(function() {
                    $('#myTable').DataTable({
                        lengthChange: false,
                        pageLength: 5,
                        ordering: false
                    });
                });
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const {
                            id,
                            name,
                            english_name,
                            description,
                            category,
                            price,
                            stock,
                            tags,
                            url
                        } = this.dataset;

                        document.getElementById('edit-product-id').value = id;
                        document.getElementById('edit-product-name').value = name;
                        document.getElementById('edit-product-english-name').value = english_name;
                        document.getElementById('edit-product-description').value = description;
                        document.getElementById('edit-product-category').value = category;
                        document.getElementById('edit-product-price').value = price;
                        document.getElementById('edit-product-stock').value = stock;
                        document.getElementById('edit-product-tags').value = tags || '';

                        document.getElementById('editProductForm').action = url;
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.url;

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.action = url;
                                form.method = 'POST';
                                form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    });
                });
                @if (session('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                @endif
            });

            document.addEventListener('DOMContentLoaded', () => {
                // Handle stock buttons
                document.querySelectorAll('.stock-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const action = this.dataset.action;
                        const input = document.getElementById(`stock-input-${productId}`);
                        const value = parseInt(input.value);

                        if (isNaN(value) || value <= 0) {
                            Swal.fire('Invalid Input', 'Please enter a valid number greater than 0.',
                                'warning');
                            return;
                        }

                        const verb = action === 'increase' ? 'add' : 'subtract';

                        Swal.fire({
                            title: `Are you sure you want to ${verb} ${value} stock?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/admin/products/${productId}/stock`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            action,
                                            amount: value
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            document.getElementById(`stock-${productId}`)
                                                .innerText = data.stock;
                                            Swal.fire('Updated!', data.message, 'success')
                                                .then(() => {
                                                    location
                                                        .reload(); // Reload page after the alert is closed
                                                });
                                        } else {
                                            Swal.fire('Error!', data.message, 'error');
                                        }
                                    });
                            }
                        });
                    });
                });

                // Handle discount dropdown
                document.querySelectorAll('.discount-select').forEach(select => {
                    select.addEventListener('change', function() {
                        const productId = this.dataset.id;
                        const discount = this.value;

                        Swal.fire({
                            title: `Apply ${discount}% discount?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/admin/products/${productId}/discount`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            discount
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Success!', data.message, 'success');
                                        } else {
                                            Swal.fire('Error!', data.message, 'error');
                                        }
                                    });
                            }
                            location.reload();
                        });
                    });
                });
            });
        </script>
    @endpush

@endsection
