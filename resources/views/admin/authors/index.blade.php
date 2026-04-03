@extends('layouts.admin')
@section('page_title', 'Authors Directory')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-feather-alt text-primary me-2"></i> Authors Directory</h5>
            <a href="{{ route('admin.authors.create') }}" class="btn btn-primary shadow-sm fw-bold rounded-pill px-3">
                <i class="fas fa-user-plus me-1"></i> Add
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4 auto-hide-alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search authors...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $authors->count() }}</span> records
                </div>
            </div>

            <div class="row g-3" id="mobileCardContainer">
                @foreach($authors as $author)
                    @php
                        $searchString = strtolower($author->name . ' ' . ($author->famous_works ?? ''));
                        $profileImg = $author->profile_image ? asset($author->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($author->name).'&background=f8f9fa&color=4f46e5';
                    @endphp
                    
                    <div class="col-12 author-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $profileImg }}" class="rounded-circle shadow-sm border border-2 border-white me-3" width="60" height="60" style="object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $author->name }}</h6>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="fas fa-calendar-alt me-1 text-primary opacity-75"></i> 
                                        {{ $author->born_date ? date('Y', strtotime($author->born_date)) : '?' }} - 
                                        {{ $author->death_date ? date('Y', strtotime($author->death_date)) : 'Present' }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 bg-light p-2 rounded-3 border">
                                <small class="text-muted fw-bold d-block mb-1 text-uppercase" style="font-size: 0.6rem;">Famous Works</small>
                                <span class="text-dark small d-block text-truncate">{{ $author->famous_works ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="d-flex gap-2 border-top pt-3">
                                <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-light text-warning flex-grow-1 shadow-sm fw-bold rounded-3 py-2 border">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="flex-grow-1 m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light text-danger w-100 shadow-sm fw-bold rounded-3 py-2 border" onclick="return confirm('Delete {{ $author->name }}?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fas fa-search-minus fa-3x text-muted opacity-25 mb-3"></i>
                <h6 class="text-muted fw-bold">No Authors Found</h6>
            </div>

            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold rounded-pill shadow-sm py-2" style="display: none;">
                Load More
            </button>
        </div>


        <div class="d-none d-md-block table-responsive mt-2">
            <table class="table table-hover align-middle custom-table w-100" id="authorsTable">
                <thead class="bg-light">
                    <tr class="text-uppercase small fw-bold text-muted tracking-wider">
                        <th width="10%" class="text-center">Profile</th>
                        <th width="25%">Author Name</th>
                        <th width="20%">Life Span</th>
                        <th width="30%">Famous Works</th>
                        <th width="15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td class="text-center">
                            <img src="{{ $author->profile_image ? asset($author->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($author->name).'&background=f8f9fa&color=4f46e5' }}" 
                                 class="rounded-circle shadow-sm border border-2 border-white" width="55" height="55" style="object-fit: cover;">
                        </td>
                        <td><div class="fw-bold text-primary fs-6">{{ $author->name }}</div></td>
                        <td>
                            <div class="d-flex align-items-center text-muted fw-semibold small">
                                <i class="fas fa-calendar-alt me-2 text-secondary"></i>
                                {{ $author->born_date ? date('Y', strtotime($author->born_date)) : '?' }} - {{ $author->death_date ? date('Y', strtotime($author->death_date)) : 'Present' }}
                            </div>
                        </td>
                        <td><span class="text-truncate d-inline-block text-muted small" style="max-width: 250px;">{{ $author->famous_works ?? 'N/A' }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-sm btn-light text-warning shadow-sm me-1 border"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger shadow-sm border" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>
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
        
        // 1. Initialize DataTable (Desktop)
        var table = $('#authorsTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel me-1"></i> Export to Excel',
                    className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill buttons-excel-custom', // Added custom class
                    exportOptions: { columns: [1, 2, 3] }
                }
            ],
            language: { search: "", searchPlaceholder: "Search authors..." },
            pageLength: 10,
        });

        // 🆕 2. Trigger DataTable Excel from Mobile Button
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile View Logic (Cards + Live Search + Counter)
        let currentLimit = 10;
        const $cards = $('.author-mobile-card');
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
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                } else {
                    $(this).hide();
                }
            });

            // Update Counter
            $counter.text(matchCount);

            matchCount === 0 ? $noResultsMsg.fadeIn() : $noResultsMsg.hide();
            matchCount > currentLimit ? $loadMoreBtn.show() : $loadMoreBtn.hide();
        }

        $('#mobileSearch').on('input', function() {
            currentLimit = 10; 
            updateMobileView();
        });

        $loadMoreBtn.on('click', function() {
            currentLimit += 10;
            updateMobileView();
        });

        updateMobileView();
    });
</script>

<style>
    .dataTables_length select { width: 70px; display: inline-block; }
    .dt-buttons .btn { margin-left: 10px; }
    .dataTables_filter input { border-radius: 20px; padding: 5px 15px; width: 250px !important; }
    /* Hide the original DataTable Excel button on mobile to avoid duplication */
    @media (max-width: 767px) { .dt-buttons { display: none !important; } }
</style>
@endsection