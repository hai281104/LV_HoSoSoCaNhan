@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    $nguoiDung = Auth::user();
    $hoTen = $nguoiDung->ho_ten;
    $thuDienTu = $nguoiDung->email;
    $soDienThoai = $nguoiDung->so_dien_thoai ?? 'Chưa cập nhật';
    $diaChi = $nguoiDung->dia_chi ?? 'Chưa cập nhật';
    $ngaySinh = $nguoiDung->ngay_sinh ? date('d/m/Y', strtotime($nguoiDung->ngay_sinh)) : 'Chưa cập nhật';
    $chucDanh = $nguoiDung->chuc_danh ?? 'Thực tập sinh IT | Sinh viên CNTT';
    $gioiThieu = $nguoiDung->gioi_thieu ?? 'Chưa có thông tin giới thiệu bản thân.';
    $soThich = $nguoiDung->so_thich ?? 'Chưa cập nhật';
    $anhDaiDien = $nguoiDung->anh_dai_dien;

    // Lay chu cai dau lam Avatar neu khong co anh
    $tenRutGon = '';
    if ($hoTen) {
        $cacTu = explode(' ', $hoTen);
        if (count($cacTu) >= 2) {
            $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
        } else {
            $tenRutGon = mb_substr($hoTen, 0, 2);
        }
        $tenRutGon = mb_strtoupper($tenRutGon);
    } else {
        $tenRutGon = 'NV';
    }

    // Truy van ngon ngu lap trinh (Languages & Frameworks)
    $ngonNguLapTrinh = DB::table('nguoi_dung_ngon_ngu_lap_trinh')
        ->join('ngon_ngu_lap_trinh', 'nguoi_dung_ngon_ngu_lap_trinh.ngon_ngu_lap_trinh_id', '=', 'ngon_ngu_lap_trinh.id')
        ->where('nguoi_dung_id', $nguoiDung->id)
        ->pluck('ten_ngon_ngu')
        ->toArray();

    // Truy van ky nang mem (Soft Skills / Tools)
    $kyNangMem = DB::table('nguoi_dung_ky_nang_mem')
        ->join('ky_nang_mem', 'nguoi_dung_ky_nang_mem.ky_nang_mem_id', '=', 'ky_nang_mem.id')
        ->where('nguoi_dung_id', $nguoiDung->id)
        ->pluck('ten_ky_nang')
        ->toArray();

    // Truy van lien ket mang xa hoi
    $lienKetMxh = DB::table('lien_ket_mxh')
        ->where('id_nguoi_dung', $nguoiDung->id)
        ->get();
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - {{ $hoTen }}</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/ho-so/trangchu.css') }}?v={{ time() }}">
</head>
<body>

    <!-- SIDEBAR -->
@include('ho-so.partials.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- HEADER -->
        @include('ho-so.partials.header', ['headerTitle' => 'Hồ sơ cá nhân', 'searchPlaceholder' => 'Tìm kiếm chứng chỉ, kỹ năng..'])

        <!-- CONTENT BODY -->
        <div class="content-body">
            
            <!-- Profile Banner Card -->
            <div class="profile-banner-card">
                <div class="banner-cover"></div>
                <div class="banner-profile-info">
                    <div class="avatar-overlap-wrapper">
                        <div class="avatar-overlap">
                            @if($anhDaiDien)
                                <img src="{{ asset($anhDaiDien) }}" alt="Avatar">
                            @else
                                {{ $tenRutGon }}
                            @endif
                        </div>
                        <span class="status-dot"></span>
                    </div>

                    <div class="profile-name-title">
                        <h2>{{ $hoTen }}</h2>
                        <p>{{ $chucDanh }}</p>
                    </div>

                    <button type="button" class="btn-edit-profile">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span>Chỉnh sửa hồ sơ</span>
                    </button>
                </div>
            </div>

            <!-- Two Column Profile Grid -->
            <div class="profile-grid">
                
                <!-- Column 1 (Left Side) -->
                <div class="grid-column">
                    
                    <!-- Thông tin cơ bản Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Thông tin cơ bản</span>
                            </h3>
                        </div>

                        <div class="basic-info-list">
                            <!-- Ngày sinh -->
                            <div class="basic-info-item">
                                <div class="info-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Ngày sinh</div>
                                    <div class="info-item-value">{{ $ngaySinh }}</div>
                                </div>
                            </div>

                            <!-- Khu vực -->
                            <div class="basic-info-item">
                                <div class="info-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Khu vực</div>
                                    <div class="info-item-value">{{ $diaChi }}</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="basic-info-item">
                                <div class="info-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Email liên hệ</div>
                                    <a href="mailto:{{ $thuDienTu }}" class="info-item-value link">{{ $thuDienTu }}</a>
                                </div>
                            </div>

                            <!-- Điện thoại -->
                            <div class="basic-info-item">
                                <div class="info-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Số điện thoại</div>
                                    <div class="info-item-value">{{ $soDienThoai }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liên kết chuyên môn Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <span>Liên kết chuyên môn</span>
                            </h3>
                            <button type="button" class="card-action-icon" title="Thêm liên kết">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        <div class="social-links-list">
                            @if(count($lienKetMxh) > 0)
                                @foreach($lienKetMxh as $lienKet)
                                    @php
                                        $iconSvg = '';
                                        $domainHienThi = parse_url($lienKet->duong_dan, PHP_URL_HOST) ?? $lienKet->duong_dan;
                                        $labelHienThi = $lienKet->ten_nen_tang;
                                        
                                        // Gan icon tuong ung
                                        if (stripos($lienKet->ten_nen_tang, 'facebook') !== false) {
                                            $iconSvg = '<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />';
                                        } elseif (stripos($lienKet->ten_nen_tang, 'github') !== false) {
                                            $iconSvg = '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />';
                                        } else {
                                            // Fallback link icon
                                            $iconSvg = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />';
                                        }
                                    @endphp
                                    <a href="{{ $lienKet->duong_dan }}" target="_blank" class="social-link-item">
                                        <div class="social-link-info">
                                            <div class="social-logo-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                                                    {!! $iconSvg !!}
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="social-name">{{ $labelHienThi }}</span>
                                                <span class="social-handle">{{ $domainHienThi }}</span>
                                            </div>
                                        </div>
                                        <span class="social-link-external">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </span>
                                    </a>
                                @endforeach
                            @else
                                <!-- Default Mock Social Links -->
                                <a href="https://github.com" target="_blank" class="social-link-item">
                                    <div class="social-link-info">
                                        <div class="social-logo-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="social-name">GitHub Profile</span>
                                            <span class="social-handle">github.com</span>
                                        </div>
                                    </div>
                                    <span class="social-link-external">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </span>
                                </a>

                                <a href="https://linkedin.com" target="_blank" class="social-link-item">
                                    <div class="social-link-info">
                                        <div class="social-logo-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="social-name">LinkedIn Connection</span>
                                            <span class="social-handle">linkedin.com</span>
                                        </div>
                                    </div>
                                    <span class="social-link-external">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Column 2 (Right Side) -->
                <div class="grid-column">
                    
                    <!-- Giới thiệu bản thân Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Giới thiệu bản thân</span>
                            </h3>
                        </div>

                        <div class="intro-text">
                            @if(!empty($gioiThieu))
                                {{ $gioiThieu }}
                            @else
                                <span style="font-style: italic; color: #94a3b8;">Chưa có thông tin giới thiệu bản thân.</span>
                            @endif
                        </div>
                    </div>

                    <!-- Kỹ năng chuyên môn Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Kỹ năng chuyên môn</span>
                            </h3>
                            <a href="#" class="card-action-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Sửa</span>
                            </a>
                        </div>

                        <div class="skill-group-container">
                            <!-- NGÔN NGỮ & FRAMEWORK -->
                            <div>
                                <h4 class="skill-group-title">Ngôn ngữ & Framework</h4>
                                <div class="skill-tags-list">
                                    @if(count($ngonNguLapTrinh) > 0)
                                        @foreach($ngonNguLapTrinh as $ngonNgu)
                                            <div class="skill-tag">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                </svg>
                                                <span>{{ $ngonNgu }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Fallbacks -->
                                        <div class="skill-tag"><span>JavaScript / TS</span></div>
                                        <div class="skill-tag"><span>React & Next.js</span></div>
                                        <div class="skill-tag"><span>PHP & MySQL</span></div>
                                        <div class="skill-tag"><span>Java / Spring Boot</span></div>
                                    @endif
                                </div>
                            </div>

                            <!-- CÔNG CỤ & PHƯƠNG PHÁP (MAPPED FROM SOFT SKILLS / DETAILS) -->
                            <div>
                                <h4 class="skill-group-title">Kỹ năng mềm & Công cụ</h4>
                                <div class="skill-tags-list">
                                    @if(count($kyNangMem) > 0)
                                        @foreach($kyNangMem as $kyNang)
                                            <div class="skill-tag">
                                                <!-- Lightning icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                <span>{{ $kyNang }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Fallbacks -->
                                        <div class="skill-tag"><span>Git & GitHub</span></div>
                                        <div class="skill-tag"><span>DevOps Basis</span></div>
                                        <div class="skill-tag"><span>Agile / Scrum</span></div>
                                        <div class="skill-tag"><span>UI/UX Design</span></div>
                                    @endif
                                </div>
                            </div>

                            <!-- Sở thích -->
                            <div>
                                <h4 class="skill-group-title">Sở thích cá nhân</h4>
                                <div style="font-size: 13px; line-height: 1.6; color: var(--text-secondary); background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px dashed var(--border-color)">
                                    {{ $soThich }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </main>

    <script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>
