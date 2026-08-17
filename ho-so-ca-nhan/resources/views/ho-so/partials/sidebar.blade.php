<aside class="sidebar">
    <a href="{{ route('landing') }}" class="sidebar-brand" style="text-decoration: none;">
        <img src="{{ asset('uploads/logo/logo.png') }}" alt="Logo" style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; flex-shrink: 0; background-color: rgba(255, 255, 255, 0.05); padding: 4px;">
        <div>
            <span class="brand-logo">DPCS</span>
            <span class="brand-sub">Hồ sơ cá nhân</span>
        </div>
    </a>

    <nav class="sidebar-menu">
        @if(Auth::user() && Auth::user()->vai_tro === 'quan_tri')
        <div class="menu-group admin-link-group" style="margin-bottom: 20px;">
            <div class="menu-title" style="color: #f43f5e; font-weight: 800; letter-spacing: 0.5px;">Quản trị</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link" style="background: rgba(244, 63, 94, 0.08); border: 1px solid rgba(244, 63, 94, 0.15); border-radius: 8px; padding: 10px 16px; display: flex; align-items: center; gap: 10px; color: #f43f5e; text-decoration: none; transition: all 0.3s ease;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; color: #f43f5e; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        <span style="font-weight: 700; font-size: 13px;">Trang quản trị</span>
                    </a>
                </li>
            </ul>
        </div>
        @endif

        {{-- Tổng quan --}}
        <div class="menu-group">
            <div class="menu-title">Tổng quan</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('trang-chu') }}" class="menu-link {{ Route::is('trang-chu') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so') }}" class="menu-link {{ Route::is('ho-so') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Hồ sơ cá nhân</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.hanh-trinh') }}" class="menu-link {{ Route::is('ho-so.hanh-trinh') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span>Hành trình phát triển</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Nghề nghiệp --}}
        <div class="menu-group">
            <div class="menu-title">Nghề nghiệp</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('ho-so.hoc-van') }}" class="menu-link {{ Route::is('ho-so.hoc-van') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        <span>Học vấn & Trình độ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.du-an') }}" class="menu-link {{ Route::is('ho-so.du-an') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>Portfolio dự án</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.cv.index') }}" class="menu-link {{ Route::is('ho-so.cv.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Quản lý CV</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.chung-chi') }}" class="menu-link {{ Route::is('ho-so.chung-chi') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span>Chứng chỉ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.thanh-tuu') }}" class="menu-link {{ Route::is('ho-so.thanh-tuu') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <span>Thành tựu</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.kinh-nghiem') }}" class="menu-link {{ Route::is('ho-so.kinh-nghiem') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Kinh nghiệm làm việc</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.album') }}" class="menu-link {{ Route::is('ho-so.album') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Album ảnh nổi bật</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Công cụ --}}
        <div class="menu-group">
            <div class="menu-title">Công cụ</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('ho-so.chia-se') }}" class="menu-link {{ Route::is('ho-so.chia-se') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l4.828-2.414m0 5.344l-4.828-2.414zm6.086-4.238a3 3 0 11-5.714 0 3 3 0 015.714 0zm-5.71 8.824a3 3 0 11-5.714 0 3 3 0 015.714 0zm5.71-3.002a3 3 0 11-5.714 0 3 3 0 015.714 0z"/></svg>
                        <span>Chia sẻ hồ sơ</span>
                    </a>
                </li>
{{--
                <li class="menu-item">
                    <a href="{{ route('ho-so.lich') }}" class="menu-link {{ Route::is('ho-so.lich') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Lịch / Công việc</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('ho-so.dich-vu') }}" class="menu-link {{ Route::is('ho-so.dich-vu') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Dịch vụ cá nhân</span>
                    </a>
                </li>
--}}
                <li class="menu-item">
                    <a href="{{ route('ho-so.nhat-ky') }}" class="menu-link {{ Route::is('ho-so.nhat-ky') ? 'active' : '' }}" title="Theo dõi lịch sử truy cập, các thao tác chỉnh sửa hồ sơ và nhật ký bảo mật của bạn.">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Hoạt động & Nhật ký</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="sidebar-user" style="position: relative;">
        <div class="sidebar-user-trigger" id="avatarTrigger" title="Tùy chọn tài khoản" style="display: flex; align-items: center; gap: 10px; cursor: pointer; flex: 1; overflow: hidden; padding: 4px; border-radius: 6px; transition: background-color 0.2s;">
            <div class="user-avatar-sm" style="flex-shrink: 0;">
                @if(isset($anhDaiDien) && $anhDaiDien)
                    <img src="{{ asset($anhDaiDien) }}" alt="Avatar" class="js-avatar-img">
                @else
                    <span id="sidebar-initials" class="js-avatar-initials-sm">{{ $tenRutGon ?? '' }}</span>
                @endif
            </div>
            <div class="user-info-sm" style="flex: 1; overflow: hidden;">
                <div class="user-name-sm" id="sidebar-user-name" style="color: #e2e8f0; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $hoTen ?? '' }}</div>
                <div class="user-role-sm" id="sidebar-user-role" style="color: #64748b; font-size: 11px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $chucDanh ?? '' }}</div>
            </div>
            <div class="user-chevron-sm" style="color: #64748b; flex-shrink: 0; display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
            </div>
        </div>

        <form id="logoutForm" action="{{ route('dang-xuat') }}" method="POST" style="display:none;">@csrf</form>
        <button type="button" class="btn-logout-icon" onclick="if (confirm('Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?')) document.getElementById('logoutForm').submit()" title="Đăng xuất">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        </button>

        <!-- Avatar Dropdown Menu -->
        <div class="avatar-dropdown" id="avatarDropdown" style="position: absolute; opacity: 0; visibility: hidden; transform: translateY(10px);">
            <div class="avatar-dropdown-header">
                <div class="dropdown-user-name">{{ $hoTen ?? '' }}</div>
                <div class="dropdown-user-email">{{ Auth::user()->email ?? '' }}</div>
            </div>
            <div class="avatar-dropdown-divider"></div>
            <ul class="avatar-dropdown-list">
                <li>
                    <button type="button" class="avatar-dropdown-item" id="btn-open-settings">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Cài đặt</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="avatar-dropdown-item" id="btn-open-policy">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Chính sách & Bảo mật</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="avatar-dropdown-item" id="btn-open-feedback">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        <span>Đóng góp ý kiến</span>
                    </button>
                </li>
                <li class="avatar-dropdown-divider"></li>
                <li>
                    <button type="button" class="avatar-dropdown-item text-danger" onclick="if (confirm('Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?')) document.getElementById('logoutForm').submit()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Đăng xuất</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- MODALS SECTION -->

<!-- 1. Modal Cài đặt (Settings) -->
<div class="cai-dat-modal-overlay" id="settingsModal" style="display: none;">
    <div class="cai-dat-modal-card">
        <div class="cai-dat-modal-header">
            <h3 class="cai-dat-modal-title">Cài đặt tài khoản</h3>
            <button type="button" class="cai-dat-modal-close" onclick="dongSettingsModal()">&times;</button>
        </div>
        <div class="cai-dat-modal-body">
            <div class="cai-dat-tabs-container">
                <!-- Sidebar Tabs -->
                <div class="cai-dat-tabs-sidebar">
                    <button type="button" class="cai-dat-tab-btn active" data-target="tab-doi-mat-khau">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2m-5 0a2 2 0 012 2"/></svg>
                        <span>Đổi mật khẩu</span>
                    </button>
                    <button type="button" class="cai-dat-tab-btn" data-target="tab-thong-bao">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>Thông báo</span>
                    </button>
                    <button type="button" class="cai-dat-tab-btn" data-target="tab-xoa-tai-khoan">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Xóa tài khoản</span>
                    </button>
                </div>
                <!-- Content Areas -->
                <div class="cai-dat-tabs-content">
                    
                    <!-- TAB 1: ĐỔI MẬT KHẨU -->
                    <div class="cai-dat-tab-pane active" id="tab-doi-mat-khau">
                        <form id="formDoiMatKhau">
                            <div class="cai-dat-form-group">
                                <label for="mat_khau_cu">Mật khẩu hiện tại</label>
                                <input type="password" name="mat_khau_cu" id="mat_khau_cu" required class="cai-dat-input">
                                <small class="cai-dat-input-hint" style="font-size: 11px; color: #94a3b8; display: block; margin-top: 2px;">* Nhập mật khẩu hiện tại của bạn.</small>
                                <span class="cai-dat-error-msg" id="err-mat_khau_cu"></span>
                            </div>
                            <div class="cai-dat-form-group">
                                <label for="mat_khau">Mật khẩu mới</label>
                                <input type="password" name="mat_khau" id="mat_khau" required class="cai-dat-input">
                                <small class="cai-dat-input-hint" style="font-size: 11px; color: #94a3b8; display: block; margin-top: 2px;">* Độ dài từ 6 - 20 ký tự, phải bao gồm cả chữ và số.</small>
                                <span class="cai-dat-error-msg" id="err-mat_khau"></span>
                            </div>
                            <div class="cai-dat-form-group">
                                <label for="mat_khau_xac_nhan">Xác nhận mật khẩu mới</label>
                                <input type="password" name="mat_khau_xac_nhan" id="mat_khau_xac_nhan" required class="cai-dat-input">
                                <small class="cai-dat-input-hint" style="font-size: 11px; color: #94a3b8; display: block; margin-top: 2px;">* Nhập lại mật khẩu mới để xác nhận.</small>
                                <span class="cai-dat-error-msg" id="err-mat_khau_xac_nhan"></span>
                            </div>
                            <button type="submit" class="cai-dat-btn btn-primary" id="btnSubmitDoiMatKhau">Cập nhật mật khẩu</button>
                        </form>
                    </div>

                    <!-- TAB 2: THÔNG BÁO -->
                    <div class="cai-dat-tab-pane" id="tab-thong-bao">
                        <div class="cai-dat-setting-item">
                            <div class="setting-item-info">
                                <div class="setting-item-title">Thông báo từ hệ thống</div>
                                <div class="setting-item-desc">Nhận thông báo tự động về ngày lễ, sự kiện công việc sắp đến hạn và cảnh báo bảo mật.</div>
                            </div>
                            <label class="cai-dat-toggle">
                                <input type="checkbox" id="toggleThongBao" {{ (Auth::user()->thong_bao_bat ?? 1) ? 'checked' : '' }}>
                                <span class="cai-dat-toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- TAB 3: XÓA TÀI KHOẢN -->
                    <div class="cai-dat-tab-pane" id="tab-xoa-tai-khoan">
                        <div class="cai-dat-danger-zone">
                            <div class="danger-zone-title">⚠️ Cảnh báo quan trọng</div>
                            <p class="danger-zone-desc">Hành động này sẽ xóa mềm tài khoản của bạn khỏi hệ thống. Bạn sẽ bị đăng xuất ngay lập tức và không thể truy cập lại trang này trừ khi liên hệ Quản trị viên để khôi phục.</p>
                            
                            <div class="cai-dat-form-group" style="margin-top: 15px;">
                                <label for="inputXacNhanXoa">Vui lòng nhập chữ <strong style="color: #ef4444;">delete</strong> để xác nhận:</label>
                                <input type="text" id="inputXacNhanXoa" placeholder="Gõ 'delete' vào đây" autocomplete="off" class="cai-dat-input">
                                <small class="cai-dat-input-hint" style="font-size: 11px; color: #f87171; display: block; margin-top: 2px;">* Phải nhập chính xác chữ "delete" bằng chữ thường để xác nhận.</small>
                            </div>
                            <button type="button" class="cai-dat-btn btn-danger" id="btnXoaTaiKhoan" disabled>Xóa tài khoản của tôi</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Chính sách & Bảo mật -->
<div class="cai-dat-modal-overlay" id="policyModal" style="display: none;">
    <div class="cai-dat-modal-card small-modal">
        <div class="cai-dat-modal-header">
            <h3 class="cai-dat-modal-title">Chính sách & Bảo mật</h3>
            <button type="button" class="cai-dat-modal-close" onclick="dongPolicyModal()">&times;</button>
        </div>
        <div class="cai-dat-modal-body text-scroll">
            <h4 style="color: #e2e8f0; font-size: 14px; margin-top: 0; margin-bottom: 5px;">1. Thu thập thông tin</h4>
            <p style="margin-bottom: 12px; color: #94a3b8; font-size: 13px;">Hệ thống DPCS thu thập các thông tin hồ sơ cá nhân bao gồm họ tên, học vấn, lịch công việc, và hoạt động nhằm mục đích giúp bạn tự quản lý và chia sẻ hồ sơ chuyên môn của mình.</p>
            
            <h4 style="color: #e2e8f0; font-size: 14px; margin-top: 0; margin-bottom: 5px;">2. Bảo mật dữ liệu</h4>
            <p style="margin-bottom: 12px; color: #94a3b8; font-size: 13px;">Mật khẩu của bạn được mã hóa một chiều an toàn bằng thuật toán Bcrypt. Nhật ký hoạt động và thiết bị đăng nhập được ghi nhận đầy đủ để giúp bạn phát hiện sớm các bất thường.</p>
            
            <h4 style="color: #e2e8f0; font-size: 14px; margin-top: 0; margin-bottom: 5px;">3. Quyền của bạn</h4>
            <p style="margin-bottom: 12px; color: #94a3b8; font-size: 13px;">Bạn có toàn quyền chỉnh sửa thông tin, bật/tắt thông báo hoặc yêu cầu xóa tài khoản (xóa mềm) bất cứ lúc nào thông qua chức năng cài đặt.</p>
            
            <h4 style="color: #e2e8f0; font-size: 14px; margin-top: 0; margin-bottom: 5px;">4. Liên hệ</h4>
            <p style="margin-bottom: 0; color: #94a3b8; font-size: 13px;">Mọi thắc mắc về bảo mật và chính sách, vui lòng liên hệ ban quản trị hệ thống.</p>
        </div>
        <div class="cai-dat-modal-footer">
            <button type="button" class="cai-dat-btn btn-secondary" onclick="dongPolicyModal()">Đã hiểu</button>
        </div>
    </div>
</div>

<!-- 3. Modal Đóng góp ý kiến -->
<div class="cai-dat-modal-overlay" id="feedbackModal" style="display: none;">
    <div class="cai-dat-modal-card small-modal">
        <div class="cai-dat-modal-header">
            <h3 class="cai-dat-modal-title">Đóng góp ý kiến</h3>
            <button type="button" class="cai-dat-modal-close" onclick="dongFeedbackModal()">&times;</button>
        </div>
        <form id="formFeedback">
            <div class="cai-dat-modal-body">
                <p style="font-size: 13px; color: #94a3b8; margin-bottom: 15px;">Chúng tôi luôn lắng nghe ý kiến từ bạn để hoàn thiện hệ thống quản lý hồ sơ cá nhân DPCS ngày một tốt hơn.</p>
                <div class="cai-dat-form-group">
                    <label for="noi_dung_y_kien">Nội dung đóng góp ý kiến</label>
                    <textarea name="noi_dung" id="noi_dung_y_kien" required class="cai-dat-textarea" placeholder="Nhập ý kiến đóng góp của bạn tại đây (tối thiểu 10 ký tự)..." rows="5"></textarea>
                    <small class="cai-dat-input-hint" style="font-size: 11px; color: #94a3b8; display: block; margin-top: 2px;">* Độ dài từ 10 đến 1000 ký tự.</small>
                    <span class="cai-dat-error-msg" id="err-noi_dung_y_kien"></span>
                </div>
            </div>
            <div class="cai-dat-modal-footer">
                <button type="button" class="cai-dat-btn btn-secondary" onclick="dongFeedbackModal()">Hủy</button>
                <button type="submit" class="cai-dat-btn btn-primary" id="btnSubmitFeedback">Gửi đóng góp</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/ho-so/cai-dat.css') }}">
<script src="{{ asset('js/cai-dat.js') }}"></script>

