
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
                         <button class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute m-2 top-0 end-0 toggle-wishlist z-index-10" 
        data-id="{{ $book->id }}" 
        style="width: 35px; height: 35px; z-index: 10;">
    <i class="{{ in_array($book->id, $wishlistIds ?? []) ? 'fas text-danger' : 'far text-secondary' }} fa-heart wishlist-icon-{{ $book->id }}"></i>
</button>
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
                         <button class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute m-2 top-0 end-0 toggle-wishlist z-index-10" 
        data-id="{{ $book->id }}" 
        style="width: 35px; height: 35px; z-index: 10;">
    <i class="{{ in_array($book->id, $wishlistIds ?? []) ? 'fas text-danger' : 'far text-secondary' }} fa-heart wishlist-icon-{{ $book->id }}"></i>
</button>
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
