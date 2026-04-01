@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">📦 Manage Orders</h4>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown">
                    Filter Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">All Orders</a></li>
                    <li><a class="dropdown-item" href="#">Pending</a></li>
                    <li><a class="dropdown-item" href="#">Shipped</a></li>
                    <li><a class="dropdown-item" href="#">Cancelled</a></li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Tracking</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold text-primary">#{{ $order->order_number }}</td>
                        <td>
                            <div class="fw-bold">{{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->user->role == 'seller' ? 'Partner' : 'Customer' }}</small>
                        </td>
                        <td><span class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</span></td>
                        <td>
                            @if($order->payment_status == 'paid')
                                <span class="badge bg-success-soft text-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                            @else
                                <span class="badge bg-danger-soft text-danger"><i class="fas fa-clock me-1"></i> Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-white',
                                    'shipped' => 'bg-primary text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-dark text-white'
                                ];
                            @endphp
                            <span class="badge {{ $statusClasses[$order->status] }} text-capitalize px-3 py-2">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            @if($order->tracking_id)
                                <small class="d-block fw-bold text-muted">{{ $order->courier_name }}</small>
                                <small class="text-primary">{{ $order->tracking_id }}</small>
                            @else
                                <span class="text-muted small">Not Dispatched</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View & Track">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($order->status == 'cancelled' && $order->payment_status == 'paid' && $order->refund_status != 'processed')
                                    <form action="{{ route('admin.orders.refund', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold shadow-sm" title="Process Refund">
                                            <i class="fas fa-undo"></i> Refund
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No orders found yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: #dcfce7; color: #15803d; }
    .bg-danger-soft { background-color: #fee2e2; color: #b91c1c; }
    .table thead th { border-top: none; }
</style>
@endsection