<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>@yield('title', 'Divyansh Publication | Bringing Words to Life')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,700;1,600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #1e293b; 
            --accent-color: #d97706; 
            --bg-light: #fdfbf7; 
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

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: var(--accent-color);
            font-size: 0.65rem;
        }

       /* =========================================
           🛒 MINI CART HOVER STYLES (FIXED & ANIMATED)
           ========================================= */
        .nav-cart-wrapper .mini-cart-dropdown {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            top: 100%;
            right: -20px;
            width: 320px;
            z-index: 1050;
            padding-top: 15px; /* Transparent gap taaki mouse niche aate waqt band na ho */
            transition: all 0.3s ease;
            transform: translateY(10px); /* Halki si neeche se upar aane wali animation */
        }
        
        .nav-cart-wrapper:hover .mini-cart-dropdown { 
            visibility: visible;
            opacity: 1;
            transform: translateY(0); 
        }

        .mini-cart-content { background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden; }
        .mini-cart-items { max-height: 320px; overflow-y: auto; }
        .mini-cart-items::-webkit-scrollbar { width: 5px; }
        .mini-cart-items::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .mini-cart-item:last-child { border-bottom: none !important; }

        /* Mobile par hover dropdown chhipane ke liye */
        @media (max-width: 991.98px) {
            .nav-cart-wrapper .mini-cart-dropdown { display: none !important; }

            /* 🌟 Wishlist Mobile UI Adjustments */
    .wishlist-card { border-radius: 8px !important; }
    .wishlist-card .card-body { padding: 10px !important; }
    .wishlist-title { font-size: 0.85rem !important; margin-bottom: 2px !important; }
    .wishlist-author { font-size: 0.75rem !important; margin-bottom: 8px !important; }
    .wishlist-price { font-size: 0.95rem !important; }
    .wishlist-add-btn { padding: 4px 10px !important; font-size: 0.75rem !important; }
    
    /* Trash button ko thoda chhota aur side me kiya */
    .remove-from-wishlist { 
        width: 28px !important; 
        height: 28px !important; 
        padding: 0 !important; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
    }
        }

        /* Footer */
        .footer-custom {
            background-color: var(--primary-color);
            color: #f1f5f9;
            padding: 60px 0 20px;
            margin-top: auto;
        }
        .footer-custom a { color: #cbd5e1; text-decoration: none; transition: 0.3s; }
        .footer-custom a:hover { color: var(--accent-color); }

        /* 📱 MOBILE BOTTOM NAV */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background-color: #fff;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 70px;
            z-index: 1050;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .mobile-bottom-nav .nav-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: #64748b; text-decoration: none; font-size: 0.75rem; font-weight: 600; flex: 1;
        }

        .mobile-bottom-nav .nav-item i { font-size: 1.3rem; margin-bottom: 4px; }
        .mobile-bottom-nav .nav-item.active { color: var(--accent-color); }

        .center-home-wrapper {
            position: relative; top: -25px;
            background-color: var(--accent-color); color: #fff !important;
            width: 60px; height: 60px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4);
            border: 6px solid var(--bg-light);
        }

        .cart-badge-mobile {
            position: absolute; top: 10px; right: 20%;
            background: var(--accent-color); color: white;
            font-size: 0.65rem; padding: 3px 6px;
        }

        @media (max-width: 991.98px) {
            body { padding-bottom: 85px; }
            .desktop-nav-elements { display: none !important; }
            .navbar-custom .container { justify-content: center; } 
        }

        /* Search Modal Customization */
        .search-modal .modal-content { border-radius: 20px; border: none; }
        .search-input-lg { border: none; font-size: 1.5rem; padding: 20px; font-family: 'Playfair Display', serif; }
        .search-input-lg:focus { box-shadow: none; }
    </style>
    @yield('styles')
