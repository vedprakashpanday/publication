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
        <h1 class="user-greeting">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
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
    <span class="badge bg-light text-dark border fs-6 fw-normal d-none d-sm-inline-block">{{ $orders->count() }} Orders</span>
</h2>

@forelse($orders as $order)
    <div class="order-item">
        <div class="order-header">
            <div>
                <div class="order-id">#DVP-{{ $order->order_number }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
            </div>
            <div class="order-status {{ $order->status == 'delivered' ? 'status-delivered' : 'status-processing' }}">
                <i class="fas {{ $order->status == 'delivered' ? 'fa-check-circle' : 'fa-box' }}"></i> {{ ucfirst($order->status) }}
            </div>
        </div>
        
        @foreach($order->items as $item)
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
            <div class="order-product">
                @php $frontImg = $item->book->images->where('image_type', 'front')->first(); @endphp
                <img src="{{ $frontImg ? asset('storage/'.$frontImg->image_path) : 'default.jpg' }}" class="order-img" alt="Book">
                <div>
                    <h4 class="order-title">{{ $item->book->title }}</h4>
                    <p class="order-author">{{ $item->book->author->name ?? '' }}</p>
                    <div class="order-price">₹{{ $item->price }} <span class="text-muted small fw-normal ms-1">| Qty: {{ $item->quantity }}</span></div>
                </div>
            </div>
            
            @if($order->status == 'delivered')
            <div class="order-actions mt-2 mt-md-0">
                <button class="btn btn-sm btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->book->id }}">
                    <i class="fas fa-star"></i> Rate & Review
                </button>
            </div>
            @endif
        </div>
        @endforeach
    </div>
@empty
    <div class="text-center py-4">
        <i class="fas fa-box-open fs-1 text-muted opacity-50 mb-3"></i>
        <p class="text-muted">You haven't placed any orders yet.</p>
        <a href="{{ route('shop') }}" class="btn btn-accent rounded-pill px-4">Start Shopping</a>
    </div>
@endforelse

                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-profile" role="tabpanel">
                            <div class="dashboard-card">
                                <h2 class="card-title-dash">Personal Information</h2>
                               <form action="{{ route('user.profile.update') }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control bg-light" value="{{ auth()->user()->email }}" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}">
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
        <h2 class="card-title-dash d-flex justify-content-between align-items-center">
            My Wishlist
            <span class="badge bg-light text-dark border fs-6 fw-normal d-none d-sm-inline-block" id="wishlist-count">{{ $wishlists->count() }} Books</span>
        </h2>

        @if($wishlists->count() > 0)
          <div class="row g-2 g-md-3"> @foreach($wishlists as $item)
    @if($item->book)
    <div class="col-6 col-md-6 col-lg-4 wishlist-item-wrapper-{{ $item->book->id }}">
        <div class="card wishlist-card h-100 border-0 shadow-sm rounded-3 overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
            <div class="position-relative">
                <button class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute m-2 top-0 end-0 remove-from-wishlist" 
                        data-id="{{ $item->book->id }}" title="Remove from Wishlist" style="z-index: 10;">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 0.85rem;"></i>
                </button>
                
                <a href="{{ route('book.show', $item->book->slug ?? $item->book->id) }}" class="d-block">
                    @php $frontImage = $item->book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=400&auto=format&fit=crop' }}" 
                         class="card-img-top w-100" alt="{{ $item->book->title }}" style="aspect-ratio: 2/2; object-fit: cover;">
                </a>
            </div>
            
            <div class="card-body p-3 d-flex flex-column">
                <a href="{{ route('book.show', $item->book->slug ?? $item->book->id) }}" class="text-decoration-none">
                    <h6 class="fw-bold text-dark mb-1 text-truncate wishlist-title" title="{{ $item->book->title }}">{{ $item->book->title }}</h6>
                </a>
                <p class="small text-muted mb-2 wishlist-author text-truncate">{{ $item->book->author->name ?? 'Unknown Author' }}</p>
                
                <div class="mt-auto d-flex justify-content-between align-items-center flex-wrap gap-1">
                    <span class="fw-bold text-accent wishlist-price">₹{{ $item->book->price }}</span>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold add-to-cart-home wishlist-add-btn" data-id="{{ $item->book->id }}">
                        Add <i class="fas fa-shopping-bag ms-1 d-none d-sm-inline"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
            
            <div class="text-center py-5 d-none" id="empty-wishlist-msg">
                <i class="far fa-heart fs-1 text-muted opacity-50 mb-3"></i>
                <p class="text-muted">Your wishlist is empty now.</p>
                <a href="{{ route('shop') }}" class="btn btn-accent rounded-pill px-4">Discover Books</a>
            </div>
            
        @else
            <div class="text-center py-5">
                <i class="far fa-heart fs-1 text-muted opacity-50 mb-3"></i>
                <p class="text-muted">You haven't added any books to your wishlist yet.</p>
                <a href="{{ route('shop') }}" class="btn btn-accent rounded-pill px-4">Discover Books</a>
            </div>
        @endif
    </div>
