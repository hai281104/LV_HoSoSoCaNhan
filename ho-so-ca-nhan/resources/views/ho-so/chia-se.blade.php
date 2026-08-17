<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chia sẻ hồ sơ - {{ $hoTen }}</title>
    <meta name="description" content="Tải xuống và chia sẻ CV, hồ sơ năng lực cá nhân.">

    {{-- CSS trang hồ sơ --}}
    <link rel="stylesheet" href="{{ asset('css/ho-so/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chinh-sua.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/cv/cv-style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/ho-so/chia-se.css') }}?v={{ time() }}">
    
    {{-- CryptoJS & PDF.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
</head>
<body>

{{-- SIDEBAR --}}
@include('ho-so.partials.sidebar')

<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- MAIN CONTENT --}}
<main class="main-content">
    {{-- Header --}}
    @include('ho-so.partials.header', ['headerTitle' => 'Chia sẻ hồ sơ', 'searchPlaceholder' => 'Tìm kiếm...', 'disableSearch' => true])

    {{-- Content Body --}}
    <div class="content-body">
        
        <div class="share-instructions">
            <strong>Hướng dẫn tải và gửi nhanh hồ sơ:</strong>
            <ol>
                <li>Nhấp vào nút <strong>"Xem trước"</strong> để xem nội dung hồ sơ trước khi tải xuống.</li>
                <li>Trên trang xem trước, nhấp nút <strong>"Tải xuống PDF"</strong> để lưu tệp về máy. Hoặc nhấp thẳng nút <strong>"Tải xuống ... (PDF)"</strong> để bỏ qua bước xem trước.</li>
                <li>Sau khi tệp đã tải xong, nhấp vào nút <strong>"Gửi qua Zalo"</strong> hoặc <strong>"Gửi qua Gmail"</strong> rồi đính kèm tệp PDF vừa tải để gửi đi.</li>
            </ol>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            {{-- Card 1: Tải & Chia sẻ CV --}}
            <div class="share-card">
                <div>
                    <div class="share-card-title">
                        <div class="share-card-icon icon-cv">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 28px; height: 28px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3>Tải & Gửi nhanh CV</h3>
                    </div>
                    <p class="share-card-desc">Lựa chọn một trong các CV của bạn để tải xuống dưới dạng PDF tiêu chuẩn hoặc chia sẻ nhanh qua các kênh.</p>
                    
                    @if(count($danhSachCv) > 0)
                        @php
                            $cvChinh = $danhSachCv->where('la_cv_chinh', 1)->first() ?: $danhSachCv->first();
                        @endphp
                        <div class="share-select-wrapper" style="margin-bottom: 24px;">
                            <label style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; display: block;">CV mặc định (chính thức):</label>
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px; color: #9333ea;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>{{ $cvChinh->ten_cv }}</span>
                            </div>
                            <input type="hidden" id="cv-select" value="{{ $cvChinh->id }}" data-name="{{ $cvChinh->ten_cv }}">
                        </div>
                    @else
                        <div style="background-color: #fef2f2; border: 1px solid #fee2e2; color: #b91c1c; padding: 12px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px;">
                            Bạn chưa tạo CV nào. Hãy <a href="{{ route('ho-so.cv.index') }}" style="text-decoration: underline; font-weight: 600; color: #b91c1c;">vào trang Quản lý CV</a> để tạo.
                        </div>
                    @endif
                </div>

                <div>
                    @if(count($danhSachCv) > 0)
                        {{-- Xem trước CV --}}
                        <button type="button" class="btn-preview" onclick="xemTruocCvDaChon()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Xem trước CV
                        </button>
                        {{-- Tải xuống CV --}}
                        <button type="button" class="btn-share-download btn-cv-download" onclick="taiCvDaChon()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Tải xuống CV (PDF)
                        </button>
                        
                        <div class="share-action-group">
                            <span class="share-action-label">Gửi nhanh file đã tải</span>
                            <div class="share-buttons">
                                <button type="button" onclick="chiaSeCv('zalo')" class="btn-social-share btn-zalo">
                                    Gửi qua Zalo
                                </button>
                                <button type="button" onclick="chiaSeCv('gmail')" class="btn-social-share btn-gmail">
                                    Gửi qua Gmail
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card 2: Tải & Chia sẻ Hồ sơ năng lực --}}
            <div class="share-card">
                <div>
                    <div class="share-card-title">
                        <div class="share-card-icon icon-profile">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 28px; height: 28px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </div>
                        <h3>Tải & Gửi nhanh Hồ sơ</h3>
                    </div>
                    <p class="share-card-desc">Tải xuống toàn bộ hồ sơ năng lực đầy đủ (không bao gồm các bức ảnh thuộc Album) dưới định dạng A4 chuẩn để lưu trữ hoặc gửi tới nhà tuyển dụng.</p>
                </div>

                <div>
                    {{-- Xem trước Hồ sơ --}}
                    <button type="button" class="btn-preview" onclick="xemTruocHoSo()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Xem trước Hồ sơ
                    </button>
                    {{-- Tải xuống Hồ sơ --}}
                    <button type="button" class="btn-share-download btn-profile-download" onclick="taiHoSo()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Tải xuống Hồ sơ (PDF)
                    </button>
                    
                    <div class="share-action-group">
                        <span class="share-action-label">Gửi nhanh file đã tải</span>
                        <div class="share-buttons">
                            <button type="button" onclick="chiaSeHoSo('zalo')" class="btn-social-share btn-zalo">
                                Gửi qua Zalo
                            </button>
                            <button type="button" onclick="chiaSeHoSo('gmail')" class="btn-social-share btn-gmail">
                                Gửi qua Gmail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Xem Hồ sơ Bảo mật --}}
            <div class="share-card" style="background: #faf5ff; border-color: #d8b4fe;">
                <div>
                    <div class="share-card-title">
                        <div class="share-card-icon" style="background-color: #f3e8ff; color: #9333ea;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 28px; height: 28px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3>Xem Hồ sơ Bảo mật</h3>
                    </div>
                    <p class="share-card-desc">Giải mã và xem trực tiếp hồ sơ năng lực cá nhân đã được mã hóa(chỉ cho phép xem trực tuyến, không thể tải xuống tệp gốc).</p>
                    
                    <div class="share-select-wrapper" style="margin-bottom: 12px;">
                        <label style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; display: block;">Chọn tệp tin (.enc.pdf / .enc):</label>
                        <input type="file" id="decrypt-file-input" accept=".enc,.pdf,.pdf.enc" class="share-select" style="padding: 8px;">
                    </div>
                    
                    <div class="share-select-wrapper" style="margin-bottom: 20px;">
                        <label style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; display: block;">Nhập mật mã giải mã:</label>
                        <input type="password" id="decrypt-password-input" placeholder="Nhập mật mã tại đây..." class="share-select">
                    </div>
                </div>

                <div>
                    <button type="button" class="btn-share-download" style="background: linear-gradient(135deg, #9333ea, #a855f7); color: white; box-shadow: 0 4px 12px rgba(147,51,234,0.2);" onclick="giaiMaVaMoFile()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        Giải mã & Xem Hồ sơ
                    </button>
                </div>
            </div>
        </div>

    </div>
</main>

{{-- Modal hiển thị mật mã khi tải --}}
<div class="secure-modal-overlay" id="encrypt-modal-overlay">
    <div class="secure-modal-panel">
        <div class="secure-modal-header">
            <h3 class="secure-modal-title">🔐 Xuất Hồ sơ Bảo mật</h3>
            <button class="secure-modal-close" onclick="dongModalMaHoa()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p style="font-size: 14px; color: #475569; line-height: 1.5; margin-bottom: 16px;">
            Vui lòng sao lưu lại mật mã dưới đây để cung cấp cho người xem:
        </p>
        <div class="passcode-box">
            <span class="passcode-text" id="generated-passcode">DPCS-XXXXXX</span>
            <button class="btn-copy-passcode" onclick="saoChepMatMa()">Sao chép</button>
        </div>
        <div style="font-size: 12.5px; color: #b45309; background-color: #fffbeb; border: 1px solid #fef3c7; padding: 10px; border-radius: 8px; margin-bottom: 20px; line-height: 1.4;">
            ⚠️ <strong>Quan trọng:</strong> Mật mã này được tạo ngẫu nhiên và KHÔNG lưu trữ trên hệ thống của chúng tôi để đảm bảo tính riêng tư tuyệt đối. Hãy chắc chắn đã sao chép nó.
        </div>
        <button type="button" class="btn-share-download btn-profile-download" style="margin-bottom: 0;" onclick="kichHoatTaiMaHoa()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Bắt đầu tải xuống file mã hóa (.enc)
        </button>
    </div>
</div>

{{-- Fullscreen Canvas PDF Viewer --}}
<div class="secure-pdf-viewer" id="secure-pdf-viewer">
    <div class="viewer-header">
        <div class="viewer-title">
            <span>🛡️ Trình xem Hồ sơ Bảo mật (Chế độ xem an toàn)</span>
        </div>
        <button class="viewer-close-btn" onclick="dongTrinhXemBaoMat()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Đóng trình xem
        </button>
    </div>
    <div class="viewer-content-area" id="viewer-canvas-container">
        <!-- Rendered canvases go here -->
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

{{-- JS modules --}}
<script>
    window.ROUTES = {
        xemTruocIn: "{{ route('ho-so.xem-truoc-in') }}"
    };
    window.USER_DATA = {
        hoTen: "{{ $hoTen }}"
    };
</script>
<script src="{{ asset('js/ho-so/chinh-sua.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/chia-se/chia-se.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/thong-bao.js') }}?v={{ time() }}"></script>
</body>
</html>

