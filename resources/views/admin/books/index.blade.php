@extends('layouts.admin')
@section('page_title', 'Manage Books')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-book text-primary me-2"></i> Book Inventory</h5>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary shadow-sm fw-bold rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> Add New
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 auto-hide-alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search books...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $books->count() }}</span> Books
                </div>
            </div>

            <div class="row g-4" id="mobileCardContainer">
                @foreach($books as $key => $book)
                    @php
                        $cover = \App\Models\BookImage::where('book_id', $book->id)->where('image_type', 'cover')->first();
                        $searchString = strtolower($book->title . ' ' . ($book->author->name ?? '') . ' ' . $book->isbn_13);
                    @endphp
                    
                    <div class="col-12 book-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-4 border-primary">
                            <div class="bg-light p-3 text-center position-relative" style="height: 200px;">
                                @if($cover && $cover->image_path)
                                    <img src="{{ asset($cover->image_path) }}" class="img-fluid rounded shadow-sm" style="max-height: 100%; object-fit: contain;">
                                @else
                                    <div class="h-100 d-flex flex-column justify-content-center opacity-25">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <small>No Cover Image</small>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge {{ $book->is_active ? 'bg-success' : 'bg-secondary' }} shadow-sm px-3 rounded-pill">
                                        {{ $book->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark mb-1 lh-sm text-center px-2">{{ $book->title }}</h6>
                                <p class="text-muted small text-center mb-3">By {{ $book->author->name ?? 'Unknown Author' }}</p>
                                
                                <div class="bg-light rounded-3 p-2 mb-3 border">
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Price:</span>
                                        <span class="fw-bold text-success">₹{{ number_format($book->price, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Stock:</span>
                                        <span class="fw-bold {{ $book->quantity <= 5 ? 'text-danger' : 'text-primary' }}">{{ $book->quantity }} Units</span>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted">ISBN:</span>
                                        <span class="text-dark fw-semibold">{{ $book->isbn_13 }}</span>
                                    </div>
                                </div>
                                
                          <div class="d-flex gap-2 border-top pt-3">
    <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-light text-primary flex-grow-1 shadow-sm fw-bold border rounded-3 py-2" style="font-size: 0.85rem;">
        <i class="fas fa-eye me-1"></i> View
    </a>

    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-light text-warning flex-grow-1 shadow-sm fw-bold border rounded-3 py-2" style="font-size: 0.85rem;">
        <i class="fas fa-edit me-1"></i> Edit
    </a>

    <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST" class="flex-grow-1 m-0">
        @csrf 
        @method('PATCH')
        <button type="submit" class="btn btn-light text-{{ $book->is_active ? 'danger' : 'success' }} w-100 shadow-sm fw-bold border rounded-3 py-2" style="font-size: 0.85rem;" onclick="return confirm('Change status of this book?')">
            <i class="fas fa-power-off me-1"></i> {{ $book->is_active ? 'Off' : 'On' }}
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
                <h6 class="text-muted fw-bold">No Match Found</h6>
            </div>

            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                Load More Books
            </button>
        </div>

        <div class="d-none d-md-block table-responsive mt-2">
            <table class="table table-hover align-middle custom-table w-100" id="booksTable">
                <thead class="bg-light">
                    <tr class="text-uppercase small fw-bold text-muted tracking-wider">
                        <th width="5%">#</th>
                        <th width="10%">Cover</th>
                        <th>Title & Author</th>
                        <th>Publisher</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $key => $book)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @php $cover = \App\Models\BookImage::where('book_id', $book->id)->where('image_type', 'cover')->first(); @endphp
                            <img src="{{ $cover ? asset($cover->image_path) : 'https://via.placeholder.com/50x70' }}" class="img-thumbnail bg-white" style="width: 45px; height: 60px; object-fit: contain;">
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $book->title }}</div>
                            <small class="text-muted">{{ $book->author->name ?? 'Unknown' }} | {{ $book->isbn_13 }}</small>
                        </td>
                        <td class="small">{{ $book->publisher->name ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">₹{{ number_format($book->price, 2) }}</td>
                        <td class="fw-bold">{{ $book->quantity }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $book->is_active ? 'success' : 'secondary' }} shadow-xs px-2 py-1">
                                {{ $book->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-light border shadow-sm text-primary" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-light border shadow-sm text-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-{{ $book->is_active ? 'danger' : 'success' }}" title="Toggle Status"><i class="fas fa-power-off"></i></button>
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
        // 1. Initialize DataTable (Desktop)
        var table = $('#booksTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                exportOptions: { columns: [0, 2, 3, 4, 5, 6] }
            }],
            language: { search: "", searchPlaceholder: "Search records..." },
            pageLength: 10
        });

        // 2. Mobile Excel Trigger
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile View Filter Logic
        let currentLimit = 10;
        const $cards = $('.book-mobile-card');
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

        if ($('.auto-hide-alert').length > 0) {
            setTimeout(function() { $('.auto-hide-alert').fadeOut('slow'); }, 2000);
        }

        updateMobileView();
    });
</script>

<style>
    .dataTables_length select { width: 70px; display: inline-block; }
    .dt-buttons .btn { margin-left: 10px; }
    .dataTables_filter input { border-radius: 20px; padding: 5px 15px; width: 250px !important; }
    @media (max-width: 767px) { .dt-buttons { display: none !important; } }
</style>
@endsection