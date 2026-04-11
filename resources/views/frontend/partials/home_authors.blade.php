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
                         <button class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute m-2 top-0 end-0 toggle-wishlist z-index-10" 
        data-id="{{ $book->id }}" 
        style="width: 35px; height: 35px; z-index: 10;">
    <i class="{{ in_array($book->id, $wishlistIds ?? []) ? 'fas text-danger' : 'far text-secondary' }} fa-heart wishlist-icon-{{ $book->id }}"></i>
</button>
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