@extends('layouts.admin')
@section('page_title', 'Registered Customers')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark">Total Customers</h5>
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                {{ $users->total() }} Users Found
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>User Info</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th>Account Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-soft text-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                            @else
                                <span class="badge bg-danger-soft text-danger"><i class="fas fa-ban me-1"></i> Blocked</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} px-3">
                                    {{ $user->is_active ? 'Block' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No customers registered yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: #e6fcf5; color: #0ca678; }
    .bg-danger-soft { background-color: #fff5f5; color: #fa5252; }
    .bg-soft-primary { background-color: #e7f1ff; color: #0d6efd; }
</style>
@endsection