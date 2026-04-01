@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-block bg-primary text-white rounded-circle p-3 mb-3 shadow-sm">
                            <i class="fas fa-sign-in-alt fs-3"></i>
                        </div>
                        <h2 class="fw-bold text-dark">Welcome Back</h2>
                        <p class="text-muted">Please sign in to your account.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
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

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control form-control-lg border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="text-danger small fw-bold mt-1 d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Keep me signed in') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                {{ __('Sign In') }} <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center mt-3 pt-3 border-top">
                            <p class="text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Sign up now</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #ced4da; /* keep border color same to match input group */
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
</style>
@endsection