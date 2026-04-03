@extends('layouts.admin')
@section('page_title', 'Register New Author')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body ">
        
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

        <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <label class="form-label d-block fw-bold">Author Profile Image</label>
                    <div class="mb-3 position-relative d-inline-block mt-2">
                        <img id="profilePreview" src="https://ui-avatars.com/api/?name=Author&size=150" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow" id="removeProfileBtn" style="display: none; width: 30px; height: 30px; padding: 0; line-height: 1; font-size: 16px;">&times;</button>
                    </div>
                    <input type="file" name="profile_image" id="profileInput" class="form-control form-control-sm" accept="image/*">
                </div>
                
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Munshi Premchand" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="born_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Death (Optional)</label>
                            <input type="date" name="death_date" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Famous Books (Comma separated)</label>
                            <input type="text" name="famous_works" class="form-control" placeholder="Godan, Gaban, etc.">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label class="form-label fw-bold">About Author (Biography)</label>
                    <textarea name="about" id="summernote"></textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-5 btn-lg shadow-sm"><i class="fas fa-save me-2"></i> Save Author Profile</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        
        // 1. Auto Hide Alerts after 2 seconds
        if ($('.auto-hide-alert').length > 0) {
            setTimeout(function() {
                $('.auto-hide-alert').fadeOut('slow');
            }, 2000);
        }

        // 2. Summernote Initialization
        $('#summernote').summernote({ height: 200, tabsize: 2 });

        // 3. Profile Image Preview & Remove Logic
        const defaultAvatar = "https://ui-avatars.com/api/?name=Author&size=150";

        $('#profileInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#profilePreview').attr('src', event.target.result); // Show selected image
                    $('#removeProfileBtn').fadeIn(); // Show 'X' button
                }
                reader.readAsDataURL(file);
            }
        });

        $('#removeProfileBtn').on('click', function() {
            $('#profileInput').val(''); // Clear the file input
            $('#profilePreview').attr('src', defaultAvatar); // Revert to default avatar
            $(this).fadeOut(); // Hide the 'X' button
        });

    });
</script>
@endsection