@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="bg-primary p-5 text-center">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&size=128" class="rounded-circle border border-4 border-white shadow">
                <h4 class="text-white mt-3 fw-bold">{{ Auth::user()->name }}</h4>
                <span class="badge bg-white text-primary rounded-pill px-3">System Administrator</span>
            </div>
            <div class="card-body p-4">
                <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab">
                    <li class="nav-item"><button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#info">Info</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-bs-target="#security">Security</button></li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active" id="info">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ Auth::user()->email }}">
                            </div>
                            <button class="btn btn-primary w-100 rounded-pill fw-bold">Update Profile</button>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection