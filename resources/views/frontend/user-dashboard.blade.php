@extends('layouts.frontend')
@section('title', 'My Account | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       USER DASHBOARD STYLES (POLISHED)
       ========================================= */
    body { background-color: #f8fafc; } 

    /* Compact Header */
    .dashboard-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 20px 0; }
    .user-greeting { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.5rem; margin: 0; }
    
    /* Content Cards */
    .dashboard-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .card-title-dash { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.25rem; margin-bottom: 15px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }

    /* Desktop Sidebar Navigation */
    .dashboard-sidebar { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; position: sticky; top: 100px; }
    .nav-dashboard { flex-direction: column; gap: 5px; }
    .nav-dashboard .nav-link { 
        color: #475569; font-weight: 600; padding: 10px 15px; border-radius: 8px; 
        transition: 0.3s; display: flex; align-items: center; gap: 12px; 
        border: none; background: transparent; text-align: left; width: 100%; font-size: 0.95rem;
    }
    .nav-dashboard .nav-link i { font-size: 1.1rem; width: 24px; text-align: center; }
    .nav-dashboard .nav-link:hover { background-color: #f1f5f9; color: var(--primary-color); }
    .nav-dashboard .nav-link.active { background-color: var(--accent-color); color: #fff; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.2); }

    /* Order History Item */
    .order-item { border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 15px; transition: 0.3s; background: #fff; }
    .order-item:hover { border-color: #cbd5e1; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
    
    .order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #e2e8f0; }
    .order-id { font-weight: 700; color: var(--primary-color); font-size: 1.05rem; }
    .order-date { font-size: 0.8rem; color: #64748b; }
    
    .order-status { font-weight: 700; font-size: 0.8rem; padding: 4px 10px; border-radius: 50px; display: inline-flex; align-items: center; gap: 5px; }
    .status-processing { background-color: #fffbeb; color: #d97706; }
    .status-shipped { background-color: #eff6ff; color: #3b82f6; }
    .status-delivered { background-color: #f0fdf4; color: #16a34a; }

    .order-product { display: flex; gap: 15px; align-items: center; }
    .order-img { width: 50px; height: 75px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0; }
    .order-title { font-weight: 700; color: var(--primary-color); font-size: 0.95rem; margin-bottom: 2px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .order-author { font-size: 0.8rem; color: #64748b; margin-bottom: 4px; }
    .order-price { font-weight: 700; color: var(--primary-color); font-size: 0.95rem; }

    .btn-track { border: 1px solid #cbd5e1; background: #fff; color: #475569; font-weight: 600; padding: 6px 15px; border-radius: 50px; font-size: 0.85rem; transition: 0.3s; white-space: nowrap; }
    .btn-track:hover { background: #f8fafc; color: var(--primary-color); border-color: #94a3b8; }

    /* Form Styles */
    .form-label { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 5px; }
    .form-control { border-radius: 8px; border: 1px solid #cbd5e1; padding: 8px 12px; font-size: 0.95rem; }
    .form-control:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); }
    .btn-save { background-color: var(--primary-color); color: white; font-weight: 600; padding: 10px 25px; border-radius: 50px; transition: 0.3s; border: none; font-size: 0.95rem; }
    .btn-save:hover { background-color: #0f172a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(15, 23, 42, 0.2); color: white; }

    /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS 
       ========================================= */
    @media (max-width: 991px) {
        .dashboard-header { padding: 15px 0; }
        
        .dashboard-sidebar { 
            position: relative; top: 0; padding: 0; margin-bottom: 15px; 
            border-radius: 0; border: none; border-bottom: 1px solid #e2e8f0; background: transparent;
        }
        .nav-dashboard { 
            flex-direction: row; overflow-x: auto; flex-wrap: nowrap; 
            -webkit-overflow-scrolling: touch; scrollbar-width: none; 
        }
        .nav-dashboard::-webkit-scrollbar { display: none; }
        
        .nav-dashboard .nav-link { 
            white-space: nowrap; width: auto; padding: 12px 15px; font-size: 0.9rem; 
            border-radius: 0; background: transparent !important; color: #64748b;
            border-bottom: 2px solid transparent; box-shadow: none !important;
            margin-bottom: -1px; 
        }
        .nav-dashboard .nav-link i { display: none; } 
        .nav-dashboard .nav-link.active { 
            color: var(--accent-color); border-bottom-color: var(--accent-color); font-weight: 700;
        }

        .dashboard-card { padding: 15px; border-radius: 8px; border-left: none; border-right: none; } 
        
        .order-header { margin-bottom: 10px; padding-bottom: 10px; }
        .order-product { align-items: flex-start; }
        .order-actions { width: 100%; margin-top: 12px; }
        .btn-track { width: 100%; text-align: center; padding: 8px; }
        
        .body-padding-mobile { padding-bottom: 80px; } 
    }
</style>
@endsection

@section('content')

<div class="body-padding-mobile">

    <div class="dashboard-header shadow-sm">
        <div class="container">
            <h1 class="user-greeting">Welcome back, John!</h1>
            <p class="text-muted mb-0 small mt-1">Manage your account and track orders.</p>
        </div>
    </div>

    <section class="py-3 py-md-4">
        <div class="container">
            <div class="row g-3 g-md-4">
                
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="nav nav-dashboard" id="v-pills-tab" role="tablist">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-orders" type="button" role="tab">
                                <i class="fas fa-box-open"></i> My Orders
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab">
                                <i class="far fa-user"></i> Profile
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-wishlist" type="button" role="tab">
                                <i class="far fa-heart"></i> Wishlist
                            </button>
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-address" type="button" role="tab">
                                <i class="far fa-map"></i> Addresses
                            </button>
                            <hr class="my-2 d-none d-lg-block text-muted">
                            <form action="{{ route('logout') }}" method="POST" class="d-none d-lg-block w-100">
                                @csrf
                                <button type="submit" class="nav-link text-danger w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        <div class="tab-pane fade show active" id="tab-orders" role="tabpanel">
                            <div class="dashboard-card">
                                <h2 class="card-title-dash d-flex justify-content-between align-items-center">
                                    Order History
                                    <span class="badge bg-light text-dark border fs-6 fw-normal d-none d-sm-inline-block">3 Orders</span>
                                </h2>

                                <div class="order-item">
                                    <div class="order-header">
                                        <div>
                                            <div class="order-id">#DVP-9824</div>
                                            <div class="order-date">12 Mar 2026</div>
                                        </div>
                                        <div class="order-status status-shipped">
                                            <i class="fas fa-truck"></i> Shipped
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                        <div class="order-product">
                                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=150&auto=format&fit=crop" class="order-img" alt="Book">
                                            <div>
                                                <h4 class="order-title">The Art of Storytelling</h4>
                                                <p class="order-author">Ved Prakash Panday</p>
                                                <div class="order-price">₹299 <span class="text-muted small fw-normal ms-1">| Qty: 1</span></div>
                                            </div>
                                        </div>
                                        <div class="order-actions">
                                            <button class="btn btn-track w-100">Track Package</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-item">
                                    <div class="order-header">
                                        <div>
                                            <div class="order-id">#DVP-9855</div>
                                            <div class="order-date">15 Mar 2026</div>
                                        </div>
                                        <div class="order-status status-processing">
                                            <i class="fas fa-box"></i> Processing
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                        <div class="order-product">
                                            <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=150&auto=format&fit=crop" class="order-img" alt="Book">
                                            <div>
                                                <h4 class="order-title">Ghazals of the Night</h4>
                                                <p class="order-author">Aman Verma</p>
                                                <div class="order-price">₹499 <span class="text-muted small fw-normal ms-1">| Qty: 1</span></div>
                                            </div>
                                        </div>
                                        <div class="order-actions">
                                            <button class="btn btn-track w-100">Order Details</button>
                                        </div>
                                    </div>
                                </div>

                                <nav class="mt-4 d-none d-md-block" aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled"><a class="page-link shadow-none" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a></li>
                                        <li class="page-item active"><a class="page-link shadow-none bg-dark border-dark text-white" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link shadow-none text-dark" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link shadow-none text-dark" href="#"><i class="fas fa-chevron-right"></i></a></li>
                                    </ul>
                                </nav>

                                <div class="text-center mt-4 d-md-none">
                                    <button class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold shadow-sm w-100">
                                        Load More Orders <i class="fas fa-sync-alt ms-2"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-profile" role="tabpanel">
                            <div class="dashboard-card">
                                <h2 class="card-title-dash">Personal Information</h2>
                                <form action="#" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" value="John Doe" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control bg-light" value="john@example.com" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="phone" class="form-control" value="+91 9876543210">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-save w-100 w-sm-auto">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="dashboard-card">
                                <h2 class="card-title-dash">Update Password</h2>
                                <form action="#" method="POST">
                                    @csrf @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" name="current_password" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                        </div>
                                        <div class="col-12 mt-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <button type="submit" class="btn btn-save w-100 w-sm-auto">Update Password</button>
                                            
                                            <form action="{{ route('logout') }}" method="POST" class="d-md-none w-100 mt-2">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold">Logout from Account</button>
                                            </form>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-wishlist" role="tabpanel">
                            <div class="dashboard-card">
                                <h2 class="card-title-dash">My Wishlist</h2>
                                <p class="text-muted">You haven't added any books to your wishlist yet.</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-address" role="tabpanel">
                            <div class="dashboard-card">
                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                    <h2 class="card-title-dash border-0 mb-0 pb-0">Saved Addresses</h2>
                                    <button class="btn btn-dark btn-sm rounded-pill px-3"><i class="fas fa-plus"></i> <span class="d-none d-sm-inline ms-1">Add New</span></button>
                                </div>

                                <div class="border rounded-3 p-3 position-relative bg-light">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">Default</span>
                                    <h5 class="fw-bold fs-6 mb-1 text-dark">John Doe</h5>
                                    <p class="text-muted small mb-1">+91 9876543210</p>
                                    <p class="text-dark small mb-2 lh-sm">123, Publisher Street, Knowledge Park,<br>New Delhi, DL - 110001, India</p>
                                    <div class="d-flex gap-3 border-top pt-2 mt-2">
                                        <a href="#" class="text-accent fw-bold small text-decoration-none"><i class="fas fa-edit me-1"></i> Edit</a>
                                        <a href="#" class="text-danger fw-bold small text-decoration-none"><i class="fas fa-trash-alt me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

@endsection