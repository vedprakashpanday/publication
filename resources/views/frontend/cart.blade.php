@extends('layouts.frontend')
@section('title', 'Shopping Cart | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       CART PAGE STYLES
       ========================================= */
    .page-header { background-color: var(--bg-light); border-bottom: 1px solid #e2e8f0; }
    
    /* Cart Item Layout */
    .cart-item { 
        padding: 20px 0; 
        border-bottom: 1px solid #e2e8f0; 
        display: flex; 
        gap: 20px; 
    }
    .cart-item:last-child { border-bottom: none; }
    
    .cart-book-img { 
        width: 100px; 
        height: 150px; 
        object-fit: cover; 
        border-radius: 8px; 
        border: 1px solid #e2e8f0;
        box-shadow: 2px 4px 10px rgba(0,0,0,0.05);
    }

    .cart-book-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.2rem; color: var(--primary-color); margin-bottom: 5px; }
    .cart-book-author { font-size: 0.85rem; color: #64748b; }
    .cart-book-price { font-weight: 700; color: var(--primary-color); font-size: 1.1rem; }
    .cart-book-mrp { font-size: 0.9rem; color: #94a3b8; text-decoration: line-through; margin-left: 8px; }

    /* Action Links (Remove, Wishlist) */
    .cart-action-link { 
        color: #64748b; 
        font-size: 0.85rem; 
        font-weight: 600; 
        text-decoration: none; 
        transition: 0.2s; 
        background: none;
        border: none;
        padding: 0;
    }
    .cart-action-link:hover { color: var(--accent-color); }
    .cart-action-link.text-danger:hover { color: #dc2626 !important; }
    .cart-action-divider { color: #cbd5e1; margin: 0 10px; }

    /* Quantity Selector */
    .qty-group-sm { width: 110px; height: 35px; display: flex; }
    .qty-input-sm { text-align: center; font-weight: bold; border: 1px solid #cbd5e1; border-left: 0; border-right: 0; padding: 0; border-radius: 0; }
    .qty-btn-sm { background: #f8fafc; border: 1px solid #cbd5e1; padding: 0 12px; color: #475569; transition: 0.2s; display: flex; align-items: center; justify-content: center; }
    .qty-btn-sm:hover { background: #e2e8f0; }

    /* Order Summary Card */
    .summary-card { 
        background-color: #fff; 
        border: 1px solid #e2e8f0; 
        border-radius: 12px; 
        padding: 25px; 
        position: sticky; 
        top: 100px; 
    }
    .summary-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.3rem; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
    
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: #475569; }
    .summary-row.total { border-top: 1px dashed #cbd5e1; padding-top: 15px; margin-top: 5px; font-size: 1.2rem; font-weight: 700; color: var(--primary-color); }
    
    .btn-checkout { 
        background-color: var(--accent-color); 
        color: white; 
        font-weight: 600; 
        padding: 12px; 
        border-radius: 50px; 
        width: 100%; 
        transition: 0.3s; 
        border: none; 
        font-size: 1.05rem;
    }
    .btn-checkout:hover { background-color: #b45309; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(217, 119, 6, 0.3); color: white; }

    /* Coupon Box */
    .coupon-box { position: relative; margin-bottom: 20px; }
    .coupon-box input { border-radius: 50px; padding-right: 90px; border: 1px solid #cbd5e1; }
    .coupon-box input:focus { border-color: var(--primary-color); box-shadow: none; }
    .coupon-box .btn-apply { position: absolute; right: 5px; top: 5px; bottom: 5px; border-radius: 50px; background: var(--primary-color); color: white; border: none; padding: 0 15px; font-size: 0.85rem; font-weight: 600; }

    /* =========================================
       SUGGESTION BOOK CARDS (Reused)
       ========================================= */
    .book-card { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff; transition: 0.3s; display: flex; flex-direction: column; height: 100%; position: relative; }
    .book-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08); transform: translateY(-5px); }
    .book-cover { width: 100%; aspect-ratio: 2/3; object-fit: cover; border-bottom: 1px solid #f1f5f9; }
    .book-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.1rem; color: var(--primary-color); margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .book-author { font-size: 0.85rem; color: #64748b; margin-bottom: 10px; }
    .book-price { font-weight: 600; color: var(--accent-color); font-size: 1.1rem; }
    .btn-cart-circle { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; background: var(--accent-color); color: white; border: none; transition: 0.3s; }
    .btn-cart-circle:hover { background: #b45309; transform: scale(1.1); }

    /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS
       ========================================= */
    @media (max-width: 768px) {
        .cart-item { gap: 15px; flex-direction: column; }
        .cart-book-img { width: 90px; height: 130px; }
        .cart-book-title { font-size: 1.1rem; }
        
        .mobile-checkout-bar {
            position: fixed;
            bottom: 70px;
            left: 0;
            right: 0;
            background: #fff;
            padding: 15px;
            box-shadow: 0 -5px 15px rgba(0,0,0,0.05);
            z-index: 1040;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .body-padding-mobile { padding-bottom: 150px; }
    }
</style>
@endsection

@section('content')

<div class="body-padding-mobile">

    <div class="page-header py-3 py-md-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i> Home</a></li>
                    <li class="breadcrumb-item active text-accent fw-bold" aria-current="page">Shopping Cart</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold font-playfair text-dark mb-0">Your Bag <span class="text-muted fs-5">(2 Items)</span></h1>
        </div>
    </div>

    <section class="pt-4 pb-5">
        <div class="container">
            
            <div class="row g-4 g-lg-5">
                
                <div class="col-lg-8">
                    <div class="bg-white border rounded-4 p-3 p-md-4 shadow-sm">
                        
                        <div class="cart-item flex-md-row">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=200&auto=format&fit=crop" class="cart-book-img d-none d-md-block" alt="Book">
                            
                            <div class="d-flex flex-column justify-content-between w-100">
                                
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-3">
                                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=200&auto=format&fit=crop" class="cart-book-img d-md-none" alt="Book">
                                        <div>
                                            <h3 class="cart-book-title mb-1">The Art of Storytelling</h3>
                                            <p class="cart-book-author mb-1">Ved Prakash Panday</p>
                                            <span class="badge bg-light text-dark border small mt-1">Paperback</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="cart-book-price">₹299</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-end mt-3 border-top pt-3 border-md-0 pt-md-0">
                                    <div class="qty-group-sm">
                                        <button class="btn qty-btn-sm rounded-start"><i class="fas fa-minus fs-6"></i></button>
                                        <input type="text" class="form-control qty-input-sm" value="1" readonly>
                                        <button class="btn qty-btn-sm rounded-end"><i class="fas fa-plus fs-6"></i></button>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="cart-action-link d-none d-sm-inline-block"><i class="far fa-heart me-1"></i> Save for later</button>
                                        <span class="cart-action-divider d-none d-sm-inline-block">|</span>
                                        <button class="cart-action-link text-danger fw-bold"><i class="far fa-trash-alt me-1"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="cart-item flex-md-row">
                            <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=200&auto=format&fit=crop" class="cart-book-img d-none d-md-block" alt="Book">
                            
                            <div class="d-flex flex-column justify-content-between w-100">
                                
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-3">
                                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=200&auto=format&fit=crop" class="cart-book-img d-md-none" alt="Book">
                                        <div>
                                            <h3 class="cart-book-title mb-1">Ghazals of the Night</h3>
                                            <p class="cart-book-author mb-1">Aman Verma</p>
                                            <span class="badge bg-light text-dark border small mt-1">Hardcover</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="cart-book-price">₹499</div>
                                        <div class="cart-book-mrp text-muted small text-decoration-line-through">₹699</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-end mt-3 border-top pt-3 border-md-0 pt-md-0">
                                    <div class="qty-group-sm">
                                        <button class="btn qty-btn-sm rounded-start"><i class="fas fa-minus fs-6"></i></button>
                                        <input type="text" class="form-control qty-input-sm" value="1" readonly>
                                        <button class="btn qty-btn-sm rounded-end"><i class="fas fa-plus fs-6"></i></button>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="cart-action-link d-none d-sm-inline-block"><i class="far fa-heart me-1"></i> Save for later</button>
                                        <span class="cart-action-divider d-none d-sm-inline-block">|</span>
                                        <button class="cart-action-link text-danger fw-bold"><i class="far fa-trash-alt me-1"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="mt-4 text-center text-md-start">
                        <a href="{{ url('/') }}" class="text-decoration-none text-dark fw-bold"><i class="fas fa-arrow-left me-2 text-accent"></i> Continue Shopping</a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card shadow-sm">
                        <h4 class="summary-title">Order Summary</h4>
                        
                        <div class="coupon-box">
                            <input type="text" class="form-control" placeholder="Enter coupon code">
                            <button class="btn-apply">Apply</button>
                        </div>

                        <div class="summary-row mt-4">
                            <span>Subtotal (2 Items)</span>
                            <span class="fw-bold text-dark">₹798</span>
                        </div>
                        <div class="summary-row">
                            <span>Discount</span>
                            <span class="text-success fw-bold">- ₹200</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Total Amount</span>
                            <span>₹598</span>
                        </div>
                        <p class="text-muted small text-end mb-4">You will save ₹200 on this order!</p>

                        <button class="btn btn-checkout d-none d-md-block">
                            Proceed to Checkout <i class="fas fa-lock ms-2 small opacity-75"></i>
                        </button>
                        
                        <div class="text-center mt-3 d-none d-md-block">
                            <div class="small text-muted fw-bold"><i class="fas fa-shield-alt text-success"></i> 100% Secure Payments</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5 bg-light border-top">
        <div class="container">
            <div class="mb-4 text-center text-md-start">
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Based on your cart</span>
                <h3 class="fw-bold font-playfair text-dark mb-0">Frequently Bought Together</h3>
            </div>
            
            <div class="row g-3 g-md-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="book-card border-0 shadow-sm">
                        <a href="#" class="text-decoration-none text-dark">
                            <span class="badge bg-dark position-absolute m-2" style="z-index: 1;">By Ved Prakash</span>
                            <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h3 class="book-title fs-6">The Grand Journey</h3>
                                <div class="mt-auto d-flex justify-content-between align-items-center mt-2">
                                    <span class="book-price fs-6">₹399</span>
                                    <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="book-card border-0 shadow-sm">
                        <a href="#" class="text-decoration-none text-dark">
                            <span class="badge bg-dark position-absolute m-2" style="z-index: 1;">By Aman Verma</span>
                            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h3 class="book-title fs-6">Midnight Poetry</h3>
                                <div class="mt-auto d-flex justify-content-between align-items-center mt-2">
                                    <span class="book-price fs-6">₹250</span>
                                    <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 d-none d-md-block">
                    <div class="book-card border-0 shadow-sm">
                        <a href="#" class="text-decoration-none text-dark">
                            <img src="https://images.unsplash.com/photo-1618666012174-83b441c0bc76?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h3 class="book-title fs-6">Echoes of the Past</h3>
                                <p class="book-author mb-1 small">Ravi Sharma</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center mt-2">
                                    <span class="book-price fs-6">₹350</span>
                                    <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3 d-none d-lg-block">
                    <div class="book-card border-0 shadow-sm">
                        <a href="#" class="text-decoration-none text-dark">
                            <span class="badge bg-danger position-absolute m-2" style="z-index: 1;">Sale</span>
                            <img src="https://images.unsplash.com/photo-1476275466078-4007374efbbe?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h3 class="book-title fs-6">The Hidden Truth</h3>
                                <p class="book-author mb-1 small">Divyansh Exclusives</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center mt-2">
                                    <span class="book-price fs-6">₹499</span>
                                    <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mobile-checkout-bar d-md-none">
        <div>
            <div class="text-muted small fw-bold">Total Amount</div>
            <div class="fs-4 fw-bold font-playfair text-dark" style="line-height: 1;">₹598</div>
            <div class="text-success small fw-bold" style="font-size: 0.75rem;">You save ₹200</div>
        </div>
        <button class="btn btn-accent rounded-pill px-4 py-2 fw-bold shadow-sm">
            Checkout <i class="fas fa-chevron-right ms-1"></i>
        </button>
    </div>

</div> @endsection