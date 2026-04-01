@extends('layouts.admin')
@section('page_title', 'Manage Sellers')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Divyansh Partners (Sellers)</h5>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Shop/Fair Name</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellers as $seller)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $seller->name }}</div>
                            <small class="text-muted">Joined: {{ $seller->created_at->format('d M Y') }}</small>
                        </td>
                        <td>{{ $seller->shop_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $seller->seller_type == 'book_fair' ? 'bg-info' : 'bg-primary' }}">
                                {{ $seller->seller_type == 'book_fair' ? '🎪 Fair Agent' : '🏪 Store Owner' }}
                            </span>
                        </td>
                        <td>{{ $seller->email }}</td>
                        <td>
                            <span class="badge {{ $seller->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $seller->is_active ? 'Active' : 'Blocked' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.users.toggle', $seller->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $seller->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $seller->is_active ? 'Block' : 'Unblock' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $sellers->links() }}
    </div>
</div>
@endsection