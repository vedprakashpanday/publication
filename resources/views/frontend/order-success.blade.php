@extends('layouts.frontend')
@section('title', 'Order Placed Successfully | Divyansh Publication')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            </div>
            
            <h1 class="display-5 fw-bold font-playfair mb-3">Thank You for Your Order!</h1>
            <p class="lead text-muted mb-4">
                Your order has been placed successfully. We'll send you an email confirmation with tracking details shortly.
            </p>
            
            <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Order Number:</span>
                    <span class="fw-bold text-dark">#{{ $order_number }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Estimated Delivery:</span>
                    <span class="fw-bold text-dark">5-7 Business Days</span>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('shop') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">
                    Continue Shopping
                </a>
                <a href="#" class="btn btn-outline-dark btn-lg rounded-pill px-5 py-3 fw-bold">
                    View My Orders
                </a>
            </div>
            
            <p class="mt-5 text-muted small">
                Need help? <a href="#" class="text-accent fw-bold text-decoration-none">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection