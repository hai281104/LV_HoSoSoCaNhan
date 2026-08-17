<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Học vấn & Trình độ - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý lịch sử học tập, bằng cấp chuyên môn của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/hoc-van/hoc-van.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Học vấn & Trình độ', 'searchPlaceholder' => 'Tìm kiếm học vấn...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="education-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="education-title-section">
                    <h2>Học vấn & Trình độ</h2>
                    <p>Quản lý lịch sử học tập, bằng cấp chuyên môn và các khóa đào tạo chính quy.</p>
                </div>
                <div>
                    <button type="button" class="btn-edit-profile" id="btn-them-hoc-van" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
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
                {{-- Card thống kê học lực --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Tổng quan học tập</span>
                        </h3>
                    </div>
                    @php
                        $dangHocCount = $danhSachHocVan->where('trang_thai', 'dang_hoc')->count();
                        $daTotNghiepCount = $danhSachHocVan->where('trang_thai', 'da_tot_nghiep')->count();
                        $tamDungCount = $danhSachHocVan->where('trang_thai', 'tam_dung')->count();
                        $baoLuuCount = $danhSachHocVan->where('trang_thai', 'bao_luu')->count();
                    @endphp
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số mục:</span>
                            <strong class="stats-value"><span class="stats-badge badge-normal">{{ $danhSachHocVan->count() }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đang học:</span>
                            <strong class="stats-value"><span class="stats-badge badge-valid">{{ $dangHocCount }}</span></strong>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">Đã hoàn thành:</span>
                            <strong class="stats-value"><span class="stats-badge" style="color: #1d4ed8; background-color: #dbeafe;">{{ $daTotNghiepCount }}</span></strong>
                        </div>
                        @if($tamDungCount > 0)
                            <div class="stats-item">
                                <span class="stats-label">Tạm dừng:</span>
                                <strong class="stats-value"><span class="stats-badge" style="color: #b45309; background-color: #fef3c7;">{{ $tamDungCount }}</span></strong>
                            </div>
                        @endif
                        @if($baoLuuCount > 0)
                            <div class="stats-item">
                                <span class="stats-label">Bảo lưu:</span>
                                <strong class="stats-value"><span class="stats-badge" style="color: #7c3aed; background-color: #f3e8ff;">{{ $baoLuuCount }}</span></strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Dòng thời gian học tập --}}
            <div class="grid-column">
                @if($danhSachHocVan->count() > 0)
                    {{-- Bộ lọc --}}
                    <div class="filter-card">
                        <div class="filter-main-row">
                            <div class="filter-col-phan-loai">
                                <select id="filter-nam" class="filter-select">
                                    <option value="">Tất cả các năm học</option>
                                    @php
                                        $cacNam = collect();
                                        foreach($danhSachHocVan as $hv) {
                                            $cacNam->push($hv->nam_bat_dau);
                                            if ($hv->nam_ket_thuc) {
                                                $cacNam->push($hv->nam_ket_thuc);
                                            }
                                        }
                                        $cacNam = $cacNam->unique()->sortDesc();
                                    @endphp
                                    @foreach($cacNam as $nam)
                                        <option value="{{ $nam }}">{{ $nam }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-col-phan-loai">
                                <select id="filter-trang-thai" class="filter-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="dang_hoc">Đang học</option>
                                    <option value="da_tot_nghiep">Đã hoàn thành</option>
                                    <option value="bao_luu">Bảo lưu</option>
                                    <option value="tam_dung">Tạm dừng</option>
                                </select>
                            </div>

                            <div class="filter-col-phan-loai">
                                <select id="filter-xep-loai" class="filter-select">
                                    <option value="">Tất cả xếp loại</option>
                                    <option value="Xuất sắc">Xuất sắc</option>
                                    <option value="Giỏi">Giỏi</option>
                                    <option value="Khá">Khá</option>
                                    <option value="Trung bình">Trung bình</option>
                                    <option value="Khác">Khác</option>
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
                                <button type="button" id="btn-reset-filters" class="btn-reset-filters">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                    <span>Đặt lại</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Timeline --}}
                <div style="font-size: 12px; color: var(--text-secondary); opacity: 0.75; font-style: italic; margin-bottom: 12px; text-align: right; user-select: none;">
                    (Sắp xếp theo năm kết thúc từ cao đến thấp)
                </div>
                <div class="timeline-container" style="padding-top: 0;">
                    {{-- Card khi không tìm thấy kết quả lọc --}}
                    <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                        <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="no-results-title">Không tìm thấy thông tin phù hợp</h3>
                        <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
                    </div>

                    @if($danhSachHocVan->count() > 0)
                        @foreach($danhSachHocVan as $hv)
                            <div class="timeline-item"
                                 data-id="{{ $hv->id }}"
                                 data-noi-bat="{{ $hv->noi_bat ? '1' : '0' }}"
                                 data-nam-bat-dau="{{ $hv->nam_bat_dau }}"
                                 data-nam-ket-thuc="{{ $hv->nam_ket_thuc ?? date('Y') }}"
                                 data-trang-thai="{{ $hv->trang_thai }}"
                                 data-xep-loai="{{ $hv->xep_loai ?? '' }}">
                                <div class="timeline-left">
                                    @if($hv->trang_thai === 'dang_hoc')
                                        <div class="timeline-year">{{ $hv->nam_bat_dau }} - Hiện tại</div>
                                        <span class="timeline-status status-dang_hoc">Đang học</span>
                                    @else
                                        <div class="timeline-year">{{ $hv->nam_bat_dau }} - {{ $hv->nam_ket_thuc }}</div>
                                        @if($hv->trang_thai === 'da_tot_nghiep')
                                            <span class="timeline-status status-da_tot_nghiep">Đã hoàn thành</span>
                                        @elseif($hv->trang_thai === 'bao_luu')
                                            <span class="timeline-status" style="background-color: #f3e8ff; color: #7c3aed;">Bảo lưu</span>
                                        @else
                                            <span class="timeline-status status-tam_dung">Tạm dừng</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="timeline-center">
                                    <div class="timeline-line"></div>
                                    <div class="timeline-circle {{ $hv->trang_thai === 'da_tot_nghiep' ? 'active' : '' }}">
                                        @if($hv->trang_thai === 'da_tot_nghiep')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="timeline-right">
                                    <div class="education-card" data-id="{{ $hv->id }}" onclick="moModalChiTietHocVan(event, {{ json_encode($hv) }})">
                                        <div class="education-card-header">
                                            <div class="education-card-title" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                                @if($hv->noi_bat)
                                                    <span class="badge-noi-bat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                                                        Nổi bật
                                                    </span>
                                                @endif
                                                <h3 style="margin:0;">{{ $hv->tieu_de }}</h3>
                                            </div>
                                            <div class="education-actions">
                                                <button type="button" class="btn-toggle-noi-bat {{ $hv->noi_bat ? 'active' : '' }}"
                                                    onclick="event.stopPropagation(); doToggleNoiBat('hoc_van', {{ $hv->id }}, this)"
                                                    data-noi-bat="{{ $hv->noi_bat }}"
                                                    title="{{ $hv->noi_bat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn-edu-action edit" onclick="event.stopPropagation(); moModalSuaHocVan({{ json_encode($hv) }})" title="Sửa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>
                                                <button type="button" class="btn-edu-action delete" onclick="event.stopPropagation(); xoaHocVan({{ $hv->id }}, '{{ route('ho-so.hoc-van.xoa', ['id' => $hv->id]) }}')" title="Xóa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="education-school">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <span>{{ $hv->ten_truong }}</span>
                                        </div>

                                        @if($hv->khoa || $hv->nganh || $hv->xep_loai || $hv->gpa)
                                            <div class="education-details">
                                                @if($hv->khoa)
                                                    <div class="education-details-item">
                                                        <span>Khoa:</span> <strong>{{ $hv->khoa }}</strong>
                                                    </div>
                                                @endif
                                                @if($hv->nganh)
                                                    <div class="education-details-item">
                                                        <span>Ngành:</span> <strong>{{ $hv->nganh }}</strong>
                                                    </div>
                                                @endif
                                                @if($hv->xep_loai)
                                                    <div class="education-details-item">
                                                        <span>Xếp loại:</span> <strong>{{ $hv->xep_loai }}</strong>
                                                    </div>
                                                @endif
                                                @if($hv->gpa)
                                                    <div class="education-details-item">
                                                        <span>GPA:</span> <strong>{{ $hv->gpa }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if($hv->mo_ta)
                                            <div class="education-description">{{ $hv->mo_ta }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 48px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; color: var(--text-secondary); margin-bottom: 12px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            <h3 style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Chưa có thông tin học vấn</h3>
                            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 16px;">Vui lòng thêm thông tin học vấn để làm nổi bật hồ sơ của bạn.</p>
                            <button type="button" class="btn-edit-profile" onclick="moModalThemHocVan()" style="margin: 0 auto; display: inline-flex; align-items: center; gap: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Thêm mới học vấn</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</main>

{{-- MODAL: HỌC VẤN & TRÌNH ĐỘ --}}
<div class="modal-overlay" id="modal-hoc-van" role="dialog" aria-modal="true" aria-labelledby="modal-hoc-van-title">
    <div class="modal-panel">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-hoc-van-title">Cập nhật học vấn & trình độ</div>
                    <div class="modal-subtitle">Cập nhật thông tin quá trình học tập và bằng cấp của bạn</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-hoc-van" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-hoc-van" autocomplete="off">
                <input type="hidden" id="input-edu-id" name="id">

                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input-edu-tieu-de">Tên chương trình học <span class="required">*</span></label>
                            <input type="text" id="input-edu-tieu-de" name="tieu_de" class="form-input" placeholder="VD: Cử nhân Công nghệ Thông tin" required minlength="2" maxlength="50">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 50 ký tự, hỗ trợ các ký tự dấu câu cơ bản.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-edu-ten-truong">Trường / Tổ chức đào tạo <span class="required">*</span></label>
                            <input type="text" id="input-edu-ten-truong" name="ten_truong" class="form-input" placeholder="VD: Đại học Cần Thơ" required minlength="2" maxlength="200">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 200 ký tự, hỗ trợ các ký tự dấu câu cơ bản.</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-edu-nam-bat-dau">Năm bắt đầu <span class="required">*</span></label>
                            <select id="input-edu-nam-bat-dau" name="nam_bat_dau" class="form-select" required>
                                <option value="">Chọn năm</option>
                            </select>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Chọn năm bắt đầu học.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-edu-nam-ket-thuc">Năm kết thúc <span class="nam-ket-thuc-required text-red-500" style="color:#ef4444;">*</span></label>
                            <select id="input-edu-nam-ket-thuc" name="nam_ket_thuc" class="form-select" required>
                                <option value="">Chọn năm</option>
                            </select>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Phải lớn hơn hoặc bằng năm bắt đầu.</span>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-edu-trang-thai">Trạng thái học tập <span class="required">*</span></label>
                            <select id="input-edu-trang-thai" name="trang_thai" class="form-select" required>
                                <option value="dang_hoc">Đang học</option>
                                <option value="da_tot_nghiep" selected>Đã tốt nghiệp</option>
                                <option value="bao_luu">Bảo lưu</option>
                                <option value="tam_dung">Tạm dừng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-edu-xep-loai">Xếp loại học lực</label>
                            <select id="input-edu-xep-loai" name="xep_loai" class="form-select">
                                <option value="">Chọn xếp loại</option>
                                <option value="Xuất sắc">Xuất sắc</option>
                                <option value="Giỏi">Giỏi</option>
                                <option value="Khá">Khá</option>
                                <option value="Trung bình">Trung bình</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-edu-khoa">Khoa</label>
                            <input type="text" id="input-edu-khoa" name="khoa" class="form-input" placeholder="VD: Công nghệ thông tin" minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 100 ký tự, hỗ trợ các ký tự dấu câu cơ bản.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-edu-nganh">Ngành học</label>
                            <input type="text" id="input-edu-nganh" name="nganh" class="form-input" placeholder="VD: Kỹ thuật phần mềm" minlength="2" maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Từ 2 đến 100 ký tự, hỗ trợ các ký tự dấu câu cơ bản.</span>
                        </div>
                    </div>

                    <div class="form-row single" style="margin-top:14px;">
                        <div class="form-group">
                            <label class="form-label" for="input-edu-gpa">Điểm GPA</label>
                            <input type="number" step="0.01" min="0" max="10" id="input-edu-gpa" name="gpa" class="form-input" placeholder="VD: 3.75 hoặc 8.5">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Điểm hệ 10 hoặc hệ 4 (0 đến 10).</span>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <label class="form-label" for="input-edu-mo-ta" style="margin-bottom:0;">Mô tả chi tiết</label>
                            <span style="font-size: 11px; color: #94a3b8;"><span id="edu-desc-counter">0</span>/1000 ký tự</span>
                        </div>
                        <textarea id="input-edu-mo-ta" name="mo_ta" class="form-textarea tall" placeholder="Mô tả các môn học chuyên ngành, đề tài nghiên cứu hoặc các hoạt động ngoại khóa nổi bật..." maxlength="1000"></textarea>
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
            <div class="modal-footer-actions" style="display: flex; gap: 8px; width: 100%; justify-content: flex-end; align-items: center;">
                <button type="button" class="btn-cancel" id="btn-xoa-hoc-van" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: none; margin-right: auto; align-items: center; gap: 4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Xóa học vấn
                </button>
                <button type="button" class="btn-cancel" data-dong-modal="modal-hoc-van" style="margin: 0;">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-hoc-van" style="margin: 0;">
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

{{-- MODAL: XEM CHI TIẾT HỌC VẤN --}}
<div class="modal-overlay" id="modal-chi-tiet-hoc-van" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-title">
    <div class="modal-panel wide">
        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background-color: #eff6ff; color: var(--accent-blue);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-title">Chi tiết học vấn & trình độ</div>
                    <div class="modal-subtitle">Thông tin chi tiết quá trình học tập</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-hoc-van" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <div class="detail-section-two-columns">
                <!-- Column Left: Text Details -->
                <div class="detail-column-left">
                    <div class="detail-group">
                        <span class="detail-label">Tiêu đề bằng cấp / chứng chỉ</span>
                        <div class="detail-value text-primary font-bold" id="detail-edu-tieu-de" style="font-size: 16px;"></div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Trường / Tổ chức đào tạo</span>
                        <div class="detail-value text-emerald font-semibold" id="detail-edu-ten-truong" style="color: #059669; font-size: 15px;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Khoa</span>
                            <div class="detail-value" id="detail-edu-khoa">-</div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Ngành học</span>
                            <div class="detail-value" id="detail-edu-nganh">-</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div class="detail-group">
                            <span class="detail-label">Trạng thái học tập</span>
                            <div>
                                <span class="timeline-status" id="detail-edu-trang-thai"></span>
                            </div>
                        </div>
                        <div class="detail-group">
                            <span class="detail-label">Học lực / GPA</span>
                            <div class="detail-value">
                                <span id="detail-edu-xep-loai">-</span> 
                                <span id="detail-edu-gpa-container" style="display:none;">(GPA: <strong id="detail-edu-gpa"></strong>)</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-group" style="margin-top: 14px;">
                        <span class="detail-label">Thời gian học tập</span>
                        <div class="detail-value font-semibold" id="detail-edu-thoi-gian"></div>
                    </div>
                </div>

                <!-- Column Right: Description -->
                <div class="detail-column-right" style="display: flex; flex-direction: column; height: 100%;">
                    <div class="detail-group" style="flex: 1; display: flex; flex-direction: column; height: 100%;">
                        <span class="detail-label">Mô tả chi tiết</span>
                        <div class="detail-value textarea-style" id="detail-edu-mo-ta" style="white-space: pre-wrap; flex: 1; min-height: 180px; margin-top: 4px; box-sizing: border-box; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <!-- Left side: Delete button -->
            <button type="button" class="btn-cancel" id="btn-detail-xoa-hoc-van" style="color: #ef4444; border-color: #fca5a5; background-color: #fee2e2; display: inline-flex; align-items: center; gap: 4px; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Xóa
            </button>
            <!-- Right side: Close and Edit buttons -->
            <div class="modal-footer-actions" style="display: flex; gap: 8px; margin: 0;">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-hoc-van" style="margin: 0;">Đóng</button>
                <button type="button" class="btn-save" id="btn-detail-sua-hoc-van" style="background-color: var(--accent-blue); color: white; border: 1px solid var(--accent-blue); display: inline-flex; align-items: center; gap: 4px; padding: 0 16px; margin: 0;">
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
        luuHocVan: "{{ route('ho-so.hoc-van.luu') }}",
        xoaHocVan: "{{ route('ho-so.hoc-van.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        toggleNoiBat: {
            hoc_van: "{{ route('ho-so.hoc-van.toggle-noi-bat', ['id' => '__ID__']) }}"
        }
    };

    // Wrapper cho toggle nổi bật + hiệu ứng spin
    function doToggleNoiBat(module, id, btn) {
        btn.classList.add('spin-once');
        btn.addEventListener('animationend', () => btn.classList.remove('spin-once'), { once: true });
        toggleNoiBat(module, id, btn);
    }
</script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/hoc-van/hoc-van.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/noi-bat.js') }}?v={{ time() }}"></script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

