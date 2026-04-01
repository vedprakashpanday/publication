@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-bold mb-0">Order Details: <span class="text-primary">#{{ $order->order_number }}</span></h4>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h6 class="text-muted text-uppercase small fw-bold">Customer Info</h6>
                            <p class="mb-1 fw-bold text-dark">{{ $order->user->name }}</p>
                            <p class="mb-0 text-muted small"><i class="fas fa-envelope me-1"></i> {{ $order->user->email }}</p>
                        </div>
                        <div class="col-md-6 ps-md-4 mt-3 mt-md-0">
                            <h6 class="text-muted text-uppercase small fw-bold">Shipping Address</h6>
                            <p class="mb-0 text-dark small" style="line-height: 1.5;">
                                {!! nl2br(e($order->shipping_address)) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Items in this Order</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Book Title</th>
                                    <th class="text-center">Qty</th>
                                    <th>Price</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->book->title }}</div>
                                        <small class="text-muted">Author: {{ $item->book->author->name }}</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td class="text-end pe-4 fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td colspan="3" class="text-end py-3">Grand Total:</td>
                                    <td class="text-end pe-4 py-3 text-primary fs-5">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 text-center p-3" style="border-radius: 12px; background: #f8f9fa;">
                <div class="row">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block mb-1">Status</small>
                        <span class="badge bg-primary px-3 py-2 text-capitalize">{{ $order->status }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Payment</small>
                        <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }} px-3 py-2 text-capitalize">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-truck-moving me-2"></i>Update Order Tracker</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateTracking', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Current Order Status</label>
                            <select name="status" class="form-select border-0 bg-light">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dispatched)</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3" id="stockRestoreDiv" style="display:none;">
                        <div class="form-check form-switch p-3 bg-light border rounded">
                            <input class="form-check-input ms-0 me-2" type="checkbox" name="stock_restored" id="restoreStock">
                            <label class="form-check-label fw-bold text-danger" for="restoreStock">
                                Confirm: Books received back in good condition? (Add to Stock)
                            </label>
                        </div>
                    </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Courier / Logistics Name</label>
                            <input type="text" name="courier_name" class="form-control border-0 bg-light" value="{{ $order->courier_name }}" placeholder="e.g. Indian Post, DTDC, BlueDart">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Tracking / Consignment ID</label>
                            <input type="text" name="tracking_id" class="form-control border-0 bg-light fw-bold text-primary" value="{{ $order->tracking_id }}" placeholder="Enter Tracking Number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Live Status Message</label>
                            <textarea name="tracking_msg" class="form-control border-0 bg-light" rows="3" placeholder="e.g. Packet has left Delhi Hub.">{{ $order->tracking_msg }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-pill">
                            <i class="fas fa-sync-alt me-2"></i> Update Tracker Info
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-3">
                <button onclick="window.print()" class="btn btn-outline-secondary w-100 rounded-pill border-0 shadow-sm">
                    <i class="fas fa-print me-2"></i> Print Order Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // JS se checkbox tabhi dikhao jab status 'cancelled' select ho
    document.querySelector('select[name="status"]').addEventListener('change', function() {
        const div = document.getElementById('stockRestoreDiv');
        if(this.value === 'cancelled') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    });
</script>
@endsection