@extends('layouts.admin')
@section('page_title', 'Register New Publication')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-5">
                <form action="{{ route('admin.publishers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center mb-4">
                        <label class="form-label d-block fw-bold text-muted">Publication Logo</label>
                        <div class="position-relative d-inline-block mb-3">
                            <img id="logoPreview" src="https://via.placeholder.com/150?text=Upload+Logo" class="img-thumbnail shadow-sm" width="150" height="150" style="object-fit: cover; border-radius: 12px;">
                        </div>
                        <input type="file" name="logo" class="form-control form-control-sm mx-auto w-50" accept="image/*" onchange="document.getElementById('logoPreview').src = window.URL.createObjectURL(this.files[0])">
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
                        <a href="{{ route('admin.publishers.index') }}" class="btn btn-light me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm"><i class="fas fa-building me-2"></i> Register Publication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection