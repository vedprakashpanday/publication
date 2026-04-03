@extends('layouts.admin')
@section('page_title', 'Buyer Stories Gallery')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-images text-primary me-2"></i> Buyer Stories</h5>
            <a href="{{ route('admin.buyer-stories.create') }}" class="btn btn-primary shadow-sm fw-bold rounded-pill px-3">
                <i class="fas fa-plus-circle me-1"></i> Add Story
            </a>
        </div>

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search events or buyers...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $stories->count() }}</span> Stories
                </div>
            </div>

            <div class="row g-4" id="mobileCardContainer">
                @foreach($stories as $story)
                    @php $searchString = strtolower($story->buyer_name . ' ' . $story->event_name); @endphp
                    <div class="col-12 story-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <img src="{{ asset($story->image_path) }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold text-dark mb-0">{{ $story->buyer_name ?? 'Happy Buyer' }}</h6>
                                    <span class="badge bg-{{ $story->is_active ? 'success' : 'secondary' }} rounded-pill">{{ $story->is_active ? 'Live' : 'Hidden' }}</span>
                                </div>
                                <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $story->event_name }} ({{ date('d M, Y', strtotime($story->event_date)) }})</p>
                                
                                <div class="d-flex gap-3 mb-3">
                                    @if($story->instagram_url) <a href="{{ $story->instagram_url }}" target="_blank" class="text-danger"><i class="fab fa-instagram fa-lg"></i></a> @endif
                                    @if($story->facebook_url) <a href="{{ $story->facebook_url }}" target="_blank" class="text-primary"><i class="fab fa-facebook fa-lg"></i></a> @endif
                                </div>

                                <div class="d-flex gap-2 border-top pt-3">
                                    <a href="{{ route('admin.buyer-stories.edit', $story->id) }}" class="btn btn-light text-warning flex-grow-1 shadow-sm fw-bold border rounded-3 py-2"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('admin.buyer-stories.destroy', $story->id) }}" method="POST" class="flex-grow-1">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger w-100 shadow-sm fw-bold border rounded-3 py-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold rounded-pill shadow-sm py-2" style="display: none;">Load More</button>
        </div>

        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover align-middle w-100" id="storiesTable">
                <thead class="bg-light">
                    <tr class="text-uppercase small fw-bold text-muted">
                        <th>Image</th>
                        <th>Buyer/Event</th>
                        <th>Social Links</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $story)
                    <tr>
                        <td><img src="{{ asset($story->image_path) }}" class="rounded shadow-sm" width="80" height="60" style="object-fit: cover;"></td>
                        <td>
                            <div class="fw-bold">{{ $story->buyer_name }}</div>
                            <small class="text-muted">{{ $story->event_name }} | {{ $story->event_date }}</small>
                        </td>
                        <td>
                            @if($story->instagram_url) <i class="fab fa-instagram text-danger me-2"></i> @endif
                            @if($story->facebook_url) <i class="fab fa-facebook text-primary"></i> @endif
                        </td>
                        <td><span class="badge bg-{{ $story->is_active ? 'success' : 'secondary' }}">{{ $story->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('admin.buyer-stories.edit', $story->id) }}" class="btn btn-sm btn-light border shadow-sm text-warning"><i class="fas fa-edit"></i></a>
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
        var table = $('#storiesTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{ extend: 'excelHtml5', text: '<i class="fas fa-file-excel me-1"></i> Excel', className: 'btn btn-success btn-sm fw-bold rounded-pill' }],
            language: { search: "", searchPlaceholder: "Search stories..." },
            pageLength: 10
        });

        $('#mobileExcelBtn').on('click', function() { table.button('.buttons-excel').trigger(); });

        let currentLimit = 10;
        const $cards = $('.story-mobile-card');
        const $loadMoreBtn = $('#loadMoreBtn');
        const $counter = $('#mobileResultCount');

        function updateMobileView() {
            let visibleCount = 0;
            let matchCount = 0;
            let searchTerm = $('#mobileSearch').val().toLowerCase();

            $cards.each(function() {
                let searchData = $(this).data('search');
                if (searchData.includes(searchTerm)) {
                    matchCount++;
                    if (visibleCount < currentLimit) { $(this).show(); visibleCount++; } else { $(this).hide(); }
                } else { $(this).hide(); }
            });
            $counter.text(matchCount);
            matchCount > currentLimit ? $loadMoreBtn.show() : $loadMoreBtn.hide();
        }

        $('#mobileSearch').on('input', function() { currentLimit = 10; updateMobileView(); });
        $loadMoreBtn.on('click', function() { currentLimit += 10; updateMobileView(); });
        updateMobileView();
    });
</script>
@endsection