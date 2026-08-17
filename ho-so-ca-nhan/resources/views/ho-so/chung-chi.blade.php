<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chứng chỉ & Chứng nhận - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý danh sách bằng cấp, chứng chỉ chuyên môn và chứng nhận khóa học của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/chung-chi/chung-chi.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Chứng chỉ & Chứng nhận', 'searchPlaceholder' => 'Tìm kiếm chứng chỉ...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="certificate-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="certificate-title-section">
                    <h2>Chứng chỉ & Chứng nhận</h2>
                    <p>Quản lý danh sách bằng cấp, chứng chỉ chuyên môn và các khóa học đã hoàn thành.</p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" id="btn-them-chung-chi" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Thêm mới</span>
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

            {{-- CỘT TRÁI: Tổng quan tóm tắt --}}
            <div class="grid-column">

                {{-- Card thống kê chứng chỉ --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê chứng chỉ</span>
                        </h3>
                    </div>
                    @php
                        $tongSoChungChi = $danhSachChungChi->count();
                        $conHiuLuc = $danhSachChungChi->filter(function($cc) {
                            return is_null($cc->ngay_het_han) || strtotime($cc->ngay_het_han) >= time();
                        })->count();
                        $hetHiuLuc = $tongSoChungChi - $conHiuLuc;

                        $chuyenMonCount = $danhSachChungChi->where('phan_loai', 'chuyen_mon')->count();
                        $ngoaiNguCount = $danhSachChungChi->where('phan_loai', 'ngoai_ngu')->count();
                        $kyNangCount = $danhSachChungChi->where('phan_loai', 'ky_nang')->count();
                        $khacCount = $danhSachChungChi->where('phan_loai', 'khac')->count();
                    @endphp
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số chứng chỉ:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $tongSoChungChi }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Còn hiệu lực:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid">{{ $conHiuLuc }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Hết hiệu lực:</span>
                            <strong class="stats-value"><span class="stats-badge badge-expired">{{ $hetHiuLuc }}</span></strong>
                        </div>
                        <div class="stats-item" style="border-top: 1px dashed var(--border-color); margin-top: 8px; padding-top: 8px;">
                            <span class="stats-label">Chuyên môn:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $chuyenMonCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Ngoại ngữ:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $ngoaiNguCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Kỹ năng mềm:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $kyNangCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Khác:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $khacCount }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Danh sách chứng chỉ --}}
            <div class="grid-column">
                {{-- Bộ lọc --}}
                <div class="filter-card">
                    <!-- Row chính: Phân loại và các nút điều khiển -->
                    <div class="filter-main-row">
                        <div class="filter-col-phan-loai">
                            <select id="filter-phan-loai" class="filter-select">
                                <option value="">Tất cả phân loại</option>
                                <option value="chuyen_mon">Chuyên môn</option>
                                <option value="ngoai_ngu">Ngoại ngữ</option>
                                <option value="ky_nang">Kỹ năng mềm</option>
                                <option value="khac">Khác</option>
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
                                <span>Lọc theo ngày</span>
                                <svg id="toggle-dates-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 12px; height: 12px; transition: transform 0.2s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            
                            <button type="button" id="btn-reset-filters" class="btn-reset-filters">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                <span>Đặt lại</span>
                            </button>
                        </div>
                    </div>

                    <!-- Panel ngày tháng: Ẩn/Hiện khi click "Lọc theo ngày" -->
                    <div id="date-filters-panel" class="filter-dates-panel">
                        <div class="filter-dates-grid">
                            {{-- Ngày cấp --}}
                            <div class="filter-col-ngay-cap">
                                <label class="filter-label">Ngày cấp</label>
                                <div class="filter-date-inputs">
                                    <input type="date" id="filter-ngay-cap-tu" class="filter-input" placeholder="Từ ngày">
                                    <span class="filter-separator">đến</span>
                                    <input type="date" id="filter-ngay-cap-den" class="filter-input" placeholder="Đến ngày">
                                </div>
                            </div>

                            {{-- Ngày hết hạn --}}
                            <div class="filter-col-ngay-het-han">
                                <label class="filter-label">Ngày hết hạn</label>
                                <div class="filter-date-inputs">
                                    <input type="date" id="filter-ngay-het-han-tu" class="filter-input" placeholder="Từ ngày">
                                    <span class="filter-separator">đến</span>
                                    <input type="date" id="filter-ngay-het-han-den" class="filter-input" placeholder="Đến ngày">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="certificate-cards-container">
                    {{-- Card khi không tìm thấy kết quả lọc --}}
                    <div id="no-filter-results" class="no-results-card" style="display: none;">
                        <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="no-results-title">Không tìm thấy chứng chỉ phù hợp</h3>
                        <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
                    </div>

                    @if($danhSachChungChi->count() > 0)
                        @foreach($danhSachChungChi as $cc)
                            @php
                                $isExpired = !is_null($cc->ngay_het_han) && strtotime($cc->ngay_het_han) < time();
                            @endphp
                            <div class="certificate-card" 
                                 data-id="{{ $cc->id }}"
                                 data-noi-bat="{{ $cc->noi_bat ? '1' : '0' }}"
                                 onclick="moModalChiTietChungChi(event, {{ json_encode($cc) }})"
                                 data-phan-loai="{{ $cc->phan_loai }}" 
                                 data-ngay-cap="{{ $cc->ngay_cap }}" 
                                 data-ngay-het-han="{{ $cc->ngay_het_han }}">
                                {{-- Card Header --}}
                                <div class="certificate-card-header">
                                    <div class="certificate-icon-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                    <div class="certificate-main-info">
                                        <h3 class="certificate-name" style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                            @if($cc->noi_bat)
                                                <span class="badge-noi-bat">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                                                    Nổi bật
                                                </span>
                                            @endif
                                            {{ $cc->ten_chung_chi }}
                                        </h3>
                                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 4px;">
                                            <span class="certificate-issuer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; color: #475569;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                {{ $cc->to_chuc_cap }}
                                            </span>
                                            @if(($cc->phan_loai ?? null) === 'chuyen_mon')
                                                <span class="certificate-category-badge category-chuyen-mon">Chuyên môn</span>
                                            @elseif(($cc->phan_loai ?? null) === 'ngoai_ngu')
                                                <span class="certificate-category-badge category-ngoai-ngu">Ngoại ngữ</span>
                                            @elseif(($cc->phan_loai ?? null) === 'ky_nang')
                                                <span class="certificate-category-badge category-ky-nang">Kỹ năng mềm</span>
                                            @elseif(($cc->phan_loai ?? null) === 'khac')
                                                <span class="certificate-category-badge category-khac">Khác</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Actions --}}
                                <div class="certificate-card-actions" onclick="event.stopPropagation();">
                                    <button type="button" class="btn-toggle-noi-bat {{ $cc->noi_bat ? 'active' : '' }}"
                                        onclick="event.stopPropagation(); doToggleNoiBat('chung_chi', {{ $cc->id }}, this)"
                                        data-noi-bat="{{ $cc->noi_bat }}"
                                        title="{{ $cc->noi_bat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-cert-action edit" onclick="event.stopPropagation(); moModalSuaChungChi({{ json_encode($cc) }})" title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" class="btn-cert-action delete" onclick="event.stopPropagation(); xoaChungChi({{ $cc->id }}, '{{ route('ho-so.chung-chi.xoa', ['id' => $cc->id]) }}')" title="Xóa">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>

                                {{-- Card Details --}}
                                <div class="certificate-details-list">
                                    @if($cc->ma_chung_chi)
                                        <div class="certificate-detail-item">
                                            <span class="certificate-detail-label">Mã chứng chỉ:</span>
                                            <strong class="certificate-detail-value">{{ $cc->ma_chung_chi }}</strong>
                                        </div>
                                    @endif
                                    <div class="certificate-detail-item">
                                        <span class="certificate-detail-label">Ngày cấp:</span>
                                        <strong class="certificate-detail-value">{{ !is_null($cc->ngay_cap) ? date('d/m/Y', strtotime($cc->ngay_cap)) : 'Chưa cập nhật' }}</strong>
                                    </div>
                                    <div class="certificate-detail-item">
                                        <span class="certificate-detail-label">Ngày hết hạn:</span>
                                        <strong class="certificate-detail-value">{{ !is_null($cc->ngay_het_han) ? date('d/m/Y', strtotime($cc->ngay_het_han)) : 'Không hết hạn' }}</strong>
                                    </div>
                                    <div class="certificate-detail-item">
                                        <span class="certificate-detail-label">Trạng thái:</span>
                                        @if($isExpired)
                                            <span class="certificate-status-badge status-expired">Hết hạn</span>
                                        @else
                                            <span class="certificate-status-badge status-valid">Còn hiệu lực</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Card Footer --}}
                                @if($cc->url_tap_tin || $cc->file_pdf)
                                    <div class="certificate-card-footer" onclick="event.stopPropagation();" style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        @if($cc->url_tap_tin)
                                            <a href="{{ $cc->url_tap_tin }}" target="_blank" class="btn-view-credential" style="margin: 0;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                <span>Xem chứng chỉ</span>
                                            </a>
                                        @endif
                                        @if($cc->file_pdf)
                                            <a href="{{ asset($cc->file_pdf) }}" target="_blank" class="btn-view-credential" style="background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0; margin: 0;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                <span>Tệp PDF</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; color: var(--text-secondary); margin-bottom: 12px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Chưa có thông tin chứng chỉ</h3>
                            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 16px;">Vui lòng thêm thông tin chứng chỉ để hồ sơ của bạn trông chuyên nghiệp hơn.</p>
                            <button type="button" class="btn-edit-profile" onclick="moModalThemChungChi()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Thêm chứng chỉ mới</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</main>

