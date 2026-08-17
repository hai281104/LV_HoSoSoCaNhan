@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    $nguoiDung  = $nguoiDung ?? Auth::user();
    $hoTen      = $nguoiDung->ho_ten;
    $chucDanh   = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
    $anhDaiDien = $nguoiDung->anh_dai_dien;

    // Tạo chữ cái tắt
    $tenRutGon = '';
    if ($hoTen) {
        $cacTu = explode(' ', trim($hoTen));
        if (count($cacTu) >= 2) {
            $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
        } else {
            $tenRutGon = mb_substr($hoTen, 0, 2);
        }
        $tenRutGon = mb_strtoupper($tenRutGon);
    } else {
        $tenRutGon = 'ND';
    }
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kinh nghiệm làm việc - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý quá trình công tác và kinh nghiệm làm việc của {{ $hoTen }}.">

    {{-- CSS chính & chung --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    {{-- CSS riêng --}}
    <link rel="stylesheet" href="{{ asset('css/kinh-nghiem/kinh-nghiem.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Kinh nghiệm làm việc', 'searchPlaceholder' => 'Tìm kiếm kinh nghiệm...'])

    {{-- Content Body --}}
    <div class="content-body">
        
        {{-- Header Card --}}
        <div class="experience-header-card">
            <div class="experience-title-section" style="display: flex; justify-content: space-between; align-items: center; width: 100%; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h2>Kinh nghiệm công tác & Làm việc</h2>
                    <p>Quản lý và hiển thị quá trình làm việc chuyên nghiệp, sắp xếp nhóm theo khoảng thời gian. <span style="font-size: 12.5px; font-style: italic; color: var(--text-secondary); margin-left: 8px;">(Sắp xếp theo năm kết thúc từ cao đến thấp)</span></p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" onclick="moModalThemKinhNghiem()" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Thêm kinh nghiệm</span>
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

            {{-- CỘT TRÁI: Thống kê --}}
            <div class="grid-column">
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê kinh nghiệm</span>
                        </h3>
                    </div>
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số kinh nghiệm:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $tongSoKinhNghiem }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đang làm việc:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid">{{ $dangLamViecCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đã kết thúc:</span>
                            <strong class="stats-value"><span class="stats-badge badge-expired">{{ $daKetThucCount }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Bộ lọc & Dòng thời gian --}}
            <div class="grid-column">
                @if($tongSoKinhNghiem > 0)
                    {{-- Bộ lọc --}}
                    @php
                        $namBoLoc = [];
                        if (isset($tatCaKinhNghiem)) {
                            foreach ($tatCaKinhNghiem as $kn) {
                                if ($kn->ngay_bat_dau) {
                                    $namBoLoc[] = date('Y', strtotime($kn->ngay_bat_dau));
                                }
                                if ($kn->ngay_ket_thuc) {
                                    $namBoLoc[] = date('Y', strtotime($kn->ngay_ket_thuc));
                                }
                            }
                        }
                        $namBoLoc = array_unique($namBoLoc);
                        rsort($namBoLoc);
                    @endphp
                    <div class="filter-card">
                        <div class="filter-main-row">
                            <div style="display: flex; gap: 12px; flex-wrap: wrap; flex: 1;">
                                <div class="filter-col-phan-loai" style="max-width: 200px; min-width: 150px;">
                                    <select id="filter-trang-thai" class="filter-select">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="dang_lam">Đang làm việc</option>
                                        <option value="da_nghi">Đã kết thúc</option>
                                    </select>
                                </div>
                                <div class="filter-col-phan-loai" style="max-width: 200px; min-width: 150px;">
                                    <select id="filter-nam" class="filter-select">
                                        <option value="">Tất cả các năm</option>
                                        @foreach($namBoLoc as $nam)
                                            <option value="{{ $nam }}">{{ $nam }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-col-phan-loai" style="max-width: 200px; min-width: 150px;">
                                    <select id="filter-noi-bat" class="filter-select">
                                        <option value="">Tất cả độ nổi bật</option>
                                        <option value="1">⭐ Nổi bật</option>
                                        <option value="0">Không nổi bật</option>
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

                    {{-- Container danh sách dòng thời gian --}}
                    <div class="experience-timeline-container" style="display: flex; flex-direction: column; width: 100%;">
                        <div style="font-size: 12px; color: var(--text-secondary); opacity: 0.75; font-style: italic; margin-bottom: 12px; text-align: right; user-select: none;">
                            (Sắp xếp theo ngày kết thúc từ cao đến thấp)
                        </div>
                        
                        {{-- Không tìm thấy kết quả --}}
                        <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                            <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            <h3 class="no-results-title">Không tìm thấy kinh nghiệm phù hợp</h3>
                            <p class="no-results-desc">Vui lòng thử lại với từ khóa hoặc bộ lọc khác.</p>
                        </div>

                        {{-- Render danh sách kinh nghiệm nhóm theo thời gian --}}
                        @foreach($danhSachKinhNghiem as $thoiGian => $items)
                            <div class="timeline-group" data-timeline-range="{{ $thoiGian }}">
                                <div class="timeline-time-header">
                                    <h4>{{ $thoiGian }}</h4>
                                </div>
                                <div class="timeline-group-divider"></div>
                                <div class="timeline-experience-list">
                                    @foreach($items as $kn)
                                        <div class="experience-list-item" 
                                             data-id="{{ $kn->id }}"
                                             data-noi-bat="{{ $kn->noi_bat ? '1' : '0' }}"
                                             onclick="moModalChiTietKinhNghiem(event, {{ json_encode($kn) }})"
                                             data-dang-lam-viec="{{ $kn->dang_lam_viec }}"
                                             data-nam-bat-dau="{{ date('Y', strtotime($kn->ngay_bat_dau)) }}"
                                             data-nam-ket-thuc="{{ $kn->ngay_ket_thuc ? date('Y', strtotime($kn->ngay_ket_thuc)) : '' }}"
                                             style="cursor: pointer;">
                                            
                                            <div class="item-bullet">●</div>
                                            
                                            <div class="item-content">
                                                <div class="item-header">
                                                    <h3 class="item-position">
                                                        @if($kn->noi_bat)
                                                            <span class="badge-noi-bat" style="margin-right:6px;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                                                                Nổi bật
                                                            </span>
                                                        @endif
                                                        {{ $kn->vi_tri_cong_viec }}
                                                    </h3>
                                                    <div class="item-actions-inline">
                                                        <button type="button" class="btn-toggle-noi-bat {{ $kn->noi_bat ? 'active' : '' }}"
                                                            onclick="event.stopPropagation(); doToggleNoiBat('kinh_nghiem', {{ $kn->id }}, this)"
                                                            data-noi-bat="{{ $kn->noi_bat }}"
                                                            title="{{ $kn->noi_bat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="btn-edu-action edit" onclick="event.stopPropagation(); moModalSuaKinhNghiem(event, {{ json_encode($kn) }})" title="Sửa">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                        </button>
                                                        <button type="button" class="btn-edu-action delete" onclick="event.stopPropagation(); xoaKinhNghiem(event, {{ $kn->id }})" title="Xóa">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="item-company">{{ $kn->ten_cong_ty }}</div>
                                                @if($kn->mo_ta_chi_tiet)
                                                    <div class="item-desc">{{ Str::limit($kn->mo_ta_chi_tiet, 180) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 64px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); max-width: 600px; margin: 30px auto; width: 100%;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 56px; height: 56px; color: var(--text-secondary); margin-bottom: 16px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <h3 style="font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px;">Chưa có kinh nghiệm làm việc</h3>
                        <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">Vui lòng thêm quá trình làm việc của bạn vào hồ sơ cá nhân.</p>
                        <button type="button" class="btn-edit-profile" onclick="moModalThemKinhNghiem()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Thêm kinh nghiệm</span>
                        </button>
                    </div>
                @endif
            </div>

        </div>

    </div>
</main>

{{-- MODAL: CẬP NHẬT KINH NGHIỆM --}}
<div class="modal-overlay" id="modal-kinh-nghiem" role="dialog" aria-modal="true" aria-labelledby="modal-kinh-nghiem-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-kinh-nghiem-title">Cập nhật kinh nghiệm</div>
                    <div class="modal-subtitle">Thêm mới hoặc cập nhật thông tin vị trí, công ty và thời gian làm việc</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-kinh-nghiem" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-kinh-nghiem" autocomplete="off">
                <input type="hidden" id="input-exp-id" name="id">

                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input-exp-position">Vị trí công việc <span class="required">*</span></label>
                            <input type="text" id="input-exp-position" name="vi_tri_cong_viec" class="form-input" placeholder="VD: Thực tập sinh IT, Freelancer,..." required minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 100 ký tự.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-exp-company">Tên công ty / Tổ chức <span class="required">*</span></label>
                            <input type="text" id="input-exp-company" name="ten_cong_ty" class="form-input" placeholder="VD: Công ty Công nghệ, Dự án cá nhân,..." required minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 100 ký tự.</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-exp-start">Ngày bắt đầu <span class="required">*</span></label>
                            <input type="date" id="input-exp-start" name="ngay_bat_dau" class="form-input" required>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Chọn ngày bắt đầu làm việc.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-exp-end">Ngày kết thúc <span class="required" id="span-exp-end-required">*</span></label>
                            <input type="date" id="input-exp-end" name="ngay_ket_thuc" class="form-input" required>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải lớn hơn hoặc bằng ngày bắt đầu.</span>
                            
                            <div style="margin-top: 6px; display: flex; align-items: center; gap: 6px;">
                                <input type="checkbox" id="checkbox-exp-ongoing" name="dang_lam_viec" value="1" style="cursor: pointer;">
                                <label for="checkbox-exp-ongoing" style="font-size: 12px; color: var(--text-secondary); cursor: pointer; user-select: none;">Công việc hiện tại (Đang làm việc)</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="form-label" for="input-exp-desc" style="margin-bottom:0;">Mô tả chi tiết công việc</label>
                            <span style="font-size: 11px; color: #94a3b8;"><span id="exp-desc-counter">0</span>/1000 ký tự</span>
                        </div>
                        <textarea id="input-exp-desc" name="mo_ta_chi_tiet" class="form-textarea tall" placeholder="Mô tả chi tiết về công việc, trách nhiệm và thành tích đạt được..." maxlength="1000"></textarea>
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Tối đa 1000 ký tự.</span>
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
                <button type="button" class="btn-cancel" data-dong-modal="modal-kinh-nghiem">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-kinh-nghiem">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Lưu thay đổi
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: CHI TIẾT KINH NGHIỆM (XEM CHI TIẾT) --}}
<div class="modal-overlay" id="modal-chi-tiet-kinh-nghiem" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-kinh-nghiem-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-kinh-nghiem-title">Chi tiết kinh nghiệm làm việc</div>
                    <div class="modal-subtitle">Thông tin chi tiết công tác và làm việc</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-kinh-nghiem" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section">
                <!-- Row 1: Vị trí và Công ty -->
                <div class="detail-row-grid">
                    <div class="detail-group">
                        <span class="detail-label">Vị trí công việc</span>
                        <div class="detail-value text-primary font-bold" id="detail-exp-position" style="font-size: 16px;"></div>
                    </div>
                    <div class="detail-group">
                        <span class="detail-label">Tên công ty / Tổ chức</span>
                        <div class="detail-value font-semibold" id="detail-exp-company" style="color: #059669; font-size: 15px;"></div>
                    </div>
                </div>

                <!-- Row 2: Ngày bắt đầu và Ngày kết thúc -->
                <div class="detail-row-grid" style="margin-top: 14px;">
                    <div class="detail-group">
                        <span class="detail-label">Ngày bắt đầu</span>
                        <div class="detail-value font-semibold" id="detail-exp-start-date"></div>
                    </div>
                    <div class="detail-group">
                        <span class="detail-label">Ngày kết thúc</span>
                        <div class="detail-value font-semibold" id="detail-exp-end-date"></div>
                    </div>
                </div>

                <!-- Row 3: Trạng thái công việc -->
                <div class="detail-row-grid" style="margin-top: 14px;">
                    <div class="detail-group">
                        <span class="detail-label">Trạng thái công việc</span>
                        <div id="detail-exp-status"></div>
                    </div>
                </div>

                <!-- Bottom full width section: Mô tả chi tiết -->
                <div class="detail-group" style="margin-top: 18px; border-top: 1px dashed var(--border-color); padding-top: 16px;">
                    <span class="detail-label">Mô tả chi tiết công việc</span>
                    <div class="detail-value textarea-style" id="detail-exp-desc" style="white-space: pre-wrap; margin-top: 6px; min-height: 120px; max-height: 250px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-kinh-nghiem" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-kinh-nghiem" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-kinh-nghiem" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
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
        luuKinhNghiem: "{{ route('ho-so.kinh-nghiem.luu') }}",
        xoaKinhNghiem: "{{ route('ho-so.kinh-nghiem.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        toggleNoiBat: {
            kinh_nghiem: "{{ route('ho-so.kinh-nghiem.toggle-noi-bat', ['id' => '__ID__']) }}"
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
<script src="{{ asset('js/kinh-nghiem/kinh-nghiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/noi-bat.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