</div>
                        <div class="tab-pane fade" id="tab-address" role="tabpanel">
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
            <h2 class="card-title-dash border-0 mb-0 pb-0">Saved Addresses</h2>
            <button type="button" class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline ms-1">Add New</span>
            </button>
        </div>

        <div class="row g-3">
            @forelse($addresses as $address)
            <div class="col-md-6">
                <div class="border rounded-3 p-3 position-relative bg-light h-100">
                    @if($address->is_default)
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">Default</span>
                    @endif
                    <h5 class="fw-bold fs-6 mb-1 text-dark">{{ $address->first_name }} {{ $address->last_name }}</h5>
                    <p class="text-muted small mb-1">{{ $address->phone }}</p>
                    <p class="text-dark small mb-2 lh-sm">
                        {{ $address->address_line }}, 
                        @if($address->apartment) {{ $address->apartment }}, @endif <br>
                        {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                    </p>
                    
                    <div class="d-flex gap-3 border-top pt-2 mt-2">
                       <button type="button" class="btn btn-link text-accent p-0 fw-bold small text-decoration-none border-0 align-baseline edit-address-btn" 
    data-id="{{ $address->id }}"
    data-fname="{{ $address->first_name }}"
    data-lname="{{ $address->last_name }}"
    data-phone="{{ $address->phone }}"
    data-address="{{ $address->address_line }}"
    data-apt="{{ $address->apartment }}"
    data-city="{{ $address->city }}"
    data-state="{{ $address->state }}"
    data-pin="{{ $address->pincode }}"
    data-default="{{ $address->is_default }}">
    <i class="fas fa-edit me-1"></i> Edit
</button>
                        
                        <form action="{{ route('address.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0 fw-bold small text-decoration-none border-0 align-baseline"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <i class="far fa-map fs-1 text-muted opacity-50 mb-3"></i>
                <p class="text-muted">You haven't saved any addresses yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold font-playfair" id="addAddressModalLabel">Add New Address</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address Line</label>
                            <input type="text" name="address_line" class="form-control" placeholder="House No, Building, Street" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Apartment / Suite (Optional)</label>
                            <input type="text" name="apartment" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control" required>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" name="is_default" value="1" id="defaultCheck">
                                <label class="form-check-label text-muted small" for="defaultCheck">
                                    Set as default shipping address
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-pill">Save Address</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold font-playfair" id="editAddressModalLabel">Edit Address</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address Line</label>
                            <input type="text" name="address_line" id="edit_address_line" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Apartment / Suite (Optional)</label>
                            <input type="text" name="apartment" id="edit_apartment" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">City</label>
                            <input type="text" name="city" id="edit_city" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" id="edit_state" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" id="edit_pincode" class="form-control" required>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" name="is_default" value="1" id="edit_defaultCheck">
                                <label class="form-check-label text-muted small" for="edit_defaultCheck">
                                    Set as default shipping address
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-pill">Update Address</button>
                        </div>
                    </div>
                </form>
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

@push('scripts')
    <script>
$(document).ready(function() {

// 🌟 Check URL for tab parameters (e.g., ?tab=wishlist)
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');

    if (activeTab) {
        // Tab ka target dhundo (jaise: #tab-wishlist)
        let targetButton = $('button[data-bs-target="#tab-' + activeTab + '"]');
        
        // Agar button mil gaya toh usko active (click) kar do
        if (targetButton.length > 0) {
            targetButton.tab('show'); // Bootstrap 5 ka tab switch method
        }
    }



      $(document).on('click', '.add-to-cart-home', function(e) {
        e.preventDefault();
        let bookId = $(this).data('id');
        let btn = $(this);
        
        btn.html('<i class="fas fa-spinner fa-spin"></i>'); // Loading state

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                book_id: bookId,
                quantity: 1
            },
            success: function(response) {
                btn.html('<i class="fas fa-check"></i>');
                setTimeout(() => btn.html('<i class="fas fa-cart-plus"></i>'), 2000);

                if (typeof window.updateCartUI === 'function') {
                    window.updateCartUI(response); 
                }

                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Added to your bag!',
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#1e293b',
                    color: '#fff'
                });
            }
        });
    });




    // Remove from Wishlist (Dashboard specific)
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        let btn = $(this);
        let bookId = btn.data('id');
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin text-danger"></i>');

        $.ajax({
            url: "{{ route('wishlist.toggle') }}", // Hum wahi controller method use kar rahe hain
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                book_id: bookId
            },
            success: function(response) {
                if(response.status === 'removed') {
                    // Card ko slowly fade out karke remove kar do
                    $('.wishlist-item-wrapper-' + bookId).fadeOut(300, function() {
                        $(this).remove();
                        
                        // Count update karo
                        let currentCount = parseInt($('#wishlist-count').text());
                        if(!isNaN(currentCount)) {
                            let newCount = currentCount - 1;
                            $('#wishlist-count').text(newCount + ' Books');
                            
                            // Agar 0 ho gaya toh empty message dikhao
                            if(newCount === 0) {
                                $('.row.g-3').hide();
                                $('#empty-wishlist-msg').removeClass('d-none');
                            }
                        }
                    });
                    
                    Swal.fire({ toast: true, position: 'bottom-end', icon: 'success', title: 'Removed from wishlist', showConfirmButton: false, timer: 1500 });
                }
            }
        });
    });

    $(document).on('click', '.edit-address-btn', function() {
        let btn = $(this);
        
        // Form mein purana data bhar rahe hain
        $('#edit_first_name').val(btn.data('fname'));
        $('#edit_last_name').val(btn.data('lname'));
        $('#edit_phone').val(btn.data('phone'));
        $('#edit_address_line').val(btn.data('address'));
        $('#edit_apartment').val(btn.data('apt'));
        $('#edit_city').val(btn.data('city'));
        $('#edit_state').val(btn.data('state'));
        $('#edit_pincode').val(btn.data('pin'));
        
        if(btn.data('default') == 1 || btn.data('default') === true) {
            $('#edit_defaultCheck').prop('checked', true);
        } else {
            $('#edit_defaultCheck').prop('checked', false);
        }
        
        // Form ka action URL dynamically set kar rahe hain ID ke hisaab se
        let updateUrl = "{{ url('/my-account/address') }}/" + btn.data('id');
        $('#editAddressForm').attr('action', updateUrl);
        
        // Modal open karein
        $('#editAddressModal').modal('show');
    });
});
</script>
@endpush