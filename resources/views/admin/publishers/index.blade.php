@extends('layouts.admin')
@section('page_title', 'Manage Publications')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark">Partner Publications</h5>
            <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-building me-2"></i> Register Publication
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table">
                <thead class="bg-light">
                    <tr>
                        <th width="10%">Logo</th>
                        <th width="25%">Publication Name</th>
                        <th width="20%">Contact Info</th>
                        <th width="20%">Address</th>
                        <th width="10%" class="text-center">Total Books</th>
                        <th width="15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publishers as $pub)
                    <tr>
                        <td>
                            @if($pub->logo)
                                <img src="{{ asset('storage/'.$pub->logo) }}" class="img-thumbnail" width="60" style="border-radius: 8px;">
                            @else
                                <div class="bg-light text-secondary d-flex justify-content-center align-items-center img-thumbnail fw-bold" style="width: 60px; height: 60px; border-radius: 8px;">
                                    {{ substr($pub->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td><div class="fw-bold text-dark fs-6">{{ $pub->name }}</div></td>
                        <td>
                            <div class="text-muted"><i class="fas fa-phone-alt me-1 text-primary"></i> {{ $pub->contact_no ?? 'N/A' }}</div>
                        </td>
                        <td><small class="text-muted">{{ Str::limit($pub->address, 30) ?? 'Not Provided' }}</small></td>
                        <td class="text-center">
                            <span class="badge bg-success rounded-pill px-3">{{ $pub->books_count }} Books</span>
                        </td>
                        <td class="text-center">
    <a href="{{ route('admin.publishers.edit', $pub->id) }}" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i>
    </a>
    
    <form action="{{ route('admin.publishers.destroy', $pub->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this Publication?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No publications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $publishers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection