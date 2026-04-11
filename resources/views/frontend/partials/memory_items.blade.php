@foreach($stories as $story)
<div class="col-12 col-md-6 col-lg-4 memory-item">
    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden buyer-story-card">
        <div class="position-relative">
            <img src="{{ asset($story->image_path) }}" class="card-img-top" alt="{{ $story->buyer_name }}" style="height: 250px; object-fit: cover;">
            <div class="position-absolute bottom-0 end-0 m-3 d-flex gap-2">
                @if($story->instagram_url)
                    <a href="{{ $story->instagram_url }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fab fa-instagram text-danger"></i></a>
                @endif
                @if($story->facebook_url)
                    <a href="{{ $story->facebook_url }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fab fa-facebook-f text-primary"></i></a>
                @endif
            </div>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0 fs-6">{{ $story->buyer_name }}</h5>
                    <p class="text-accent small mb-0 fw-semibold">{{ $story->event_name }}</p>
                </div>
                <span class="small text-muted opacity-75">{{ \Carbon\Carbon::parse($story->event_date)->format('M Y') }}</span>
            </div>
            <p class="text-secondary small mt-3 mb-0">
                "{{ $story->description ?? 'Amazing experience with Divyansh Publication!' }}"
            </p>
        </div>
    </div>
</div>
@endforeach