{{-- MODAL: CHỨNG CHỈ & CHỨNG NHẬN --}}
<div class="modal-overlay" id="modal-chung-chi" role="dialog" aria-modal="true" aria-labelledby="modal-chung-chi-title">
    <div class="modal-panel max-w-3xl">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chung-chi-title">Cập nhật chứng chỉ</div>
                    <div class="modal-subtitle">Cập nhật thông tin bằng cấp, chứng chỉ hoặc chứng nhận của bạn</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chung-chi" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-chung-chi" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" id="input-cert-id" name="id">

                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input-cert-ten-chung-chi">Tên chứng chỉ / bằng cấp <span class="required">*</span></label>
                            <input type="text" id="input-cert-ten-chung-chi" name="ten_chung_chi" class="form-input" placeholder="VD: AWS Certified Cloud Practitioner" required minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 100 ký tự.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-cert-to-chuc-cap">Tổ chức cấp <span class="required">*</span></label>
                            <input type="text" id="input-cert-to-chuc-cap" name="to_chuc_cap" class="form-input" placeholder="VD: Amazon Web Services (AWS)" required minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 100 ký tự.</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-cert-ma-chung-chi">Mã chứng chỉ / Credential ID</label>
                            <input type="text" id="input-cert-ma-chung-chi" name="ma_chung_chi" class="form-input" placeholder="VD: AWS-SEC-ID-9921" maxlength="50">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Tối đa 50 ký tự.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-cert-url-tap-tin">Liên kết tập tin / Credential URL</label>
                            <input type="url" id="input-cert-url-tap-tin" name="url_tap_tin" class="form-input" placeholder="VD: https://docs.google.com" maxlength="500">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* URL minh chứng.</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-cert-file-pdf">Tải lên tệp PDF chứng chỉ</label>
                            <input type="file" id="input-cert-file-pdf" name="file_pdf" class="form-input" accept="application/pdf">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Định dạng .pdf, tối đa 5MB.</span>
                            <div id="cert-file-pdf-preview" style="margin-top: 6px; display: none; align-items: center; gap: 8px; font-size: 13px; color: var(--accent-blue);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <a href="#" id="cert-file-pdf-link" target="_blank" style="text-decoration: underline;">Xem file PDF hiện tại</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-cert-ngay-cap">Ngày cấp <span class="required">*</span></label>
                            <input type="date" id="input-cert-ngay-cap" name="ngay_cap" class="form-input" required>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Bắt buộc.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-cert-ngay-het-han">Ngày hết hạn (để trống nếu không hết hạn)</label>
                            <input type="date" id="input-cert-ngay-het-han" name="ngay_het_han" class="form-input">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải từ ngày cấp trở đi.</span>
                        </div>
                    </div>

                                    <div class="form-row" style="margin-top:14px;">
                                        <div class="form-group">
                                            <label class="form-label" for="input-cert-phan-loai">Phân loại chứng chỉ <span class="required">*</span></label>
                                            <select id="input-cert-phan-loai" name="phan_loai" class="form-select" style="width: 100%;" required>
                                                <option value="chuyen_mon" selected>Chuyên môn (Technical / Professional)</option>
                                                <option value="ngoai_ngu">Ngoại ngữ (Languages)</option>
                                                <option value="ky_nang">Kỹ năng mềm (Soft Skills)</option>
                                                <option value="khac">Khác (Others)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Hãy điền đầy đủ các thông tin bắt buộc (*)
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chung-chi">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-chung-chi">
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

