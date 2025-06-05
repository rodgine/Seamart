@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4 fw-bold">My Profile</h2>

        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ $profile && $profile->picture
                    ? asset('storage/' . $profile->picture)
                    : asset('admin-assets/assets/images/logos/defaulte-profile.avif') }}"
                    alt="Profile Picture" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <p class="text-muted">
                    Customer Since:
                    <strong>{{ \Carbon\Carbon::parse($customer->created_at)->format('F Y') }}</strong>
                </p>
            </div>

            <div class="col-md-8">
                @if ($profile)
                    <div class="card border p-4">
                        <h5 class="fw-semibold mb-3">Personal Information</h5>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>Last Name:</strong> {{ $profile->lname }}</div>
                            <div class="col-md-8"><strong>First Name:</strong> {{ $profile->fname }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>Middle
                                    Name: </strong>{{ $profile->mname ? $profile->mname : 'None' }}</div>
                            <div class="col-md-8"><strong>Contact Number:</strong> {{ $profile->contact_number }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>Email:</strong> {{ $customer->email }}</div>
                            <div class="col-md-8"><strong>Address:</strong> {{ $profile->address }}</div>
                        </div>
                        <div class="mt-4">
                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">Edit Profile</a>
                        </div>
                    </div>

                    <!-- Edit Profile Modal -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('profile.update', $profile->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body row">
                                        <input type="hidden" name="customer_id" value="{{ auth('customer')->id() }}">

                                        <div class="col-md-12 mb-3 text-center">
                                            @if ($profile->picture)
                                                <img src="{{ asset('storage/' . $profile->picture) }}"
                                                    alt="Current Picture" class="mt-2"
                                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                            @endif
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="picture" class="form-label">Profile Picture</label>
                                            <input type="file" name="picture" class="form-control" accept="image/*">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" name="lname" class="form-control"
                                                value="{{ old('lname', $profile->lname) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" name="fname" class="form-control"
                                                value="{{ old('fname', $profile->fname) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="mname" class="form-label">Middle Name</label>
                                            <input type="text" name="mname" class="form-control"
                                                value="{{ old('mname', $profile->mname) }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="contact_number" class="form-label">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control"
                                                value="{{ old('contact_number', $profile->contact_number) }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $profile->email) }}" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" class="form-control" rows="2" required>{{ old('address', $profile->address) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        You have not set up a profile yet.
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                        Add Profile
                    </button>
                @endif
            </div>
        </div>

        <!-- Add Profile Modal -->
        <div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProfileModalLabel">Add Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <input type="hidden" name="customer_id" value="{{ auth('customer')->id() }}">

                            <div class="col-md-6 mb-3">
                                <label for="picture" class="form-label">Profile Picture</label>
                                <input type="file" name="picture" class="form-control" accept="image/*">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" name="lname" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" name="fname" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" name="mname" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ auth('customer')->user()->email }}" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Recent Purchases Section --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-3">Recent Purchases</h4>

            @if ($orders->isEmpty())
                <p class="text-muted">You have no recent purchases.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</td>
                                    <td>
                                        @foreach ($order->items as $item)
                                            {{ $item->product->name ?? 'N/A' }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    @php
                                        $total = $order->items->sum(function ($item) {
                                            return $item->price * $item->quantity;
                                        });
                                    @endphp
                                    <td>₱{{ number_format($total, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = match ($order->status) {
                                                'Completed' => 'bg-success',
                                                'Cancelled' => 'bg-danger',
                                                'Pending' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        @elseif (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}"
            });
        @endif
    </script>
@endsection
