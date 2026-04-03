@extends('layouts.admin')
@section('content')
<div class="container-fluid mb-3">
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-gradient-primary text-white">
                <small class="opacity-75 fw-bold text-dark">TOTAL REVENUE</small>
                <h3 class="fw-bold mb-0 text-dark">₹{{ number_format($total_revenue, 2) }}</h3>
            </div>
        </div>
        </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
    <h6 class="fw-bold mb-4">Weekly Sales Trend</h6>
    <div style="position: relative; height: 320px; width: 100%;">
        <canvas id="salesChart"></canvas>
    </div>
</div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-4">Recent Orders</h6>
                @foreach($recent_orders as $order)
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light p-2 rounded-circle me-3"><i class="fas fa-shopping-bag text-primary"></i></div>
                    <div>
                        <div class="small fw-bold">#{{ $order->order_number }}</div>
                        <small class="text-muted">{{ $order->user->name }}</small>
                    </div>
                    <div class="ms-auto fw-bold text-success small">₹{{ $order->total_amount }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        // Hum labels ko thoda format kar dete hain (Optional)
        labels: {!! json_encode($sales_labels->map(fn($d) => date('d M', strtotime($d)))) !!},
        datasets: [{
            label: 'Daily Sales (₹)',
            data: {!! json_encode($sales_values) !!},
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#4f46e5',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false } // Legend hide kar diya kyunki ek hi line hai
        },
        scales: {
            y: { beginAtZero: true, grid: { display: false } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endsection