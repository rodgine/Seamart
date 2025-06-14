<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - SeaMart</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('admin-assets/assets/images/logos/logo.png') }}" />
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/styles.min.css') }}" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('admin-assets/assets/images/logos/seamart-banner.png') }}" width="180" alt="logo">
                </a>
                <p class="text-center">Admin Panel Login</p>

                @if(session('error'))
                  <div class="alert alert-danger text-center">
                      {{ session('error') }}
                  </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" id="remember">
                      <label class="form-check-label text-dark" for="remember">
                        Remember me
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="#">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded-2">Sign In</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('admin-assets/assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin-assets/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
