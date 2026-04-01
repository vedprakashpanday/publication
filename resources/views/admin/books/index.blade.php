@extends('layouts.admin')

@section('page_title', 'Manage Books')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Book Inventory</h5>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary fw-bold">
                <i class="fas fa-plus-circle me-1"></i> Add New Book
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="8%">Cover</th>
                        <th width="25%">Book Title & ISBN</th>
                        <th width="15%">Publisher</th>
                        <th width="10%">Price</th>
                        <th width="12%">Stock Qty</th>
                        <th width="10%">Status</th>
                        <th width="15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $key => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $key }}</td>
                        <td>
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="img-thumbnail" style="width: 50px; height: 70px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white d-flex justify-content-center align-items-center img-thumbnail" style="width: 50px; height: 70px; font-size: 10px;">No Img</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $book->title }}</div>
                            <small class="text-muted">ISBN: {{ $book->isbn_13 }}</small>
                        </td>
                        <td>{{ $book->publisher->name ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">₹{{ $book->price }}</td>
                        <td>
                            @if($book->quantity > 10)
                                <span class="badge bg-primary rounded-pill px-3">{{ $book->quantity }}</span>
                            @elseif($book->quantity > 0 && $book->quantity <= 10)
                                <span class="badge bg-warning text-dark rounded-pill px-3">{{ $book->quantity }} (Low)</span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($book->is_active)
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i> Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-info" title="View Details"><i class="fas fa-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-outline-danger" title="Toggle Status"><i class="fas fa-power-off"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">No books found in the inventory.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection