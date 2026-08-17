@php
    // Dùng $nguoiDung (Eloquent User model) thay vì $profileData['nguoiDung'] để tránh lỗi stdClass
    $user = $nguoiDung;
    $avatar = $user->anh_dai_dien ?? null;
    $primaryColor = '#1e3a8a';
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hồ sơ năng lực - {{ $user->ho_ten }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}?v=10.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/ho-so/xem-truoc-in.css') }}?v={{ time() }}">
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
        }
    </style>
</head>
<body>

<div class="standalone-toolbar" id="standalone-toolbar">
    <a href="{{ route('ho-so.chia-se') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Quay lại
    </a>
    
    <div class="toolbar-actions">
        <button class="btn-action print-pdf" onclick="downloadPdfDirectly()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Tải xuống PDF
        </button>
    </div>
</div>

<div class="page-preview-wrapper">
    <div class="a4-page-container">
        <div class="cv-document">
            {{-- Têu tài liệu (duyên hóa, và để test có thể nhận diện) --}}
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="display: inline-block; border: 2px solid var(--primary-color); padding: 6px 24px; border-radius: 4px; margin-bottom: 12px;">
                    <h1 style="font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--primary-color); margin: 0;">HỒ SƠ NĂNG LỰC CÁ NHÂN</h1>
                </div>
            </div>
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
                    <h1 class="cv-name">{{ $user->ho_ten }}</h1>
                    @if($user->chuc_danh)
                        <h2 class="cv-title">{{ $user->chuc_danh }}</h2>
                    @endif
                    
                    <div class="cv-contact-grid">
                        @if($user->so_dien_thoai)
                            <div class="cv-contact-item" title="Số điện thoại">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $user->so_dien_thoai }}</span>
                            </div>
                        @endif
                        @if($user->email)
                            <div class="cv-contact-item" title="Thư điện tử">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ $user->email }}</span>
                            </div>
                        @endif
                        @if($user->dia_chi)
                            <div class="cv-contact-item" title="Địa chỉ sinh sống">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $user->dia_chi }}</span>
                            </div>
                        @endif
                        @if($user->ngay_sinh)
                            <div class="cv-contact-item" title="Ngày sinh">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ date('d/m/Y', strtotime($user->ngay_sinh)) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Biography --}}
            @if($user->gioi_thieu)
                <div class="cv-section">
                    <h3 class="cv-section-title">Giới thiệu bản thân</h3>
                    <p class="cv-intro-text">{{ $user->gioi_thieu }}</p>
                </div>
            @endif

            {{-- HỌC VẤN --}}
            @if(count($profileData['hocVan']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Học vấn & Bằng cấp</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['hocVan'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">{{ $item->tieu_de }}</h4>
                                        <div class="cv-timeline-subtitle">{{ $item->ten_truong }}</div>
                                    </div>
                                    <span class="cv-timeline-date">
                                        {{ $item->nam_bat_dau }} - {{ ($item->trang_thai === 'dang_hoc') ? 'Nay' : $item->nam_ket_thuc }}
                                    </span>
                                </div>
                                <div class="cv-timeline-details">
                                    @if($item->khoa) <span>Khoa: {{ $item->khoa }}</span> @endif
                                    @if($item->nganh) <span>Ngành: {{ $item->nganh }}</span> @endif
                                    @if($item->xep_loai) <span>Xếp loại: {{ $item->xep_loai }}</span> @endif
                                    @if($item->gpa) <span>GPA: {{ $item->gpa }}</span> @endif
                                </div>
                                @if($item->mo_ta)
                                    <p class="cv-timeline-desc">{{ $item->mo_ta }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- KINH NGHIỆM LÀM VIỆC --}}
            @if(count($profileData['kinhNghiem']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Kinh nghiệm làm việc</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['kinhNghiem'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">{{ $item->vi_tri_cong_viec }}</h4>
                                        <div class="cv-timeline-subtitle">{{ $item->ten_cong_ty }}</div>
                                    </div>
                                    <span class="cv-timeline-date">
                                        {{ date('m/Y', strtotime($item->ngay_bat_dau)) }} - {{ $item->dang_lam_viec ? 'Nay' : date('m/Y', strtotime($item->ngay_ket_thuc)) }}
                                    </span>
                                </div>
                                @if($item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc">{{ $item->mo_ta_chi_tiet }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- DỰ ÁN --}}
            @if(count($profileData['duAn']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Dự án / Portfolio</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['duAn'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">{{ $item->ten_du_an }}</h4>
                                        <div class="cv-timeline-subtitle">{{ $item->vai_tro }}</div>
                                    </div>
                                    <span class="cv-timeline-date">
                                        {{ date('m/Y', strtotime($item->ngay_bat_dau)) }} - {{ ($item->ngay_ket_thuc ?? null) ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Nay' }}
                                    </span>
                                </div>
                                @if($item->lien_ket)
                                    <div class="cv-timeline-details">
                                        <span>Liên kết: <a href="{{ $item->lien_ket }}" target="_blank" class="text-blue-600 hover:underline">{{ $item->lien_ket }}</a></span>
                                    </div>
                                @endif
                                @if($item->mo_ta_chi_tiet)
                                    <p class="cv-timeline-desc">{{ $item->mo_ta_chi_tiet }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CHỨNG CHỈ --}}
            @if(count($profileData['chungChi']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Chứng chỉ & Khóa học</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['chungChi'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">{{ $item->ten_chung_chi }}</h4>
                                        <div class="cv-timeline-subtitle">{{ $item->to_chuc_cap }}</div>
                                    </div>
                                    <span class="cv-timeline-date">
                                        {{ date('m/Y', strtotime($item->ngay_cap)) }}
                                    </span>
                                </div>
                                @if(isset($item->ghi_chu) && $item->ghi_chu)
                                    <p class="cv-timeline-desc">{{ $item->ghi_chu }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- THANH TỰU --}}
            @if(count($profileData['thanhTuu']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Thành tựu & Giải thưởng</h3>
                    <div class="cv-timeline-list">
                        @foreach($profileData['thanhTuu'] as $item)
                            <div class="cv-timeline-item">
                                <div class="cv-timeline-header">
                                    <div>
                                        <h4 class="cv-timeline-title">{{ $item->ten_thanh_tuu }}</h4>
                                        <div class="cv-timeline-subtitle">{{ $item->to_chuc_cap }}</div>
                                    </div>
                                    <span class="cv-timeline-date">
                                        {{ $item->thoi_gian ? date('m/Y', strtotime($item->thoi_gian)) : 'N/A' }}
                                    </span>
                                </div>
                                @if($item->mo_ta)
                                    <p class="cv-timeline-desc">{{ $item->mo_ta }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- KỸ NĂNG --}}
            @if(count($profileData['ngonNgu']) > 0 || count($profileData['kyNang']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Kỹ năng</h3>
                    
                    @if(count($profileData['ngonNgu']) > 0)
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 600; font-size: 13px; color: var(--text-dark); margin-bottom: 6px;">Ngôn ngữ lập trình / Công nghệ:</div>
                            <div class="cv-pill-container">
                                @foreach($profileData['ngonNgu'] as $item)
                                    <span class="cv-pill">{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($profileData['kyNang']) > 0)
                        <div>
                            <div style="font-weight: 600; font-size: 13px; color: var(--text-dark); margin-bottom: 6px;">Kỹ năng mềm:</div>
                            <div class="cv-pill-container">
                                @foreach($profileData['kyNang'] as $item)
                                    <span class="cv-pill">{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- SỞ THÍCH CÁ NHÂN --}}
            @if($user->so_thich)
                <div class="cv-section">
                    <h3 class="cv-section-title">Sở thích cá nhân</h3>
                    <p class="cv-intro-text">{{ $user->so_thich }}</p>
                </div>
            @endif

            {{-- LIÊN KẾT --}}
            @if(count($profileData['lienKetMxh']) > 0)
                <div class="cv-section">
                    <h3 class="cv-section-title">Mạng xã hội & Liên kết</h3>
                    <div class="cv-links-list">
                        @foreach($profileData['lienKetMxh'] as $item)
                            <div class="cv-link-card">
                                <strong>{{ $item->ten_nen_tang }}:</strong>
                                <a href="{{ $item->duong_dan }}" target="_blank">{{ $item->duong_dan }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    window.CV_CONFIG = {
        fileName: 'Ho-so-nang-luc-{{ Str::slug($user->ho_ten, "-") }}.pdf'
    };
</script>
<script src="{{ asset('js/ho-so/xem-truoc-in.js') }}?v={{ time() }}"></script>
</body>
</html>
