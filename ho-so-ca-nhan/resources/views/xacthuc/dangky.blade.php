<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - Hồ sơ cá nhân</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/xacthuc/dangky.css') }}?v={{ time() }}">
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
                <h1>Đăng ký tài khoản</h1>
                <p>Tạo tài khoản hồ sơ cá nhân của bạn</p>
            </div>

            <!-- Validation Errors Banner -->
            @if ($errors->any() && !$errors->has('ho_ten') && !$errors->has('email') && !$errors->has('so_dien_thoai') && !$errors->has('mat_khau') && !$errors->has('mat_khau_xac_nhan') && !$errors->has('dong_y'))
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

            <form action="{{ url('/dang-ky') }}" method="POST" autocomplete="off">
                @csrf

                <div class="form-grid">
                    <!-- Họ tên Input Group -->
                    <div class="form-group form-group-full">
                        <label for="ho_ten" class="form-label">Họ và tên</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <!-- User Card outline icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                id="ho_ten" 
                                name="ho_ten" 
                                class="form-input @error('ho_ten') input-error @enderror" 
                                placeholder="Nguyễn Văn An" 
                                value="{{ old('ho_ten') }}" 
                                required 
                                minlength="2"
                                maxlength="25"
                                pattern="^[a-zA-ZÀ-ỹ\s]+$"
                                title="Họ tên phải từ 2 đến 25 ký tự, không chứa số hay ký tự đặc biệt"
                                autofocus
                            >
                        </div>
                        <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Từ 2 đến 25 ký tự, chỉ gồm chữ cái và khoảng trắng.</span>
                        @error('ho_ten')
                            <div class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Input Group -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <!-- Mail icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input @error('email') input-error @enderror" 
                                placeholder="an@vietho.com" 
                                value="{{ old('email') }}" 
                                required
                            >
                        </div>
                        <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Địa chỉ email hợp lệ (VD: example@gmail.com, tối đa 150 ký tự).</span>
                        @error('email')
                            <div class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Số điện thoại Input Group -->
                    <div class="form-group">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <!-- Phone outline icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </span>
                            <input 
                                type="tel" 
                                id="so_dien_thoai" 
                                name="so_dien_thoai" 
                                class="form-input @error('so_dien_thoai') input-error @enderror" 
                                placeholder="0912345678" 
                                value="{{ old('so_dien_thoai') }}" 
                                required
                                pattern="^0(3|5|7|8|9)[0-9]{8}$"
                                maxlength="10"
                                title="Số điện thoại phải gồm đúng 10 số và bắt đầu bằng 03, 05, 07, 08, 09"
                            >
                        </div>
                        <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Đúng 10 chữ số, bắt đầu bằng 03, 05, 07, 08, 09.</span>
                        @error('so_dien_thoai')
                            <div class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Mật khẩu Input Group -->
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
                                minlength="6"
                                maxlength="20"
                                title="Mật khẩu phải từ 6 đến 20 ký tự, có thể chứa chữ cái, chữ số và ký tự đặc biệt"
                            >
                            <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Hiện mật khẩu">
                                <!-- Eye icon -->
                                <svg class="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Từ 6 đến 20 ký tự, có thể chứa chữ cái, chữ số và ký tự đặc biệt.</span>
                        @error('mat_khau')
                            <div class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Nhập lại mật khẩu Input Group -->
                    <div class="form-group">
                        <label for="mat_khau_xac_nhan" class="form-label">Nhập lại mật khẩu</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <!-- Lock check icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                id="mat_khau_xac_nhan" 
                                name="mat_khau_xac_nhan" 
                                class="form-input @error('mat_khau_xac_nhan') input-error @enderror" 
                                placeholder="••••••••" 
                                required
                                minlength="6"
                                maxlength="20"
                            >
                            <button type="button" class="password-toggle" id="togglePasswordConfirmBtn" aria-label="Hiện mật khẩu">
                                <!-- Eye icon -->
                                <svg class="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 4px; display: block;">* Phải trùng khớp hoàn toàn với mật khẩu đã nhập ở trên.</span>
                        @error('mat_khau_xac_nhan')
                            <div class="error-message">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Agreement Checkbox Group -->
                <div class="form-group">
                    <label class="agreement-group">
                        <input 
                            type="checkbox" 
                            id="dong_y" 
                            name="dong_y" 
                            required 
                            {{ old('dong_y') ? 'checked' : '' }}
                        >
                        <span>Tôi đồng ý với <a href="#" id="openTermsLink">Điều khoản sử dụng và Chính sách bảo mật</a></span>
                    </label>
                    @error('dong_y')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Đăng ký</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </button>

                <!-- Nút trở về đăng nhập -->
                <a href="{{ route('dang-nhap') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Trở về đăng nhập</span>
                </a>
            </form>

            <div class="login-footer">
                <p>&copy; 2026 Hệ thống hồ sơ cá nhân. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="terms-modal-overlay" id="termsModal">
        <div class="terms-modal-card">
            <div class="terms-modal-header">
                <h2>Điều khoản & Chính sách</h2>
                <button type="button" class="terms-modal-close-btn" id="closeTermsModalHeaderBtn" aria-label="Đóng">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="terms-modal-body">
                <div class="terms-section-title">1. Điều khoản sử dụng</div>
                <ul class="terms-list">
                    <li>Cung cấp thông tin đúng sự thật.</li>
                    <li>Không đăng nội dung vi phạm pháp luật.</li>
                    <li>Không sử dụng hệ thống để lừa đảo.</li>
                    <li>Chịu trách nhiệm về dữ liệu đã nhập.</li>
                </ul>

                <div class="terms-section-title">2. Chính sách bảo mật</div>
                <ul class="terms-list">
                    <li>Hệ thống được phép lưu trữ hồ sơ của người dùng.</li>
                    <li>Thông tin cá nhân được bảo vệ.</li>
                    <li>Không chia sẻ cho bên thứ ba nếu chưa được phép.</li>
                    <li>Người dùng có quyền chỉnh sửa hoặc xóa dữ liệu.</li>
                </ul>
            </div>
            <div class="terms-modal-footer">
                <button type="button" class="btn-close-modal" id="closeTermsModalBtn">Đồng ý & Đóng</button>
            </div>
        </div>
    </div>

    <!-- Password visibility toggle script -->
    <script src="{{ asset('js/xacthuc/dangky.js') }}?v={{ time() }}"></script>
</body>
</html>
