@extends('layouts.admin')
@section('page_title', 'Partner Sales Reports')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="container-fluid">
    
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white text-center">
                <div class="card-body p-3">
                    <small class="d-block opacity-75 fw-bold text-uppercase" style="font-size: 0.6rem;">Total Revenue</small>
                    <h5 class="mb-0 fw-bold">₹{{ number_format($sales->sum('total_amount'), 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white text-center">
                <div class="card-body p-3">
                    <small class="d-block opacity-75 fw-bold text-uppercase" style="font-size: 0.6rem;">Units Sold</small>
                    <h5 class="mb-0 fw-bold">{{ $sales->sum('sold_qty') }} <small style="font-size: 0.7rem;">PCS</small></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-3 p-md-4">
            
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-line text-primary me-2"></i> Sales Reports</h5>
                
                <form action="" method="GET" class="d-flex gap-2 align-items-center bg-light p-2 rounded-pill border">
                    <i class="fas fa-calendar-alt ms-2 text-muted small"></i>
                    <input type="date" name="date" class="form-control form-control-sm border-0 bg-transparent" value="{{ request('date') }}">
                    <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm">Filter</button>
                    @if(request('date'))
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-light btn-sm rounded-circle text-danger border"><i class="fas fa-times"></i></a>
                    @endif
                </form>
            </div>

            <div class="d-block d-md-none mb-4">
                <div class="position-relative mb-3">
                    <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search shop or book...">
                    <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                    <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                    <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border shadow-xs text-uppercase" style="font-size: 0.65rem;">
                        Showing <span id="mobileResultCount" class="text-primary">{{ $sales->count() }}</span> Records
                    </div>
                </div>

                <div class="row g-3" id="mobileCardContainer">
                    @foreach($sales as $sale)
                        @php
                            $searchString = strtolower(($sale->seller->shop_name ?? '') . ' ' . ($sale->book->title ?? ''));
                        @endphp
                        
                        <div class="col-12 sale-mobile-card" data-search="{{ $searchString }}">
                            <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-primary">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="text-muted small fw-bold"><i class="far fa-calendar-alt me-1"></i> {{ $sale->created_at->format('d M, Y') }}</span>
                                        <h6 class="fw-bold text-dark mt-1 mb-0 lh-sm">{{ $sale->seller->shop_name ?? $sale->seller->name }}</h6>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="fw-bold text-success mb-0">₹{{ number_format($sale->total_amount, 2) }}</h5>
                                        <small class="badge bg-primary-subtle text-primary rounded-pill px-2">{{ $sale->sold_qty }} Units</small>
                                    </div>
                                </div>
                                <div class="bg-light p-2 rounded-3 border">
                                    <div class="fw-bold text-dark small">{{ $sale->book->title ?? 'Book Removed' }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Ed: {{ $sale->book->edition ?? '-' }} | {{ $sale->book->publisher->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                    <i class="fas fa-search-dollar fa-3x text-muted opacity-25 mb-3"></i>
                    <h6 class="text-muted fw-bold">No matching records</h6>
                </div>

                <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                    Load More
                </button>
            </div>

            <div class="d-none d-md-block table-responsive mt-2">
                <table class="table table-hover align-middle custom-table w-100" id="salesTable">
                    <thead class="bg-light text-uppercase small fw-bold text-muted tracking-wider">
                        <tr>
                            <th width="12%">Date</th>
                            <th width="20%">Seller / Shop</th>
                            <th>Book Details</th>
                            <th class="text-center">Qty</th>
                            <th width="15%">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td class="fw-semibold small">{{ $sale->created_at->format('d M, Y') }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $sale->seller->shop_name ?? $sale->seller->name }}</div>
                                <small class="text-muted">ID: #SEL-{{ $sale->user_id }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary small text-truncate" style="max-width: 250px;">{{ $sale->book->title ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $sale->book->publisher->name ?? 'N/A' }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $sale->sold_qty }}</span>
                            </td>
                            <td class="fw-bold text-success">₹{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .dataTables_length select { width: 70px; display: inline-block; }
    .dataTables_filter input { border-radius: 20px; padding: 5px 15px; width: 250px !important; }
    .bg-info-subtle { background-color: #e0f2fe; color: #0369a1; }
    .bg-primary-subtle { background-color: #eef2ff; color: #4f46e5; }
    @media (max-width: 767px) { .dt-buttons { display: none !important; } }
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#salesTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                title: 'Sales_Report_{{ date("Y-m-d") }}'
            }],
            language: { search: "", searchPlaceholder: "Search report..." },
            pageLength: 10,
            order: [[0, 'desc']]
        });

        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        let currentLimit = 10;
        const $cards = $('.sale-mobile-card');
        const $loadMoreBtn = $('#loadMoreBtn');
        const $noResultsMsg = $('#noResultsMessage');
        const $counter = $('#mobileResultCount');

        function updateMobileView() {
            let visibleCount = 0;
            let matchCount = 0;
            let searchTerm = $('#mobileSearch').val().toLowerCase();

            $cards.each(function() {
                let searchData = $(this).data('search');
                if (searchData.includes(searchTerm)) {
                    matchCount++;
                    if (visibleCount < currentLimit) {
                        $(this).show(); visibleCount++;
                    } else { $(this).hide(); }
                } else { $(this).hide(); }
            });

            $counter.text(matchCount);
            matchCount === 0 ? $noResultsMsg.show() : $noResultsMsg.hide();
            matchCount > currentLimit ? $loadMoreBtn.show() : $loadMoreBtn.hide();
        }

        $('#mobileSearch').on('input', function() { currentLimit = 10; updateMobileView(); });
        $loadMoreBtn.on('click', function() { currentLimit += 10; updateMobileView(); });

        updateMobileView();
    });
</script>
@endsection