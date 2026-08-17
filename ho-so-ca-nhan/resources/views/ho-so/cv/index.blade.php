<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý CV cá nhân - {{ $hoTen }}</title>
    <meta name="description" content="Tạo và quản lý các CV cá nhân từ hồ sơ nghề nghiệp.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/cv/cv-style.css') }}?v={{ time() }}">
    <style>
        @media (min-width: 769px) {
            #modal-them-cv .modal-panel {
                max-width: 980px !important;
                width: 95% !important;
            }
            .modal-preview-right {
                width: 360px !important;
            }
        }
        @media (max-width: 768px) {
            .modal-preview-right {
                display: none !important;
            }
            #modal-them-cv .modal-panel {
                max-width: 550px !important;
                width: 90% !important;
            }
        }

        /* Zoom hover effect for preview image */
        .preview-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            width: 100%;
        }
        .preview-img-container:hover .preview-zoom-overlay {
            opacity: 1 !important;
        }
        .preview-img-container:hover #template-live-preview-img {
            transform: scale(1.03);
            filter: brightness(0.9);
        }

        /* Styling for Xem mẫu button under template option card */
        .btn-xem-mau-truoc {
            border: none;
            background: none;
            color: #2563eb;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }
        .btn-xem-mau-truoc:hover {
            background-color: rgba(37, 99, 235, 0.08);
            color: #1d4ed8 !important;
        }

        /* Custom styles for template zoom modal */
        #modal-zoom-template.active .zoom-panel {
            transform: scale(1) !important;
            opacity: 1 !important;
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Quản lý CV', 'searchPlaceholder' => 'Tìm kiếm...'])

    {{-- Content Body --}}
    <div class="content-body">
        
        {{-- Flash Session Message --}}
        @if(session('thong_bao'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    hienToast('success', "{{ session('thong_bao') }}");
                });
            </script>
        @endif

        @if(session('loi'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    hienToast('error', "{{ session('loi') }}");
                });
            </script>
        @endif

        {{-- Header Card --}}
        <div class="cv-header-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div class="cv-title-section">
                    <h2>Danh sách CV cá nhân</h2>
                    <p>Tạo và quản lý các phiên bản CV trực quan. CV được tự động tổng hợp từ dữ liệu hồ sơ cá nhân của bạn.</p>
                </div>
                <div>
                    <button type="button" class="btn-create-cv-trigger" onclick="moModal('modal-them-cv')" style="margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tạo CV mới</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Grid --}}
        <div class="cv-grid">
            
            {{-- Cột Trái: Thống kê & Mẹo --}}
            <div class="cv-grid-left">
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2"/></svg>
                            <span>Thống kê CV</span>
                        </h3>
                    </div>
                    @php
                        $tongSoCv = $danhSachCv->count();
                        $cvChinh = $danhSachCv->where('la_cv_chinh', 1)->first();
                        $nhapCount = $danhSachCv->where('la_cv_chinh', 0)->count();
                        $thuCongCount = $danhSachCv->filter(function($cv) {
                            return ($cv->tuy_chinh['kieu_cv'] ?? '') === 'thu_cong';
                        })->count();
                        $tuDongCount = $tongSoCv - $thuCongCount;
                    @endphp
                    <div class="stats-list">
                        <div class="stats-item">
                            <span class="stats-label">Tổng số CV:</span>
                            <span class="stats-value-badge">{{ $tongSoCv }}</span>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">CV chính thức:</span>
                            <span class="stats-value-text" style="color: #10b981; font-weight: 600;">
                                {{ $cvChinh ? $cvChinh->ten_cv : 'Chưa thiết lập' }}
                            </span>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">CV thủ công:</span>
                            <span class="stats-value-badge secondary">{{ $thuCongCount }}</span>
                        </div>
                        <div class="stats-item">
                            <span class="stats-label">CV tự động:</span>
                            <span class="stats-value-badge secondary">{{ $tuDongCount }}</span>
                        </div>
                    </div>
                </div>

                {{-- Hướng dẫn/Mẹo --}}
                <div class="info-card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3 class="card-title" style="color: var(--accent-blue);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Gợi ý cho bạn</span>
                        </h3>
                    </div>
                    <ul class="tips-list" style="padding-left: 20px; font-size: 13px; line-height: 1.6; color: var(--cv-text-secondary); display: flex; flex-direction: column; gap: 8px;">
                        <li><strong>Đồng bộ dữ liệu:</strong> Thông tin trên CV được đồng bộ tự động từ các mục Học vấn, Kinh nghiệm, Dự án,... ở thanh điều hướng bên trái.</li>
                        <li><strong>CV tự động :</strong> Phù hợp để xuất nhanh PDF A4 tiêu chuẩn. Hệ thống sẽ tự động tổng hợp những thông tin nổi bật nhất trong hồ sơ của bạn.</li>
                        <li><strong>CV thủ công (Tự thiết kế):</strong> Cho phép thay đổi màu sắc chủ đạo, đổi mẫu thiết kế, ẩn/hiện hoặc kéo thả để sắp xếp lại thứ tự các phần theo mong muốn.</li>
                        <li><strong>Thiết lập CV chính:</strong> Giúp người khác xem được CV của bạn trong Dịch vụ cá nhân và tải CV bên Chia sẻ hồ sơ.</li>
                    </ul>
                </div>
            </div>

            {{-- Cột Phải: Danh sách CV --}}
            <div class="cv-grid-right">
                @if($tongSoCv === 0)
                    <div class="cv-empty-state">
                        <div class="empty-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3>Chưa có CV nào được tạo</h3>
                        <p>Hãy tạo một CV đầu tiên để ứng tuyển công việc mơ ước của bạn. Bạn có thể chọn tự sinh tự động từ hồ sơ hoặc tự thiết kế thủ công.</p>
                        <button type="button" class="btn-create-cv-trigger" onclick="moModal('modal-them-cv')" style="margin-top: 15px;">Tạo CV đầu tiên</button>
                    </div>
                @else
                    {{-- Bộ lọc --}}
                    <div class="filter-card">
                        <div class="filter-main-row">
                            <div class="filter-col-phan-loai">
                                <select id="filter-template" class="filter-select">
                                    <option value="">Tất cả các mẫu</option>
                                    <option value="template_classic">Classic Minimal</option>
                                    <option value="template_modern">Modern Professional</option>
                                </select>
                            </div>

                            <div class="filter-col-phan-loai">
                                <select id="filter-kieu" class="filter-select">
                                    <option value="">Tất cả hình thức</option>
                                    <option value="thu_cong">Tự thiết kế</option>
                                    <option value="tu_dong">Sinh tự động</option>
                                </select>
                            </div>

                            <div class="filter-col-phan-loai">
                                <select id="filter-trang-thai" class="filter-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="chinh_thuc">CV chính thức</option>
                                    <option value="nhap">Bản nháp</option>
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

                    <div class="cv-cards-list">
                        {{-- Card khi không tìm thấy kết quả lọc --}}
                        <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
                            <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            <h3 class="no-results-title">Không tìm thấy CV phù hợp</h3>
                            <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
                        </div>

                        @foreach($danhSachCv as $cv)
                            <div class="cv-card {{ $cv->la_cv_chinh ? 'main-cv-card' : '' }}"
                                 data-template="{{ $cv->ma_template }}"
                                 data-kieu="{{ $cv->tuy_chinh['kieu_cv'] ?? 'thu_cong' }}"
                                 data-trang-thai="{{ $cv->la_cv_chinh ? 'chinh_thuc' : 'nhap' }}">
                                {{-- Preview thumbnail placeholder with CSS layout mockup --}}
                                <div class="cv-card-thumbnail">
                                    <div class="cv-mockup-page {{ $cv->ma_template }}">
                                        <div class="mockup-header" style="background-color: {{ $cv->tuy_chinh['mau_chu_dao'] ?? '#1e3a8a' }}"></div>
                                        <div class="mockup-body">
                                            <div class="mockup-line title"></div>
                                            <div class="mockup-line desc"></div>
                                            <div class="mockup-blocks">
                                                <div class="mockup-block"></div>
                                                <div class="mockup-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cv-thumbnail-overlay">
                                        <a href="{{ route('ho-so.cv.preview', $cv->id) }}" class="btn-thumbnail-action preview" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Xem trước
                                        </a>
                                        @if(!$isMobile)
                                            <a href="{{ route('ho-so.cv.edit', $cv->id) }}" class="btn-thumbnail-action edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                Chỉnh sửa
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="cv-card-info">
                                    <div class="cv-card-meta">
                                        @if($cv->la_cv_chinh)
                                            <span class="cv-badge active">CV chính thức</span>
                                        @else
                                            <span class="cv-badge draft">Bản nháp</span>
                                        @endif

                                        <span class="cv-type-badge {{ $cv->tuy_chinh['kieu_cv'] ?? 'thu_cong' }}">
                                            {{ ($cv->tuy_chinh['kieu_cv'] ?? 'thu_cong') === 'thu_cong' ? 'Tự thiết kế' : 'Sinh tự động' }}
                                        </span>
                                    </div>
                                    
                                    <h4 class="cv-card-title">{{ $cv->ten_cv }}</h4>
                                    <p class="cv-card-desc">{{ ($cv->tuy_chinh['mo_ta_ngan'] ?? '') ?: 'Không có mô tả ngắn.' }}</p>
                                    
                                    <div class="cv-card-details">
                                        <div class="detail-item">
                                            <span>Mẫu:</span>
                                            <strong>{{ $cv->ma_template === 'template_classic' ? 'Classic Minimal' : 'Modern Professional' }}</strong>
                                        </div>
                                        <div class="detail-item">
                                            <span>Cập nhật:</span>
                                            <strong>{{ date('d/m/Y H:i', strtotime($cv->ngay_cap_nhat)) }}</strong>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="cv-card-actions">
                                        <div style="display: flex; gap: 8px;">
                                            @if(!$isMobile)
                                                <a href="{{ route('ho-so.cv.edit', $cv->id) }}" class="btn-card-action edit-btn" title="Chỉnh sửa bố cục & màu sắc">
                                                    Sửa thiết kế
                                                </a>
                                            @endif
                                            <a href="{{ route('ho-so.cv.preview', $cv->id) }}?download=1" class="btn-card-action preview-btn" target="_blank" title="Tải xuống trực tiếp CV dạng file PDF">
                                                Xuất PDF
                                            </a>
                                        </div>
                                        
                                        <div style="display: flex; gap: 8px; align-items: center;">
                                            @if(!$cv->la_cv_chinh)
                                                <form action="{{ route('ho-so.cv.set-main', $cv->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon-action set-main-btn" title="Đặt làm CV chính">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; color: #9ca3af;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn-icon-action delete-btn" onclick="xacNhanXoa({{ $cv->id }})" title="Xóa CV này">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px; color: #ef4444;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</main>


{{-- MODAL: TẠO CV MỚI --}}
<div class="modal-overlay" id="modal-them-cv">
    <div class="modal-panel" style="max-width: 980px; border-radius: 16px;">
        <div class="modal-header" style="padding: 20px 28px; border-bottom: 1px solid #f1f5f9;">
            <div class="modal-header-left" style="display: flex; align-items: center; gap: 12px;">
                <div class="modal-icon" style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #eff6ff, #e0e7ff); display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px; color: #2563eb;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <h3 class="modal-title" style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0;">Tạo mới một CV</h3>
                    <p class="modal-subtitle" style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Chọn hình thức khởi tạo và mẫu thiết kế phù hợp</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="dongModal('modal-them-cv')" aria-label="Đóng" style="background: none; border: 1px solid #e2e8f0; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <form action="{{ route('ho-so.cv.store') }}" method="POST" id="form-them-cv" style="display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden;">
            @csrf
            <div class="modal-body" style="padding: 0; display: flex; flex: 1; min-height: 0; overflow: hidden; align-items: stretch;">
                
                {{-- Left side: Form fields (scrollable) --}}
                <div class="modal-form-left" style="flex: 1; padding: 24px 28px; overflow-y: auto; max-height: calc(90vh - 160px); scrollbar-width: thin; scrollbar-color: #e2e8f0 transparent;">
                    
                    {{-- Section 1: Thông tin cơ bản --}}
                    <div class="form-section" style="margin-bottom: 24px;">
                        <div class="form-section-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                            <span>Thông tin cơ bản</span>
                            <span style="flex: 1; height: 1px; background: #f1f5f9;"></span>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 16px; display: flex; flex-direction: column; gap: 6px;">
                            <label class="form-label required">Tên gọi của CV</label>
                            <input type="text" name="ten_cv" class="form-control-input" required minlength="2" maxlength="30" placeholder="VD: CV ứng tuyển lập trình viên Web, CV Freelance...">
                            <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 2px;">* Từ 2 đến 30 ký tự, không chứa ký tự đặc biệt.</span>
                        </div>

                        <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                            <label class="form-label">Mô tả ngắn</label>
                            <textarea name="mo_ta_ngan" class="form-control-textarea" rows="2" maxlength="200" placeholder="Nhập mô tả ngắn gọn về mục tiêu hoặc phiên bản của CV này..."></textarea>
                            <span class="form-hint" style="font-size: 11px; color: #64748b; margin-top: 2px;">* Tối đa 200 ký tự.</span>
                        </div>
                    </div>

                    {{-- Section 2: Hình thức khởi tạo --}}
                    <div class="form-section" style="margin-bottom: 24px;">
                        <div class="form-section-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                            <span>Hình thức khởi tạo</span>
                            <span style="flex: 1; height: 1px; background: #f1f5f9;"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="cv-type-selector">
                                @if(!$isMobile)
                                    <label class="type-option">
                                        <input type="radio" name="kieu_cv" value="thu_cong" checked onclick="handleKieuCvChange('thu_cong')">
                                        <div class="option-box">
                                            <div class="option-icon"> </div>
                                            <h4>CV Thủ công (Tự thiết kế)</h4>
                                            <p>Tự do tùy biến mẫu thiết kế, màu sắc chủ đạo, bật/tắt và kéo sắp xếp các mục theo ý thích.</p>
                                        </div>
                                    </label>
                                @endif
                                <label class="type-option">
                                    <input type="radio" name="kieu_cv" value="tu_dong" {{ $isMobile ? 'checked' : '' }} onclick="handleKieuCvChange('tu_dong')">
                                    <div class="option-box">
                                        <div class="option-icon"></div>
                                        <h4>CV Tự động </h4>
                                        <p>Hệ thống tự động lọc thông tin nổi bật nhất trong hồ sơ và đưa vào mẫu Classic mặc định.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Mẫu Template --}}
                    <div class="form-section" id="template-select-group" style="margin-bottom: 0;">
                        <div class="form-section-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                            <span>Chọn Template ban đầu</span>
                            <span style="flex: 1; height: 1px; background: #f1f5f9;"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="template-selector-grid">
                                @foreach($templates as $tpl)
                                    <label class="template-option-card">
                                        <input type="radio" name="ma_template" value="{{ $tpl->ma_mau_cv }}" {{ $loop->first ? 'checked' : '' }} onchange="updateLiveTemplatePreview('{{ $tpl->ma_mau_cv }}', '{{ $tpl->ten_mau }}', '{{ asset($tpl->anh_xem_truoc) }}')">
                                        <div class="template-card-box">
                                            <div class="template-mockup-preview {{ $tpl->ma_mau_cv }}">
                                                @if($tpl->ma_mau_cv === 'template_modern')
                                                    <div class="mock-sidebar"></div>
                                                    <div class="mock-main">
                                                        <div class="mock-ln wide" style="background-color: var(--accent-blue);"></div>
                                                        <div class="mock-ln"></div>
                                                        <div class="mock-ln"></div>
                                                    </div>
                                                @else
                                                    <div class="mock-hdr"></div>
                                                    <div class="mock-bdy">
                                                        <div class="mock-ln wide" style="background-color: var(--accent-blue);"></div>
                                                        <div class="mock-ln"></div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; width: 100%;">
                                                <span class="template-name" style="font-weight: 600; font-size: 11px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">{{ $tpl->ten_mau }}</span>
                                                <button type="button" class="btn-xem-mau-truoc" onclick="event.stopPropagation(); moZoomTemplateOption('{{ asset($tpl->anh_xem_truoc) }}', '{{ $tpl->ten_mau }}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <span>Xem mẫu</span>
                                                </button>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right side: Sticky Live Template Preview --}}
                <div class="modal-preview-right" style="width: 360px; background-color: #f8fafc; border-left: 1px solid #e2e8f0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; box-sizing: border-box; flex-shrink: 0; min-height: 0;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; margin-bottom: 16px; align-self: flex-start;">
                        Xem trước mẫu thiết kế
                    </div>
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; width: 100%; min-height: 0; position: relative;" class="preview-img-container" onclick="moZoomTemplate()">
                        <div class="preview-zoom-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.4); opacity: 0; transition: opacity 0.25s ease; border-radius: 8px; cursor: pointer; color: white; font-weight: 600; font-size: 13px; z-index: 5;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(15, 23, 42, 0.85); padding: 8px 16px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                Click để phóng to
                            </span>
                        </div>
                        <img id="template-live-preview-img" src="{{ asset('uploads/cv-templates/classic.png') }}" alt="Mẫu CV Preview" style="max-width: 100%; max-height: 380px; object-fit: contain; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); background-color: white; transition: all 0.3s ease; cursor: pointer;">
                    </div>
                    <div id="template-preview-desc" style="margin-top: 14px; font-size: 12.5px; color: #475569; text-align: center; font-weight: 600; line-height: 1.4;">
                        Cổ điển đơn giản (Classic)
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="padding: 16px 28px; background: #fafbfc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn-cancel" onclick="dongModal('modal-them-cv')">Hủy bỏ</button>
                <button type="submit" class="btn-save" style="background: linear-gradient(135deg, #2563eb, #4f46e5); color: white; border: none; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">Bắt đầu tạo</button>
            </div>
        </form>
    </div>
</div>

<!-- Removed modal-xoa-cv -->

{{-- MODAL: XEM TOÀN BỘ MẪU CV (ZOOM) --}}
<div class="modal-overlay" id="modal-zoom-template" onclick="if (event.target === this) dongModal('modal-zoom-template')" style="z-index: 1200; background: rgba(10, 18, 38, 0.85); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
    <div style="position: relative; max-width: 90%; max-height: 90%; display: flex; flex-direction: column; align-items: center; justify-content: center; transform: scale(0.95); opacity: 0; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);" class="zoom-panel">
        <button type="button" class="modal-close" onclick="dongModal('modal-zoom-template')" aria-label="Đóng" style="position: absolute; top: -45px; right: 0; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; transition: all 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="zoom-template-img" src="" alt="Mẫu CV phóng to" style="max-width: 100%; max-height: 80vh; object-fit: contain; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); background-color: white;">
        <div id="zoom-template-desc" style="margin-top: 16px; color: white; font-size: 15px; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.6); letter-spacing: 0.05em;"></div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script>
    function updateLiveTemplatePreview(ma, ten, imgUrl) {
        const previewImg = document.getElementById('template-live-preview-img');
        const previewDesc = document.getElementById('template-preview-desc');
        if (previewImg) {
            previewImg.style.opacity = '0.3';
            previewImg.style.transform = 'scale(0.95)';
            setTimeout(() => {
                previewImg.src = imgUrl;
                previewImg.style.opacity = '1';
                previewImg.style.transform = 'scale(1)';
            }, 120);
        }
        if (previewDesc) {
            previewDesc.innerText = ten;
        }
    }

    function moZoomTemplateOption(imgUrl, ten) {
        const zoomImg = document.getElementById('zoom-template-img');
        const zoomDesc = document.getElementById('zoom-template-desc');
        if (zoomImg) {
            zoomImg.src = imgUrl;
            if (zoomDesc) {
                zoomDesc.innerText = ten;
            }
            moModal('modal-zoom-template');
        }
    }

    function moZoomTemplate() {
        const previewImg = document.getElementById('template-live-preview-img');
        const previewDesc = document.getElementById('template-preview-desc');
        if (previewImg) {
            moZoomTemplateOption(previewImg.src, previewDesc ? previewDesc.innerText : '');
        }
    }

    function handleKieuCvChange(kieu) {
        const group = document.getElementById('template-select-group');
        if (kieu === 'tu_dong') {
            // Ẩn phần chọn template vì CV tự động luôn mặc định dùng Classic
            group.style.display = 'none';
            // Đảm bảo chọn template mặc định (mẫu đầu tiên) trong form để gửi lên server
            const firstRadio = group.querySelector('input[type="radio"]');
            if (firstRadio) {
                firstRadio.checked = true;
                updateLiveTemplatePreview(
                    firstRadio.value,
                    'Mẫu Classic mặc định (Sinh tự động)',
                    '{{ asset("uploads/cv-templates/classic.png") }}'
                );
            }
        } else {
            // Hiện phần chọn template từ các mẫu do Admin cung cấp cho CV thủ công
            group.style.display = 'block';
            
            // Kích hoạt cập nhật preview hình ảnh cho mẫu đang được checked
            const checkedRadio = group.querySelector('input[type="radio"]:checked');
            if (checkedRadio) {
                if (typeof checkedRadio.onchange === 'function') {
                    checkedRadio.onchange();
                } else {
                    checkedRadio.dispatchEvent(new Event('change'));
                }
            }
        }
    }

    function xacNhanXoa(id) {
        if (!confirm('Bạn có chắc chắn muốn xóa CV này không?')) {
            return;
        }

        let routeTemplate = "{{ route('ho-so.cv.destroy', ['id' => 'ID_PLACEHOLDER']) }}";
        const url = routeTemplate.replace('ID_PLACEHOLDER', id);
        const token = typeof layToken === 'function' ? layToken() : '';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            const result = isJson ? await res.json() : null;
            if (!res.ok) {
                if (result && result.thong_bao) {
                    throw new Error(result.thong_bao);
                }
                throw new Error('Lỗi máy chủ (' + res.status + ')');
            }
            return result;
        })
        .then(result => {
            if (result && result.thanh_cong) {
                if (typeof hienToast === 'function') {
                    hienToast('success', result.thong_bao || 'Xóa CV thành công!');
                }
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                if (typeof hienToast === 'function') {
                    hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
                }
            }
        })
        .catch(err => {
            console.error('[CvDelete] Error:', err);
            if (typeof hienToast === 'function') {
                hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
            } else {
                alert(err.message || 'Lỗi kết nối! Vui lòng thử lại.');
            }
        });
    }

    // Lọc & tìm kiếm CV
    function locDanhSachCv() {
        const searchInput = document.getElementById('main-search-input');
        const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';

        const filterTemplate = document.getElementById('filter-template') ? document.getElementById('filter-template').value : '';
        const filterKieu = document.getElementById('filter-kieu') ? document.getElementById('filter-kieu').value : '';
        const filterTrangThai = document.getElementById('filter-trang-thai') ? document.getElementById('filter-trang-thai').value : '';

        const cvCards = document.querySelectorAll('.cv-card');
        let visibleCount = 0;

        cvCards.forEach(card => {
            // 1. Lọc theo từ khóa tìm kiếm
            let matchesKeyword = true;
            if (keyword) {
                const title = card.querySelector('.cv-card-title') ? card.querySelector('.cv-card-title').textContent.toLowerCase() : '';
                const desc = card.querySelector('.cv-card-desc') ? card.querySelector('.cv-card-desc').textContent.toLowerCase() : '';
                const templateText = card.querySelector('.cv-card-details') ? card.querySelector('.cv-card-details').textContent.toLowerCase() : '';
                matchesKeyword = title.includes(keyword) || desc.includes(keyword) || templateText.includes(keyword);
            }

            // 2. Lọc theo mẫu template
            let matchesTemplate = true;
            if (filterTemplate) {
                const cardTemplate = card.getAttribute('data-template');
                matchesTemplate = (cardTemplate === filterTemplate);
            }

            // 3. Lọc theo hình thức (Tự thiết kế / Sinh tự động)
            let matchesKieu = true;
            if (filterKieu) {
                const cardKieu = card.getAttribute('data-kieu');
                matchesKieu = (cardKieu === filterKieu);
            }

            // 4. Lọc theo trạng thái (CV chính thức / Bản nháp)
            let matchesTrangThai = true;
            if (filterTrangThai) {
                const cardTrangThai = card.getAttribute('data-trang-thai');
                matchesTrangThai = (cardTrangThai === filterTrangThai);
            }

            // Cập nhật hiển thị
            if (matchesKeyword && matchesTemplate && matchesKieu && matchesTrangThai) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Cập nhật giao diện khi không tìm thấy kết quả
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            if (visibleCount === 0 && cvCards.length > 0) {
                noResults.style.display = '';
            } else {
                noResults.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('main-search-input');
        const filterTemplate = document.getElementById('filter-template');
        const filterKieu = document.getElementById('filter-kieu');
        const filterTrangThai = document.getElementById('filter-trang-thai');
        const btnResetFilters = document.getElementById('btn-reset-filters');

        if (searchInput) searchInput.addEventListener('input', locDanhSachCv);
        if (filterTemplate) filterTemplate.addEventListener('change', locDanhSachCv);
        if (filterKieu) filterKieu.addEventListener('change', locDanhSachCv);
        if (filterTrangThai) filterTrangThai.addEventListener('change', locDanhSachCv);

        // Kích hoạt cập nhật preview hình ảnh cho mẫu và kiểu đang được checked ban đầu
        const checkedKieuRadio = document.querySelector('input[name="kieu_cv"]:checked');
        if (checkedKieuRadio) {
            handleKieuCvChange(checkedKieuRadio.value);
        } else {
            const checkedRadio = document.querySelector('#template-select-group input[type="radio"]:checked');
            if (checkedRadio) {
                if (typeof checkedRadio.onchange === 'function') {
                    checkedRadio.onchange();
                } else {
                    checkedRadio.dispatchEvent(new Event('change'));
                }
            }
        }

        if (btnResetFilters) {
            btnResetFilters.addEventListener('click', function () {
                if (filterTemplate) filterTemplate.value = '';
                if (filterKieu) filterKieu.value = '';
                if (filterTrangThai) filterTrangThai.value = '';
                if (searchInput) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                } else {
                    locDanhSachCv();
                }
            });
        }

        // AJAX Form submit: Tạo CV mới
        const formThemCv = document.getElementById('form-them-cv');
        if (formThemCv) {
            formThemCv.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const nameInput = this.querySelector('input[name="ten_cv"]');
                const descInput = this.querySelector('textarea[name="mo_ta_ngan"]');
                const name = nameInput ? nameInput.value.trim() : '';
                const desc = descInput ? descInput.value.trim() : '';

                if (name.length < 2 || name.length > 30) {
                    if (typeof hienToast === 'function') {
                        hienToast('error', 'Tên gọi CV phải từ 2 đến 30 ký tự.');
                    } else {
                        alert('Tên gọi CV phải từ 2 đến 30 ký tự.');
                    }
                    if (nameInput) nameInput.focus();
                    return;
                }

                // Regex JS hỗ trợ unicode property để kiểm tra chữ cái tiếng Việt, số, khoảng trắng, gạch ngang, gạch dưới
                const unicodeRegex = /^[\p{L}0-9\s\-_]+$/u;
                if (!unicodeRegex.test(name)) {
                    if (typeof hienToast === 'function') {
                        hienToast('error', 'Tên gọi CV không được chứa ký tự đặc biệt.');
                    } else {
                        alert('Tên gọi CV không được chứa ký tự đặc biệt.');
                    }
                    if (nameInput) nameInput.focus();
                    return;
                }

                if (desc.length > 200) {
                    if (typeof hienToast === 'function') {
                        hienToast('error', 'Mô tả ngắn tối đa 200 ký tự.');
                    } else {
                        alert('Mô tả ngắn tối đa 200 ký tự.');
                    }
                    if (descInput) descInput.focus();
                    return;
                }

                const btnSubmit = this.querySelector('button[type="submit"]');
                if (typeof datTrangThaiLoading === 'function') {
                    datTrangThaiLoading(btnSubmit, true);
                }

                const url = this.action;
                const token = typeof layToken === 'function' ? layToken() : '';
                const formData = new FormData(this);

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    const isJson = res.headers.get('content-type')?.includes('application/json');
                    const result = isJson ? await res.json() : null;
                    if (!res.ok) {
                        if (res.status === 422 && result && result.errors) {
                            const errorMsg = Object.values(result.errors).flat().join(', ');
                            throw new Error(errorMsg);
                        }
                        if (result && result.thong_bao) {
                            throw new Error(result.thong_bao);
                        }
                        throw new Error('Lỗi máy chủ (' + res.status + ')');
                    }
                    return result;
                })
                .then(result => {
                    if (result && result.thanh_cong) {
                        if (typeof hienToast === 'function') {
                            hienToast('success', result.thong_bao || 'Tạo CV thành công!');
                        }
                        dongModal('modal-them-cv');
                        setTimeout(() => {
                            if (result.redirect_url) {
                                window.location.href = result.redirect_url;
                            } else {
                                window.location.reload();
                            }
                        }, 800);
                    } else {
                        if (typeof hienToast === 'function') {
                            hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
                        }
                        if (typeof datTrangThaiLoading === 'function') {
                            datTrangThaiLoading(btnSubmit, false);
                        }
                    }
                })
                .catch(err => {
                    console.error('[CvCreate] Error:', err);
                    if (typeof hienToast === 'function') {
                        hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
                    } else {
                        alert(err.message || 'Lỗi kết nối! Vui lòng thử lại.');
                    }
                    if (typeof datTrangThaiLoading === 'function') {
                        datTrangThaiLoading(btnSubmit, false);
                    }
                });
            });
        }

        // Removed form-xoa-cv AJAX submit

        // Submit form tạo CV bằng AI
        const formThemCvAi = document.getElementById('form-them-cv-ai');
        if (formThemCvAi) {
            formThemCvAi.addEventListener('submit', function(e) {
                e.preventDefault();
                const btnSubmit = this.querySelector('button[type="submit"]');
                const originalText = btnSubmit.innerHTML;
                
                if (typeof datTrangThaiLoading === 'function') {
                    datTrangThaiLoading(btnSubmit, true, 'Đang tạo...');
                } else {
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = 'Đang xử lý AI...';
                }

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        if (res.status === 422) {
                            return res.json().then(err => {
                                const msg = Object.values(err.errors).flat().join('\n');
                                throw new Error(msg);
                            });
                        }
                        return res.json().then(err => {
                            throw new Error(err.thong_bao || 'Lỗi hệ thống');
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.thanh_cong) {
                        if (typeof hienToast === 'function') hienToast('success', data.thong_bao);
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        throw new Error(data.thong_bao || 'Thất bại');
                    }
                })
                .catch(err => {
                    if (typeof hienToast === 'function') hienToast('error', err.message);
                    else alert(err.message);
                    
                    if (typeof datTrangThaiLoading === 'function') {
                        datTrangThaiLoading(btnSubmit, false);
                    } else {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = originalText;
                    }
                });
            });
        }
    });
</script>

    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

