@extends('layouts.admin')
@section('page_title', 'Account Settings')

@section('content')
<div class="container-fluid mb-5">
    
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf @method('PUT')
                    
                    <input type="hidden" name="remove_image" id="removeImageFlag" value="0">

                    <div class="mb-4">
                        <div class="position-relative d-inline-block">
                            @php
                                $defaultAvatar = 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=f1f5f9&color=4f46e5&size=150';
                                $currentAvatar = Auth::user()->profile_image ? asset(Auth::user()->profile_image) : $defaultAvatar;
                            @endphp

                            <img id="avatarPreview" src="{{ $currentAvatar }}" 
                                 class="rounded-circle border border-4 shadow-sm" 
                                 style="width: 140px; height: 140px; object-fit: cover; border-color: #f8fafc !important;">
                            
                            <button type="button" id="removeAvatarBtn" 
                                    class="btn btn-danger position-absolute rounded-circle shadow-sm p-0" 
                                    style="width: 30px; height: 30px; top: 0; right: 0; display: {{ Auth::user()->profile_image ? 'flex' : 'none' }}; align-items: center; justify-content: center;" 
                                    title="Remove Photo">
                                <i class="fas fa-times small"></i>
                            </button>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                    <p class="badge bg-primary-subtle text-primary rounded-pill px-3 mb-4">{{ Auth::user()->seller_type ?? 'Administrator' }}</p>

                    <div class="d-grid gap-2">
                        <label for="profileInput" class="btn btn-outline-primary rounded-pill fw-bold" style="cursor: pointer;">
                            <i class="fas fa-camera me-2"></i> Change Picture
                        </label>
                        <input type="file" name="profile_image" id="profileInput" class="d-none" accept="image/jpeg, image/png, image/webp">
                    </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 p-0 overflow-hidden">
                
                <div class="card-header bg-white border-bottom p-4">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active rounded-pill px-4 fw-bold shadow-none" data-bs-toggle="pill" data-bs-target="#info" onclick="window.location.hash='#info'">Personal Info</button>
                        </li>
                        <li class="nav-item ms-2">
                            <button type="button" class="nav-link rounded-pill px-4 fw-bold shadow-none" data-bs-toggle="pill" data-bs-target="#security" onclick="window.location.hash='#security'">Security</button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade show active" id="info">
                            <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-user-edit text-primary me-2"></i> Account Details</h5>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-lg bg-light border-0" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="col-12 mt-4 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                        </form> <div class="tab-pane fade" id="security">
                            <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-shield-alt text-primary me-2"></i> Update Password</h5>
                            
                            <form action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">Current Password</label>
                                        <input type="password" name="current_password" class="form-control form-control-lg bg-light border-0" placeholder="Enter current password" required>
                                        @error('current_password') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">New Password</label>
                                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="Min. 8 characters" required minlength="8">
                                        @error('password') <small class="text-danger fw-bold mt-1 d-block">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light border-0" placeholder="Retype new password" required minlength="8">
                                    </div>
                                    <div class="col-12 mt-4 pt-3 border-top">
                                        <button type="submit" class="btn btn-dark px-5 py-2 rounded-pill fw-bold shadow-sm">
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #eef2ff; color: #4f46e5; }
    .form-control-lg { font-size: 0.95rem; border-radius: 10px; }
    .form-control:focus { background-color: #fff !important; border: 1px solid #4f46e5 !important; box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1); }
    .nav-pills .nav-link { color: #64748b; font-size: 0.95rem; }
    .nav-pills .nav-link.active { background-color: #4f46e5; color: #fff; }
</style>

<script>
    // ✅ FIX 2: Check Hash on Load and Open Correct Tab
    document.addEventListener("DOMContentLoaded", function() {
        let hash = window.location.hash;
        if (hash) {
            let targetTab = document.querySelector(`[data-bs-target="${hash}"]`);
            if (targetTab) {
                // Bootstrap 5 Tab trigger
                let tab = new bootstrap.Tab(targetTab);
                tab.show();
            }
        }
    });

    const profileInput = document.getElementById('profileInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const removeBtn = document.getElementById('removeAvatarBtn');
    const removeFlag = document.getElementById('removeImageFlag');
    const defaultAvatarUrl = "{!! $defaultAvatar !!}";

    profileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
                removeBtn.style.display = 'flex';
                removeFlag.value = '0';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeBtn.addEventListener('click', function() {
        profileInput.value = '';
        avatarPreview.src = defaultAvatarUrl;
        this.style.display = 'none';
        removeFlag.value = '1';
    });
</script>
@endsection