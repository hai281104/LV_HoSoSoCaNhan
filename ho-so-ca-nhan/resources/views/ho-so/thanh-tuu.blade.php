<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thành tựu cá nhân - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý giải thưởng, học bổng và cột mốc nổi bật của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/thanh-tuu/thanh-tuu.css') }}?v={{ time() }}">

    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Thành tựu', 'searchPlaceholder' => 'Tìm kiếm thành tựu...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="thanh-tuu-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="thanh-tuu-title-section">
                    <h2>Thành tựu cá nhân</h2>
                    <p>Nơi lưu trữ các giải thưởng, học bổng và cột mốc xuất sắc trong quá trình học tập và làm việc.</p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" id="btn-them-thanh-tuu" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Thêm thành tựu mới</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Banner thông báo nổi bật tự động vào CV --}}
        <div class="noi-bat-notice">
            <div class="noi-bat-notice-icon">💡</div>
            <div class="noi-bat-notice-text">
                Các mục được đánh dấu nổi bật (<span style="color:#d97706;">★</span>) sẽ được hệ thống tự động thêm vào <strong>CV tự động</strong> để tối ưu hóa hồ sơ năng lực.
            </div>
        </div>

        {{-- Profile Grid (2 Columns) --}}
        <div class="profile-grid">

            {{-- CỘT TRÁI: Thống kê thành tựu --}}
            <div class="grid-column">
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê thành tựu</span>
                        </h3>
                    </div>
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số thành tựu:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $tongSoThanhTuu }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Giải thưởng / Huy chương:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid">{{ $giaiThuongCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Học bổng:</span>
                            <strong class="stats-value"><span class="stats-badge" style="background-color: #fef3c7; color: #d97706; display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 20px; border-radius: 10px; font-size: 11.5px; font-weight: 700;">{{ $hocBongCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Danh hiệu / Cột mốc:</span>
                            <strong class="stats-value"><span class="stats-badge" style="background-color: #eff6ff; color: #1d4ed8; display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 20px; border-radius: 10px; font-size: 11.5px; font-weight: 700;">{{ $danhHieuCount }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Bộ lọc & Danh sách thành tựu --}}
            <div class="grid-column">
                {{-- Bộ lọc --}}
                <div class="filter-card">
                    <div class="filter-main-row">
                        <div class="filter-col-phan-loai">
                            <select id="filter-phan-loai" class="filter-select">
                                <option value="">Tất cả phân loại</option>
                                <option value="giai_thuong">Giải thưởng</option>
                                <option value="hoc_bong">Học bổng</option>
                                <option value="danh_hieu">Danh hiệu</option>
                            </select>
                        </div>

                        <div class="filter-col-phan-loai">
                            <select id="filter-noi-bat" class="filter-select">
                                <option value="">Tất cả độ nổi bật</option>
                                <option value="1">⭐ Nổi bật</option>
                                <option value="0">Không nổi bật</option>
                            </select>
                        </div>

                        <div class="filter-actions-group">
                            <button type="button" id="btn-toggle-date-filters" class="btn-toggle-dates">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Lọc theo thời gian</span>
                                <svg id="toggle-dates-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 12px; height: 12px; transition: transform 0.2s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            
                            <button type="button" id="btn-reset-filters" class="btn-reset-filters">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                <span>Đặt lại</span>
                            </button>
                        </div>
                    </div>

                    <!-- Panel ngày tháng: Ẩn/Hiện khi click "Lọc theo thời gian" -->
                    <div id="date-filters-panel" class="filter-dates-panel">
                        <div class="filter-dates-grid" style="grid-template-columns: 1fr;">
                            {{-- Thời gian đạt được --}}
                            <div class="filter-col-ngay-cap" style="width: 100%;">
                                <label class="filter-label">Ngày đạt được</label>
                                <div class="filter-date-inputs">
                                    <input type="date" id="filter-ngay-dat-duoc-tu" class="filter-input" placeholder="Từ ngày">
                                    <span class="filter-separator">đến</span>
                                    <input type="date" id="filter-ngay-dat-duoc-den" class="filter-input" placeholder="Đến ngày">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="thanh-tuu-cards-container">
                    {{-- Card khi không tìm thấy kết quả lọc --}}
                    <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                        <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="no-results-title">Không tìm thấy thành tựu phù hợp</h3>
                        <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
                    </div>

                    @if($danhSachThanhTuu->count() > 0)
                        @foreach($danhSachThanhTuu as $tt)
                            <div class="achievement-card" 
                                 data-id="{{ $tt->id }}"
                                 data-noi-bat="{{ $tt->noi_bat ? '1' : '0' }}"
                                 onclick="moModalChiTietThanhTuu(event, {{ json_encode($tt) }})"
                                 data-phan-loai="{{ $tt->phan_loai }}"
                                 data-thoi-gian="{{ $tt->thoi_gian }}">
                                {{-- Banner --}}
                                <div class="achievement-banner-wrapper">
                                    @if($tt->anh_minh_hoa)
                                        <img src="{{ asset($tt->anh_minh_hoa) }}" alt="Banner" class="achievement-banner-img">
                                    @else
                                        <div class="achievement-banner-placeholder" style="position: absolute; top:0; left:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f1f5f9; color:#94a3b8;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 36px; height: 36px; opacity:0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    
                                    @if($tt->phan_loai === 'giai_thuong')
                                        <span class="achievement-badge-pill badge-giai-thuong">Giải thưởng</span>
                                    @elseif($tt->phan_loai === 'hoc_bong')
                                        <span class="achievement-badge-pill badge-hoc-bong">Học bổng</span>
                                    @elseif($tt->phan_loai === 'danh_hieu')
                                        <span class="achievement-badge-pill badge-danh-hieu">Danh hiệu</span>
                                    @endif
                                </div>

                                {{-- Body --}}
                                <div class="achievement-card-body">
                                    <h3 class="achievement-name" style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                        @if($tt->noi_bat)
                                            <span class="badge-noi-bat">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                                                Nổi bật
                                            </span>
                                        @endif
                                        {{ $tt->ten_thanh_tuu }}
                                    </h3>
                                    <div class="achievement-meta-row">
                                        @if($tt->to_chuc_cap)
                                            <span class="achievement-issuer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                {{ $tt->to_chuc_cap }}
                                            </span>
                                        @endif
                                        @if($tt->thoi_gian)
                                            <span class="achievement-time">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $tt->thoi_gian }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($tt->mo_ta)
                                        <p class="achievement-desc">{{ $tt->mo_ta }}</p>
                                    @endif
                                    
                                    {{-- Card Footer --}}
                                    <div class="achievement-card-footer" onclick="event.stopPropagation();">
                                        @if($tt->phan_loai === 'giai_thuong')
                                            <div class="achievement-category-icon-box icon-box-giai-thuong" title="Giải thưởng">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                                            </div>
                                        @elseif($tt->phan_loai === 'hoc_bong')
                                            <div class="achievement-category-icon-box icon-box-hoc-bong" title="Học bổng">
                                                <!-- Graduation cap representation or ribbon medal -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                            </div>
                                        @elseif($tt->phan_loai === 'danh_hieu')
                                            <div class="achievement-category-icon-box icon-box-danh-hieu" title="Danh hiệu">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                            </div>
                                        @endif
                                        
                                        <div class="achievement-card-actions" style="display: flex; gap: 6px; align-items: center; margin-left: auto;">
                                            <button type="button" class="btn-toggle-noi-bat {{ $tt->noi_bat ? 'active' : '' }}"
                                                onclick="event.stopPropagation(); doToggleNoiBat('thanh_tuu', {{ $tt->id }}, this)"
                                                data-noi-bat="{{ $tt->noi_bat }}"
                                                title="{{ $tt->noi_bat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn-edu-action edit" onclick="event.stopPropagation(); moModalSuaThanhTuu({{ json_encode($tt) }})" title="Chỉnh sửa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <button type="button" class="btn-edu-action delete" onclick="event.stopPropagation(); xoaThanhTuu({{ $tt->id }})" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; color: var(--text-secondary); margin-bottom: 12px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Chưa có thông tin thành tựu</h3>
                            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 16px;">Vui lòng thêm thông tin các thành tựu, giải thưởng hoặc học bổng nổi bật.</p>
                            <button type="button" class="btn-edit-profile" onclick="moModalThemThanhTuu()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Thêm thành tựu mới</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</main>

{{-- MODAL: THÊM MỚI / CHỈNH SỬA THÀNH TỰU --}}
<div class="modal-overlay" id="modal-thanh-tuu" role="dialog" aria-modal="true" aria-labelledby="modal-thanh-tuu-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-thanh-tuu-title">Cập nhật thành tựu</div>
                    <div class="modal-subtitle">Thêm mới hoặc cập nhật các giải thưởng, học bổng và cột mốc nổi bật</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-thanh-tuu" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-thanh-tuu" autocomplete="off" class="modal-form-two-columns">
                <input type="hidden" id="input-achievement-id" name="id">
                <input type="hidden" id="input-achievement-cover-base64" name="anh_minh_hoa">

                <!-- Column Left: Inputs -->
                <div class="modal-column-left">
                    <div class="form-group">
                        <label class="form-label" for="input-achievement-name">Tên thành tựu / giải thưởng <span class="required">*</span></label>
                        <input type="text" id="input-achievement-name" name="ten_thanh_tuu" class="form-input" placeholder="VD: Giải Nhì Hackathon HCMUT 2025" required minlength="2" maxlength="100">
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 100 ký tự.</span>
                    </div>
                    
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label" for="input-achievement-issuer">Đơn vị trao</label>
                        <input type="text" id="input-achievement-issuer" name="to_chuc_cap" class="form-input" placeholder="VD: Đại học Bách Khoa TP.HCM" minlength="2" maxlength="100">
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 100 ký tự.</span>
                    </div>

                    <div class="form-row-compact" style="margin-top:12px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label" for="input-time-specific">Thời gian đạt được <span class="required" id="indicator-time-required">*</span></label>
                            <input type="date" id="input-time-specific" class="form-input" style="width: 100%;" required>
                            <input type="hidden" id="input-achievement-time" name="thoi_gian">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Bắt buộc.</span>
                            
                            <div style="display: flex; align-items: center; gap: 6px; margin-top: 6px;">
                                <input type="checkbox" id="checkbox-no-time" style="cursor: pointer; width: auto; height: auto;">
                                <label for="checkbox-no-time" style="font-size: 11.5px; color: var(--text-secondary); cursor: pointer; user-select: none; margin-bottom: 0;">Không thời gian</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-achievement-category">Phân loại <span class="required">*</span></label>
                            <select id="input-achievement-category" name="phan_loai" class="form-select" style="width: 100%; height: 38px;" required>
                                <option value="giai_thuong" selected>Giải thưởng</option>
                                <option value="hoc_bong">Học bổng</option>
                                <option value="danh_hieu">Danh hiệu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="form-label" for="input-achievement-desc" style="margin-bottom:0;">Mô tả chi tiết</label>
                            <span style="font-size: 11px; color: #94a3b8;"><span id="achievement-desc-counter">0</span>/500 ký tự</span>
                        </div>
                        <textarea id="input-achievement-desc" name="mo_ta" class="form-textarea" style="height: 220px; resize: vertical; padding: 10px;" placeholder="Mô tả tóm tắt về vị trí đạt được, nội dung thành tựu..." maxlength="500"></textarea>
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Tối đa 500 ký tự.</span>
                    </div>
                    
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label" for="input-achievement-link">Link minh chứng</label>
                        <input type="url" id="input-achievement-link" name="link_minh_chung" class="form-input" placeholder="VD: https://drive.google.com/xyz (nếu có)" maxlength="500">
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* URL minh chứng.</span>
                    </div>
                </div>

                <!-- Column Right: Cover Image Upload -->
                <div class="modal-column-right">
                    <div class="form-group">
                        <label class="form-label">Ảnh bìa minh họa (Định dạng JPG, PNG, WebP; Tối đa 2MB)</label>
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px;">
                            <button type="button" class="btn-achievement-edit" id="btn-upload-cover" style="margin: 0; background-color: var(--accent-blue); color: white; border-color: transparent; display: inline-flex; align-items: center; gap: 6px; height: 32px; padding: 0 10px; font-size: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Tải ảnh lên</span>
                            </button>
                            <button type="button" class="btn-achievement-edit" id="btn-delete-cover" style="margin: 0; color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: none; height: 32px; padding: 0 10px; font-size: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Xóa ảnh</span>
                            </button>
                            <input type="file" id="cover-file-input" style="display: none;" accept="image/jpeg,image/png,image/webp,image/jpg">
                        </div>
                        
                        <!-- Crop Panel -->
                        <div class="image-crop-section" id="cover-crop-section" style="padding: 10px; margin-top: 4px;">
                            <div class="crop-canvas-wrapper" style="max-height: 160px; margin-bottom: 8px;">
                                <img id="cover-crop-image" src="" alt="To Crop">
                            </div>
                            <div class="crop-controls">
                                <button type="button" class="btn-crop-action btn-crop-apply-custom" id="btn-cover-crop-apply" style="height: 28px; padding: 0 10px; font-size: 11px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Cắt (16:9)
                                </button>
                                <button type="button" class="btn-crop-action btn-crop-cancel-custom" id="btn-cover-crop-cancel" style="height: 28px; padding: 0 10px; font-size: 11px;">Huỷ</button>
                            </div>
                        </div>
                        
                        <!-- Preview Box -->
                        <div class="cover-preview-box" style="margin-top: 4px;">
                            <div class="cover-preview-placeholder" id="cover-preview-placeholder" style="padding: 15px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 28px; height: 28px; margin-bottom: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span style="font-size: 12px; line-height: 1.3;">Chưa chọn ảnh bìa (16:9)</span>
                            </div>
                            <img id="cover-preview-img" src="" style="display: none;" alt="Cover Preview">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-thanh-tuu">Huỷ</button>
                <!-- Nút xóa bản ghi đặt ở chân modal khi sửa -->
                <button type="button" class="btn-cancel" id="btn-xoa-thanh-tuu" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: none; margin-right: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; display: inline; vertical-align: middle; margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Xóa thành tựu
                </button>
                <button type="button" class="btn-save" id="btn-luu-thanh-tuu">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Lưu thông tin
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: XEM CHI TIẾT THÀNH TỰU --}}
<div class="modal-overlay" id="modal-chi-tiet-thanh-tuu" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-thanh-tuu-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-thanh-tuu-title">Chi tiết thành tựu</div>
                    <div class="modal-subtitle">Thông tin chi tiết về giải thưởng, học bổng hoặc danh hiệu đạt được</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-thanh-tuu" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section-two-columns">
                <!-- Column Left: Text Details -->
                <div class="detail-column-left">
                    <div class="detail-group">
                        <span class="detail-label">Tên thành tựu / giải thưởng</span>
                        <div class="detail-value text-primary font-bold" id="detail-achievement-name" style="font-size: 16px;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Tổ chức cấp / Trường</span>
                            <div class="detail-value font-semibold" id="detail-achievement-issuer" style="color: #059669;">-</div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Phân loại</span>
                            <div>
                                <span class="achievement-badge-pill" id="detail-achievement-category" style="position: static; box-shadow: none;"></span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Thời gian đạt được</span>
                        <div class="detail-value" id="detail-achievement-time">-</div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Mô tả chi tiết</span>
                        <div class="detail-value textarea-style" id="detail-achievement-desc">-</div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;" id="detail-achievement-link-container">
                        <span class="detail-label">Link minh chứng</span>
                        <div class="detail-value">
                            <a href="" id="detail-achievement-link" target="_blank" style="color: var(--accent-blue); font-weight: 600; text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span id="detail-achievement-link-text">Xem tài liệu minh chứng</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Column Right: Banner Cover -->
                <div class="detail-column-right" id="detail-achievement-banner-container">
                    <span class="detail-label" style="margin-bottom: 8px;">Ảnh bìa minh họa</span>
                    <!-- Cover Image display (aspect ratio 16:9, clickable) -->
                    <div class="detail-banner-clickable" id="detail-achievement-banner-wrapper" style="display: none; margin-bottom: 0;">
                        <img src="" id="detail-achievement-banner" alt="Cover Image">
                        <div class="detail-banner-overlay">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Xem ảnh kích thước lớn</span>
                        </div>
                    </div>
                    <!-- Placeholder when no cover is uploaded -->
                    <div class="detail-banner-placeholder-box" id="detail-achievement-banner-placeholder" style="display: flex; align-items: center; justify-content: center; border: 1px dashed var(--border-color); border-radius: 8px; background: #f8fafc; aspect-ratio: 16/9; color: #94a3b8; flex-direction: column; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 32px; height: 32px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span style="font-size: 12.5px;">Không có ảnh bìa</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-thanh-tuu" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-thanh-tuu" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-thanh-tuu" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Sửa
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Lightbox Overlay --}}
<div id="achievementLightbox" class="lightbox-overlay" style="display: none;">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage" src="" alt="Full Cover Image">
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JAVASCRIPT CONFIG (Routes) --}}
<script>
    window.ROUTES = {
        luuThanhTuu: "{{ route('ho-so.thanh-tuu.luu') }}",
        xoaThanhTuu: "{{ route('ho-so.thanh-tuu.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        toggleNoiBat: {
            thanh_tuu: "{{ route('ho-so.thanh-tuu.toggle-noi-bat', ['id' => '__ID__']) }}"
        }
    };

    function doToggleNoiBat(module, id, btn) {
        btn.classList.add('spin-once');
        btn.addEventListener('animationend', () => btn.classList.remove('spin-once'), { once: true });
        toggleNoiBat(module, id, btn);
    }
</script>

{{-- Cropper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/thanh-tuu/thanh-tuu.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/noi-bat.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

