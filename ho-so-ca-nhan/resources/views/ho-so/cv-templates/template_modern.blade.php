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
        --border-light: #e2e8f0;
        --bg-sidebar: #f8fafc;
        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cv-document {
        font-family: var(--font-sans);
        color: var(--text-dark);
        line-height: 1.5;
        font-size: 13.5px;
        background-color: #fff;
        display: flex;
        min-height: 297mm; /* Khổ A4 */
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Sidebar Column */
    .cv-sidebar {
        width: 32%;
        background-color: var(--bg-sidebar);
        border-right: 1.5px solid var(--border-light);
        padding: 24px 16px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .cv-sidebar-avatar-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 8px;
    }

    .cv-sidebar-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        background-color: #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .cv-sidebar-avatar-initials {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid var(--primary-color);
        background-color: var(--primary-color);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        font-weight: 700;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .cv-sidebar-section {
        page-break-inside: avoid;
    }

    .cv-sidebar-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--primary-color);
        border-bottom: 1.5px solid var(--primary-color);
        padding-bottom: 4px;
        margin: 0 0 10px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-sidebar-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-light);
    }

    .cv-sidebar-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .cv-sidebar-item-label {
        font-weight: 600;
        color: var(--text-dark);
    }

    .cv-sidebar-item-val {
        word-break: break-all;
    }

    .cv-sidebar-item-val a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .cv-sidebar-item-val a:hover {
        text-decoration: underline;
    }

    /* Main Content Column */
    .cv-main {
        width: 68%;
        padding: 24px 22px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .cv-main-header {
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 14px;
        margin-bottom: 6px;
    }

    .cv-name {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary-color);
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-light);
        margin: 0;
    }

    .cv-main-section {
        margin-bottom: 4px;
    }

    .cv-main-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-color);
        border-bottom: 1.5px solid var(--primary-color);
        padding-bottom: 4px;
        margin: 0 0 12px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cv-intro-text {
        font-size: 13px;
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
        margin-bottom: 2px;
    }

    .cv-timeline-header > div:first-child {
        flex: 1;
        min-width: 0;
        padding-right: 16px;
    }

    .cv-timeline-title {
        font-weight: 700;
        font-size: 13.5px;
        color: var(--text-dark);
        margin: 0;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .cv-timeline-subtitle {
        font-weight: 600;
        font-size: 12.5px;
        color: var(--text-light);
        font-style: italic;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .cv-timeline-date {
        font-size: 12px;
        color: var(--primary-color);
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .cv-timeline-details {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 2px;
        display: flex;
        gap: 10px;
    }

    .cv-timeline-desc {
        font-size: 12.5px;
        color: var(--text-light);
        margin: 4px 0 0 0;
        text-align: justify;
        white-space: pre-wrap;
    }

    .cv-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .cv-pill {
        background-color: #fff;
        color: var(--text-dark);
        font-size: 11.5px;
        padding: 3px 8px;
        border-radius: 4px;
        border: 1px solid var(--border-light);
        font-weight: 500;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.02);
    }

</style>

<div class="cv-document">
    {{-- Left Sidebar: Avatar, Personal Info, Skills, Links --}}
    <div class="cv-sidebar">
        {{-- Avatar --}}
        <div class="cv-sidebar-avatar-wrapper">
            @if($avatar)
                <img src="{{ str_starts_with($avatar, 'http') ? $avatar : asset($avatar) }}" alt="Avatar" class="cv-sidebar-avatar">
            @else
                <div class="cv-sidebar-avatar-initials">
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
        </div>

        {{-- Personal Info (Always Show in Sidebar) --}}
        <div class="cv-sidebar-section">
            <h3 class="cv-sidebar-title" data-edit-key="section_title.contact_info">{{ $getVal('section_title.contact_info', 'Thông tin liên hệ') }}</h3>
            <div class="cv-sidebar-list">
                <div class="cv-sidebar-item">
                    <span class="cv-sidebar-item-label">Số điện thoại:</span>
                    <span class="cv-sidebar-item-val" data-edit-key="so_dien_thoai">{{ $getVal('so_dien_thoai', $user->so_dien_thoai) }}</span>
                </div>
                <div class="cv-sidebar-item">
                    <span class="cv-sidebar-item-label">Email:</span>
                    <span class="cv-sidebar-item-val" style="word-break: break-all;" data-edit-key="email">{{ $getVal('email', $user->email) }}</span>
                </div>
                <div class="cv-sidebar-item">
                    <span class="cv-sidebar-item-label">Địa chỉ:</span>
                    <span class="cv-sidebar-item-val" data-edit-key="dia_chi">{{ $getVal('dia_chi', $user->dia_chi ?: 'Hà Nội, Việt Nam') }}</span>
                </div>
                @if($user->ngay_sinh)
                    <div class="cv-sidebar-item">
                        <span class="cv-sidebar-item-label">Ngày sinh:</span>
                        <span class="cv-sidebar-item-val" data-edit-key="ngay_sinh">{{ $getVal('ngay_sinh', date('d/m/Y', strtotime($user->ngay_sinh))) }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Programming Languages & Skills (Placed on left sidebar) --}}
        @if(isset($visibility['ky_nang']) && $visibility['ky_nang'] && (count($profileData['ngonNgu']) > 0 || count($profileData['kyNang']) > 0))
            <div class="cv-sidebar-section">
                <h3 class="cv-sidebar-title" data-edit-key="section_title.ky_nang">{{ $getVal('section_title.ky_nang', 'Kỹ năng') }}</h3>
                <div class="cv-sidebar-list" style="gap: 14px;">
                    @if(count($profileData['ngonNgu']) > 0)
                        <div>
                            <div class="cv-sidebar-item-label" style="font-size: 12px; margin-bottom: 4px;">Công nghệ / Ngôn ngữ:</div>
                            <div class="cv-pill-container">
                                @foreach($profileData['ngonNgu'] as $lang)
                                    <span class="cv-pill" data-edit-key="ngon_ngu.{{ $loop->index }}">{{ $getVal("ngon_ngu.{$loop->index}", $lang) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($profileData['kyNang']) > 0)
                        <div>
                            <div class="cv-sidebar-item-label" style="font-size: 12px; margin-bottom: 4px;">Kỹ năng mềm:</div>
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

        {{-- Social Media Links (Placed on left sidebar) --}}
        @if(isset($visibility['lien_ket']) && $visibility['lien_ket'] && $profileData['lienKetMxh']->count() > 0)
            <div class="cv-sidebar-section">
                <h3 class="cv-sidebar-title" data-edit-key="section_title.lien_ket">{{ $getVal('section_title.lien_ket', 'Mạng xã hội') }}</h3>
                <div class="cv-sidebar-list">
                    @foreach($profileData['lienKetMxh'] as $item)
                        <div class="cv-sidebar-item">
                            <span class="cv-sidebar-item-label" data-edit-key="lien_ket.{{ $item->id }}.ten_nen_tang">{{ $getVal("lien_ket.{$item->id}.ten_nen_tang", $item->ten_nen_tang) }}:</span>
                            <span class="cv-sidebar-item-val"><a href="{{ $item->duong_dan }}" target="_blank" data-edit-key="lien_ket.{{ $item->id }}.duong_dan">{{ $getVal("lien_ket.{$item->id}.duong_dan", $item->duong_dan) }}</a></span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Right Main Column: Name, Bio, and Timeline sections --}}
    <div class="cv-main">
        {{-- Profile Header --}}
        <div class="cv-main-header">
            <h1 class="cv-name" data-edit-key="ho_ten">{{ $getVal('ho_ten', $user->ho_ten) }}</h1>
            <h2 class="cv-title" data-edit-key="chuc_danh">{{ $getVal('chuc_danh', $user->chuc_danh ?: 'Lập trình viên / Phát triển phần mềm') }}</h2>
        </div>

        {{-- Biography --}}
        @if($user->gioi_thieu)
            <div class="cv-main-section">
                <h3 class="cv-main-section-title" data-edit-key="section_title.gioi_thieu">{{ $getVal('section_title.gioi_thieu', 'Giới thiệu bản thân') }}</h3>
                <p class="cv-intro-text" data-edit-key="gioi_thieu">{{ $getVal('gioi_thieu', $user->gioi_thieu) }}</p>
            </div>
        @endif

        {{-- Loop sections in order --}}
        @foreach($order as $section)
            @if(isset($visibility[$section]) && $visibility[$section])
                
                {{-- HỌC VẤN --}}
                @if($section === 'hoc_van' && $profileData['hocVan']->count() > 0)
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.hoc_van">{{ $getVal('section_title.hoc_van', 'Học vấn & Bằng cấp') }}</h3>
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
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.kinh_nghiem">{{ $getVal('section_title.kinh_nghiem', 'Kinh nghiệm làm việc') }}</h3>
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
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.du_an">{{ $getVal('section_title.du_an', 'Dự án / Portfolio') }}</h3>
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
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.chung_chi">{{ $getVal('section_title.chung_chi', 'Chứng chỉ & Chứng nhận') }}</h3>
                        <div class="cv-timeline-list">
                            @foreach($profileData['chungChi'] as $item)
                                <div class="cv-timeline-item">
                                    <div class="cv-timeline-header">
                                        <div>
                                            <h4 class="cv-timeline-title" data-edit-key="chung_chi.{{ $item->id }}.ten_chung_chi">{{ $getVal("chung_chi.{$item->id}.ten_chung_chi", $item->ten_chung_chi) }}</h4>
                                            <span class="cv-timeline-subtitle" data-edit-key="chung_chi.{{ $item->id }}.to_chuc_cap">Tổ chức cấp: {{ $getVal("chung_chi.{$item->id}.to_chuc_cap", $item->to_chuc_cap) }}</span>
                                        </div>
                                        <div class="cv-timeline-date" data-edit-key="chung_chi.{{ $item->id }}.date">
                                            {{ $getVal("chung_chi.{$item->id}.date", 'Cấp: ' . date('m/Y', strtotime($item->ngay_cap))) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- THÀNH TỰU --}}
                @if($section === 'thanh_tuu' && $profileData['thanhTuu']->count() > 0)
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.thanh_tuu">{{ $getVal('section_title.thanh_tuu', 'Thành tựu & Giải thưởng') }}</h3>
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

                {{-- SỞ THÍCH CÁ NHÂN --}}
                @if($section === 'so_thich' && $user->so_thich)
                    <div class="cv-main-section">
                        <h3 class="cv-main-section-title" data-edit-key="section_title.so_thich">{{ $getVal('section_title.so_thich', 'Sở thích cá nhân') }}</h3>
                        <p class="cv-intro-text" data-edit-key="so_thich">{{ $getVal('so_thich', $user->so_thich) }}</p>
                    </div>
                @endif

            @endif
        @endforeach
    </div>
</div>
