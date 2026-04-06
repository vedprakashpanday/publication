@extends('layouts.frontend') 
@section('title', 'Divyansh Publication | Home')

@section('styles')
<style>
    /* =========================================
       HERO SLIDER STYLES
       ========================================= */
    .hero-slider .carousel-inner { border-radius: 0; }
    .hero-slider .carousel-item img {
        width: 100%;
        object-fit: cover;
        height: 450px; /* Desktop Height */
    }
    .carousel-caption {
        background: rgba(15, 23, 42, 0.6);
        padding: 20px;
        border-radius: 15px;
        backdrop-filter: blur(5px);
        bottom: 20%;
    }

    .book-card:hover .book-cover {
    border-color: var(--accent-color) !important;
    transform: scale(1.03);
    box-shadow: 0 15px 30px rgba(0,0,0,0.4);
}

    /* =========================================
       BOOK CARDS (Premium UI)
       ========================================= */
    .book-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .book-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }
    .book-cover {
        width: 100%;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        border-bottom: 1px solid #f1f5f9;
    }
    .book-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary-color);
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .book-author { font-size: 0.85rem; color: #64748b; margin-bottom: 10px; }
    .book-price { font-weight: 600; color: var(--accent-color); font-size: 1.1rem; }
    
    /* Trust Badges */
    .trust-section { background-color: #fff; border-bottom: 1px solid #f1f5f9; }
    .trust-icon { font-size: 1.8rem; color: var(--accent-color); margin-bottom: 10px; }

    /* Author Circles */
    .author-circle-wrapper {
        text-align: center;
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    .author-circle-wrapper:hover { transform: translateY(-5px); }
    .author-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS
       ========================================= */
    @media (max-width: 768px) {
        .hero-slider .carousel-item img { height: 220px; }
        .carousel-caption { padding: 10px; bottom: 10%; width: 80%; left: 10%; }
        .carousel-caption h2 { font-size: 1.2rem; }
        .carousel-caption p { font-size: 0.8rem; margin-bottom: 0; }
        
        .book-title { font-size: 0.95rem; }
        .book-price { font-size: 1rem; }
        .btn-add-cart { padding: 5px 10px; font-size: 0.8rem; }
        
        .author-img { width: 90px; height: 90px; }
    }
</style>
@endsection

@section('content')

<div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop" alt="New Arrivals">
            <div class="carousel-caption d-none d-md-block">
                <h2>Bestselling Literature</h2>
                <p>Discover the stories everyone is talking about this month.</p>
                <a href="{{ route('shop') }}" class="btn btn-accent mt-2">Shop Now</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=2000&auto=format&fit=crop" alt="Poetry Collection">
            <div class="carousel-caption">
                <h2>Soulful Poetry & Ghazals</h2>
                <p>Immerse yourself in our finest collection of classical words.</p>
            </div>
        </div>
    </div>
</div>

<section class="trust-section py-4 d-none d-md-block shadow-sm">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <i class="fas fa-truck trust-icon"></i>
                <h6 class="fw-bold mb-0">Fast Delivery</h6>
                <small class="text-muted">Across All India</small>
            </div>
            <div class="col-md-3">
                <i class="fas fa-shield-alt trust-icon"></i>
                <h6 class="fw-bold mb-0">Secure Payments</h6>
                <small class="text-muted">100% Safe Checkout</small>
            </div>
            <div class="col-md-3">
                <i class="fas fa-book trust-icon"></i>
                <h6 class="fw-bold mb-0">Original Prints</h6>
                <small class="text-muted">Direct from Publisher</small>
            </div>
            <div class="col-md-3">
                <i class="fas fa-headset trust-icon"></i>
                <h6 class="fw-bold mb-0">24/7 Support</h6>
                <small class="text-muted">Dedicated Helpdesk</small>
            </div>
        </div>
    </div>
</section>

<section class="py-5 mt-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Fresh off the press</span>
                <h2 class="mb-0 font-playfair fw-bold">New Arrivals</h2>
            </div>
            <a href="{{ route('shop', ['filter' => 'new-arrivals']) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All</a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($newArrivals as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration == 4 ? 'd-none d-md-block' : '' }}">
                <div class="book-card h-100 shadow-sm border rounded-3 overflow-hidden">
                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}">
                        @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" class="book-cover w-100" alt="{{ $book->title }}" style="aspect-ratio: 2/3; object-fit: cover;">
                    </a>
                    
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="text-decoration-none">
                            <h3 class="book-title text-dark fs-6 fw-bold mb-1">{{ $book->title }}</h3>
                        </a>
                        <p class="book-author small text-muted mb-3">{{ $book->author->name ?? 'Unknown Author' }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="book-price fw-bold text-accent">₹{{ $book->price }}</span>
                            <button type="button" class="btn btn-accent btn-sm rounded-circle shadow-sm add-to-cart-home" 
                                    data-id="{{ $book->id }}" 
                                    title="Add to Cart" 
                                    style="width: 35px; height: 35px;">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('shop', ['filter' => 'new-arrivals']) }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">View All Arrivals</a>
        </div>
    </div>
</section>


<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5 text-center text-lg-start">
                <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Divyansh Originals</span>
                <h2 class="display-5 fw-bold text-white mb-3 mt-2 font-playfair">Only on Divyansh</h2>
                <p class="text-light opacity-75 mb-4 px-3 px-lg-0">Discover literary gems published exclusively by us. Unedited, unfiltered, and deeply original content that you won't find anywhere else.</p>
                
                <a href="{{ route('shop', ['filter' => 'exclusive']) }}" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold">
                    View Exclusive Collection <i class="fas fa-arrow-right ms-2 small"></i>
                </a>
            </div>

            <div class="col-lg-7">
                <div class="row g-3 justify-content-center">
                    @foreach($exclusiveBooks as $book)
                    <div class="col-5 col-md-4 {{ $loop->iteration == 3 ? 'd-none d-md-block' : '' }}">
                        <div class="book-card border-0 bg-transparent text-white text-center position-relative" style="box-shadow: none;">
                            
                            <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="d-block mb-2">
                                @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                                <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?q=80&w=400&auto=format&fit=crop' }}" 
                                     class="book-cover rounded-3 shadow-lg w-100" 
                                     alt="{{ $book->title }}" 
                                     style="border: 2px solid #334155; aspect-ratio: 2/3; object-fit: cover; transition: 0.3s;">
                            </a>

                            <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="text-decoration-none">
                                <h3 class="book-title text-white fs-6 mb-1 text-truncate">{{ $book->title }}</h3>
                            </a>

                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="text-warning fw-bold small">₹{{ $book->price }}</span>
                                
                                <button type="button" 
                                        class="btn btn-sm p-0 text-white border-0 add-to-cart-home" 
                                        data-id="{{ $book->id }}" 
                                        style="background: transparent;"
                                        title="Quick Add">
                                    <i class="fas fa-plus-circle text-accent fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div class="text-center text-md-start">
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Master Wordsmiths</span>
                <h2 class="mb-0 font-playfair fw-bold">Meet Our Top Authors</h2>
            </div>
            <a href="{{ route('authors.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All Authors</a>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($topAuthors as $author)
            <div class="col-6 col-md-3 col-lg-2 text-center">
                <a href="{{ route('authors.show', $author->id) }}" class="text-decoration-none author-circle-wrapper d-block">
                    <img src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop' }}" 
                         class="rounded-circle author-img mb-3 shadow-sm border border-2" alt="{{ $author->name }}"
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <h5 class="fw-bold fs-6 text-dark mb-0">{{ $author->name }}</h5>
                    <small class="text-muted">{{ $author->books_count ?? '0' }} Books</small>
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('authors.index') }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">Explore All Authors</a>
        </div>
    </div>
</section>


<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div class="text-center text-md-start w-100">
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Curated Collection</span>
                <h2 class="mb-0 font-playfair fw-bold">Books by Top Authors</h2>
            </div>
            <a href="{{ route('shop', ['filter' => 'top-authors']) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All</a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($booksByTopAuthors as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration == 4 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm h-100">
                    <span class="badge bg-dark position-absolute m-2" style="z-index: 2;">By {{ explode(' ', trim($book->author->name ?? 'Unknown'))[0] }}</span>
                    
                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="d-block">
                        @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop' }}" 
                             class="book-cover w-100" 
                             alt="{{ $book->title }}"
                             style="aspect-ratio: 2/3; object-fit: cover;">
                    </a>

                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="text-decoration-none">
                            <h3 class="book-title text-dark fs-6 fw-bold mb-1">{{ $book->title }}</h3>
                        </a>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center mt-3">
                            <span class="book-price fw-bold text-accent">₹{{ $book->price }}</span>
                            
                            <button type="button" 
                                    class="btn btn-accent btn-sm rounded-circle shadow-sm add-to-cart-home" 
                                    data-id="{{ $book->id }}" 
                                    title="Add to Cart"
                                    style="width: 35px; height: 35px;">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('shop', ['filter' => 'top-authors']) }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">View All by Top Authors</a>
        </div>
    </div>
