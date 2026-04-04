<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Divyansh Publication | Bringing Words to Life')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,700;1,600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #1e293b; /* Deep Slate */
            --accent-color: #d97706; /* Classic Gold/Orange */
            --bg-light: #fdfbf7; /* Off-white paper feel */
            --text-dark: #334155;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .serif-font {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
        }

        /* 🌟 Premium Desktop Navbar */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            margin: 0 10px;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .nav-link:hover, .nav-link.active { color: var(--accent-color); }

        .btn-accent {
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 0;
            font-weight: 500;
            padding: 10px 24px;
            transition: 0.3s;
        }
        .btn-accent:hover { background-color: #b45309; color: #fff; }

        /* Footer */
        .footer-custom {
            background-color: var(--primary-color);
            color: #f1f5f9;
            padding: 60px 0 20px;
            margin-top: auto;
        }
        .footer-custom a { color: #cbd5e1; text-decoration: none; transition: 0.3s; }
        .footer-custom a:hover { color: var(--accent-color); }

        /* ==========================================
           📱 MOBILE SPECIFIC STYLES (Bottom Nav)
           ========================================== */
        
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 70px;
            z-index: 1050;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 0 10px;
        }

        .mobile-bottom-nav .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            flex: 1;
            transition: 0.3s;
        }

        .mobile-bottom-nav .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .mobile-bottom-nav .nav-item.active, 
        .mobile-bottom-nav .nav-item:hover {
            color: var(--accent-color);
        }

        /* 🏠 Center Floating Home Button */
        .center-home-wrapper {
            position: relative;
            top: -25px;
            background-color: var(--accent-color);
            color: #fff !important;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4);
            border: 6px solid var(--bg-light); /* Merges with body background */
        }
        
        .center-home-wrapper i { font-size: 1.5rem !important; margin: 0 !important; }
        .center-home-text { display: none; /* Hide text for the floating button */ }

        .cart-badge-mobile {
            position: absolute;
            top: -5px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            font-size: 0.65rem;
            padding: 3px 6px;
        }

        /* Mobile View Media Queries */
        @media (max-width: 991.98px) {
            body { 
                padding-bottom: 85px; /* Add space at bottom so content isn't hidden behind nav */
            }
            .navbar-toggler { display: none !important; } /* Hide Hamburger Toggle */
            .desktop-nav-elements { display: none !important; } /* Hide Desktop Links/Icons */
            
            /* Center Logo on Mobile */
            .navbar-custom .container { justify-content: center; } 
            .footer-custom { padding-bottom: 90px; } /* Give footer extra space on mobile */
        }

    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-open text-accent me-2" style="color: var(--accent-color);"></i>Divyansh.
            </a>
            
            <div class="collapse navbar-collapse desktop-nav-elements" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Authors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-dark fs-5 text-decoration-none hover-accent"><i class="fas fa-search"></i></a>
                    <a href="#" class="text-dark fs-5 position-relative text-decoration-none mx-2 hover-accent">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="badge rounded-pill cart-badge">0</span>
                    </a>
                    @guest
                        <button type="button" class="btn btn-accent btn-sm rounded-pill px-4 ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    @else
                        <div class="dropdown">
                            <a href="#" class="text-dark fs-5 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="far fa-user-circle"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-3">
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-box me-2 text-muted"></i> My Orders</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-cog me-2 text-muted"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item py-2 text-danger" type="submit"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4 mb-4 text-center text-md-start">
                <div class="col-lg-4">
                    <h4 class="text-white mb-3"><i class="fas fa-book-open me-2" style="color: var(--accent-color);"></i>Divyansh.</h4>
                    <p class="small text-light opacity-75 pe-md-4">Curating stories that inspire, educate, and entertain. We are dedicated to bringing the best literature to your doorstep.</p>
                </div>
                <div class="col-md-4 col-lg-2">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Explore</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#">New Releases</a></li>
                        <li class="mb-2"><a href="#">Best Sellers</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Customer Service</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#">Track Order</a></li>
                        <li class="mb-2"><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h6 class="text-uppercase fw-bold mb-3 text-white">Stay Connected</h6>
                    <div class="d-flex gap-3 fs-5 justify-content-center justify-content-md-start">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-x-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 mt-4 text-center small opacity-50">
                &copy; {{ date('Y') }} Divyansh Publication. All rights reserved.
            </div>
        </div>
    </footer>

    <div class="mobile-bottom-nav d-lg-none">
        <a href="#" class="nav-item">
            <i class="fas fa-store"></i>
            <span>Shop</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Search</span>
        </a>
        
        <a href="{{ url('/') }}" class="nav-item active" style="flex: 0.8;">
            <div class="center-home-wrapper">
                <i class="fas fa-home"></i>
            </div>
            <span class="center-home-text">Home</span>
        </a>
        
        <a href="#" class="nav-item position-relative">
            <i class="fas fa-shopping-bag"></i>
            <span class="badge rounded-pill cart-badge-mobile">0</span>
            <span>Cart</span>
        </a>
        <a href="#" class="nav-item" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="far fa-user"></i>
            <span>Profile</span>
        </a>
    </div>

