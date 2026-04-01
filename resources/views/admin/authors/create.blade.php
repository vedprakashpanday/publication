@extends('layouts.admin')
@section('page_title', 'Register New Author')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-5">
        <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 text-center border-end">
                    <label class="form-label d-block fw-bold">Author Profile Image</label>
                    <div class="mb-3">
                        <img id="preview" src="https://ui-avatars.com/api/?name=Author&size=150" class="rounded-circle shadow" width="150">
                    </div>
                    <input type="file" name="profile_image" class="form-control form-control-sm" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
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
                <button type="submit" class="btn btn-primary px-5 btn-lg shadow-sm">Save Author Profile</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({ height: 200, tabsize: 2 });
    });
</script>
@endsection