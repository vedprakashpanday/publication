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
    .btn-cart-circle { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; background: var(--accent-color); color: white; border: none; transition: 0.3s; }
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
                <div class="search-box mb-4">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control py-2" placeholder="Search books...">
                </div>

                <div class="filter-card">
                    <h4 class="filter-title">Categories</h4>
                    <div class="form-check custom-checkbox mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat1" checked>
                        <label class="form-check-label w-100" for="cat1">Literature & Fiction <span class="filter-count">(42)</span></label>
                    </div>
                    <div class="form-check custom-checkbox mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat2">
                        <label class="form-check-label w-100" for="cat2">Poetry & Ghazals <span class="filter-count">(18)</span></label>
                    </div>
                    <div class="form-check custom-checkbox mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat3">
                        <label class="form-check-label w-100" for="cat3">Self-Help <span class="filter-count">(30)</span></label>
                    </div>
                </div>

                <div class="filter-card">
                    <h4 class="filter-title">Price Range</h4>
                    <div class="row g-2 align-items-center">
                        <div class="col-5"><input type="number" class="price-input" placeholder="Min" value="99"></div>
                        <div class="col-2 text-center text-muted fw-bold">-</div>
                        <div class="col-5"><input type="number" class="price-input" placeholder="Max" value="999"></div>
                    </div>
                    <button class="btn btn-dark w-100 mt-3 rounded-pill btn-sm fw-bold">Apply Filter</button>
                </div>

                <div class="filter-card">
                    <h4 class="filter-title">Authors</h4>
                    <div class="form-check custom-checkbox mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="auth1">
                        <label class="form-check-label w-100" for="auth1">Ved Prakash Panday <span class="filter-count">(5)</span></label>
                    </div>
                    <div class="form-check custom-checkbox mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="auth2">
                        <label class="form-check-label w-100" for="auth2">Aditi Sharma <span class="filter-count">(3)</span></label>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    
                    <div class="d-none d-md-block text-dark font-playfair fs-5 fw-bold">
                        Showing <span class="text-accent">1–12</span> of 129 Books
                    </div>

                    <div class="d-flex d-md-none w-100 bg-white rounded-pill shadow-sm border p-1 mb-2">
                        <button class="btn btn-sm w-50 fw-bold text-dark d-flex align-items-center justify-content-center border-end rounded-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterBottom">
                            <i class="fas fa-sliders-h me-2 text-muted"></i> Filter
                        </button>
                        
                        <div class="w-50 position-relative d-flex align-items-center justify-content-center bg-white rounded-end-pill px-2">
                            <i class="fas fa-sort-amount-down me-1 text-muted small"></i>
                            <select class="form-select form-select-sm shadow-none border-0 bg-transparent fw-bold text-dark w-100 px-0" style="cursor: pointer; text-overflow: ellipsis;">
                                <option value="latest">Latest</option>
                                <option value="price_low">Low to High</option>
                                <option value="price_high">High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-none d-md-flex align-items-center">
                        <span class="text-muted small fw-bold me-3">Sort by:</span>
                        <div class="desktop-sort-wrapper">
                            <select class="form-select shadow-none border-0 fw-bold text-dark bg-transparent ps-2 pe-4" style="cursor: pointer;">
                                <option value="latest">Latest Arrivals</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3 g-md-4">
                    <div class="col-6 col-md-4">
                        <div class="book-card">
                            <a href="#" class="text-decoration-none text-dark">
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <h3 class="book-title">The Art of Storytelling</h3>
                                    <p class="book-author">Ved Prakash Panday</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="book-price">₹299</span>
                                        <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-4">
                        <div class="book-card">
                            <a href="#" class="text-decoration-none text-dark">
                                <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <h3 class="book-title">Ghazals of the Night</h3>
                                    <p class="book-author">Aman Verma</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="book-price">₹199</span>
                                        <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="book-card">
                            <a href="#" class="text-decoration-none text-dark">
                                <span class="badge bg-danger position-absolute m-2" style="z-index: 1;">Sale</span>
                                <img src="https://images.unsplash.com/photo-1476275466078-4007374efbbe?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <h3 class="book-title">The Hidden Truth</h3>
                                    <p class="book-author">Divyansh Exclusives</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="book-price">₹499</span>
                                            <small class="text-muted text-decoration-line-through ms-1">₹699</small>
                                        </div>
                                        <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="book-card">
                            <a href="#" class="text-decoration-none text-dark">
                                <img src="https://images.unsplash.com/photo-1618666012174-83b441c0bc76?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <h3 class="book-title">Echoes of the Past</h3>
                                    <p class="book-author">Ravi Sharma</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="book-price">₹350</span>
                                        <button class="btn-cart-circle shadow-sm" onclick="event.preventDefault();"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <nav class="mt-5 d-none d-md-block" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>

                <div class="text-center mt-4 d-md-none">
                    <button class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold shadow-sm w-100">
                        Load More Books <i class="fas fa-sync-alt ms-2"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light border-top">
    <div class="container">
        <h3 class="fw-bold font-playfair mb-4 text-dark text-center text-md-start">You Might Also Like</h3>
        
        <div class="row g-3 g-md-4">
            <div class="col-6 col-md-3">
                <div class="book-card border-0 shadow-sm">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                        <div class="p-3">
                            <h3 class="book-title fs-6">Modern Web Dev</h3>
                            <p class="book-author mb-1 small">Tech Experts</p>
                            <span class="book-price fs-6">₹450</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="book-card border-0 shadow-sm">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                        <div class="p-3">
                            <h3 class="book-title fs-6">Silent Echoes</h3>
                            <p class="book-author mb-1 small">Aditi Sharma</p>
                            <span class="book-price fs-6">₹220</span>
                        </div>
                    </a>
                </div>
            </div>
             <div class="col-6 col-md-3 d-none d-md-block">
                <div class="book-card border-0 shadow-sm">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                        <div class="p-3">
                            <h3 class="book-title fs-6">The Art of Story</h3>
                            <p class="book-author mb-1 small">Ved Prakash</p>
                            <span class="book-price fs-6">₹299</span>
                        </div>
                    </a>
                </div>
            </div>
             <div class="col-6 col-md-3 d-none d-md-block">
                <div class="book-card border-0 shadow-sm">
                    <a href="#" class="text-decoration-none text-dark">
                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop" class="book-cover" alt="Book">
                        <div class="p-3">
                            <h3 class="book-title fs-6">Ghazals of the Night</h3>
                            <p class="book-author mb-1 small">Aman Verma</p>
                            <span class="book-price fs-6">₹199</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-bottom rounded-top-4" tabindex="-1" id="mobileFilterBottom" aria-labelledby="mobileFilterLabel" style="height: 80vh;">
    <div class="offcanvas-header border-bottom py-3">
        <h5 class="offcanvas-title fw-bold font-playfair mb-0" id="mobileFilterLabel"><i class="fas fa-filter text-accent me-2"></i> Filter Books</h5>
        <button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body">
        <div class="search-box mb-4">
            <i class="fas fa-search"></i>
            <input type="text" class="form-control py-2 bg-light border-0" placeholder="Search books...">
        </div>

        <h6 class="fw-bold mb-3 text-dark">Categories</h6>
        <div class="mb-4">
            <div class="form-check custom-checkbox mb-2">
                <input class="form-check-input" type="checkbox" id="m_cat1" checked>
                <label class="form-check-label w-100" for="m_cat1">Literature & Fiction</label>
            </div>
            <div class="form-check custom-checkbox mb-2">
                <input class="form-check-input" type="checkbox" id="m_cat2">
                <label class="form-check-label w-100" for="m_cat2">Poetry & Ghazals</label>
            </div>
            <div class="form-check custom-checkbox mb-2">
                <input class="form-check-input" type="checkbox" id="m_cat3">
                <label class="form-check-label w-100" for="m_cat3">History & Culture</label>
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-dark">Price Range</h6>
        <div class="row g-2 align-items-center mb-4">
            <div class="col-5"><input type="number" class="price-input bg-light border-0" placeholder="Min" value="99"></div>
            <div class="col-2 text-center text-muted fw-bold">-</div>
            <div class="col-5"><input type="number" class="price-input bg-light border-0" placeholder="Max" value="999"></div>
        </div>

        <h6 class="fw-bold mb-3 text-dark">Authors</h6>
        <div class="mb-4">
            <div class="form-check custom-checkbox mb-2">
                <input class="form-check-input" type="checkbox" id="m_auth1">
                <label class="form-check-label w-100" for="m_auth1">Ved Prakash Panday</label>
            </div>
            <div class="form-check custom-checkbox mb-2">
                <input class="form-check-input" type="checkbox" id="m_auth2">
                <label class="form-check-label w-100" for="m_auth2">Aditi Sharma</label>
            </div>
        </div>
    </div>
    
    <div class="offcanvas-footer p-3 border-top bg-white">
        <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold" data-bs-dismiss="offcanvas">Apply Filters</button>
    </div>
</div>

@endsection