<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SeaMart - Admin</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin-assets/assets/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/customstyle.css') }}" />
</head>
<style>
    .greeting-wrapper {
        width: 70%;
        /* or set a specific width if needed */
        overflow: hidden;
        /* hide overflow */
        position: relative;
    }

    .greeting-text {
        white-space: nowrap;
        display: inline-block;
        animation: slide-left 15s linear infinite;
        color: black;
        font-size: 14px;
        letter-spacing: 1px !important;
    }

    @keyframes slide-left {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>

<body style="background-color: whitesmoke;">
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#" class="text-nowrap logo-img banner-img">
                        <img src="{{ asset('admin-assets/assets/images/logos/logo2.png') }}" width="200"
                            alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <!-- Home -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                            <ul>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                                        <span><i class="ti ti-layout-dashboard"></i></span>
                                        <span class="hide-menu">Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- System Components -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">SYSTEM COMPONENTS</span>
                            <ul>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('admin.products.index') }}"
                                        aria-expanded="false">
                                        <span><i class="ti ti-package"></i></span>
                                        <span class="hide-menu">Products</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('admin.categories.index') }}"
                                        aria-expanded="false">
                                        <span><i class="ti ti-tags"></i></span>
                                        <span class="hide-menu">Categories</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link d-flex justify-content-between align-items-center"
                                        href="{{ route('admin.orders.index') }}">
                                        <div>
                                            <i class="ti ti-shopping-cart"></i>
                                            <span class="hide-menu ms-2">Orders</span>
                                        </div>
                                        @if (!empty($pendingOrdersCount) && $pendingOrdersCount > 0)
                                            <span class="badge bg-warning rounded-pill"
                                                title="There are {{ $pendingOrdersCount }} pending order requests">{{ $pendingOrdersCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link d-flex justify-content-between align-items-center"
                                        href="{{ route('admin.customer-details.index') }}">
                                        <div>
                                            <i class="ti ti-users"></i>
                                            <span class="hide-menu ms-2">Customers</span>
                                        </div>
                                        @if (!empty($customerCount) && $customerCount > 0)
                                            <span class="badge bg-warning rounded-pill"
                                                title="Total registered customers: {{ $customerCount }}">{{ $customerCount }}</span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Settings -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">SETTINGS</span>
                            <ul>
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                                        <span><i class="ti ti-settings"></i></span>
                                        <span class="hide-menu">Settings</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse first-level">
                                        <li class="sidebar-item">
                                            <a href="{{ url('/admin/users') }}" class="sidebar-link">
                                                <span><i class="ti ti-user"></i></span>
                                                <span class="hide-menu">Users</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover position-relative" href="#"
                                id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing fs-5"></i>
                                @if ($totalNotifications > 0)
                                    <span
                                        class="position-absolute top-4 right-4 translate-middle badge rounded-circle bg-danger p-1"
                                        style="font-size: 10px; min-width: 16px; height: 16px; line-height: 10px;">
                                        {{ $totalNotifications }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-sm shadow mt-2"
                                aria-labelledby="notificationDropdown" style="min-width: 280px;">

                                @if ($pendingOrdersCount > 0)
                                    <li>
                                        <a href="{{ url('/orders') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <i class="ti ti-shopping-cart fs-5 text-warning me-3 mt-1"></i>
                                            <div>
                                                <strong>{{ $pendingOrdersCount }} Pending Orders</strong>
                                                <div class="text-muted small">View and manage new order requests</div>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                                @if ($customerCount > 0)
                                    <li>
                                        <a href="{{ url('/customer-details') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <i class="ti ti-users fs-5 text-info me-3 mt-1"></i>
                                            <div>
                                                <strong>{{ $customerCount }} New Customers</strong>
                                                <div class="text-muted small">Registered today</div>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                                @if ($lowStockCount > 0)
                                    <li>
                                        <a href="{{ url('/products') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <i class="ti ti-alert-triangle fs-5 text-primary me-3 mt-1"></i>
                                            <div>
                                                <strong>{{ $lowStockCount }} Products Low on Stock</strong>
                                                <div class="text-muted small">Reorder soon</div>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                                @if ($noStockCount > 0)
                                    <li>
                                        <a href="{{ url('/products') }}"
                                            class="dropdown-item d-flex align-items-start">
                                            <i class="ti ti-alert-circle fs-5 text-danger me-3 mt-1"></i>
                                            <div>
                                                <strong>{{ $noStockCount }} Out of Stock Items</strong>
                                                <div class="text-muted small">Restock needed urgently</div>
                                            </div>
                                        </a>
                                    </li>
                                @endif

                                @if ($totalNotifications === 0)
                                    <li class="dropdown-item text-center text-muted">No new notifications</li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    <div class="greeting-wrapper">
                        <div class="greeting-text fw-100" style="font-style: italic;">Note: This session will expire
                            in 30 minutes. After that, you will automatically log out for security purposes</div>
                    </div>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            Welcome back, &nbsp;<b>Admin</b>!
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('admin-assets/assets/images/profile/user-1.jpg') }}"
                                        alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <form method="POST" action="{{ route('admin.logout') }}"
                                            id="adminLogoutForm" class="mx-3 mt-2">
                                            @csrf
                                            <button type="button" class="btn btn-outline-primary d-block w-100"
                                                id="adminLogoutBtn">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Core Scripts -->
    <script src="{{ asset('admin-assets/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/js/dashboard.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    @endpush

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Delete button with SweetAlert
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

            // Edit modal population
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const {
                        id,
                        name,
                        description
                    } = this.dataset;

                    document.getElementById('edit-category-id').value = id;
                    document.getElementById('edit-category-name').value = name;
                    document.getElementById('edit-category-description').value = description;

                    const form = document.getElementById('editCategoryForm');
                    form.action = `/admin/categories/${id}`;
                });
            });

            const logoutBtn = document.getElementById('adminLogoutBtn');
            const logoutForm = document.getElementById('adminLogoutForm');

            if (logoutBtn && logoutForm) {
                logoutBtn.addEventListener('click', function(e) {
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
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>
