@extends('layouts.admin')
@section('page_title', 'Edit Publication: ' . $publisher->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-5">
                <form action="{{ route('admin.publishers.update', $publisher->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="text-center mb-4">
                        <label class="form-label d-block fw-bold text-muted">Current Logo</label>
                        <div class="position-relative d-inline-block mb-3">
                            <img id="logoPreview" src="{{ $publisher->logo ? asset('storage/'.$publisher->logo) : 'https://via.placeholder.com/150' }}" class="img-thumbnail shadow-sm" width="150" height="150" style="object-fit: cover; border-radius: 12px;">
                        </div>
                        <input type="file" name="logo" class="form-control form-control-sm mx-auto w-50" accept="image/*" onchange="document.getElementById('logoPreview').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Publication Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $publisher->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="contact_no" class="form-control" value="{{ $publisher->contact_no }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ $publisher->address }}</textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4 pt-3 border-top">
                        <a href="{{ route('admin.publishers.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">Update Publication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection