<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Divyansh Pub.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #1e293b; --sidebar-hover: #334155; --primary: #3b82f6; }
        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; overflow-x: hidden; }
        
        /* Sidebar CSS */
        .sidebar {
            width: 260px; height: 100vh; position: fixed; left: 0; top: 0;
            background: var(--sidebar-bg); color: #fff; z-index: 1000;
            transition: all 0.3s ease; display: flex; flex-direction: column;
        }
        
        .sidebar-header { padding: 20px; border-bottom: 1px solid #334155; text-align: center; }
        .sidebar-content { flex-grow: 1; overflow-y: auto; padding: 10px 0; }
        .sidebar-footer { padding: 15px; border-top: 1px solid #334155; background: #0f172a; }

        .nav-link {
            color: #94a3b8 !important; padding: 12px 20px; margin: 4px 12px;
            border-radius: 8px; display: flex; align-items: center; text-decoration: none;
        }
        .nav-link:hover { background: var(--sidebar-hover); color: #fff !important; }
        .nav-link.active { background: var(--primary); color: #fff !important; font-weight: 600; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); }
        .nav-link i { width: 25px; font-size: 1.1rem; }

        .section-title { font-size: 0.7rem; text-transform: uppercase; color: #64748b; font-weight: 700; margin: 20px 25px 8px; letter-spacing: 1px; }

        /* Main Content area */
        .main { margin-left: 260px; transition: all 0.3s; min-height: 100vh; }
        
        /* Mobile Overlay */
        @media (max-width: 991px) {
            .sidebar { left: -260px; }
            .sidebar.active { left: 0; }
            .main { margin-left: 0; }
            .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; display: none; }
            .overlay.active { display: block; }
        }

        .top-nav { background: #fff; padding: 10px 25px; border-bottom: 1px solid #e2e8f0; }
    </style>
</head>
<body>

<div class="overlay" id="overlay"></div>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4 class="fw-bold mb-0 text-white"><i class="fas fa-book-open text-primary me-2"></i>Divyansh<span class="text-primary">Pub.</span></h4>
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
            <i class="fas fa-feather"></i> Authors
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

        <p class="section-title">Users & Community</p>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
            <i class="fas fa-store-alt"></i> Sellers & Fairs
        </a>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger w-100 fw-bold py-2 shadow-sm">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>
<div class="main">
    <nav class="top-nav d-flex justify-content-between align-items-center sticky-top">
        <button class="btn btn-outline-dark d-lg-none" id="menu-toggle"><i class="fas fa-bars"></i></button>
        <h5 class="fw-bold mb-0 text-dark d-none d-md-block">Admin Control Panel</h5>
        <div class="d-flex align-items-center">
            <span class="me-3 fw-semibold text-muted">{{ Auth::user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="rounded-circle shadow-sm" width="40">
        </div>
    </nav>

    <div class="container-fluid p-4">
        @yield('content')
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btn = document.getElementById('menu-toggle');

    btn.onclick = function() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    overlay.onclick = function() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>