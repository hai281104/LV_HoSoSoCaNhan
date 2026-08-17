<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản bị khóa - DPCS</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/xacthuc/bi-khoa.css') }}?v={{ time() }}">
</head>
<body>

    <div class="lock-container">
        <div class="lock-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h1 class="lock-title">Tài khoản đã bị khóa</h1>
        <p class="lock-subtitle">Tài khoản của bạn tạm thời hoặc vĩnh viễn không được quyền truy cập vào hệ thống theo quyết định của ban quản trị.</p>

        <div class="lock-details">
            <div class="detail-row">
                <span class="detail-label">Mã người dùng:</span>
                <span class="detail-value">{{ $nguoiDung->ma_nguoi_dung }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Lý do khóa:</span>
                <span class="detail-value" style="color: #be123c;">{{ $nguoiDung->ly_do_khoa ?? 'Vi phạm quy định sử dụng hệ thống.' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Ngày khóa:</span>
                <span class="detail-value">
                    @if($nguoiDung->ngay_khoa)
                        {{ \Carbon\Carbon::parse($nguoiDung->ngay_khoa)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                    @else
                        {{ now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Thời hạn khóa:</span>
                <span class="detail-value" style="font-weight: 700; color: #be123c;">
                    @if($nguoiDung->khoa_den)
                        Có thời hạn đến {{ \Carbon\Carbon::parse($nguoiDung->khoa_den)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                    @else
                        Khóa vĩnh viễn
                    @endif
                </span>
            </div>
        </div>

        <form action="{{ route('dang-xuat') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout-submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Đăng xuất tài khoản
            </button>
        </form>
    </div>

</body>
</html>
