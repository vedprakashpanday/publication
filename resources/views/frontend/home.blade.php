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
                <h2 class="mb-0">New Arrivals</h2>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All</a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($newArrivals as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration == 4 ? 'd-none d-md-block' : '' }}">
                <div class="book-card">
                    @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="{{ $book->title }}">
                    
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="book-price">₹{{ $book->price }}</span>
                            <button class="btn btn-accent btn-sm rounded-circle shadow-sm" title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('shop') }}" class="btn btn-outline-dark rounded-pill px-4 w-100">View All Arrivals</a>
        </div>
    </div>
</section>

<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5 text-center text-lg-start">
                <span class="badge bg-warning text-dark mb-2 px-3 py-2 rounded-pill fw-bold">Divyansh Originals</span>
                <h2 class="display-5 fw-bold text-white mb-3 mt-2">Only on Divyansh</h2>
                <p class="text-light opacity-75 mb-4 px-3 px-lg-0">Discover literary gems published exclusively by us. Unedited, unfiltered, and deeply original content that you won't find anywhere else.</p>
                <a href="{{ route('shop') }}" class="btn btn-accent rounded-pill px-4 py-2">View Exclusive Collection</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3 justify-content-center">
                    @foreach($exclusiveBooks as $book)
                    <div class="col-5 col-md-4 {{ $loop->iteration == 3 ? 'd-none d-md-block' : '' }}">
                        <div class="book-card border-0 bg-transparent text-white text-center" style="box-shadow: none;">
                            @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                            <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?q=80&w=400&auto=format&fit=crop' }}" class="book-cover rounded-3 shadow-lg mb-2" alt="{{ $book->title }}" style="border: 2px solid #334155;">
                            <h3 class="book-title text-white fs-6 mb-0">{{ $book->title }}</h3>
                            <span class="text-warning fw-bold small">₹{{ $book->price }}</span>
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
        <div class="text-center mb-5">
            <span class="text-uppercase fw-bold small text-muted letter-spacing">Master Wordsmiths</span>
            <h2 class="mb-0">Meet Our Top Authors</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($topAuthors as $author)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="author-circle-wrapper">
                    <img src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop' }}" class="rounded-circle author-img mb-3" alt="{{ $author->name }}">
                    <h5 class="fw-bold fs-6 text-dark mb-0">{{ $author->name }}</h5>
                    <small class="text-muted">Author</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-uppercase fw-bold small text-muted letter-spacing">Curated Collection</span>
            <h2 class="mb-0">Books by Top Authors</h2>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($booksByTopAuthors as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration == 4 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm">
                    <span class="badge bg-dark position-absolute m-2">By {{ explode(' ', trim($book->author->name ?? 'Unknown'))[0] }}</span>
                    @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="{{ $book->title }}">
                    <div class="p-3">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="book-price">₹{{ $book->price }}</span>
                            <button class="btn btn-outline-primary btn-sm rounded-circle"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase fw-bold small text-muted letter-spacing">5-Star Favorites</span>
                <h2 class="mb-0">Top Rated Books</h2>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($topRatedBooks as $book)
            <div class="col-6 col-md-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm bg-light text-center p-2">
                    @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" class="book-cover rounded-3 mb-2" alt="{{ $book->title }}">
                    
                    <div class="text-warning small mb-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        @if($loop->iteration % 2 == 0) <i class="fas fa-star"></i> @else <i class="fas fa-star-half-alt"></i> @endif
                    </div>
                    
                    <h3 class="book-title fs-6">{{ $book->title }}</h3>
                    <span class="book-price d-block mt-2">₹{{ $book->price }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Trending Now</span>
                <h2 class="mb-0">Most Read Publications</h2>
            </div>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($trendingBooks as $book)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm">
                    <div class="position-absolute bg-danger text-white small px-2 py-1 m-2 rounded shadow-sm"><i class="fas fa-fire me-1"></i> Trending</div>
                    @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="{{ $book->title }}">
                    <div class="p-3">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $loop->iteration == 1 ? 'Thousands reading now' : 'Highly Demanded' }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="book-price">₹{{ $book->price }}</span>
                            <button class="btn btn-accent btn-sm rounded-circle"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection