<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hành trình phát triển - {{ $hoTen }}</title>
    <meta name="description" content="Trải nghiệm thời gian các mốc học vấn, dự án, chứng chỉ, thành tựu và kinh nghiệm của {{ $hoTen }}.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/hanh-trinh.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Hành trình phát triển', 'searchPlaceholder' => 'Tìm kiếm sự kiện, công nghệ, vị trí...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="timeline-header-card">
            <div class="timeline-header-title">
                <h2>Hành trình phát triển</h2>
                <p>Dòng thời gian tổng hợp toàn bộ học vấn, dự án công nghệ, chứng chỉ, kinh nghiệm làm việc và thành tựu cá nhân.</p>
            </div>
        </div>

        {{-- Profile Grid (2 Columns) --}}
        <div class="profile-grid">

            {{-- CỘT TRÁI: Tổng quan tóm tắt --}}
            <div class="grid-column">
                {{-- Card thống kê hành trình --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; color: var(--accent-blue);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Tổng quan hành trình</span>
                        </h3>
                    </div>
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số mốc sự kiện:</span>
                            <strong class="stats-value">
                                <span class="stats-badge badge-normal" style="color: var(--text-primary); background-color: #f1f5f9; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarHocVanCount + $sidebarDuAnCount + $sidebarChungChiCount + $sidebarThanhTuuCount + $sidebarKinhNghiemCount }}</span>
                            </strong>
                        </div>
                        <div class="stats-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-top: 1px solid var(--border-color);">
                            <span class="stats-label">Học vấn & Trình độ:</span>
                            <strong class="stats-value">
                                <span class="stats-badge" style="color: #1e40af; background-color: #eff6ff; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarHocVanCount }}</span>
                            </strong>
                        </div>
                        <div class="stats-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-top: 1px solid var(--border-color);">
                            <span class="stats-label">Portfolio dự án:</span>
                            <strong class="stats-value">
                                <span class="stats-badge" style="color: #065f46; background-color: #ecfdf5; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarDuAnCount }}</span>
                            </strong>
                        </div>
                        <div class="stats-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-top: 1px solid var(--border-color);">
                            <span class="stats-label">Chứng chỉ:</span>
                            <strong class="stats-value">
                                <span class="stats-badge" style="color: #5b21b6; background-color: #f5f3ff; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarChungChiCount }}</span>
                            </strong>
                        </div>
                        <div class="stats-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-top: 1px solid var(--border-color);">
                            <span class="stats-label">Thành tựu:</span>
                            <strong class="stats-value">
                                <span class="stats-badge" style="color: #854d0e; background-color: #fef9c3; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarThanhTuuCount }}</span>
                            </strong>
                        </div>
                        <div class="stats-item" style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-top: 1px solid var(--border-color);">
                            <span class="stats-label">Kinh nghiệm làm việc:</span>
                            <strong class="stats-value">
                                <span class="stats-badge" style="color: #9a3412; background-color: #fff7ed; padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $sidebarKinhNghiemCount }}</span>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: Dòng thời gian sự kiện & Các mốc thời gian --}}
            <div class="grid-column">
                @if(count($groupedTimeline) > 0)
                    <div class="timeline-split-layout">
                        {{-- Timeline List --}}
                        <div class="timeline-container" style="margin-top: 0; padding-top: 0;">
                            <div class="timeline-line"></div>

                            {{-- Card khi không tìm thấy kết quả lọc --}}
                            <div id="no-filter-results" class="no-results-card" style="display: none; text-align: center; padding: 48px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); margin-bottom: 20px;">
                                <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 48px; height: 48px; color: var(--text-secondary); margin: 0 auto 12px auto; opacity: 0.6;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                <h3 class="no-results-title" style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">Không tìm thấy kết quả phù hợp</h3>
                                <p class="no-results-desc" style="font-size: 13.5px; color: var(--text-secondary);">Vui lòng thử lại với từ khóa tìm kiếm khác.</p>
                            </div>

                            @foreach($groupedTimeline as $friendlyDate => $items)
                                @php
                                    $slug = Str::slug($friendlyDate);
                                @endphp
                                <div class="timeline-milestone-group" id="milestone-{{ $slug }}" data-milestone="{{ $friendlyDate }}">
                                    <div class="timeline-milestone-dot"></div>
                                    <div class="timeline-milestone-header">
                                        <span class="timeline-milestone-label">{{ $friendlyDate }}</span>
                                    </div>

                                    <div class="timeline-cards-list">
                                        @foreach($items as $item)
                                            @php
                                                $typeName = '';
                                                if ($item['type'] === 'hoc_van') $typeName = 'Học vấn & Trình độ';
                                                elseif ($item['type'] === 'du_an') $typeName = 'Dự án';
                                                elseif ($item['type'] === 'chung_chi') $typeName = 'Chứng chỉ';
                                                elseif ($item['type'] === 'thanh_tuu') $typeName = 'Thành tựu';
                                                elseif ($item['type'] === 'kinh_nghiem') $typeName = 'Kinh nghiệm làm việc';
                                            @endphp
                                            <div class="timeline-item-card type-{{ $item['type'] }}" 
                                                 data-type="{{ $item['type'] }}" 
                                                 data-item-json="{{ json_encode($item['original_data']) }}"
                                                 data-display-date="{{ $item['display_date'] }}"
                                                 onclick="moModalHanhTrinhChiTiet(this)">
                                                <div class="timeline-card-indicator"></div>
                                                
                                                <span class="timeline-badge badge-{{ $item['type'] }}">
                                                    {{ $typeName }}
                                                </span>

                                                <div class="timeline-card-header">
                                                    <div class="timeline-card-header-left">
                                                        <h3 class="timeline-card-title">{{ $item['title'] }}</h3>
                                                        <p class="timeline-card-subtitle">{{ $item['subtitle'] }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="timeline-card-date-badge">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 13px; height: 13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                            {{ $item['display_date'] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @php
                                                    $desc = '';
                                                    if ($item['type'] === 'hoc_van') $desc = $item['original_data']->mo_ta;
                                                    elseif ($item['type'] === 'du_an') $desc = $item['original_data']->mo_ta;
                                                    elseif ($item['type'] === 'thanh_tuu') $desc = $item['original_data']->mo_ta;
                                                    elseif ($item['type'] === 'kinh_nghiem') $desc = $item['original_data']->mo_ta_chi_tiet;
                                                @endphp
                                                @if(!empty($desc))
                                                    <p class="timeline-card-description">{{ strip_tags($desc) }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Milestone Scrollspy Navigation (Các mốc thời gian) --}}
                        <div class="milestones-scrollspy-wrapper">
                            <div class="info-card timeline-scrollspy-card">
                                <div class="card-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 20px;">
                                    <h3 class="card-title" style="font-size: 15px; font-weight: 750; text-transform: uppercase; color: var(--text-primary); letter-spacing: 0.03em;">
                                        CÁC MỐC THỜI GIAN
                                    </h3>
                                </div>
                                <div class="milestones-nav-list" style="display: flex; flex-direction: column; gap: 4px;">
                                    @php $isFirst = true; @endphp
                                    @foreach($groupedTimeline as $friendlyDate => $items)
                                        @php
                                            $slug = Str::slug($friendlyDate);
                                        @endphp
                                        <a href="#milestone-{{ $slug }}" class="milestone-nav-link {{ $isFirst ? 'active' : '' }}" data-target="milestone-{{ $slug }}">
                                            {{ $friendlyDate }}
                                        </a>
                                        @php $isFirst = false; @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 64px 24px; background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: var(--radius-lg); width: 100%;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 56px; height: 56px; color: var(--text-secondary); margin-bottom: 16px; opacity: 0.6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <h3 style="font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px;">Chưa có dữ liệu hành trình</h3>
                        <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">Vui lòng thêm thông tin Học vấn, Dự án, Kinh nghiệm, Chứng chỉ hoặc Thành tựu để hệ thống vẽ dòng thời gian sự nghiệp của bạn.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

{{-- MODAL: XEM CHI TIẾT HÀNH TRÌNH (VIEW ONLY - KHÔNG SỬA / XÓA) --}}
<div class="modal-overlay" id="modal-chi-tiet-hanh-trinh" role="dialog" aria-modal="true" aria-labelledby="modal-title-hanh-trinh">
    <div class="modal-panel max-w-2xl">
        {{-- Header --}}
        <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
            <div class="modal-header-left">
                <div class="modal-icon" id="detail-modal-icon-container" style="background-color: #f1f5f9; color: var(--text-secondary);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-title-hanh-trinh">Chi tiết sự kiện</div>
                    <div class="modal-subtitle" id="modal-subtitle-hanh-trinh">Thông tin dòng thời gian phát triển</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-hanh-trinh" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body" style="padding-top: 20px;">
            <div style="display: flex; flex-direction: column; gap: 18px;" id="detail-modal-fields">
                {{-- Loaded dynamically by JavaScript --}}
            </div>
        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="display: flex; justify-content: flex-end; width: 100%; border-top: 1px solid var(--border-color);">
            <button type="button" class="btn-cancel" data-dong-modal="modal-chi-tiet-hanh-trinh" style="margin: 0;">Đóng</button>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- Scripts --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>

<script>
    /**
     * Mở modal xem chi tiết hành trình dựa trên dữ liệu lưu trong data attributes
     */
    function moModalHanhTrinhChiTiet(card) {
        const type = card.getAttribute('data-type');
        const displayDate = card.getAttribute('data-display-date');
        const item = JSON.parse(card.getAttribute('data-item-json'));

        console.log('[HanhTrinh] moModal called with type:', type, 'item:', item);

        const titleEl = document.getElementById('modal-title-hanh-trinh');
        const subtitleEl = document.getElementById('modal-subtitle-hanh-trinh');
        const fieldsContainer = document.getElementById('detail-modal-fields');
        const iconContainer = document.getElementById('detail-modal-icon-container');

        // Reset
        fieldsContainer.innerHTML = '';
        
        let headerTitle = '';
        let headerSubtitle = '';
        let iconSvg = '';
        let iconBgColor = '#f1f5f9';
        let iconColor = '#475569';
        let fieldsHtml = '';

        if (type === 'hoc_van') {
            headerTitle = 'Chi tiết Học vấn & Trình độ';
            headerSubtitle = 'Bằng cấp học thuật và quá trình đào tạo';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>`;
            iconBgColor = '#eff6ff';
            iconColor = '#1e40af';

            const gpaVal = item.gpa ? parseFloat(item.gpa).toFixed(2) : 'Chưa cập nhật';
            const xepLoaiVal = item.xep_loai || 'Chưa cập nhật';
            const khoaVal = item.khoa || 'Chưa cập nhật';
            const nganhVal = item.nganh || 'Chưa cập nhật';
            const moTaVal = item.mo_ta || 'Không có mô tả chi tiết học vấn.';

            let trangThaiText = 'Đang học';
            if (item.trang_thai === 'da_tot_nghiep') trangThaiText = 'Đã tốt nghiệp';
            else if (item.trang_thai === 'bao_luu') trangThaiText = 'Bảo lưu kết quả';
            else if (item.trang_thai === 'tam_dung') trangThaiText = 'Tạm dừng học';

            fieldsHtml = `
                <div class="detail-field-group">
                    <div class="detail-field-label">Tiêu đề bằng cấp / chứng chỉ</div>
                    <div class="detail-field-value text-primary" style="font-size: 16px; font-weight: 700;">${item.tieu_de}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Trường / Tổ chức đào tạo</div>
                    <div class="detail-field-value font-semibold" style="color:#1e40af;">${item.ten_truong}</div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Khoa</div>
                        <div class="detail-field-value">${khoaVal}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Ngành học</div>
                        <div class="detail-field-value">${nganhVal}</div>
                    </div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Thời gian</div>
                        <div class="detail-field-value">${displayDate}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Trạng thái học tập</div>
                        <div class="detail-field-value"><span class="certificate-status-badge status-valid">${trangThaiText}</span></div>
                    </div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Điểm GPA</div>
                        <div class="detail-field-value">${gpaVal}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Xếp loại học lực</div>
                        <div class="detail-field-value">${xepLoaiVal}</div>
                    </div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Mô tả quá trình học tập</div>
                    <div class="detail-field-value rich-text">${moTaVal}</div>
                </div>
            `;
        } 
        else if (type === 'du_an') {
            headerTitle = 'Chi tiết Dự án / Sản phẩm';
            headerSubtitle = 'Các sản phẩm và dự án công nghệ thực chiến';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>`;
            iconBgColor = '#ecfdf5';
            iconColor = '#065f46';

            // Decode tu_khoa
            let tagsHtml = '';
            let tags = [];
            try {
                tags = Array.isArray(item.tu_khoa) ? item.tu_khoa : (item.tu_khoa ? JSON.parse(item.tu_khoa) : []);
            } catch(e) {
                tags = [];
            }
            if (tags && tags.length > 0) {
                tagsHtml = tags.map(tag => `<span class="project-tag" style="margin-right:6px; margin-bottom:6px; display:inline-block;">${tag}</span>`).join('');
            } else {
                tagsHtml = '<span style="font-style:italic; color:#64748b; font-size:12px;">Không có từ khóa công nghệ.</span>';
            }

            // Decode links
            let linksHtml = '';
            let links = Array.isArray(item.lien_ket) ? item.lien_ket : [];
            if (links && links.length > 0) {
                linksHtml = links.map(lk => {
                    return `
                        <a href="${lk.duong_dan}" target="_blank" class="btn-view-credential" style="font-size:12px; padding:3px 10px; border-radius:20px; text-decoration:none; margin-right:8px; display:inline-flex; align-items:center; gap:4px; width:auto; height:auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span>${lk.nhan_hien_thi || lk.loai_lien_ket}</span>
                        </a>
                    `;
                }).join('');
            } else {
                linksHtml = '<span style="font-style:italic; color:#64748b; font-size:12px;">Không có liên kết dự án.</span>';
            }

            fieldsHtml = `
                <div class="detail-field-group">
                    <div class="detail-field-label">Tên dự án / sản phẩm</div>
                    <div class="detail-field-value text-primary" style="font-size: 16px; font-weight: 700;">${item.ten_du_an}</div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Vai trò</div>
                        <div class="detail-field-value font-semibold" style="color:#065f46;">${item.vai_tro || 'Thành viên'}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Thời gian thực hiện</div>
                        <div class="detail-field-value">${displayDate}</div>
                    </div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Công nghệ sử dụng</div>
                    <div class="project-card-tags" style="margin-top:6px;">${tagsHtml}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Liên kết ngoài</div>
                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:6px;">${linksHtml}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Mô tả chi tiết dự án</div>
                    <div class="detail-field-value rich-text">${item.mo_ta || 'Không có mô tả chi tiết dự án.'}</div>
                </div>
            `;
        } 
        else if (type === 'chung_chi') {
            headerTitle = 'Chi tiết Chứng chỉ / Bằng cấp';
            headerSubtitle = 'Bằng cấp chuyên môn và chứng nhận kỹ năng';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>`;
            iconBgColor = '#f5f3ff';
            iconColor = '#5b21b6';

            let categoryText = 'Chuyên môn';
            if (item.phan_loai === 'ngoai_ngu') categoryText = 'Ngoại ngữ';
            else if (item.phan_loai === 'ky_nang') categoryText = 'Kỹ năng mềm';
            else if (item.phan_loai === 'khac') categoryText = 'Khác';

            const maVal = item.ma_chung_chi || 'Không có mã định danh';
            const cleanUrl = item.url_tap_tin ? item.url_tap_tin.trim() : '';
            const linkHtml = cleanUrl ? `
                <div class="detail-field-group">
                    <div class="detail-field-label">Liên kết xác minh</div>
                    <div style="margin-top:6px;">
                        <a href="${cleanUrl}" target="_blank" class="btn-view-credential" style="font-size:13px; display:inline-flex; align-items:center; gap:6px; width:auto; height:auto; padding:6px 14px; text-decoration:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Xem chứng chỉ gốc</span>
                        </a>
                    </div>
                </div>
            ` : '';

            const cleanPdf = item.file_pdf ? item.file_pdf.trim() : '';
            const pdfHtml = cleanPdf ? `
                <div class="detail-field-group" style="margin-top: 10px;">
                    <div class="detail-field-label">Tệp PDF đính kèm</div>
                    <div style="margin-top:6px;">
                        <a href="${window.location.origin}/${cleanPdf}" target="_blank" class="btn-view-credential" style="font-size:13px; display:inline-flex; align-items:center; gap:6px; width:auto; height:auto; padding:6px 14px; text-decoration:none; background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Xem tệp PDF</span>
                        </a>
                    </div>
                </div>
            ` : '';

            const formatNgay = (dateStr) => {
                if(!dateStr) return '';
                const d = new Date(dateStr);
                return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()}`;
            };

            const isExpired = item.ngay_het_han && new Date(item.ngay_het_han) < new Date();
            const statusBadge = isExpired ? `<span class="certificate-status-badge status-expired">Hết hạn</span>` : `<span class="certificate-status-badge status-valid">Còn hiệu lực</span>`;

            fieldsHtml = `
                <div class="detail-field-group">
                    <div class="detail-field-label">Tên chứng chỉ / bằng cấp</div>
                    <div class="detail-field-value text-primary" style="font-size: 16px; font-weight: 700;">${item.ten_chung_chi}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Tổ chức cấp</div>
                    <div class="detail-field-value font-semibold" style="color:#5b21b6;">${item.to_chuc_cap}</div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Phân loại</div>
                        <div class="detail-field-value"><span class="certificate-category-badge category-${item.phan_loai}">${categoryText}</span></div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Mã chứng chỉ</div>
                        <div class="detail-field-value">${maVal}</div>
                    </div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Ngày cấp</div>
                        <div class="detail-field-value font-semibold">${formatNgay(item.ngay_cap)}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Ngày hết hạn</div>
                        <div class="detail-field-value font-semibold">${item.ngay_het_han ? formatNgay(item.ngay_het_han) : 'Không hết hạn'}</div>
                    </div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Trạng thái hiệu lực</div>
                    <div class="detail-field-value" style="margin-top:4px;">${statusBadge}</div>
                </div>
                ${linkHtml}
                ${pdfHtml}
            `;
        } 
        else if (type === 'thanh_tuu') {
            headerTitle = 'Chi tiết Thành tựu';
            headerSubtitle = 'Các giải thưởng, danh hiệu và học bổng đạt được';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>`;
            iconBgColor = '#fef9c3';
            iconColor = '#854d0e';

            let categoryText = 'Giải thưởng';
            if (item.phan_loai === 'hoc_bong') categoryText = 'Học bổng';
            else if (item.phan_loai === 'danh_hieu') categoryText = 'Danh hiệu';

            const toChuc = item.to_chuc_cap || 'Chưa cập nhật đơn vị';
            const minhChung = item.link_minh_chung ? item.link_minh_chung.trim() : '';
            const linkHtml = minhChung ? `
                <div class="detail-field-group">
                    <div class="detail-field-label">Liên kết minh chứng</div>
                    <div style="margin-top:6px;">
                        <a href="${minhChung}" target="_blank" class="btn-view-credential" style="font-size:13px; display:inline-flex; align-items:center; gap:6px; width:auto; height:auto; padding:6px 14px; text-decoration:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Xem minh chứng ngoài</span>
                        </a>
                    </div>
                </div>
            ` : '';

            fieldsHtml = `
                <div class="detail-field-group">
                    <div class="detail-field-label">Tên thành tựu</div>
                    <div class="detail-field-value text-primary" style="font-size: 16px; font-weight: 700;">${item.ten_thanh_tuu}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Đơn vị trao tặng</div>
                    <div class="detail-field-value font-semibold" style="color:#854d0e;">${toChuc}</div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Phân loại</div>
                        <div class="detail-field-value"><span class="certificate-category-badge" style="background-color:#fef9c3; color:#854d0e; border:1px solid #fef08a;">${categoryText}</span></div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Thời gian đạt được</div>
                        <div class="detail-field-value">${displayDate}</div>
                    </div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Mô tả chi tiết</div>
                    <div class="detail-field-value rich-text">${item.mo_ta || 'Không có mô tả chi tiết thành tựu.'}</div>
                </div>
                ${linkHtml}
            `;
        } 
        else if (type === 'kinh_nghiem') {
            headerTitle = 'Chi tiết Kinh nghiệm làm việc';
            headerSubtitle = 'Lịch sử công tác và kinh nghiệm thực tế';
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>`;
            iconBgColor = '#fff7ed';
            iconColor = '#9a3412';

            fieldsHtml = `
                <div class="detail-field-group">
                    <div class="detail-field-label">Vị trí công việc / Chức vụ</div>
                    <div class="detail-field-value text-primary" style="font-size: 16px; font-weight: 700;">${item.vi_tri_cong_viec}</div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Công ty / Cơ quan công tác</div>
                    <div class="detail-field-value font-semibold" style="color:#9a3412;">${item.ten_cong_ty}</div>
                </div>
                <div class="modal-detail-grid">
                    <div class="detail-field-group">
                        <div class="detail-field-label">Thời gian làm việc</div>
                        <div class="detail-field-value">${displayDate}</div>
                    </div>
                    <div class="detail-field-group">
                        <div class="detail-field-label">Trạng thái công tác</div>
                        <div class="detail-field-value"><span class="certificate-status-badge status-valid">${item.dang_lam_viec ? 'Đang làm việc tại đây' : 'Đã kết thúc'}</span></div>
                    </div>
                </div>
                <div class="detail-field-group">
                    <div class="detail-field-label">Mô tả công việc chi tiết</div>
                    <div class="detail-field-value rich-text">${item.mo_ta_chi_tiet || 'Không có mô tả chi tiết công việc.'}</div>
                </div>
            `;
        }

        // Apply fields and display
        titleEl.textContent = headerTitle;
        subtitleEl.textContent = headerSubtitle;
        iconContainer.innerHTML = iconSvg;
        iconContainer.style.backgroundColor = iconBgColor;
        iconContainer.style.color = iconColor;
        fieldsContainer.innerHTML = fieldsHtml;

        moModal('modal-chi-tiet-hanh-trinh');
    }

    // Scrollspy highlight logic
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.milestone-nav-link');
        const milestoneGroups = document.querySelectorAll('.timeline-milestone-group');
        
        // Smooth scroll on click
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const offset = 74; 
                    const elementPosition = targetElement.getBoundingClientRect().top + window.scrollY;
                    const offsetPosition = elementPosition - offset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Scrollspy highlight logic
        function updateActiveMilestone() {
            let activeId = null;
            const scrollPosition = window.scrollY || document.documentElement.scrollTop;
            const offset = 150; // offset for header + top padding

            for (const group of milestoneGroups) {
                if (group.style.display !== 'none') {
                    const top = group.offsetTop;
                    if (scrollPosition >= top - offset) {
                        activeId = group.getAttribute('id');
                    }
                }
            }

            // Fallback to first visible group if scroll position is near top
            if (!activeId && milestoneGroups.length > 0) {
                for (const group of milestoneGroups) {
                    if (group.style.display !== 'none') {
                        activeId = group.getAttribute('id');
                        break;
                    }
                }
            }

            if (activeId) {
                navLinks.forEach(link => {
                    if (link.getAttribute('data-target') === activeId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }
        }

        window.addEventListener('scroll', updateActiveMilestone);
        updateActiveMilestone(); // Run initially
    });
</script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

