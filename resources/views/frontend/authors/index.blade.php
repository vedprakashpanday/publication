@extends('layouts.frontend')
@section('title', 'Our Authors | Divyansh Publication')

@section('styles')
<style>
    .author-grid-card {
        transition: 0.3s;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        background: #fff;
    }
    .author-grid-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: var(--accent-color);
    }
    .author-img-large {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    @media (max-width: 768px) {
        .author-img-large { width: 80px; height: 80px; }
    }
</style>
@endsection

@section('content')
<div class="page-header py-4 bg-light border-bottom">
    <div class="container text-center">
        <h1 class="display-6 fw-bold font-playfair mb-2">Our Authors</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0 small">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item active text-accent fw-bold">Authors</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4 py-lg-5">
    <div class="row g-4">
        
        <div class="d-lg-none mb-2">
            <button class="btn btn-dark rounded-pill w-100 py-2 fw-bold shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#authorFilterMobile">
                <i class="fas fa-search me-2"></i> Find Authors
            </button>
        </div>

        <div class="col-lg-3 d-none d-lg-block">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 font-playfair">Filter Authors</h5>
                    <form action="{{ route('authors.index') }}" method="GET">
                        @include('frontend.partials.shop-filters')
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="text-muted mb-0 small">Showing <b>{{ $authors->count() }}</b> of <b>{{ $authors->total() }}</b> Master Wordsmiths</p>
            </div>

            <div class="row g-3 g-md-4">
                @forelse($authors as $author)
                <div class="col-6 col-md-4">
                    <a href="{{ route('authors.show', $author->id) }}" class="text-decoration-none">
                        <div class="author-grid-card p-3 p-md-4 text-center h-100 d-flex flex-column align-items-center">
                            <img src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop' }}" 
                                 class="rounded-circle author-img-large mb-3" alt="{{ $author->name }}">
                            
                            <h5 class="fw-bold fs-6 text-dark mb-1 font-playfair">{{ $author->name }}</h5>
                            <span class="badge rounded-pill bg-light text-muted border fw-normal mb-2" style="font-size: 0.7rem;">
                                {{ $author->books_count }} Books Published
                            </span>
                            
                            <div class="mt-auto pt-2">
                                <span class="text-accent small fw-bold">View Profile <i class="fas fa-chevron-right ms-1" style="font-size: 0.6rem;"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-user-edit display-1 text-light mb-4"></i>
                    <h4 class="text-muted">No authors found matching your criteria.</h4>
                    <a href="{{ route('authors.index') }}" class="btn btn-accent rounded-pill px-4 mt-3">Clear Filters</a>
                </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $authors->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-bottom rounded-top-4" tabindex="-1" id="authorFilterMobile" style="height: 80vh; z-index:9999;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold font-playfair">Find Authors</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('authors.index') }}" method="GET">
            @include('frontend.partials.shop-filters')
        </form>
    </div>
</div>
@endsection