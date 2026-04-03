@extends('layouts.admin')
@section('page_title', 'Book Details: ' . $book->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark"><i class="fas fa-book text-primary me-2"></i> Book Details</h4>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary shadow-sm me-2 d-flex align-items-center"><i class="fas fa-arrow-left me-1"></i>Back</a>
            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning shadow-sm fw-bold d-flex align-items-center"><i class="fas fa-edit me-1"></i>Edit</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center p-4">
                    @if($cover && $cover->image_path)
                        <img src="{{ asset($cover->image_path) }}" alt="{{ $book->title }}" class="img-fluid rounded shadow" style="max-height: 350px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded shadow-sm" style="height: 350px; width: 100%;">
                            <span class="text-muted"><i class="fas fa-image fa-3x mb-2"></i><br>No Cover Uploaded</span>
                        </div>
                    @endif

                    @if($galleryImages->count() > 0)
                        <h6 class="fw-bold mt-4 mb-3 text-start">Gallery Images</h6>
                        <div class="d-flex gap-2 overflow-auto pb-2">
                            @foreach($galleryImages as $img)
                                <img src="{{ asset($img->image_path) }}" class="img-thumbnail rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-1">{{ $book->title }}</h3>
                    <h5 class="text-muted mb-4"><i class="fas fa-feather-alt me-1"></i> {{ $book->author->name ?? 'Unknown Author' }}</h5>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded border-start border-4 border-info">
                                <small class="text-muted text-uppercase fw-bold">Publisher</small>
                                <div class="fs-5 fw-semibold text-dark">{{ $book->publisher->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded border-start border-4 border-success">
                                <small class="text-muted text-uppercase fw-bold">Price</small>
                                <div class="fs-5 fw-bold text-success">₹{{ $book->price }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">ISBN-13</small>
                                <div class="fw-semibold text-dark">{{ $book->isbn_13 }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">Stock Qty</small>
                                <div class="fw-bold {{ $book->quantity > 0 ? 'text-primary' : 'text-danger' }}">{{ $book->quantity }} Units</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">Status</small>
                                <div>
                                    @if($book->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">Binding</small>
                                <div class="fw-semibold text-dark">{{ $book->binding ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">Edition</small>
                                <div class="fw-semibold text-dark">{{ $book->edition ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase fw-bold">Published Date</small>
                                <div class="fw-semibold text-dark">{{ $book->published_date ? \Carbon\Carbon::parse($book->published_date)->format('d M, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3">Description</h5>
                    <div class="text-muted" style="line-height: 1.8;">
                        {!! $book->description ?? 'No description available for this book.' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection