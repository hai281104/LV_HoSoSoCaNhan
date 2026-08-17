<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ý kiến người dùng - DPCS Admin</title>
    <meta name="description" content="Xem đóng góp ý kiến từ người dùng.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">

    <style>
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
                    {{-- <li class="menu-item">
                        <a href="{{ route('admin.duyet-dich-vu.index') }}" class="menu-link {{ Route::is('admin.duyet-dich-vu.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <span>Duyệt dịch vụ</span>
                        </a>
                    </li> --}}
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
                <h1 class="header-title">Ý kiến đóng góp từ người dùng</h1>
            </div>
        </header>

        <!-- Body Content -->
        <div class="content-body">
            
            <!-- Alerts -->
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

            <!-- Search and Filter Bar -->
            <div class="search-filter-bar" style="margin-bottom: 20px;">
                <form action="{{ route('admin.y-kien-nguoi-dung.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" class="form-input" placeholder="Tìm người dùng, email, nội dung đóng góp..." value="{{ $search }}" style="min-width: 220px;">
                    
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
                    @if(!empty($search) || !empty($thang) || !empty($nam))
                        <a href="{{ route('admin.y-kien-nguoi-dung.index') }}" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; height: 42px; text-decoration: none; padding: 0 16px; border-radius: 8px; background-color: #f1f5f9; color: var(--text-secondary); border: 1px solid var(--border-color); font-size: 13.5px; font-weight: 600;">Xóa bộ lọc</a>
                    @endif
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 170px;">Thời gian gửi</th>
                            <th style="width: 250px;">Người gửi</th>
                            <th>Nội dung đóng góp</th>
                            <th style="width: 100px; text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danhSachDongGop as $dongGop)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($dongGop->ngay_tao)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text-primary);">{{ $dongGop->ho_ten }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">{{ $dongGop->ma_nguoi_dung }}</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">{{ $dongGop->email }}</div>
                                </td>
                                <td>
                                    <div style="white-space: pre-wrap; word-break: break-word; line-height: 1.6; color: var(--text-primary); font-weight: 500;">{{ $dongGop->noi_dung }}</div>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('admin.y-kien-nguoi-dung.destroy', $dongGop->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ý kiến đóng góp này không?')">
                                        @csrf
                                        <button type="submit" class="btn-cancel" style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer;">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px 20px;">
                                    Không tìm thấy ý kiến đóng góp nào từ người dùng.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($danhSachDongGop->hasPages())
                    <div class="pagination-wrapper" style="padding: 20px 0 0 0;">
                        {{ $danhSachDongGop->links('admin.partials.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
