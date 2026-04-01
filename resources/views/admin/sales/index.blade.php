@extends('layouts.admin')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">📈 Partner Sales Reports</h4>
            <form action="" class="d-flex gap-2">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                <button class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Seller / Shop</th>
                        <th>Book (Edition/Pub)</th>
                        <th>Qty Sold</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->sale_date }}</td>
                        <td><span class="fw-bold">{{ $sale->seller->shop_name }}</span></td>
                        <td>
                            <div class="fw-bold text-primary">{{ $sale->book->title }}</div>
                            <small class="text-muted">Ed: {{ $sale->book->edition }} | {{ $sale->book->publisher->name }}</small>
                        </td>
                        <td class="text-center fw-bold text-success">{{ $sale->quantity_sold }}</td>
                        <td class="fw-bold">₹{{ number_format($sale->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection