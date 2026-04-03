@extends('layouts.admin')
@section('page_title', 'Stock Requests')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="container-fluid">
    
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark text-center">
                <div class="card-body p-3">
                    <small class="d-block opacity-75 fw-bold text-uppercase" style="font-size: 0.6rem;">Pending</small>
                    <h5 class="mb-0 fw-bold">{{ $requests->where('status', 'pending')->count() }} <small style="font-size: 0.7rem;">REQ</small></h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-white text-center">
                <div class="card-body p-3">
                    <small class="d-block opacity-75 fw-bold text-uppercase" style="font-size: 0.6rem;">Approved Today</small>
                    <h5 class="mb-0 fw-bold">{{ $requests->where('status', 'approved')->where('updated_at', '>=', now()->startOfDay())->count() }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-3 p-md-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-boxes text-primary me-2"></i> Stock Requests</h5>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 auto-hide-alert text-center small py-2 mb-4">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="d-block d-md-none mb-4">
                <div class="position-relative mb-3">
                    <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search seller or book...">
                    <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                    <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </button>
                    <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border shadow-xs text-uppercase" style="font-size: 0.65rem;">
                        Showing <span id="mobileResultCount" class="text-primary">{{ $requests->count() }}</span> Requests
                    </div>
                </div>

                <div class="row g-4" id="mobileCardContainer">
                    @foreach($requests as $req)
                        @php
                            $sellerName = $req->user->shop_name ?? $req->user->name;
                            $searchString = strtolower($sellerName . ' ' . $req->book->title);
                            $statusBorder = $req->status == 'pending' ? 'border-warning' : ($req->status == 'approved' ? 'border-success' : 'border-danger');
                        @endphp
                        
                        <div class="col-12 stock-mobile-card" data-search="{{ $searchString }}">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-4 {{ $statusBorder }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 lh-sm">{{ $sellerName }}</h6>
                                            <small class="text-muted" style="font-size: 0.7rem;"><i class="fas fa-store me-1"></i> {{ $req->user->seller_type ?? 'Seller' }}</small>
                                        </div>
                                        <span class="badge {{ $req->status == 'pending' ? 'bg-warning text-dark' : ($req->status == 'approved' ? 'bg-success' : 'bg-danger') }} rounded-pill px-2 py-1 text-capitalize" style="font-size: 0.65rem;">
                                            {{ $req->status }}
                                        </span>
                                    </div>

                                    <div class="bg-light rounded-3 p-3 mb-3 border">
                                        <div class="fw-bold text-primary mb-2 small">{{ $req->book->title }}</div>
                                        <div class="d-flex justify-content-between align-items-center small">
                                            <span class="text-muted">Requested Qty:</span>
                                            <span class="fw-bold text-dark">{{ $req->quantity }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center small mt-1">
                                            <span class="text-muted">Warehouse Stock:</span>
                                            <span class="fw-bold {{ $req->book->stock < $req->quantity ? 'text-danger' : 'text-success' }}">{{ $req->book->stock }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-1">
                                        @if($req->status == 'pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('admin.stock.approve', $req->id) }}" method="POST" class="flex-grow-1 m-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-light text-success w-100 shadow-sm fw-bold border rounded-3 py-2" onclick="return confirm('Approve and deduct stock?')">
                                                        <i class="fas fa-check-circle me-1"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.stock.reject', $req->id) }}" method="POST" class="flex-grow-1 m-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-light text-danger w-100 shadow-sm fw-bold border rounded-3 py-2" onclick="return confirm('Reject this request?')">
                                                        <i class="fas fa-times-circle me-1"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center py-2 bg-light border rounded-3 text-muted small fw-bold">
                                                <i class="fas fa-history me-1"></i> Processed on {{ $req->updated_at->format('d M, Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                    <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                    <h6 class="text-muted fw-bold">No requests found</h6>
                </div>

                <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                    Load More
                </button>
            </div>

            <div class="d-none d-md-block table-responsive mt-2">
                <table class="table table-hover align-middle custom-table w-100" id="stockTable">
                    <thead class="bg-light text-uppercase small fw-bold text-muted tracking-wider">
                        <tr>
                            <th>Seller / Fair</th>
                            <th>Book Details</th>
                            <th class="text-center">Req. Qty</th>
                            <th class="text-center">WH Stock</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $req->user->shop_name ?? $req->user->name }}</div>
                                <small class="text-muted small">{{ $req->user->seller_type }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary small text-truncate" style="max-width: 200px;">{{ $req->book->title }}</div>
                                <small class="text-muted">Ed: {{ $req->book->edition }}</small>
                            </td>
                            <td class="text-center fw-bold">{{ $req->quantity }}</td>
                            <td class="text-center">
                                <span class="badge {{ $req->book->stock < $req->quantity ? 'bg-danger-subtle text-danger border border-danger' : 'bg-success-subtle text-success border border-success' }} rounded-pill px-3">
                                    {{ $req->book->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $req->status == 'pending' ? 'bg-warning text-dark' : ($req->status == 'approved' ? 'bg-success' : 'bg-danger') }} rounded-pill px-3 py-1 shadow-xs text-capitalize">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                @if($req->status == 'pending')
                                    <div class="d-flex justify-content-end gap-1">
                                        <form action="{{ route('admin.stock.approve', $req->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-light border shadow-sm text-success" title="Approve"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('admin.stock.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" title="Reject"><i class="fas fa-times"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <small class="text-muted fw-bold">PROCESSED</small>
                                @endif
                            </td>
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
    .bg-danger-subtle { background-color: #fee2e2; }
    .bg-success-subtle { background-color: #dcfce7; }
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
        // 1. Desktop DataTable
        var table = $('#stockTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            }],
            language: { search: "", searchPlaceholder: "Search requests..." },
            pageLength: 10,
            order: [[4, 'asc']] // Show Pending first
        });

        // 2. Mobile Excel Trigger
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile Live Search + Counter
        let currentLimit = 10;
        const $cards = $('.stock-mobile-card');
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
            matchCount === 0 ? $noResultsMsg.fadeIn() : $noResultsMsg.hide();
            matchCount > currentLimit ? $loadMoreBtn.show() : $loadMoreBtn.hide();
        }

        $('#mobileSearch').on('input', function() { currentLimit = 10; updateMobileView(); });
        $loadMoreBtn.on('click', function() { currentLimit += 10; updateMobileView(); });

        updateMobileView();
    });
</script>
@endsection