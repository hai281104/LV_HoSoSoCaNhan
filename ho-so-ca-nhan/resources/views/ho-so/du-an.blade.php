<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portfolio dự án - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý danh sách dự án, sản phẩm và portfolio công nghệ của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/du-an/du-an.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Portfolio dự án', 'searchPlaceholder' => 'Tìm kiếm dự án...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="project-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="project-title-section">
                    <h2>Portfolio dự án</h2>
                    <p>Lưu trữ, quản lý và trình bày các sản phẩm phần mềm, đồ án công nghệ thực chiến.</p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" id="btn-them-du-an" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Thêm dự án mới</span>
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

            {{-- CỘT TRÁI: Thống kê dự án --}}
            <div class="grid-column">
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê dự án</span>
                        </h3>
                    </div>
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số dự án:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $tongSoDuAn }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đang thực hiện:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid">{{ $dangThucHienCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đã hoàn thành:</span>
                            <strong class="stats-value"><span class="stats-badge badge-expired">{{ $daHoanThanhCount }}</span></strong>
                        </div>
                        
                        @if(count($techCounts) > 0)
                            <div class="stats-item" style="border-top: 1px dashed var(--border-color); margin-top: 8px; padding-top: 8px;">
                                <span class="stats-label" style="font-weight: 600; color: var(--text-primary);">Top công nghệ:</span>
                            </div>
                            @php $i = 0; @endphp
                            @foreach($techCounts as $tech => $info)
                                @if($i++ < 5)
                                    <div class="stats-item">
                                        <span class="stats-label">{{ $info['name'] }}:</span>
                                        <strong class="stats-value"><span class="stats-badge badge-normal">{{ $info['count'] }}</span></strong>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Bộ lọc & Danh sách dự án --}}
            <div class="grid-column">
                @if($tongSoDuAn > 0)
                    {{-- Bộ lọc --}}
                    <div class="filter-card">
                    <!-- Row chính: Từ khóa công nghệ và các nút điều khiển -->
                    <div class="filter-main-row">
                        <div class="filter-col-phan-loai">
                            <select id="filter-cong-nghe" class="filter-select">
                                <option value="">Tất cả công nghệ</option>
                                @foreach($cacCongNghe as $techName)
                                    <option value="{{ $techName }}">{{ $techName }}</option>
                                @endforeach
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
                        <div class="filter-dates-grid">
                            {{-- Thời gian bắt đầu --}}
                            <div class="filter-col-ngay-cap">
                                <label class="filter-label">Dự án bắt đầu từ ngày</label>
                                <div class="filter-date-inputs">
                                    <input type="date" id="filter-ngay-bat-dau-tu" class="filter-input" placeholder="Từ ngày">
                                    <span class="filter-separator">đến</span>
                                    <input type="date" id="filter-ngay-bat-dau-den" class="filter-input" placeholder="Đến ngày">
                                </div>
                            </div>

                            {{-- Thời gian kết thúc --}}
                            <div class="filter-col-ngay-het-han">
                                <label class="filter-label">Dự án kết thúc từ ngày</label>
                                <div class="filter-date-inputs">
                                    <input type="date" id="filter-ngay-ket-thuc-tu" class="filter-input" placeholder="Từ ngày">
                                    <span class="filter-separator">đến</span>
                                    <input type="date" id="filter-ngay-ket-thuc-den" class="filter-input" placeholder="Đến ngày">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Container chứa danh sách card dự án --}}
                <div class="project-list-container" style="display: flex; flex-direction: column; width: 100%;">
                    {{-- Card khi không tìm thấy kết quả lọc --}}
                    <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                        <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="no-results-title">Không tìm thấy dự án phù hợp</h3>
                        <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
                    </div>

                    @if($danhSachDuAn->count() > 0)
                        <div class="project-cards-container">
                            @foreach($danhSachDuAn as $da)
                                <div class="project-card" onclick="moModalChiTietDuAn(event, {{ json_encode($da) }})" 
                                     data-id="{{ $da->id }}"
                                     data-noi-bat="{{ $da->noi_bat ? '1' : '0' }}"
                                     data-ngay-bat-dau="{{ $da->ngay_bat_dau }}" 
                                     data-ngay-ket-thuc="{{ $da->ngay_ket_thuc }}" 
                                     data-tu-khoa="{{ json_encode(array_map('mb_strtolower', $da->tu_khoa)) }}"
                                     style="cursor: pointer;">
                                    
                                    {{-- Header sạch sẽ --}}
                                    <div class="project-card-header">
                                        <h3 class="project-card-title" style="margin-bottom: 0; display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                            @if($da->noi_bat)
                                                <span class="badge-noi-bat">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                                                    Nổi bật
                                                </span>
                                            @endif
                                            {{ $da->ten_du_an }}
                                        </h3>
                                        <div class="project-card-actions-inline">
                                            <button type="button" class="btn-toggle-noi-bat {{ $da->noi_bat ? 'active' : '' }}"
                                                onclick="event.stopPropagation(); doToggleNoiBat('du_an', {{ $da->id }}, this)"
                                                data-noi-bat="{{ $da->noi_bat }}"
                                                title="{{ $da->noi_bat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn-edu-action edit" onclick="event.stopPropagation(); moModalSuaDuAn(event, {{ json_encode($da) }})" title="Sửa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <button type="button" class="btn-edu-action delete" onclick="event.stopPropagation(); xoaDuAn(event, {{ $da->id }})" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Nội dung --}}
                                    <div class="project-card-body" style="padding-top: 8px;">
                                        @if($da->vai_tro)
                                            <div class="project-card-role" style="font-size: 13px; font-weight: 600; color: var(--accent-blue); margin-bottom: 8px; display: flex; align-items: center; gap: 4px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; opacity: 0.8;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                <span>{{ $da->vai_tro }}</span>
                                            </div>
                                        @endif
                                        
                                        <p class="project-card-desc">{{ $da->mo_ta }}</p>

                                        {{-- Từ khóa/Công nghệ --}}
                                        @if(!empty($da->tu_khoa))
                                            <div class="project-card-tags">
                                                @foreach($da->tu_khoa as $tag)
                                                    <span class="project-tag">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Footer --}}
                                        <div class="project-card-footer">
                                            <div class="project-date">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                                                @php
                                                    $batDau = date('m/Y', strtotime($da->ngay_bat_dau));
                                                    $ketThuc = $da->ngay_ket_thuc ? date('m/Y', strtotime($da->ngay_ket_thuc)) : 'Hiện tại';
                                                @endphp
                                                <span>{{ $batDau }} - {{ $ketThuc }}</span>
                                            </div>

                                            <div class="project-links" onclick="event.stopPropagation();">
                                                @foreach($da->lien_ket as $lk)
                                                    @php
                                                        $iconSvg = '';
                                                        if($lk->loai_lien_ket === 'github') {
                                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.579.688.481C19.137 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>';
                                                        } elseif($lk->loai_lien_ket === 'demo') {
                                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>';
                                                        } else {
                                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
                                                        }
                                                    @endphp
                                                    <a href="{{ $lk->duong_dan }}" target="_blank" class="project-link-icon" title="{{ $lk->nhan_hien_thi ?: ucfirst($lk->loai_lien_ket) }}">
                                                        {!! $iconSvg !!}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                </div>
            @else
                <div style="text-align: center; padding: 64px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); max-width: 600px; margin: 30px auto; width: 100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 56px; height: 56px; color: var(--text-secondary); margin-bottom: 16px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 00-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <h3 style="font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px;">Chưa có thông tin dự án</h3>
                    <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">Vui lòng thêm sản phẩm hoặc dự án công nghệ của bạn vào portfolio.</p>
                    <button type="button" class="btn-edit-profile" onclick="moModalThemDuAn()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Thêm dự án mới</span>
                    </button>
                </div>
            @endif
        </div>
        </div>

    </div>
