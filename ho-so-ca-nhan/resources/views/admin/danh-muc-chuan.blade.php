<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Danh mục chuẩn - DPCS Admin</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">
    
    <style>
        .catalog-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .btn-add-item {
            background: linear-gradient(135deg, var(--color-blue), var(--color-purple));
            color: #ffffff;
            border: none;
            padding: 10px 20px;
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
        
        .btn-add-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(219, 39, 119, 0.35);
        }

        .btn-add-item svg {
            width: 16px;
            height: 16px;
        }

        /* Action buttons overrides */
        .btn-edit-item {
            border: 1px solid #e2e8f0;
            background-color: #fff;
            color: #db2777;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: var(--transition-smooth);
        }

        .btn-edit-item:hover {
            background-color: #fdf2f8;
            border-color: #fbcfe8;
        }

        .btn-delete-item {
            border: 1px solid #fee2e2;
            background-color: #fff;
            color: #ef4444;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: var(--transition-smooth);
        }

        .btn-delete-item:hover {
            background-color: #fef2f2;
            border-color: #fca5a5;
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
                <h1 class="header-title">Danh mục chuẩn</h1>
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

            <!-- Catalog Header Row (Tabs + Add Button) -->
            <div class="catalog-header-bar">
                <!-- Tabs -->
                <div class="tab-group" style="margin: 0;">
                    <a href="{{ route('admin.danh-muc-chuan.index', ['tab' => 'ngon_ngu', 'search' => $search]) }}" class="tab-item {{ $tab === 'ngon_ngu' ? 'active' : '' }}">
                        Ngôn ngữ lập trình
                    </a>
                    <a href="{{ route('admin.danh-muc-chuan.index', ['tab' => 'ky_nang', 'search' => $search]) }}" class="tab-item {{ $tab === 'ky_nang' ? 'active' : '' }}">
                        Kỹ năng mềm
                    </a>
                </div>
                
                <!-- Add Button -->
                <button type="button" class="btn-add-item" onclick="moModalAdd()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Thêm {{ $tab === 'ky_nang' ? 'kỹ năng mới' : 'ngôn ngữ mới' }}</span>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-filter-bar" style="margin-bottom: 20px;">
                <form action="{{ route('admin.danh-muc-chuan.index') }}" method="GET" class="search-form" style="width: 100%;">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" class="form-input" placeholder="Tìm kiếm theo tên..." value="{{ $search }}" style="flex: 1;">
                    <button type="submit" class="btn-search">Tìm kiếm</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.danh-muc-chuan.index', ['tab' => $tab]) }}" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; height: 42px; text-decoration: none; padding: 0 16px; border-radius: 8px; background-color: #f1f5f9; color: var(--text-secondary); border: 1px solid var(--border-color); font-size: 13.5px; font-weight: 600;">Xóa bộ lọc</a>
                    @endif
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>Tên danh mục</th>
                            <th style="width: 200px; text-align: right; padding-right: 24px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danhSach as $item)
                            <tr>
                                <td style="font-weight: 700; color: var(--text-secondary);">#{{ $item->id }}</td>
                                <td style="font-weight: 600; font-size: 14.5px;">{{ $tab === 'ky_nang' ? $item->ten_ky_nang : $item->ten_ngon_ngu }}</td>
                                <td style="text-align: right; padding-right: 24px;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button type="button" class="btn-edit-item" onclick="moModalEdit({{ $item->id }}, '{{ $tab === 'ky_nang' ? $item->ten_ky_nang : $item->ten_ngon_ngu }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            Sửa
                                        </button>
                                        <form action="{{ $tab === 'ky_nang' ? route('admin.danh-muc-chuan.ky-nang.xoa', $item->id) : route('admin.danh-muc-chuan.ngon-ngu.xoa', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mục này? Toàn bộ liên kết của người dùng với mục này cũng sẽ bị xóa bỏ hoàn toàn!')" style="margin: 0; display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-delete-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 40px; font-weight: 500;">
                                    Không tìm thấy danh mục nào phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($danhSach->hasPages())
                    <div class="pagination-wrapper" style="padding: 20px;">
                        {{ $danhSach->links('admin.partials.pagination') }}
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Add Item Modal Overlay -->
    <div class="modal-overlay" id="addModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">
                    {{ $tab === 'ky_nang' ? 'Thêm kỹ năng mềm mới' : 'Thêm ngôn ngữ lập trình mới' }}
                </h3>
                <button type="button" class="modal-close" onclick="dongModalAdd()">&times;</button>
            </div>
            <form method="POST" action="{{ $tab === 'ky_nang' ? route('admin.danh-muc-chuan.ky-nang.luu') : route('admin.danh-muc-chuan.ngon-ngu.luu') }}">
                @csrf
                <div class="modal-body" style="padding-top: 10px;">
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                        <label class="form-label" for="add_ten_input" style="font-weight: 600;">
                            {{ $tab === 'ky_nang' ? 'Tên kỹ năng mềm' : 'Tên ngôn ngữ lập trình' }} <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="{{ $tab === 'ky_nang' ? 'ten_ky_nang' : 'ten_ngon_ngu' }}" id="add_ten_input" class="form-input" required minlength="2" maxlength="{{ $tab === 'ky_nang' ? 30 : 20 }}" placeholder="Nhập tên gọi..." autocomplete="off">
                        <small style="color: var(--text-muted); font-size: 11px;">
                            * Độ dài từ 2 đến {{ $tab === 'ky_nang' ? '30' : '20' }} ký tự.
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 20px;">
                    <button type="button" class="btn-cancel" onclick="dongModalAdd()">Hủy</button>
                    <button type="submit" class="btn-submit-lock" style="background: linear-gradient(135deg, var(--color-blue), var(--color-purple)); color: white; border: none;">Lưu danh mục</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Item Modal Overlay -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">
                    {{ $tab === 'ky_nang' ? 'Chỉnh sửa kỹ năng mềm' : 'Chỉnh sửa ngôn ngữ lập trình' }}
                </h3>
                <button type="button" class="modal-close" onclick="dongModalEdit()">&times;</button>
            </div>
            <form id="editForm" method="POST" action="">
                @csrf
                <div class="modal-body" style="padding-top: 10px;">
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                        <label class="form-label" for="edit_ten_input" style="font-weight: 600;">
                            {{ $tab === 'ky_nang' ? 'Tên kỹ năng mềm' : 'Tên ngôn ngữ lập trình' }} <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="{{ $tab === 'ky_nang' ? 'ten_ky_nang' : 'ten_ngon_ngu' }}" id="edit_ten_input" class="form-input" required minlength="2" maxlength="{{ $tab === 'ky_nang' ? 30 : 20 }}" placeholder="Nhập tên gọi mới..." autocomplete="off">
                        <small style="color: var(--text-muted); font-size: 11px;">
                            * Độ dài từ 2 đến {{ $tab === 'ky_nang' ? '30' : '20' }} ký tự.
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 20px;">
                    <button type="button" class="btn-cancel" onclick="dongModalEdit()">Hủy</button>
                    <button type="submit" class="btn-submit-lock" style="background: linear-gradient(135deg, var(--color-blue), var(--color-purple)); color: white; border: none;">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script điều khiển Modals -->
    <script>
        function moModalAdd() {
            document.getElementById('addModal').classList.add('active');
            setTimeout(() => {
                document.getElementById('add_ten_input').focus();
            }, 100);
        }

        function dongModalAdd() {
            document.getElementById('addModal').classList.remove('active');
            document.getElementById('add_ten_input').value = '';
        }

        function moModalEdit(id, name) {
            const editForm = document.getElementById('editForm');
            let actionRoute = '';
            
            @if($tab === 'ky_nang')
                actionRoute = "{{ route('admin.danh-muc-chuan.ky-nang.cap-nhat', ['id' => ':id']) }}".replace(':id', id);
            @else
                actionRoute = "{{ route('admin.danh-muc-chuan.ngon-ngu.cap-nhat', ['id' => ':id']) }}".replace(':id', id);
            @endif

            editForm.action = actionRoute;
            document.getElementById('edit_ten_input').value = name;
            document.getElementById('editModal').classList.add('active');
            
            setTimeout(() => {
                document.getElementById('edit_ten_input').focus();
            }, 100);
        }

        function dongModalEdit() {
            document.getElementById('editModal').classList.remove('active');
            document.getElementById('edit_ten_input').value = '';
        }

        // Đóng modal khi click ra ngoài thẻ card
        window.addEventListener('click', function(event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            if (event.target === addModal) {
                dongModalAdd();
            }
            if (event.target === editModal) {
                dongModalEdit();
            }
        });
    </script>

</body>
</html>
