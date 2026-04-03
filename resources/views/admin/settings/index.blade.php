@extends('layouts.admin')
@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-cog text-primary me-2"></i> System Settings</h5>
    
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Application Name</label>
                <input type="text" name="app_name" class="form-control rounded-3" value="Divyansh Publication">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold small text-muted">Support Email</label>
                <input type="email" name="support_email" class="form-control rounded-3" value="support@divyanshpub.com">
            </div>

            <div class="col-12">
                <div class="p-4 bg-light rounded-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Maintenance Mode</h6>
                            <p class="text-muted small mb-0">Jab ye on hoga, tab sirf bypass key wale log hi site dekh payenge.</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenanceMode" style="width: 50px; height: 25px;" {{ app()->isDownForMaintenance() ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="row g-3 mt-2" id="maintenanceFields">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Bypass Secret Key (Admin Key)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-key text-warning"></i></span>
                                <input type="text" name="maintenance_secret" id="secretKey" class="form-control border-start-0" placeholder="e.g. admin-entry-2026" value="admin-access">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Your Bypass URL</label>
                            <div class="input-group">
                                <input type="text" id="bypassUrl" class="form-control bg-white" readonly value="{{ url('/') }}/admin-access">
                                <button class="btn btn-outline-primary" type="button" onclick="copyBypassUrl()"><i class="fas fa-copy"></i></button>
                            </div>
                            <small class="text-info" style="font-size: 0.7rem;">Is link ko kholne par aapke liye site chalu ho jayegi.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm py-2">
                    <i class="fas fa-save me-2"></i> Save Settings
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Copy URL Logic
    function copyBypassUrl() {
        var copyText = document.getElementById("bypassUrl");
        copyText.select();
        document.execCommand("copy");
        alert("Bypass URL copied to clipboard!");
    }

    // Dynamic URL Update
    document.getElementById('secretKey').addEventListener('input', function(e) {
        let baseUrl = "{{ url('/') }}";
        document.getElementById('bypassUrl').value = baseUrl + '/' + e.target.value;
    });
</script>
@endsection