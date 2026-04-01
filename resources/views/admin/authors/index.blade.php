@extends('layouts.admin')
@section('page_title', 'Authors Directory')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark">Total Registered Authors</h5>
            <a href="{{ route('admin.authors.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-user-plus me-2"></i> Add New Author
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Life Span</th>
                        <th>Famous Works</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td>
                            <img src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://ui-avatars.com/api/?name='.$author->name }}" 
                                 class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $author->name }}</div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $author->born_date ? date('Y', strtotime($author->born_date)) : '?' }} - 
                                {{ $author->death_date ? date('Y', strtotime($author->death_date)) : 'Present' }}
                            </small>
                        </td>
                        <td><span class="text-truncate d-inline-block" style="max-width: 200px;">{{ $author->famous_works }}</span></td>
                        <td class="text-center">
    <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i>
    </a>
    
    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this Author? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $authors->links() }}
    </div>
</div>
@endsection