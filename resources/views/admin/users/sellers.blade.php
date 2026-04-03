@extends('layouts.admin')
@section('page_title', 'Manage Sellers')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-store text-primary me-2"></i> Divyansh Partners</h5>
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold shadow-sm d-none d-md-inline-block">
                {{ $sellers->count() }} Partners
            </span>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4 auto-hide-alert text-center small py-2">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search shop or name...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border shadow-xs text-uppercase" style="font-size: 0.65rem;">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $sellers->count() }}</span> Partners
                </div>
            </div>

            <div class="row g-3" id="mobileCardContainer">
                @foreach($sellers as $seller)
                    @php
                        $searchString = strtolower($seller->name . ' ' . $seller->shop_name . ' ' . $seller->seller_type);
                        $typeIcon = $seller->seller_type == 'book_fair' ? '🎪' : '🏪';
                        $typeLabel = $seller->seller_type == 'book_fair' ? 'Fair Agent' : 'Store Owner';
                        $typeClass = $seller->seller_type == 'book_fair' ? 'bg-info' : 'bg-primary';
                    @endphp
                    
                    <div class="col-12 seller-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-4 border-primary">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="position-relative me-3">
                                        <div class="bg-light text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center fw-bold border border-white" style="width: 55px; height: 55px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                                        </div>
                                        <span class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm" style="font-size: 10px; padding: 2px;">{{ $typeIcon }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-0 lh-sm">{{ $seller->shop_name ?? 'N/A' }}</h6>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $seller->name }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $seller->is_active ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-pill px-2" style="font-size: 0.7rem;">
                                            {{ $seller->is_active ? 'Active' : 'Blocked' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="bg-light p-2 rounded-3 border mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted fw-bold">Type:</small>
                                        <span class="badge {{ $typeClass }} rounded-pill" style="font-size: 0.65rem;">{{ $typeLabel }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted fw-bold">Email:</small>
                                        <small class="text-dark">{{ $seller->email }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted fw-bold">Joined:</small>
                                        <small class="text-dark fw-semibold">{{ $seller->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                                
                                <form action="{{ route('admin.users.toggle', $seller->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn {{ $seller->is_active ? 'btn-light text-danger' : 'btn-success' }} w-100 shadow-sm fw-bold border rounded-3 py-2" onclick="return confirm('Toggle status for {{ $seller->shop_name }}?')">
                                        <i class="fas {{ $seller->is_active ? 'fa-ban' : 'fa-check-circle' }} me-2"></i>
                                        {{ $seller->is_active ? 'Block Seller' : 'Activate Seller' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fas fa-store-slash fa-3x text-muted opacity-25 mb-3"></i>
                <h6 class="text-muted fw-bold">No Partners Found</h6>
            </div>

            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                Load More Partners
            </button>
        </div>

        <div class="d-none d-md-block table-responsive mt-2">
            <table class="table table-hover align-middle custom-table w-100" id="sellersTable">
                <thead class="bg-light text-uppercase small fw-bold text-muted tracking-wider">
                    <tr>
                        <th>Partner Info</th>
                        <th>Shop/Fair Name</th>
                        <th>Business Type</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellers as $seller)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $seller->name }}</div>
                            <small class="text-muted small">Joined: {{ $seller->created_at->format('d M Y') }}</small>
                        </td>
                        <td class="fw-semibold small">{{ $seller->shop_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $seller->seller_type == 'book_fair' ? 'bg-info-subtle text-info border border-info' : 'bg-primary-subtle text-primary border border-primary' }} rounded-pill px-3 shadow-xs">
                                {{ $seller->seller_type == 'book_fair' ? '🎪 Fair Agent' : '🏪 Store Owner' }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $seller->email }}</td>
                        <td>
                            <span class="badge {{ $seller->is_active ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-pill px-3 shadow-xs border">
                                {{ $seller->is_active ? 'Active' : 'Blocked' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.users.toggle', $seller->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $seller->is_active ? 'btn-light text-danger' : 'btn-success text-white' }} px-3 rounded-pill fw-bold border shadow-xs" onclick="return confirm('Change status?')">
                                    {{ $seller->is_active ? 'Block' : 'Unblock' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: #dcfce7; color: #15803d; }
    .bg-danger-soft { background-color: #fee2e2; color: #b91c1c; }
    .bg-soft-primary { background-color: #e0e7ff; color: #4338ca; }
    .bg-info-subtle { background-color: #e0f2fe; color: #0369a1; }
    .bg-primary-subtle { background-color: #eef2ff; color: #4f46e5; }
    .dataTables_filter input { border-radius: 20px; padding: 5px 15px; width: 250px !important; }
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
        var table = $('#sellersTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            }],
            language: { search: "", searchPlaceholder: "Search partners..." },
            pageLength: 10
        });

        // 2. Mobile Excel Trigger
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile Live Search + Counter
        let currentLimit = 10;
        const $cards = $('.seller-mobile-card');
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

        if ($('.auto-hide-alert').length > 0) {
            setTimeout(function() { $('.auto-hide-alert').fadeOut('slow'); }, 2000);
        }

        updateMobileView();
    });
</script>
@endsection