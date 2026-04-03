@extends('layouts.admin')
@section('page_title', 'Edit Author: ' . $author->name)

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
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

        <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <label class="form-label d-block fw-bold text-muted">Current Profile Image</label>
                    <div class="mb-3 position-relative d-inline-block mt-2">
                        @php
                            // Direct WebP path (Trait) ya phir avatar
                            $currentProfile = $author->profile_image ? asset($author->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($author->name).'&background=random&color=fff&size=150';
                        @endphp
                        
                        <img id="profilePreview" src="{{ $currentProfile }}" class="rounded-circle shadow-sm border border-3 border-white" style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow" id="removeProfileBtn" style="display: none; width: 30px; height: 30px; padding: 0; line-height: 1; font-size: 16px;" title="Undo changes">&times;</button>
                    </div>
                    
                    <input type="file" name="profile_image" id="profileInput" class="form-control form-control-sm mx-auto w-75" accept="image/*">
                    <small class="text-muted d-block mt-2">Upload a new image to change</small>
                </div>
                
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $author->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="born_date" class="form-control" value="{{ old('born_date', $author->born_date) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Death (Optional)</label>
                            <input type="date" name="death_date" class="form-control" value="{{ old('death_date', $author->death_date) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Famous Books</label>
                            <input type="text" name="famous_works" class="form-control" value="{{ old('famous_works', $author->famous_works) }}" placeholder="e.g. Godan, Gaban">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label class="form-label fw-bold">About Author (Biography)</label>
                    <textarea name="about" id="summernote">{!! old('about', $author->about) !!}</textarea>
                </div>
            </div>

            <div class="text-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.authors.index') }}" class="btn btn-light px-4 fw-bold shadow-sm me-2 ">Cancel</a>
                <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold text-dark "><i class="fas fa-sync-alt me-2"></i>Update</button>
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

        // 3. Image Preview & Undo Logic
        const originalProfile = "{{ $currentProfile }}"; // Save current image URL from DB

        $('#profileInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#profilePreview').attr('src', event.target.result); // Show new selected image
                    $('#removeProfileBtn').fadeIn(); // Show 'X' button
                }
                reader.readAsDataURL(file);
            }
        });

        // Cancel the new file selection and revert to original DB image
        $('#removeProfileBtn').on('click', function() {
            $('#profileInput').val(''); // Clear the file input
            $('#profilePreview').attr('src', originalProfile); // Revert to database image
            $(this).fadeOut(); // Hide the 'X' button
        });

    });
</script>
@endsection