</main>

{{-- MODAL: CẬP NHẬT DỰ ÁN --}}
<div class="modal-overlay" id="modal-du-an" role="dialog" aria-modal="true" aria-labelledby="modal-du-an-title">
    <div class="modal-panel max-w-3xl">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-du-an-title">Cập nhật thông tin dự án</div>
                    <div class="modal-subtitle">Thêm mới hoặc cập nhật thông tin sản phẩm và liên kết dự án</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-du-an" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-du-an" autocomplete="off">
                <input type="hidden" id="input-project-id" name="id">

                <div class="form-section">
                    {{-- Grid 2 cột trên desktop --}}
                    <div class="form-row-grid">
                        {{-- Cột trái: Thông tin cơ bản --}}
                        <div class="grid-sub-col">
                            <div class="form-group">
                                <label class="form-label" for="input-project-name">Tên dự án / sản phẩm <span class="required">*</span></label>
                                <input type="text" id="input-project-name" name="ten_du_an" class="form-input" placeholder="VD: Phân hệ Quản lý hợp đồng CRM" required minlength="2" maxlength="100">
                                <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 100 ký tự.</span>
                            </div>

                            <div class="form-group" style="margin-top: 14px;">
                                <label class="form-label" for="input-project-role">Vai trò <span class="required">*</span></label>
                                <input type="text" id="input-project-role" name="vai_tro" class="form-input" placeholder="VD: Backend Developer, Fullstack,..." required minlength="2" maxlength="50">
                                <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 - 50 ký tự.</span>
                            </div>

                            <div class="form-row" style="margin-top: 14px;">
                                <div class="form-group">
                                    <label class="form-label" for="input-project-start">Ngày bắt đầu <span class="required">*</span></label>
                                    <input type="date" id="input-project-start" name="ngay_bat_dau" class="form-input" required>
                                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Bắt buộc.</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input-project-end">Ngày kết thúc</label>
                                    <input type="date" id="input-project-end" name="ngay_ket_thuc" class="form-input">
                                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải từ ngày bắt đầu trở đi.</span>
                                    <div style="margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                                        <input type="checkbox" id="checkbox-project-ongoing" style="cursor: pointer;">
                                        <label for="checkbox-project-ongoing" style="font-size: 12px; color: var(--text-secondary); cursor: pointer; user-select: none;">Dự án đang thực hiện</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 14px;">
                                <label class="form-label" for="input-project-tags">Từ khóa công nghệ / Thẻ</label>
                                <input type="text" id="input-project-tags" name="tu_khoa" class="form-input" placeholder="VD: PHP, Laravel, MySQL ">
                                <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Ngăn cách bằng dấu phẩy.</span>
                            </div>
                        </div>

                        {{-- Cột phải: Liên kết ngoài --}}
                        <div class="grid-sub-col">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <label class="form-label" style="margin-bottom:0; font-weight: 600;">Đường dẫn liên kết</label>
                                <button type="button" class="btn-add-link" id="btn-them-lien-ket">+ Thêm link</button>
                            </div>
                            <div id="wrapper-lien-ket" class="wrapper-lien-ket">
                                {{-- Các dòng liên kết động chèn ở đây --}}
                            </div>
                        </div>
                    </div>

                    {{-- Mô tả chi tiết --}}
                    <div class="form-group" style="margin-top: 18px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="form-label" for="input-project-desc" style="margin-bottom:0;">Mô tả chi tiết dự án <span class="required">*</span></label>
                            <span style="font-size: 11px; color: #94a3b8;"><span id="project-desc-counter">0</span>/1000 ký tự</span>
                        </div>
                        <textarea id="input-project-desc" name="mo_ta" class="form-textarea tall" placeholder="Mô tả mục tiêu dự án, vai trò của bạn, các công nghệ sử dụng và kết quả đạt được..." required maxlength="1000"></textarea>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Điền đầy đủ các thông tin bắt buộc (*)
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-du-an">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-du-an">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Lưu dự án
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: XEM CHI TIẾT DỰ ÁN --}}
<div class="modal-overlay" id="modal-chi-tiet-du-an" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-du-an-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-du-an-title">Chi tiết dự án & sản phẩm</div>
                    <div class="modal-subtitle">Thông tin chi tiết dự án trong portfolio</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-du-an" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section-two-columns">
                <!-- Column Left: Text Details -->
                <div class="detail-column-left">
                    <div class="detail-group">
                        <span class="detail-label">Tên dự án / sản phẩm</span>
                        <div class="detail-value text-primary font-bold" id="detail-project-name" style="font-size: 16px;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Vai trò</span>
                            <div class="detail-value font-semibold" id="detail-project-role" style="color: #2563eb;"></div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Thời gian thực hiện</span>
                            <div class="detail-value" id="detail-project-time"></div>
                        </div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Công nghệ sử dụng</span>
                        <div class="project-card-tags" id="detail-project-tags" style="margin-top: 6px; margin-bottom: 0;"></div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Liên kết dự án</span>
                        <div id="detail-project-links" style="display: flex; gap: 8px; margin-top: 6px; flex-wrap: wrap;"></div>
                    </div>
                </div>

                <!-- Column Right: Description -->
                <div class="detail-column-right" style="display: flex; flex-direction: column; height: 100%;">
                    <div class="detail-group" style="flex: 1; display: flex; flex-direction: column; height: 100%;">
                        <span class="detail-label">Mô tả chi tiết</span>
                        <div class="detail-value textarea-style" id="detail-project-desc" style="white-space: pre-wrap; flex: 1; min-height: 180px; margin-top: 4px; box-sizing: border-box; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-du-an" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-du-an" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-du-an" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Sửa
                </button>
            </div>
        </div>
    </div>
</div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JAVASCRIPT CONFIG (Routes) --}}
<script>
    window.ROUTES = {
        luuDuAn: "{{ route('ho-so.du-an.luu') }}",
        xoaDuAn: "{{ route('ho-so.du-an.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        toggleNoiBat: {
            du_an: "{{ route('ho-so.du-an.toggle-noi-bat', ['id' => '__ID__']) }}"
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
<script src="{{ asset('js/du-an/du-an.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/noi-bat.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

