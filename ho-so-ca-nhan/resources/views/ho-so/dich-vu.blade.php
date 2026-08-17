@php
    $catMap = [
        'lap_trinh_web' => 'Lập trình Web',
        'toi_uu_sql' => 'Tối ưu SQL/Database',
        'thiet_ke_uiux' => 'Thiết kế UI/UX',
        'lap_trinh_mobile' => 'Lập trình Mobile',
        'devops_cloud' => 'DevOps & Cloud',
        'kiem_thu' => 'Kiểm thử phần mềm',
        'an_ninh_mang' => 'An ninh mạng / Bảo mật',
        'phan_tich_du_lieu' => 'Phân tích dữ liệu (Data Analysis)',
        'tri_tue_nhan_tao' => 'Trí tuệ nhân tạo (AI/Machine Learning)',
        'viet_lach_content' => 'Viết lách / Biên dịch content',
        'quan_tri_du_an' => 'Quản trị dự án (Project Management)',
        'khac' => 'Lĩnh vực khác'
    ];
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dịch vụ cá nhân - {{ $hoTen }}</title>
    <meta name="description" content="Quản lý và đăng tải dịch vụ cá nhân, tìm kiếm cơ hội hợp tác và kết nối cộng đồng.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/dich-vu.css') }}?v={{ time() }}">
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Dịch vụ cá nhân', 'searchPlaceholder' => 'Tìm kiếm dịch vụ...', 'disableSearch' => true])

    {{-- Content Body --}}
    <div class="content-body">
        
        {{-- Tabs Navigation --}}
        <div class="tab-container">
            <div class="tabs-list">
                <button type="button" class="tab-btn active" data-tab="tab-ca-nhan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tab-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>Dịch vụ của tôi</span>
                </button>
                <button type="button" class="tab-btn" data-tab="tab-cong-dong">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tab-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Cộng đồng</span>
                </button>
            </div>
        </div>

        {{-- TAB: CÁ NHÂN (MY SERVICES) --}}
        <div class="tab-panel active" id="tab-ca-nhan">
            <div class="service-header-card">
                <div class="service-header-info">
                    <h2>Danh sách dịch vụ đã đăng ký</h2>
                    <p>Bạn có thể tạo tối đa các gói dịch vụ giới thiệu năng lực bản thân kèm theo thông tin Zalo, Gmail và đính kèm CV đã thiết kế.</p>
                </div>
                <button type="button" class="btn-action-sm primary" onclick="moModalDichVu(null)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:2.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Thêm dịch vụ</span>
                </button>
            </div>

            @if($dichVuCaNhan->count() > 0)
                {{-- Sub-tabs for filtering personal services --}}
                <div class="sub-tab-container">
                    <button type="button" class="sub-tab-btn active" data-sub-tab="all">
                        Tất cả ({{ $dichVuCaNhan->count() }})
                    </button>
                    <button type="button" class="sub-tab-btn" data-sub-tab="hien-thi">
                        Đang hiển thị ({{ $dichVuCaNhan->where('trang_thai_duyet', 1)->where('trang_thai', 1)->count() }})
                    </button>
                    <button type="button" class="sub-tab-btn" data-sub-tab="dang-an">
                        Đang ẩn ({{ $dichVuCaNhan->where('trang_thai_duyet', 1)->where('trang_thai', 0)->count() }})
                    </button>
                    <button type="button" class="sub-tab-btn" data-sub-tab="cho-duyet">
                        Chờ duyệt ({{ $dichVuCaNhan->where('trang_thai_duyet', 0)->count() }})
                    </button>
                    <button type="button" class="sub-tab-btn" data-sub-tab="tu-choi">
                        Bị từ chối ({{ $dichVuCaNhan->where('trang_thai_duyet', 2)->count() }})
                    </button>
                </div>

                {{-- Personal Filter, Search & Sort --}}
                <div class="filter-card">
                    <div class="filter-row">
                        <div class="filter-col">
                            <input type="text" id="search-personal-service" class="filter-input" placeholder="🔍 Tìm tên dịch vụ, mô tả...">
                        </div>
                        <div class="filter-col" style="max-width: 240px;">
                            <select id="filter-personal-category" class="filter-input">
                                <option value="">-- Tất cả lĩnh vực --</option>
                                @foreach($catMap as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-col" style="max-width: 185px;">
                            <select id="sort-personal" class="filter-input">
                                <option value="newest">🕒 Mới nhất trước</option>
                                <option value="oldest">📅 Cũ nhất trước</option>
                            </select>
                        </div>
                        <div style="flex-shrink: 0;">
                            <button type="button" id="btn-reset-personal-filters" class="btn-reset-filters">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                <span>Đặt lại</span>
                            </button>
                        </div>
                    </div>
                    <div style="margin-top:10px; font-size:12px; color:var(--text-secondary); display:flex; align-items:center; gap:5px;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Tìm thấy <strong><span id="personal-result-count">{{ $dichVuCaNhan->count() }}</span></strong> dịch vụ của tôi
                    </div>
                </div>
            @endif

            @if($dichVuCaNhan->count() === 0)
                <div class="empty-services">
                    <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3>Chưa đăng ký dịch vụ nào</h3>
                    <p>Đăng tải dịch vụ cá nhân của bạn để các nhà tuyển dụng hoặc người dùng khác dễ dàng tìm kiếm và kết nối trực tiếp qua Zalo/Gmail.</p>
                    <button type="button" class="btn-action-sm primary" onclick="moModalDichVu(null)">Đăng ký ngay dịch vụ đầu tiên</button>
                </div>
            @else
                <div class="services-grid" id="personal-services-grid">
                    @foreach($dichVuCaNhan as $dv)
                        @php $zaloPhone = preg_replace('/[^0-9]/', '', $dv->zalo); @endphp
                        <div class="service-card {{ !$dv->trang_thai ? 'is-hidden' : '' }}" 
                             id="card-service-{{ $dv->id }}" 
                             data-status="{{ $dv->trang_thai }}" 
                             data-approval="{{ $dv->trang_thai_duyet }}"
                             data-date="{{ $dv->ngay_cap_nhat }}" 
                             onclick="moModalChiTietDichVu({{ json_encode($dv) }}, true)">
                            <div class="service-header">
                                <div class="service-title-section">
                                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                        <h3 class="service-title">{{ $dv->ten_dich_vu }}</h3>
                                        @if($dv->trang_thai_duyet == 0)
                                            <span class="approval-badge pending">Chờ duyệt</span>
                                        @elseif($dv->trang_thai_duyet == 2)
                                            <span class="approval-badge rejected" title="{{ $dv->ly_do_tu_choi ? 'Lý do: ' . $dv->ly_do_tu_choi : 'Bị từ chối' }}">Bị từ chối</span>
                                        @else
                                            @if(!$dv->trang_thai)
                                                <span class="hidden-badge">Đang ẩn</span>
                                            @else
                                                <span class="approval-badge approved">Đang hiển thị</span>
                                            @endif
                                        @endif
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-top:4px;">
                                        <span class="category-badge {{ $dv->phan_loai }}">{{ $catMap[$dv->phan_loai] ?? 'Lĩnh vực khác' }}</span>
                                        <span style="font-size:11px; color:var(--text-secondary);">Cập nhật: {{ date('H:i d/m/Y', strtotime($dv->ngay_cap_nhat)) }}</span>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                    {{-- Toggle visibility (only if approved) --}}
                                    @if($dv->trang_thai_duyet == 1)
                                        <button type="button" class="btn-card-icon {{ $dv->trang_thai ? 'eye-on' : 'eye-off' }}"
                                            id="toggle-btn-{{ $dv->id }}"
                                            title="{{ $dv->trang_thai ? 'Đang hiển thị cộng đồng — Click để ẩn' : 'Đang ẩn — Click để hiển thị cộng đồng' }}"
                                            onclick="event.stopPropagation(); doiTrangThaiDichVu({{ $dv->id }})">
                                            @if($dv->trang_thai)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                            @endif
                                        </button>
                                    @endif
                                    {{-- Edit --}}
                                    <button type="button" class="btn-card-icon" title="Chỉnh sửa" onclick="event.stopPropagation(); moModalDichVu({{ json_encode($dv) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 15px; height: 15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    {{-- Delete --}}
                                    <button type="button" class="btn-card-icon delete" title="Xóa" onclick="event.stopPropagation(); xoaDichVu({{ $dv->id }}, '{{ addslashes($dv->ten_dich_vu) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 15px; height: 15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="service-desc">{{ $dv->mo_ta }}</div>

                            @if($dv->trang_thai_duyet == 2 && !empty($dv->ly_do_tu_choi))
                                <div class="rejection-reason" style="margin-bottom: 20px;" onclick="event.stopPropagation();">
                                    <strong>Lý do từ chối:</strong> {{ $dv->ly_do_tu_choi }}
                                </div>
                            @endif


                            <div class="service-contacts">
                                <div class="contact-item">
                                    <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span class="contact-label">Zalo:</span>
                                    <span class="contact-val"><a href="https://zalo.me/{{ $zaloPhone }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();">{{ $dv->zalo }}</a></span>
                                </div>
                                <div class="contact-item">
                                    <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="contact-label">Gmail:</span>
                                    <span class="contact-val"><a href="mailto:{{ $dv->gmail }}" onclick="event.stopPropagation();">{{ $dv->gmail }}</a></span>
                                </div>
                            </div>

                            <div class="service-actions">
                                @if($dv->id_cv)
                                    <a href="{{ route('ho-so.dich-vu.xem-cv', $dv->id) }}" target="_blank" class="btn-action-sm outline" style="width: 100%; justify-content: center;" onclick="event.stopPropagation();">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Xem CV đính kèm: {{ $dv->ten_cv ?: 'Bản đính kèm' }}</span>
                                    </a>
                                @else
                                    <span style="font-size:11.5px;color:#94a3b8;font-style:italic;text-align:center;width:100%;display:inline-block;padding:8px 0;">Không đính kèm CV</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="personal-pagination-container" class="service-pagination-container" style="display: none;"></div>

                {{-- No search results card for personal --}}
                <div id="no-personal-results" class="empty-services" style="display: none; margin: 40px auto;">
                    <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <h3>Không tìm thấy dịch vụ nào</h3>
                    <p>Không có kết quả nào trùng khớp với bộ lọc tìm kiếm của bạn. Hãy thử đổi từ khóa hoặc bộ lọc khác.</p>
                </div>
            @endif
        </div>

        {{-- TAB: CỘT ĐỒNG (COMMUNITY SERVICES) --}}
        <div class="tab-panel" id="tab-cong-dong">
            
            {{-- Filter, Search & Sort --}}
            <div class="filter-card">
                <div class="filter-row">
                    <div class="filter-col">
                        <input type="text" id="search-community-service" class="filter-input" placeholder="🔍 Tìm tên dịch vụ, người dùng, từ khóa...">
                    </div>
                    <div class="filter-col" style="max-width: 240px;">
                        <select id="filter-community-category" class="filter-input">
                            <option value="">-- Tất cả lĩnh vực --</option>
                            @foreach($catMap as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-col" style="max-width: 185px;">
                        <select id="sort-community" class="filter-input">
                            <option value="newest">🕒 Mới nhất trước</option>
                            <option value="oldest">📅 Cũ nhất trước</option>
                        </select>
                    </div>
                    <div style="flex-shrink: 0;">
                        <button type="button" id="btn-reset-community-filters" class="btn-reset-filters">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                            <span>Đặt lại</span>
                        </button>
                    </div>
                </div>
                <div style="margin-top:10px; font-size:12px; color:var(--text-secondary); display:flex; align-items:center; gap:5px;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Tìm thấy <strong><span id="community-result-count">{{ $dichVuCongDong->count() }}</span></strong> dịch vụ từ cộng đồng
                </div>
            </div>

            @if($dichVuCongDong->count() === 0)
                <div class="empty-services">
                    <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <h3>Chưa có dịch vụ cộng đồng nào</h3>
                    <p>Hiện tại chưa có dịch vụ nào từ những người dùng khác được xuất bản lên cộng đồng. Hãy quay lại sau.</p>
                </div>
            @else
                <div class="services-grid" id="community-services-container">
                    @foreach($dichVuCongDong as $dv)
                        @php
                            $init = '';
                            if ($dv->ten_nguoi_dung) {
                                $words = explode(' ', trim($dv->ten_nguoi_dung));
                                if (count($words) >= 2) {
                                    $init = mb_substr($words[count($words)-2], 0, 1) . mb_substr($words[count($words)-1], 0, 1);
                                } else {
                                    $init = mb_substr($dv->ten_nguoi_dung, 0, 2);
                                }
                                $init = mb_strtoupper($init);
                            } else {
                                $init = 'ND';
                            }
                            // Clean Zalo phone for link
                            $zaloCleanPhone = preg_replace('/[^0-9]/', '', $dv->zalo);
                        @endphp
                        <div class="service-card community-card" 
                             data-service-title="{{ strtolower($dv->ten_dich_vu) }}"
                             data-provider-name="{{ strtolower($dv->ten_nguoi_dung) }}"
                             data-desc="{{ strtolower($dv->mo_ta) }}"
                             data-category="{{ $dv->phan_loai }}"
                             data-date="{{ $dv->ngay_cap_nhat }}"
                             onclick="moModalChiTietDichVu({{ json_encode($dv) }}, false)">
                            
                            {{-- Provider Profile Info Header --}}
                            <div class="service-provider">
                                <div class="provider-avatar">
                                    @if($dv->anh_nguoi_dung)
                                        <img src="{{ asset($dv->anh_nguoi_dung) }}" alt="Avatar">
                                    @else
                                        <span>{{ $init }}</span>
                                    @endif
                                </div>
                                <div class="provider-info">
                                    <span class="provider-name">{{ $dv->ten_nguoi_dung }}</span>
                                    <span class="provider-role">{{ $dv->chuc_danh_nguoi_dung ?: 'Thành viên' }}</span>
                                </div>
                            </div>

                            <div class="service-header">
                                <div class="service-title-section">
                                    <h3 class="service-title">{{ $dv->ten_dich_vu }}</h3>
                                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-top:4px;">
                                        <span class="category-badge {{ $dv->phan_loai }}">{{ $catMap[$dv->phan_loai] ?? 'Lĩnh vực khác' }}</span>
                                        <span style="font-size:11px; color:var(--text-secondary);">Cập nhật: {{ date('H:i d/m/Y', strtotime($dv->ngay_cap_nhat)) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="service-desc">{{ $dv->mo_ta }}</div>
                            
                            <div class="service-contacts">
                                <div class="contact-item">
                                    <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span class="contact-label">Zalo:</span>
                                    <span class="contact-val">{{ $dv->zalo }}</span>
                                </div>
                                <div class="contact-item">
                                    <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="contact-label">Gmail:</span>
                                    <span class="contact-val">{{ $dv->gmail }}</span>
                                </div>
                            </div>

                            <div class="service-actions" style="grid-template-columns: repeat({{ $dv->id_cv ? '3' : '2' }}, 1fr); display: grid; gap: 8px; border-top: 1px solid var(--border-color); padding-top:16px;">
                                <a href="https://zalo.me/{{ $zaloCleanPhone }}" target="_blank" rel="noopener noreferrer" class="btn-action-sm outline" style="justify-content: center; font-size:11px; padding: 7px 4px;" onclick="event.stopPropagation();">
                                    💬 Liên hệ Zalo
                                </a>
                                <a href="mailto:{{ $dv->gmail }}" class="btn-action-sm outline" style="justify-content: center; font-size:11px; padding: 7px 4px;" onclick="event.stopPropagation();">
                                    ✉️ Gửi Email
                                </a>
                                @if($dv->id_cv)
                                    <a href="{{ route('ho-so.dich-vu.xem-cv', $dv->id) }}" target="_blank" class="btn-action-sm primary" style="justify-content: center; font-size:11px; padding: 7px 4px;" onclick="event.stopPropagation();">
                                        📄 Xem CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="community-pagination-container" class="service-pagination-container" style="display: none;"></div>
                
                {{-- No search results card --}}
                <div id="no-community-results" class="empty-services" style="display: none; margin: 40px auto;">
                    <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <h3>Không tìm thấy dịch vụ nào</h3>
                    <p>Không có kết quả nào trùng khớp với từ khóa tìm kiếm của bạn. Hãy thử một từ khóa khác.</p>
                </div>
            @endif
        </div>

    </div>
</main>

{{-- MODAL: ĐĂNG KÝ / CẬP NHẬT DỊCH VỤ CÁ NHÂN --}}
<div class="modal-overlay" id="modal-dich-vu" role="dialog" aria-modal="true" aria-labelledby="modal-dich-vu-title">
    <div class="modal-panel">

        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-dich-vu-title">Đăng ký dịch vụ mới</div>
                    <div class="modal-subtitle">Diền thông tin dịch vụ, liên hệ và đính kèm CV nếu cần</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-dich-vu" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <form id="form-dich-vu" autocomplete="off">
                <input type="hidden" id="input-service-id" name="id">

                {{-- Section 1: Thông tin dịch vụ --}}
                <div class="form-section">
                    <div class="form-section-title">Thông tin dịch vụ</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input-service-title">Tên dịch vụ / sự kiện <span class="required">*</span></label>
                            <input type="text" id="input-service-title" name="ten_dich_vu" class="form-input" required
                                placeholder="VD: Lập trình website, Dịch thuật Anh-Việt..."
                                minlength="2" maxlength="50">
                            <div class="form-hint" style="display:flex; justify-content:space-between; font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                <span>* Từ 2 đến 50 ký tự, không chứa ký tự đặc biệt nguy hiểm.</span>
                                <span id="title-counter-wrap"><span id="title-counter">0</span>/50</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-service-category">Lĩnh vực chuyên môn <span class="required">*</span></label>
                            <select id="input-service-category" name="phan_loai" class="form-input" required>
                                @foreach($catMap as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Lĩnh vực hoạt động phù hợp của dịch vụ.</span>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 14px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                            <label class="form-label" for="input-service-desc" style="margin-bottom:0;">Mô tả chi tiết <span class="required">*</span></label>
                            <span style="font-size:11px; color:#94a3b8;"><span id="desc-counter">0</span>/2000 ký tự</span>
                        </div>
                        <textarea id="input-service-desc" name="mo_ta" class="form-textarea tall" required
                            placeholder="Mô tả cụ thể về gói dịch vụ, chuyên môn, kinh nghiệm và những gì bạn sẽ cung cấp..."
                            maxlength="2000"></textarea>
                        <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Mô tả chi tiết về dịch vụ (tối đa 2000 ký tự).</span>
                    </div>
                </div>

                {{-- Section 2: Thông tin liên hệ --}}
                <div class="form-section">
                    <div class="form-section-title">Thông tin liên hệ</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input-service-zalo">Số điện thoại Zalo <span class="required">*</span></label>
                            <input type="tel" id="input-service-zalo" name="zalo" class="form-input" required
                                placeholder="0912345678 hoặc +84912345678"
                                maxlength="13"
                                title="Số Zalo phải đúng định dạng VD: 0912345678 hoặc +84912345678">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Số điện thoại Zalo của Việt Nam (VD: 0912345678 hoặc +84912345678).</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-service-gmail">Email liên hệ <span class="required">*</span></label>
                            <input type="email" id="input-service-gmail" name="gmail" class="form-input" required
                                placeholder="example@gmail.com"
                                maxlength="100">
                            <span class="form-hint" style="font-size: 11px; color: #94a3b8; margin-top: 2px; display: block;">* Email nhận liên hệ từ khách hàng (tối đa 100 ký tự).</span>
                        </div>
                    </div>
                </div>

                {{-- Section 3: CV đính kèm --}}
                <div class="form-section">
                    <div class="form-section-title">CV đính kèm (Mặc định)</div>
                    <div class="form-group">
                        @php
                            $cvChinh = $danhSachCv->where('la_cv_chinh', 1)->first() ?: $danhSachCv->first();
                        @endphp
                        @if($cvChinh)
                            <div style="background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 8px; font-size: 14px; font-weight: 600; color: #334155; display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px; color: #10b981;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>{{ $cvChinh->ten_cv }} (CV chính thức)</span>
                            </div>
                            <input type="hidden" id="select-service-cv" name="id_cv" value="{{ $cvChinh->id }}">
                        @else
                            <div style="background-color: #fef2f2; border: 1px solid #fee2e2; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 13.5px;">
                                Bạn chưa tạo CV nào. Hãy <a href="{{ route('ho-so.cv.index') }}" style="text-decoration: underline; font-weight: 600; color: #b91c1c;">vào trang Quản lý CV</a> để tạo và chọn CV chính.
                            </div>
                            <input type="hidden" id="select-service-cv" name="id_cv" value="">
                        @endif
                        <div class="form-hint">CV chính thức của bạn sẽ được tự động đính kèm. Thông tin liên hệ nhạy cảm sẽ được che đi khi người khác xem CV qua dịch vụ.</div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <div class="modal-footer-info">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Diền đầy đủ các thông tin bắt buộc (*)
            </div>
            <div class="modal-footer-actions">
                <button type="button" class="btn-cancel" data-dong-modal="modal-dich-vu">Huỷ</button>
                <button type="button" class="btn-save" id="btn-save-service">
                    <span class="btn-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Đăng dịch vụ
                    </span>
                    <span class="btn-loading"><span class="spinner"></span> Đang lưu...</span>
                </button>
            </div>
        </div>
    </div>
</div>



{{-- MODAL: XEM CHI TIẾT DỊCH VỤ CÁ NHÂN --}}
<div class="modal-overlay" id="modal-chi-tiet-dich-vu" role="dialog" aria-modal="true" aria-labelledby="modal-chi-tiet-title">
    <div class="modal-panel" style="max-width: 720px;">

        {{-- Header --}}
        <div class="modal-header" style="border-bottom: 1px solid var(--border-color); padding: 16px 24px;">
            <div class="modal-header-left" style="display:flex; align-items:center; gap:12px;">
                <div class="modal-icon" style="background: rgba(37,99,235,0.08); color: var(--accent-blue); width: 40px; height: 40px; border-radius: 8px; display:flex; align-items:center; justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="modal-title" id="modal-chi-tiet-title" style="font-family: var(--font-heading); font-size: 16px; font-weight: 700; color: var(--text-primary);">Chi tiết dịch vụ</div>
                    <div class="modal-subtitle" id="modal-chi-tiet-category" style="font-size: 12px; color: var(--text-secondary); margin-top:2px;">Danh mục dịch vụ</div>
                </div>
            </div>
            <button type="button" class="modal-close" data-dong-modal="modal-chi-tiet-dich-vu" aria-label="Đóng">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="modal-body" style="padding: 24px; max-height: calc(100vh - 200px); overflow-y: auto;">
            
            {{-- Provider Info (for community, hidden for personal) --}}
            <div id="modal-chi-tiet-provider" style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px; padding-bottom:14px; border-bottom: 1px solid var(--border-color); flex-wrap: wrap;">
                <div style="display:flex; align-items:center; gap:12px; min-width:0;">
                    <div class="provider-avatar" id="modal-chi-tiet-provider-avatar" style="width: 44px; height: 44px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--accent-blue); background-color:rgba(37,99,235,0.1); border: 2px solid #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); flex-shrink:0;">
                        <span id="modal-chi-tiet-provider-init">ND</span>
                    </div>
                    <div style="display:flex; flex-direction:column; min-width:0;">
                        <span class="provider-name" id="modal-chi-tiet-provider-name" style="font-size:14px; font-weight:700; color:var(--text-primary);">Tên người dùng</span>
                        <span class="provider-role" id="modal-chi-tiet-provider-role" style="font-size:11.5px; color:var(--text-secondary); margin-top:1px;">Chức danh</span>
                    </div>
                </div>
                <button type="button" id="modal-chi-tiet-btn-all-services" class="btn-action-sm primary" style="font-size: 11.5px; height: 34px; padding: 0 12px; border-radius: 8px; font-weight:600; display:none; align-items:center; gap:6px;">
                    💼 Tất cả dịch vụ của người này
                </button>
            </div>

            {{-- Title & Desc --}}
            <div style="margin-bottom: 20px;">
                <h3 id="modal-chi-tiet-service-title" style="font-family: var(--font-heading); font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 10px; line-height: 1.4; word-break:break-word;">Tên dịch vụ</h3>
                <div id="modal-chi-tiet-service-desc" style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.6; white-space: pre-line; word-break: break-word; background: #f8fafc; padding: 16px; border-radius: var(--radius-md); border: 1px solid #f1f5f9;">
                    Mô tả dịch vụ
                </div>
            </div>

            {{-- Contacts --}}
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">Thông tin liên hệ</h4>
                <div class="service-contacts" style="margin-bottom: 0;">
                    <div class="contact-item">
                        <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;color:var(--text-secondary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span class="contact-label">Zalo:</span>
                        <span class="contact-val" id="modal-chi-tiet-zalo"></span>
                    </div>
                    <div class="contact-item" style="margin-top: 8px;">
                        <svg class="contact-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;color:var(--text-secondary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="contact-label">Gmail:</span>
                        <span class="contact-val" id="modal-chi-tiet-gmail"></span>
                    </div>
                </div>
            </div>

            {{-- Attached CV --}}
            <div id="modal-chi-tiet-cv-container" style="margin-bottom: 20px;">
                <h4 style="font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">Hồ sơ năng lực đính kèm</h4>
                <div style="display:flex; align-items:center; justify-content:space-between; padding: 12px 16px; background:#f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;">
                    <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#16a34a" style="width:20px;height:20px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span id="modal-chi-tiet-cv-name" style="font-size:13px; font-weight:600; color:#16a34a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Tên bản CV</span>
                    </div>
                    <a href="#" id="modal-chi-tiet-cv-link" target="_blank" class="btn-action-sm primary" style="background:#16a34a; border-color:#16a34a; font-size:11px; padding: 6px 12px; flex-shrink:0;">
                        📄 Xem trực tuyến
                    </a>
                </div>
                <div style="font-size:11.5px; color:var(--text-secondary); margin-top:6px; font-style:italic;">* Các thông tin liên hệ và địa chỉ của chủ sở hữu sẽ được che đi để bảo mật.</div>
            </div>



            {{-- Metadata Dates --}}
            <div style="display:flex; gap:16px; border-top: 1px solid var(--border-color); padding-top:16px; font-size:12px; color:var(--text-secondary); flex-wrap:wrap;">
                <div>📅 Ngày đăng: <span id="modal-chi-tiet-created-at"></span></div>
                <div>🕒 Cập nhật cuối: <span id="modal-chi-tiet-updated-at"></span></div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 16px 24px; display:flex; justify-content:space-between; align-items:center;">
            <div id="modal-chi-tiet-footer-status" style="font-size: 12px;"></div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                {{-- Actions for My Service --}}
                <div id="modal-chi-tiet-my-actions" style="display:flex; gap:10px;">
                    <button type="button" class="btn-action-sm outline" id="modal-chi-tiet-btn-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Sửa dịch vụ
                    </button>
                    <button type="button" class="btn-action-sm outline" id="modal-chi-tiet-btn-delete" style="color:#ef4444; border-color:rgba(239,68,68,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Gỡ bỏ
                    </button>
                </div>
                {{-- Contact Actions for Community Service --}}
                <div id="modal-chi-tiet-comm-actions" style="display:flex; gap:10px;">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="btn-action-sm outline" id="modal-chi-tiet-comm-zalo">💬 Chat Zalo</a>
                    <a href="#" class="btn-action-sm outline" id="modal-chi-tiet-comm-gmail">✉️ Gửi Email</a>
                </div>
                <button type="button" class="btn-action-sm outline" data-dong-modal="modal-chi-tiet-dich-vu">Đóng</button>
            </div>
        </div>

    </div>
</div>

{{-- Modal Toàn bộ dịch vụ của người dùng --}}
<div class="modal-overlay" id="modal-provider-all-services" style="z-index: 1050;">
    <div class="modal-panel" style="max-width: 960px; width: 100%; background: #fff; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
        
        {{-- Header --}}
        <div class="modal-header" style="border-bottom: 1px solid var(--border-color); padding: 18px 24px; display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(37,99,235,0.1); color: var(--accent-blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px;" id="modal-all-services-avatar">
                    <span id="modal-all-services-init">ND</span>
                </div>
                <div>
                    <h3 style="font-family: var(--font-heading); font-size: 15px; font-weight: 700; color: var(--text-primary); margin:0;" id="modal-all-services-title">
                        Toàn bộ dịch vụ của người này
                    </h3>
                    <span style="font-size: 11.5px; color: var(--text-secondary);" id="modal-all-services-subtitle">Danh sách dịch vụ đã duyệt</span>
                </div>
            </div>
            <button type="button" class="btn-close-modal" data-dong-modal="modal-provider-all-services" style="background:none; border:none; font-size:24px; color:var(--text-secondary); cursor:pointer; line-height:1; padding: 0 4px;">&times;</button>
        </div>
        
        {{-- Body --}}
        <div class="modal-body" style="padding: 24px; max-height: calc(100vh - 220px); overflow-y: auto; background: #f8fafc; display: flex; flex-direction: column;">
            
            {{-- Filters --}}
            <div class="modal-provider-services-filters" style="display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; background:#ffffff; padding:12px; border-radius:10px; border:1px solid #e2e8f0; width: 100%;">
                <input type="text" id="modal-provider-search" placeholder="Tìm kiếm dịch vụ..." style="flex: 1; min-width: 140px; height: 36px; font-size: 12.5px; padding: 0 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; outline: none; background: #ffffff;">
                <select id="modal-provider-category" style="width: 150px; height: 36px; font-size: 12.5px; padding: 0 8px; border: 1.5px solid #cbd5e1; border-radius: 8px; outline: none; background: #ffffff; color: var(--text-primary); cursor: pointer;">
                    <option value="">-- Tất cả lĩnh vực --</option>
                    @foreach($catMap as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select id="modal-provider-sort" style="width: 120px; height: 36px; font-size: 12.5px; padding: 0 8px; border: 1.5px solid #cbd5e1; border-radius: 8px; outline: none; background: #ffffff; color: var(--text-primary); cursor: pointer;">
                    <option value="newest">🕒 Mới nhất</option>
                    <option value="oldest">📅 Cũ nhất</option>
                </select>
                <button type="button" id="modal-provider-filter-btn" class="btn-action-sm primary" style="font-size: 12px; height: 36px; padding: 0 16px; border-radius: 8px; font-weight:600;">Lọc</button>
                <button type="button" id="modal-provider-clear-btn" class="btn-action-sm outline" style="font-size: 12px; height: 36px; padding: 0 16px; border-radius: 8px; font-weight:600; display:none; align-items:center; justify-content:center;">Xóa lọc</button>
            </div>
            
            {{-- Services List Container --}}
            <div id="modal-provider-services-list" style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                {{-- Mini items rendered by JS --}}
            </div>
            
            {{-- Pagination Container --}}
            <div id="modal-provider-services-pagination" style="display: flex; justify-content: center; gap: 6px; margin-top: 18px; flex-wrap: wrap; width: 100%;">
                {{-- Pagination buttons rendered by JS --}}
            </div>
            
        </div>
        
        {{-- Footer --}}
        <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 16px 24px; display:flex; justify-content:flex-end;">
            <button type="button" class="btn-action-sm outline" data-dong-modal="modal-provider-all-services">Đóng</button>
        </div>
        
    </div>
</div>

{{-- Scripts --}}
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script>
    window.ROUTES = {
        luuDichVu: "{{ route('ho-so.dich-vu.luu') }}",
        xemCv: "{{ route('ho-so.dich-vu.xem-cv', ['id' => 'ID_PLACEHOLDER']) }}",
        xoaDichVu: "{{ route('ho-so.dich-vu.xoa', ['id' => 'ID_PLACEHOLDER']) }}",
        doiTrangThaiDichVu: "{{ route('ho-so.dich-vu.doi-trang-thai', ['id' => 'ID_PLACEHOLDER']) }}"
    };
    window.USER_DATA = {
        soDienThoai: "{{ $nguoiDung->so_dien_thoai }}",
        email: "{{ $nguoiDung->email }}",
        cvChinhId: "{{ $cvChinh ? $cvChinh->id : '' }}"
    };
</script>
<script src="{{ asset('js/ho-so/tim-kiem.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/dich-vu/dich-vu.js') }}?v={{ time() }}"></script>

