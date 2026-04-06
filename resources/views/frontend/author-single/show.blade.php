@extends('layouts.frontend')
@section('title', $author->name . ' | Divyansh Publication')

@section('content')
<div class="page-header py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('authors.index') }}" class="text-decoration-none text-muted">Authors</a></li>
                <li class="breadcrumb-item active text-accent fw-bold">{{ $author->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4 py-lg-5">
    <div class="row g-4">
        <div class="d-lg-none mb-3">
            <button class="btn btn-dark rounded-pill w-100 py-2 fw-bold" data-bs-toggle="offcanvas" data-bs-target="#mobileFilter">
                <i class="fas fa-sliders-h me-2"></i> Filter Books
            </button>
        </div>

        <div class="col-lg-3 d-none d-lg-block">
    <div class="sticky-top" style="top: 100px;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 font-playfair">Refine Books</h5>
            
            <form action="{{ route('authors.show', $author->id) }}" method="GET">
                @include('frontend.partials.shop-filters')
            </form>
            
        </div>
    </div>
</div>

        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4 text-center p-4 bg-light">
                        <img src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop' }}" 
                             class="rounded-circle shadow-lg border border-4 border-white" 
                             style="width: 180px; height: 180px; object-fit: cover;" alt="{{ $author->name }}">
                    </div>
                    <div class="col-md-8 p-4">
                        <h1 class="display-6 fw-bold font-playfair text-dark mb-2">{{ $author->name }}</h1>
                        <div class="text-muted small mb-3">
                            <span class="me-3"><i class="fas fa-birthday-cake me-2 text-accent"></i> Born: {{ $author->born ?? 'N/A' }}</span>
                            @if($author->death)
                            <span><i class="fas fa-dove me-2 text-muted"></i> Died: {{ $author->death }}</span>
                            @endif
                        </div>
                        <p class="text-secondary">{{ $author->description ?? 'No biography available for this author.' }}</p>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold font-playfair mb-4">Books by {{ $author->name }}</h4>
            <div class="row g-3 g-md-4">
               @foreach($books as $book)
                <div class="col-6 col-md-4">
                    <div class="book-card border-0 shadow-sm h-100 position-relative">
                        @if($book->stock_status == 'out_of_stock')
                            <div class="position-absolute bg-dark text-white small px-2 py-1 m-2 rounded" style="z-index: 2; opacity: 0.8;">Out of Stock</div>
                        @endif
                        
                        <a href="{{ route('book.show', $book->id) }}">
                            @php $frontImg = $book->images->where('image_type', 'front')->first(); @endphp
                            <img src="{{ $frontImg ? asset('storage/'.$frontImg->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" 
                                 class="book-cover w-100 {{ $book->stock_status == 'out_of_stock' ? 'grayscale' : '' }}" alt="{{ $book->title }}">
                        </a>
                        
                        <div class="p-3">
                            <h3 class="book-title fs-6 fw-bold mb-1">{{ $book->title }}</h3>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="book-price text-accent fw-bold">₹{{ $book->price }}</span>
                                
                                <button type="button" 
                                        class="btn btn-accent btn-sm rounded-circle add-to-cart-home {{ $book->stock_status == 'out_of_stock' ? 'disabled' : '' }}" 
                                        data-id="{{ $book->id }}"
                                        style="width: 35px; height: 35px;">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-bottom rounded-top-4" tabindex="-1" id="mobileFilter" style="height: 80vh; z-index: 9999;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold font-playfair">Filter Books</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    
    <div class="offcanvas-body">
    <form action="{{ route('authors.show', $author->id) }}" method="GET">
        @include('frontend.partials.shop-filters')
    </form>
</div>
</div>
@endsection


@push('scripts')    

<script>
$(document).ready(function() {
   $(document).on('click', '.add-to-cart-home', function(e) {
   
    
        e.preventDefault();
        let bookId = $(this).data('id');
        let btn = $(this);
        
        btn.html('<i class="fas fa-spinner fa-spin"></i>'); // Loading state

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                book_id: bookId,
                quantity: 1
            },
            success: function(response) {
                btn.html('<i class="fas fa-check"></i>');
                setTimeout(() => btn.html('<i class="fas fa-cart-plus"></i>'), 2000);

                // Global Count Update
               if (typeof window.updateCartUI === 'function') {
            window.updateCartUI(response); 
        }

                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Added to your bag!',
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#1e293b',
                    color: '#fff'
                });
            }
        });
    });
});
</script>

@endpush