{{-- MODAL: XEM CHI TIẾT CHỨNG CHỈ --}}
<div class="modal-overlay" id="modal-chi-tiet-chung-chi" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-chung-chi-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-chung-chi-title">Chi tiết chứng chỉ / bằng cấp</div>
                    <div class="modal-subtitle">Thông tin chi tiết bằng cấp, chứng chỉ hoặc chứng nhận của bạn</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-chung-chi" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section-two-columns">
                <!-- Column Left: Key details -->
                <div class="detail-column-left">
                    <div class="detail-group">
                        <span class="detail-label">Tên chứng chỉ / bằng cấp</span>
                        <div class="detail-value text-primary font-bold" id="detail-cert-name" style="font-size: 16px;"></div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Tổ chức cấp</span>
                        <div class="detail-value font-semibold" id="detail-cert-issuer" style="color: #059669; font-size: 15px;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Phân loại</span>
                            <div>
                                <span class="certificate-category-badge" id="detail-cert-category"></span>
                            </div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Mã chứng chỉ</span>
                            <div class="detail-value" id="detail-cert-code">-</div>
                        </div>
                    </div>
                </div>

                <!-- Column Right: Dates and links -->
                <div class="detail-column-right">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Ngày cấp</span>
                            <div class="detail-value font-semibold" id="detail-cert-date-issued"></div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Ngày hết hạn</span>
                            <div class="detail-value font-semibold" id="detail-cert-date-expired"></div>
                        </div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Trạng thái hiệu lực</span>
                        <div>
                            <span class="certificate-status-badge" id="detail-cert-status"></span>
                        </div>
                    </div>

                    <div class="detail-group" id="detail-cert-link-group" style="margin-top: 18px; display: none;">
                        <span class="detail-label">Đường dẫn liên kết</span>
                        <div class="detail-value" style="margin-top: 6px;">
                            <a href="#" id="detail-cert-link" target="_blank" class="btn-view-credential" style="font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Xem chứng chỉ gốc</span>
                            </a>
                        </div>
                    </div>

                    <div class="detail-group" id="detail-cert-pdf-group" style="margin-top: 14px; display: none;">
                        <span class="detail-label">Tệp PDF đính kèm</span>
                        <div class="detail-value" style="margin-top: 6px;">
                            <a href="#" id="detail-cert-pdf-link" target="_blank" class="btn-view-credential" style="font-size: 14px; display: inline-flex; align-items: center; gap: 6px; background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Xem tệp PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-chung-chi" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-chung-chi" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-chung-chi" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Sửa
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JAVASCRIPT CONFIG (Routes) --}}
<script>
    window.ROUTES = {
        luuChungChi: "{{ route('ho-so.chung-chi.luu') }}",
        xoaChungChi: "{{ route('ho-so.chung-chi.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        toggleNoiBat: {
            chung_chi: "{{ route('ho-so.chung-chi.toggle-noi-bat', ['id' => '__ID__']) }}"
        }
    };

    function doToggleNoiBat(module, id, btn) {
        btn.classList.add('spin-once');
        btn.addEventListener('animationend', () => btn.classList.remove('spin-once'), { once: true });
        toggleNoiBat(module, id, btn);
    }
</script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/chung-chi/chung-chi.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/noi-bat.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

