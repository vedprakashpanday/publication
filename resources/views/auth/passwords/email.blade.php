@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg text-center" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="d-inline-block bg-primary text-white rounded-circle p-4 mb-4 shadow-sm">
                        <i class="fas fa-unlock-alt fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">{{ __('Forgot Password?') }}</h3>
                    <p class="text-muted mb-4 px-3" style="font-size: 1rem;">
                        {{ __("No worries! Enter your email address below and we'll send you a link to reset your password.") }}
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 text-start" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="text-start">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control form-control-lg border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            </div>
                            @error('email')
                                <span class="text-danger small fw-bold mt-1 d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm transition-all">
                                <i class="fas fa-paper-plane me-2"></i> {{ __('Send Reset Link') }}
                            </button>
                        </div>
                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted fw-bold transition-all hover-primary">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Login') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    .input-group:focus-within {
        border-radius: 0.5rem;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    .input-group-text, .form-control {
        border-color: #dee2e6;
    }
    .input-group:focus-within .input-group-text, 
    .input-group:focus-within .form-control {
        border-color: #0d6efd;
    }
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2) !important;
    }
    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>
@endsection