@extends('layouts.admin')
@section('page_title', 'Add Buyer Story')

@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.buyer-stories.store') }}" method="POST" enctype="multipart/form-data" id="storyForm">
                    @csrf
                    
                    <div class="text-center mb-4">
                        <label class="form-label fw-bold d-block">Buyer/Event Photo <span class="text-danger">*</span></label>
                        <div class="position-relative d-inline-block mb-3 group">
                            <img id="preview" src="https://via.placeholder.com/400x250?text=Select+Image" 
                                 class="rounded-4 shadow-sm border" 
                                 style="width: 100%; max-width: 400px; max-height: 250px; object-fit: cover;">
                            
                            <button type="button" id="removeImageBtn" 
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-lg border-white border-2" 
                                    style="display: none; width: 32px; height: 32px; z-index: 10;" 
                                    title="Remove Image">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <input type="file" name="image_path" id="imageInput" class="form-control" accept="image/*" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Buyer Name</label>
                            <input type="text" name="buyer_name" class="form-control rounded-3" placeholder="e.g. Rahul Sharma">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Event Name</label>
                            <input type="text" name="event_name" class="form-control rounded-3" placeholder="e.g. Delhi Book Fair">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Event Date</label>
                            <input type="date" name="event_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-share-nodes me-2"></i>Social Media Links (Optional)
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-danger-subtle text-danger border-0"><i class="fab fa-instagram"></i></span>
                                        <input type="url" name="instagram_url" class="form-control" placeholder="Instagram URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary-subtle text-primary border-0"><i class="fab fa-facebook-f"></i></span>
                                        <input type="url" name="facebook_url" class="form-control" placeholder="Facebook URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text brand-x border-0 text-white"><i class="fab fa-x-twitter"></i></span>
                                        <input type="url" name="x_url" class="form-control" placeholder="X (Twitter) URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text brand-threads border-0 text-white"><i class="fab fa-threads"></i></span>
                                        <input type="url" name="threads_url" class="form-control" placeholder="Threads URL">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text bg-success-subtle text-success border-0"><i class="fab fa-whatsapp"></i></span>
                                        <input type="url" name="whatsapp_url" class="form-control" placeholder="WhatsApp Community/Group Link">
                                    </div>
                                    <small class="text-muted ms-1" style="font-size: 0.7rem;">Paste your WhatsApp community or group invite link.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4 pt-3 border-top">
                        <a href="{{ route('admin.buyer-stories.index') }}" class="btn btn-light px-4 rounded-pill me-2 fw-bold text-muted border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Story</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const removeBtn = document.getElementById('removeImageBtn');
    const placeholder = "https://via.placeholder.com/400x250?text=Select+Image";

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                removeBtn.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    removeBtn.addEventListener('click', function() {
        imageInput.value = ''; // Input clear
        preview.src = placeholder; // Placeholder vapas
        this.style.display = 'none'; // Cross button hide
    });
</script>

<style>
    /* Custom Social Icon Styling */
    .input-group-text { width: 46px; justify-content: center; font-size: 1.1rem; }
    
    /* Brand Colors for X and Threads to avoid pure black look */
    .brand-x { background-color: #14171A; } /* Dark Navy/Black */
    .brand-threads { background-color: #262626; } /* Deep Gray */
    
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1); }
    
    /* Image Preview Animation */
    #preview { transition: all 0.3s ease; }
    .group:hover #preview { filter: brightness(0.9); }
</style>
@endsection