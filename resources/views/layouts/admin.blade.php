<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Divyansh Pub.</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root { 
            --sidebar-bg: #0f172a; 
            --sidebar-hover: #1e293b; 
            --primary: #4f46e5; 
            --primary-glow: rgba(79, 70, 229, 0.35);
            --text-muted: #94a3b8;
            --bg-light: #f8fafc;
        }
        
        body { background-color: var(--bg-light); font-family: 'Inter', sans-serif; overflow-x: hidden; color: #334155; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }

        .sidebar {
            width: 270px; height: 100vh; position: fixed; left: 0; top: 0;
            background: var(--sidebar-bg); color: #fff; z-index: 1040;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            display: flex; flex-direction: column;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center; }
        .brand-logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 0.5px; }
        .sidebar-content { flex-grow: 1; overflow-y: auto; padding: 20px 0; }
        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.2); }

        .nav-link {
            color: var(--text-muted) !important; padding: 12px 20px; margin: 4px 16px;
            border-radius: 10px; display: flex; align-items: center; text-decoration: none;
            transition: all 0.2s ease; font-weight: 500; font-size: 0.95rem;
        }
        .nav-link:hover { background: var(--sidebar-hover); color: #fff !important; transform: translateX(5px); }
        .nav-link.active { background: var(--primary); color: #fff !important; font-weight: 600; box-shadow: 0 4px 15px var(--primary-glow); }
        .nav-link i { width: 30px; font-size: 1.1rem; }
        .section-title { font-size: 0.7rem; text-transform: uppercase; color: #64748b; font-weight: 700; margin: 25px 25px 10px; letter-spacing: 1.5px; }

        .main { margin-left: 270px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); min-height: 100vh; display: flex; flex-direction: column; }
        .top-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); padding: 15px 30px; border-bottom: 1px solid #e2e8f0; z-index: 1030; }
        .nav-icon-btn { background: transparent; border: none; color: #64748b; font-size: 1.2rem; position: relative; }
        .badge-dot { position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; }

        @media (max-width: 991px) {
            .sidebar { left: -270px; }
            .sidebar.active { left: 0; }
            .main { margin-left: 0; }
            .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(3px); z-index: 1035; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
            .overlay.active { opacity: 1; visibility: visible; }
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4 class="brand-logo text-white mb-0">
            <i class="fas fa-book-open text-primary me-2"></i>Divyansh<span style="color: #60a5fa;">Pub.</span>
        </h4>
    </div>

    <div class="sidebar-content">
        <p class="section-title">Core</p>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <p class="section-title">Inventory</p>
        <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Books
        </a>
        <a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
            <i class="fas fa-feather-alt"></i> Authors
        </a>
        <a href="{{ route('admin.publishers.index') }}" class="nav-link {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
            <i class="fas fa-building"></i> Publications
        </a>

        <p class="section-title">Operations</p>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders & Tracking
        </a>
        <a href="{{ route('admin.stock.index') }}" class="nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i> Stock Requests
        </a>
        <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>

        <p class="section-title">Community</p>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
            <i class="fas fa-store-alt"></i> Sellers & Fairs
        </a>
        <a href="{{ route('admin.buyer-stories.index') }}" class="nav-link {{ request()->routeIs('admin.buyer-stories.*') ? 'active' : '' }}">
    <i class="fas fa-camera-retro"></i> Buyer Stories
</a>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger w-100 fw-bold py-2 shadow-sm d-flex justify-content-center align-items-center" style="border-radius: 8px;">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main">
    <nav class="top-nav d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-lg-none me-3 border-0 shadow-sm" id="menu-toggle" style="border-radius: 8px;">
                <i class="fas fa-bars text-dark"></i>
            </button>
            <h5 class="fw-bold mb-0 text-dark d-none d-md-block" style="letter-spacing: -0.5px;">Control Panel</h5>
        </div>
        
        <div class="d-flex align-items-center gap-4">
            <button class="nav-icon-btn">
                <i class="far fa-bell"></i>
                <span class="badge-dot"></span>
            </button>

            <div class="dropdown">
                <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <div class="text-end me-3 d-none d-sm-block">
                        <div class="fw-bold text-dark fs-6" style="line-height: 1.2;">{{ Auth::user()->name ?? 'Admin User' }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=4f46e5&color=fff" class="rounded-circle shadow-sm border border-2 border-white" width="45" height="45">
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 10px; min-width: 200px;">
    <li>
        <a class="dropdown-item py-2" href="{{ route('admin.profile.index') }}">
            <i class="fas fa-user-circle me-2 text-muted"></i> My Profile
        </a>
    </li>
    <li>
        <a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}">
            <i class="fas fa-cog me-2 text-muted"></i> Settings
        </a>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </li>
</ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid pt-3 flex-grow-1">
        @yield('content')
    </div>
    
    <footer class="mt-auto py-3 px-4 border-top text-center text-md-start d-flex justify-content-between flex-wrap text-muted small">
        <span>&copy; {{ date('Y') }} Divyansh Publication. All rights reserved.</span>
        <span>Version 1.0</span>
    </footer>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btn = document.getElementById('menu-toggle');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    btn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>