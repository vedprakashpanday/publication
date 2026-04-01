@extends('layouts.admin')
@section('page_title', 'Add New Book')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-5">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Basic Information</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Book Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                    <select name="author_id" class="form-select" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Publisher <span class="text-danger">*</span></label>
                    <select name="publisher_id" class="form-select" required>
                        <option value="">Select Publisher</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ISBN-13 <span class="text-danger">*</span></label>
                    <input type="text" name="isbn_13" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Edition</label>
                    <input type="text" name="edition" class="form-control">
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Publishing & Inventory</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Published Date</label>
                    <input type="date" name="published_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Binding <span class="text-danger">*</span></label>
                    <select name="binding" class="form-select" required>
                        <option value="Paperback">Paperback</option>
                        <option value="Hardbound">Hardbound</option>
                        <option value="Spiral">Spiral</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="0" required>
                </div>
            </div>

            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Media & Description</h5>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Cover Image <span class="text-danger">*</span></label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Extra Images</label>
                    <input type="file" name="extra_images[]" class="form-control" accept="image/*" multiple>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Book Description</label>
                    <textarea name="description" id="summernote" class="form-control"></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold"><i class="fas fa-save me-2"></i> Save Book</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
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
    });
</script>
@endsection