@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0 px-md-2">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-decoration-none">Orders</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-dark">Order: <span class="text-primary">#{{ $order->order_number }}</span></h3>
            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> Placed on: {{ $order->created_at->format('d M, Y | h:i A') }}</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-white border shadow-sm fw-bold">
                <i class="fas fa-print me-2 text-secondary"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary fw-bold shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row text-center position-relative">
                @php
                    $steps = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentIndex = array_search($order->status, $steps);
                @endphp
                @foreach($steps as $index => $step)
                    <div class="col-3">
                        <div class="position-relative mb-2">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm 
                                {{ $index <= $currentIndex ? 'bg-primary text-white' : 'bg-light text-muted border' }}" 
                                style="width: 45px; height: 45px; z-index: 2; position: relative;">
                                <i class="fas {{ $step == 'pending' ? 'fa-clock' : ($step == 'processing' ? 'fa-cog' : ($step == 'shipped' ? 'fa-truck' : 'fa-check-double')) }}"></i>
                            </div>
                            @if(!$loop->last)
                                <div class="position-absolute top-50 start-50 translate-middle-y w-100" 
                                     style="height: 4px; background: {{ $index < $currentIndex ? '#4f46e5' : '#e2e8f0' }}; left: 50%; z-index: 1;"></div>
                            @endif
                        </div>
                        <span class="small fw-bold text-capitalize {{ $index <= $currentIndex ? 'text-primary' : 'text-muted' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 border-md-end">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Customer Information</h6>
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=4f46e5&color=fff" class="rounded-circle me-3 shadow-sm" width="50">
                                <div>
                                    <p class="mb-0 fw-bold text-dark fs-5">{{ $order->user->name }}</p>
                                    <span class="badge bg-{{ $order->user->role == 'seller' ? 'info' : 'secondary' }}-subtle text-{{ $order->user->role == 'seller' ? 'info' : 'secondary' }} rounded-pill px-2">
                                        {{ ucfirst($order->user->role) }} Account
                                    </span>
                                </div>
                            </div>
                            <p class="mb-1 text-muted small"><i class="fas fa-envelope me-2 text-primary"></i>{{ $order->user->email }}</p>
                            <p class="mb-0 text-muted small"><i class="fas fa-phone me-2 text-primary"></i>{{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Shipping Details</h6>
                            <div class="p-3 bg-light rounded-3 border">
                                <p class="mb-0 text-dark small fw-semibold" style="line-height: 1.6;">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    {!! nl2br(e($order->shipping_address)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0 mt-2">
                    <h5 class="fw-bold mb-0"><i class="fas fa-shopping-cart text-primary me-2"></i>Items Summary</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light shadow-sm">
                                <tr class="text-muted small fw-bold">
                                    <th class="ps-4 py-3">Book Details</th>
                                    <th class="text-center py-3">Qty</th>
                                    <th class="py-3">Unit Price</th>
                                    <th class="text-end pe-4 py-3">Sub-Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $cover = \App\Models\BookImage::where('book_id', $item->book_id)->where('image_type', 'cover')->first();
                                            @endphp
                                            <img src="{{ $cover ? asset($cover->image_path) : 'https://via.placeholder.com/40x60' }}" 
                                                 class="rounded shadow-sm me-3" style="width: 45px; height: 60px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->book->title }}</div>
                                                <small class="text-muted"><i class="fas fa-feather me-1"></i>{{ $item->book->author->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td class="text-end pe-4 fw-bold text-dark">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light-subtle">
                                <tr>
                                    <td colspan="3" class="text-end py-3 fw-bold">Total Amount Payable:</td>
                                    <td class="text-end pe-4 py-3 text-primary fs-4 fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 rounded-4 text-center p-3 bg-white">
                <div class="row g-0">
                    <div class="col-6 border-end">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.65rem;">Order Status</small>
                        <span class="badge rounded-pill bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'dark' : 'primary') }} px-3 py-2 text-capitalize">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.65rem;">Payment</small>
                        <span class="badge rounded-pill {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger-subtle text-danger' }} px-3 py-2 text-capitalize">
                            <i class="fas {{ $order->payment_status == 'paid' ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 border-top border-primary border-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-map-marker-alt me-2"></i>Update Dispatch Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateTracking', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Update Status</label>
                            <select name="status" class="form-select border-0 bg-light rounded-3 py-2">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dispatched)</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3" id="stockRestoreDiv" style="display:{{ $order->status == 'cancelled' ? 'block' : 'none' }};">
                            <div class="form-check form-switch p-3 bg-danger-subtle border border-danger rounded-3">
                                <input class="form-check-input ms-0 me-2" type="checkbox" name="stock_restored" id="restoreStock">
                                <label class="form-check-label fw-bold text-danger small" for="restoreStock">
                                    Restore items to inventory stock?
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Courier / Logistics Service</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light"><i class="fas fa-shipping-fast text-muted"></i></span>
                                <input type="text" name="courier_name" class="form-control border-0 bg-light" value="{{ $order->courier_name }}" placeholder="e.g. DTDC, BlueDart">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Consignment / Tracking ID</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light"><i class="fas fa-barcode text-muted"></i></span>
                                <input type="text" name="tracking_id" class="form-control border-0 bg-light fw-bold text-primary" value="{{ $order->tracking_id }}" placeholder="Order TRK#">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Live Tracking Message (to Customer)</label>
                            <textarea name="tracking_msg" class="form-control border-0 bg-light rounded-3" rows="3" placeholder="Explain the current location or ETA...">{{ $order->tracking_msg }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm rounded-pill mt-2">
                            <i class="fas fa-paper-plane me-2"></i> Update Tracker & Notify
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-primary-subtle rounded-4 border border-primary border-dashed text-center">
                <p class="small text-primary fw-bold mb-2">Need a physical copy?</p>
                <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-4">
                    <i class="fas fa-file-invoice me-1"></i> Generate PDF Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Styling */
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; vertical-align: middle; }
    .bg-light-subtle { background-color: #f9fafb; }
    .border-dashed { border-style: dashed !important; }
    
    @media print {
        .sidebar, .top-nav, .col-lg-4, .btn, footer { display: none !important; }
        .main { margin-left: 0 !important; width: 100% !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .col-lg-8 { width: 100% !important; }
    }
</style>

<script>
    document.querySelector('select[name="status"]').addEventListener('change', function() {
        const div = document.getElementById('stockRestoreDiv');
        div.style.display = (this.value === 'cancelled') ? 'block' : 'none';
    });
</script>
@endsection