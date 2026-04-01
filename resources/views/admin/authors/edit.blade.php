@extends('layouts.admin')
@section('page_title', 'Edit Author: ' . $author->name)

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-5">
        <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <label class="form-label d-block fw-bold">Current Profile Image</label>
                    <div class="mb-3">
                        <img id="preview" src="{{ $author->profile_image ? asset('storage/'.$author->profile_image) : 'https://ui-avatars.com/api/?name='.$author->name }}" class="rounded-circle shadow" width="150" height="150" style="object-fit: cover;">
                    </div>
                    <input type="file" name="profile_image" class="form-control form-control-sm" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                    <small class="text-muted">Nayi image upload karein badalne ke liye</small>
                </div>
                
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $author->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="born_date" class="form-control" value="{{ $author->born_date }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date of Death (Optional)</label>
                            <input type="date" name="death_date" class="form-control" value="{{ $author->death_date }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Famous Books</label>
                            <input type="text" name="famous_works" class="form-control" value="{{ $author->famous_works }}">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <label class="form-label fw-bold">About Author (Biography)</label>
                    <textarea name="about" id="summernote">{!! $author->about !!}</textarea>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.authors.index') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 shadow-sm">Update Author Details</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({ height: 200 });
    });
</script>
@endsection