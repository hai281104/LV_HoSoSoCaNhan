<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hồ sơ cá nhân</title>
    
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
                <h1>Hồ sơ cá nhân</h1>
                <p>Vui lòng đăng nhập hệ thống của bạn</p>
            </div>

            <!-- Validation Errors Banner -->
            @if ($errors->any() && !$errors->has('email') && !$errors->has('mat_khau'))
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

            <!-- Success/Status Banner -->
            @if (session('success') || session('status'))
                <div class="success-banner" style="background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.18); border-radius: 12px; padding: 12px 16px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 10px; animation: fade-in 0.3s ease-out forwards;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; color: #22c55e; flex-shrink: 0; margin-top: 2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="success-banner-content" style="color: #15803d; font-size: 14px; line-height: 1.4;">
                        {{ session('success') ?? session('status') }}
                    </div>
                </div>
            @endif

            <form action="{{ url('/dang-nhap') }}" method="POST" autocomplete="off">
                @csrf

                <!-- Email Input Group -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
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
                            placeholder="ten@vietho.com" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                    </div>
                    <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Nhập địa chỉ email tài khoản đã đăng ký.</span>
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
                    <label for="mat_khau" class="form-label">Mật khẩu</label>
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
                    <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Nhập mật khẩu tài khoản tối thiểu 6 ký tự.</span>
                    @error('mat_khau')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Checkbox Ghi nho -->
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" id="ghi_nho" name="ghi_nho">
                        <span>Ghi nhớ thông tin</span>
                    </label>
                    <a href="{{ route('quen-mat-khau') }}" class="forgot-password-link">Quên mật khẩu?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Đăng nhập</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>

                <!-- Back to Home Page Button -->
                <a href="{{ url('/') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Trở lại trang chủ</span>
                </a>
            </form>

            <div class="login-footer">
                <p style="margin-bottom: 12px;">Chưa có tài khoản? <a href="{{ route('dang-ky') }}">Đăng ký ngay</a></p>
                <p>&copy; 2026 Hệ thống hồ sơ cá nhân. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </div>

    <!-- Password visibility toggle script -->
    <script src="{{ asset('js/xacthuc/dangnhap.js') }}?v={{ time() }}"></script>
</body>
</html>
