@extends('layouts.admin')
@section('page_title', 'Register New Publication')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4 auto-hide-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4 auto-hide-alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.publishers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="text-center mb-4">
                        <label class="form-label d-block fw-bold text-muted">Publication Logo</label>
                        <div class="position-relative d-inline-block mb-3 mt-2">
                            <img id="logoPreview" src="https://ui-avatars.com/api/?name=Publisher&background=EBF4FF&color=4F46E5&size=150" class="img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border-radius: 12px;">
                            
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow" id="removeLogoBtn" style="display: none; width: 30px; height: 30px; padding: 0; line-height: 1; font-size: 16px;">&times;</button>
                        </div>
                        <input type="file" name="logo" id="logoInput" class="form-control form-control-sm mx-auto w-50" accept="image/*">
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Publication Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Divyansh Publication" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" placeholder="+91 xxxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Head office address..."></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4 pt-3 border-top">
                        <a href="{{ route('admin.publishers.index') }}" class="btn btn-light fw-bold me-2 shadow-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm"><i class="fas fa-building me-2"></i> Register Publication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        // 1. Auto Hide Alerts after 2 seconds
        if ($('.auto-hide-alert').length > 0) {
            setTimeout(function() {
                $('.auto-hide-alert').fadeOut('slow');
            }, 2000);
        }

        // 2. Logo Image Preview & Remove Logic
        const defaultLogo = "https://ui-avatars.com/api/?name=Publisher&background=EBF4FF&color=4F46E5&size=150";

        $('#logoInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#logoPreview').attr('src', event.target.result); // Show selected image
                    $('#removeLogoBtn').fadeIn(); // Show 'X' button
                }
                reader.readAsDataURL(file);
            }
        });

        $('#removeLogoBtn').on('click', function() {
            $('#logoInput').val(''); // Clear the file input
            $('#logoPreview').attr('src', defaultLogo); // Revert to default placeholder
            $(this).fadeOut(); // Hide the 'X' button
        });

    });
</script>
@endsection