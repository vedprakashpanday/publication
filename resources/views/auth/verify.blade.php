@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg text-center" style="border-radius: 20px;">
                <div class="card-body p-5">
                    
                    <div class="d-inline-block bg-primary text-white rounded-circle p-4 mb-4 shadow-sm">
                        <i class="fas fa-envelope-open-text fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">{{ __('Verify Your Email') }}</h3>

                    @if (session('resent'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 text-start" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4" style="font-size: 1.05rem;">
                        {{ __('Before proceeding, please check your email for a verification link.') }}<br>
                        {{ __('If you did not receive the email, you can request another one below.') }}
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-lg rounded-pill fw-bold px-4 shadow-sm w-100 transition-all">
                            <i class="fas fa-paper-plane me-2"></i> {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2) !important;
    }
</style>
@endsection