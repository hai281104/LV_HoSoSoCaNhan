<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Duyệt dịch vụ - DPCS Admin</title>
    <meta name="description" content="Quản trị viên duyệt dịch vụ cá nhân của người dùng trên hệ thống DPCS.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">

    <style>
        /* ─── Service Review Styles ─── */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 18px;
        }

        .service-card {
            background: var(--card-bg, #fff);
            border: 1.5px solid var(--border-color, #e2e8f0);
            border-radius: 14px;
            padding: 18px 20px 16px;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.2s, border-color 0.2s;
        }
        .service-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.10);
            transform: translateY(-2px);
            border-color: #6366f1;
        }

        .service-card-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .service-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .service-info { flex: 1; min-width: 0; }
        .service-name {
            font-size: 14.5px; font-weight: 700;
            color: var(--text-primary, #1e293b);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .service-category { font-size: 11.5px; color: var(--text-muted, #94a3b8); margin-top: 2px; }

        .service-user-row {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px;
            background: var(--bg-subtle, #f8fafc);
            border-radius: 8px;
            margin-top: 12px;
        }
        .user-avatar-tiny {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #db2777, #f43f5e);
            color: #fff; font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden;
        }
        .user-avatar-tiny img { width: 100%; height: 100%; object-fit: cover; }
        .user-detail-sm .user-name-sm { font-size: 12.5px; font-weight: 600; color: var(--text-primary,#1e293b); }
        .user-detail-sm .user-email-sm { font-size: 11px; color: var(--text-muted,#94a3b8); }

        .service-desc-preview {
            font-size: 12.5px; color: var(--text-secondary, #64748b);
            line-height: 1.5; margin-top: 10px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .count-badge {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 6px;
            border-radius: 10px; font-size: 11px; font-weight: 700;
            background: #ef4444; color: #fff; margin-left: 6px;
        }
        .count-badge.green { background: #10b981; }
        .count-badge.gray  { background: #94a3b8; }

        .empty-state {
            text-align: center; padding: 60px 20px;
            color: var(--text-muted, #94a3b8);
        }
        .empty-state svg { width: 56px; height: 56px; margin: 0 auto 16px; opacity: 0.4; display: block; }
        .empty-state p { font-size: 15px; }

        .hint-click {
            font-size: 11.5px; color: #94a3b8;
            text-align: center; margin-top: 10px;
            display: flex; align-items: center; justify-content: center; gap: 4px;
        }
        .hint-click svg { width: 13px; height: 13px; }

        /* ─── Modal Chi tiết ─── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 1000;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: opacity 0.25s;
            padding: 20px;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }

        .modal-panel {
            background: #fff;
            border-radius: 18px;
            width: 100%; max-width: 920px;
            max-height: 95vh;
            overflow: hidden;
            display: flex; flex-direction: column;
            box-shadow: 0 24px 64px rgba(0,0,0,0.20);
            transform: translateY(24px) scale(0.97);
            transition: transform 0.3s;
        }
        .modal-overlay.active .modal-panel { transform: translateY(0) scale(1); }

        .detail-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
        }
        .detail-header-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .detail-icon-wrap {
            width: 44px; height: 44px; border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 22px;
        }
        .detail-title { font-size: 16px; font-weight: 700; color: #1e293b; }
        .detail-sub { font-size: 12px; color: #94a3b8; margin-top: 2px; }
        .modal-close-btn {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; padding: 4px; border-radius: 6px;
            transition: color 0.15s, background 0.15s; flex-shrink: 0;
        }
        .modal-close-btn:hover { color: #1e293b; background: #f1f5f9; }

        .detail-body {
            flex: 1; overflow-y: auto; padding: 22px 24px;
            display: flex; flex-direction: column; gap: 18px;
        }

        .detail-provider-row {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px;
            background: #f8fafc; border-radius: 10px;
            border: 1px solid #e8edf5;
        }
        .detail-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: linear-gradient(135deg, #db2777, #f43f5e);
            color: #fff; font-size: 14px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; overflow: hidden; border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .detail-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .detail-section-label {
            font-size: 11.5px; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-desc-box {
            background: #f8fafc; border: 1px solid #e8edf5;
            border-radius: 10px; padding: 14px 16px;
            font-size: 13.5px; color: #334155; line-height: 1.65;
            white-space: pre-line; word-break: break-word;
        }

        .detail-contact-row {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 0;
        }
        .detail-contact-row + .detail-contact-row {
            border-top: 1px solid #f1f5f9;
        }
        .detail-contact-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .detail-contact-icon.zalo { background: #e0f2fe; color: #0369a1; }
        .detail-contact-icon.gmail { background: #fee2e2; color: #dc2626; }
        .detail-contact-icon svg { width: 16px; height: 16px; }
        .detail-contact-label { font-size: 11.5px; color: #94a3b8; }
        .detail-contact-val { font-size: 13.5px; font-weight: 600; color: #1e293b; }
        .detail-contact-val a { color: #6366f1; text-decoration: none; }
        .detail-contact-val a:hover { text-decoration: underline; }

        .detail-cv-box {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px;
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
        }
        .detail-cv-icon {
            width: 36px; height: 36px; border-radius: 8px;
            background: #dcfce7; color: #16a34a;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .detail-cv-icon svg { width: 18px; height: 18px; }
        .detail-cv-name { font-size: 13px; font-weight: 600; color: #15803d; }
        .btn-view-cv-detail {
            margin-left: auto; flex-shrink: 0;
            padding: 6px 14px;
            background: #16a34a; color: #fff;
            border: none; border-radius: 7px;
            font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn-view-cv-detail:hover { background: #15803d; }

        .detail-meta-row {
            display: flex; gap: 16px; flex-wrap: wrap;
            padding-top: 14px; border-top: 1px solid #f1f5f9;
            font-size: 12px; color: #94a3b8;
        }

        .detail-footer {
            padding: 16px 24px;
            border-top: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .detail-footer-status { font-size: 12.5px; font-weight: 600; }

        .btn-approve-detail {
            padding: 9px 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-approve-detail:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-reject-detail {
            padding: 9px 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff; border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-reject-detail:hover { opacity: 0.88; transform: translateY(-1px); }

        /* Toast */
        .toast-container { position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px; }
        .toast { background:#1e293b;color:#fff;padding:12px 18px;border-radius:10px;font-size:13.5px;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,0.2);opacity:0;transform:translateX(40px);transition:all 0.3s;max-width:320px; }
        .toast.show { opacity:1;transform:translateX(0); }
        .toast.success { border-left:4px solid #10b981; }
        .toast.error   { border-left:4px solid #ef4444; }

        /* Overrides & custom filter styles */
        .search-form {
            width: auto !important;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-select {
            background-color: #ffffff;
            border: 1px solid var(--border-color, #ffe4e6);
            padding: 10px 14px;
            border-radius: 8px;
            color: var(--text-primary, #3f0712);
            font-family: var(--font-outfit, sans-serif);
            font-size: 14px;
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
            min-width: 140px;
            height: 42px;
        }
        .filter-select:focus {
            border-color: #db2777;
            box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.1);
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
                        <a href="{{ route('admin.duyet-dich-vu.index') }}" class="menu-link {{ Route::is('admin.duyet-dich-vu.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <span>Duyệt dịch vụ</span>
                            @if($soCho > 0)
                                <span class="count-badge">{{ $soCho }}</span>
                            @endif
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
                <h1 class="header-title">Duyệt dịch vụ cá nhân</h1>
            </div>
        </header>

        <!-- Body Content -->
        <div class="content-body">

            <!-- Search + Tabs Bar -->
            <div class="search-filter-bar">
                <form action="{{ route('admin.duyet-dich-vu.index') }}" method="GET" class="search-form">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    
                    <input type="text" name="search" class="form-input" placeholder="Tìm tên dịch vụ, người đăng..." value="{{ $search }}" style="min-width: 220px;">
                    
                    <!-- Lọc theo lĩnh vực -->
                    <select name="linh_vuc" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tất cả lĩnh vực</option>
                        @foreach($catMap as $key => $name)
                            <option value="{{ $key }}" {{ $linhVuc === $key ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    <!-- Lọc theo tháng -->
                    <select name="thang" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tất cả các tháng</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $thang == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                        @endfor
                    </select>

                    <!-- Lọc theo năm -->
                    <select name="nam" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tất cả các năm</option>
                        @foreach ($danhSachNam as $y)
                            <option value="{{ $y }}" {{ $nam == $y ? 'selected' : '' }}>Năm {{ $y }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-search">Lọc</button>

                    @if(!empty($search) || !empty($thang) || !empty($nam) || !empty($linhVuc))
                        <a href="{{ route('admin.duyet-dich-vu.index', ['tab' => $tab]) }}" class="btn-cancel" style="display:inline-flex;align-items:center;justify-content:center;height:42px;text-decoration:none;padding:0 16px;border-radius:8px;background-color:#f1f5f9;color:var(--text-secondary);border:1px solid var(--border-color);font-size:13.5px;font-weight:600;">Xóa bộ lọc</a>
                    @endif
                </form>

                <div class="tab-group">
                    <a href="{{ route('admin.duyet-dich-vu.index', ['tab' => 'cho_duyet', 'search' => $search, 'thang' => $thang, 'nam' => $nam, 'linh_vuc' => $linhVuc]) }}"
                       class="tab-item {{ $tab === 'cho_duyet' ? 'active' : '' }}">
                        Chờ duyệt
                        @if($soCho > 0)<span class="count-badge">{{ $soCho }}</span>@endif
                    </a>
                    <a href="{{ route('admin.duyet-dich-vu.index', ['tab' => 'da_duyet', 'search' => $search, 'thang' => $thang, 'nam' => $nam, 'linh_vuc' => $linhVuc]) }}"
                       class="tab-item {{ $tab === 'da_duyet' ? 'active' : '' }}">
                        Đã duyệt
                        <span class="count-badge green">{{ $soDuyet }}</span>
                    </a>
                    <a href="{{ route('admin.duyet-dich-vu.index', ['tab' => 'tu_choi', 'search' => $search, 'thang' => $thang, 'nam' => $nam, 'linh_vuc' => $linhVuc]) }}"
                       class="tab-item {{ $tab === 'tu_choi' ? 'active' : '' }}">
                        Từ chối
                        @if($soTuChoi > 0)<span class="count-badge gray">{{ $soTuChoi }}</span>@endif
                    </a>
                </div>
            </div>

            <!-- Cards -->
            @if($danhSachDichVu->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p>
                        @if($tab === 'cho_duyet') Không có dịch vụ nào đang chờ duyệt.
                        @elseif($tab === 'da_duyet') Chưa có dịch vụ nào được duyệt.
                        @else Chưa có dịch vụ nào bị từ chối.
                        @endif
                    </p>
                </div>
            @else
                <div class="service-grid">
                    @foreach($danhSachDichVu as $dv)
                    @php
                        $phanLoaiMap = [
                            'lap_trinh_web'       => ['icon' => '🌐', 'label' => 'Lập trình Web'],
                            'toi_uu_sql'          => ['icon' => '🗄️', 'label' => 'Tối ưu SQL'],
                            'thiet_ke_uiux'       => ['icon' => '🎨', 'label' => 'Thiết kế UI/UX'],
                            'lap_trinh_mobile'    => ['icon' => '📱', 'label' => 'Lập trình Mobile'],
                            'devops_cloud'        => ['icon' => '☁️', 'label' => 'DevOps & Cloud'],
                            'kiem_thu'            => ['icon' => '🔍', 'label' => 'Kiểm thử'],
                            'an_ninh_mang'        => ['icon' => '🔒', 'label' => 'An ninh mạng'],
                            'phan_tich_du_lieu'   => ['icon' => '📊', 'label' => 'Phân tích dữ liệu'],
                            'tri_tue_nhan_tao'    => ['icon' => '🤖', 'label' => 'Trí tuệ nhân tạo'],
                            'viet_lach_content'   => ['icon' => '✍️', 'label' => 'Viết lách & Content'],
                            'quan_tri_du_an'      => ['icon' => '📋', 'label' => 'Quản trị dự án'],
                            'khac'                => ['icon' => '⭐', 'label' => 'Khác'],
                        ];
                        $pl = $phanLoaiMap[$dv->phan_loai] ?? ['icon' => '⭐', 'label' => $dv->phan_loai];
                        $words = explode(' ', trim($dv->ten_nguoi_dung));
                        $initials = count($words) >= 2
                            ? mb_strtoupper(mb_substr($words[count($words)-2], 0, 1) . mb_substr($words[count($words)-1], 0, 1))
                            : mb_strtoupper(mb_substr($dv->ten_nguoi_dung, 0, 2));
                    @endphp
                    <div class="service-card" onclick='moChiTiet(@json($dv), @json($pl), "{{ $initials }}")'>
                        <div class="service-card-header">
                            <div class="service-icon">{{ $pl['icon'] }}</div>
                            <div class="service-info">
                                <div class="service-name" title="{{ $dv->ten_dich_vu }}">{{ $dv->ten_dich_vu }}</div>
                                <div class="service-category">{{ $pl['label'] }}</div>
                            </div>
                            <span class="badge
                                @if($dv->trang_thai_duyet == 0) badge-pending
                                @elseif($dv->trang_thai_duyet == 1) badge-approved
                                @else badge-rejected
                                @endif"
                                style="white-space:nowrap; font-size:11px; padding:3px 9px; border-radius:20px; font-weight:600; flex-shrink:0;">
                                @if($dv->trang_thai_duyet == 0) ⏳ Chờ duyệt
                                @elseif($dv->trang_thai_duyet == 1) ✅ Đã duyệt
                                @else ❌ Từ chối
                                @endif
                            </span>
                        </div>

                        <div class="service-user-row">
                            <div class="user-avatar-tiny">
                                @if($dv->anh_nguoi_dung)
                                    <img src="{{ asset($dv->anh_nguoi_dung) }}" alt="Avatar">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                            <div class="user-detail-sm">
                                <div class="user-name-sm">{{ $dv->ten_nguoi_dung }}</div>
                                <div class="user-email-sm">{{ $dv->ma_nguoi_dung }}</div>
                            </div>
                            <span style="margin-left:auto; font-size:11px; color:#94a3b8; white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($dv->ngay_tao)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                            </span>
                        </div>

                        <p class="service-desc-preview">{{ $dv->mo_ta }}</p>

                        <div class="hint-click">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Nhấn để xem chi tiết & duyệt
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper" style="margin-top:28px;">
                    {{ $danhSachDichVu->links('admin.partials.pagination') }}
                </div>
            @endif

        </div>
    </main>

    <!-- ═══════════════════════════════════════════════
         MODAL XEM CHI TIẾT DỊCH VỤ
         ═══════════════════════════════════════════════ -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-panel">

            <!-- Header -->
            <div class="detail-header">
                <div class="detail-header-left">
                    <div class="detail-icon-wrap" id="detail-icon">🌐</div>
                    <div>
                        <div class="detail-title" id="detail-ten-dv">Tên dịch vụ</div>
                        <div class="detail-sub" id="detail-phan-loai">Phân loại</div>
                    </div>
                </div>
                <button type="button" class="modal-close-btn" onclick="dongChiTiet()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="detail-body">

                <!-- Thông tin người đăng -->
                <div>
                    <div class="detail-section-label">Người đăng dịch vụ</div>
                    <div class="detail-provider-row">
                        <div class="detail-avatar" id="detail-avatar">ND</div>
                        <div>
                            <div style="font-size:14px; font-weight:700; color:#1e293b;" id="detail-ho-ten">Tên người dùng</div>
                            <div style="font-size:12px; color:#94a3b8;" id="detail-email">Email</div>
                        </div>
                        <span id="detail-badge" style="margin-left:auto; white-space:nowrap; font-size:11.5px; padding:4px 10px; border-radius:20px; font-weight:600;"></span>
                    </div>
                </div>

                <!-- Mô tả -->
                <div>
                    <div class="detail-section-label">Mô tả dịch vụ</div>
                    <div class="detail-desc-box" id="detail-mo-ta">Mô tả dịch vụ</div>
                </div>

                <!-- Thông tin liên hệ -->
                <div>
                    <div class="detail-section-label">Thông tin liên hệ</div>
                    <div style="border: 1px solid #f1f5f9; border-radius: 10px; padding: 4px 14px;">
                        <div class="detail-contact-row">
                            <div class="detail-contact-icon zalo">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <div class="detail-contact-label">Zalo</div>
                                <div class="detail-contact-val" id="detail-zalo"><a href="#" id="detail-zalo-link" target="_blank" rel="noopener noreferrer"></a></div>
                            </div>
                        </div>
                        <div class="detail-contact-row">
                            <div class="detail-contact-icon gmail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="detail-contact-label">Email</div>
                                <div class="detail-contact-val" id="detail-gmail"><a href="#" id="detail-gmail-link"></a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CV đính kèm -->
                <div id="detail-cv-section">
                    <div class="detail-section-label">Hồ sơ năng lực đính kèm</div>
                    <div class="detail-cv-box">
                        <div class="detail-cv-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <div class="detail-cv-name">CV đính kèm</div>
                            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Thông tin nhạy cảm sẽ được che khi xem</div>
                        </div>
                        <a href="#" id="detail-cv-link" target="_blank" class="btn-view-cv-detail">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Xem CV
                        </a>
                    </div>
                </div>

                <!-- Ngày tháng -->
                <div class="detail-meta-row">
                    <div>📅 Ngày đăng: <strong id="detail-ngay-tao"></strong></div>
                    <div>🕒 Cập nhật: <strong id="detail-ngay-cap-nhat"></strong></div>
                </div>

            </div>

            <!-- Footer: nút Duyệt / Từ chối / Đóng -->
            <div class="detail-footer">
                <button type="button" onclick="dongChiTiet()" style="padding:9px 18px; background:#f1f5f9; border:none; border-radius:9px; font-size:13.5px; font-weight:600; cursor:pointer; color:#64748b;">Đóng lại</button>
                <div style="display:flex; gap:10px;" id="detail-action-btns">
                    <button type="button" class="btn-reject-detail" id="btn-tu-choi" onclick="tuChoiDichVu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Từ chối
                    </button>
                    <button type="button" class="btn-approve-detail" id="btn-duyet" onclick="duyetDichVu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Duyệt dịch vụ
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;
        let currentDv = null;

        // Format ngày
        function fmtDate(str) {
            if (!str) return '—';
            const d = new Date(str);
            const pad = n => String(n).padStart(2, '0');
            return `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
        }

        // Mở modal chi tiết
        function moChiTiet(dv, pl, initials) {
            currentDv = dv;

            // Icon + tên + phân loại
            document.getElementById('detail-icon').textContent = pl.icon;
            document.getElementById('detail-ten-dv').textContent = dv.ten_dich_vu;
            document.getElementById('detail-phan-loai').textContent = pl.label;

            // Avatar người đăng
            const avatarEl = document.getElementById('detail-avatar');
            if (dv.anh_nguoi_dung) {
                avatarEl.innerHTML = `<img src="${dv.anh_nguoi_dung}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
            } else {
                avatarEl.textContent = initials;
            }
            document.getElementById('detail-ho-ten').textContent = dv.ten_nguoi_dung;
            document.getElementById('detail-email').textContent = (dv.ma_nguoi_dung || '') + ' · ' + (dv.email_nguoi_dung || '');

            // Badge trạng thái
            const badge = document.getElementById('detail-badge');
            if (dv.trang_thai_duyet == 0) {
                badge.textContent = '⏳ Chờ duyệt';
                badge.className = 'badge badge-pending';
            } else if (dv.trang_thai_duyet == 1) {
                badge.textContent = '✅ Đã duyệt';
                badge.className = 'badge badge-approved';
            } else {
                badge.textContent = '❌ Từ chối';
                badge.className = 'badge badge-rejected';
            }

            // Mô tả
            document.getElementById('detail-mo-ta').textContent = dv.mo_ta;

            // Liên hệ
            const zaloPhone = (dv.zalo || '').replace(/[^0-9]/g, '');
            document.getElementById('detail-zalo-link').textContent = dv.zalo;
            document.getElementById('detail-zalo-link').href = 'https://zalo.me/' + zaloPhone;
            document.getElementById('detail-gmail-link').textContent = dv.gmail;
            document.getElementById('detail-gmail-link').href = 'mailto:' + dv.gmail;

            // CV đính kèm
            const cvSection = document.getElementById('detail-cv-section');
            if (dv.id_cv) {
                cvSection.style.display = 'block';
                document.getElementById('detail-cv-link').href = '/ho-so/dich-vu/xem-cv/' + dv.id;
            } else {
                cvSection.style.display = 'none';
            }

            // Ngày
            document.getElementById('detail-ngay-tao').textContent = fmtDate(dv.ngay_tao);
            document.getElementById('detail-ngay-cap-nhat').textContent = fmtDate(dv.ngay_cap_nhat);

            // Nút hành động
            const btnDuyet = document.getElementById('btn-duyet');
            const btnTuChoi = document.getElementById('btn-tu-choi');
            if (dv.trang_thai_duyet == 1) {
                // Đã duyệt → chỉ cho từ chối / thu hồi
                btnDuyet.style.display = 'none';
                btnTuChoi.style.display = 'flex';
                btnTuChoi.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Thu hồi duyệt`;
            } else if (dv.trang_thai_duyet == 2) {
                // Từ chối → chỉ cho duyệt lại
                btnTuChoi.style.display = 'none';
                btnDuyet.style.display = 'flex';
            } else {
                // Chờ duyệt → cả 2
                btnDuyet.style.display = 'flex';
                btnTuChoi.style.display = 'flex';
                btnTuChoi.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Từ chối`;
            }

            document.getElementById('detailModal').classList.add('active');
        }

        function dongChiTiet() {
            document.getElementById('detailModal').classList.remove('active');
        }

        // Duyệt dịch vụ
        function duyetDichVu() {
            if (!currentDv) return;
            const btn = document.getElementById('btn-duyet');
            btn.disabled = true;

            fetch('/admin/duyet-dich-vu/' + currentDv.id + '/duyet', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                if (data.thanh_cong) {
                    showToast(data.thong_bao, 'success');
                    dongChiTiet();
                    setTimeout(() => location.reload(), 900);
                } else {
                    showToast(data.thong_bao, 'error');
                }
            })
            .catch(() => { btn.disabled = false; showToast('Lỗi kết nối.', 'error'); });
        }

        // Từ chối dịch vụ (không cần lý do)
        function tuChoiDichVu() {
            if (!currentDv) return;
            const btn = document.getElementById('btn-tu-choi');
            btn.disabled = true;

            fetch('/admin/duyet-dich-vu/' + currentDv.id + '/tu-choi', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                if (data.thanh_cong) {
                    showToast(data.thong_bao, 'success');
                    dongChiTiet();
                    setTimeout(() => location.reload(), 900);
                } else {
                    showToast(data.thong_bao, 'error');
                }
            })
            .catch(() => { btn.disabled = false; showToast('Lỗi kết nối.', 'error'); });
        }

        // Đóng khi click bên ngoài
        window.addEventListener('click', e => {
            if (e.target === document.getElementById('detailModal')) dongChiTiet();
        });

        // Toast
        function showToast(msg, type = 'success') {
            const c = document.getElementById('toastContainer');
            const t = document.createElement('div');
            t.className = 'toast ' + type;
            t.textContent = msg;
            c.appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 350); }, 3500);
        }
    </script>
</body>
</html>
