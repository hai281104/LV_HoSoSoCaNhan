<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Album ảnh nổi bật - {{ $hoTen }}</title>
    <meta name="description" content="Album lưu trữ những khoảnh khắc nổi bật trong sự nghiệp và cuộc sống của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/album/album.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Album ảnh nổi bật', 'searchPlaceholder' => 'Tìm kiếm sự kiện..'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="album-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="album-title-section">
                    <h2>Album ảnh nổi bật</h2>
                    <p>Lưu giữ và chia sẻ những khoảnh khắc đáng nhớ trong cuộc đời và sự nghiệp của bạn.</p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" id="btn-dang-su-kien" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Đăng sự kiện mới</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Profile Grid (2 Columns) --}}
        <div class="profile-grid">

            {{-- CỘT TRÁI: Thống kê --}}
            <div class="grid-column">
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê Album</span>
                        </h3>
                    </div>
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số sự kiện:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal" id="stats-total-events">{{ $tongSoSuKien }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Tổng số ảnh:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid" id="stats-total-photos">{{ $tongSoAnh }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Hoạt động gần nhất:</span>
                            <strong class="stats-value"><span class="stats-badge" style="background-color: #eff6ff; color: #1d4ed8; padding: 3px 8px; border-radius: 10px; font-size: 11.5px; font-weight: 700; width: auto; height: auto;" id="stats-recent-month">{{ $thangGanNhat }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Album list --}}
            <div class="grid-column">
                {{-- Bộ lọc --}}
                @if($tongSoSuKien > 0)
                    @php
                        $monthsList = [];
                        $yearsList = [];
                        foreach ($tatCaSuKien as $sk) {
                            if ($sk->ngay_dien_ra) {
                                $monthsList[] = date('n', strtotime($sk->ngay_dien_ra));
                                $yearsList[] = date('Y', strtotime($sk->ngay_dien_ra));
                            }
                        }
                        $monthsList = array_unique($monthsList);
                        sort($monthsList);
                        $yearsList = array_unique($yearsList);
                        rsort($yearsList);

                        $tenThangMap = [
                            1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4',
                            5 => 'Tháng 5', 6 => 'Tháng 6', 7 => 'Tháng 7', 8 => 'Tháng 8',
                            9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
                        ];
                    @endphp
                    <div class="filter-card">
                        <div class="filter-main-row">
                            <div style="display: flex; gap: 12px; flex-wrap: wrap; flex: 1;">
                                <div class="filter-col-phan-loai">
                                    <select id="filter-thang" class="filter-select">
                                        <option value="">Tất cả tháng</option>
                                        @foreach($monthsList as $m)
                                            <option value="{{ $m }}">{{ $tenThangMap[$m] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-col-phan-loai">
                                    <select id="filter-nam" class="filter-select">
                                        <option value="">Tất cả năm</option>
                                        @foreach($yearsList as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="filter-actions-group">
                                <button type="button" id="btn-reset-filters" class="btn-reset-filters">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                    <span>Đặt lại</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="album-timeline-container" style="display: flex; flex-direction: column; width: 100%;">
                    {{-- Card khi không tìm thấy kết quả lọc --}}
                    <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                        <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="no-results-title">Không tìm thấy sự kiện nào</h3>
                        <p class="no-results-desc">Vui lòng thử lại với từ khóa tìm kiếm hoặc các bộ lọc khác.</p>
                    </div>

                    @if($tongSoSuKien > 0)
                        @foreach($danhSachAlbumGrouped as $timeHeader => $events)
                            <div class="timeline-group" data-timeline-range="{{ $timeHeader }}">
                                <div class="timeline-time-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px; color: var(--accent-blue);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <h4>{{ $timeHeader }}</h4>
                                    <span class="timeline-status status-dang_hoc" style="margin-left: auto; position: static; box-shadow: none;">{{ $events->count() }} sự kiện</span>
                                </div>
                                <div class="timeline-group-divider"></div>
                                <div class="album-cards-grid">
                                    @foreach($events as $sk)
                                        @php
                                            $count = $sk->anh_danh_sach->count();
                                            $ngayDienRaFormatted = date('d/m/Y', strtotime($sk->ngay_dien_ra));
                                            $thangDienRa = date('n', strtotime($sk->ngay_dien_ra));
                                            $namDienRa = date('Y', strtotime($sk->ngay_dien_ra));
                                        @endphp
                                        <div class="event-card"
                                             onclick="moModalChiTietAlbum(event, {{ json_encode($sk) }})"
                                             data-thang="{{ $thangDienRa }}"
                                             data-nam="{{ $namDienRa }}">
                                            
                                            {{-- Collage Media Display --}}
                                            <div class="album-media-layout">
                                                @if($count === 1)
                                                    <div class="media-single">
                                                        <img src="{{ asset($sk->anh_danh_sach[0]->url_hinh_anh) }}" class="album-media-img">
                                                    </div>
                                                @elseif($count === 2)
                                                    <div class="media-split">
                                                        <img src="{{ asset($sk->anh_danh_sach[0]->url_hinh_anh) }}" class="album-media-img">
                                                        <img src="{{ asset($sk->anh_danh_sach[1]->url_hinh_anh) }}" class="album-media-img">
                                                    </div>
                                                @else
                                                    <div class="media-collage">
                                                        <div class="collage-left">
                                                            <img src="{{ asset($sk->anh_danh_sach[0]->url_hinh_anh) }}" class="album-media-img">
                                                        </div>
                                                        <div class="collage-right">
                                                            <div class="collage-sub-item">
                                                                <img src="{{ asset($sk->anh_danh_sach[1]->url_hinh_anh) }}" class="album-media-img">
                                                            </div>
                                                            <div class="collage-sub-item has-overlay">
                                                                <img src="{{ asset($sk->anh_danh_sach[2]->url_hinh_anh) }}" class="album-media-img">
                                                                @if($count > 3)
                                                                    <div class="media-overlay-count">
                                                                        <span>+{{ $count - 2 }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Body --}}
                                            <div class="event-card-body">
                                                <h3 class="event-card-title">{{ $sk->tieu_de }}</h3>
                                                @if($sk->mo_ta)
                                                    <p class="event-card-desc">{{ $sk->mo_ta }}</p>
                                                @endif

                                                <div class="event-card-meta">
                                                    <span class="event-date">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        {{ $ngayDienRaFormatted }}
                                                    </span>
                                                    <span class="photos-pill">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        {{ $count }} ảnh
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 64px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); width: 100%;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 56px; height: 56px; color: var(--text-secondary); margin-bottom: 16px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 style="font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px;">Chưa có sự kiện nổi bật</h3>
                            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">Hãy lưu trữ những khoảnh khắc đáng nhớ trong cuộc sống của bạn.</p>
                            <button type="button" class="btn-edit-profile" onclick="moModalThemAlbum()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Đăng sự kiện mới</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</main>

{{-- MODAL: ĐĂNG / SỬA SỰ KIỆN --}}
<div class="modal-overlay" id="modal-album" role="dialog" aria-modal="true" aria-labelledby="modal-album-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-album-title">Đăng sự kiện mới</div>
                    <div class="modal-subtitle">Thêm sự kiện và tải lên tối đa 5 hình ảnh</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-album" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-album" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" id="input-album-id" name="id">

                <div class="form-group">
                    <label class="form-label" for="input-album-title">Tên sự kiện / Tiêu đề <span class="required">*</span></label>
                    <input type="text" id="input-album-title" name="ten_su_kien" class="form-input" placeholder="VD: Hội thảo AI 2025, Bảo vệ Đồ án tốt nghiệp,..." required minlength="2" maxlength="100">
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 100 ký tự, chỉ chứa chữ, số, khoảng trắng, gạch ngang, gạch dưới.</span>
                </div>

                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label" for="input-album-date">Ngày sự kiện <span class="required">*</span></label>
                    <input type="date" id="input-album-date" name="ngay_su_kien" class="form-input" required>
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Chọn ngày diễn ra sự kiện.</span>
                </div>

                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label" for="input-album-desc" style="display: flex; justify-content: space-between;">
                        <span>Mô tả sự kiện</span>
                        <span style="font-size: 12px; font-weight: normal; color: var(--text-muted);"><span id="album-desc-counter">0</span>/1000 ký tự</span>
                    </label>
                    <textarea id="input-album-desc" name="mo_ta" class="form-textarea" placeholder="Mô tả tóm tắt về sự kiện diễn ra..." maxlength="1000" style="min-height: 180px; resize: vertical;"></textarea>
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Không bắt buộc, tối đa 1000 ký tự.</span>
                </div>

                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label">Tải ảnh lên (Tối thiểu 1 ảnh, tối đa 5 ảnh, file gốc <= 2MB, định dạng: JPG, JPEG, PNG, WebP) <span class="required">*</span></label>
                    
                    <div class="photo-uploader-box" id="album-uploader-clickbox">
                        <svg class="photo-uploader-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p style="font-size: 13px; color: var(--text-secondary); font-weight: 500; margin-bottom: 2px;">Nhấn vào đây để chọn ảnh</p>
                        <p style="font-size: 11px; color: var(--text-muted);">Hỗ trợ định dạng JPG, JPEG, PNG, WebP tối đa 2MB</p>
                    </div>
                    
                    <input type="file" id="album-file-input" style="display: none;" accept="image/jpeg,image/png,image/webp,image/jpg" multiple>
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải tải lên từ 1 đến 5 ảnh minh họa. Mỗi ảnh tối đa 2MB.</span>

                    {{-- Previews Container --}}
                    <div class="photo-previews-grid" id="album-previews-container"></div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Ảnh đầu tiên sẽ làm ảnh đại diện sự kiện.</span>
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-album">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-album">
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

{{-- MODAL: XEM CHI TIẾT ALBUM --}}
<div class="modal-overlay" id="modal-chi-tiet-album" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-album-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-album-title">Chi tiết Album sự kiện</div>
                    <div class="modal-subtitle">Thông tin chi tiết các hình ảnh sự kiện lưu trữ</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-album" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section-two-columns">
                <!-- Cột trái: Thông tin sự kiện và Mô tả -->
                <div class="detail-column-left">
                    <div class="detail-info-header" style="margin-bottom: 16px;">
                        <h2 id="detail-album-title" style="font-size: 19px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;"></h2>
                        <div style="display: flex; gap: 14px; align-items: center;">
                            <span class="event-date">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span id="detail-album-date"></span>
                            </span>
                            <span class="photos-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span id="detail-album-photo-count"></span> ảnh
                            </span>
                        </div>
                    </div>
                    
                    <div id="detail-album-desc-wrapper" style="display: flex; flex-direction: column; gap: 6px;">
                        <span class="detail-label" style="display: block;">Mô tả sự kiện</span>
                        <div id="detail-album-desc"></div>
                    </div>
                </div>

                <!-- Cột phải: Gallery hình ảnh -->
                <div class="detail-column-right">
                    <span class="detail-label" style="margin-bottom: 10px; display: block;">Danh sách hình ảnh (Click để xem ảnh gốc)</span>
                    <div class="detail-photos-grid" id="detail-photos-gallery-grid"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-album" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa sự kiện
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-album" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-album" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Sửa thông tin
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Fullscreen Lightbox Overlay --}}
<div class="lightbox-overlay" id="albumLightbox" role="dialog" aria-modal="true">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage" src="" alt="Original Image">
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JAVASCRIPT CONFIG (Routes) --}}
<script>
    window.ROUTES = {
        luuAlbum: "{{ route('ho-so.album.luu') }}",
        xoaAlbum: "{{ route('ho-so.album.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        assetUrl: "{{ asset('') }}"
    };
</script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/album/album.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

