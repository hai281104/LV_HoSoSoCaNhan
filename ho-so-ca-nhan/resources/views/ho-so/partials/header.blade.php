<link rel="stylesheet" href="{{ asset('css/ho-so/thong-bao.css') }}?v={{ time() }}">
<script>
    window.API_THONG_BAO_ROUTES = {
        fetch: "{{ route('thong-bao.lay') }}",
        docTatCa: "{{ route('thong-bao.doc-tat-ca') }}",
        docPattern: "{{ route('thong-bao.doc', ['id' => ':id']) }}",
        xoaPattern: "{{ route('thong-bao.xoa', ['id' => ':id']) }}"
    };
</script>
<header class="header">
    <button type="button" class="btn-menu-toggle" id="btn-toggle-sidebar" aria-label="Mở menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
    <h1 class="header-title">{{ $headerTitle ?? 'Hồ sơ cá nhân' }}</h1>
    <div class="header-actions">
        <div class="search-box" @if(isset($disableSearch) && $disableSearch) style="opacity: 0.45; pointer-events: none; cursor: not-allowed;" @endif>
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" class="search-input" id="main-search-input" placeholder="" @if(isset($disableSearch) && $disableSearch) disabled @endif>
        </div>

        {{-- NOTIFICATION BELL --}}
        <div class="notif-wrapper" id="notif-wrapper">
            <button type="button" class="btn-notification" id="notif-btn" aria-expanded="false" aria-label="Thông báo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="notif-badge" id="notif-badge" style="display:none;"></span>
            </button>

            {{-- Dropdown --}}
            <div class="notif-dropdown" id="notif-dropdown">
                <div class="notif-header">
                    <span class="notif-header-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Thông báo
                    </span>
                    <button type="button" class="notif-read-all-btn" onclick="docTatCaThongBao()" title="Đánh dấu tất cả đã đọc">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Đọc tất cả
                    </button>
                </div>
                <div class="notif-list" id="notif-list">
                    <div class="notif-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="40" height="40">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p>Đang tải thông báo...</p>
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="{{ route('ho-so.nhat-ky') }}" class="notif-footer-link">
                        Xem nhật ký hoạt động
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        {{-- END NOTIFICATION BELL --}}
    </div>
</header>

