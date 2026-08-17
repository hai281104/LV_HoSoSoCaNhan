<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý mẫu CV - DPCS Admin</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">
    <style>
        #themModal .modal-card, #suaModal .modal-card {
            max-width: 95vw;
            width: 95vw;
            height: 90vh;
            display: flex;
            flex-direction: column;
            padding: 24px;
            box-sizing: border-box;
        }
        #themModal form, #suaModal form {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
            margin: 0;
        }
        #themModal .modal-body, #suaModal .modal-body {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            flex: 1;
            height: calc(90vh - 150px) !important;
            max-height: none !important;
            overflow: hidden !important;
            padding: 4px;
            box-sizing: border-box;
        }
        .modal-config-sidebar {
            overflow-y: auto;
            padding-right: 8px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            height: 100%;
        }
        .modal-editor-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }
        .editor-wrapper {
            display: flex;
            position: relative;
            flex: 1;
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            overflow: hidden;
        }
        .editor-gutter {
            width: 48px;
            background-color: #1e293b;
            color: #64748b;
            padding: 14px 0;
            text-align: right;
            padding-right: 12px;
            user-select: none;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            border-right: 1px solid #334155;
            overflow: hidden;
            box-sizing: border-box;
        }
        .editor-gutter-line {
            height: 20px;
            line-height: 20px;
            font-weight: 500;
        }
        .code-editor-textarea {
            flex: 1;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            line-height: 20px;
            background-color: transparent;
            color: #f8fafc;
            border: none;
            padding: 14px;
            height: 100%;
            resize: none;
            outline: none;
            tab-size: 4;
            white-space: pre;
            overflow: auto;
            box-sizing: border-box;
            margin: 0;
        }
        .code-editor-textarea:focus {
            outline: none;
        }
        .template-preview-img-td {
            width: 70px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .template-preview-img-td:hover {
            transform: scale(1.05);
        }
        /* Custom styles for quick switch/toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: var(--color-blue);
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        .btn-add-tpl {
            background: linear-gradient(135deg, var(--color-blue), var(--color-purple));
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-family: var(--font-outfit);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(219, 39, 119, 0.25);
            transition: var(--transition-smooth);
            text-decoration: none;
        }
        .btn-add-tpl:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(219, 39, 119, 0.35);
        }
        .btn-add-tpl svg {
            width: 16px;
            height: 16px;
        }
        .img-preview-container {
            margin-top: 10px;
            display: none;
            position: relative;
            width: 120px;
            height: 160px;
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background-color: #f8fafc;
        }
        .img-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .img-preview-container .btn-remove-preview {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(15, 23, 42, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <aside class="sidebar-admin">
        <a href="{{ route('landing') }}" class="sidebar-brand" style="text-decoration: none;">
            <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; flex-shrink: 0; background-color: rgba(255, 255, 255, 0.05); padding: 4px;">
            <div>
                <span class="brand-logo">DPCS <span class="badge-admin">Admin</span></span>
                <span class="brand-sub">Quản trị hệ thống</span>
            </div>
        </a>

        <nav class="sidebar-menu">
            <div class="menu-group">
                <div class="menu-title">Quản trị</div>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                            <span>Tổng quan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.nguoi-dung.index') }}" class="menu-link {{ Route::is('admin.nguoi-dung.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Quản lý người dùng</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.mau-cv.index') }}" class="menu-link {{ Route::is('admin.mau-cv.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Quản lý mẫu CV</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.danh-muc-chuan.index') }}" class="menu-link {{ Route::is('admin.danh-muc-chuan.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            <span>Danh mục chuẩn</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.nhat-ky-hoat-dong.index') }}" class="menu-link {{ Route::is('admin.nhat-ky-hoat-dong.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Nhật ký hoạt động</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.nhat-ky-he-thong.index') }}" class="menu-link {{ Route::is('admin.nhat-ky-he-thong.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Nhật ký hệ thống</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.y-kien-nguoi-dung.index') }}" class="menu-link {{ Route::is('admin.y-kien-nguoi-dung.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>Ý kiến người dùng</span>
                        </a>
                    </li>
                </ul>
            </div>


        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar-sm">
                    @if($anhDaiDien)
                        <img src="{{ asset($anhDaiDien) }}" alt="Avatar">
                    @else
                        <span class="js-avatar-initials-sm">{{ $tenRutGon }}</span>
                    @endif
                </div>
                <div class="user-info-sm">
                    <div class="user-name-sm">{{ $hoTen }}</div>
                    <div class="user-role-sm">{{ $chucDanh }}</div>
                </div>
            </div>
            <form id="logoutForm" action="{{ route('dang-xuat') }}" method="POST" style="display:none;">@csrf</form>
            <button type="button" class="btn-logout" onclick="if (confirm('Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?')) document.getElementById('logoutForm').submit()" title="Đăng xuất">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Đăng xuất</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <h1 class="header-title">Quản lý mẫu CV</h1>
            </div>
        </header>

        <!-- Body Content -->
        <div class="content-body">
            <!-- Success/Error Alerts -->
            @if(session('thanh_cong'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('thanh_cong') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <ul style="list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Search and Action Bar -->
            <div class="search-filter-bar" style="display: flex; justify-content: space-between; align-items: center;">
                <form action="{{ route('admin.mau-cv.index') }}" method="GET" class="search-form" style="display: flex; gap: 12px; align-items: center;">
                    <input type="text" name="search" class="form-input" placeholder="Tìm mã, tên mẫu..." value="{{ $search }}" style="width: 260px;">
                    
                    <select name="trang_thai" class="form-input" style="width: 160px; height: 42px;">
                        <option value="">Tất cả trạng thái</option>
                        <option value="hoat_dong" {{ $trangThai === 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="tam_an" {{ $trangThai === 'tam_an' ? 'selected' : '' }}>Tạm ẩn</option>
                    </select>

                    <button type="submit" class="btn-search" style="height: 42px;">Tìm kiếm</button>
                    @if($search || $trangThai)
                        <a href="{{ route('admin.mau-cv.index') }}" class="btn-cancel" style="display: flex; align-items: center; justify-content: center; height: 42px; text-decoration: none; padding: 0 16px;">Đặt lại</a>
                    @endif
                </form>

                <button type="button" class="btn-add-tpl" onclick="moModalThem()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Thêm mẫu CV</span>
                </button>
            </div>

            <!-- Templates Table -->
            <div class="table-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Ảnh mẫu</th>
                            <th>Mã mẫu CV</th>
                            <th>Tên gọi</th>
                            <th>File view / Phiên bản</th>
                            <th>Kích thước view</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danhSachMauCv as $tpl)
                            <tr>
                                <td>
                                    @if($tpl->anh_xem_truoc)
                                        <img src="{{ asset($tpl->anh_xem_truoc) }}" alt="Preview" class="template-preview-img-td" onclick="moZoomAnh('{{ asset($tpl->anh_xem_truoc) }}', '{{ $tpl->ten_mau }}')">
                                    @else
                                        <div style="width: 70px; height: 90px; border-radius: 6px; border: 1px dashed var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 11px; color: var(--text-muted); background-color: #f8fafc;">Không ảnh</div>
                                    @endif
                                </td>
                                <td style="font-weight: 700;">{{ $tpl->ma_mau_cv }}</td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $tpl->ten_mau }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Tạo lúc: {{ date('d/m/Y H:i', strtotime($tpl->ngay_tao)) }}</div>
                                </td>
                                <td>
                                    <code style="background-color: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 12px; color: #0f172a;">{{ $tpl->duong_dan_file }}</code>
                                    <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Bản: <strong>{{ $tpl->phien_ban ?? 'v1.0' }}</strong></div>
                                </td>
                                <td>
                                    <strong style="color: var(--text-secondary);">
                                        {{ $tpl->kich_thuoc_file ? number_format($tpl->kich_thuoc_file / 1024, 2) . ' KB' : '0.00 KB' }}
                                    </strong>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <label class="switch">
                                            <input type="checkbox" {{ $tpl->trang_thai === 'hoat_dong' ? 'checked' : '' }} onchange="toggleTrangThai({{ $tpl->id }}, this)">
                                            <span class="slider"></span>
                                        </label>
                                        <span id="badge-status-{{ $tpl->id }}" class="badge {{ $tpl->trang_thai === 'hoat_dong' ? 'badge-active' : 'badge-locked' }}">
                                            {{ $tpl->trang_thai === 'hoat_dong' ? 'Hoạt động' : 'Tạm ẩn' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-action btn-unlock" style="background-color: rgba(219,39,119,0.06); border-color: rgba(219,39,119,0.12); color: var(--color-blue);" onclick="moModalSua({{ json_encode($tpl) }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Sửa
                                        </button>
                                        <button type="button" class="btn-action btn-lock" onclick="xacNhanXoa({{ $tpl->id }}, '{{ $tpl->ten_mau }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Không tìm thấy mẫu CV nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination-wrapper">
                    {{ $danhSachMauCv->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Create Template Modal -->
    <div class="modal-overlay" id="themModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Thêm mẫu CV mới</h3>
                <button type="button" class="modal-close" onclick="dongModalThem()">&times;</button>
            </div>
            <form action="{{ route('admin.mau-cv.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Left Sidebar: Configuration -->
                    <div class="modal-config-sidebar">
                        <div class="form-group">
                            <label class="form-label" for="ma_mau_cv_input">Mã mẫu CV <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="ma_mau_cv" id="ma_mau_cv_input" class="form-input" placeholder="VD: template_creative" required>
                            <small style="color: var(--text-muted); font-size: 11px; margin-top: 4px; display: block;">Mã duy nhất, chỉ chứa chữ thường không dấu, số, gạch dưới và gạch ngang.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ten_mau_input">Tên gọi mẫu CV <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="ten_mau" id="ten_mau_input" class="form-input" placeholder="VD: Mẫu sáng tạo chuyên nghiệp" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phien_ban_input">Phiên bản</label>
                            <input type="text" name="phien_ban" id="phien_ban_input" class="form-input" placeholder="VD: v1.0" value="v1.0">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Trạng thái ban đầu</label>
                            <div class="form-radio-group">
                                <label class="form-radio-label">
                                    <input type="radio" name="trang_thai" value="hoat_dong" checked>
                                    Hoạt động
                                </label>
                                <label class="form-radio-label">
                                    <input type="radio" name="trang_thai" value="tam_an">
                                    Tạm ẩn
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="anh_xem_truoc_file_input">Ảnh xem trước <span style="color: #ef4444;">*</span></label>
                            <input type="file" name="anh_xem_truoc_file" id="anh_xem_truoc_file_input" class="form-input" accept="image/*" required onchange="xemTruocAnh(this, 'them-img-preview')">
                            <div class="img-preview-container" id="them-img-preview">
                                <img src="" alt="Preview">
                                <button type="button" class="btn-remove-preview" onclick="xoaFilePreview('anh_xem_truoc_file_input', 'them-img-preview')">&times;</button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel: Code Editor -->
                    <div class="modal-editor-container">
                        <label class="form-label" for="noi_dung_view_input" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span>Mã nguồn Blade View <span style="color: #ef4444;">*</span></span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button type="button" onclick="moModalAiTemplate('noi_dung_view_input', 'them_noi_dung_view_gutter')" style="background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(168,85,247,0.3);">
                                    ✨ Tạo mẫu CV bằng AI
                                </button>
                                <span style="color: var(--text-muted); font-size: 11px; font-weight: normal;">Nhấn Tab để thụt dòng</span>
                            </div>
                        </label>
                        <div class="editor-wrapper">
                            <div class="editor-gutter" id="them_noi_dung_view_gutter"></div>
                            <textarea name="noi_dung_view" id="noi_dung_view_input" class="code-editor-textarea" placeholder="Nhập mã nguồn Blade cho mẫu CV..." wrap="off" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="dongModalThem()">Hủy</button>
                    <button type="submit" class="btn-submit-lock" style="background-color: var(--color-blue); box-shadow: 0 4px 12px rgba(219,39,119,0.25);">Lưu mẫu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Template Modal -->
    <div class="modal-overlay" id="suaModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Chỉnh sửa mẫu CV</h3>
                <button type="button" class="modal-close" onclick="dongModalSua()">&times;</button>
            </div>
            <form id="suaForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Left Sidebar: Configuration -->
                    <div class="modal-config-sidebar">
                        <div class="form-group">
                            <label class="form-label">Mã mẫu CV (Không được sửa)</label>
                            <input type="text" id="sua_ma_mau_cv" class="form-input" style="background-color: #f1f5f9; cursor: not-allowed;" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="sua_ten_mau">Tên gọi mẫu CV <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="ten_mau" id="sua_ten_mau" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="sua_phien_ban">Phiên bản</label>
                            <input type="text" name="phien_ban" id="sua_phien_ban" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Trạng thái</label>
                            <div class="form-radio-group">
                                <label class="form-radio-label">
                                    <input type="radio" name="trang_thai" id="sua_trang_thai_hoat_dong" value="hoat_dong">
                                    Hoạt động
                                </label>
                                <label class="form-radio-label">
                                    <input type="radio" name="trang_thai" id="sua_trang_thai_tam_an" value="tam_an">
                                    Tạm ẩn
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="sua_anh_xem_truoc_file_input">Ảnh xem trước (Để trống nếu giữ nguyên)</label>
                            <input type="file" name="anh_xem_truoc_file" id="sua_anh_xem_truoc_file_input" class="form-input" accept="image/*" onchange="xemTruocAnh(this, 'sua-img-preview')">
                            <div class="img-preview-container" id="sua-img-preview" style="display: block;">
                                <img id="sua_anh_preview_tag" src="" alt="Preview">
                                <button type="button" class="btn-remove-preview" id="sua_btn_remove_preview_tag" onclick="xoaFilePreview('sua_anh_xem_truoc_file_input', 'sua-img-preview', true)">&times;</button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel: Code Editor -->
                    <div class="modal-editor-container">
                        <label class="form-label" for="sua_noi_dung_view" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span>Mã nguồn Blade View <span style="color: #ef4444;">*</span></span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <button type="button" onclick="moModalAiTemplate('sua_noi_dung_view', 'sua_noi_dung_view_gutter')" style="background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(168,85,247,0.3);">
                                    ✨ Tạo mẫu CV bằng AI
                                </button>
                                <span style="color: var(--text-muted); font-size: 11px; font-weight: normal;">Nhấn Tab để thụt dòng</span>
                            </div>
                        </label>
                        <div class="editor-wrapper">
                            <div class="editor-gutter" id="sua_noi_dung_view_gutter"></div>
                            <textarea name="noi_dung_view" id="sua_noi_dung_view" class="code-editor-textarea" wrap="off" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="dongModalSua()">Hủy</button>
                    <button type="submit" class="btn-submit-lock" style="background-color: var(--color-blue); box-shadow: 0 4px 12px rgba(219,39,119,0.25);">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Zoom Preview Modal -->
    <div class="modal-overlay" id="zoomModal" onclick="if(event.target===this) dongZoomAnh()">
        <div style="position: relative; max-width: 90%; max-height: 90%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <button type="button" class="modal-close" onclick="dongZoomAnh()" style="position: absolute; top: -40px; right: 0; color: white;">&times;</button>
            <img id="zoom-img-tag" src="" alt="Zoom Preview" style="max-width: 100%; max-height: 80vh; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); background-color: white;">
            <div id="zoom-img-title" style="color: white; font-weight: 600; margin-top: 12px; font-size: 16px;"></div>
        </div>
    </div>

    <!-- Starter CV Template (escaped for Blade compilation) -->
    <script type="text/template" id="starter-cv-template">@@php
    $order = $tuyChinh['thu_tu_cac_muc'] ?? ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu', 'ky_nang', 'lien_ket', 'so_thich'];
    $visibility = $tuyChinh['hien_thi_cac_muc'] ?? [];
    $accentColor = $tuyChinh['mau_chu_dao'] ?? '#db2777';
    $avatar = $tuyChinh['anh_dai_dien'] ?? ($profileData['nguoiDung']->anh_dai_dien ?? '');
    $user = $profileData['nguoiDung'];
    $noiDungChinhSua = $tuyChinh['noi_dung_chinh_sua'] ?? [];
    $getVal = function($key, $default) use ($noiDungChinhSua) {
        return array_key_exists($key, $noiDungChinhSua) ? $noiDungChinhSua[$key] : $default;
    };
@@endphp

<style>
    :root {
        --primary-color: @{{ $accentColor }};
        --text-dark: #1f2937;
        --text-light: #4b5563;
        --border-light: #e5e7eb;
        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cv-document {
        font-family: var(--font-sans);
        color: var(--text-dark);
        line-height: 1.5;
        font-size: 14px;
        background-color: #fff;
        padding: 24px;
    }

    .cv-header {
        display: flex;
        gap: 24px;
        border-bottom: 3px solid var(--primary-color);
        padding-bottom: 16px;
        margin-bottom: 24px;
        align-items: center;
    }

    .cv-header-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
        flex-shrink: 0;
        background-color: #f3f4f6;
    }

    .cv-header-avatar-initials {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 2px solid var(--primary-color);
        background-color: var(--primary-color);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .cv-header-info {
        flex: 1;
    }

    .cv-name {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary-color);
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-light);
        margin: 0 0 10px 0;
    }

    .cv-contact-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px 16px;
        font-size: 12.5px;
        color: var(--text-light);
    }

    .cv-section {
        margin-bottom: 22px;
    }

    .cv-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 4px;
        margin: 0 0 12px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-intro-text {
        font-size: 13px;
        color: var(--text-light);
        text-align: justify;
        white-space: pre-line;
        margin: 0;
    }

    .cv-timeline-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .cv-timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2px;
    }

    .cv-timeline-title {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
        margin: 0;
    }

    .cv-timeline-subtitle {
        font-weight: 600;
        font-size: 12.5px;
        color: var(--text-light);
        font-style: italic;
    }

    .cv-timeline-date {
        font-size: 12px;
        color: var(--primary-color);
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .cv-timeline-desc {
        font-size: 12.5px;
        color: var(--text-light);
        margin: 4px 0 0 0;
        white-space: pre-wrap;
    }

    .cv-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .cv-pill {
        background-color: #f3f4f6;
        color: var(--text-dark);
        font-size: 12px;
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid var(--border-light);
    }

    .cv-links-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px 16px;
    }

    .cv-link-card a {
        color: var(--primary-color);
        text-decoration: none;
    }
</style>

<div class="cv-document">
    <div class="cv-header">
        @@if($avatar)
            <img src="@{{ str_starts_with($avatar, 'http') ? $avatar : asset($avatar) }}" alt="Avatar" class="cv-header-avatar">
        @@else
            <div class="cv-header-avatar-initials">
                @@php
                    $tenRut = 'ND';
                    if ($user->ho_ten) {
                        $cacTu = explode(' ', trim($user->ho_ten));
                        $tenRut = count($cacTu) >= 2 
                            ? mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1) 
                            : mb_substr($user->ho_ten, 0, 2);
                        $tenRut = mb_strtoupper($tenRut);
                    }
                @@endphp
                @{{ $tenRut }}
            </div>
        @@endif

        <div class="cv-header-info">
            <h1 class="cv-name" data-edit-key="ho_ten">@{{ $getVal('ho_ten', $user->ho_ten) }}</h1>
            <h2 class="cv-title" data-edit-key="chuc_danh">@{{ $getVal('chuc_danh', $user->chuc_danh ?: 'Chuyên viên / Lập trình viên') }}</h2>
            
            <div class="cv-contact-grid">
                <div class="cv-contact-item">
                    SĐT: <span data-edit-key="so_dien_thoai">@{{ $getVal('so_dien_thoai', $user->so_dien_thoai) }}</span>
                </div>
                <div class="cv-contact-item">
                    Email: <span data-edit-key="email">@{{ $getVal('email', $user->email) }}</span>
                </div>
                <div class="cv-contact-item">
                    Địa chỉ: <span data-edit-key="dia_chi">@{{ $getVal('dia_chi', $user->dia_chi ?: 'Hà Nội, Việt Nam') }}</span>
                </div>
                @@if($user->ngay_sinh)
                    <div class="cv-contact-item">
                        Ngày sinh: <span data-edit-key="ngay_sinh">@{{ $getVal('ngay_sinh', date('d/m/Y', strtotime($user->ngay_sinh))) }}</span>
                    </div>
                @@endif
            </div>
        </div>
    </div>

    @@if($user->gioi_thieu)
        <div class="cv-section">
            <h3 class="cv-section-title" data-edit-key="section_title.gioi_thieu">@{{ $getVal('section_title.gioi_thieu', 'Giới thiệu bản thân') }}</h3>
            <p class="cv-intro-text" data-edit-key="gioi_thieu">@{{ $getVal('gioi_thieu', $user->gioi_thieu) }}</p>
        </div>
    @@endif

    @@foreach($order as $section)
        @@if(isset($visibility[$section]) && $visibility[$section])
            
            @@if($section === 'hoc_van' && $profileData['hocVan']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.hoc_van">@{{ $getVal('section_title.hoc_van', 'Học vấn & Bằng cấp') }}</h3>
                    <div class="cv-timeline-list">
                        @@foreach($profileData['hocVan'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="hoc_van.@{{ $item->id }}.tieu_de">@{{ $getVal("hoc_van.{$item->id}.tieu_de", $item->tieu_de) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="hoc_van.@{{ $item->id }}.ten_truong">@{{ $getVal("hoc_van.{$item->id}.ten_truong", $item->ten_truong) }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="hoc_van.@{{ $item->id }}.date">
                                        @{{ $getVal("hoc_van.{$item->id}.date", $item->nam_bat_dau . ' - ' . ($item->trang_thai === 'dang_hoc' || is_null($item->nam_ket_thuc) ? 'Hiện tại' : $item->nam_ket_thuc)) }}
                                    </div>
                                </div>
                                @@if($item->mo_ta)
                                    <p class="cv-timeline-desc" data-edit-key="hoc_van.@{{ $item->id }}.mo_ta">@{{ $getVal("hoc_van.{$item->id}.mo_ta", $item->mo_ta) }}</p>
                                @@endif
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'kinh_nghiem' && $profileData['kinhNghiem']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.kinh_nghiem">@{{ $getVal('section_title.kinh_nghiem', 'Kinh nghiệm làm việc') }}</h3>
                    <div class="cv-timeline-list">
                        @@foreach($profileData['kinhNghiem'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="kinh_nghiem.@{{ $item->id }}.vi_tri_cong_viec">@{{ $getVal("kinh_nghiem.{$item->id}.vi_tri_cong_viec", $item->vi_tri_cong_viec) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="kinh_nghiem.@{{ $item->id }}.ten_cong_ty">@{{ $getVal("kinh_nghiem.{$item->id}.ten_cong_ty", $item->ten_cong_ty) }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="kinh_nghiem.@{{ $item->id }}.date">
                                        @{{ $getVal("kinh_nghiem.{$item->id}.date", date('m/Y', strtotime($item->ngay_bat_dau)) . ' - ' . ($item->dang_lam_viec ? 'Hiện tại' : ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại'))) }}
                                    </div>
                                </div>
                                @@if($item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc" data-edit-key="kinh_nghiem.@{{ $item->id }}.mo_ta_chi_tiet">@{{ $getVal("kinh_nghiem.{$item->id}.mo_ta_chi_tiet", $item->mo_ta_chi_tiet) }}</p>
                                @@endif
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'du_an' && $profileData['duAn']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.du_an">@{{ $getVal('section_title.du_an', 'Dự án nổi bật') }}</h3>
                    <div class="cv-timeline-list">
                        @@foreach($profileData['duAn'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="du_an.@{{ $item->id }}.ten_du_an">@{{ $getVal("du_an.{$item->id}.ten_du_an", $item->ten_du_an) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="du_an.@{{ $item->id }}.vai_tro">Vai trò: @{{ $getVal("du_an.{$item->id}.vai_tro", $item->vai_tro ?: 'Thành viên') }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="du_an.@{{ $item->id }}.date">
                                        @{{ $getVal("du_an.{$item->id}.date", date('m/Y', strtotime($item->ngay_bat_dau)) . ' - ' . ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại')) }}
                                    </div>
                                </div>
                                @@if(isset($item->mo_ta_chi_tiet) && $item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc" data-edit-key="du_an.@{{ $item->id }}.mo_ta_chi_tiet">@{{ $getVal("du_an.{$item->id}.mo_ta_chi_tiet", $item->mo_ta_chi_tiet) }}</p>
                                @@endif
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'chung_chi' && $profileData['chungChi']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.chung_chi">@{{ $getVal('section_title.chung_chi', 'Chứng chỉ / Chứng nhận') }}</h3>
                    <div class="cv-timeline-list">
                        @@foreach($profileData['chungChi'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">@{{ $item->ten_chung_chi }}</h4>
                                        <span class="cv-timeline-subtitle">Tổ chức cấp: @{{ $item->to_chuc_cap }}</span>
                                    </div>
                                    <div class="cv-timeline-date">
                                        @{{ date('m/Y', strtotime($item->ngay_cap)) }}
                                    </div>
                                </div>
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'thanh_tuu' && $profileData['thanhTuu']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.thanh_tuu">@{{ $getVal('section_title.thanh_tuu', 'Thành tựu & Giải thưởng') }}</h3>
                    <div class="cv-timeline-list">
                        @@foreach($profileData['thanhTuu'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4>@{{ $item->ten_thanh_tuu }}</h4>
                                    </div>
                                    <div class="cv-timeline-date">
                                        @{{ $item->thoi_gian }}
                                    </div>
                                </div>
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'ky_nang' && (count($profileData['ngonNgu']) > 0 || count($profileData['kyNang']) > 0))
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.ky_nang">@{{ $getVal('section_title.ky_nang', 'Kỹ năng chuyên môn') }}</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @@if(count($profileData['ngonNgu']) > 0)
                            <div>
                                <h5 style="margin: 0 0 6px 0; font-size: 13px; font-weight: 600;">Kỹ năng chuyên môn:</h5>
                                <div class="cv-pill-container">
                                    @@foreach($profileData['ngonNgu'] as $lang)
                                        <span class="cv-pill">@{{ $lang }}</span>
                                    @@endforeach
                                </div>
                            </div>
                        @@endif

                        @@if(count($profileData['kyNang']) > 0)
                            <div>
                                <h5 style="margin: 0 0 6px 0; font-size: 13px; font-weight: 600;">Kỹ năng mềm / Khác:</h5>
                                <div class="cv-pill-container">
                                    @@foreach($profileData['kyNang'] as $skill)
                                        <span class="cv-pill">@{{ $skill }}</span>
                                    @@endforeach
                                </div>
                            </div>
                        @@endif
                    </div>
                </div>
            @@endif

            @@if($section === 'lien_ket' && $profileData['lienKetMxh']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.lien_ket">@{{ $getVal('section_title.lien_ket', 'Liên kết & Mạng xã hội') }}</h3>
                    <div class="cv-links-list">
                        @@foreach($profileData['lienKetMxh'] as $item)
                            <div class="cv-link-card">
                                <strong>@{{ $item->ten_nen_tang }}:</strong>
                                <a href="@{{ $item->duong_dan }}" target="_blank">@{{ $item->duong_dan }}</a>
                            </div>
                        @@endforeach
                    </div>
                </div>
            @@endif

            @@if($section === 'so_thich' && $user->so_thich)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.so_thich">@{{ $getVal('section_title.so_thich', 'Sở thích') }}</h3>
                    <p class="cv-intro-text">@{{ $user->so_thich }}</p>
                </div>
            @@endif

        @@endif
    @@endforeach
</div></script>

    <script>
        const STARTER_TEMPLATE = document.getElementById('starter-cv-template').innerHTML.trim();
        let updateThemLines, updateSuaLines;

        function initCodeEditor(textareaId, gutterId) {
            const textarea = document.getElementById(textareaId);
            const gutter = document.getElementById(gutterId);

            if (!textarea || !gutter) return null;

            function updateLines() {
                const lines = textarea.value.split('\n');
                let html = '';
                for (let i = 1; i <= lines.length; i++) {
                    html += `<div class="editor-gutter-line">${i}</div>`;
                }
                gutter.innerHTML = html;
            }

            // Sync scrolling
            textarea.addEventListener('scroll', function() {
                gutter.scrollTop = textarea.scrollTop;
            });

            // Update lines on typing, pasting, or backspacing
            textarea.addEventListener('input', updateLines);
            textarea.addEventListener('keyup', updateLines);

            // Tab key functionality
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + "    " + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 4;
                    updateLines();
                }
            });

            return updateLines;
        }

        // Initialize Tab key & gutter support on DOM load
        document.addEventListener('DOMContentLoaded', function() {
            updateThemLines = initCodeEditor('noi_dung_view_input', 'them_noi_dung_view_gutter');
            updateSuaLines = initCodeEditor('sua_noi_dung_view', 'sua_noi_dung_view_gutter');
        });

        // Modal Them
        function moModalThem() {
            document.getElementById('themModal').classList.add('active');
            document.getElementById('noi_dung_view_input').value = STARTER_TEMPLATE;
            if (updateThemLines) {
                updateThemLines();
            }
        }
        function dongModalThem() {
            document.getElementById('themModal').classList.remove('active');
            document.getElementById('ma_mau_cv_input').value = '';
            document.getElementById('ten_mau_input').value = '';
            document.getElementById('phien_ban_input').value = 'v1.0';
            document.getElementById('noi_dung_view_input').value = '';
            document.querySelector('input[name="trang_thai"][value="hoat_dong"]').checked = true;
            xoaFilePreview('anh_xem_truoc_file_input', 'them-img-preview');
        }

        // Modal Sua
        let backupSuaAnhSrc = '';
        function moModalSua(tpl) {
            const form = document.getElementById('suaForm');
            form.action = "{{ route('admin.mau-cv.update', ['id' => ':id']) }}".replace(':id', tpl.id);
            
            document.getElementById('sua_ma_mau_cv').value = tpl.ma_mau_cv;
            document.getElementById('sua_ten_mau').value = tpl.ten_mau;
            document.getElementById('sua_phien_ban').value = tpl.phien_ban || 'v1.0';
            document.getElementById('sua_noi_dung_view').value = tpl.noi_dung_view || '';

            if (updateSuaLines) {
                updateSuaLines();
            }

            if (tpl.trang_thai === 'hoat_dong') {
                document.getElementById('sua_trang_thai_hoat_dong').checked = true;
            } else {
                document.getElementById('sua_trang_thai_tam_an').checked = true;
            }

            const previewContainer = document.getElementById('sua-img-preview');
            const previewTag = document.getElementById('sua_anh_preview_tag');
            const removeBtn = document.getElementById('sua_btn_remove_preview_tag');

            if (tpl.anh_xem_truoc) {
                previewContainer.style.display = 'block';
                previewTag.src = "{{ asset('/') }}" + tpl.anh_xem_truoc;
                backupSuaAnhSrc = previewTag.src;
                removeBtn.style.display = 'none'; // Keep existing image from DB
            } else {
                previewContainer.style.display = 'none';
                previewTag.src = '';
                backupSuaAnhSrc = '';
            }

            document.getElementById('suaModal').classList.add('active');
        }
        
        function dongModalSua() {
            document.getElementById('suaModal').classList.remove('active');
            document.getElementById('sua_anh_xem_truoc_file_input').value = '';
            document.getElementById('sua_noi_dung_view').value = '';
        }

        // Image file upload preview
        function xemTruocAnh(input, containerId) {
            const container = document.getElementById(containerId);
            const img = container.querySelector('img');
            const removeBtn = container.querySelector('.btn-remove-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.style.display = 'block';
                    if (removeBtn) removeBtn.style.display = 'flex';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function xoaFilePreview(inputId, containerId, isEdit = false) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);
            const img = container.querySelector('img');
            const removeBtn = container.querySelector('.btn-remove-preview');

            input.value = '';
            
            if (isEdit && backupSuaAnhSrc) {
                img.src = backupSuaAnhSrc;
                if (removeBtn) removeBtn.style.display = 'none';
            } else {
                img.src = '';
                container.style.display = 'none';
            }
        }

        // Zoom Image Modal
        function moZoomAnh(src, title) {
            document.getElementById('zoom-img-tag').src = src;
            document.getElementById('zoom-img-title').innerText = title;
            document.getElementById('zoomModal').classList.add('active');
        }
        function dongZoomAnh() {
            document.getElementById('zoomModal').classList.remove('active');
        }

        // Action: Toggle Status via AJAX
        function toggleTrangThai(id, checkbox) {
            const isChecked = checkbox.checked;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const badge = document.getElementById('badge-status-' + id);
            
            // Temporary disable until server response
            checkbox.disabled = true;

            fetch("{{ route('admin.mau-cv.doi-trang-thai', ['id' => ':id']) }}".replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                checkbox.disabled = false;
                if (data.thanh_cong) {
                    if (data.trang_thai_moi === 'hoat_dong') {
                        badge.className = 'badge badge-active';
                        badge.innerText = 'Hoạt động';
                        checkbox.checked = true;
                    } else {
                        badge.className = 'badge badge-locked';
                        badge.innerText = 'Tạm ẩn';
                        checkbox.checked = false;
                    }
                } else {
                    checkbox.checked = !isChecked; // Revert
                    alert(data.thong_bao || 'Có lỗi xảy ra!');
                }
            })
            .catch(err => {
                checkbox.disabled = false;
                checkbox.checked = !isChecked; // Revert
                console.error(err);
                alert('Không thể kết nối đến máy chủ.');
            });
        }

        // Action: Soft Delete CV template
        function xacNhanXoa(id, name) {
            if (!confirm('Bạn có chắc chắn muốn xóa mẫu CV "' + name + '" không? Người dùng sẽ không thể chọn mẫu này để tạo CV nữa.')) {
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.mau-cv.destroy', ['id' => ':id']) }}".replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.thanh_cong) {
                    alert(data.thong_bao);
                    window.location.reload();
                } else {
                    alert(data.thong_bao || 'Có lỗi xảy ra!');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Không thể kết nối đến máy chủ.');
            });
        }

        // Close modal when clicking outside card
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(event) {
                if (event.target === this) {
                    if (this.id === 'themModal') dongModalThem();
                    else if (this.id === 'suaModal') dongModalSua();
                    else if (this.id === 'zoomModal') dongZoomAnh();
                    else if (this.id === 'modal-ai-cv-template') dongModalAiTemplate();
                }
            });
        });

        // AI CV Template Generation Logic
        let currentTargetEditorId = null;
        let currentTargetGutterId = null;

        function moModalAiTemplate(editorId, gutterId) {
            currentTargetEditorId = editorId;
            currentTargetGutterId = gutterId;
            document.getElementById('ai_template_prompt').value = '';
            document.getElementById('ai_template_image').value = '';
            document.getElementById('ai_image_preview_box').style.display = 'none';
            document.getElementById('ai_template_status').style.display = 'none';
            document.getElementById('modal-ai-cv-template').classList.add('active');
        }

        function dongModalAiTemplate() {
            document.getElementById('modal-ai-cv-template').classList.remove('active');
        }

        function xemTruocAnhAi(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('ai_image_preview_img').src = e.target.result;
                    document.getElementById('ai_image_preview_box').style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function xoaAnhAi() {
            document.getElementById('ai_template_image').value = '';
            document.getElementById('ai_image_preview_box').style.display = 'none';
        }

        function xuLyTaoAiTemplate() {
            const promptInput = document.getElementById('ai_template_prompt');
            const fileInput = document.getElementById('ai_template_image');
            const prompt = promptInput.value.trim();
            const statusBox = document.getElementById('ai_template_status');
            const submitBtn = document.getElementById('btn_submit_ai_template');

            if (!prompt && (!fileInput.files || fileInput.files.length === 0)) {
                statusBox.style.display = 'block';
                statusBox.style.background = '#fef2f2';
                statusBox.style.color = '#ef4444';
                statusBox.innerText = 'Vui lòng nhập mô tả hoặc tải lên 1 hình ảnh mẫu CV!';
                return;
            }

            const formData = new FormData();
            formData.append('prompt', prompt);
            if (fileInput.files && fileInput.files[0]) {
                formData.append('mau_anh_file', fileInput.files[0]);
            }

            submitBtn.disabled = true;
            submitBtn.innerText = '⏳ AI đang phân tích & sinh mã Blade...';
            statusBox.style.display = 'block';
            statusBox.style.background = '#f0fdf4';
            statusBox.style.color = '#166534';
            statusBox.innerText = fileInput.files && fileInput.files[0] 
                ? 'AI (Gemini) đang phân tích bố cục, màu sắc từ hình ảnh mẫu của bạn...'
                : 'AI đang khởi tạo cấu trúc mã Blade View theo yêu cầu...';

            fetch('{{ route("admin.mau-cv.generate-ai") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerText = '✨ Tạo mã Blade ngay';

                if (data.thanh_cong && data.blade_code) {
                    const editor = document.getElementById(currentTargetEditorId);
                    if (editor) {
                        editor.value = data.blade_code;
                        editor.dispatchEvent(new Event('input'));
                    }
                    dongModalAiTemplate();
                } else {
                    statusBox.style.background = '#fef2f2';
                    statusBox.style.color = '#ef4444';
                    statusBox.innerText = '❌ ' + (data.thong_bao || 'Lỗi sinh mã từ AI.');
                }
            })
            .catch(err => {
                console.error(err);
                submitBtn.disabled = false;
                submitBtn.innerText = '✨ Tạo mã Blade ngay';
                statusBox.style.background = '#fef2f2';
                statusBox.style.color = '#ef4444';
                statusBox.innerText = '❌ Lỗi hệ thống: Không thể kết nối tới dịch vụ AI.';
            });
        }
    </script>

    <!-- Modal: Tạo mẫu CV bằng AI -->
    <div class="modal-overlay" id="modal-ai-cv-template" style="z-index: 10050;">
        <div class="modal-card" style="max-width: 580px;">
            <div class="modal-header">
                <h3 class="modal-title" style="display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px; color: #a855f7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Tạo mẫu CV bằng AI (Hỗ trợ đọc Ảnh mẫu)
                </h3>
                <button type="button" class="modal-close" onclick="dongModalAiTemplate()">&times;</button>
            </div>
            <div class="modal-body" style="display: block; padding: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label class="form-label">Tải lên ảnh CV mẫu (Tùy chọn - AI sẽ phân tích bố cục từ ảnh)</label>
                    <input type="file" id="ai_template_image" class="form-input" accept="image/*" onchange="xemTruocAnhAi(this)">
                    <div id="ai_image_preview_box" style="display: none; margin-top: 10px; position: relative;">
                        <img id="ai_image_preview_img" src="" style="max-height: 140px; border-radius: 8px; border: 1px solid #cbd5e1; object-fit: contain;">
                        <button type="button" onclick="xoaAnhAi()" style="position: absolute; top: -6px; right: -6px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">&times;</button>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label class="form-label">Mô tả thêm phong cách & bố cục mong muốn</label>
                    <textarea id="ai_template_prompt" class="form-input" rows="3" style="height: auto; resize: vertical;" placeholder="VD: Mô phỏng theo thiết kế trong ảnh nhưng đổi tông màu chủ đạo thành xanh dương và làm nổi bật phần Kinh nghiệm..."></textarea>
                </div>
                <div id="ai_template_status" style="display: none; padding: 10px; border-radius: 8px; font-size: 13px; margin-top: 10px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="dongModalAiTemplate()">Hủy bỏ</button>
                <button type="button" id="btn_submit_ai_template" onclick="xuLyTaoAiTemplate()" class="btn-submit-lock" style="background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border: none; color: white;">
                    ✨ Phân tích & Tạo mã Blade
                </button>
            </div>
        </div>
    </div>
</body>
</html>
