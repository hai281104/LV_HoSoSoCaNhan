<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tổng quan Dashboard - {{ $hoTen }}</title>

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/tong-quan.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Tổng quan Dashboard', 'searchPlaceholder' => 'Tìm kiếm...', 'disableSearch' => true])

    {{-- Content Body --}}
    <div class="content-body">
        
        {{-- Dashboard Top Header Grid --}}
        <div class="dashboard-top-grid">
            {{-- Welcome Banner Card --}}
            <div class="dashboard-welcome-card">
                <div class="welcome-content">
                    <h2 class="welcome-title">Xin chào, {{ $hoTen }}! </h2>
                    <p class="welcome-desc">Chào mừng bạn trở lại. Hôm nay là ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}. Hãy xem qua các thống kê hồ sơ cá nhân và sử dụng các phím tắt nhanh bên dưới để quản lý hành trình nghề nghiệp của bạn.</p>
                    
                    <div class="completion-wrapper">
                        <div class="completion-header">
                            <span>Độ hoàn thiện thông tin cơ bản</span>
                            <span>{{ $doHoanThien }}%</span>
                        </div>
                        <div class="completion-bar-bg">
                            <div class="completion-bar-fill" style="width: {{ $doHoanThien }}%"></div>
                        </div>
                        @if(count($missingFields) > 0)
                            <div class="completion-suggestion">
                                <span class="suggestion-icon"></span>
                                <span>Để đạt 100%, bạn cần bổ sung: <strong class="highlight-fields">{{ implode(', ', $missingFields) }}</strong>.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- User Profile Mini Card --}}
            <div class="dashboard-profile-card">
                <div class="profile-card-glow"></div>
                <div class="profile-avatar-wrapper">
                    @if($anhDaiDien)
                        <img src="{{ asset($anhDaiDien) }}" alt="Avatar" class="profile-avatar-lg">
                    @else
                        <div class="profile-avatar-lg-initials">{{ $tenRutGon }}</div>
                    @endif
                    <span class="status-badge-online" title="Đang hoạt động"></span>
                </div>
                
                <h3 class="profile-name-lg">{{ $hoTen }}</h3>
                <p class="profile-title-lg">{{ $chucDanh }}</p>
                
                <div class="profile-quick-stats">
                    <div class="quick-stat-item">
                        <span class="quick-stat-value">{{ $cvCount }}</span>
                        <span class="quick-stat-lbl">CV</span>
                    </div>
                    <div class="quick-stat-divider"></div>
                    <div class="quick-stat-item">
                        <span class="quick-stat-value">{{ $doHoanThien }}%</span>
                        <span class="quick-stat-lbl">Hoàn thiện</span>
                    </div>
                </div>

                <div class="profile-quick-actions">
                    <a href="{{ route('ho-so') }}" class="btn-profile-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Sửa hồ sơ
                    </a>
                    <a href="{{ route('ho-so.xem-truoc-in') }}" class="btn-profile-preview" target="_blank" title="Xem trước bản in A4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <h3 class="action-section-title" style="margin-top: 12px;">Thống kê tổng quan</h3>
        <div class="stats-grid">
            {{-- CVs --}}
            <a href="{{ route('ho-so.cv.index') }}" style="text-decoration: none;" class="stat-card card-blue">
                <div class="stat-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $cvCount }}</div>
                    <div class="stat-label">Quản lý CV</div>
                </div>
            </a>

            {{-- Projects --}}
            <a href="{{ route('ho-so.du-an') }}" style="text-decoration: none;" class="stat-card card-green">
                <div class="stat-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $duAnCount }}</div>
                    <div class="stat-label">Portfolio dự án</div>
                </div>
            </a>

            {{-- Education --}}
            <a href="{{ route('ho-so.hoc-van') }}" style="text-decoration: none;" class="stat-card card-purple">
                <div class="stat-icon icon-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $hocVanCount }}</div>
                    <div class="stat-label">Học vấn & Trình độ</div>
                </div>
            </a>

            {{-- Experience --}}
            <a href="{{ route('ho-so.kinh-nghiem') }}" style="text-decoration: none;" class="stat-card card-indigo">
                <div class="stat-icon icon-indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $kinhNghiemCount }}</div>
                    <div class="stat-label">Kinh nghiệm làm việc</div>
                </div>
            </a>

            {{-- Certificates --}}
            <a href="{{ route('ho-so.chung-chi') }}" style="text-decoration: none;" class="stat-card card-amber">
                <div class="stat-icon icon-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $chungChiCount }}</div>
                    <div class="stat-label">Chứng chỉ</div>
                </div>
            </a>

            {{-- Achievements --}}
            <a href="{{ route('ho-so.thanh-tuu') }}" style="text-decoration: none;" class="stat-card card-rose">
                <div class="stat-icon icon-rose">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $thanhTuuCount }}</div>
                    <div class="stat-label">Thành tựu</div>
                </div>
            </a>

            {{-- Albums --}}
            <a href="{{ route('ho-so.album') }}" style="text-decoration: none;" class="stat-card card-teal">
                <div class="stat-icon icon-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $suKienCount }}</div>
                    <div class="stat-label">Album ảnh nổi bật</div>
                </div>
            </a>
        </div>

        {{-- Quick Actions --}}
        <h3 class="action-section-title">Phím tắt thao tác nhanh</h3>
        <div class="action-grid">
            {{-- Edit Profile --}}
            <div class="action-card">
                <div class="action-header">
                    <h4 class="action-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Thông tin hồ sơ
                    </h4>
                    <p class="action-desc">Cập nhật thông tin cá nhân cơ bản, ảnh đại diện, viết lời giới thiệu bản thân và lựa chọn các kỹ năng chuyên môn.</p>
                </div>
                <a href="{{ route('ho-so') }}" class="btn-action-go">Cập nhật ngay <span>&rarr;</span></a>
            </div>

            {{-- Manage CV --}}
            <div class="action-card">
                <div class="action-header">
                    <h4 class="action-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Thiết kế CV
                    </h4>
                    <p class="action-desc">Tạo mới hoặc tùy chỉnh các mẫu CV xin việc khác nhau. Bạn có thể thay đổi bố cục, chọn mẫu hiện đại hoặc cổ điển.</p>
                </div>
                <a href="{{ route('ho-so.cv.index') }}" class="btn-action-go">Quản lý CV <span>&rarr;</span></a>
            </div>

            {{-- Work & Edu --}}
            <div class="action-card">
                <div class="action-header">
                    <h4 class="action-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        Trình độ & Dự án
                    </h4>
                    <p class="action-desc">Thêm mới thông tin quá trình học tập tại các trường, các công ty từng làm việc cùng danh sách dự án trong Portfolio.</p>
                </div>
                <a href="{{ route('ho-so.hoc-van') }}" class="btn-action-go">Thêm thông tin <span>&rarr;</span></a>
            </div>

            {{-- Share --}}
            <div class="action-card">
                <div class="action-header">
                    <h4 class="action-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l4.828-2.414m0 5.344l-4.828-2.414zm6.086-4.238a3 3 0 11-5.714 0 3 3 0 015.714 0zm-5.71 8.824a3 3 0 11-5.714 0 3 3 0 015.714 0zm5.71-3.002a3 3 0 11-5.714 0 3 3 0 015.714 0z"/></svg>
                        Xuất file & Chia sẻ
                    </h4>
                    <p class="action-desc">Tải trực tiếp bản CV chính thức hoặc toàn bộ Hồ sơ năng lực cá nhân dạng PDF. Gửi nhanh qua Zalo hoặc soạn mail qua Gmail.</p>
                </div>
                <a href="{{ route('ho-so.chia-se') }}" class="btn-action-go">Đến trang Chia sẻ <span>&rarr;</span></a>
            </div>
        </div>

    </div>
</main>

<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

