@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-block bg-primary text-white rounded-circle p-3 mb-3 shadow-sm">
                            <i class="fas fa-key fs-3"></i>
                        </div>
                        <h2 class="fw-bold text-dark">Reset Password</h2>
                        <p class="text-muted">Enter your new secure password below.</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control form-control-lg border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="text-danger small fw-bold mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">{{ __('New Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="text-danger small fw-bold mt-1 d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">{{ __('Confirm New Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-double text-muted"></i></span>
                                <input id="password-confirm" type="password" class="form-control form-control-lg border-start-0 ps-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm transition-all">
                                {{ __('Update Password') }} <i class="fas fa-sync-alt ms-2"></i>
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
        border-color: #dee2e6;
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
</style>
@endsection