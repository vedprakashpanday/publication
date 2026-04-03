@extends('layouts.admin')
@section('page_title', 'Edit Book')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body">
        
        @if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4" id="autoHideAlert">
                <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Form Error:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Basic Information</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Book Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                    <select name="author_id" class="form-select searchable-select" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Publisher <span class="text-danger">*</span></label>
                    <select name="publisher_id" class="form-select searchable-select" required>
                        <option value="">Select Publisher</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->id }}" {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                {{ $publisher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ISBN-13 <span class="text-danger">*</span></label>
                    <input type="text" name="isbn_13" class="form-control" value="{{ old('isbn_13', $book->isbn_13) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Edition</label>
                    <input type="text" name="edition" class="form-control" value="{{ old('edition', $book->edition) }}">
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Publishing & Inventory</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Published Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $book->published_date) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Binding <span class="text-danger">*</span></label>
                    <select name="binding" class="form-select" required>
                        <option value="Paperback" {{ $book->binding == 'Paperback' ? 'selected' : '' }}>Paperback</option>
                        <option value="Hardbound" {{ $book->binding == 'Hardbound' ? 'selected' : '' }}>Hardbound</option>
                        <option value="Spiral" {{ $book->binding == 'Spiral' ? 'selected' : '' }}>Spiral</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $book->price) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $book->quantity) }}" required>
                </div>
            </div>

              <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Media & Description</h5>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <label class="form-label fw-bold">Cover Image <span class="text-danger">*</span></label>
        <input type="file" name="cover_image" class="form-control" accept="image/*" id="coverInput" required>
        <div id="coverPreviewContainer" class="mt-3 position-relative" style="display: none; width: 120px;">
            <img id="coverPreview" src="" class="img-thumbnail rounded" style="width: 120px; height: 160px; object-fit: cover;">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow" id="removeCoverBtn" style="width: 25px; height: 25px; padding: 0; line-height: 1;">&times;</button>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-bold">Extra Images</label>
        <input type="file" name="extra_images[]" class="form-control" accept="image/*" multiple id="galleryInput">
        <div id="galleryPreviewContainer" class="mt-3 d-flex flex-wrap gap-2"></div>
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">Book Description</label>
        <textarea name="description" id="summernote" class="form-control"></textarea>
    </div>
</div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.books.index') }}" class="btn btn-light shadow-sm fw-bold">Cancel</a>
                <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-dark shadow-sm"><i class="fas fa-sync-alt me-2"></i> Update Book</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        // Select2 Initialize
        $('.searchable-select').select2({
            placeholder: "Search and select...",
            allowClear: true,
            width: '100%'
        });

        // Summernote Initialize
        $('#summernote').summernote({
            placeholder: 'Write a detailed description of the book...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

         // --- 1. Auto Hide Alert after 2 seconds ---
        if ($('#autoHideAlert').length > 0) {
            setTimeout(function() {
                $('#autoHideAlert').fadeOut('slow');
            }, 2000); // 2000 ms = 2 seconds
        }

        // --- 2. Single Cover Image Preview ---
        $('#coverInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#coverPreview').attr('src', e.target.result);
                    $('#coverPreviewContainer').fadeIn();
                }
                reader.readAsDataURL(file);
            }
        });

        // Cover Image Remove Button
        $('#removeCoverBtn').on('click', function() {
            $('#coverInput').val(''); // Clear the file input
            $('#coverPreviewContainer').fadeOut(); // Hide preview
        });

        // --- 3. Multiple Gallery Images Preview ---
        let selectedFiles = []; // Array to store multiple files

        $('#galleryInput').on('change', function(e) {
            const files = Array.from(e.target.files);
            selectedFiles = selectedFiles.concat(files); // Add new files to array
            updateGalleryPreview();
        });

        function updateGalleryPreview() {
            $('#galleryPreviewContainer').empty(); // Clear old previews
            
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const html = `
                        <div class="position-relative" data-index="${index}">
                            <img src="${e.target.result}" class="img-thumbnail rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle shadow remove-gallery-btn" style="width: 20px; height: 20px; padding: 0; line-height: 1; font-size: 10px;">&times;</button>
                        </div>
                    `;
                    $('#galleryPreviewContainer').append(html);
                }
                reader.readAsDataURL(file);
            });

            // Re-sync input files (because standard file input is read-only)
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('galleryInput').files = dataTransfer.files;
        }

        // Gallery Image Remove Button (Event Delegation)
        $(document).on('click', '.remove-gallery-btn', function() {
            const index = $(this).parent().data('index');
            selectedFiles.splice(index, 1); // Remove from array
            updateGalleryPreview(); // Refresh UI
        });
    });
</script>
@endsection