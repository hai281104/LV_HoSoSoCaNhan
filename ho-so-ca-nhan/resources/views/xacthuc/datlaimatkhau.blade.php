<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Hồ sơ cá nhân</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/xacthuc/dangnhap.css') }}?v={{ time() }}">
</head>
<body>

    <!-- Circles Background -->
    <div class="decor-circle circle-1"></div>
    <div class="decor-circle circle-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-area">
                <div class="logo-icon" style="background: transparent; box-shadow: none; border-radius: 0;">
                    <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h1>Đặt lại mật khẩu</h1>
                <p>Thiết lập mật khẩu mới cho tài khoản của bạn</p>
            </div>

            <!-- Validation Errors Banner -->
            @if ($errors->any() && !$errors->has('email') && !$errors->has('mat_khau') && !$errors->has('mat_khau_xac_nhan'))
                <div class="alert-banner">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="alert-banner-content">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Input Group (Read-only) -->
                <div class="form-group">
                    <label for="email" class="form-label">Email tài khoản</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <!-- User outline icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input @error('email') input-error @enderror" 
                            value="{{ $email }}" 
                            readonly 
                            style="background: rgba(241, 245, 249, 0.4); cursor: not-allowed; color: #64748b;"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Input Group -->
                <div class="form-group">
                    <label for="mat_khau" class="form-label">Mật khẩu mới</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <!-- Lock icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="mat_khau" 
                            name="mat_khau" 
                            class="form-input @error('mat_khau') input-error @enderror" 
                            placeholder="••••••••" 
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Hiện mật khẩu">
                            <!-- Eye outline icon -->
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Mật khẩu mới từ 6 đến 20 ký tự.</span>
                    @error('mat_khau')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password Input Group -->
                <div class="form-group">
                    <label for="mat_khau_xac_nhan" class="form-label">Xác nhận mật khẩu mới</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <!-- Lock icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="mat_khau_xac_nhan" 
                            name="mat_khau_xac_nhan" 
                            class="form-input @error('mat_khau_xac_nhan') input-error @enderror" 
                            placeholder="••••••••" 
                            required
                        >
                        <button type="button" class="password-toggle" id="toggleConfirmPasswordBtn" aria-label="Hiện mật khẩu">
                            <!-- Eye outline icon -->
                            <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('mat_khau_xac_nhan')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" style="margin-top: 10px;">
                    <span>Lưu mật khẩu mới</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>

                <!-- Back to Login Button -->
                <a href="{{ route('dang-nhap') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Quay lại đăng nhập</span>
                </a>
            </form>

            <div class="login-footer">
                <p>&copy; 2026 Hệ thống hồ sơ cá nhân. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle for New Password
            const passwordInput = document.getElementById('mat_khau');
            const toggleButton = document.getElementById('togglePasswordBtn');
            const eyeIcon = document.getElementById('eyeIcon');

            toggleButton.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                    toggleButton.setAttribute('aria-label', 'Ẩn mật khẩu');
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                    toggleButton.setAttribute('aria-label', 'Hiện mật khẩu');
                }
            });

            // Toggle for Confirm Password
            const confirmInput = document.getElementById('mat_khau_xac_nhan');
            const toggleConfirmButton = document.getElementById('toggleConfirmPasswordBtn');
            const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

            toggleConfirmButton.addEventListener('click', function() {
                const isPassword = confirmInput.getAttribute('type') === 'password';
                confirmInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    eyeConfirmIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    `;
                    toggleConfirmButton.setAttribute('aria-label', 'Ẩn mật khẩu');
                } else {
                    eyeConfirmIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                    toggleConfirmButton.setAttribute('aria-label', 'Hiện mật khẩu');
                }
            });
        });
    </script>
</body>
</html>
