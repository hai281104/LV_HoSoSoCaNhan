<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khôi phục mật khẩu - DPCS</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .note {
            font-size: 13px;
            color: #64748b;
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Khôi phục mật khẩu</h1>
        </div>
        <div class="content">
            <p>Xin chào,</p>
            <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn trên hệ thống <strong>Hồ sơ cá nhân (DPCS)</strong>.</p>
            <p>Vui lòng nhấn vào nút dưới đây để tiến hành đặt lại mật khẩu mới. Liên kết này sẽ hết hạn sau 60 phút:</p>
            <div class="button-container">
                <a href="{{ route('password.reset', ['token' => $token]) . '?email=' . urlencode($email) }}" class="btn">Đặt lại mật khẩu</a>
            </div>
            <p>Nếu bạn không gửi yêu cầu này, vui lòng bỏ qua email này. Tài khoản của bạn vẫn được bảo mật an toàn.</p>
            <div class="note">
                <p>Nếu nút trên không hoạt động, bạn có thể sao chép và dán đường dẫn sau vào trình duyệt:</p>
                <p style="word-break: break-all; color: #2563eb;">{{ route('password.reset', ['token' => $token]) . '?email=' . urlencode($email) }}</p>
            </div>
        </div>
        <div class="footer">
            <p>© 2026 Hệ thống hồ sơ cá nhân (DPCS). Bảo lưu mọi quyền.</p>
        </div>
    </div>
</body>
</html>
