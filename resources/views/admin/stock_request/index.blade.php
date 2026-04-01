@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">
            <i class="fas fa-boxes text-info me-2"></i> Partner Stock Requests
        </h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-muted tracking-wider">
                            <th>Seller / Fair</th>
                            <th>Book Details</th>
                            <th class="text-center">Req. Qty</th>
                            <th class="text-center">Warehouse Stock</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $req->user->shop_name ?? $req->user->name }}</div>
                                <small class="text-muted"><i class="fas fa-store me-1"></i> {{ $req->user->seller_type }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary mb-1">{{ $req->book->title }}</div>
                                <div class="small">
                                    <span class="badge bg-light text-dark border me-1">Ed: {{ $req->book->edition }}</span>
                                    <span class="badge bg-light text-dark border me-1">Pub: {{ $req->book->publisher->name }}</span>
                                    <span class="text-muted ms-1">({{ $req->book->published_date }})</span>
                                </div>
                            </td>
                            <td class="fw-bold text-center fs-5 text-dark">{{ $req->quantity }}</td>
                            <td class="text-center">
                                <span class="badge {{ $req->book->stock < $req->quantity ? 'bg-danger' : 'bg-success' }} fs-6">
                                    {{ $req->book->stock }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning text-dark',
                                        'approved' => 'bg-success text-white',
                                        'rejected' => 'bg-danger text-white',
                                    ];
                                @endphp
                                <span class="badge {{ $statusColors[$req->status] ?? 'bg-secondary' }} px-3 py-2 text-uppercase">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                @if($req->status == 'pending')
                                    <form action="{{ route('admin.stock.approve', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success shadow-sm fw-bold px-3 me-1" onclick="return confirm('Approve this request? Stock will be deducted.')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.stock.reject', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm fw-bold px-3" onclick="return confirm('Are you sure you want to reject this request?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small"><i class="fas fa-lock me-1"></i> Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fs-1 mb-3 opacity-25"></i>
                                <h5>No Stock Requests</h5>
                                <p>You are all caught up!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-end">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection