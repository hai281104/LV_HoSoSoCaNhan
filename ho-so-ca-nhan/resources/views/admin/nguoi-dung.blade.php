<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý người dùng - DPCS Admin</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Quản trị -->
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v={{ time() }}">
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
                <h1 class="header-title">Quản lý người dùng</h1>
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

            <!-- Search and Tabs Bar -->
            <div class="search-filter-bar">
                <!-- Search Box -->
                <form action="{{ route('admin.nguoi-dung.index') }}" method="GET" class="search-form">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" class="form-input" placeholder="Tìm mã người dùng, tên..." value="{{ $search }}">
                    <button type="submit" class="btn-search">Tìm kiếm</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.nguoi-dung.index', ['tab' => $tab]) }}" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; height: 42px; text-decoration: none; padding: 0 16px; border-radius: 8px; background-color: #f1f5f9; color: var(--text-secondary); border: 1px solid var(--border-color); font-size: 13.5px; font-weight: 600;">Xóa bộ lọc</a>
                    @endif
                </form>

                <!-- Tabs -->
                <div class="tab-group">
                    <a href="{{ route('admin.nguoi-dung.index', ['tab' => 'hoat_dong', 'search' => $search]) }}" class="tab-item {{ $tab === 'hoat_dong' ? 'active' : '' }}">
                        Hoạt động
                    </a>
                    <a href="{{ route('admin.nguoi-dung.index', ['tab' => 'bi_khoa', 'search' => $search]) }}" class="tab-item {{ $tab === 'bi_khoa' ? 'active' : '' }}">
                        Bị khóa
                    </a>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="table-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã người dùng</th>
                            <th>Họ và tên</th>
                            <th>Email / Số điện thoại</th>
                            @if($tab === 'bi_khoa')
                                <th>Chi tiết khóa</th>
                            @endif
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($danhSachNguoiDung as $user)
                            <tr>
                                <td style="font-weight: 700;">{{ $user->ma_nguoi_dung }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $user->ho_ten }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">Đăng ký lúc: {{ \Carbon\Carbon::parse($user->ngay_tao)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div>{{ $user->email }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">SĐT: {{ $user->so_dien_thoai ?? 'Chưa có' }}</div>
                                </td>
                                @if($tab === 'bi_khoa')
                                    <td>
                                        <div class="user-meta-info">Lý do: <strong style="color: #ef4444;">{{ $user->ly_do_khoa }}</strong></div>
                                        <div class="user-meta-info">Ngày khóa: <strong>{{ $user->ngay_khoa ? \Carbon\Carbon::parse($user->ngay_khoa)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') : 'Không rõ' }}</strong></div>
                                        <div class="user-meta-info">Thời hạn: 
                                            <strong style="color: #ef4444;">
                                                @if($user->khoa_den)
                                                    Đến {{ \Carbon\Carbon::parse($user->khoa_den)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                                                @else
                                                    Vĩnh viễn
                                                @endif
                                            </strong>
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    @if($user->trang_thai === 'hoat_dong')
                                        <span class="badge badge-active">Hoạt động</span>
                                    @else
                                        <span class="badge badge-locked">Bị khóa</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($user->trang_thai === 'hoat_dong')
                                            <button type="button" class="btn-action btn-lock" onclick="moModalKhoa({{ $user->id }}, '{{ $user->ma_nguoi_dung }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                                Khóa tài khoản
                                            </button>
                                        @else
                                            <form action="{{ route('admin.nguoi-dung.mo-khoa', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn mở khóa tài khoản này không?');">
                                                @csrf
                                                <button type="submit" class="btn-action btn-unlock">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                                    </svg>
                                                    Mở khóa
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab === 'bi_khoa' ? 6 : 5 }}" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Không tìm thấy tài khoản người dùng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination-wrapper">
                    {{ $danhSachNguoiDung->links('admin.partials.pagination') }}
                </div>
            </div>

        </div>
    </main>

    <!-- Lock User Modal Overlay -->
    <div class="modal-overlay" id="lockModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Khóa tài khoản người dùng</h3>
                <button type="button" class="modal-close" onclick="dongModalKhoa()">&times;</button>
            </div>
            <form id="lockForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 16px;">
                        Bạn đang thực hiện khóa tài khoản người dùng có mã: <strong id="lockUserCode" style="color: #ef4444;"></strong>
                    </p>

                    <!-- Reason Input -->
                    <div class="form-group">
                        <label class="form-label" for="ly_do_khoa_input">Lý do khóa tài khoản <span style="color: #ef4444;">*</span></label>
                        <textarea name="ly_do_khoa" id="ly_do_khoa_input" class="form-textarea" placeholder="Nhập lý do khóa cụ thể..." required></textarea>
                    </div>

                    <!-- Lock Type Radio Group -->
                    <div class="form-group">
                        <label class="form-label">Loại khóa</label>
                        <div class="form-radio-group">
                            <label class="form-radio-label">
                                <input type="radio" name="kieu_khoa" value="vinh_vien" checked>
                                Vĩnh viễn
                            </label>
                            <label class="form-radio-label">
                                <input type="radio" name="kieu_khoa" value="co_thoi_han">
                                Có thời hạn
                            </label>
                        </div>
                    </div>

                    <!-- Lock Until Datetime Group (hidden by default) -->
                    <div class="form-group" id="datetimeGroup" style="display: none;">
                        <label class="form-label" for="khoa_den_input">Mở khóa vào lúc <span style="color: #ef4444;">*</span></label>
                        <input type="datetime-local" name="khoa_den" id="khoa_den_input" class="form-input">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="dongModalKhoa()">Hủy</button>
                    <button type="submit" class="btn-submit-lock">Xác nhận khóa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script điều khiển Modal -->
    <script>
        function moModalKhoa(userId, userCode) {
            const lockForm = document.getElementById('lockForm');
            lockForm.action = "{{ route('admin.nguoi-dung.khoa', ['id' => ':id']) }}".replace(':id', userId);
            
            document.getElementById('lockUserCode').innerText = userCode;
            document.getElementById('lockModal').classList.add('active');
        }

        function dongModalKhoa() {
            document.getElementById('lockModal').classList.remove('active');
            // Reset form
            document.getElementById('ly_do_khoa_input').value = '';
            document.querySelector('input[name="kieu_khoa"][value="vinh_vien"]').checked = true;
            document.getElementById('datetimeGroup').style.display = 'none';
            document.getElementById('khoa_den_input').value = '';
            document.getElementById('khoa_den_input').required = false;
        }

        // Bắt sự kiện chuyển loại khóa
        document.querySelectorAll('input[name="kieu_khoa"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const datetimeGroup = document.getElementById('datetimeGroup');
                const datetimeInput = document.getElementById('khoa_den_input');
                if (this.value === 'co_thoi_han') {
                    datetimeGroup.style.display = 'block';
                    datetimeInput.required = true;
                    // Thiết lập ngày tối thiểu là hiện tại
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    datetimeInput.min = now.toISOString().slice(0, 16);
                } else {
                    datetimeGroup.style.display = 'none';
                    datetimeInput.required = false;
                    datetimeInput.value = '';
                }
            });
        });

        // Đóng modal khi click ra ngoài thẻ card
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('lockModal');
            if (event.target === modal) {
                dongModalKhoa();
            }
        });
    </script>
</body>
</html>
