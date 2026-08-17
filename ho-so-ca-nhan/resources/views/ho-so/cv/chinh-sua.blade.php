<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chỉnh sửa thiết kế CV - {{ $cv->ten_cv }}</title>
    <meta name="description" content="Tùy chỉnh bố cục, sắp xếp thứ tự và màu sắc CV.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/cv/cv-style.css') }}?v={{ time() }}">
</head>
<body class="cv-editor-body">

{{-- Header --}}
<header class="editor-header">
    <div class="editor-header-left">
        <a href="{{ route('ho-so.cv.index') }}" class="btn-back-editor" title="Trở về danh sách CV">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Quản lý CV</span>
                        @if(isset($sidebarCvCount) && $sidebarCvCount > 0)
                            <span class="badge-count">{{ $sidebarCvCount }}</span>
                        @endif
                    </a>
        <div class="editor-title-container">
            <h1 class="editor-cv-title" id="display-cv-title">{{ $cv->ten_cv }}</h1>
            <span class="editor-cv-type-tag {{ $tuyChinh['kieu_cv'] ?? 'thu_cong' }}">
                {{ ($tuyChinh['kieu_cv'] ?? 'thu_cong') === 'thu_cong' ? 'Tự thiết kế' : 'Sinh tự động' }}
            </span>
        </div>
    </div>
    
    <div class="editor-header-right">
        <button type="button" class="btn-editor-action discard" id="btn-discard-cv" onclick="discardCvChanges()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18"/></svg>
            <span>Hủy thay đổi</span>
        </button>
        <button type="button" class="btn-editor-action save" id="btn-save-cv" onclick="saveCvSettings(true)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            <span>Lưu & Tải lại trang</span>
        </button>
        <a href="xem-truoc" class="btn-editor-action print" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Xem & Tải PDF</span>
        </a>
    </div>
</header>

