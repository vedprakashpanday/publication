@extends('layouts.frontend')
@section('title', 'Shopping Cart | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       CART PAGE STYLES (PREMIUM FIX)
       ========================================= */
    .page-header { background-color: var(--bg-light); border-bottom: 1px solid #e2e8f0; }
    
    .cart-item { padding: 20px 0; border-bottom: 1px solid #e2e8f0; display: flex; gap: 20px; }
    .cart-item:last-child { border-bottom: none; }
    
    .cart-book-img { width: 100px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 2px 4px 10px rgba(0,0,0,0.05); }

    .cart-book-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.2rem; color: var(--primary-color); margin-bottom: 5px; }
    .cart-book-author { font-size: 0.85rem; color: #64748b; }
    .cart-book-price { font-weight: 700; color: var(--primary-color); font-size: 1.1rem; }

    /* Action Links Fix */
    .cart-action-link { color: #64748b; font-size: 0.85rem; font-weight: 600; text-decoration: none; background: none; border: none; padding: 5px 0; transition: 0.2s; }
    .cart-action-link:hover { color: var(--accent-color); }
    .cart-action-link.text-danger:hover { color: #dc2626 !important; }
    .cart-action-divider { color: #cbd5e1; margin: 0 10px; }

    .qty-group-sm { width: 110px; height: 35px; display: flex; }
    .qty-input-sm { text-align: center; font-weight: bold; border: 1px solid #cbd5e1; border-left: 0; border-right: 0; padding: 0; border-radius: 0; width: 40px; background: white; }
    .qty-btn-sm { background: #f8fafc; border: 1px solid #cbd5e1; padding: 0 12px; color: #475569; transition: 0.2s; display: flex; align-items: center; justify-content: center; }

    /* Summary Card (Restored Coupon & Charges) */
    .summary-card { background-color: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; position: sticky; top: 100px; }
    .summary-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.3rem; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #475569; }
    .summary-row.total { border-top: 1px dashed #cbd5e1; padding-top: 15px; margin-top: 10px; font-size: 1.25rem; font-weight: 800; color: var(--primary-color); }
    
    .btn-checkout { background-color: var(--accent-color); color: white; font-weight: 600; padding: 14px; border-radius: 50px; width: 100%; border: none; font-size: 1.05rem; transition: 0.3s; margin-top: 15px; }
    .btn-checkout:hover { background-color: #b45309; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.2); }

    .coupon-box { position: relative; margin-bottom: 20px; }
    .coupon-box input { border-radius: 50px; padding: 10px 100px 10px 20px; border: 1px solid #cbd5e1; height: 48px; font-size: 0.9rem; }
    .coupon-box .btn-apply { position: absolute; right: 5px; top: 5px; bottom: 5px; border-radius: 50px; background: var(--primary-color); color: white; border: none; padding: 0 20px; font-size: 0.85rem; font-weight: 600; }

    /* Saved for Later Section */
    .saved-section { margin-top: 60px; padding-top: 30px; border-top: 2px solid #e2e8f0; }
    .saved-item-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; transition: 0.3s; }
    .saved-item-card:hover { box-shadow: 0 8px 20px rgba(0,0,0,0.05); }

    @media (max-width: 768px) {
        .cart-item { gap: 15px; }
        .cart-book-img { width: 85px; height: 125px; }
        
        /* Mobile Buttons Spacing Fix */
       .cart-item-actions { 
        display: flex; 
        gap: 25px; /* Spacing badha di gayi hai */
        margin-top: 15px; 
        border-top: 1px solid #f1f5f9; 
        padding-top: 10px;
    }
    .cart-action-link { font-size: 0.9rem !important; }
        
        .mobile-checkout-bar { 
            position: fixed; bottom: 70px; left: 0; right: 0; 
            background: #fff; padding: 15px; 
            box-shadow: 0 -10px 20px rgba(0,0,0,0.1); 
            z-index: 1040; display: flex; justify-content: space-between; align-items: center; 
            border-top-left-radius: 20px; border-top-right-radius: 20px; 
        }
        .body-padding-mobile { padding-bottom: 160px; }
    }
</style>
@endsection

@section('content')

@php
    $subtotal = 0;
    foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
    
    // Naya Logic: Extra Charges
    $handling_fee = $subtotal > 0 ? round($subtotal * 0.02) : 0; // 2% handling
    $shipping_fee = ($subtotal > 0 && $subtotal < 500) ? 50 : 0; // ₹50 if order below 500
    $discount = session()->get('coupon.discount', 0);
    
    $total = $subtotal + $handling_fee + $shipping_fee - $discount;
    $savedItems = session()->get('saved_for_later', []);
@endphp

<div class="body-padding-mobile">
    <div class="page-header py-3 py-md-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active text-accent fw-bold">Shopping Cart</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold font-playfair text-dark mb-0">Your Bag <span class="text-muted fs-5">({{ count($cart) }} Items)</span></h1>
        </div>
    </div>

    <section class="pt-4 pb-5">
        <div class="container">
            @if(count($cart) > 0)
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    <div class="bg-white border rounded-4 p-3 p-md-4 shadow-sm">
                        @foreach($cart as $id => $details)
                        <div class="cart-item">
                            <img src="{{ $details['image'] ? asset('storage/'.$details['image']) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=200&auto=format&fit=crop' }}" class="cart-book-img d-none d-md-block" alt="{{ $details['title'] }}">
                            
                            <div class="d-flex flex-column justify-content-between w-100">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex gap-3">
                                        <img src="{{ $details['image'] ? asset('storage/'.$details['image']) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=200&auto=format&fit=crop' }}" class="cart-book-img d-md-none" alt="{{ $details['title'] }}">
                                        <div>
                                            <h3 class="cart-book-title mb-1">{{ $details['title'] }}</h3>
                                            <p class="cart-book-author mb-1">{{ $details['author'] }}</p>
                                            <span class="badge bg-light text-dark border small">Paperback</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="cart-book-price">₹{{ $details['price'] * $details['quantity'] }}</div>
                                        <small class="text-muted">₹{{ $details['price'] }} / unit</small>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 border-top pt-3 border-md-0 pt-md-0">
                                    <div class="qty-group-sm mb-2 mb-md-0">
                                        <button class="btn qty-btn-sm rounded-start update-cart" data-id="{{ $id }}" data-type="minus"><i class="fas fa-minus fs-6"></i></button>
                                        <input type="text" class="form-control qty-input-sm" value="{{ $details['quantity'] }}" readonly>
                                        <button class="btn qty-btn-sm rounded-end update-cart" data-id="{{ $id }}" data-type="plus"><i class="fas fa-plus fs-6"></i></button>
                                    </div>
                                    <div class="cart-item-actions">
                                        <button class="cart-action-link save-for-later" data-id="{{ $id }}"><i class="far fa-heart me-1"></i> Save for later</button>
                                        <span class="cart-action-divider d-none d-md-inline">|</span>
                                        <button class="cart-action-link text-danger fw-bold remove-from-cart" data-id="{{ $id }}"><i class="far fa-trash-alt me-1"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4"><a href="{{ route('shop') }}" class="text-decoration-none text-dark fw-bold"><i class="fas fa-arrow-left me-2 text-accent"></i> Continue Shopping</a></div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card shadow-sm">
                        <h4 class="summary-title">Order Summary</h4>
                        
                        <div class="coupon-box">
                            <input type="text" class="form-control" placeholder="Apply coupon">
                            <button class="btn-apply">Apply</button>
                        </div>

                        <div class="summary-row"><span>Bag Subtotal</span><span class="fw-bold text-dark">₹{{ $subtotal }}</span></div>
                        <div class="summary-row"><span>Handling Charges</span><span class="text-dark">₹{{ $handling_fee }}</span></div>
                        <div class="summary-row">
                            <span>Courier Charges</span>
                            <span class="{{ $shipping_fee == 0 ? 'text-success fw-bold' : 'text-dark' }}">
                                {{ $shipping_fee == 0 ? 'FREE' : '₹'.$shipping_fee }}
                            </span>
                        </div>
                        
                        @if($discount > 0)
                        <div class="summary-row"><span>Coupon Discount</span><span class="text-success fw-bold">- ₹{{ $discount }}</span></div>
                        @endif

                        <div class="summary-row total">
                            <span>Total Amount</span>
                            <span>₹{{ $total }}</span>
                        </div>

                        <button class="btn btn-checkout d-none d-md-block" onclick="window.location.href='{{ route('checkout') }}'">
                            Secure Checkout <i class="fas fa-lock ms-2 small opacity-75"></i>
                        </button>
                        
                        <div class="text-center mt-3 d-none d-md-block">
                            <img src="https://img.icons8.com/color/48/000000/visa.png" width="30">
                            <img src="https://img.icons8.com/color/48/000000/mastercard.png" width="30" class="mx-2">
                            <img src="https://img.icons8.com/color/48/000000/upi.png" width="30">
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-4x text-light-emphasis mb-4"></i>
                <h2 class="fw-bold font-playfair">Your Bag is Empty</h2>
                <p class="text-muted">Explore our latest arrivals and find your next great read.</p>
                <a href="{{ route('shop') }}" class="btn btn-accent rounded-pill px-5 py-2 mt-3 fw-bold">Shop Now</a>
            </div>
            @endif

            @if(count($savedItems) > 0)
            <div class="saved-section">
                <h3 class="fw-bold font-playfair mb-4">Saved for Later <span class="text-muted fs-5">({{ count($savedItems) }} items)</span></h3>
                <div class="row g-3">
                    @foreach($savedItems as $sid => $sitem)
                    <div class="col-md-6 col-lg-4">
                        <div class="saved-item-card d-flex gap-3">
                            <img src="{{ $sitem['image'] ? asset('storage/'.$sitem['image']) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=200&auto=format&fit=crop' }}" style="width: 75px; height: 110px; object-fit: cover; border-radius: 8px;">
                            <div class="d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <h4 class="fs-6 fw-bold mb-1 text-truncate" style="max-width: 180px;">{{ $sitem['title'] }}</h4>
                                    <div class="text-accent fw-bold small">₹{{ $sitem['price'] }}</div>
                                    <div class="text-muted small">By {{ $sitem['author'] }}</div>
                                </div>
                                <div class="d-flex gap-3 mt-2 border-top pt-2">
                                    <button class="cart-action-link move-to-cart text-primary" data-id="{{ $sid }}"><i class="fas fa-cart-plus me-1"></i> Move to Bag</button>
                                    <button class="cart-action-link text-danger remove-from-saved" data-id="{{ $sid }}"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    @if(count($cart) > 0)
    <div class="mobile-checkout-bar d-md-none">
        <div>
            <div class="text-muted small fw-bold">Grand Total</div>
            <div class="fs-4 fw-bold font-playfair text-dark">₹{{ $total }}</div>
        </div>
        <button class="btn btn-accent rounded-pill px-4 py-2 fw-bold shadow-sm" onclick="window.location.href='{{ route('checkout') }}'">
            Checkout <i class="fas fa-chevron-right ms-1"></i>
        </button>
    </div>
    @endif
</div> 

@endsection


    
@push('scripts')
<script>
    // Logic: Update Qty + Auto Remove if < 1
    // $('.update-cart').click(function (e) {
    //     e.preventDefault();
    //     let id = $(this).data('id');
    //     let type = $(this).data('type');
    //     let currentQty = parseInt($(this).siblings('input').val());
    //     let newQty = type === 'plus' ? currentQty + 1 : currentQty - 1;

    //     if (newQty < 1) {
    //         Swal.fire({
    //             title: 'Remove item?',
    //             text: "Do you want to remove this book from your bag?",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#dc2626',
    //             confirmButtonText: 'Yes, remove it!'
    //         }).then((result) => {
    //             if (result.isConfirmed) { removeItem(id); }
    //         });
    //         return;
    //     }

    //     $.ajax({
    //         url: "{{ route('cart.update') }}",
    //         method: "PATCH",
    //         data: { _token: '{{ csrf_token() }}', id: id, quantity: newQty },
    //         success: function () { window.location.reload(); }
    //     });
    // });

    function removeItem(id) {
        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "DELETE",
            data: { _token: '{{ csrf_token() }}', id: id },
            success: function () { window.location.reload(); }
        });
    }

    $('.remove-from-cart').click(function() { removeItem($(this).data('id')); });

    // Save for Later AJAX
    $('.save-for-later').click(function() {
        $.ajax({
            url: "/cart/save-for-later/" + $(this).data('id'),
            method: "POST",
            data: { _token: '{{ csrf_token() }}' },
            success: function() { window.location.reload(); }
        });
    });

    // Move back to Cart AJAX
    $('.move-to-cart').click(function() {
        $.ajax({
            url: "/cart/move-to-cart/" + $(this).data('id'),
            method: "POST",
            data: { _token: '{{ csrf_token() }}' },
            success: function() { window.location.reload(); }
        });
    });

    $('.update-cart').click(function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let type = $(this).data('type');
    let currentQty = parseInt($(this).siblings('input').val());
    let newQty = type === 'plus' ? currentQty + 1 : currentQty - 1;

    // FIX: Agar quantity 1 se niche jaye toh seedha remove trigger karo
    if (newQty < 1) {
        Swal.fire({
            title: 'Remove from bag?',
            text: "This item will be removed from your cart.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) { removeItem(id); }
        });
        return;
    }

    $.ajax({
        url: "{{ route('cart.update') }}",
        method: "PATCH",
        data: { _token: '{{ csrf_token() }}', id: id, quantity: newQty },
        success: function () { window.location.reload(); }
    });
});
</script>
@endpush