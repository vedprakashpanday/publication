@extends('layouts.admin')
@section('page_title', 'Registered Customers')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-users text-primary me-2"></i> Customers List</h5>
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold shadow-sm d-none d-md-inline-block">
                {{ $users->count() }} Total
            </span>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4 auto-hide-alert text-center small py-2">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="d-block d-md-none mb-4">
            <div class="position-relative mb-3">
                <input type="text" id="mobileSearch" class="form-control form-control-lg rounded-pill shadow-sm ps-4 border-primary" style="border-width: 2px;" placeholder="Search name or email...">
                <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-4 text-primary"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                <button type="button" id="mobileExcelBtn" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <div class="text-muted small fw-bold bg-light px-3 py-1 rounded-pill border shadow-xs text-uppercase" style="font-size: 0.65rem;">
                    Showing <span id="mobileResultCount" class="text-primary">{{ $users->count() }}</span> Users
                </div>
            </div>

            <div class="row g-3" id="mobileCardContainer">
                @foreach($users as $user)
                    @php
                        $searchString = strtolower($user->name . ' ' . $user->email);
                    @endphp
                    
                    <div class="col-12 user-mobile-card" data-search="{{ $searchString }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-4 border-primary">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center fw-bold me-3 border border-white" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark mb-0 lh-sm">{{ $user->name }}</h6>
                                        <small class="text-muted text-truncate d-block" style="max-width: 180px;">{{ $user->email }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $user->is_active ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-pill px-2" style="font-size: 0.7rem;">
                                            {{ $user->is_active ? 'Active' : 'Blocked' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="bg-light p-2 rounded-3 border mb-3 text-center">
                                    <small class="text-muted fw-semibold"><i class="far fa-calendar-alt me-1"></i> Joined: {{ $user->created_at->format('d M, Y') }}</small>
                                </div>
                                
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn {{ $user->is_active ? 'btn-light text-danger' : 'btn-success' }} w-100 shadow-sm fw-bold border rounded-3 py-2" onclick="return confirm('Change status for {{ $user->name }}?')">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} me-2"></i>
                                        {{ $user->is_active ? 'Block Account' : 'Activate Account' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fas fa-user-times fa-3x text-muted opacity-25 mb-3"></i>
                <h6 class="text-muted fw-bold">No Users Found</h6>
            </div>

            <button id="loadMoreBtn" class="btn btn-outline-primary w-100 mt-4 fw-bold shadow-sm py-2 rounded-pill">
                Load More Users
            </button>
        </div>

        <div class="d-none d-md-block table-responsive mt-2">
            <table class="table table-hover align-middle custom-table w-100" id="usersTable">
                <thead class="bg-light text-uppercase small fw-bold text-muted tracking-wider">
                    <tr>
                        <th>User Info</th>
                        <th>Email Address</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 border border-primary-subtle" style="width: 38px; height: 38px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $user->email }}</td>
                        <td class="small fw-semibold">{{ $user->created_at->format('d M, Y') }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} rounded-pill px-3 shadow-xs border">
                                {{ $user->is_active ? 'Active' : 'Blocked' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-light text-danger' : 'btn-success text-white' }} px-3 rounded-pill fw-bold border shadow-xs" onclick="return confirm('Toggle status?')">
                                    {{ $user->is_active ? 'Block' : 'Activate' }}
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
        var table = $('#usersTable').DataTable({
            dom: "<'row mb-3'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm fw-bold shadow-sm rounded-pill',
                exportOptions: { columns: [0, 1, 2, 3] }
            }],
            language: { search: "", searchPlaceholder: "Search customers..." },
            pageLength: 10
        });

        // 2. Mobile Excel Trigger
        $('#mobileExcelBtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });

        // 3. Mobile Live Search + Counter
        let currentLimit = 10;
        const $cards = $('.user-mobile-card');
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