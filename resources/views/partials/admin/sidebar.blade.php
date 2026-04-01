<div class="d-flex flex-column flex-shrink-0 text-white bg-dark-blue h-100 shadow-lg">
    <div class="brand-section px-4 py-4 mb-2 border-bottom border-secondary text-center">
        <i class="fas fa-book-open text-warning fs-2 mb-2"></i>
        <div class="fw-bold text-uppercase tracking-wider" style="font-size: 1.1rem;">
            Divyansh<span class="text-warning">Pub.</span>
        </div>
    </div>
    
    <div class="nav-container overflow-y-auto flex-grow-1 px-3" style="max-height: calc(100vh - 180px);">
        <ul class="nav nav-pills flex-column mb-auto mt-2">
            
            <li class="nav-item">
                <p class="section-label">Main Console</p>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <p class="section-label">Inventory</p>
                <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <i class="fas fa-book-medical me-2"></i> Manage Books
                </a>
                <a href="{{ route('admin.authors.index') }}" class="nav-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
                    <i class="fas fa-feather-alt me-2"></i> Authors
                </a>
                <a href="{{ route('admin.publishers.index') }}" class="nav-link {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
                    <i class="fas fa-university me-2"></i> Publications
                </a>
            </li>

            <li class="nav-item">
                <p class="section-label">Revenue & Orders</p>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-truck-loading me-2"></i> Orders Tracker
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-hand-holding-usd me-2 text-success"></i> Payments/Refunds
                </a>
            </li>

            <li class="nav-item">
                <p class="section-label">Partners & Users</p>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle me-2"></i> All Customers
                </a>
                <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
                    <i class="fas fa-store-alt me-2 text-info"></i> Sellers & Fairs
                </a>
            </li>

            <li class="nav-item mt-2 mb-4">
                <p class="section-label">System Control</p>
                <a href="#" class="nav-link"><i class="fas fa-cog me-2"></i> App Settings</a>
            </li>
        </ul>
    </div>
    
    <div class="user-profile border-top border-secondary p-3 mt-auto bg-darker">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=Admin&background=ffc107&color=000" width="35" height="35" class="rounded-circle me-2">
                <div class="small fw-bold">Admin Portal</div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow border-secondary">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* Premium Dark Theme CSS */
    .bg-dark-blue { background-color: #1a237e; } /* Deep Indigo */
    .bg-darker { background-color: #121858; }
    .nav-link { color: rgba(255,255,255,0.7) !important; font-size: 0.9rem; padding: 10px 15px; transition: 0.3s; }
    .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff !important; }
    .nav-link.active { background: #ffc107 !important; color: #000 !important; font-weight: bold; }
    .section-label { font-size: 0.65rem; text-uppercase: uppercase; letter-spacing: 1.2px; color: rgba(255,255,255,0.4); margin: 20px 0 8px 15px; font-weight: 800; }
    
    /* Custom Scrollbar for Sidebar */
    .nav-container::-webkit-scrollbar { width: 5px; }
    .nav-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
    
    /* Responsive adjustment */
    @media (max-width: 992px) { .sidebar { width: 100% !important; } }
</style>