@extends('layouts.admin')
@section('page_title', 'Manage Publications')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-building text-primary me-2"></i> Partner Publications</h5>
            <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary shadow-sm fw-bold rounded-pill px-3">
                <i class="fas fa-plus-circle me-1"></i> Register
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4 auto-hide-alert text-center">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search publications...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border shadow-xs text-uppercase" style="font-size: 0.65rem;">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $publishers->count() }}</span> Records
                </div>
            </div>

            <div class="row g-4" id="mobileCardContainer">
                @foreach($publishers as $pub)
                    @php
                        $searchString = strtolower($pub->name . ' ' . ($pub->contact_no ?? '') . ' ' . ($pub->address ?? ''));
                    @endphp
                    
                    <div class="col-12 pub-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-4 border-primary">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    @if($pub->logo)
                                        <img src="{{ asset($pub->logo) }}" class="rounded shadow-sm border border-white me-3" width="60" height="60" style="object-fit: contain; background: #fff;">
                                    @else
                                        <div class="bg-light text-primary d-flex justify-content-center align-items-center rounded shadow-sm fw-bold fs-4 me-3" style="width: 60px; height: 60px;">
                                            {{ substr($pub->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $pub->name }}</h6>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.65rem;">ID: #PUB-{{ str_pad($pub->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                                
                                <div class="bg-light rounded-3 p-3 mb-3 border">
                                    <div class="mb-2 small">
                                        <i class="fas fa-phone-alt me-2 text-primary opacity-75"></i> 
                                        <span class="text-dark fw-semibold">{{ $pub->contact_no ?? 'N/A' }}</span>
                                    </div>
                                    <div class="mb-2 small text-muted">
                                        <i class="fas fa-map-marker-alt me-2 text-danger opacity-75"></i> 
                                        {{ Str::limit($pub->address, 50) ?? 'No Address' }}
                                    </div>
                                    <div class="mt-2 pt-2 border-top text-center">
                                        <span class="fw-bold text-primary">{{ $pub->books_count }}</span> <small class="text-muted">Total Books Published</small>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 pt-1">
                                    <a href="{{ route('admin.publishers.edit', $pub->id) }}" class="btn btn-light text-warning flex-grow-1 shadow-sm fw-bold border rounded-3 py-2" style="font-size: 0.85rem;">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.publishers.destroy', $pub->id) }}" method="POST" class="flex-grow-1 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger w-100 shadow-sm fw-bold border rounded-3 py-2" style="font-size: 0.85rem;" onclick="return confirm('Delete this publication?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fas fa-search-minus fa-3x text-muted opacity-25 mb-3"></i>
                <h6 class="text-muted fw-bold">No Publications Found</h6>
            </div>

            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                Load More
            </button>
        </div>

        <div class="d-none d-md-block table-responsive mt-2">
            <table class="table table-hover align-middle custom-table w-100" id="publishersTable">
                <thead class="bg-light">
                    <tr class="text-uppercase small fw-bold text-muted tracking-wider">
                        <th width="10%">Logo</th>
                        <th>Publication Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th class="text-center">Books</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publishers as $pub)
                    <tr>
                        <td>
                            @if($pub->logo)
                                <img src="{{ asset($pub->logo) }}" class="img-thumbnail" width="50" height="50" style="object-fit: contain;">
                            @else
                                <div class="bg-light text-primary d-flex justify-content-center align-items-center img-thumbnail fw-bold" style="width: 50px; height: 50px;">{{ substr($pub->name, 0, 1) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $pub->name }}</div>
                            <small class="text-muted">#PUB-{{ $pub->id }}</small>
                        </td>
                        <td class="small fw-semibold">{{ $pub->contact_no ?? '-' }}</td>
                        <td class="small text-muted">{{ Str::limit($pub->address, 30) }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $pub->books_count }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.publishers.edit', $pub->id) }}" class="btn btn-sm btn-light border shadow-sm text-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.publishers.destroy', $pub->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
        var table = $('#publishersTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                exportOptions: { columns: [1, 2, 3, 4] }
            }],
            language: { search: "", searchPlaceholder: "Search publications..." },
            pageLength: 10
        });

        // 2. Mobile Excel Trigger
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile View Logic
        let currentLimit = 10;
        const $cards = $('.pub-mobile-card');
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

<style>
    .dataTables_length select { width: 70px; display: inline-block; }
    .dataTables_filter input { border-radius: 20px; padding: 5px 15px; width: 250px !important; }
    @media (max-width: 767px) { .dt-buttons { display: none !important; } }
</style>
@endsection