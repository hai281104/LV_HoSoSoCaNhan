@php
    $accentColor = $tuyChinh['mau_chu_dao'] ?? '#2563eb';
    $user = $profileData['nguoiDung'] ?? null;
    $avatar = $tuyChinh['anh_dai_dien'] ?? ($user->anh_dai_dien ?? '');
@endphp

<style>
    :root {
        --primary-color: {{ $accentColor }};
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --bg-sidebar: #0f172a;
        --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cv-document {
        font-family: var(--font-sans);
        color: var(--text-dark);
        line-height: 1.6;
        font-size: 14px;
        background-color: #ffffff;
        display: flex;
        align-items: stretch;
        min-height: 100%;
        width: 100%;
        box-sizing: border-box;
    }

    .cv-sidebar {
        width: 32%;
        background-color: var(--bg-sidebar);
        color: #f8fafc;
        padding: 30px 20px;
        box-sizing: border-box;
        align-self: stretch;
        flex-shrink: 0;
    }

    .cv-main {
        width: 68%;
        padding: 30px 30px;
        box-sizing: border-box;
    }

    .cv-avatar-box {
        text-align: center;
        margin-bottom: 24px;
    }

    .cv-avatar-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-color);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .cv-sidebar-title {
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 6px;
        margin-top: 24px;
        margin-bottom: 12px;
        letter-spacing: 0.5px;
    }

    .cv-sidebar-item {
        font-size: 13px;
        margin-bottom: 8px;
        word-break: break-word;
        color: #cbd5e1;
    }

    .cv-main-name {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 4px 0;
        text-transform: uppercase;
    }

    .cv-main-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .cv-section-header {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 6px;
        margin-top: 24px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cv-section-header::before {
        content: '';
        display: inline-block;
        width: 10px;
        height: 16px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

    .cv-item {
        margin-bottom: 16px;
    }

    .cv-item-header {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        color: var(--text-dark);
    }

    .cv-item-sub {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 13.5px;
    }

    .cv-item-date {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .cv-item-desc {
        font-size: 13px;
        color: #475569;
        margin-top: 4px;
    }

    .cv-tag {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        margin-right: 6px;
        margin-bottom: 6px;
    }
</style>

<div class="cv-document">
    <!-- Sidebar Left -->
    <div class="cv-sidebar">
        @if($avatar)
            <div class="cv-avatar-box">
                <img src="{{ asset($avatar) }}" class="cv-avatar-img" alt="Avatar">
            </div>
        @endif

        <div class="cv-sidebar-title">Liên hệ</div>
        @if(!empty($user->email))
            <div class="cv-sidebar-item">📧 {{ $user->email }}</div>
        @endif
        @if(!empty($user->so_dien_thoai))
            <div class="cv-sidebar-item">📱 {{ $user->so_dien_thoai }}</div>
        @endif
        @if(!empty($user->dia_chi))
            <div class="cv-sidebar-item">📍 {{ $user->dia_chi }}</div>
        @endif

        @if(!empty($profileData['lienKetMxh']) && count($profileData['lienKetMxh']) > 0)
            <div class="cv-sidebar-title">Mạng xã hội</div>
            @foreach($profileData['lienKetMxh'] as $lk)
                <div class="cv-sidebar-item">🌐 <a href="{{ $lk->duong_dan }}" target="_blank" style="color: #93c5fd; text-decoration: none;">{{ $lk->ten_nen_tang ?? 'Link' }}</a></div>
            @endforeach
        @endif

        @if(!empty($profileData['kyNang']) && count($profileData['kyNang']) > 0)
            <div class="cv-sidebar-title">Kỹ năng mềm</div>
            @foreach($profileData['kyNang'] as $kn)
                <span class="cv-tag" style="background: rgba(255,255,255,0.15); color: #fff;">{{ $kn }}</span>
            @endforeach
        @endif

        @if(!empty($profileData['ngonNgu']) && count($profileData['ngonNgu']) > 0)
            <div class="cv-sidebar-title">Ngôn ngữ lập trình</div>
            @foreach($profileData['ngonNgu'] as $nn)
                <span class="cv-tag" style="background: rgba(255,255,255,0.15); color: #fff;">{{ $nn }}</span>
            @endforeach
        @endif
    </div>

    <!-- Main Content Right -->
    <div class="cv-main">
        <h1 class="cv-main-name">{{ $user->ho_ten ?? 'Họ và Tên' }}</h1>
        <div class="cv-main-title">{{ $user->chuc_danh ?? 'Chuyên viên' }}</div>

        @if(!empty($user->gioi_thieu))
            <div class="cv-item-desc" style="margin-bottom: 20px;">
                {{ $user->gioi_thieu }}
            </div>
        @endif

        @if(!empty($profileData['kinhNghiem']) && count($profileData['kinhNghiem']) > 0)
            <div class="cv-section">
                <div class="cv-section-header">Kinh nghiệm làm việc</div>
                @foreach($profileData['kinhNghiem'] as $kn)
                    <div class="cv-timeline-item">
                        <div class="cv-item-header">
                            <span>{{ $kn->ten_cong_ty ?? '' }}</span>
                            <span class="cv-item-date">{{ isset($kn->ngay_bat_dau) ? date('m/Y', strtotime($kn->ngay_bat_dau)) : '' }} - {{ !empty($kn->dang_lam_viec) ? 'Hiện tại' : (isset($kn->ngay_ket_thuc) ? date('m/Y', strtotime($kn->ngay_ket_thuc)) : 'Hiện tại') }}</span>
                        </div>
                        <div class="cv-item-sub">{{ $kn->vi_tri_cong_viec ?? $kn->chuc_vu ?? '' }}</div>
                        @php $moTa = $kn->mo_ta_chi_tiet ?? $kn->mo_ta ?? ''; @endphp
                        @if(!empty($moTa))
                            <div class="cv-item-desc">{!! nl2br(e($moTa)) !!}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($profileData['hocVan']) && count($profileData['hocVan']) > 0)
            <div class="cv-section">
                <div class="cv-section-header">Học vấn</div>
                @foreach($profileData['hocVan'] as $hv)
                    <div class="cv-timeline-item">
                        <div class="cv-item-header">
                            <span>{{ $hv->ten_truong ?? '' }}</span>
                            <span class="cv-item-date">{{ $hv->nam_bat_dau ?? '' }} - {{ ($hv->trang_thai ?? '') === 'dang_hoc' || empty($hv->nam_ket_thuc) ? 'Hiện tại' : $hv->nam_ket_thuc }}</span>
                        </div>
                        <div class="cv-item-sub">{{ $hv->nganh ?? $hv->tieu_de ?? $hv->chuyen_nganh ?? '' }}</div>
                        @if(!empty($hv->mo_ta))
                            <div class="cv-item-desc">{!! nl2br(e($hv->mo_ta)) !!}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($profileData['duAn']) && count($profileData['duAn']) > 0)
            <div class="cv-section">
                <div class="cv-section-header">Dự án thực hiện</div>
                @foreach($profileData['duAn'] as $da)
                    <div class="cv-timeline-item">
                        <div class="cv-item-header">
                            <span>{{ $da->ten_du_an ?? '' }}</span>
                        </div>
                        <div class="cv-item-sub">Vai trò: {{ $da->vai_tro ?? $da->chuc_vu ?? 'Thành viên' }}</div>
                        @php $moTaDa = $da->mo_ta_chi_tiet ?? $da->mo_ta ?? ''; @endphp
                        @if(!empty($moTaDa))
                            <div class="cv-item-desc">{!! nl2br(e($moTaDa)) !!}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($profileData['chungChi']) && count($profileData['chungChi']) > 0)
            <div class="cv-section">
                <div class="cv-section-header">Chứng chỉ</div>
                @foreach($profileData['chungChi'] as $cc)
                    <div class="cv-timeline-item">
                        <div class="cv-item-header">
                            <span>{{ $cc->ten_chung_chi }}</span>
                            <span class="cv-item-date">{{ $cc->ngay_cap }}</span>
                        </div>
                        <div class="cv-item-sub">{{ $cc->to_chuc_cap }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>