<style>
    .auth-modal .modal-content { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .auth-modal .modal-header { border-bottom: none; padding: 25px 30px 10px; }
    .auth-modal .modal-body { padding: 10px 30px 30px; }
    .auth-modal .btn-close { font-size: 0.8rem; background-color: #f1f5f9; border-radius: 50%; padding: 10px; opacity: 0.7; }
    .auth-modal .btn-close:hover { opacity: 1; background-color: #e2e8f0; }
    
    .auth-title { font-family: 'Playfair Display', serif; font-weight: 800; color: var(--primary-color); font-size: 1.8rem; margin-bottom: 5px; }
    .auth-subtitle { font-size: 0.9rem; color: #64748b; margin-bottom: 25px; }
    
    .auth-form .form-control { border-radius: 8px; padding: 12px 15px; border-color: #cbd5e1; font-size: 0.95rem; }
    .auth-form .form-control:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); }
    .auth-form .form-label { font-size: 0.85rem; font-weight: 600; color: var(--primary-color); margin-bottom: 6px; }
    
    .btn-auth { background-color: var(--primary-color); color: white; font-weight: 600; padding: 12px; border-radius: 50px; width: 100%; transition: 0.3s; border: none; margin-top: 10px; }
    .btn-auth:hover { background-color: var(--accent-color); color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3); }
    
    .auth-link { color: var(--accent-color); font-weight: 600; text-decoration: none; cursor: pointer; transition: 0.2s; background: none; border: none; padding: 0; }
    .auth-link:hover { color: #b45309; text-decoration: underline; }
    
    .divider-text { display: flex; align-items: center; text-align: center; color: #94a3b8; font-size: 0.85rem; margin: 20px 0; }
    .divider-text::before, .divider-text::after { content: ''; flex: 1; border-bottom: 1px solid #e2e8f0; }
    .divider-text:not(:empty)::before { margin-right: .5em; }
    .divider-text:not(:empty)::after { margin-left: .5em; }
    
    /* OTP Input Styling */
    .otp-input-wrapper { display: flex; gap: 10px; justify-content: space-between; margin-bottom: 20px; }
    .otp-input { width: 50px; height: 55px; text-align: center; font-size: 1.5rem; font-weight: 700; border-radius: 8px; border: 1px solid #cbd5e1; color: var(--primary-color); }
    .otp-input:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); outline: none; }
</style>

<div class="modal fade auth-modal" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Welcome Back</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form">
                <p class="auth-subtitle text-center">Login to access your orders and wishlist.</p>
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Password</label>
                            <button type="button" class="auth-link small" data-bs-target="#forgotModal" data-bs-toggle="modal" data-bs-dismiss="modal">Forgot Password?</button>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-auth">Sign In</button>
                </form>
                
                <div class="text-center mt-4 small text-muted">
                    New to Divyansh Publication? <button type="button" class="auth-link" data-bs-target="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade auth-modal" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Join Us</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form">
                <p class="auth-subtitle text-center">Create an account to start your reading journey.</p>
                <form action="#" method="POST">
                    @csrf
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="John" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">+91</span>
                            <input type="tel" name="phone" class="form-control border-start-0" placeholder="9876543210" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                    </div>
                    <button type="submit" class="btn btn-auth">Create Account</button>
                </form>
                
                <div class="text-center mt-4 small text-muted">
                    Already have an account? <button type="button" class="auth-link" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign In</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade auth-modal" id="forgotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Reset Password</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form text-center">
                <p class="auth-subtitle mb-4">Enter your registered email address. We'll send you an OTP to reset your password.</p>
                <form action="#" method="POST" id="forgotForm">
                    @csrf
                    <div class="mb-4 text-start">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="button" class="btn btn-auth" data-bs-target="#otpModal" data-bs-toggle="modal" data-bs-dismiss="modal">Send OTP</button>
                </form>
                
                <div class="text-center mt-4">
                    <button type="button" class="auth-link small text-muted" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-1"></i> Back to Login</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade auth-modal" id="otpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Verify Email</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form text-center">
                <p class="auth-subtitle mb-2">We have sent a 4-digit code to</p>
                <p class="fw-bold text-dark mb-4">john@example.com</p>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="otp-input-wrapper">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" required onkeyup="moveToNext(this, 'otp2')">
                        <input type="text" class="otp-input" id="otp2" maxlength="1" pattern="[0-9]" required onkeyup="moveToNext(this, 'otp3')">
                        <input type="text" class="otp-input" id="otp3" maxlength="1" pattern="[0-9]" required onkeyup="moveToNext(this, 'otp4')">
                        <input type="text" class="otp-input" id="otp4" maxlength="1" pattern="[0-9]" required>
                    </div>
                    <button type="submit" class="btn btn-auth">Verify & Proceed</button>
                </form>
                
                <div class="text-center mt-4 small text-muted">
                    Didn't receive the code? <button type="button" class="auth-link">Resend OTP</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function moveToNext(current, nextFieldID) {
        if (current.value.length >= current.maxLength) {
            document.getElementById(nextFieldID).focus();
        }
    }
</script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>