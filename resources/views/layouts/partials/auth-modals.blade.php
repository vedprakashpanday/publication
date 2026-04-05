<style>
    .auth-modal .modal-content { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .auth-modal .modal-header { border-bottom: none; padding: 25px 30px 10px; }
    .auth-modal .modal-body { padding: 10px 30px 30px; }
    .auth-modal .btn-close { font-size: 0.8rem; background-color: #f1f5f9; border-radius: 50%; padding: 10px; opacity: 0.7; }
    .auth-modal .btn-close:hover { opacity: 1; background-color: #e2e8f0; }
    
    .auth-title { font-family: 'Playfair Display', serif; font-weight: 800; color: var(--primary-color); font-size: 1.8rem; margin-bottom: 5px; }
    .auth-subtitle { font-size: 0.9rem; color: #64748b; margin-bottom: 25px; }
    
    .auth-form .form-control { border-radius: 8px; padding: 12px 15px; border-color: #cbd5e1; font-size: 0.95rem; }
    .auth-form .form-control:focus { border-color: var(--accent-color); box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.1); }
    .auth-form .form-label { font-size: 0.85rem; font-weight: 600; color: var(--primary-color); margin-bottom: 6px; }
    
    .btn-auth { background-color: var(--primary-color); color: white; font-weight: 600; padding: 12px; border-radius: 50px; width: 100%; transition: 0.3s; border: none; margin-top: 10px; }
    .btn-auth:hover { background-color: var(--accent-color); color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3); }
    
    .auth-link { color: var(--accent-color); font-weight: 600; text-decoration: none; cursor: pointer; transition: 0.2s; background: none; border: none; padding: 0; }
    .auth-link:hover { color: #b45309; text-decoration: underline; }
    
    .divider-text { display: flex; align-items: center; text-align: center; color: #94a3b8; font-size: 0.85rem; margin: 20px 0; }
    .divider-text::before, .divider-text::after { content: ''; flex: 1; border-bottom: 1px solid #e2e8f0; }
    
    .otp-input-wrapper { display: flex; gap: 10px; justify-content: space-between; margin-bottom: 20px; }
    .otp-input { width: 50px; height: 55px; text-align: center; font-size: 1.5rem; font-weight: 700; border-radius: 8px; border: 1px solid #cbd5e1; color: var(--primary-color); }
</style>
 
<div class="modal fade auth-modal" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Welcome Back</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form">
                <p class="auth-subtitle text-center">Login to access your orders and wishlist.</p>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Password</label>
                            <button type="button" class="auth-link small" data-bs-target="#forgotModal" data-bs-toggle="modal" data-bs-dismiss="modal">Forgot Password?</button>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-auth">Sign In</button>
                </form>
                <div class="text-center mt-4 small text-muted">
                    New to Divyansh Publication? <button type="button" class="auth-link" data-bs-target="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade auth-modal" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="auth-title w-100 text-center">Join Us</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body auth-form">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Doe">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">+91</span>
                            <input type="tel" name="phone" class="form-control border-start-0" placeholder="9876543210" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
                    </div>
                    <button type="submit" class="btn btn-auth">Create Account</button>
                </form>
                <div class="text-center mt-4 small text-muted">
                    Already have an account? <button type="button" class="auth-link" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign In</button>
                </div>
            </div>
        </div>
    </div>
</div>