<div class="editor-layout">
    {{-- Left Panel: Tool Customizer --}}
    <aside class="editor-sidebar-left">
        <form id="cv-customizer-form" enctype="multipart/form-data" onsubmit="event.preventDefault();">
            @php
                $isTuDong = ($tuyChinh['kieu_cv'] ?? 'thu_cong') === 'tu_dong';
            @endphp
            
            {{-- Mục 1: Thông tin cơ bản CV --}}
            <div class="sidebar-section-card">
                <div class="section-card-title">1. Thông tin CV</div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label required">Tên gọi CV</label>
                    <input type="text" name="ten_cv" value="{{ $cv->ten_cv }}" class="form-control-input" required minlength="2" maxlength="30" oninput="updateCvTitleDisplay(this.value)">
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px;">* Từ 2 đến 30 ký tự, không chứa ký tự đặc biệt.</span>
                </div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label">Mô tả ngắn</label>
                    <input type="text" name="mo_ta_ngan" value="{{ $tuyChinh['mo_ta_ngan'] ?? '' }}" class="form-control-input" maxlength="200" placeholder="Mục đích dùng CV...">
                    <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px;">* Tối đa 200 ký tự.</span>
                </div>
                @if($isTuDong)
                    <div style="font-size: 11.5px; color: #b45309; margin-top: 4px; display: flex; gap: 6px; align-items: flex-start; line-height: 1.4;">
                        <span>⚡</span>
                        <span>CV tự động đồng bộ từ các thông tin nổi bật (★) trong hồ sơ cá nhân. Bạn vẫn có thể tùy biến bố cục & giao diện bên dưới.</span>
                    </div>
                @endif
            </div>

            {{-- Mục 2: Chọn Template & Màu sắc --}}
            <div class="sidebar-section-card">
                <div class="section-card-title">2. Giao diện & Màu sắc</div>
                
                {{-- Chọn Template --}}
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label required">Chọn Mẫu CV (Template)</label>
                    <select name="ma_template" class="form-control-input" onchange="markUnsavedChanges()">
                        @foreach($templates as $tpl)
                            <option value="{{ $tpl->ma_mau_cv }}" {{ $cv->ma_template === $tpl->ma_mau_cv ? 'selected' : '' }}>
                                {{ $tpl->ten_mau }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Chọn Màu sắc chủ đạo --}}
                <div class="form-group">
                    <label class="form-label required">Màu sắc chủ đạo</label>
                    <div class="color-palette-container">
                        @php
                            $selectedColor = $tuyChinh['mau_chu_dao'] ?? '#1e3a8a';
                            $presetColors = ['#1e3a8a', '#2563eb', '#0d9488', '#059669', '#b91c1c', '#7c3aed', '#1f2937'];
                        @endphp
                        <div class="color-presets">
                            @foreach($presetColors as $color)
                                <button type="button" class="color-preset-btn {{ $selectedColor === $color ? 'active' : '' }}" 
                                        style="background-color: {{ $color }};" 
                                        onclick="selectPresetColor('{{ $color }}')"
                                        title="{{ $color }}"></button>
                            @endforeach
                        </div>
                        <div class="custom-color-picker-wrapper" style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                            <input type="color" id="custom-color-picker" value="{{ $selectedColor }}" onchange="selectPresetColor(this.value)">
                            <span style="font-size: 12px; color: #475569;">Tự chọn màu khác</span>
                        </div>
                        <input type="hidden" name="mau_chu_dao" id="hidden-mau-chu-dao" value="{{ $selectedColor }}">
                    </div>
                </div>
            </div>

            {{-- Mục 3: Ảnh đại diện riêng cho CV --}}
            <div class="sidebar-section-card">
                <div class="section-card-title">3. Ảnh đại diện CV</div>
                <div style="display: flex; gap: 16px; align-items: center;">
                    <div class="cv-editor-avatar-preview">
                        <img id="cv-avatar-preview-img" src="{{ $tuyChinh['anh_dai_dien'] ? asset($tuyChinh['anh_dai_dien']) : ($nguoiDung->anh_dai_dien ? asset($nguoiDung->anh_dai_dien) : asset('uploads/avatar/default.png')) }}" alt="Avatar">
                    </div>
                    <div style="flex: 1;">
                        <input type="file" name="anh_dai_dien_file" id="cv-avatar-input" style="display: none;" accept="image/*" onchange="previewCvAvatar(this)">
                        <button type="button" class="btn-cancel" style="margin: 0; padding: 6px 12px; font-size: 12.5px;" onclick="document.getElementById('cv-avatar-input').click()">
                            Chọn ảnh khác
                        </button>
                        <p style="font-size: 11px; color: #475569; margin-top: 6px;">Hỗ trợ định dạng JPG, PNG, WEBP tối đa 2MB.</p>
                    </div>
                </div>
            </div>

            {{-- Mục 4: Bật/Tắt các phần hiển thị --}}
            <div class="sidebar-section-card">
                <div class="section-card-title">4. Hiển thị các phần</div>
                <div class="section-toggles-list">
                    @php
                        $sections = [
                            'hoc_van' => 'Học vấn & Bằng cấp',
                            'kinh_nghiem' => 'Kinh nghiệm làm việc',
                            'du_an' => 'Dự án / Portfolio',
                            'chung_chi' => 'Chứng chỉ & Khóa học',
                            'thanh_tuu' => 'Thành tựu & Giải thưởng',
                            'ky_nang' => 'Kỹ năng chuyên môn',
                            'lien_ket' => 'Mạng xã hội & Liên kết',
                            'so_thich' => 'Sở thích cá nhân'
                        ];
                        $hienThi = $tuyChinh['hien_thi_cac_muc'] ?? [];
                    @endphp
                    @foreach($sections as $key => $label)
                        @php
                            $isEnabled = isset($hienThi[$key]) ? filter_var($hienThi[$key], FILTER_VALIDATE_BOOLEAN) : true;
                        @endphp
                        <label class="toggle-item-row">
                            <input type="checkbox" name="hien_thi_cac_muc[{{ $key }}]" value="true" {{ $isEnabled ? 'checked' : '' }} onchange="markUnsavedChanges()">
                            <span class="toggle-custom-slider"></span>
                            <span class="toggle-item-label">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Mục 5: Sắp xếp thứ tự các phần --}}
            <div class="sidebar-section-card">
                <div class="section-card-title">5. Sắp xếp thứ tự</div>
                <p style="font-size: 12px; color: #475569; margin-top: -8px; margin-bottom: 12px;">Nhấn nút Lên/Xuống để thay đổi thứ tự các phần trong CV.</p>
                
                <div class="section-sort-list" id="section-sortable-container">
                    @php
                        $orderList = $tuyChinh['thu_tu_cac_muc'] ?? ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu', 'ky_nang', 'lien_ket', 'so_thich'];
                    @endphp
                    @foreach($orderList as $secKey)
                        @if(isset($sections[$secKey]))
                            <div class="sort-item-card" data-key="{{ $secKey }}">
                                <span class="sort-item-drag-icon">☰</span>
                                <span class="sort-item-text">{{ $sections[$secKey] }}</span>
                                <div class="sort-action-arrows">
                                    <button type="button" class="arrow-btn up" onclick="moveSectionUp(this)" title="Di chuyển lên">▲</button>
                                    <button type="button" class="arrow-btn down" onclick="moveSectionDown(this)" title="Di chuyển xuống">▼</button>
                                </div>
                                <input type="hidden" name="thu_tu_cac_muc[]" value="{{ $secKey }}">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            @if(!$isTuDong)
            {{-- Mục 6: Chi tiết nội dung các phần (Chỉ hiển thị với CV Thủ công) --}}
            <div class="sidebar-section-card" id="detail-items-section">
                <div class="section-card-title">6. Nội dung chi tiết các phần</div>
                <p style="font-size: 11.5px; color: #475569; margin-top: -8px; margin-bottom: 12px;">Bật/tắt các bản ghi cụ thể và kéo thả để sắp xếp thứ tự hiển thị của chúng.</p>
                
                <div class="detail-items-accordion">
                    {{-- Accordion Chứng chỉ --}}
                    @if(isset($profileData['chungChi']) && count($profileData['chungChi']) > 0)
                    <div class="accordion-item" data-section="chung_chi">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Chứng chỉ & Khóa học</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="chung_chi">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['chung_chi'] ?? null;
                                    $items = $profileData['chungChi'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->ten_chung_chi }}</div>
                                            <div class="custom-item-subtitle">{{ $item->to_chuc_cap }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[chung_chi][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Dự án --}}
                    @if(isset($profileData['duAn']) && count($profileData['duAn']) > 0)
                    <div class="accordion-item" data-section="du_an">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Dự án / Portfolio</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="du_an">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['du_an'] ?? null;
                                    $items = $profileData['duAn'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->ten_du_an }}</div>
                                            <div class="custom-item-subtitle">{{ $item->vai_tro ?: 'Thành viên' }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[du_an][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Học vấn --}}
                    @if(isset($profileData['hocVan']) && count($profileData['hocVan']) > 0)
                    <div class="accordion-item" data-section="hoc_van">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Học vấn & Bằng cấp</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="hoc_van">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['hoc_van'] ?? null;
                                    $items = $profileData['hocVan'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->tieu_de }}</div>
                                            <div class="custom-item-subtitle">{{ $item->ten_truong }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[hoc_van][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Kinh nghiệm --}}
                    @if(isset($profileData['kinhNghiem']) && count($profileData['kinhNghiem']) > 0)
                    <div class="accordion-item" data-section="kinh_nghiem">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Kinh nghiệm làm việc</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="kinh_nghiem">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['kinh_nghiem'] ?? null;
                                    $items = $profileData['kinhNghiem'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->vi_tri_cong_viec }}</div>
                                            <div class="custom-item-subtitle">{{ $item->ten_cong_ty }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[kinh_nghiem][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Kỹ năng --}}
                    @if((isset($profileData['ngonNgu']) && count($profileData['ngonNgu']) > 0) || (isset($profileData['kyNang']) && count($profileData['kyNang']) > 0))
                    <div class="accordion-item" data-section="ky_nang">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Kỹ năng chuyên môn</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="ky_nang_total" style="max-height: 350px;">
                                {{-- Phần ngôn ngữ lập trình --}}
                                @if(isset($profileData['ngonNgu']) && count($profileData['ngonNgu']) > 0)
                                    <div class="custom-items-subtitle-header">Công nghệ & Ngôn ngữ</div>
                                    <div class="custom-items-list-inner" data-category="ngon_ngu">
                                        @php
                                            $savedLangs = $tuyChinh['lua_chon_items']['ngon_ngu'] ?? null;
                                            $langs = $profileData['ngonNgu'];
                                            if (is_array($savedLangs)) {
                                                usort($langs, function($a, $b) use ($savedLangs) {
                                                    $idxA = array_search($a, $savedLangs);
                                                    $idxB = array_search($b, $savedLangs);
                                                    $valA = $idxA !== false ? $idxA : 999999;
                                                    $valB = $idxB !== false ? $idxB : 999999;
                                                    return $valA <=> $valB;
                                                });
                                            }
                                        @endphp
                                        @foreach($langs as $lang)
                                            @php
                                                $isChecked = is_array($savedLangs) ? in_array($lang, $savedLangs) : false;
                                            @endphp
                                            <div class="custom-item-card" data-val="{{ $lang }}" style="margin-bottom: 6px;">
                                                <span class="drag-handle">☰</span>
                                                <label class="custom-item-checkbox-wrapper">
                                                    <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                                    <span class="custom-checkbox-ui"></span>
                                                </label>
                                                <div class="custom-item-info">
                                                    <div class="custom-item-title">{{ $lang }}</div>
                                                </div>
                                                <input type="hidden" name="lua_chon_items[ngon_ngu][]" value="{{ $lang }}" {{ $isChecked ? '' : 'disabled' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Phần kỹ năng mềm --}}
                                @if(isset($profileData['kyNang']) && count($profileData['kyNang']) > 0)
                                    <div class="custom-items-subtitle-header" style="margin-top: 14px;">Kỹ năng mềm</div>
                                    <div class="custom-items-list-inner" data-category="ky_nang">
                                        @php
                                            $savedSkills = $tuyChinh['lua_chon_items']['ky_nang'] ?? null;
                                            $skills = $profileData['kyNang'];
                                            if (is_array($savedSkills)) {
                                                usort($skills, function($a, $b) use ($savedSkills) {
                                                    $idxA = array_search($a, $savedSkills);
                                                    $idxB = array_search($b, $savedSkills);
                                                    $valA = $idxA !== false ? $idxA : 999999;
                                                    $valB = $idxB !== false ? $idxB : 999999;
                                                    return $valA <=> $valB;
                                                });
                                            }
                                        @endphp
                                        @foreach($skills as $skill)
                                            @php
                                                $isChecked = is_array($savedSkills) ? in_array($skill, $savedSkills) : false;
                                            @endphp
                                            <div class="custom-item-card" data-val="{{ $skill }}" style="margin-bottom: 6px;">
                                                <span class="drag-handle">☰</span>
                                                <label class="custom-item-checkbox-wrapper">
                                                    <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                                    <span class="custom-checkbox-ui"></span>
                                                </label>
                                                <div class="custom-item-info">
                                                    <div class="custom-item-title">{{ $skill }}</div>
                                                </div>
                                                <input type="hidden" name="lua_chon_items[ky_nang][]" value="{{ $skill }}" {{ $isChecked ? '' : 'disabled' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Liên kết --}}
                    @if(isset($profileData['lienKetMxh']) && count($profileData['lienKetMxh']) > 0)
                    <div class="accordion-item" data-section="lien_ket">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Mạng xã hội & Liên kết</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="lien_ket">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['lien_ket'] ?? null;
                                    $items = $profileData['lienKetMxh'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->ten_nen_tang }}</div>
                                            <div class="custom-item-subtitle">{{ $item->duong_dan }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[lien_ket][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Accordion Thành tựu --}}
                    @if(isset($profileData['thanhTuu']) && count($profileData['thanhTuu']) > 0)
                    <div class="accordion-item" data-section="thanh_tuu">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span>Thành tựu & Giải thưởng</span>
                            <span class="accordion-arrow">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="custom-items-list" data-category="thanh_tuu">
                                @php
                                    $savedIds = $tuyChinh['lua_chon_items']['thanh_tuu'] ?? null;
                                    $items = $profileData['thanhTuu'];
                                    if (is_array($savedIds)) {
                                        $items = collect($items)->sortBy(function($item) use ($savedIds) {
                                            $idx = array_search((int)$item->id, $savedIds);
                                            return $idx !== false ? $idx : 999999;
                                        });
                                    }
                                @endphp
                                @foreach($items as $item)
                                    @php
                                        $isChecked = is_array($savedIds) ? in_array((int)$item->id, $savedIds) : false;
                                    @endphp
                                    <div class="custom-item-card" data-id="{{ $item->id }}">
                                        <span class="drag-handle">☰</span>
                                        <label class="custom-item-checkbox-wrapper">
                                            <input type="checkbox" class="item-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="toggleItemCheckbox(this)">
                                            <span class="custom-checkbox-ui"></span>
                                        </label>
                                        <div class="custom-item-info">
                                            <div class="custom-item-title">{{ $item->ten_thanh_tuu }}</div>
                                            <div class="custom-item-subtitle">{{ $item->to_chuc_cap ?: 'Đã đạt được' }}</div>
                                        </div>
                                        <input type="hidden" name="lua_chon_items[thanh_tuu][]" value="{{ $item->id }}" {{ $isChecked ? '' : 'disabled' }}>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Thẻ giữ chữ tự động chỉnh sửa --}}
            <input type="hidden" name="noi_dung_chinh_sua" id="hidden-noi-dung-chinh-sua" value="{{ json_encode($tuyChinh['noi_dung_chinh_sua'] ?? (object)[]) }}">

        </form>
    </aside>

    {{-- Right Panel: Live CV Preview Screen --}}
    <main class="editor-main-preview">
        
        {{-- Preview Controls Toolbar --}}
        <div class="preview-toolbar">
            <div class="preview-mode-selectors">
                <button type="button" class="btn-toolbar-mode active" id="mode-a4-btn" onclick="switchPreviewMode('a4')">
                    📄 Khổ giấy A4
                </button>
                <button type="button" class="btn-toolbar-mode" id="mode-mobile-btn" onclick="switchPreviewMode('mobile')">
                    📱 Điện thoại
                </button>
            </div>

            <div class="preview-zoom-control" id="zoom-control-wrapper">
                <span class="zoom-label">Thu phóng:</span>
                <input type="range" id="preview-zoom-slider" min="50" max="130" value="80" oninput="adjustPreviewZoom(this.value)">
                <span class="zoom-value" id="preview-zoom-val-text">80%</span>
            </div>
            
            <div class="preview-status-indicator">
                <span class="status-dot-green"></span>
                <span id="save-status-text">Đã lưu</span>
            </div>
        </div>

        {{-- Screen Workspace --}}
        <div class="preview-workspace" id="preview-workspace-area">
            
            {{-- A4 Page Container --}}
            <div class="a4-preview-scroll-container" id="a4-preview-wrapper">
                <div class="a4-preview-page" id="a4-page-frame" style="transform: scale(0.8);">
                    <iframe id="cv-preview-iframe" src="xem-truoc"></iframe>
                </div>
            </div>

            {{-- Mobile Container (Hidden by default) --}}
            <div class="mobile-preview-container" id="mobile-preview-wrapper" style="display: none;">
                <div class="mobile-device-frame">
                    <div class="mobile-device-screen">
                        <iframe id="cv-preview-iframe-mobile" src="xem-truoc"></iframe>
                    </div>
                </div>
            </div>

        </div>

    </main>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- Script logic for Customizer --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script>
    let hasUnsavedChanges = false;

    // Cảnh báo khi rời khỏi trang có thay đổi chưa lưu
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = 'Bạn có thay đổi chưa lưu. Bạn có chắc chắn muốn rời khỏi trang?';
            return e.returnValue;
        }
    });

    // Hủy thay đổi và tải lại trang (không lưu)
    function discardCvChanges() {
        if (hasUnsavedChanges) {
            if (confirm('Bạn có chắc chắn muốn tải lại trang và hủy bỏ tất cả các thay đổi chưa lưu?')) {
                // Tắt cảnh báo beforeunload trước khi reload thủ công để tránh bị lặp confirm
                hasUnsavedChanges = false;
                window.location.reload();
            }
        } else {
            window.location.reload();
        }
    }

    // Đánh dấu trạng thái có thay đổi chưa lưu
    function markUnsavedChanges() {
        hasUnsavedChanges = true;
        
        // Đổi màu dấu chấm trạng thái thành đỏ
        const dot = document.querySelector('.preview-status-indicator span:first-child');
        if (dot) {
            dot.style.backgroundColor = '#ef4444';
            dot.style.boxShadow = '0 0 8px #ef4444';
        }
        
        // Đổi text trạng thái thành màu đỏ và hiển thị chưa lưu
        const statusText = document.getElementById('save-status-text');
        if (statusText) {
            statusText.innerText = 'Có thay đổi chưa lưu';
            statusText.style.color = '#ef4444';
        }
    }

    // Đánh dấu trạng thái đã lưu
    function markSaved() {
        hasUnsavedChanges = false;
        
        // Đổi màu dấu chấm trạng thái thành xanh
        const dot = document.querySelector('.preview-status-indicator span:first-child');
        if (dot) {
            dot.style.backgroundColor = '';
            dot.style.boxShadow = '';
        }
        
        // Trả text về mặc định
        const statusText = document.getElementById('save-status-text');
        if (statusText) {
            statusText.innerText = 'Đã lưu';
            statusText.style.color = '';
        }
    }

    // Cập nhật tên CV hiển thị ở Header
    function updateCvTitleDisplay(val) {
        document.getElementById('display-cv-title').innerText = val || 'Chưa đặt tên CV';
        markUnsavedChanges();
    }

    // Chọn màu sắc preset
    function selectPresetColor(color) {
        document.getElementById('hidden-mau-chu-dao').value = color;
        document.getElementById('custom-color-picker').value = color;
        
        // Remove active class from presets and add to the matching one
        document.querySelectorAll('.color-preset-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.style.backgroundColor === color || rgbToHex(btn.style.backgroundColor) === color.toLowerCase()) {
                btn.classList.add('active');
            }
        });

        markUnsavedChanges();
    }

    function rgbToHex(rgb) {
        if (/^rgb\(/.test(rgb)) {
            let parts = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            delete (parts[0]);
            for (let i = 1; i <= 3; ++i) {
                parts[i] = parseInt(parts[i], 10).toString(16);
                if (parts[i].length == 1) parts[i] = '0' + parts[i];
            }
            return '#' + parts.join('');
        }
        return rgb;
    }

    // Xem trước ảnh đại diện CV khi upload
    function previewCvAvatar(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cv-avatar-preview-img').src = e.target.result;
                markUnsavedChanges();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Di chuyển các mục lên/xuống bằng nút bấm
    function moveSectionUp(btn) {
        const item = btn.closest('.sort-item-card');
        const prev = item.previousElementSibling;
        if (prev) {
            item.parentNode.insertBefore(item, prev);
            markUnsavedChanges();
        }
    }

    function moveSectionDown(btn) {
        const item = btn.closest('.sort-item-card');
        const next = item.nextElementSibling;
        if (next) {
            item.parentNode.insertBefore(next, item);
            markUnsavedChanges();
        }
    }

    // Toggle accordion chi tiết nội dung
    function toggleAccordion(header) {
        const item = header.closest('.accordion-item');
        const isActive = item.classList.contains('active');
        
        // Đóng các accordion khác
        document.querySelectorAll('.accordion-item').forEach(acc => {
            acc.classList.remove('active');
        });
        
        if (!isActive) {
            item.classList.add('active');
        }
    }

    // Bật/tắt checkbox của bản ghi hồ sơ
    function toggleItemCheckbox(checkbox) {
        const card = checkbox.closest('.custom-item-card');
        const hiddenInput = card.querySelector('input[type="hidden"]');
        if (checkbox.checked) {
            hiddenInput.removeAttribute('disabled');
        } else {
            hiddenInput.setAttribute('disabled', 'disabled');
        }
        markUnsavedChanges();
    }

    // AJAX Lưu cấu hình CV (Thủ công)
    function saveCvSettings(showToast = false) {
        const statusText = document.getElementById('save-status-text');
        
        // Xác thực phía máy khách trước khi lưu
        const nameInput = document.querySelector('input[name="ten_cv"]');
        const descInput = document.querySelector('input[name="mo_ta_ngan"]');
        const name = nameInput ? nameInput.value.trim() : '';
        const desc = descInput ? descInput.value.trim() : '';

        if (name.length < 2 || name.length > 30) {
            if (statusText) statusText.innerText = 'Lỗi nhập liệu';
            hienToast('error', 'Tên gọi CV phải từ 2 đến 30 ký tự.');
            if (nameInput) nameInput.focus();
            return;
        }

        const unicodeRegex = /^[\p{L}0-9\s\-_]+$/u;
        if (!unicodeRegex.test(name)) {
            if (statusText) statusText.innerText = 'Lỗi nhập liệu';
            hienToast('error', 'Tên gọi CV không được chứa ký tự đặc biệt.');
            if (nameInput) nameInput.focus();
            return;
        }

        if (desc.length > 200) {
            if (statusText) statusText.innerText = 'Lỗi nhập liệu';
            hienToast('error', 'Mô tả ngắn tối đa 200 ký tự.');
            if (descInput) descInput.focus();
            return;
        }

        if (statusText) statusText.innerText = 'Đang lưu thiết kế...';
        
        // Buộc iframe blur phần tử đang sửa (nếu có) trước khi lưu.
        // Sử dụng postMessage để tránh lỗi CORS khi deploy lên hosting/cPanel.
        const iframe = document.getElementById('cv-preview-iframe');
        if (iframe && iframe.contentWindow) {
            // Thử trực tiếp trước (sẽ hoạt động khi cùng origin, ví dụ localhost)
            try {
                if (iframe.contentWindow.document.activeElement) {
                    iframe.contentWindow.document.activeElement.blur();
                }
            } catch (e) {
                // Bị chặn bởi CORS trên hosting → fallback sang postMessage
                iframe.contentWindow.postMessage({ type: 'cv-blur-active' }, '*');
            }
        }

        // Delay 200ms để sự kiện blur/postMessage kịp cập nhật vào hidden input trước khi gửi form
        setTimeout(() => {
            let form = document.getElementById('cv-customizer-form');
            let formData = new FormData(form);

            // Serialize hien_thi_cac_muc
            form.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (!cb.checked) {
                    let name = cb.getAttribute('name');
                    formData.append(name, 'false');
                }
            });

            let token = layToken();
            let routeUpdate = "cap-nhat";

            fetch(routeUpdate, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.thanh_cong) {
                    markSaved();
                    // Tắt cảnh báo beforeunload trước khi reload trang
                    hasUnsavedChanges = false;
                    
                    if (showToast) {
                        hienToast('success', 'Thiết kế CV đã được lưu thành công! Đang tải lại trang...');
                        // Tải lại trang sau 600ms để người dùng kịp nhìn thấy thông báo Toast thành công
                        setTimeout(() => {
                            window.location.reload();
                        }, 600);
                    } else {
                        window.location.reload();
                    }
                } else {
                    if (statusText) statusText.innerText = 'Lỗi lưu dữ liệu';
                    if (showToast) {
                        hienToast('error', data.thong_bao || 'Có lỗi xảy ra khi lưu.');
                    }
                }
            })
            .catch(err => {
                console.error(err);
                if (statusText) statusText.innerText = 'Lỗi kết nối';
                if (showToast) {
                    hienToast('error', 'Lỗi kết nối mạng.');
                }
            });
        }, 200);
    }

    // Làm mới preview iframes
    function reloadPreviewIframes() {
        const iframeA4 = document.getElementById('cv-preview-iframe');
        const iframeMobile = document.getElementById('cv-preview-iframe-mobile');
        
        if (iframeA4) iframeA4.src = iframeA4.src;
        if (iframeMobile) iframeMobile.src = iframeMobile.src;
    }

    // Đồng bộ hóa chiều cao iframe thông qua postMessage (an toàn với CORS)
    // Chiều cao thực sự được báo cáo từ iframe qua sự kiện 'message'
    function syncIframeHeight(height) {
        const iframe = document.getElementById('cv-preview-iframe');
        const pageFrame = document.getElementById('a4-page-frame');
        if (iframe && pageFrame && height) {
            iframe.style.height = height + 'px';
            pageFrame.style.height = height + 'px';
        }
    }

    // Khởi tạo kéo thả sắp xếp thứ tự HTML5
    function initDragAndDropSort() {
        // 1. Sắp xếp thứ tự các phần (sections)
        const container = document.getElementById('section-sortable-container');
        if (container) {
            const items = container.querySelectorAll('.sort-item-card');
            items.forEach(item => {
                item.setAttribute('draggable', 'true');
                
                item.addEventListener('dragstart', (e) => {
                    item.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });

                item.addEventListener('dragend', () => {
                    item.classList.remove('dragging');
                    markUnsavedChanges();
                });
            });

            container.addEventListener('dragover', (e) => {
                e.preventDefault();
                const draggingItem = container.querySelector('.dragging');
                if (!draggingItem) return;

                const siblings = [...container.querySelectorAll('.sort-item-card:not(.dragging)')];
                const nextSibling = siblings.find(sibling => {
                    const rect = sibling.getBoundingClientRect();
                    return e.clientY <= rect.top + rect.height / 2;
                });

                if (nextSibling) {
                    container.insertBefore(draggingItem, nextSibling);
                } else {
                    container.appendChild(draggingItem);
                }
            });
        }

        // 2. Sắp xếp thứ tự các bản ghi chi tiết (items)
        const subListContainers = document.querySelectorAll('.custom-items-list, .custom-items-list-inner');
        subListContainers.forEach(listContainer => {
            const cards = listContainer.querySelectorAll(':scope > .custom-item-card');
            cards.forEach(card => {
                card.setAttribute('draggable', 'true');
                
                card.addEventListener('dragstart', (e) => {
                    card.classList.add('item-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });

                card.addEventListener('dragend', () => {
                    card.classList.remove('item-dragging');
                    markUnsavedChanges();
                });
            });

            listContainer.addEventListener('dragover', (e) => {
                e.preventDefault();
                const draggingItem = listContainer.querySelector('.item-dragging');
                if (!draggingItem) return;

                const siblings = [...listContainer.querySelectorAll(':scope > .custom-item-card:not(.item-dragging)')];
                const nextSibling = siblings.find(sibling => {
                    const rect = sibling.getBoundingClientRect();
                    return e.clientY <= rect.top + rect.height / 2;
                });

                if (nextSibling) {
                    listContainer.insertBefore(draggingItem, nextSibling);
                } else {
                    listContainer.appendChild(draggingItem);
                }
            });
        });
    }

    // Không còn cần trực tiếp truy cập DOM của iframe (CORS-unsafe).
    // Chiều cao được đồng bộ thông qua postMessage từ iframe.

    // Nhận thông báo từ iframe preview qua postMessage (CORS-safe)
    window.addEventListener('message', function(event) {
        if (!event.data || typeof event.data !== 'object') return;

        // 1. Nhận sửa chữ trực tiếp trong CV
        if (event.data.type === 'cv-text-edited') {
            const input = document.getElementById('hidden-noi-dung-chinh-sua');
            let data = {};
            try {
                const parsed = JSON.parse(input.value);
                // Nếu dữ liệu ban đầu là một Mảng (array), chuyển sang Đối tượng (object)
                if (parsed && typeof parsed === 'object' && !Array.isArray(parsed)) {
                    data = parsed;
                }
            } catch(e) {}
            data[event.data.key] = event.data.value;
            input.value = JSON.stringify(data);
            markUnsavedChanges();
        }

        // 2. Nhận thông báo chiều cao từ iframe để đồng bộ (thay thế syncIframeHeight DOM-direct)
        if (event.data.type === 'cv-iframe-resize' && event.data.height) {
            syncIframeHeight(event.data.height);
        }
    });

    // Chuyển đổi chế độ Xem trước (A4 vs Mobile)
    function switchPreviewMode(mode) {
        document.querySelectorAll('.btn-toolbar-mode').forEach(btn => btn.classList.remove('active'));
        
        const a4Wrapper = document.getElementById('a4-preview-wrapper');
        const mobileWrapper = document.getElementById('mobile-preview-wrapper');
        const zoomWrapper = document.getElementById('zoom-control-wrapper');

        if (mode === 'a4') {
            document.getElementById('mode-a4-btn').classList.add('active');
            a4Wrapper.style.display = 'flex';
            mobileWrapper.style.display = 'none';
            zoomWrapper.style.visibility = 'visible';
            setTimeout(syncIframeHeight, 100);
        } else {
            document.getElementById('mode-mobile-btn').classList.add('active');
            a4Wrapper.style.display = 'none';
            mobileWrapper.style.display = 'flex';
            zoomWrapper.style.visibility = 'hidden';
            
            const iframeMobile = document.getElementById('cv-preview-iframe-mobile');
            if (iframeMobile) iframeMobile.src = iframeMobile.src;
        }
    }

    // Thu phóng khung A4 preview
    function adjustPreviewZoom(val) {
        const scaleVal = parseFloat(val) / 100;
        document.getElementById('a4-page-frame').style.transform = `scale(${scaleVal})`;
        document.getElementById('preview-zoom-val-text').innerText = `${val}%`;
    }

    // Khởi tạo trang
    window.addEventListener('DOMContentLoaded', () => {
        initDragAndDropSort();
    });

    window.addEventListener('load', () => {
        let width = window.innerWidth;
        if (width < 1400) {
            adjustPreviewZoom(60);
            document.getElementById('preview-zoom-slider').value = 60;
        } else {
            adjustPreviewZoom(80);
            document.getElementById('preview-zoom-slider').value = 80;
        }
    });
</script>

</body>
</html>
