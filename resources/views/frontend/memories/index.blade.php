@extends('layouts.frontend')
@section('title', 'Community Memories | Divyansh Publication')

@section('styles')
<style>
    .buyer-story-card { transition: 0.3s ease; }
    .buyer-story-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; }
</style>
@endsection

@section('content')
<div class="page-header py-5 bg-light border-bottom text-center">
    <div class="container">
        <span class="text-uppercase fw-bold small text-muted letter-spacing">Community Gallery</span>
        <h1 class="display-5 fw-bold font-playfair mt-2 mb-3">Our Happy Memories</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">Every book has a story, and so do the people who read them.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4 justify-content-center" id="memories-container">
        @include('frontend.partials.memory_items', ['stories' => $stories])
    </div>

    <div class="text-center mt-5" id="loading-spinner" style="display: none;">
        <i class="fas fa-circle-notch fa-spin fa-2x text-accent"></i>
        <p class="text-muted mt-2 small">Loading more memories...</p>
    </div>
    
    <div class="text-center mt-5" id="no-more-data" style="display: none;">
        <p class="text-muted mb-0"><i class="fas fa-heart text-danger me-1"></i> You've seen all the memories!</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentPage = 1;
    let hasMorePages = true;
    let isLoading = false;
    let lastPage = {{ $stories->lastPage() }}; // Blade se last page info liya

    // Check if initial load already has all data
    if (currentPage >= lastPage) {
        hasMorePages = false;
        $('#no-more-data').show();
    }

    // Scroll Logic
    $(window).scroll(function() {
        // Agar window ka scroll position + window ki height document ki total height ke paas pahunch jaye
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            
            if (hasMorePages && !isLoading) {
                loadMoreMemories();
            }
        }
    });

    function loadMoreMemories() {
        isLoading = true;
        currentPage++;
        $('#loading-spinner').show();

        $.ajax({
            url: '?page=' + currentPage,
            type: "GET",
            success: function(response) {
                if(response.html === '') {
                    hasMorePages = false;
                    $('#loading-spinner').hide();
                    $('#no-more-data').show();
                    return;
                }

                $('#memories-container').append(response.html);
                $('#loading-spinner').hide();
                isLoading = false;

                // Check if we hit the last page
                if (currentPage >= lastPage) {
                    hasMorePages = false;
                    $('#no-more-data').show();
                }
            },
            error: function() {
                isLoading = false;
                $('#loading-spinner').hide();
            }
        });
    }
});
</script>
@endpush