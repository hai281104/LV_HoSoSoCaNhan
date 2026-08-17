@php
    $order = $tuyChinh['thu_tu_cac_muc'] ?? ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu', 'ky_nang', 'lien_ket', 'so_thich'];
    $visibility = $tuyChinh['hien_thi_cac_muc'] ?? [];
    $accentColor = $tuyChinh['mau_chu_dao'] ?? '#1e3a8a';
    $avatar = $tuyChinh['anh_dai_dien'] ?? ($profileData['nguoiDung']->anh_dai_dien ?? '');
    $user = $profileData['nguoiDung'];
    $noiDungChinhSua = $tuyChinh['noi_dung_chinh_sua'] ?? [];
    $getVal = function($key, $default) use ($noiDungChinhSua) {
        return array_key_exists($key, $noiDungChinhSua) ? $noiDungChinhSua[$key] : $default;
    };
@endphp

<style>
    :root {
        --primary-color: {{ $accentColor }};
        --text-dark: #1f2937;
        --text-light: #4b5563;
        --border-light: #e5e7eb;
        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cv-document {
        font-family: var(--font-sans);
        color: var(--text-dark);
        line-height: 1.5;
        font-size: 14px;
        background-color: #fff;
        padding: 0;
        margin: 0;
    }

    .cv-header {
        display: flex;
        gap: 24px;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 16px;
        margin-bottom: 24px;
        align-items: center;
    }

    .cv-header-avatar {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--primary-color);
        flex-shrink: 0;
        background-color: #f3f4f6;
    }

    .cv-header-avatar-initials {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        border: 2px solid var(--primary-color);
        background-color: var(--primary-color);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .cv-header-info {
        flex: 1;
    }

    .cv-name {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-light);
        margin: 0 0 12px 0;
    }

    .cv-contact-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px 16px;
        font-size: 12.5px;
        color: var(--text-light);
    }

    .cv-contact-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .cv-contact-item svg {
        width: 14px;
        height: 14px;
        color: var(--primary-color);
        flex-shrink: 0;
    }

    .cv-section {
        margin-bottom: 22px;
    }

    .cv-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-color);
        border-bottom: 1.5px solid var(--primary-color);
        padding-bottom: 4px;
        margin: 0 0 12px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .cv-intro-text {
        font-size: 13.5px;
        color: var(--text-light);
        text-align: justify;
        white-space: pre-line;
        margin: 0;
    }

    .cv-timeline-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .cv-timeline-item {
        page-break-inside: avoid;
    }

    .cv-timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 4px;
    }

    .cv-timeline-header > div:first-child {
        flex: 1;
        min-width: 0;
        padding-right: 16px;
    }

    .cv-timeline-title {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
        margin: 0;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .cv-timeline-subtitle {
        font-weight: 500;
        font-size: 13px;
        color: var(--text-light);
        font-style: italic;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .cv-timeline-date {
        font-size: 12.5px;
        color: var(--primary-color);
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .cv-timeline-details {
        font-size: 12.5px;
        color: #6b7280;
        margin-bottom: 4px;
        display: flex;
        gap: 12px;
    }

    .cv-timeline-desc {
        font-size: 13px;
        color: var(--text-light);
        margin: 4px 0 0 0;
        text-align: justify;
        white-space: pre-wrap;
    }

    .cv-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .cv-pill {
        background-color: #f3f4f6;
        color: var(--text-dark);
        font-size: 12.5px;
        padding: 4px 10px;
        border-radius: 4px;
        border: 1px solid var(--border-light);
        font-weight: 500;
    }

    .cv-links-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px 16px;
    }

    .cv-link-card {
        font-size: 13px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .cv-link-card a {
        color: var(--primary-color);
        text-decoration: none;
        word-break: break-all;
    }

    .cv-link-card a:hover {
        text-decoration: underline;
    }

</style>

<div class="cv-document">
    {{-- Header --}}
    <div class="cv-header">
        @if($avatar)
            <img src="{{ str_starts_with($avatar, 'http') ? $avatar : asset($avatar) }}" alt="Avatar" class="cv-header-avatar">
        @else
            <div class="cv-header-avatar-initials">
                @php
                    $tenRut = 'ND';
                    if ($user->ho_ten) {
                        $cacTu = explode(' ', trim($user->ho_ten));
                        $tenRut = count($cacTu) >= 2 
                            ? mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1) 
                            : mb_substr($user->ho_ten, 0, 2);
                        $tenRut = mb_strtoupper($tenRut);
                    }
                @endphp
                {{ $tenRut }}
            </div>
        @endif

        <div class="cv-header-info">
            <h1 class="cv-name" data-edit-key="ho_ten">{{ $getVal('ho_ten', $user->ho_ten) }}</h1>
            <h2 class="cv-title" data-edit-key="chuc_danh">{{ $getVal('chuc_danh', $user->chuc_danh ?: 'Lập trình viên / Phát triển phần mềm') }}</h2>
            
            <div class="cv-contact-grid">
                <div class="cv-contact-item" title="Số điện thoại">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span data-edit-key="so_dien_thoai">{{ $getVal('so_dien_thoai', $user->so_dien_thoai) }}</span>
                </div>
                <div class="cv-contact-item" title="Thư điện tử">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span data-edit-key="email">{{ $getVal('email', $user->email) }}</span>
                </div>
                <div class="cv-contact-item" title="Địa chỉ sinh sống">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span data-edit-key="dia_chi">{{ $getVal('dia_chi', $user->dia_chi ?: 'Hà Nội, Việt Nam') }}</span>
                </div>
                @if($user->ngay_sinh)
                    <div class="cv-contact-item" title="Ngày sinh">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span data-edit-key="ngay_sinh">{{ $getVal('ngay_sinh', date('d/m/Y', strtotime($user->ngay_sinh))) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Biography (Always show under header) --}}
    @if($user->gioi_thieu)
        <div class="cv-section">
            <h3 class="cv-section-title" data-edit-key="section_title.gioi_thieu">{{ $getVal('section_title.gioi_thieu', 'Giới thiệu bản thân') }}</h3>
            <p class="cv-intro-text" data-edit-key="gioi_thieu">{{ $getVal('gioi_thieu', $user->gioi_thieu) }}</p>
        </div>
    @endif

    {{-- Loop sections based on order and visibility --}}
    @foreach($order as $section)
        @if(isset($visibility[$section]) && $visibility[$section])
            
            {{-- HỌC VẤN --}}
            @if($section === 'hoc_van' && $profileData['hocVan']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.hoc_van">{{ $getVal('section_title.hoc_van', 'Học vấn & Bằng cấp') }}</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['hocVan'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="hoc_van.{{ $item->id }}.tieu_de">{{ $getVal("hoc_van.{$item->id}.tieu_de", $item->tieu_de) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="hoc_van.{{ $item->id }}.ten_truong">{{ $getVal("hoc_van.{$item->id}.ten_truong", $item->ten_truong) }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="hoc_van.{{ $item->id }}.date">
                                        {{ $getVal("hoc_van.{$item->id}.date", $item->nam_bat_dau . ' - ' . ($item->trang_thai === 'dang_hoc' || is_null($item->nam_ket_thuc) ? 'Hiện tại' : $item->nam_ket_thuc)) }}
                                    </div>
                                </div>
                                <div class="cv-timeline-details">
                                    @if($item->khoa) <span data-edit-key="hoc_van.{{ $item->id }}.khoa">Khoa: {{ $getVal("hoc_van.{$item->id}.khoa", $item->khoa) }}</span> @endif
                                    @if($item->nganh) <span data-edit-key="hoc_van.{{ $item->id }}.nganh">Ngành: {{ $getVal("hoc_van.{$item->id}.nganh", $item->nganh) }}</span> @endif
                                    @if($item->gpa) <span data-edit-key="hoc_van.{{ $item->id }}.gpa">GPA: {{ $getVal("hoc_van.{$item->id}.gpa", $item->gpa) }}</span> @endif
                                    @if($item->xep_loai) <span data-edit-key="hoc_van.{{ $item->id }}.xep_loai">Xếp loại: {{ $getVal("hoc_van.{$item->id}.xep_loai", $item->xep_loai) }}</span> @endif
                                </div>
                                @if($item->mo_ta)
                                    <p class="cv-timeline-desc" data-edit-key="hoc_van.{{ $item->id }}.mo_ta">{{ $getVal("hoc_van.{$item->id}.mo_ta", $item->mo_ta) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- KINH NGHIỆM --}}
            @if($section === 'kinh_nghiem' && $profileData['kinhNghiem']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.kinh_nghiem">{{ $getVal('section_title.kinh_nghiem', 'Kinh nghiệm làm việc') }}</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['kinhNghiem'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="kinh_nghiem.{{ $item->id }}.vi_tri_cong_viec">{{ $getVal("kinh_nghiem.{$item->id}.vi_tri_cong_viec", $item->vi_tri_cong_viec) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="kinh_nghiem.{{ $item->id }}.ten_cong_ty">{{ $getVal("kinh_nghiem.{$item->id}.ten_cong_ty", $item->ten_cong_ty) }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="kinh_nghiem.{{ $item->id }}.date">
                                        {{ $getVal("kinh_nghiem.{$item->id}.date", date('m/Y', strtotime($item->ngay_bat_dau)) . ' - ' . ($item->dang_lam_viec ? 'Hiện tại' : ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại'))) }}
                                    </div>
                                </div>
                                @if($item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc" data-edit-key="kinh_nghiem.{{ $item->id }}.mo_ta_chi_tiet">{{ $getVal("kinh_nghiem.{$item->id}.mo_ta_chi_tiet", $item->mo_ta_chi_tiet) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- DỰ ÁN --}}
            @if($section === 'du_an' && $profileData['duAn']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.du_an">{{ $getVal('section_title.du_an', 'Dự án / Portfolio') }}</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['duAn'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="du_an.{{ $item->id }}.ten_du_an">{{ $getVal("du_an.{$item->id}.ten_du_an", $item->ten_du_an) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="du_an.{{ $item->id }}.vai_tro">Vai trò: {{ $getVal("du_an.{$item->id}.vai_tro", $item->vai_tro ?: 'Thành viên') }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="du_an.{{ $item->id }}.date">
                                        {{ $getVal("du_an.{$item->id}.date", date('m/Y', strtotime($item->ngay_bat_dau)) . ' - ' . ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại')) }}
                                    </div>
                                </div>
                                
                                @if($item->tu_khoa)
                                    <div class="cv-timeline-details" style="margin-top: 2px;">
                                        @php $tags = json_decode($item->tu_khoa, true) ?: []; @endphp
                                        <span data-edit-key="du_an.{{ $item->id }}.tu_khoa">Công nghệ: {{ $getVal("du_an.{$item->id}.tu_khoa", implode(', ', $tags)) }}</span>
                                    </div>
                                @endif

                                @if(isset($item->lien_ket) && $item->lien_ket)
                                    <div class="cv-timeline-details" style="margin-top: -2px;">
                                        <span>Liên kết: <a href="{{ $item->lien_ket }}" target="_blank" data-edit-key="du_an.{{ $item->id }}.lien_ket">{{ $getVal("du_an.{$item->id}.lien_ket", $item->lien_ket) }}</a></span>
                                    </div>
                                @endif

                                @if(isset($item->mo_ta_ngan) && $item->mo_ta_ngan)
                                    <p class="cv-timeline-desc" style="font-weight: 500;" data-edit-key="du_an.{{ $item->id }}.mo_ta_ngan">{{ $getVal("du_an.{$item->id}.mo_ta_ngan", $item->mo_ta_ngan) }}</p>
                                @endif
                                @if(isset($item->mo_ta_chi_tiet) && $item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc" data-edit-key="du_an.{{ $item->id }}.mo_ta_chi_tiet">{{ $getVal("du_an.{$item->id}.mo_ta_chi_tiet", $item->mo_ta_chi_tiet) }}</p>
                                @elseif(isset($item->mo_ta) && $item->mo_ta)
                                    <p class="cv-timeline-desc" data-edit-key="du_an.{{ $item->id }}.mo_ta">{{ $getVal("du_an.{$item->id}.mo_ta", $item->mo_ta) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CHỨNG CHỈ --}}
            @if($section === 'chung_chi' && $profileData['chungChi']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.chung_chi">{{ $getVal('section_title.chung_chi', 'Chứng chỉ & Chứng nhận') }}</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['chungChi'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="chung_chi.{{ $item->id }}.ten_chung_chi">{{ $getVal("chung_chi.{$item->id}.ten_chung_chi", $item->ten_chung_chi) }}</h4>
                                        <span class="cv-timeline-subtitle" data-edit-key="chung_chi.{{ $item->id }}.to_chuc_cap">Tổ chức cấp: {{ $getVal("chung_chi.{$item->id}.to_chuc_cap", $item->to_chuc_cap) }}</span>
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="chung_chi.{{ $item->id }}.date">
                                        {{ $getVal("chung_chi.{$item->id}.date", 'Cấp: ' . date('m/Y', strtotime($item->ngay_cap)) . ($item->ngay_het_han ? ' - Hạn: ' . date('m/Y', strtotime($item->ngay_het_han)) : '')) }}
                                    </div>
                                </div>
                                <div class="cv-timeline-details">
                                    <span data-edit-key="chung_chi.{{ $item->id }}.phan_loai">Phân loại: 
                                        {{ $getVal("chung_chi.{$item->id}.phan_loai", $item->phan_loai === 'chuyen_mon' ? 'Chuyên môn' : ($item->phan_loai === 'ngoai_ngu' ? 'Ngoại ngữ' : ($item->phan_loai === 'ky_nang' ? 'Kỹ năng' : 'Khác'))) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- THÀNH TỰU --}}
            @if($section === 'thanh_tuu' && $profileData['thanhTuu']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.thanh_tuu">{{ $getVal('section_title.thanh_tuu', 'Thành tựu & Giải thưởng') }}</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['thanhTuu'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title" data-edit-key="thanh_tuu.{{ $item->id }}.ten_thanh_tuu">{{ $getVal("thanh_tuu.{$item->id}.ten_thanh_tuu", $item->ten_thanh_tuu) }}</h4>
                                        @if($item->to_chuc_cap)
                                            <span class="cv-timeline-subtitle" data-edit-key="thanh_tuu.{{ $item->id }}.to_chuc_cap">Đơn vị trao: {{ $getVal("thanh_tuu.{$item->id}.to_chuc_cap", $item->to_chuc_cap) }}</span>
                                        @endif
                                    </div>
                                    <div class="cv-timeline-date" data-edit-key="thanh_tuu.{{ $item->id }}.date">
                                        {{ $getVal("thanh_tuu.{$item->id}.date", $item->thoi_gian ?: 'Đã đạt được') }}
                                    </div>
                                </div>
                                @if($item->mo_ta)
                                    <p class="cv-timeline-desc" data-edit-key="thanh_tuu.{{ $item->id }}.mo_ta">{{ $getVal("thanh_tuu.{$item->id}.mo_ta", $item->mo_ta) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- KỸ NĂNG --}}
            @if($section === 'ky_nang' && (count($profileData['ngonNgu']) > 0 || count($profileData['kyNang']) > 0))
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.ky_nang">{{ $getVal('section_title.ky_nang', 'Kỹ năng chuyên môn') }}</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @if(count($profileData['ngonNgu']) > 0)
                            <div>
                                <h5 style="margin: 0 0 6px 0; font-size: 13px; font-weight: 600; color: var(--text-dark);">Công nghệ & Ngôn ngữ lập trình:</h5>
                                <div class="cv-pill-container">
                                    @foreach($profileData['ngonNgu'] as $lang)
                                        <span class="cv-pill" data-edit-key="ngon_ngu.{{ $loop->index }}">{{ $getVal("ngon_ngu.{$loop->index}", $lang) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($profileData['kyNang']) > 0)
                            <div>
                                <h5 style="margin: 0 0 6px 0; font-size: 13px; font-weight: 600; color: var(--text-dark);">Kỹ năng mềm / Khác:</h5>
                                <div class="cv-pill-container">
                                    @foreach($profileData['kyNang'] as $skill)
                                        <span class="cv-pill" data-edit-key="ky_nang.{{ $loop->index }}">{{ $getVal("ky_nang.{$loop->index}", $skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- LIÊN KẾT --}}
            @if($section === 'lien_ket' && $profileData['lienKetMxh']->count() > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.lien_ket">{{ $getVal('section_title.lien_ket', 'Liên hệ & Mạng xã hội') }}</h3>
                    <div class="cv-links-list">
                        @foreach($profileData['lienKetMxh'] as $item)
                            <div class="cv-link-card">
                                <strong data-edit-key="lien_ket.{{ $item->id }}.ten_nen_tang">{{ $getVal("lien_ket.{$item->id}.ten_nen_tang", $item->ten_nen_tang) }}:</strong>
                                <a href="{{ $item->duong_dan }}" target="_blank" data-edit-key="lien_ket.{{ $item->id }}.duong_dan">{{ $getVal("lien_ket.{$item->id}.duong_dan", $item->duong_dan) }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- SỞ THÍCH CÁ NHÂN --}}
            @if($section === 'so_thich' && $user->so_thich)
                <div class="cv-section">
                    <h3 class="cv-section-title" data-edit-key="section_title.so_thich">{{ $getVal('section_title.so_thich', 'Sở thích cá nhân') }}</h3>
                    <p class="cv-intro-text" data-edit-key="so_thich">{{ $getVal('so_thich', $user->so_thich) }}</p>
                </div>
            @endif

        @endif
    @endforeach
</div>
