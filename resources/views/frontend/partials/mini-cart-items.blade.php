@php 
    $cart = session('cart', []); 
    $miniSubtotal = 0;
@endphp

<div class="mini-cart-content" id="miniCartUpdate">
    <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold font-playfair text-dark">Your Bag</h6>
        <span class="badge bg-secondary rounded-pill"><span class="count-sync">{{ count($cart) }}</span> items</span>
    </div>
    
    <div class="mini-cart-items p-2">
        @forelse($cart as $id => $details)
            @php $miniSubtotal += $details['price'] * $details['quantity']; @endphp
            <div class="d-flex align-items-center p-2 border-bottom mini-cart-item">
                <img src="{{ $details['image'] ? asset('uploads/books/covers/'.$details['image']) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=50&auto=format&fit=crop' }}" alt="" style="width: 45px; height: 65px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                <div class="ms-3 flex-grow-1">
                    <h6 class="mb-1 small fw-bold text-dark text-truncate" style="max-width: 140px;">{{ $details['title'] }}</h6>
                    <div class="text-muted" style="font-size: 0.75rem;">Qty: {{ $details['quantity'] }}</div>
                </div>
                <div class="fw-bold small text-accent">₹{{ $details['price'] * $details['quantity'] }}</div>
            </div>
        @empty
            <div class="text-center py-4 text-muted small">
                <i class="fas fa-shopping-bag fs-3 mb-2 opacity-50"></i><br>
                Looks like your bag is empty.
            </div>
        @endforelse
    </div>
    
    @if(count($cart) > 0)
    <div class="p-3 bg-light border-top">
        <div class="d-flex justify-content-between fw-bold text-dark mb-3">
            <span>Subtotal:</span>
            <span>₹{{ $miniSubtotal }}</span>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('checkout') }}" class="btn btn-accent btn-sm rounded-pill fw-bold text-dark border shadow-sm">Secure Checkout</a>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark btn-sm rounded-pill fw-bold">View Bag</a>
        </div>
    </div>
    @endif
</div>