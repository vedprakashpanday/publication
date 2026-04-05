@extends('layouts.frontend')
@section('title', $book->title . ' | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       BOOK DETAILS SPECIFIC STYLES
       ========================================= */
    .breadcrumb-item a { color: #64748b; text-decoration: none; font-size: 0.9rem; }
    .breadcrumb-item.active { color: var(--accent-color); font-weight: 500; font-size: 0.9rem; }
    
    .book-image-container {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        position: sticky;
        top: 100px;
    }
    
    .book-main-cover {
        max-width: 100%;
        height: auto;
        box-shadow: -15px 15px 30px rgba(0,0,0,0.15); 
        border-radius: 4px 10px 10px 4px;
    }

    /* Wishlist Floating Button */
    .btn-wishlist-float {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        width: 45px; 
        height: 45px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.2rem; 
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        z-index: 10;
    }
    .btn-wishlist-float:hover, .btn-wishlist-float.active { 
        border-color: #ef4444; color: #ef4444; background: #fef2f2; 
    }

    .book-title-large {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        font-size: 2.5rem;
        color: var(--primary-color);
        line-height: 1.2;
    }

    .author-link { color: var(--accent-color); text-decoration: none; font-weight: 600; font-size: 1.1rem; }
    .author-link:hover { text-decoration: underline; }

    .price-tag { font-size: 2.2rem; font-weight: 700; color: var(--primary-color); line-height: 1; }
    .mrp-tag { font-size: 1.2rem; color: #94a3b8; text-decoration: line-through; margin-left: 10px; }
    .discount-badge { font-size: 0.85rem; background-color: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; margin-left: 10px; vertical-align: text-bottom; }

    /* Format Selection Boxes */
    .format-box {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 20px;
        cursor: pointer;
        transition: 0.3s;
    }
    .format-box.active, .format-box:hover {
        border-color: var(--accent-color);
        background-color: #fffbeb;
    }

    /* Quantity & Cart Action */
    .action-buttons { gap: 20px !important; }
    .qty-group { width: 130px; height: 50px; }
    .qty-input { text-align: center; font-weight: bold; border: 1px solid #cbd5e1; border-left: 0; border-right: 0; padding: 0; }
    .qty-btn { background: #fff; border: 1px solid #cbd5e1; padding: 0 15px; color: #475569; font-weight: bold; transition: 0.2s; }
    .qty-btn:hover { background: #f1f5f9; }
    
    .btn-add-to-cart {
        background-color: var(--accent-color);
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0 30px;
        border-radius: 50px;
        transition: 0.3s;
        border: none;
        height: 50px;
        max-width: 250px;
    }
    .btn-add-to-cart:hover { background-color: #b45309; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(217, 119, 6, 0.3); color: white;}

    /* Info List */
    .book-meta-list { list-style: none; padding: 0; margin: 0; }
    .book-meta-list li { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed #e2e8f0; font-size: 0.95rem; }
    .book-meta-list li:last-child { border-bottom: none; }
    .meta-label { color: #64748b; }
    .meta-value { font-weight: 600; color: var(--primary-color); text-align: right;}

    /* Custom Elegant Tabs */
    .custom-tabs { border-bottom: 2px solid #e2e8f0; gap: 20px; flex-wrap: nowrap; overflow-x: auto; white-space: nowrap; padding-bottom: 5px;}
    .custom-tabs::-webkit-scrollbar { display: none; }
    .custom-tabs .nav-link { border: none; color: #64748b; font-weight: 600; font-size: 1.1rem; padding: 10px 0; border-bottom: 3px solid transparent; background: transparent; }
    .custom-tabs .nav-link.active { color: var(--primary-color); border-bottom-color: var(--accent-color); }
    
    /* Related Book Card */
    .book-card { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff; transition: 0.3s; display: flex; flex-direction: column; height: 100%; }
    .book-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08); transform: translateY(-5px); }
    .book-cover { width: 100%; aspect-ratio: 2/3; object-fit: cover; border-bottom: 1px solid #f1f5f9; }
    .book-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.1rem; color: var(--primary-color); margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS
       ========================================= */
    @media (max-width: 768px) {
        .book-image-container { 
            position: relative; 
            top: 0; 
            padding: 15px 0;
            border: none;    
            background: transparent;
            margin-bottom: 10px; 
        }
        .btn-wishlist-float { right: 15px; top: 15px; } 
        
        .book-title-large { font-size: 1.6rem; }
        .price-tag { font-size: 1.8rem; }
        
        .action-buttons { 
            display: flex; 
            flex-direction: row !important; 
            gap: 15px !important; 
            padding: 15px 0 !important;
        }
        .qty-group { width: 110px; height: 48px; flex-shrink: 0; }
        
        .btn-add-to-cart { 
            height: 48px; 
            padding: 0; 
            font-size: 1rem;
            max-width: 100%; 
            flex-grow: 1;
        }
        
        .format-box { padding: 10px; }
        .custom-tabs .nav-link { font-size: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="bg-white border-bottom py-2 py-md-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}?categories[]={{ $book->category_id }}">{{ $book->category->name ?? 'Books' }}</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 150px;">{{ $book->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4 py-md-5">
    <div class="container">
        <div class="row g-4 g-lg-5">
            
            <div class="col-lg-4 col-md-5">
                <div class="book-image-container position-relative">
                    <button class="btn-wishlist-float" title="Add to Wishlist" onclick="this.classList.toggle('active'); this.querySelector('i').classList.toggle('fas'); this.querySelector('i').classList.toggle('far');">
                        <i class="far fa-heart"></i>
                    </button>

                    @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                    <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=800&auto=format&fit=crop' }}" class="book-main-cover img-fluid" alt="{{ $book->title }}">
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                
                <div class="mb-3 mt-2 mt-md-0">
                    @if($book->quantity > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 small mb-2"><i class="fas fa-check-circle me-1"></i> In Stock</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 small mb-2"><i class="fas fa-times-circle me-1"></i> Out of Stock</span>
                    @endif
                    
                    <h1 class="book-title-large">{{ $book->title }}</h1>
                    <div class="mt-2 text-muted fs-6">
                        By <a href="{{ route('shop') }}?authors[]={{ $book->author_id }}" class="author-link">{{ $book->author->name ?? 'Unknown Author' }}</a>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="text-warning me-2 fs-6">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-muted fw-bold small">4.8</span>
                    <span class="text-muted ms-2 small">(124 Reviews)</span>
                </div>

                <div class="mb-4 d-flex align-items-end flex-wrap gap-2">
                    <span class="price-tag">₹{{ $book->price }}</span>
                    @if($book->mrp > $book->price)
                        <span class="mrp-tag mb-1">₹{{ $book->mrp }}</span>
                        @php $discount = round((($book->mrp - $book->price) / $book->mrp) * 100); @endphp
                        <span class="discount-badge mb-2">Save {{ $discount }}%</span>
                    @endif
                    <div class="w-100 mt-1 small text-success fw-bold">Inclusive of all taxes</div>
                </div>

                <div class="mb-4 text-dark opacity-75 d-none d-md-block" style="line-height: 1.8;">
                    {{ Str::limit(strip_tags($book->description), 250) }}
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-dark fs-6">Binding / Format:</h6>
                    <div class="row g-2 g-sm-3">
                        <div class="col-6 col-sm-4">
                            <div class="format-box active text-center">
                                <div class="fw-bold text-dark small">{{ $book->binding ?? 'Paperback' }}</div>
                                <div class="text-accent fw-bold mt-1">₹{{ $book->price }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    
                    <div class="d-flex align-items-center gap-3 action-buttons py-3 border-top border-bottom mb-4">
                        <div class="d-flex qty-group">
                            <button type="button" class="btn qty-btn rounded-start" onclick="updateQty(-1)"><i class="fas fa-minus small"></i></button>
                            <input type="number" name="quantity" id="qtyInput" class="form-control qty-input h-100" value="1" min="1" max="{{ $book->quantity > 10 ? 10 : $book->quantity }}" readonly>
                            <button type="button" class="btn qty-btn rounded-end" onclick="updateQty(1)"><i class="fas fa-plus small"></i></button>
                        </div>

                        <button type="submit" class="btn btn-add-to-cart d-flex align-items-center justify-content-center gap-2" {{ $book->quantity < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-bag"></i> {{ $book->quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </div>
                </form>

                <div class="d-flex gap-3 gap-md-4 text-muted small mt-2">
                    <div><i class="fas fa-shield-alt text-success me-1"></i> Secure Checkout</div>
                    <div><i class="fas fa-undo text-primary me-1"></i> 7 Days Return</div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="py-4 py-md-5 bg-white border-top">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <ul class="nav custom-tabs mb-4" id="bookTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Synopsis</button>
                    </li>
                    @if($book->author)
                    <li class="nav-item">
                        <button class="nav-link" id="author-tab" data-bs-toggle="tab" data-bs-target="#author" type="button" role="tab">About Author</button>
                    </li>
                    @endif
                </ul>

                <div class="tab-content text-dark opacity-75" style="line-height: 1.8;" id="bookTabsContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        {!! nl2br(e($book->description)) !!}
                    </div>

                    @if($book->author)
                    <div class="tab-pane fade" id="author" role="tabpanel">
                        <div class="d-flex flex-column flex-md-row gap-4 align-items-center align-items-md-start text-center text-md-start">
                            <img src="{{ $book->author->profile_image ? asset('storage/'.$book->author->profile_image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop' }}" class="rounded-circle shadow-sm flex-shrink-0" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $book->author->name }}">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $book->author->name }}</h5>
                                <p class="small text-accent fw-bold mb-2">Author</p>
                                <p class="mb-0">{{ $book->author->about ?? 'No author bio available yet.' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-light p-4 rounded-4 border border-light-subtle">
                    <h5 class="fw-bold font-playfair mb-3 text-dark">Product Details</h5>
                    <ul class="book-meta-list">
                        <li><span class="meta-label">Publisher</span> <span class="meta-value text-end">{{ $book->publisher->name ?? 'Divyansh Pub.' }}</span></li>
                        <li><span class="meta-label">Language</span> <span class="meta-value text-end">{{ $book->language ?? 'English' }}</span></li>
                        <li><span class="meta-label">Pages</span> <span class="meta-value text-end">{{ $book->pages ?? 'N/A' }} Pages</span></li>
                        <li><span class="meta-label">ISBN-13</span> <span class="meta-value text-end">{{ $book->isbn_13 ?? 'N/A' }}</span></li>
                        @if($book->edition)
                        <li><span class="meta-label">Edition</span> <span class="meta-value text-end">{{ $book->edition }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedBooks->count() > 0)
<section class="py-5 bg-light border-top">
    <div class="container">
        <h3 class="fw-bold font-playfair mb-4 text-dark text-center text-md-start">You might also like</h3>
        
        <div class="row g-3 g-md-4">
            @foreach($relatedBooks as $relatedBook)
            <div class="col-6 col-md-4 col-lg-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm">
                    <a href="{{ route('book.show', $relatedBook->id) }}" class="text-decoration-none text-dark">
                        @php $relFrontImg = $relatedBook->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $relFrontImg ? asset('storage/'.$relFrontImg->image_path) : 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="{{ $relatedBook->title }}">
                        <div class="p-3">
                            <h3 class="book-title fs-6">{{ $relatedBook->title }}</h3>
                            <p class="book-author mb-1 small">{{ $relatedBook->author->name ?? 'Unknown' }}</p>
                            <span class="book-price fs-6">₹{{ $relatedBook->price }}</span>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@section('scripts')
<script>
    function updateQty(change) {
        let input = document.getElementById('qtyInput');
        let currentVal = parseInt(input.value);
        let maxQty = parseInt(input.getAttribute('max'));
        let newVal = currentVal + change;
        
        if(newVal >= 1 && newVal <= maxQty) { 
            input.value = newVal;
        }
    }

    // Optional: Format change script (if you add multiple bindings in future)
    function changeFormat(element) {
        let boxes = document.querySelectorAll('.format-box');
        boxes.forEach(box => box.classList.remove('active'));
        element.classList.add('active');
    }
</script>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
    $('#addToCartForm').on('submit', function(e) {
        e.preventDefault(); // <-- Ye browser ko 'book/2' par jaane se rokega

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                if(response.status === 'success') {
                    alert("Book added to cart!");
                    // Cart count update karne ke liye (agar header me class hai)
                    $('.cart-count-badge').text(response.cart_count);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Error adding to cart. Check console.");
            }
        });
    });
});
    </script>
@endpush