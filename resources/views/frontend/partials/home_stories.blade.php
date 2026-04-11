<section class="py-5 bg-white overflow-hidden">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div class="text-start">
                <span class="text-uppercase fw-bold small text-muted letter-spacing">Community Love</span>
                <h2 class="display-6 fw-bold font-playfair text-dark mt-2 mb-0">Our Happy Customers</h2>
                <p class="text-muted mt-2 mb-0" style="max-width: 600px;">Real stories from real readers who found their perfect match in our collection.</p>
            </div>
            
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 d-none d-md-block">View All Memories</a>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($buyerStories as $story)
            <div class="col-12 col-md-6 col-lg-4">
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
        </div>

        @if($buyerStories->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">Stay tuned! Our readers' stories are coming soon.</p>
            </div>
        @endif

        <div class="text-center mt-5 d-md-none">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-dark rounded-pill px-4 w-100 fw-bold">Explore All Memories</a>
        </div>
    </div>
</section>

<style>
    .buyer-story-card { transition: 0.3s ease; }
    .buyer-story-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; }
    .letter-spacing { letter-spacing: 1.5px; }
</style>