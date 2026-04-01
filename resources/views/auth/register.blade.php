@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-block bg-primary text-white rounded-circle p-3 mb-3 shadow-sm">
                            <i class="fas fa-user-plus fs-3"></i>
                        </div>
                        <h2 class="fw-bold text-dark">Create an Account</h2>
                        <p class="text-muted">Join Divyansh Publication's growing network.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">{{ __('Full Name') }}</label>
                                <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="e.g. Rahul Kumar">
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="account_type" class="form-label fw-bold text-primary">I want to register as a:</label>
                            <select id="account_type" class="form-select form-select-lg @error('role') is-invalid @enderror" name="role" required onchange="toggleSellerFields(this.value)">
                                <option value="user">📚 Reader (Buy Books)</option>
                                <option value="seller">🤝 Partner / Seller</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div id="seller_fields" style="display: none; background: #f8faff; border-left: 4px solid #0d6efd; border-radius: 8px;" class="p-3 mb-4 shadow-sm">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-store me-2"></i>Seller Details</h6>
                            
                            <div class="mb-3">
                                <label for="seller_type" class="form-label text-dark">What type of seller are you?</label>
                                <select id="seller_type" class="form-select" name="seller_type" onchange="toggleShopName(this.value)">
                                    <option value="">-- Select Type --</option>
                                    <option value="book_fair">🎪 Book Fair Agent</option>
                                    <option value="book_store">🏪 Book Store Owner</option>
                                </select>
                            </div>
                            
                            <div class="mb-2" id="shop_name_div" style="display: none;">
                                <label for="shop_name" class="form-label text-dark">Store/Shop Name <span class="text-danger">*</span></label>
                                <input id="shop_name" type="text" class="form-control" name="shop_name" placeholder="e.g. Sharma Book Depot">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label fw-bold">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password">
                            </div>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                {{ __('Create My Account') }} <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign In here</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSellerFields(role) {
        const sellerFields = document.getElementById('seller_fields');
        const sellerTypeSelect = document.getElementById('seller_type');
        
        if (role === 'seller') {
            // Add a little slide-down animation effect
            sellerFields.style.display = 'block';
            sellerFields.style.animation = 'fadeIn 0.4s ease-in-out';
            sellerTypeSelect.required = true;
        } else {
            sellerFields.style.display = 'none';
            sellerTypeSelect.required = false;
            sellerTypeSelect.value = ''; // Reset
            toggleShopName(''); // Reset shop name
        }
    }

    function toggleShopName(type) {
        const shopDiv = document.getElementById('shop_name_div');
        const shopInput = document.getElementById('shop_name');
        
        if (type === 'book_store') {
            shopDiv.style.display = 'block';
            shopInput.required = true;
        } else {
            shopDiv.style.display = 'none';
            shopInput.required = false;
            shopInput.value = ''; // Reset
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endsection