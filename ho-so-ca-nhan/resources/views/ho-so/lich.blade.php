<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lịch / Công việc - {{ $hoTen }}</title>
    <meta name="description" content="Lịch làm việc, kế hoạch cá nhân và quản lý công việc của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/lich.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Lịch / Công việc', 'searchPlaceholder' => 'Tìm kiếm sự kiện...', 'disableSearch' => true])

    {{-- Content Body --}}
    <div class="content-body">
        {{-- Header Card --}}
        <div class="lich-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="lich-title-section">
                    <h2>Lịch trình & Quản lý công việc</h2>
                    <p>Theo dõi các sự kiện quan trọng, hạn chót (deadlines), lịch học tập và công tác chuyên môn của bạn.</p>
                </div>
            </div>
        </div>

        {{-- Main profile-grid (Left: 300px, Right: 1fr) --}}
        <div class="profile-grid">
            {{-- CỘT TRÁI --}}
            <div class="grid-column">
                {{-- Quick Nav Mini Calendar --}}
                <div class="info-card mini-calendar-card">
                    <div class="mini-calendar-header">
                        <span class="mini-calendar-title" id="mini-month-year">Tháng 06, 2026</span>
                        <div style="display: flex; gap: 4px;">
                            <button type="button" class="mini-calendar-nav-btn" id="btn-mini-prev" title="Tháng trước">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" class="mini-calendar-nav-btn" id="btn-mini-next" title="Tháng sau">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="mini-days-grid-header">
                        <span>T2</span><span>T3</span><span>T4</span><span>T5</span><span>T6</span><span>T7</span><span>CN</span>
                    </div>
                    <div class="mini-days-grid" id="mini-days-container">
                        {{-- Rendered via Javascript --}}
                    </div>
                </div>

                {{-- Add Event Button --}}
                <button type="button" class="btn-edit-profile" id="btn-them-lich" style="margin: 0; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Thêm lịch / công việc</span>
                </button>

                {{-- Legend Card --}}
                <div class="info-card legend-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Phân loại màu sắc</span>
                        </h3>
                    </div>
                    <div class="legend-list">
                        <div class="legend-item">
                            <span class="legend-badge ca_nhan"></span>
                            <span>Cá nhân</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-badge hop_tac"></span>
                            <span>Hợp tác / Hội nhóm</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-badge deadline"></span>
                            <span>Deadline công việc</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-badge su_kien"></span>
                            <span>Sự kiện / Hội thảo</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-badge khac"></span>
                            <span>Khác</span>
                        </div>
                        <div class="legend-item" style="margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--border-color);">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 12.5px; font-weight: 500; color: var(--text-secondary); width: 100%;">
                                <input type="checkbox" id="toggle-holidays" checked style="width: 15px; height: 15px; cursor: pointer; margin: 0;">
                                <span>Hiện ngày lễ VN (Google)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Large Calendar --}}
            <div class="grid-column">
                <div class="large-calendar-card">
                    <div class="large-calendar-header">
                        <div class="large-calendar-title-nav">
                            <span class="large-calendar-title" id="large-month-year">Tháng 6 năm 2026</span>
                            <div class="large-calendar-nav-group">
                                <button type="button" class="large-calendar-nav-btn" id="btn-large-prev" title="Tháng trước">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button type="button" class="large-calendar-nav-btn" id="btn-large-next" title="Tháng sau">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                            <button type="button" class="large-calendar-today-btn" id="btn-large-today">Hôm nay</button>
                        </div>
                    </div>

                    <div class="large-calendar-grid-header">
                        <span>Thứ 2</span><span>Thứ 3</span><span>Thứ 4</span><span>Thứ 5</span><span>Thứ 6</span><span>Thứ 7</span><span>Chủ nhật</span>
                    </div>

                    <div class="large-calendar-grid" id="large-days-container">
                        {{-- Rendered via Javascript --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- MODAL: THÊM MỚI / CHỈNH SỬA LỊCH CÔNG VIỆC --}}
<div class="modal-overlay" id="modal-lich" role="dialog" aria-modal="true" aria-labelledby="modal-lich-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-lich-title">Lên lịch công việc</div>
                    <div class="modal-subtitle">Thêm mới hoặc cập nhật công việc, sự kiện của bạn</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-lich" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-lich" autocomplete="off">
                <input type="hidden" id="input-event-id" name="id">

                <div class="form-group">
                    <label class="form-label" for="input-event-title">Tiêu đề công việc / sự kiện <span class="required">*</span></label>
                    <input type="text" id="input-event-title" name="tieu_de" class="form-input" placeholder="VD: Họp dự án tốt nghiệp, Deadline nộp báo cáo..." required minlength="2" maxlength="30">
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 30 ký tự, không chứa ký tự đặc biệt.</span>
                </div>

                <div class="form-row-compact" style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="input-start-date">Ngày bắt đầu <span class="required">*</span></label>
                        <input type="date" id="input-start-date" name="ngay_bat_dau" class="form-input" style="width: 100%;" required>
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Chọn ngày bắt đầu.</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="select-start-hour">Giờ bắt đầu</label>
                        <div style="display: flex; gap: 8px; align-items: center; width: 100%;">
                            <select id="select-start-hour" class="form-select" style="flex: 1; height: 38px;">
                                <option value="">Giờ</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $val = sprintf('%02d', $i); @endphp
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endfor
                            </select>
                            <span style="font-weight: bold; color: var(--text-secondary);">:</span>
                            <select id="select-start-minute" class="form-select" style="flex: 1; height: 38px;">
                                <option value="">Phút</option>
                                @for ($i = 0; $i < 60; $i++)
                                    @php $val = sprintf('%02d', $i); @endphp
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endfor
                            </select>
                            <input type="hidden" id="input-start-time" name="gio_bat_dau">
                        </div>
                    </div>
                </div>

                <div class="form-row-compact" style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label" for="input-end-date">Ngày kết thúc <span class="required">*</span></label>
                        <input type="date" id="input-end-date" name="ngay_ket_thuc" class="form-input" style="width: 100%;" required>
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải lớn hơn hoặc bằng ngày bắt đầu.</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="select-end-hour">Giờ kết thúc</label>
                        <div style="display: flex; gap: 8px; align-items: center; width: 100%;">
                            <select id="select-end-hour" class="form-select" style="flex: 1; height: 38px;">
                                <option value="">Giờ</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $val = sprintf('%02d', $i); @endphp
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endfor
                            </select>
                            <span style="font-weight: bold; color: var(--text-secondary);">:</span>
                            <select id="select-end-minute" class="form-select" style="flex: 1; height: 38px;">
                                <option value="">Phút</option>
                                @for ($i = 0; $i < 60; $i++)
                                    @php $val = sprintf('%02d', $i); @endphp
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endfor
                            </select>
                            <input type="hidden" id="input-end-time" name="gio_ket_thuc">
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 12px;">
                    <label class="form-label" for="input-event-category">Phân loại công việc <span class="required">*</span></label>
                    <select id="input-event-category" name="phan_loai" class="form-select" style="width: 100%; height: 38px;" required>
                        <option value="ca_nhan" selected>Cá nhân</option>
                        <option value="hop_tac">Hợp tác / Hội nhóm</option>
                        <option value="deadline">Deadline công việc</option>
                        <option value="su_kien">Sự kiện / Hội thảo</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>

                <div class="form-group" style="margin-top: 12px;">
                    <label class="form-label" for="input-event-desc">Mô tả chi tiết</label>
                    <textarea id="input-event-desc" name="mo_ta" class="form-textarea" style="height: 100px; resize: vertical; padding: 8px;" placeholder="Nhập thêm chi tiết hoặc địa điểm, nội dung lưu ý của công việc..." maxlength="100"></textarea>
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Tối đa 100 ký tự.</span>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-lich">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-lich">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Lưu sự kiện
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: XEM CHI TIẾT LỊCH CÔNG VIỆC --}}
<div class="modal-overlay" id="modal-chi-tiet-lich" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-lich-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-lich-title">Thông tin công việc</div>
                    <div class="modal-subtitle">Chi tiết sự kiện hoặc lịch công tác của bạn</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-lich" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div style="display: flex; flex-direction: column;">
                <div class="detail-row-item">
                    <div class="detail-row-label">Tiêu đề:</div>
                    <div class="detail-row-value" id="display-event-title" style="font-weight: 700; font-size: 15px;"></div>
                </div>
                <div class="detail-row-item">
                    <div class="detail-row-label">Phân loại:</div>
                    <div class="detail-row-value">
                        <span id="display-event-category-badge" class="category-badge-pill">
                            <span class="category-bullet" id="display-event-category-bullet"></span>
                            <span id="display-event-category-text"></span>
                        </span>
                    </div>
                </div>
                <div class="detail-row-item">
                    <div class="detail-row-label">Bắt đầu:</div>
                    <div class="detail-row-value" id="display-event-start"></div>
                </div>
                <div class="detail-row-item">
                    <div class="detail-row-label">Kết thúc:</div>
                    <div class="detail-row-value" id="display-event-end"></div>
                </div>
                <div class="detail-row-item" id="display-event-desc-wrapper">
                    <div class="detail-row-label">Mô tả chi tiết:</div>
                    <div class="detail-row-value" id="display-event-desc" style="white-space: pre-wrap;"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Nút xóa bên trái -->
            <button type="button" class="btn-cancel" id="btn-xoa-lich" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa sự kiện
            </button>
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-lich" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-sua-lich" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Sửa thông tin
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JAVASCRIPT CONFIG (Routes & Data) --}}
<script>
    window.ROUTES = {
        luuLich: "{{ route('ho-so.lich.luu') }}",
        xoaLich: "{{ route('ho-so.lich.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        assetUrl: "{{ asset('') }}"
    };
    window.SU_KIEN_DATA = @json($suKien);
    window.NGAY_LE_DATA = @json($ngayLe);
</script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/lich/lich.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

