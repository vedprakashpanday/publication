<div class="filter-group mb-4">
    <h6 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Search Within</h6>
    <div class="search-box position-relative">
        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        <input type="text" name="search" class="form-control ps-5 py-2 rounded-pill border-light shadow-sm" 
               placeholder="Title or keyword..." value="{{ request('search') }}">
    </div>
</div>

<hr class="my-4 opacity-10">

<div class="filter-group mb-4">
    <h6 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Categories</h6>
    <div class="category-list custom-scrollbar" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
        @foreach($categories as $category)
        <div class="form-check custom-checkbox mb-2">
            <input class="form-check-input" type="checkbox" name="categories[]" 
                   value="{{ $category->id }}" id="cat_{{ $category->id }}" 
                   @checked(is_array(request('categories')) && in_array($category->id, request('categories')))>
            <label class="form-check-label d-flex justify-content-between align-items-center w-100 cursor-pointer" for="cat_{{ $category->id }}">
                <span class="small text-secondary">{{ $category->name }}</span>
                <span class="badge rounded-pill bg-light text-muted border small fw-normal">{{ $category->books_count ?? 0 }}</span>
            </label>
        </div>
        @endforeach
    </div>
</div>

<hr class="my-4 opacity-10">

<div class="filter-group mb-4">
    <h6 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Price Range (₹)</h6>
    <div class="row g-2 align-items-center">
        <div class="col-5">
            <input type="number" name="min_price" class="form-control form-control-sm rounded-3 border-light shadow-sm text-center fw-bold" 
                   placeholder="Min" value="{{ request('min_price') }}">
        </div>
        <div class="col-2 text-center text-muted small">TO</div>
        <div class="col-5">
            <input type="number" name="max_price" class="form-control form-control-sm rounded-3 border-light shadow-sm text-center fw-bold" 
                   placeholder="Max" value="{{ request('max_price') }}">
        </div>
    </div>
</div>

@if(!request()->is('author*'))
<hr class="my-4 opacity-10">
<div class="filter-group mb-4">
    <h6 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Authors</h6>
    <div class="author-list custom-scrollbar" style="max-height: 200px; overflow-y: auto; padding-right: 5px; ">
        @foreach($authors as $filterAuthor)
        <div class="form-check custom-checkbox mb-2">
            <input class="form-check-input" type="checkbox" name="authors[]" 
                   value="{{ $filterAuthor->id }}" id="auth_{{ $filterAuthor->id }}" 
                   @checked(is_array(request('authors')) && in_array($filterAuthor->id, request('authors')))>
            <label class="form-check-label small text-secondary cursor-pointer" for="auth_{{ $filterAuthor->id }}">
                {{ $filterAuthor->name }}
            </label>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="d-grid gap-2 mt-5" style="z-index: 9999;">
    <button type="submit" class="btn btn-accent rounded-pill py-2 fw-bold shadow-sm">
        Apply Filters <i class="fas fa-filter ms-1 small"></i>
    </button>
    
    @if(request()->anyFilled(['search', 'categories', 'min_price', 'max_price', 'authors']))
        <a href="{{ url()->current() }}" class="btn btn-link text-muted btn-sm text-decoration-none">
            <i class="fas fa-times-circle me-1"></i> Clear All
        </a>
    @endif
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-checkbox .form-check-input:checked { background-color: var(--accent-color); border-color: var(--accent-color); }
</style>