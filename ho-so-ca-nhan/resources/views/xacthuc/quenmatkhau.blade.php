<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Hồ sơ cá nhân</title>
    
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
                <h1>Quên mật khẩu</h1>
                <p>Nhập email của bạn để nhận liên kết khôi phục</p>
            </div>

            <!-- Validation Errors Banner -->
            @if ($errors->any() && !$errors->has('email'))
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

            <!-- Status/Success Banner -->
            @if (session('status'))
                <div class="success-banner" style="background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.18); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; animation: fade-in 0.3s ease-out forwards;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; color: #22c55e; flex-shrink: 0; margin-top: 2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="success-banner-content" style="color: #15803d; font-size: 14px; line-height: 1.4;">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- Warning/Debug Link Banner for Local testing -->
            @if (session('warning'))
                <div class="warning-banner" style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.18); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; animation: fade-in 0.3s ease-out forwards;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; color: #f59e0b; flex-shrink: 0; margin-top: 2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="warning-banner-content" style="color: #b45309; font-size: 14px; line-height: 1.4;">
                        {!! session('warning') !!}
                    </div>
                </div>
            @endif

            <form action="{{ url('/quen-mat-khau') }}" method="POST" autocomplete="off">
                @csrf

                <!-- Email Input Group -->
                <div class="form-group">
                    <label for="email" class="form-label">Email tài khoản</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <!-- Envelope icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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
                    <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Nhập địa chỉ email mà bạn đã đăng ký để tìm lại tài khoản.</span>
                    @error('email')
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
                    <span>Gửi yêu cầu khôi phục</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
</body>
</html>
