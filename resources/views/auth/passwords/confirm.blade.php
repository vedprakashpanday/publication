@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg text-center" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="d-inline-block bg-primary text-white rounded-circle p-4 mb-4 shadow-sm">
                        <i class="fas fa-user-lock fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">{{ __('Security Check') }}</h3>

                    <p class="text-muted mb-4 px-3" style="font-size: 1rem;">
                        {{ __('Please confirm your password before continuing to this secure area.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}" class="text-start">
                        @csrf

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <label for="password" class="form-label fw-bold mb-0">{{ __('Your Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••" autofocus>
                            </div>
                            @error('password')
                                <span class="text-danger small fw-bold mt-1 d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm transition-all">
                                <i class="fas fa-shield-check me-2"></i> {{ __('Confirm Password') }}
                            </button>
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
</style>
@endsection