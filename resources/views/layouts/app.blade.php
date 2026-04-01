<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Divyansh Publication | India's Leading Publisher</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7f6; /* Modern light background */
            font-family: 'Nunito', sans-serif;
        }
        .navbar {
            padding: 15px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        .nav-link {
            font-weight: 600;
            color: #555 !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #0d6efd !important;
        }
        .btn-register {
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="{{ url('/') }}">
                    <i class="fas fa-book-open text-primary me-2 fs-3"></i>
                    <div>
                        Divyansh<span class="text-primary">Publication</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        </ul>

                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item me-3">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> {{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary btn-register text-white shadow-sm" href="{{ route('register') }}">Create Account</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff" class="rounded-circle me-2 shadow-sm" width="35" height="35" alt="Avatar">
                                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end mt-2 p-2" aria-labelledby="navbarDropdown">
                                    <div class="px-3 py-2">
                                        <small class="text-muted d-block">Logged in as:</small>
                                        <span class="fw-bold text-dark text-capitalize">{{ Auth::user()->role }}</span>
                                    </div>
                                    <hr class="dropdown-divider">
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i> Admin Dashboard
                                        </a>
                                    @elseif(Auth::user()->role === 'seller')
                                        <a class="dropdown-item py-2" href="#">
                                            <i class="fas fa-store me-2 text-warning"></i> Seller Panel
                                        </a>
                                    @else
                                        <a class="dropdown-item py-2" href="#">
                                            <i class="fas fa-user-circle me-2 text-success"></i> My Profile
                                        </a>
                                    @endif
                                    
                                    <a class="dropdown-item py-2" href="#">
                                        <i class="fas fa-shopping-bag me-2 text-info"></i> My Orders
                                    </a>
                                    
                                    <hr class="dropdown-divider">

                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>