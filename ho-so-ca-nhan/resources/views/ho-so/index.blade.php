@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    $nguoiDung  = $nguoiDung ?? Auth::user();
    $hoTen      = $nguoiDung->ho_ten;
    $thuDienTu  = $nguoiDung->email;
    $soDienThoai = $nguoiDung->so_dien_thoai ?? 'Chưa cập nhật';
    $diaChi     = $nguoiDung->dia_chi ?? 'Chưa cập nhật';
    $ngaySinhRaw = $nguoiDung->ngay_sinh;
    $ngaySinh   = $ngaySinhRaw ? date('d/m/Y', strtotime($ngaySinhRaw)) : 'Chưa cập nhật';
    $chucDanh   = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
    $gioiThieu  = $nguoiDung->gioi_thieu ?? 'Chưa có thông tin giới thiệu bản thân.';
    $soThich    = $nguoiDung->so_thich ?? 'Chưa cập nhật';
    $anhDaiDien = $nguoiDung->anh_dai_dien;

    // Tao chu cai tat
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

    // Nen tang icon map
    $iconMap = [
        'facebook'  => '<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'github'    => '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'linkedin'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/>',
        'twitter'   => '<path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'default'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>',
    ];

    $layIconMxh = function($tenNenTang) use ($iconMap) {
        $key = strtolower(trim($tenNenTang ?? ''));
        foreach ($iconMap as $k => $v) {
            if (str_contains($key, $k)) return $v;
        }
        return $iconMap['default'];
    };

    // Chuan bi du lieu cho form chinh sua lien ket
    $nenTangOptions = ['Facebook','GitHub','LinkedIn','Twitter/X','Instagram','YouTube','TikTok','Portfolio','Khác'];
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hồ sơ cá nhân - {{ $hoTen }}</title>
    <meta name="description" content="Trang hồ sơ cá nhân của {{ $hoTen }} - quản lý thông tin, kỹ năng và liên kết chuyên môn.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">

    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Hồ sơ cá nhân', 'searchPlaceholder' => ''])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Profile Banner --}}
        <div class="profile-banner-card">
            <div class="banner-cover"></div>
            <div class="banner-profile-info">
                {{-- Avatar --}}
                <div class="avatar-overlap-wrapper">
                    <div class="avatar-overlap" id="main-avatar-wrapper">
                        @if($anhDaiDien)
                            <img src="{{ asset($anhDaiDien) }}" alt="Avatar" class="js-avatar-img">
                        @else
                            <span class="js-avatar-initials" id="main-avatar-initials">{{ $tenRutGon }}</span>
                        @endif
                    </div>
                    <span class="status-dot"></span>
                </div>

                {{-- Name & Title --}}
                <div class="profile-name-title">
                    <h2 id="display-ho-ten">{{ $hoTen }}</h2>
                    <p id="display-chuc-danh">{{ $chucDanh }}</p>
                </div>

                {{-- Nút chỉnh sửa --}}
                <button type="button" class="btn-edit-profile" id="btn-mo-modal-chinh-sua">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Chỉnh sửa hồ sơ</span>
                </button>
            </div>
        </div>

        {{-- Profile Grid --}}
        <div class="profile-grid">

            {{-- CỘT TRÁI --}}
            <div class="grid-column">

                {{-- Thông tin cơ bản --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Thông tin cơ bản</span>
                        </h3>
                    </div>
                    <div class="basic-info-list">
                        {{-- Ngày sinh --}}
                        <div class="basic-info-item">
                            <div class="info-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="info-item-content">
                                <div class="info-item-label">Ngày sinh</div>
                                <div class="info-item-value" id="display-ngay-sinh">{{ $ngaySinh }}</div>
                            </div>
                        </div>
                        {{-- Khu vực --}}
                        <div class="basic-info-item">
                            <div class="info-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="info-item-content">
                                <div class="info-item-label">Khu vực sinh sống</div>
                                <div class="info-item-value" id="display-dia-chi">{{ $diaChi }}</div>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="basic-info-item">
                            <div class="info-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="info-item-content">
                                <div class="info-item-label">Email liên hệ</div>
                                <a href="mailto:{{ $thuDienTu }}" class="info-item-value link">{{ $thuDienTu }}</a>
                            </div>
                        </div>
                        {{-- SĐT --}}
                        <div class="basic-info-item">
                            <div class="info-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="info-item-content">
                                <div class="info-item-label">Số điện thoại</div>
                                <div class="info-item-value" id="display-so-dien-thoai">{{ $soDienThoai }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Liên kết chuyên môn --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <span>Liên kết chuyên môn</span>
                        </h3>
                        <button type="button" class="card-action-btn" id="btn-mo-modal-chinh-sua-lienket"
                            onclick="moModal('modal-chinh-sua'); moModalTab('modal-chinh-sua', 'tab-lien-ket')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>Sửa</span>
                        </button>
                    </div>

                    <div class="social-links-list" id="display-lien-ket-list">
                        @if($lienKetMxh->count() > 0)
                            @foreach($lienKetMxh as $lienKet)
                                @php $domainHienThi = parse_url($lienKet->duong_dan, PHP_URL_HOST) ?? $lienKet->duong_dan; @endphp
                                <a href="{{ $lienKet->duong_dan }}" target="_blank" rel="noopener" class="social-link-item">
                                    <div class="social-link-info">
                                        <div class="social-logo-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:16px;height:16px;">
                                                {!! $layIconMxh($lienKet->ten_nen_tang) !!}
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="social-name">{{ $lienKet->ten_nen_tang }}</span>
                                            <span class="social-handle">{{ $domainHienThi }}</span>
                                        </div>
                                    </div>
                                    <span class="social-link-external">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                <p>Chưa có liên kết nào.<br>Nhấn <strong>Sửa</strong> để thêm.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>{{-- /Cột trái --}}

            {{-- CỘT PHẢI --}}
            <div class="grid-column">

                {{-- Giới thiệu bản thân --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Giới thiệu bản thân</span>
                        </h3>
                    </div>
                    <div class="intro-text" id="display-gioi-thieu">{{ $gioiThieu }}</div>
                </div>

                {{-- Kỹ năng chuyên môn --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Kỹ năng chuyên môn</span>
                        </h3>
                        <button type="button" class="card-action-btn" id="btn-mo-modal-ky-nang">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>Chỉnh sửa kỹ năng</span>
                        </button>
                    </div>

                    <div class="skill-group-container">
                        {{-- Ngôn ngữ & Framework --}}
                        <div>
                            <h4 class="skill-group-title">Ngôn ngữ & Framework</h4>
                            <div class="skill-tags-list">
                                @if(count($ngonNguLapTrinh) > 0)
                                    @foreach($ngonNguLapTrinh as $nn)
                                        <div class="skill-tag skill-tag-lang">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                                            <span>{{ $nn }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p style="font-size:13px;color:#94a3b8;">Chưa cập nhật. Nhấn <strong>Chỉnh sửa kỹ năng</strong>.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kỹ năng mềm --}}
                        <div>
                            <h4 class="skill-group-title">Kỹ năng mềm</h4>
                            <div class="skill-tags-list">
                                @if(count($kyNangMem) > 0)
                                    @foreach($kyNangMem as $kn)
                                        <div class="skill-tag skill-tag-soft">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            <span>{{ $kn }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p style="font-size:13px;color:#94a3b8;">Chưa cập nhật.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sở thích cá nhân --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span>Sở thích cá nhân</span>
                        </h3>
                        <button type="button" class="card-action-btn"
                            onclick="moModal('modal-chinh-sua'); moModalTab('modal-chinh-sua', 'tab-co-ban')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>Sửa</span>
                        </button>
                    </div>
                    <div class="so-thich-text" id="display-so-thich">{{ $soThich }}</div>
                </div>

                {{-- Kế hoạch phát triển bản thân (3 năm sắp tới) --}}
                <div class="info-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 012-2h2a2 2 0 012 2v14"/>
                            </svg>
                            <span>Kế hoạch phát triển (3 năm tới)</span>
                        </h3>
                        <button type="button" class="card-action-btn"
                            onclick="moModal('modal-chinh-sua'); moModalTab('modal-chinh-sua', 'tab-co-ban')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>Sửa</span>
                        </button>
                    </div>
                    <div class="so-thich-text" id="display-ke-hoach">{!! nl2br(e($keHoach)) !!}</div>
                </div>

            </div>{{-- /Cột phải --}}

        </div>{{-- /Profile Grid --}}

    </div>{{-- /Content Body --}}
</main>

{{-- MODAL: CHỈNH SỬA HỒ SƠ CƠ BẢN + AVATAR + LIÊN KẾT --}}
<div class="modal-overlay" id="modal-chinh-sua" role="dialog" aria-modal="true" aria-labelledby="modal-chinh-sua-title">
    <div class="modal-panel wide">

        {{-- Modal Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chinh-sua-title">Chỉnh sửa hồ sơ</div>
                    <div class="modal-subtitle">Cập nhật thông tin cá nhân, avatar và liên kết</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chinh-sua" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Tabs --}}
        <div class="modal-tabs">
            <button class="modal-tab active" data-panel="tab-co-ban">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Thông tin cơ bản
            </button>
            <button class="modal-tab" data-panel="tab-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Avatar
            </button>
            <button class="modal-tab" id="tab-lien-ket-btn" data-panel="tab-lien-ket">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Liên kết
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body">

            {{-- TAB: THÔNG TIN CƠ BẢN --}}
            <div class="tab-panel active" id="tab-co-ban">
                <form id="form-chinh-sua-co-ban" autocomplete="off" class="form-two-columns">
                    <div class="form-column-left">
                        <div class="form-section">
                            <div class="form-section-title">Thông tin cá nhân</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input-ho-ten">Họ và tên <span class="required">*</span></label>
                                    <input type="text" id="input-ho-ten" name="ho_ten" class="form-input"
                                        value="{{ $hoTen }}" placeholder="Nguyễn Văn A" required minlength="2" maxlength="25">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input-chuc-danh">Chức danh / Vị trí</label>
                                    <input type="text" id="input-chuc-danh" name="chuc_danh" class="form-input"
                                        value="{{ $nguoiDung->chuc_danh }}" placeholder="VD: Fullstack Developer" minlength="2" maxlength="30">
                                    <div class="form-hint">Từ 2 đến 30 ký tự, có thể chứa ký tự đặc biệt.</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Liên lạc & Địa điểm</div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input-ngay-sinh">Ngày sinh</label>
                                    <input type="date" id="input-ngay-sinh" name="ngay_sinh" class="form-input"
                                        value="{{ $ngaySinhRaw }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input-so-dien-thoai">Số điện thoại</label>
                                    <input type="tel" id="input-so-dien-thoai" name="so_dien_thoai" class="form-input"
                                        value="{{ $nguoiDung->so_dien_thoai }}" placeholder="0912 345 678" maxlength="20">
                                </div>
                            </div>
                            <div class="form-row single" style="margin-top:14px;">
                                <div class="form-group">
                                    <label class="form-label" for="input-dia-chi">Khu vực sinh sống</label>
                                    <input type="text" id="input-dia-chi" name="dia_chi" class="form-input"
                                        value="{{ $nguoiDung->dia_chi }}" placeholder="VD: Hồ Chí Minh, Việt Nam" minlength="2" maxlength="100">
                                    <div class="form-hint">Tối đa 100 ký tự (VD: Hà Nội, Việt Nam).</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-column-right">
                        <div class="form-section">
                            <div class="form-section-title">Về bản thân</div>
                            <div class="form-group" style="margin-bottom:14px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                    <label class="form-label" for="input-gioi-thieu" style="margin-bottom: 0;">Giới thiệu bản thân</label>
                                    <button type="button" class="btn-action-sm" onclick="improveTextWithAI('input-gioi-thieu', this)" style="background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border: none; color: white; display: flex; align-items: center; gap: 4px; font-size: 11px; padding: 4px 8px; border-radius: 4px; cursor: pointer;">
                                        ✨ Viết lại bằng AI
                                    </button>
                                </div>
                                <textarea id="input-gioi-thieu" name="gioi_thieu" class="form-textarea tall"
                                    placeholder="Mô tả về bản thân, kinh nghiệm, mục tiêu nghề nghiệp..." maxlength="1000">{{ $nguoiDung->gioi_thieu }}</textarea>
                                <div class="form-hint">Tối đa 1000 ký tự. Hỗ trợ xuống dòng.</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="input-so-thich">Sở thích cá nhân</label>
                                <textarea id="input-so-thich" name="so_thich" class="form-textarea"
                                    placeholder="VD: Đọc sách, Du lịch, Lập trình, Chơi game..." minlength="2" maxlength="50">{{ $nguoiDung->so_thich }}</textarea>
                                <div class="form-hint">Từ 2 đến 50 ký tự.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>{{-- /Tab cơ bản --}}

            {{-- TAB: AVATAR --}}
            <div class="tab-panel" id="tab-avatar">
                <div class="form-section">
                    <div class="form-section-title">Ảnh đại diện</div>

                    <div class="avatar-edit-section">
                        {{-- Preview hiện tại --}}
                        <div class="avatar-current-preview" id="modal-avatar-preview">
                            @if($anhDaiDien)
                                <img src="{{ asset($anhDaiDien) }}" alt="Avatar hiện tại">
                            @else
                                <span class="js-avatar-initials">{{ $tenRutGon }}</span>
                            @endif
                        </div>

                        {{-- Controls --}}
                        <div class="avatar-controls">
                            <div class="avatar-controls-title">Chọn ảnh đại diện mới</div>
                            <button type="button" class="btn-upload-avatar" id="btn-upload-avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Chọn ảnh từ máy tính
                            </button>
                            <input type="file" id="avatar-file-input" class="avatar-file-input" accept="image/jpeg,image/jpg,image/png,image/webp">
                            <div class="avatar-format-hint">Hỗ trợ: JPG, PNG, WebP · Tối đa 5MB</div>
                        </div>
                    </div>

                    {{-- Crop section (hiện sau khi chọn file) --}}
                    <div class="crop-section" id="crop-section">
                        <div style="margin-bottom: 12px;">
                            <div class="form-label" style="margin-bottom: 8px;">Chọn tỉ lệ cắt ảnh</div>
                            <div class="crop-ratio-selector">
                                <button type="button" class="crop-ratio-btn active" data-ratio="1:1">1:1 (Vuông)</button>
                                <button type="button" class="crop-ratio-btn" data-ratio="4:3">4:3</button>
                                <button type="button" class="crop-ratio-btn" data-ratio="16:9">16:9</button>
                                <button type="button" class="crop-ratio-btn" data-ratio="free">Tự do</button>
                            </div>
                        </div>

                        <div class="crop-container">
                            <img id="crop-image" src="" alt="Ảnh cần crop" style="max-width:100%;">
                        </div>

                        <div class="crop-actions" data-upload-url="{{ route('ho-so.cap-nhat-avatar') }}">
                            <button type="button" class="btn-save" id="btn-crop-apply" style="flex:1;">
                                <span class="btn-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Áp dụng & Lưu ảnh
                                </span>
                                <span class="btn-loading">
                                    <span class="spinner"></span> Đang tải lên...
                                </span>
                            </button>
                            <button type="button" class="btn-cancel" id="btn-crop-cancel">Huỷ</button>
                        </div>
                    </div>
                </div>
            </div>{{-- /Tab avatar --}}

            {{-- TAB: LIÊN KẾT --}}
            <div class="tab-panel" id="tab-lien-ket">
                <div class="form-section">
                    <div class="form-section-title">Liên kết chuyên môn & Mạng xã hội</div>
                    <p style="font-size:13px;color:#64748b;margin-bottom:16px;">
                        Thêm các liên kết tới trang cá nhân của bạn. Chúng sẽ được hiển thị trên hồ sơ.
                    </p>

                    <div class="link-rows-container" id="link-rows-container">
                        @foreach($lienKetMxh as $i => $lienKet)
                            @php
                                $nenTangOptions = ['Facebook','GitHub','LinkedIn','Twitter/X','Instagram','YouTube','TikTok','Portfolio','Khác'];
                            @endphp
                            <div class="link-row">
                                <select class="form-select link-platform-select" name="lien_ket[{{ $i }}][ten_nen_tang]">
                                    @foreach($nenTangOptions as $opt)
                                        <option value="{{ $opt }}" {{ $lienKet->ten_nen_tang === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <input type="url" class="form-input link-url-input"
                                    name="lien_ket[{{ $i }}][duong_dan]"
                                    value="{{ $lienKet->duong_dan }}"
                                    placeholder="https://...">
                                <button type="button" class="btn-remove-link" title="Xóa">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn-add-link" id="btn-them-lien-ket" style="margin-top:12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Thêm liên kết mới
                    </button>
                </div>
            </div>{{-- /Tab liên kết --}}

        </div>{{-- /Modal Body --}}

        {{-- Modal Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Dữ liệu được lưu tự động sau khi nhấn Lưu
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-chinh-sua">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-chinh-sua">
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

{{-- MODAL: KỸ NĂNG CHUYÊN MÔN --}}
<div class="modal-overlay" id="modal-ky-nang" role="dialog" aria-modal="true" aria-labelledby="modal-ky-nang-title">
    <div class="modal-panel wide">

        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-ky-nang-title">Chỉnh sửa kỹ năng</div>
                    <div class="modal-subtitle">Chọn ngôn ngữ lập trình và kỹ năng mềm từ danh sách</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-ky-nang" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body">

            {{-- Ngôn ngữ lập trình --}}
            <div class="form-section">
                <div class="form-section-title">
                    Ngôn ngữ & Framework
                    <span class="skill-count-badge" id="count-ngon-ngu" style="display:none;">0</span>
                </div>

                <div class="skill-search-wrapper">
                    <span class="skill-search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" id="search-ngon-ngu" placeholder="Tìm kiếm ngôn ngữ...">
                </div>

                <div class="skill-chips-container" id="chips-ngon-ngu">
                    @foreach($tatCaNgonNgu as $nn)
                        <div class="skill-chip {{ in_array($nn->id, $ngonNguDaChon) ? 'selected' : '' }} {{ in_array($nn->id, $ngonNguNoiBat) ? 'featured' : '' }}"
                             data-id="{{ $nn->id }}">
                            <svg class="skill-chip-check" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            {{ $nn->ten_ngon_ngu }}
                            <div class="skill-chip-star-wrapper" onclick="toggleFeaturedSkill(event, this)">
                                <svg class="skill-chip-star" xmlns="http://www.w3.org/2000/svg" fill="{{ in_array($nn->id, $ngonNguNoiBat) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Kỹ năng mềm --}}
            <div class="form-section">
                <div class="form-section-title">
                    Kỹ năng mềm
                    <span class="skill-count-badge" id="count-ky-nang" style="display:none;">0</span>
                </div>

                <div class="skill-search-wrapper">
                    <span class="skill-search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" id="search-ky-nang" placeholder="Tìm kiếm kỹ năng mềm...">
                </div>

                <div class="skill-chips-container" id="chips-ky-nang">
                    @foreach($tatCaKyNang as $kn)
                        <div class="skill-chip {{ in_array($kn->id, $kyNangDaChon) ? 'selected' : '' }} {{ in_array($kn->id, $kyNangNoiBat) ? 'featured' : '' }}"
                             data-id="{{ $kn->id }}">
                            <svg class="skill-chip-check" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            {{ $kn->ten_ky_nang }}
                            <div class="skill-chip-star-wrapper" onclick="toggleFeaturedSkill(event, this)">
                                <svg class="skill-chip-star" xmlns="http://www.w3.org/2000/svg" fill="{{ in_array($kn->id, $kyNangNoiBat) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- /Modal Body --}}

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Click vào chip để chọn / bỏ chọn kỹ năng (click tiếp vào dấu sao để đánh dấu kỹ năng nổi bật)
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-ky-nang">Huỷ</button>
                <button type="button" class="btn-save" id="btn-luu-ky-nang">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Lưu kỹ năng
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
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
        capNhatCoBan:   "{{ route('ho-so.cap-nhat-co-ban') }}",
        capNhatAvatar:  "{{ route('ho-so.cap-nhat-avatar') }}",
        capNhatKyNang:  "{{ route('ho-so.cap-nhat-ky-nang') }}",
        capNhatLienKet: "{{ route('ho-so.cap-nhat-lien-ket') }}",
    };
</script>

{{-- Cropper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

{{-- JS modules --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}"></script>
<script src="{{ asset('js/ho-so/ky-nang.js') }}"></script>
<script src="{{ asset('js/ho-so/lien-ket.js') }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}"></script>
<script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>

{{-- Inline: nút lưu thông minh theo tab đang active --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Nút "Lưu thay đổi" trong footer chính sẽ lưu tab đang active
    const btnLuuChinhSua = document.getElementById('btn-luu-chinh-sua');
    if (btnLuuChinhSua) {
        btnLuuChinhSua.addEventListener('click', function () {
            const activeTab = document.querySelector('#modal-chinh-sua .modal-tab.active');
            if (!activeTab) return;
            const panel = activeTab.dataset.panel;

            if (panel === 'tab-co-ban') {
                luuThongTinCoBan();
            } else if (panel === 'tab-lien-ket') {
                luuLienKet(this);
            } else if (panel === 'tab-avatar') {
                const cropSection = document.getElementById('crop-section');
                const btnCropApply = document.getElementById('btn-crop-apply');
                if (cropSection && cropSection.classList.contains('visible') && btnCropApply) {
                    btnCropApply.click();
                } else {
                    dongModal('modal-chinh-sua');
                }
            }
        });
    }

    // Hàm mở modal và chuyển tab
    window.moModalTab = function (modalId, panelId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
        modal.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        const targetTab = modal.querySelector(`[data-panel="${panelId}"]`);
        const targetPanel = modal.querySelector(`#${panelId}`);
        if (targetTab) targetTab.classList.add('active');
        if (targetPanel) targetPanel.classList.add('active');
    };
});
    function improveTextWithAI(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input || !input.value.trim()) {
            hienToast('error', 'Vui lòng nhập một ít nội dung trước khi dùng AI.');
            return;
        }

        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳ Đang xử lý...';
        btn.disabled = true;

        fetch('{{ route("ho-so.cv.ai-improve-text") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ text: input.value.trim() })
        })
        .then(res => res.json())
        .then(data => {
            if (data.thanh_cong) {
                input.value = data.improved_text;
                hienToast('success', 'Đã tối ưu văn bản bằng AI thành công!');
                // Trigger change event if needed
                input.dispatchEvent(new Event('input', { bubbles: true }));
            } else {
                throw new Error(data.thong_bao || 'Lỗi hệ thống');
            }
        })
        .catch(err => {
            hienToast('error', err.message);
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
</body>
</html>
