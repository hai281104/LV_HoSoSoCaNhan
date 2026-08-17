<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem trước CV - {{ $cv->ten_cv }}</title>
    
    {{-- Google Fonts for premium typography --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Fallback relative linking standard in Laravel if public path is configured differently --}}
    <link rel="stylesheet" href="{{ asset('css/cv/cv-print.css') }}?v={{ time() }}">

    {{-- html2pdf library for direct client-side PDF downloads --}}
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}?v=10.1"></script>

    <style>
        /* Standalone floating toolbar */
        .standalone-toolbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #1f2937;
            border: 1px solid #374151;
            padding: 10px 20px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: opacity 0.2s ease;
        }

        .standalone-toolbar .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: none;
            color: #fff;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            padding: 6px 14px;
            border-radius: 9999px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .standalone-toolbar .btn-action.back {
            color: #9ca3af;
        }

        .standalone-toolbar .btn-action.back:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .standalone-toolbar .btn-action.print-pdf {
            background-color: #2563eb;
        }

        .standalone-toolbar .btn-action.print-pdf:hover {
            background-color: #1d4ed8;
        }

        .standalone-toolbar svg {
            width: 16px;
            height: 16px;
        }

        .standalone-toolbar .toolbar-divider {
            width: 1px;
            height: 20px;
            background-color: #374151;
        }

        /* Responsive preview layout for web page view */
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .a4-page-container {
            background-color: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 80px auto 40px auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            box-sizing: border-box;
            position: relative;
        }

        /* Tùy chỉnh dành riêng cho clone của container khi xuất PDF */
        .a4-page-container.generating-pdf {
            margin: 0 !important;
            box-shadow: none !important;
            width: 210mm !important;
        }

        .a4-page-container.generating-pdf::after {
            display: none !important;
            content: none !important;
        }

        @media screen {
            /* Vẽ đường phân tách trang A4 tự động trong preview */
            .a4-page-container::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                background-image: linear-gradient(to bottom, transparent 296.5mm, rgba(239, 68, 68, 0.3) 296.5mm, rgba(239, 68, 68, 0.3) 297mm, transparent 297mm);
                background-size: 100% 297mm;
                z-index: 9999;
            }
        }

        /* Remove spacing when in iframe */
        body.in-iframe {
            background-color: #fff;
            display: block;
            min-height: auto;
        }

        body.in-iframe .a4-page-container {
            margin: 0;
            padding: 10mm;
            box-shadow: none;
            width: 100%;
        }

        /* Print modifications */
        @media print {
            .standalone-toolbar {
                display: none !important;
            }
            body {
                background-color: #fff !important;
                display: block !important;
                min-height: auto !important;
            }
            .a4-page-container {
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                width: 210mm !important;
                height: 297mm !important;
            }
            /* Ẩn hoàn toàn spacer và số trang khi in để nhường chỗ cho ngắt trang tự nhiên của PDF engine */
            .cv-page-spacer,
            .cv-page-number {
                display: none !important;
                height: 0 !important;
            }
        }
        
        /* Modal Styles cho AI Evaluate */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-panel {
            background: #fff;
            border-radius: 16px;
            width: 90%;
            max-width: 650px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            flex-shrink: 0;
        }
        .modal-body {
            padding: 24px;
            background: #f8fafc;
            overflow-y: auto;
            flex: 1;
        }
        .modal-footer {
            padding: 14px 24px;
            border-top: 1px solid #f1f5f9;
            text-align: right;
            background: #ffffff;
            flex-shrink: 0;
        }
        
        .ai-score-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            color: #1e293b;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }
        
        .ai-score-value {
            font-size: 64px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
            color: #a855f7;
        }
        
        .ai-score-label {
            font-size: 16px;
            font-weight: 600;
            color: #64748b;
        }
        
        .ai-section-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border-left: 4px solid transparent;
        }
        
        .ai-section-card.strengths { border-left-color: #10b981; }
        .ai-section-card.weaknesses { border-left-color: #f59e0b; }
        .ai-section-card.tips { border-left-color: #3b82f6; }
        
        .ai-section-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1e293b;
        }
        
        .ai-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .ai-list li {
            position: relative;
            padding-left: 24px;
            color: #475569;
            line-height: 1.5;
            font-size: 14.5px;
        }
        
        .ai-list li::before {
            position: absolute;
            left: 0;
            top: 2px;
        }
        
        .ai-section-card.strengths .ai-list li::before { content: "✅"; }
        .ai-section-card.weaknesses .ai-list li::before { content: "⚠️"; }
        .ai-section-card.tips .ai-list li::before { content: "💡"; }
    </style>
</head>
<body>

{{-- Standalone floating toolbar --}}
<div class="standalone-toolbar" id="standalone-toolbar">
    <a href="{{ route('ho-so.cv.index') }}" class="btn-action back">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Quay lại
    </a>
    
    <button type="button" class="btn-action" style="background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);" onclick="evaluateCvWithAI()">
        ✨ Đánh giá CV (AI)
    </button>
    
    <div class="toolbar-divider"></div>
    <button type="button" class="btn-action print-pdf" onclick="downloadPdfDirectly()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Tải xuống PDF
    </button>
</div>

{{-- Main CV Container --}}
<div class="a4-page-container">
    @include($templateView)
</div>
{{-- MODAL: ĐÁNH GIÁ CV BẰNG AI --}}
<div class="modal-overlay" id="modal-danh-gia-ai" onclick="if(event.target === this) this.classList.remove('active')">
    <div class="modal-panel">
        <div class="modal-header">
            <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 22px; height: 22px; color: #a855f7;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Kết quả Đánh giá CV (Bởi AI)
            </h3>
            <button onclick="document.getElementById('modal-danh-gia-ai').classList.remove('active')" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; font-size: 18px; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'; this.style.color='#0f172a';" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b';">&times;</button>
        </div>
        <div class="modal-body" id="ai-eval-content">
            <!-- Content will be loaded here -->
            <div style="text-align: center; padding: 40px 0;">
                <div class="spinner" style="width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #a855f7; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p style="margin-top: 15px; color: #64748b;">AI đang phân tích và chấm điểm CV của bạn...</p>
                <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="document.getElementById('modal-danh-gia-ai').classList.remove('active')" style="padding: 9px 20px; background: #334155; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13.5px; color: #ffffff; transition: background 0.2s;" onmouseover="this.style.background='#1e293b';" onmouseout="this.style.background='#334155';">Đóng cửa sổ</button>
        </div>
    </div>
</div>

<script>
    let isGeneratingPdf = false;

    // AI Evaluation function
    function evaluateCvWithAI() {
        const modal = document.getElementById('modal-danh-gia-ai');
        const contentBox = document.getElementById('ai-eval-content');
        
        // Hiện modal kèm trạng thái loading
        modal.classList.add('active');
        contentBox.innerHTML = `
            <div style="text-align: center; padding: 40px 0;">
                <div class="spinner" style="width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #a855f7; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p style="margin-top: 15px; color: #64748b;">AI đang đọc và phân tích chuyên sâu CV của bạn...</p>
            </div>
        `;

        fetch('{{ route("ho-so.cv.ai-evaluate", $cv->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.thanh_cong) {
                const eval = data.evaluation;
                let uuDiemHtml = eval.uu_diem.map(item => `<li>${item}</li>`).join('');
                let nhuocDiemHtml = eval.nhuoc_diem.map(item => `<li>${item}</li>`).join('');
                let caiThienHtml = eval.de_xuat_cai_thien.map(item => `<li>${item}</li>`).join('');

                contentBox.innerHTML = `
                    <div class="ai-score-card">
                        <div class="ai-score-value">${eval.diem}</div>
                        <div class="ai-score-label">Điểm Đánh Giá Tổng Thể</div>
                    </div>
                    
                    <div class="ai-section-card strengths">
                        <div class="ai-section-title">
                            <span style="color: #10b981;">●</span> Điểm mạnh nổi bật
                        </div>
                        <ul class="ai-list">${uuDiemHtml}</ul>
                    </div>

                    <div class="ai-section-card weaknesses">
                        <div class="ai-section-title">
                            <span style="color: #f59e0b;">●</span> Điểm yếu cần khắc phục
                        </div>
                        <ul class="ai-list">${nhuocDiemHtml}</ul>
                    </div>

                    <div class="ai-section-card tips">
                        <div class="ai-section-title">
                            <span style="color: #3b82f6;">●</span> Đề xuất cải thiện từ Chuyên gia
                        </div>
                        <ul class="ai-list">${caiThienHtml}</ul>
                    </div>
                `;
            } else {
                contentBox.innerHTML = `<div style="color: #ef4444; padding: 20px; text-align: center;">❌ ${data.thong_bao || 'Đã xảy ra lỗi khi kết nối AI'}</div>`;
            }
        })
        .catch(err => {
            console.error(err);
            contentBox.innerHTML = `<div style="color: #ef4444; padding: 20px; text-align: center;">❌ Lỗi hệ thống: Không thể kết nối tới máy chủ AI.</div>`;
        });
    }
    // Hàm tải trực tiếp CV dưới dạng file PDF sử dụng thư viện html2pdf
    function downloadPdfDirectly(autoClose = false) {
        if (isGeneratingPdf) return;
        isGeneratingPdf = true;

        const element = document.querySelector('.a4-page-container');
        if (!element) {
            isGeneratingPdf = false;
            return;
        }

        // Tạo bản sao của phần tử để tránh làm biến dạng DOM gốc trong quá trình xuất PDF
        const clone = element.cloneNode(true);
        clone.classList.add('generating-pdf');
        
        const opt = {
            margin:       0, // 0 margin để khớp tuyệt đối với phân trang A4 (297mm) trên màn hình
            filename:     '{{ Str::slug($cv->ten_cv, "_") }}_CV.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, scrollX: 0, scrollY: 0 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        // Tạo hiệu ứng loading nhẹ khi đang kết xuất PDF
        const btn = document.querySelector('.btn-action.print-pdf');
        const originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>⏳ Đang xuất file...</span>';
        }

        // Tạo overlay thông báo nếu ở chế độ tự động tải & đóng tab
        let overlay = null;
        if (autoClose) {
            overlay = document.createElement('div');
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            overlay.style.zIndex = '10000';
            overlay.style.display = 'flex';
            overlay.style.flexDirection = 'column';
            overlay.style.justifyContent = 'center';
            overlay.style.alignItems = 'center';
            overlay.style.fontFamily = "'Inter', sans-serif";
            overlay.innerHTML = `
                <div style="font-size: 22px; font-weight: 700; color: #1e3a8a; margin-bottom: 8px;">⚡ Đang tự động kết xuất PDF...</div>
                <div style="font-size: 14px; color: #475569; margin-bottom: 24px;">Vui lòng đợi giây lát. Trình duyệt đang tải CV về máy và tab này sẽ tự động đóng.</div>
                <div class="spinner" style="width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <style>
                    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                </style>
            `;
            document.body.appendChild(overlay);
        }
        
        if (typeof html2pdf === 'undefined') {
            console.error('Không tìm thấy thư viện html2pdf');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
            if (overlay) overlay.remove();
            clone.remove();
            isGeneratingPdf = false;
            alert('Không thể tải thư viện xuất PDF. Vui lòng kết nối mạng hoặc thử lại.');
            return;
        }
        
        html2pdf().from(clone).set(opt).save()
        .then(() => {
            clone.remove();
            isGeneratingPdf = false;
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
            
            // Chạy lại phân trang để đảm bảo
            autoPaginate();

            if (autoClose) {
                if (overlay) {
                    overlay.innerHTML = `
                        <div style="font-size: 22px; font-weight: 700; color: #10b981; margin-bottom: 8px;">🎉 Xuất file PDF thành công!</div>
                        <div style="font-size: 14px; color: #475569;">Đang đóng tab này...</div>
                    `;
                }
                setTimeout(() => {
                    window.close();
                }, 1000);
            }
        })
        .catch(err => {
            console.error('Lỗi tải PDF:', err);
            clone.remove();
            isGeneratingPdf = false;
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
            if (overlay) overlay.remove();
            
            autoPaginate();

            alert('Không thể tải PDF trực tiếp. Vui lòng thử lại hoặc dùng tổ hợp Ctrl+P để lưu.');
        });
    }

    // Tự động phân trang và kích hoạt tải nếu có tham số download=1
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('download') === '1') {
            // Ẩn thanh công cụ khi đang tải tự động
            const toolbar = document.getElementById('standalone-toolbar');
            if (toolbar) toolbar.style.display = 'none';

            // Đợi phân trang và tài nguyên tải xong rồi chạy
            window.addEventListener('load', () => {
                setTimeout(() => {
                    downloadPdfDirectly(true);
                }, 800);
            });
        }
    });

    // Detect if page is embedded in iframe
    if (window.self !== window.top) {
        document.body.classList.add('in-iframe');
        const toolbar = document.getElementById('standalone-toolbar');
        if (toolbar) toolbar.style.display = 'none';

        // Cho phép sửa chữ trực tiếp trong các phần tử có data-edit-key
        document.querySelectorAll('[data-edit-key]').forEach(el => {
            el.setAttribute('contenteditable', 'true');
            el.style.outline = 'none';
            el.addEventListener('focus', () => {
                el.style.backgroundColor = 'rgba(254, 243, 199, 0.4)';
                el.style.borderRadius = '3px';
                el.style.boxShadow = '0 0 0 2px #f59e0b';
            });
            el.addEventListener('blur', () => {
                el.style.backgroundColor = '';
                el.style.boxShadow = '';
                const key = el.getAttribute('data-edit-key');
                const val = el.innerText.trim();
                
                // Gửi nội dung đã sửa về trang cha
                window.parent.postMessage({
                    type: 'cv-text-edited',
                    key: key,
                    value: val
                }, '*');
            });
        });

        // Lắng nghe lệnh blur từ trang cha (CORS-safe fallback)
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'cv-blur-active') {
                if (document.activeElement && document.activeElement !== document.body) {
                    document.activeElement.blur();
                }
            }
        });
    }

    // Tự động phân trang trên giao diện web (Simulate A4 Page Breaks)
    function autoPaginate() {
        if (isGeneratingPdf) return;
        // Chiều cao tiêu chuẩn của A4 tính bằng pixel (297mm)
        // 1mm = 3.7795275px => 297mm = 1122.5px
        const pageHeightPx = 1122.5; 
        const container = document.querySelector('.a4-page-container');
        if (!container) return;

        // Reset minHeight trước khi tính toán để container co lại theo nội dung thực
        container.style.minHeight = '';

        // Xóa các spacer và số trang cũ nếu có
        document.querySelectorAll('.cv-page-spacer').forEach(el => el.remove());
        document.querySelectorAll('.cv-page-number').forEach(el => el.remove());
        
        // Thiết lập lề trên và lề dưới cho mỗi trang (20mm ~ 75.6px)
        const topMargin = 75.6;
        const bottomMargin = 75.6;
        const maxContentHeight = pageHeightPx - topMargin - bottomMargin; // Chiều cao nội dung khả dụng trên 1 trang
        
        // Các phần tử cần tránh ngắt đôi (chỉ tránh ngắt đôi timeline item và phần nhỏ, tránh ngắt đôi toàn bộ section lớn để giảm khoảng trống thừa)
        const targets = document.querySelectorAll('.cv-timeline-item, .cv-sidebar-section, .cv-link-card, .cv-contact-item');
        
        targets.forEach(el => {
            const containerRect = container.getBoundingClientRect();
            const rect = el.getBoundingClientRect();
            
            const topRelativeToContainer = rect.top - containerRect.top;
            const bottomRelativeToContainer = rect.bottom - containerRect.top;
            
            const pageNumTop = Math.floor(topRelativeToContainer / pageHeightPx);
            
            // Lề dưới và lề trên khả dụng của trang hiện tại mà phần tử đang bắt đầu
            const currentPageBottomBoundary = (pageNumTop + 1) * pageHeightPx - bottomMargin;
            const currentPageTopBoundary = pageNumTop * pageHeightPx + topMargin;
            
            // Xác định phần tử chèn spacer và tọa độ mốc tính toán
            const section = el.closest('.cv-section, .cv-main-section');
            let insertBeforeEl = el;
            let referenceTop = topRelativeToContainer;
            
            if (section) {
                const firstTarget = section.querySelector('.cv-timeline-item, .cv-link-card, .cv-contact-item');
                if (el === firstTarget) {
                    insertBeforeEl = section;
                    referenceTop = section.getBoundingClientRect().top - containerRect.top;
                }
            }

            // Điều kiện 1: Phần tử nằm trong top margin (do tràn tự nhiên từ trang trước) -> cần đẩy xuống vùng nội dung chính
            if (pageNumTop > 0 && referenceTop < currentPageTopBoundary) {
                const spacerHeight = currentPageTopBoundary - referenceTop;
                
                const spacer = document.createElement('div');
                spacer.className = 'cv-page-spacer';
                spacer.style.height = `${spacerHeight}px`;
                spacer.style.width = '100%';
                
                insertBeforeEl.parentNode.insertBefore(spacer, insertBeforeEl);
            }
            // Điều kiện 2: Phần tử nhỏ hơn 1 trang nhưng bị tràn lề dưới hoặc bắt đầu trong vùng lề dưới -> đẩy sang trang sau
            else if (rect.height < maxContentHeight && (bottomRelativeToContainer > currentPageBottomBoundary || referenceTop > currentPageBottomBoundary)) {
                const nextPageTopBoundary = (pageNumTop + 1) * pageHeightPx + topMargin;
                const spacerHeight = nextPageTopBoundary - referenceTop;
                
                const spacer = document.createElement('div');
                spacer.className = 'cv-page-spacer';
                spacer.style.height = `${spacerHeight}px`;
                spacer.style.width = '100%';
                
                insertBeforeEl.parentNode.insertBefore(spacer, insertBeforeEl);
            }
        });

        // Tính toán tổng số trang sau khi đã chèn các spacer
        const totalHeight = container.scrollHeight;
        const totalPages = Math.ceil(totalHeight / pageHeightPx);

        // Đặt chiều cao tối thiểu của container khớp chính xác với bội số của trang A4
        container.style.minHeight = `${totalPages * pageHeightPx}px`;

        // Thêm hiển thị số trang ở lề dưới mỗi trang
        for (let i = 1; i <= totalPages; i++) {
            const pageNumDiv = document.createElement('div');
            pageNumDiv.className = 'cv-page-number';
            pageNumDiv.style.position = 'absolute';
            pageNumDiv.style.left = '0';
            pageNumDiv.style.width = '100%';
            // Căn giữa lề dưới của trang i (lề dưới từ i*pageHeightPx - bottomMargin đến i*pageHeightPx)
            pageNumDiv.style.top = `${i * pageHeightPx - 35}px`;
            pageNumDiv.style.textAlign = 'center';
            pageNumDiv.style.fontSize = '12px';
            pageNumDiv.style.color = '#64748b'; // Slate 500
            pageNumDiv.style.fontFamily = 'var(--font-sans), sans-serif';
            pageNumDiv.style.fontWeight = '500';
            pageNumDiv.style.pointerEvents = 'none';
            pageNumDiv.innerText = `Trang ${i} / ${totalPages}`;
            container.appendChild(pageNumDiv);
        }
    }

    // Gửi chiều cao thực tế của trang lên cửa sổ cha qua postMessage (CORS-safe)
    function sendHeightToParent() {
        if (window.self === window.top) return; // Chỉ chạy khi trong iframe
        const container = document.querySelector('.a4-page-container');
        if (!container) return;
        const height = Math.max(container.scrollHeight, container.offsetHeight);
        window.parent.postMessage({ type: 'cv-iframe-resize', height: height }, '*');
    }

    // Chạy phân trang khi tài liệu sẵn sàng và khi thay đổi kích thước
    window.addEventListener('load', function() {
        autoPaginate();
        // Gửi chiều cao sau khi phân trang và font đã sẵn sàng
        setTimeout(sendHeightToParent, 300);
    });
    window.addEventListener('resize', function() {
        autoPaginate();
        setTimeout(sendHeightToParent, 100);
    });
    
    // Đảm bảo chạy phân trang khi các tài nguyên khác load xong
    document.addEventListener('DOMContentLoaded', function() {
        autoPaginate();
        setTimeout(sendHeightToParent, 200);
    });
</script>

</body>
</html>
