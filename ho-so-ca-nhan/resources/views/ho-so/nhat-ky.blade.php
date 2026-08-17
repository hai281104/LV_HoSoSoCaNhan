<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hoạt động & Nhật ký - {{ $hoTen }}</title>
    <meta name="description" content="Theo dõi lịch sử truy cập, các thao tác chỉnh sửa hồ sơ và nhật ký bảo mật của bạn.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/nhat-ky.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Hoạt động & Nhật ký', 'searchPlaceholder' => 'Tìm kiếm nhật ký...'])

    {{-- Content Body --}}
    <div class="content-body">

        {{-- Header Card --}}
        <div class="log-header-card">
            <div class="log-title-section">
                <h2>Hoạt động & Nhật ký</h2>
                <p>Theo dõi lịch sử truy cập, các thao tác chỉnh sửa hồ sơ và nhật ký bảo mật của bạn.</p>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="log-stats-grid">
            <div class="log-stat-card">
                <div class="log-stat-icon all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="log-stat-info">
                    <span class="log-stat-value">{{ $soTong }}</span>
                    <span class="log-stat-label">Tổng số hoạt động</span>
                </div>
            </div>

            <div class="log-stat-card">
                <div class="log-stat-icon truy-cap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="log-stat-info">
                    <span class="log-stat-value">{{ $soTruyCap }}</span>
                    <span class="log-stat-label">Lịch sử truy cập</span>
                </div>
            </div>

            <div class="log-stat-card">
                <div class="log-stat-icon chinh-sua">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="log-stat-info">
                    <span class="log-stat-value">{{ $soChinhSua }}</span>
                    <span class="log-stat-label">Chỉnh sửa hồ sơ</span>
                </div>
            </div>

            <div class="log-stat-card">
                <div class="log-stat-icon bao-mat">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="log-stat-info">
                    <span class="log-stat-value">{{ $soBaoMat }}</span>
                    <span class="log-stat-label">Nhật ký bảo mật</span>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="log-filter-bar">
            <div class="log-tabs">
                <a href="{{ route('ho-so.nhat-ky') }}" class="log-tab {{ !$loai ? 'active' : '' }}">
                    Tất cả
                </a>
                <a href="{{ route('ho-so.nhat-ky', ['loai' => 'truy_cap']) }}" class="log-tab {{ $loai === 'truy_cap' ? 'active' : '' }}">
                    Truy cập
                </a>
                <a href="{{ route('ho-so.nhat-ky', ['loai' => 'chinh_sua']) }}" class="log-tab {{ $loai === 'chinh_sua' ? 'active' : '' }}">
                    Chỉnh sửa hồ sơ
                </a>
                <a href="{{ route('ho-so.nhat-ky', ['loai' => 'bao_mat']) }}" class="log-tab {{ $loai === 'bao_mat' ? 'active' : '' }}">
                    Bảo mật
                </a>
            </div>

            @if($soTong > 0)
                <button type="button" class="btn-clear-logs" id="btn-clear-logs-history">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Xóa lịch sử</span>
                </button>
            @endif
        </div>

        {{-- Card khi không tìm thấy kết quả lọc --}}
        <div id="no-filter-results" class="no-results-card" style="display: none; margin-bottom: 24px;">
            <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            <h3 class="no-results-title">Không tìm thấy thông tin phù hợp</h3>
            <p class="no-results-desc">Vui lòng thử lại với các tiêu chí bộ lọc khác hoặc đặt lại bộ lọc.</p>
        </div>

        {{-- Log Feed --}}
        <div class="log-feed" id="log-items-container">
            @forelse($danhSachLog as $log)
                <div class="log-item {{ $log->loai_hoat_dong }}" data-desc="{{ $log->mo_ta }}">
                    <div class="log-item-icon">
                        @if($log->loai_hoat_dong === 'truy_cap')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        @elseif($log->loai_hoat_dong === 'chinh_sua')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        @endif
                    </div>

                    <div class="log-item-body">
                        <div class="log-item-header">
                            <span class="log-item-desc">
                                {!! preg_replace('/(\'(.*?)\'|"(.*?)"|ID: \d+|CV: .*?)/u', '<strong>$1</strong>', e($log->mo_ta)) !!}
                            </span>
                            <span class="log-item-time" title="{{ \Carbon\Carbon::parse($log->ngay_tao)->format('d/m/Y H:i:s') }}">
                                {{ \Carbon\Carbon::parse($log->ngay_tao)->diffForHumans() }}
                            </span>
                        </div>

                        <div class="log-item-meta">
                            <span class="log-badge badge-{{ $log->loai_hoat_dong }}">
                                @if($log->loai_hoat_dong === 'truy_cap')
                                    Truy cập
                                @elseif($log->loai_hoat_dong === 'chinh_sua')
                                    Chỉnh sửa
                                @else
                                    Bảo mật
                                @endif
                            </span>

                            <span class="log-meta-item" title="Địa chỉ IP thực hiện">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>{{ $log->ip_dia_chi ?? 'N/A' }}</span>
                            </span>

                            @if($log->thiet_bi)
                                <span class="log-meta-item" title="{{ $log->thiet_bi }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>
                                        @php
                                            $ua = $log->thiet_bi;
                                            $shortUa = 'Thiết bị';
                                            if (stripos($ua, 'mobi') !== false) {
                                                $shortUa = 'Mobile Device';
                                            } elseif (stripos($ua, 'windows') !== false) {
                                                $shortUa = 'Windows PC';
                                            } elseif (stripos($ua, 'macintosh') !== false || stripos($ua, 'mac os') !== false) {
                                                $shortUa = 'macOS Device';
                                            } elseif (stripos($ua, 'linux') !== false) {
                                                $shortUa = 'Linux Device';
                                            }
                                            
                                            if (stripos($ua, 'chrome') !== false) {
                                                $shortUa .= ' (Chrome)';
                                            } elseif (stripos($ua, 'firefox') !== false) {
                                                $shortUa .= ' (Firefox)';
                                            } elseif (stripos($ua, 'safari') !== false) {
                                                $shortUa .= ' (Safari)';
                                            } elseif (stripos($ua, 'edge') !== false) {
                                                $shortUa .= ' (Edge)';
                                            }
                                        @endphp
                                        {{ $shortUa }}
                                    </span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="log-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="log-empty-title">Không có hoạt động nào</div>
                    <div class="log-empty-desc">Chưa ghi nhận hoạt động nào tương ứng với bộ lọc này.</div>
                </div>
            @endforelse
        </div>

        {{-- Custom Pagination --}}
        @if($danhSachLog->hasPages())
            <div class="pagination-wrapper">
                <div class="custom-pagination">
                    {{-- Nút trang trước --}}
                    @if($danhSachLog->onFirstPage())
                        <span class="page-link disabled">&laquo;</span>
                    @else
                        <a href="{{ $danhSachLog->previousPageUrl() }}" class="page-link">&laquo;</a>
                    @endif

                    {{-- Các số trang --}}
                    @php
                        $start = max(1, $danhSachLog->currentPage() - 2);
                        $end = min($danhSachLog->lastPage(), $danhSachLog->currentPage() + 2);
                    @endphp
                    
                    @if($start > 1)
                        <a href="{{ $danhSachLog->url(1) }}" class="page-link">1</a>
                        @if($start > 2)
                            <span class="page-link disabled">...</span>
                        @endif
                    @endif

                    @foreach(range($start, $end) as $i)
                        @if($i == $danhSachLog->currentPage())
                            <span class="page-link active">{{ $i }}</span>
                        @else
                            <a href="{{ $danhSachLog->url($i) }}" class="page-link">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($end < $danhSachLog->lastPage())
                        @if($end < $danhSachLog->lastPage() - 1)
                            <span class="page-link disabled">...</span>
                        @endif
                        <a href="{{ $danhSachLog->url($danhSachLog->lastPage()) }}" class="page-link">{{ $danhSachLog->lastPage() }}</a>
                    @endif

                    {{-- Nút trang sau --}}
                    @if($danhSachLog->hasMorePages())
                        <a href="{{ $danhSachLog->nextPageUrl() }}" class="page-link">&raquo;</a>
                    @else
                        <span class="page-link disabled">&raquo;</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
</main>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JS Scripts --}}
<script>
    window.ROUTES = {
        xoaNhatKy: "{{ route('ho-so.nhat-ky.xoa') }}",
        nhatKy: "{{ route('ho-so.nhat-ky') }}"
    };
</script>
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/nhat-ky/nhat-ky.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

