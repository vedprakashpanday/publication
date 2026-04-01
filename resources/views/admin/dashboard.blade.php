@extends('layouts.admin')

@section('page_title', 'Overview')

@section('content')
<style>
    .stat-card { border: none; border-radius: 12px; transition: transform 0.3s, box-shadow 0.3s; color: white; overflow: hidden; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .stat-icon { font-size: 3rem; opacity: 0.3; position: absolute; right: -10px; bottom: -10px; transform: rotate(-15deg); }
    .bg-gradient-primary { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%); }
    .bg-gradient-danger { background: linear-gradient(135deg, #ed213a 0%, #93291e 100%); }
    .custom-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .custom-table th { background: #f8f9fa; text-transform: uppercase; font-size: 0.85rem; color: #6c757d; border-bottom: 2px solid #e9ecef; }
</style>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-gradient-primary p-4 position-relative">
            <h6 class="text-uppercase fw-bold mb-1">Total Books</h6>
            <h2 class="mb-0 fw-bold">1,245</h2>
            <i class="fas fa-book stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-gradient-success p-4 position-relative">
            <h6 class="text-uppercase fw-bold mb-1">Total Revenue</h6>
            <h2 class="mb-0 fw-bold">₹45k+</h2>
            <i class="fas fa-rupee-sign stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-gradient-warning p-4 position-relative">
            <h6 class="text-uppercase fw-bold mb-1">Active Sellers</h6>
            <h2 class="mb-0 fw-bold">24</h2>
            <i class="fas fa-users stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-gradient-danger p-4 position-relative">
            <h6 class="text-uppercase fw-bold mb-1">Low Stock Alerts</h6>
            <h2 class="mb-0 fw-bold">8</h2>
            <i class="fas fa-exclamation-triangle stat-icon"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="custom-table p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Urgent Stock Requests (Fairs)</h5>
                <button class="btn btn-sm btn-outline-primary">View All</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Seller Name</th>
                            <th>Book Title</th>
                            <th>Qty Requested</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="d-flex align-items-center"><img src="https://ui-avatars.com/api/?name=Rohan" class="rounded-circle me-2" width="30"> Rohan Kumar</div></td>
                            <td class="fw-bold text-dark">Gitanjali (Hindi)</td>
                            <td><span class="badge bg-primary rounded-pill px-3">50</span></td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="d-flex align-items-center"><img src="https://ui-avatars.com/api/?name=Amit" class="rounded-circle me-2" width="30"> Amit Sharma</div></td>
                            <td class="fw-bold text-dark">Advanced Mathematics</td>
                            <td><span class="badge bg-primary rounded-pill px-3">120</span></td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td><button class="btn btn-sm btn-secondary" disabled><i class="fas fa-check"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <button class="btn btn-primary w-100 mb-2 py-2 fw-bold"><i class="fas fa-plus-circle me-2"></i> Add New Book</button>
                <button class="btn btn-outline-dark w-100 mb-2 py-2"><i class="fas fa-building me-2"></i> Register Publisher</button>
                <button class="btn btn-outline-success w-100 py-2"><i class="fas fa-file-excel me-2"></i> Export Sales Report</button>
            </div>
        </div>
    </div>
</div>
@endsection