</section>
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase fw-bold small text-muted letter-spacing">5-Star Favorites</span>
                <h2 class="mb-0 font-playfair fw-bold">Top Rated Books</h2>
            </div>
            <a href="{{ route('shop', ['filter' => 'top-rated']) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All</a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($topRatedBooks as $book)
            <div class="col-6 col-md-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm bg-light text-center p-3 h-100 d-flex flex-column">
                    
                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="d-block mb-2">
                        @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" 
                             class="book-cover rounded-3 mb-2 w-100" 
                             alt="{{ $book->title }}"
                             style="aspect-ratio: 2/3; object-fit: cover;">
                    </a>
                    
                    <div class="text-warning small mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        @if($loop->iteration % 2 == 0) <i class="fas fa-star"></i> @else <i class="fas fa-star-half-alt"></i> @endif
                    </div>
                    
                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="text-decoration-none">
                        <h3 class="book-title fs-6 text-dark fw-bold mb-2">{{ $book->title }}</h3>
                    </a>

                    <div class="mt-auto">
                        <span class="book-price d-block mb-2 fw-bold text-accent">₹{{ $book->price }}</span>
                        
                        <button type="button" 
                                class="btn btn-dark btn-sm rounded-pill px-3 fw-bold add-to-cart-home w-100" 
                                data-id="{{ $book->id }}"
                                style="font-size: 0.75rem;">
                            <i class="fas fa-cart-plus me-1"></i> Add to Bag
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('shop', ['filter' => 'top-rated']) }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">View All 5-Star Favorites</a>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Trending Now</span>
                <h2 class="mb-0 font-playfair fw-bold">Most Read Publications</h2>
            </div>
            <a href="{{ route('shop', ['filter' => 'trending']) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All</a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($trendingBooks as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm h-100 d-flex flex-column">
                    <div class="position-absolute bg-danger text-white small px-2 py-1 m-2 rounded shadow-sm" style="z-index: 2;">
                        <i class="fas fa-fire me-1"></i> Trending
                    </div>
                    
                    <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="d-block">
                        @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=600&auto=format&fit=crop' }}" 
                             class="book-cover w-100" 
                             alt="{{ $book->title }}"
                             style="aspect-ratio: 2/3; object-fit: cover;">
                    </a>

                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <a href="{{ route('book.show', $book->slug ?? $book->id) }}" class="text-decoration-none">
                            <h3 class="book-title text-dark fs-6 fw-bold mb-1">{{ $book->title }}</h3>
                        </a>
                        <p class="book-author small text-muted mb-3">{{ $loop->iteration == 1 ? 'Thousands reading now' : 'Highly Demanded' }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="book-price fw-bold text-accent">₹{{ $book->price }}</span>
                            
                            <button type="button" 
                                    class="btn btn-accent btn-sm rounded-circle shadow-sm add-to-cart-home" 
                                    data-id="{{ $book->id }}" 
                                    title="Add to Cart"
                                    style="width: 35px; height: 35px;">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('shop', ['filter' => 'trending']) }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">Explore All Trending</a>
        </div>
    </div>
</section>

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