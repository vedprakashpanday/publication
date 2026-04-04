@extends('layouts.frontend')
@section('title', 'Secure Checkout | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       CHECKOUT PAGE STYLES
       ========================================= */
    body { background-color: #f8fafc; } /* Thoda light gray background forms ke liye achha lagta hai */

    .checkout-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 20px 0; }
    
    /* Step Cards */
    .step-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .step-header { display: flex; align-items: center; margin-bottom: 20px; }
    .step-number { width: 35px; height: 35px; background: var(--primary-color); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; margin-right: 15px; }
    .step-title { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color); font-size: 1.3rem; margin: 0; }

    /* Form Inputs */
    .form-label { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 5px; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px 15px; font-size: 0.95rem; }
    .form-control:focus, .form-select:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); }

    /* Payment Method Boxes */
    .payment-box { border: 2px solid #e2e8f0; border-radius: 10px; padding: 15px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 15px; margin-bottom: 10px; }
    .payment-box:hover { border-color: #cbd5e1; background: #f8fafc; }
    .payment-box.active { border-color: var(--accent-color); background: #fffbeb; }
    .payment-box input[type="radio"] { width: 18px; height: 18px; accent-color: var(--accent-color); cursor: pointer; }
    .payment-icon { font-size: 1.5rem; color: var(--primary-color); width: 30px; text-align: center; }
    .payment-text { font-weight: 600; color: var(--primary-color); margin: 0; }
    .payment-desc { font-size: 0.8rem; color: #64748b; margin: 0; }

    /* Order Summary (Right Side) */
    .summary-sidebar { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; position: sticky; top: 100px; }
    .summary-item { display: flex; gap: 15px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .summary-item-img { width: 60px; height: 90px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; }
    .summary-item-title { font-weight: 700; font-size: 0.95rem; color: var(--primary-color); margin-bottom: 3px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    
    .calc-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; color: #475569; }
    .calc-total { border-top: 1px dashed #cbd5e1; padding-top: 15px; margin-top: 10px; font-size: 1.2rem; font-weight: 700; color: var(--primary-color); display: flex; justify-content: space-between; }

    .btn-pay { background-color: var(--accent-color); color: white; font-weight: 700; padding: 14px; border-radius: 50px; width: 100%; transition: 0.3s; border: none; font-size: 1.1rem; margin-top: 20px; }
    .btn-pay:hover { background-color: #b45309; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(217, 119, 6, 0.3); color: white; }

   /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS (FIXED)
       ========================================= */
    @media (max-width: 991px) {
        .mobile-pay-bar {
            position: fixed;
            bottom: 70px; /* ✅ FIXED: Bottom nav ke theek upar set kiya */
            left: 0;
            right: 0;
            background: #fff;
            padding: 22px 20px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.08);
            z-index: 1040; /* Bottom nav ke z-index se adjust kiya */
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .body-padding-mobile { 
            padding-bottom: 160px; /* ✅ FIXED: Page ke end me extra jagah di taki form chhup na jaye */
        }
    }
        
</style>
@endsection

@section('content')

<div class="body-padding-mobile">

    <div class="checkout-header shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h2 class="font-playfair fw-bold m-0"><i class="fas fa-lock text-success me-2 fs-4"></i> Secure Checkout</h2>
            <a href="{{ url('/cart') }}" class="text-decoration-none text-muted fw-bold small"><i class="fas fa-arrow-left me-1"></i> Back to Cart</a>
        </div>
    </div>

    <section class="py-4 py-md-5">
        <div class="container">
            <div class="row g-4 g-lg-5">
                
                <div class="col-lg-7 col-xl-8">
                    <form action="#" method="POST">
                        @csrf
                        
                        <div class="step-card">
                            <div class="step-header">
                                <div class="step-number">1</div>
                                <h3 class="step-title">Contact Information</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" placeholder="john@example.com" required value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted">+91</span>
                                        <input type="tel" class="form-control border-start-0" placeholder="9876543210" required>
                                    </div>
                                </div>
                                @guest
                                <div class="col-12 mt-3 small text-muted">
                                    Already have an account? <a href="{{ route('login') }}" class="text-accent fw-bold text-decoration-none">Log in</a> for faster checkout.
                                </div>
                                @endguest
                            </div>
                        </div>

                        <div class="step-card">
                            <div class="step-header">
                                <div class="step-number">2</div>
                                <h3 class="step-title">Shipping Address</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Street Address / House No. *</label>
                                    <input type="text" class="form-control" placeholder="House number and street name" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Apartment, suite, etc. (optional)</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State *</label>
                                    <select class="form-select" required>
                                        <option value="">Select State...</option>
                                        <option value="DL">Delhi</option>
                                        <option value="UP">Uttar Pradesh</option>
                                        <option value="MH">Maharashtra</option>
                                        </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">PIN Code *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="step-card">
                            <div class="step-header">
                                <div class="step-number">3</div>
                                <h3 class="step-title">Payment Method</h3>
                            </div>
                            <p class="small text-muted mb-3">All transactions are secure and encrypted.</p>
                            
                            <label class="payment-box active" onclick="selectPayment(this)">
                                <input type="radio" name="payment_method" value="online" checked>
                                <i class="fas fa-credit-card payment-icon"></i>
                                <div>
                                    <h6 class="payment-text">Pay Online (UPI, Cards, NetBanking)</h6>
                                    <p class="payment-desc">Powered by Razorpay. 100% Secure.</p>
                                </div>
                                <div class="ms-auto d-none d-sm-flex gap-1 text-muted fs-5">
                                    <i class="fab fa-cc-visa"></i>
                                    <i class="fab fa-cc-mastercard"></i>
                                    <i class="fab fa-google-pay"></i>
                                </div>
                            </label>

                            <label class="payment-box" onclick="selectPayment(this)">
                                <input type="radio" name="payment_method" value="cod">
                                <i class="fas fa-money-bill-wave payment-icon"></i>
                                <div>
                                    <h6 class="payment-text">Cash on Delivery (COD)</h6>
                                    <p class="payment-desc">Pay when you receive the package.</p>
                                </div>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5 col-xl-4">
                    <div class="summary-sidebar shadow-sm">
                        <h4 class="font-playfair fw-bold text-dark mb-4 border-bottom pb-2">Order Summary</h4>
                        
                        <div class="summary-items-wrap mb-4">
                            <div class="summary-item">
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=100&auto=format&fit=crop" class="summary-item-img">
                                <div class="w-100">
                                    <h6 class="summary-item-title">The Art of Storytelling</h6>
                                    <div class="text-muted small mb-1">Qty: 1 &times; ₹299</div>
                                    <div class="fw-bold text-dark">₹299</div>
                                </div>
                            </div>
                            <div class="summary-item">
                                <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=100&auto=format&fit=crop" class="summary-item-img">
                                <div class="w-100">
                                    <h6 class="summary-item-title">Ghazals of the Night</h6>
                                    <div class="text-muted small mb-1">Qty: 1 &times; ₹499</div>
                                    <div class="fw-bold text-dark">₹499</div>
                                </div>
                            </div>
                        </div>

                        <div class="calc-row">
                            <span>Subtotal</span>
                            <span class="fw-bold text-dark">₹798</span>
                        </div>
                        <div class="calc-row">
                            <span>Discount (Welcome20)</span>
                            <span class="text-success fw-bold">- ₹200</span>
                        </div>
                        <div class="calc-row">
                            <span>Shipping Fee</span>
                            <span class="text-success fw-bold">Free</span>
                        </div>
                        
                        <div class="calc-total">
                            <span>Total</span>
                            <span>₹598</span>
                        </div>

                        <button class="btn btn-pay d-none d-lg-block">
                            <i class="fas fa-lock me-1"></i> Pay ₹598
                        </button>
                        
                        <div class="text-center mt-3 small text-muted">
                            <i class="fas fa-shield-alt text-success"></i> Your personal data will be used to process your order and support your experience on this website.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="mobile-pay-bar d-lg-none">
        <div>
            <div class="text-muted small fw-bold">Total Payable</div>
            <div class="fs-4 fw-bold font-playfair text-dark" style="line-height: 1;">₹598</div>
        </div>
        <button class="btn btn-accent rounded-pill px-5 py-2 fw-bold shadow-sm fs-5" onclick="document.querySelector('form').submit();">
            Pay Now <i class="fas fa-arrow-right ms-2 small"></i>
        </button>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // Payment Box Selection Logic
    function selectPayment(element) {
        // Remove active class from all boxes
        document.querySelectorAll('.payment-box').forEach(box => {
            box.classList.remove('active');
        });
        
        // Add active class to clicked box
        element.classList.add('active');
        
        // Check the radio button inside
        element.querySelector('input[type="radio"]').checked = true;
    }
</script>
@endsection