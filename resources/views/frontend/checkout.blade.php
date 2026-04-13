@extends('layouts.frontend')
@section('title', 'Secure Checkout | Divyansh Publication')

@section('styles')
<style>
    body { background-color: #f8fafc; }
    .checkout-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 20px 0; }
    .step-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .step-number { width: 35px; height: 35px; background: var(--primary-color); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px; }
    .step-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.3rem; margin: 0; }
    .form-label { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 5px; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 15px; font-size: 0.95rem; }
    .payment-box { border: 2px solid #e2e8f0; border-radius: 10px; padding: 15px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 15px; margin-bottom: 10px; }
    .payment-box.active { border-color: var(--accent-color); background: #fffbeb; }
    .summary-sidebar { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; position: sticky; top: 100px; }
    .summary-item-img { width: 50px; height: 75px; object-fit: cover; border-radius: 4px; }
    /* ADD THIS TO YOUR STYLES SECTION */
.saved-address-box { border: 2px solid transparent !important; }
.saved-address-box.selected-address {
    border-color: var(--primary-color) !important;
    background-color: #fff !important;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.saved-address-box.selected-address::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    bottom: 10px;
    right: 15px;
    color: var(--primary-color);
    font-size: 1.2rem;
}
.btn-pay {
    background-color: var(--primary-color);
    color: white;
    font-weight: bold;
    padding: 15px;
    width: 100%;
    border-radius: 10px;
    transition: 0.3s;
    font-size: 1.1rem;
}
.btn-pay:hover {
    background-color: #0f172a;
    transform: translateY(-2px);
    color: white;
}
    
    @media (max-width: 991px) {
        .mobile-pay-bar { position: fixed; bottom: 70px; left: 0; right: 0; background: #fff; padding: 20px; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); z-index: 1040; display: flex; justify-content: space-between; align-items: center; border-radius: 15px 15px 0 0; }
        .body-padding-mobile { padding-bottom: 160px; }
    }
</style>
@endsection

@section('content')
@php
    $cart = session('cart', []);
    $subtotal = 0;
    foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
    $handling = round($subtotal * 0.02);
    $shipping = ($subtotal > 0 && $subtotal < 500) ? 50 : 0;
    $total = $subtotal + $handling + $shipping;
@endphp

<div class="body-padding-mobile">
    <div class="checkout-header shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h2 class="font-playfair fw-bold m-0"><i class="fas fa-lock text-success me-2"></i> Checkout</h2>
            <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted fw-bold small">Edit Bag</a>
        </div>
    </div>

    <section class="py-4 py-md-5">
        <div class="container">
            <form action="{{ route('placeOrder') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="row g-4 g-lg-5">
                    
                    <div class="col-lg-7 col-xl-8">
                        @auth
                            <div class="step-card">
                                <div class="step-header"><div class="step-number">1</div><h3 class="step-title">Contact Information</h3></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address *</label>
                                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number *</label>
                                        <input type="tel" name="phone" id="contact_phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" placeholder="10-digit number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="step-card">
    <div class="step-header mb-4">
        <div class="step-number">2</div>
        <h3 class="step-title">Shipping Address</h3>
    </div>
    
    @auth
        @if(isset($addresses) && $addresses->count() > 0)
        <div class="mb-4">
            <label class="form-label text-dark fw-bold mb-3"><i class="far fa-address-book text-accent me-1"></i> Select a Saved Address</label>
            <div class="row g-3">
                @foreach($addresses as $addr)
                <div class="col-md-6">
                    <div class="border rounded-3 p-3 position-relative bg-light saved-address-box" 
                         style="cursor: pointer; transition: 0.3s;"
                         onclick="fillAddress(this)"
                         data-fname="{{ $addr->first_name }}"
                         data-lname="{{ $addr->last_name }}"
                         data-phone="{{ $addr->phone }}"
                         data-address="{{ $addr->address_line }}"
                         data-apt="{{ $addr->apartment }}"
                         data-city="{{ $addr->city }}"
                         data-state="{{ $addr->state }}"
                         data-pin="{{ $addr->pincode }}">
                        
                        @if($addr->is_default)
                            <span class="badge bg-success position-absolute top-0 end-0 m-2 default-badge">Default</span>
                        @endif
                        
                        <h6 class="fw-bold mb-1">{{ $addr->first_name }} {{ $addr->last_name }}</h6>
                        <p class="small text-muted mb-1">{{ $addr->phone }}</p>
                        <p class="small text-muted mb-0 lh-sm text-truncate">
                            {{ $addr->address_line }}, {{ $addr->city }}...
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex align-items-center mt-4 mb-3">
    <hr class="flex-grow-1 m-0">
    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4 fw-bold mx-3 shadow-sm" id="btn-manual-address">
        <i class="fas fa-edit me-1"></i> Enter New Address
    </button>
    <hr class="flex-grow-1 m-0">
</div>
        </div>
        @endif
    @endauth
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">First Name *</label><input type="text" name="first_name" id="ship_fname" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Last Name *</label><input type="text" name="last_name" id="ship_lname" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Street Address *</label><input type="text" name="address" id="ship_address" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Apartment (Optional)</label><input type="text" name="apartment" id="ship_apt" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">City *</label><input type="text" name="city" id="ship_city" class="form-control" required></div>
        <div class="col-md-4">
            <label class="form-label">State *</label>
            <select name="state" id="ship_state" class="form-select" required>
                <option value="">Select State...</option>
                <option value="Bihar">Bihar</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Delhi">Delhi</option>
            </select>
        </div>
        <div class="col-md-2"><label class="form-label">PIN *</label><input type="text" name="pincode" id="ship_pin" class="form-control" required></div>
    </div>
</div>

                            <div class="step-card">
                                <div class="step-header"><div class="step-number">3</div><h3 class="step-title">Payment</h3></div>
                                <label class="payment-box active" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="online" checked>
                                    <i class="fas fa-credit-card text-accent fs-4"></i>
                                    <div><h6 class="mb-0 fw-bold">Online Payment</h6><p class="small text-muted mb-0">UPI, Cards, Netbanking</p></div>
                                </label>
                                <label class="payment-box" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="cod">
                                    <i class="fas fa-truck text-accent fs-4"></i>
                                    <div><h6 class="mb-0 fw-bold">Cash on Delivery</h6><p class="small text-muted mb-0">Pay at your doorstep</p></div>
                                </label>
                            </div>
                        @else
                            <div class="step-card text-center py-5">
                                <i class="far fa-user-circle fa-4x text-muted mb-3 opacity-50"></i>
                                <h3 class="font-playfair fw-bold text-dark mb-2">Account Sign-In Required</h3>
                                <p class="text-muted mb-4 px-md-5">Please sign in to your account to securely complete your purchase, track your order status, and ensure a seamless experience.</p>
                                <button type="button" class="btn btn-accent rounded-pill px-5 py-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fas fa-lock me-2"></i> Sign In to Continue
                                </button>
                                <div class="mt-4 small text-muted">
                                    New to Divyansh Publication? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" class="text-accent fw-bold text-decoration-none">Create an Account</a>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div class="col-lg-5 col-xl-4">
                        <div class="summary-sidebar shadow-sm">
                            <h4 class="font-playfair fw-bold mb-4 border-bottom pb-2">Order Summary</h4>
                           @foreach($cart as $item)
<div class="d-flex gap-3 mb-3 border-bottom pb-3">
    
    @if(!empty($item['image']))
        <img src="{{ asset('uploads/books/covers/' . $item['image']) }}" class="summary-item-img" alt="{{ $item['title'] }}" onerror="this.src='https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=100&auto=format&fit=crop'">
    @else
        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=100&auto=format&fit=crop" class="summary-item-img" alt="Placeholder">
    @endif
    <div>
        <h6 class="summary-item-title">{{ $item['title'] }}</h6>
        <div class="small text-muted">Qty: {{ $item['quantity'] }}</div>
        <div class="fw-bold">₹{{ $item['price'] * $item['quantity'] }}</div>
    </div>
</div>
@endforeach
                            <div class="calc-row"><span>Subtotal</span><span>₹{{ $subtotal }}</span></div>
                            <div class="calc-row"><span>Handling</span><span>₹{{ $handling }}</span></div>
                            <div class="calc-row"><span>Shipping</span><span class="text-success">{{ $shipping == 0 ? 'FREE' : '₹'.$shipping }}</span></div>
                            <div class="calc-total"><span>Total</span><span>₹{{ $total }}</span></div>
                            
                            @auth
                               <button type="submit" class="btn btn-pay d-none d-lg-block border-0 shadow mt-3">
    Complete Purchase <i class="fas fa-arrow-right ms-2"></i>
</button>
                            @else
                                <button type="button" class="btn btn-pay d-none d-lg-block border shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Login to Pay</button>
                            @endauth
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </section>

    <div class="mobile-pay-bar d-lg-none">
        <div><div class="text-muted small fw-bold">Total Payable</div><div class="fs-4 fw-bold">₹{{ $total }}</div></div>
        
        @auth
           <button type="submit" form="checkoutForm" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow">
    Complete Purchase <i class="fas fa-arrow-right ms-1"></i>
</button>
        @else
            <button type="button" class="btn btn-accent rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Login <i class="fas fa-arrow-right ms-1"></i></button>
        @endauth
    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(document).ready(function() {
        // Agar backend se auth_required ka signal aaya hai (Fallback logic)
        @if(session('auth_required'))
            var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
            myModal.show();
            $('#loginModal .auth-subtitle').html('<div class="alert alert-warning py-2 small"><i class="fas fa-exclamation-circle me-1"></i> {{ session('auth_required') }}</div>');
        @endif

        // 🌟 FORM SUBMISSION & RAZORPAY POPUP LOGIC
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault(); // Normal form submit roko
        
        let submitBtn = $('.btn-pay');
        let originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'cod') {
                    // COD hai toh seedha success page par jao
                    window.location.href = res.redirect_url;
                } 
                else if (res.status === 'online') {
                    // Online hai toh Razorpay popup kholo
                    var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}", 
                        "amount": res.amount, 
                        "currency": "INR",
                        "name": "Divyansh Publication",
                        "description": "Book Purchase - " + res.order_number,
                        "order_id": res.razorpay_order_id,
                        "handler": function (response){
                            // Payment success hone ke baad Verify API call karein
                            submitBtn.html('<i class="fas fa-circle-notch fa-spin me-2"></i> Verifying Payment...');
                            
                            $.post("{{ route('razorpay.verify') }}", {
                                _token: "{{ csrf_token() }}",
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature,
                                order_number: res.order_number
                            }, function(verifyRes) {
                                if(verifyRes.status === 'success') {
                                    window.location.href = verifyRes.redirect_url;
                                } else {
                                    Swal.fire('Error', 'Payment verification failed: ' + verifyRes.message, 'error');
                                    submitBtn.html(originalText).prop('disabled', false);
                                }
                            });
                        },
                        "prefill": {
                            "name": res.user_name,
                            "email": res.user_email,
                            "contact": res.user_phone
                        },
                        "theme": {
                            "color": "#ea580c" // Aapka Accent Color
                        },
                        "modal": {
                            "ondismiss": function(){
                                // Agar user popup band kar de
                                submitBtn.html(originalText).prop('disabled', false);
                            }
                        }
                    };
                    
                    var rzp = new Razorpay(options);
                    rzp.on('payment.failed', function (response){
                        Swal.fire('Payment Failed', response.error.description, 'error');
                        submitBtn.html(originalText).prop('disabled', false);
                    });
                    rzp.open();
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong while processing your order.', 'error');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    });

    // Payment Selection Logic
    function selectPayment(el) {
        document.querySelectorAll('.payment-box').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;
    }

    $(document).ready(function() {
        // Fallback Auth Error Logic
        @if(session('auth_required'))
            var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
            myModal.show();
            $('#loginModal .auth-subtitle').html('<div class="alert alert-warning py-2 small"><i class="fas fa-exclamation-circle me-1"></i> {{ session('auth_required') }}</div>');
        @endif

        // 🌟 Auto-select 'Default' address on page load
        let defaultAddr = $('.saved-address-box').has('.default-badge');
        if(defaultAddr.length > 0) {
            fillAddress(defaultAddr[0]); 
        }

        // 🌟 NAYA: Enter Manually Button Logic
        $('#btn-manual-address').on('click', function() {
            // Address box se selection hatao
            $('.saved-address-box').removeClass('selected-address');
            
            // Form fields ko clear karo aur readonly hata do (Unfreeze)
            $('#ship_fname, #ship_lname, #ship_address, #ship_apt, #ship_city, #ship_pin').val('').prop('readonly', false);
            
            // Select tag thoda alag handle hota hai
            $('#ship_state').val('').css('pointer-events', 'auto').css('background-color', '#fff');
            
            // Focus on first name so user can start typing
            $('#ship_fname').focus();
        });
    });

    // Payment Selection Logic
    function selectPayment(el) {
        document.querySelectorAll('.payment-box').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;
    }

    // 🌟 ADDRESS AUTO-FILL LOGIC (Updated to FREEZE fields)
    function fillAddress(el) {
        let box = $(el);
        
        // UI Highlight
        $('.saved-address-box').removeClass('selected-address');
        box.addClass('selected-address');

        // Fill Data
        $('#ship_fname').val(box.data('fname'));
        $('#ship_lname').val(box.data('lname'));
        $('#ship_address').val(box.data('address'));
        $('#ship_apt').val(box.data('apt'));
        $('#ship_city').val(box.data('city'));
        let stateName = String(box.data('state')).trim().toLowerCase();

// Ye har option ko check karega aur case-insensitive match karega
$('#ship_state option').filter(function() {
    return $(this).val().trim().toLowerCase() === stateName || 
           $(this).text().trim().toLowerCase() === stateName;
}).prop('selected', true);

// (Optional) Agar aap select2 ya koi plugin use kar rahe hain toh UI update karne ke liye
$('#ship_state').trigger('change');
        $('#ship_pin').val(box.data('pin'));

        let phoneData = box.data('phone');
        if(phoneData) {
            $('#contact_phone').val(phoneData);
        }

        // 🌟 FREEZE (Readonly) Kar rahe hain
        $('#ship_fname, #ship_lname, #ship_address, #ship_apt, #ship_city, #ship_pin').prop('readonly', true);
        
        // Select ko readonly karne ka CSS tareeka
        $('#ship_state').css('pointer-events', 'none').css('background-color', '#f8fafc');

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Address Applied!',
            showConfirmButton: false,
            timer: 1000
        });
    }


</script>


@endpush