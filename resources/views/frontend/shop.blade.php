@extends('layouts.frontend')
@section('title', 'Shop Books | Divyansh Publication')

@section('styles')
<style>
    /* =========================================
       SHOP PAGE STYLES
       ========================================= */
    body { overflow-x: hidden; } 

    .page-header { background-color: var(--bg-light); border-bottom: 1px solid #e2e8f0; }
    
    .filter-card { border: 1px solid #e2e8f0; border-radius: 12px; background: #fff; padding: 20px; margin-bottom: 20px; }
    .filter-title { font-weight: 700; color: var(--primary-color); font-size: 1.05rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .custom-checkbox .form-check-input:checked { background-color: var(--accent-color); border-color: var(--accent-color); }
    .custom-checkbox .form-check-label { color: #475569; font-size: 0.95rem; cursor: pointer; transition: 0.2s; }
    .custom-checkbox .form-check-label:hover { color: var(--accent-color); }
    .filter-count { font-size: 0.8rem; color: #94a3b8; float: right; margin-top: 3px; }

    .price-input { border: 1px solid #cbd5e1; border-radius: 8px; padding: 5px 10px; width: 100%; text-align: center; font-weight: 600; color: var(--primary-color); }
    
    .search-box { position: relative; }
    .search-box input { padding-left: 40px; border-radius: 50px; border: 1px solid #cbd5e1; box-shadow: none; }
    .search-box input:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); }
    .search-box i { position: absolute; left: 15px; top: 12px; color: #94a3b8; }

    /* Desktop Sort Wrapper */
    .desktop-sort-wrapper { border: 2px solid #e2e8f0; border-radius: 50px; padding: 4px 15px; background-color: #f8fafc; transition: 0.3s; }
    .desktop-sort-wrapper:hover, .desktop-sort-wrapper:focus-within { border-color: var(--accent-color); background-color: #fff; }

    /* Book Card */
    .book-card { border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #fff; transition: 0.3s; display: flex; flex-direction: column; height: 100%; position: relative; }
    .book-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08); transform: translateY(-5px); }
    .book-cover { width: 100%; aspect-ratio: 2/3; object-fit: cover; border-bottom: 1px solid #f1f5f9; }
    .book-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.1rem; color: var(--primary-color); margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .book-author { font-size: 0.85rem; color: #64748b; margin-bottom: 10px; }
    .book-price { font-weight: 600; color: var(--accent-color); font-size: 1.1rem; }
    
    /* CART BUTTON UPDATE */
    .btn-cart-circle { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; background: var(--accent-color); color: white; border: none; transition: 0.3s; z-index: 2; position: relative; }
    .btn-cart-circle:hover { background: #b45309; transform: scale(1.1); }

    .pagination .page-link { color: #475569; border: 1px solid #e2e8f0; margin: 0 3px; border-radius: 8px; font-weight: 600; transition: 0.2s; }
    .pagination .page-item.active .page-link { background-color: var(--accent-color); border-color: var(--accent-color); color: #fff; }
    .pagination .page-link:hover { background-color: #f1f5f9; }

    .offcanvas-bottom { height: 85vh !important; }

    /* =========================================
       📱 MOBILE SPECIFIC ADJUSTMENTS
       ========================================= */
    @media (max-width: 991px) {
        .filter-sidebar { display: none; }
        .book-title { font-size: 0.95rem; }
        .book-price { font-size: 1rem; }
    }
</style>
@endsection

@section('content')

<div class="page-header py-3 py-md-4">
    <div class="container text-center">
        <h1 class="display-6 fw-bold font-playfair text-dark mb-1">Our Collection</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 small">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item active text-accent fw-bold" aria-current="page">Shop Books</li>
            </ol>
        </nav>
    </div>
</div>

<section class="pt-3 pb-5 pt-lg-5">
    <div class="container">
        <div class="row g-4">
            
            <div class="col-lg-3 filter-sidebar">
                <form action="{{ route('shop') }}" method="GET" id="desktopFilterForm">
                    <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}" id="desktopSortHidden">

                    <div class="search-box mb-4">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control py-2" placeholder="Search books..." value="{{ request('search') }}">
                    </div>

                    <div class="filter-card">
                        <h4 class="filter-title">Categories</h4>
                        @foreach($categories as $category)
                        <div class="form-check custom-checkbox mb-2">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" @checked(is_array(request('categories')) && in_array($category->id, request('categories')))>
                            <label class="form-check-label w-100" for="cat{{ $category->id }}">
                                {{ $category->name }} <span class="filter-count">({{ $category->books_count ?? 0 }})</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="filter-card">
                        <h4 class="filter-title">Price Range</h4>
                        <div class="row g-2 align-items-center">
                            <div class="col-5"><input type="number" name="min_price" class="price-input" placeholder="Min" value="{{ request('min_price', 99) }}"></div>
                            <div class="col-2 text-center text-muted fw-bold">-</div>
                            <div class="col-5"><input type="number" name="max_price" class="price-input" placeholder="Max" value="{{ request('max_price', 1999) }}"></div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-3 rounded-pill btn-sm fw-bold">Apply Filter</button>
                    </div>

                    <div class="filter-card">
                        <h4 class="filter-title">Authors</h4>
                        @foreach($authors as $author)
                        <div class="form-check custom-checkbox mb-2">
                            <input class="form-check-input" type="checkbox" name="authors[]" value="{{ $author->id }}" id="auth{{ $author->id }}" @checked(is_array(request('authors')) && in_array($author->id, request('authors')))>
                            <label class="form-check-label w-100" for="auth{{ $author->id }}">
                                {{ $author->name }} <span class="filter-count">({{ $author->books_count ?? 0 }})</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <div class="col-lg-9">
                
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    
                    <div class="d-none d-md-block text-dark font-playfair fs-5 fw-bold">
                        Showing <span class="text-accent">{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</span> of {{ $books->total() }} Books
                    </div>

                    <div class="d-flex d-md-none w-100 bg-white rounded-pill shadow-sm border p-1 mb-2">
                        <button class="btn btn-sm w-50 fw-bold text-dark d-flex align-items-center justify-content-center border-end rounded-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterBottom">
                            <i class="fas fa-sliders-h me-2 text-muted"></i> Filter
                        </button>
                        
                        <div class="w-50 position-relative d-flex align-items-center justify-content-center bg-white rounded-end-pill px-2">
                            <i class="fas fa-sort-amount-down me-1 text-muted small"></i>
                            <select class="form-select form-select-sm shadow-none border-0 bg-transparent fw-bold text-dark w-100 px-0" style="cursor: pointer; text-overflow: ellipsis;" onchange="document.getElementById('mobileSortHidden').value = this.value; document.getElementById('mobileFilterForm').submit();">
                                <option value="latest" @selected(request('sort') == 'latest')>Latest</option>
                                <option value="price_low" @selected(request('sort') == 'price_low')>Low to High</option>
                                <option value="price_high" @selected(request('sort') == 'price_high')>High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-none d-md-flex align-items-center">
                        <span class="text-muted small fw-bold me-3">Sort by:</span>
                        <div class="desktop-sort-wrapper">
                            <select class="form-select shadow-none border-0 fw-bold text-dark bg-transparent ps-2 pe-4" style="cursor: pointer;" onchange="document.getElementById('desktopSortHidden').value = this.value; document.getElementById('desktopFilterForm').submit();">
                                <option value="latest" @selected(request('sort') == 'latest')>Latest Arrivals</option>
                                <option value="price_low" @selected(request('sort') == 'price_low')>Price: Low to High</option>
                                <option value="price_high" @selected(request('sort') == 'price_high')>Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    @forelse($books as $book)
                    <div class="col-6 col-md-4">
                        <div class="book-card">
                            <a href="{{ route('book.show', $book->id) }}" class="text-decoration-none text-dark">
                                @if($book->mrp > $book->price)
                                    <span class="badge bg-danger position-absolute m-2" style="z-index: 1;">Sale</span>
                                @endif
                                
                                @php $frontImage = $book->images->where('image_type', 'front')->first(); @endphp
                                <img src="{{ $frontImage ? asset('storage/'.$frontImage->image_path) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="{{ $book->title }}">
                                
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <h3 class="book-title">{{ $book->title }}</h3>
                                    <p class="book-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                                    
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="book-price">₹{{ $book->price }}</span>
                                            @if($book->mrp > $book->price)
                                                <small class="text-muted text-decoration-line-through ms-1">₹{{ $book->mrp }}</small>
                                            @endif
                                        </div>
                                        <button class="btn-cart-circle shadow-sm add-to-cart-btn" data-id="{{ $book->id }}">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted fw-bold mb-3">No books found!</h4>
                        <p class="text-muted">Try adjusting your filters or search criteria.</p>
                        <a href="{{ route('shop') }}" class="btn btn-dark rounded-pill px-4">Clear All Filters</a>
                    </div>
                    @endforelse
                </div>

                @if ($books->hasPages())
                <nav class="mt-5 d-none d-md-block" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @if ($books->onFirstPage())
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $books->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                        @endif

                        @foreach ($books->links()->elements[0] ?? [] as $page => $url)
                            @if ($page == $books->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($books->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $books->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                        @else
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                        @endif
                    </ul>
                </nav>
                @endif

                @if ($books->hasMorePages())
                <div class="text-center mt-4 d-md-none">
                    <a href="{{ $books->nextPageUrl() }}" class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold shadow-sm w-100">
                        Load More Books <i class="fas fa-sync-alt ms-2"></i>
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light border-top">
    <div class="container">
        <h3 class="fw-bold font-playfair mb-4 text-dark text-center text-md-start">You Might Also Like</h3>
        
        <div class="row g-3 g-md-4">
            @foreach(\App\Models\Book::inRandomOrder()->take(4)->get() as $relatedBook)
            <div class="col-6 col-md-3 {{ $loop->iteration > 2 ? 'd-none d-md-block' : '' }}">
                <div class="book-card border-0 shadow-sm">
                    <a href="{{ route('book.show', $relatedBook->id) }}" class="text-decoration-none text-dark">
                        @php $frontImg = $relatedBook->images->where('image_type', 'front')->first(); @endphp
                        <img src="{{ $frontImg ? asset('storage/'.$frontImg->image_path) : 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=600&auto=format&fit=crop' }}" class="book-cover" alt="Book">
                        <div class="p-3">
                            <h3 class="book-title fs-6">{{ $relatedBook->title }}</h3>
                            <p class="book-author mb-1 small">{{ $relatedBook->author->name ?? 'Unknown' }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="book-price fs-6">₹{{ $relatedBook->price }}</span>
                                <button class="btn-cart-circle shadow-sm add-to-cart-btn" data-id="{{ $relatedBook->id }}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-bottom rounded-top-4" tabindex="-1" id="mobileFilterBottom" aria-labelledby="mobileFilterLabel" style="height: 85vh; z-index: 99999 !important;">
    <form action="{{ route('shop') }}" method="GET" id="mobileFilterForm" class="h-100 d-flex flex-column position-relative m-0">
        <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}" id="mobileSortHidden">
        
        <div class="offcanvas-header border-bottom py-3 flex-shrink-0">
            <h5 class="offcanvas-title fw-bold font-playfair mb-0"><i class="fas fa-filter text-accent me-2"></i> Filter Books</h5>
            <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body flex-grow-1" style="padding-bottom: 100px; overflow-y: auto;"> 
            <div class="search-box mb-4">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control py-2 bg-light border-0" placeholder="Search books..." value="{{ request('search') }}">
            </div>

            <h6 class="fw-bold mb-3 text-dark">Categories</h6>
            <div class="mb-4">
                @foreach($categories as $category)
                <div class="form-check custom-checkbox mb-2">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="m_cat{{ $category->id }}" @checked(is_array(request('categories')) && in_array($category->id, request('categories')))>
                    <label class="form-check-label w-100" for="m_cat{{ $category->id }}">{{ $category->name }}</label>
                </div>
                @endforeach
            </div>

            <h6 class="fw-bold mb-3 text-dark">Price Range</h6>
            <div class="row g-2 align-items-center mb-4">
                <div class="col-5"><input type="number" name="min_price" class="price-input bg-light border-0" placeholder="Min" value="{{ request('min_price', 99) }}"></div>
                <div class="col-2 text-center text-muted fw-bold">-</div>
                <div class="col-5"><input type="number" name="max_price" class="price-input bg-light border-0" placeholder="Max" value="{{ request('max_price', 1999) }}"></div>
            </div>

            <h6 class="fw-bold mb-3 text-dark">Authors</h6>
            <div class="mb-0">
                @foreach($authors as $author)
                <div class="form-check custom-checkbox mb-2">
                    <input class="form-check-input" type="checkbox" name="authors[]" value="{{ $author->id }}" id="m_auth{{ $author->id }}" @checked(is_array(request('authors')) && in_array($author->id, request('authors')))>
                    <label class="form-check-label w-100" for="m_auth{{ $author->id }}">{{ $author->name }}</label>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-white border-top shadow-lg" style="z-index: 10;">
            <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold fs-6 shadow-sm">
                Apply Filters <i class="fas fa-check ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // 🔥 AJAX Add To Cart Logic
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();   // Button click ki default working roko
            e.stopPropagation();  // Important: Card ke <a> link par redirect hone se roko

            let bookId = $(this).data('id');
            let btn = $(this);
            
            // Button Animation Feedback
            btn.html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    book_id: bookId,
                    quantity: 1
                },
                success: function(response) {
                    if(response.status === 'success') {
                        // Restore Button Icon
                        btn.html('<i class="fas fa-check"></i>');
                        setTimeout(() => btn.html('<i class="fas fa-cart-plus"></i>'), 2000);

                        // Update Navigation Cart Badges (Desktop + Mobile)
                        if (typeof window.updateCartUI === 'function') {
                            window.updateCartUI(response.cart_count);
                        }

                        // Success Toast
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Book added to your bag!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: '#1e293b',
                            color: '#fff',
                            iconColor: '#d97706'
                        });
                    }
                },
                error: function(xhr) {
                    btn.html('<i class="fas fa-cart-plus"></i>');
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'Oops! Something went wrong.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    });
</script>
@endsection