</head>
<body>

    @php 
        $cart = session('cart', []);
        $cartCount = count($cart);
        $miniSubtotal = 0;
    @endphp

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-open text-accent me-2"></i>Divyansh.
            </a>
            
            <div class="collapse navbar-collapse desktop-nav-elements">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">Shop Books</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link {{ request()->is('authors*') ? 'active' : '' }}" href="{{ route('authors.index') }}">Authors</a>
    </li>

     <li class="nav-item">
    <a class="nav-link {{ request()->is('memories*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Memories</a>
</li>
</ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-dark fs-5" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search"></i></a>
                    
                    <div class="position-relative nav-cart-wrapper">
                        <a href="{{ route('cart.index') }}" class="text-dark fs-5 position-relative mx-2 text-decoration-none">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="badge rounded-pill cart-badge count-sync">{{ $cartCount }}</span>
                        </a>
                        
                       <div class="mini-cart-dropdown">
    @include('frontend.partials.mini-cart-items')
</div>
                    </div>

                    @guest
                        <button class="btn btn-accent btn-sm rounded-pill px-4 ms-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    @else
                        <div class="dropdown">
                            <a href="#" class="text-dark fs-5 dropdown-toggle text-decoration-none" data-bs-toggle="dropdown"><i class="far fa-user-circle"></i></a>
                          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 rounded-3" style="width: 250px;">
    <li class="px-4 py-3 border-bottom mb-2 bg-light rounded-top">
        <div class="fw-bold text-dark font-playfair fs-6">{{ Auth::user()->name ?? 'Book Lover' }}</div>
        <div class="small text-muted text-truncate">{{ Auth::user()->email ?? '' }}</div>
    </li>
    
    <li><a class="dropdown-item py-2 px-4" href="{{ route('dashboard') }}"><i class="fas fa-chart-line me-2 text-muted" style="width: 20px;"></i> My Dashboard</a></li>
    
    <li><a class="dropdown-item py-2 px-4" href="{{ route('dashboard') }}?tab=orders"><i class="fas fa-box me-2 text-muted" style="width: 20px;"></i> My Orders</a></li>
    
    <li><a class="dropdown-item py-2 px-4" href="{{ route('dashboard') }}?tab=wishlist"><i class="far fa-heart me-2 text-muted" style="width: 20px;"></i> Saved for Later</a></li>
    
    <li><a class="dropdown-item py-2 px-4" href="{{ route('dashboard') }}?tab=address"><i class="far fa-address-book me-2 text-muted" style="width: 20px;"></i> Addresses</a></li>
    
    <li><hr class="dropdown-divider mx-3"></li>
    
    <li><a class="dropdown-item py-2 px-4" href="{{ route('dashboard') }}?tab=profile"><i class="fas fa-user-cog me-2 text-muted" style="width: 20px;"></i> Profile Settings</a></li>
    
    <li>
        <form action="{{ route('logout') }}" method="POST" class="px-2">
            @csrf
            <button class="dropdown-item py-2 text-danger rounded"><i class="fas fa-sign-out-alt me-2" style="width: 20px;"></i> Logout</button>
        </form>
    </li>
</ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer class="footer-custom">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 text-center text-md-start">
                <h4 class="text-white mb-3 font-playfair fw-bold">Divyansh.</h4>
                <p class="small text-light opacity-75 mb-4">
                    Bringing words to life since 2024. We curate the finest collection of literature, poetry, and original publications for the dreamer in you.
                </p>
                <div class="d-flex justify-content-center justify-content-md-start gap-3 fs-5">
                    <a href="#" class="text-white opacity-75 hover-accent"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white opacity-75 hover-accent"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white opacity-75 hover-accent"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white opacity-75 hover-accent"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 text-center text-md-start">
                <h6 class="text-white fw-bold mb-3">Shop With Us</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="{{ route('shop', ['filter' => 'new-arrivals']) }}" class="opacity-75 hover-accent">New Arrivals</a></li>
                    
                    <li><a href="{{ route('shop', ['filter' => 'trending']) }}" class="opacity-75 hover-accent">Best Sellers</a></li>
                    
                    <li><a href="{{ route('shop', ['filter' => 'exclusive']) }}" class="opacity-75 hover-accent">Divyansh Originals</a></li>
                    
                    <li><a href="{{ route('authors.index') }}" class="opacity-75 hover-accent">Authors</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 text-center text-md-start">
                <h6 class="text-white fw-bold mb-3">Customer Service</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="#" class="opacity-75 hover-accent">Contact Us</a></li>
                    <li><a href="#" class="opacity-75 hover-accent">Shipping Policy</a></li>
                    <li><a href="#" class="opacity-75 hover-accent">Privacy Policy</a></li>
                    <li><a href="#" class="opacity-75 hover-accent">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 text-center text-md-start">
                <h6 class="text-white fw-bold mb-3">Stay Updated</h6>
                <p class="small text-light opacity-75">Subscribe to get notified about new book launches.</p>
                <form action="#" class="mb-3">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm bg-dark border-secondary text-white shadow-none" placeholder="Enter your email" style="border-radius: 50px 0 0 50px; padding-left: 15px;">
                        <button class="btn btn-accent btn-sm px-3" type="button" style="border-radius: 0 50px 50px 0;">Join</button>
                    </div>
                </form>
                <div class="small text-light opacity-75">
                    <i class="fas fa-envelope me-2"></i> support@divyansh.com<br>
                    <i class="fas fa-map-marker-alt me-2"></i> Patna, Bihar, India
                </div>
            </div>
        </div>

        <div class="border-top border-secondary pt-4 mt-5 d-flex flex-column flex-md-row justify-content-between align-items-center small opacity-50">
            <div class="mb-2 mb-md-0 text-center text-md-start">
                &copy; {{ date('Y') }} Divyansh Publication. All Rights Reserved.
            </div>
            <div class="d-flex gap-3">
                <i class="fab fa-cc-visa fs-4"></i>
                <i class="fab fa-cc-mastercard fs-4"></i>
                <i class="fab fa-google-pay fs-4"></i>
                <i class="fas fa-wallet fs-4"></i>
            </div>
        </div>
    </div>
</footer>

    <div class="mobile-bottom-nav d-lg-none">
        <a href="{{ route('shop') }}" class="nav-item {{ request()->is('shop*') ? 'active' : '' }}">
            <i class="fas fa-store"></i><span>Shop</span>
        </a>
        <a href="#" class="nav-item" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="fas fa-search"></i><span>Search</span>
        </a>
        <a href="{{ url('/') }}" class="nav-item">
            <div class="center-home-wrapper"><i class="fas fa-home"></i></div>
        </a>
        <a href="{{ route('cart.index') }}" class="nav-item position-relative {{ request()->is('cart*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i>
            <span class="badge rounded-pill cart-badge-mobile count-sync">{{ $cartCount }}</span>
            <span>Cart</span>
        </a>
        @auth
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('my-account*') || request()->is('dashboard*') ? 'active' : '' }}">
        <i class="far fa-user"></i><span>Profile</span>
    </a>
@else
    <a href="#" class="nav-item" data-bs-toggle="modal" data-bs-target="#loginModal">
        <i class="far fa-user"></i><span>Profile</span>
    </a>
@endauth
    </div>

    <div class="modal fade search-modal" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Search Divyansh Publication</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('shop') }}" method="GET">
                        <div class="input-group border-bottom">
                            <span class="input-group-text bg-transparent border-0 fs-4"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control search-input-lg" placeholder="Search by title, author..." autofocus>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-accent rounded-pill px-5">Search Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.auth-modals') 

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>

       window.updateCartUI = function(data) {
    console.log("Cart Data Received:", data); // Isse pata chalega data aa raha hai
    
    // Dono (Desktop aur Mobile) badges update honge
    $('.count-sync').text(data.cart_count); 
    
    // Mini-cart ka poora dabba naye HTML se replace hoga
    $('.mini-cart-dropdown').html(data.mini_cart); 
};

        function moveToNext(current, nextFieldID) {
            if (current.value.length >= current.maxLength) {
                document.getElementById(nextFieldID).focus();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>