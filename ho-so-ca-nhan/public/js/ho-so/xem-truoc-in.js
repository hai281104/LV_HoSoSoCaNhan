let isGeneratingPdf = false;

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
    
    // Các phần tử cần tránh ngắt đôi
    const targets = document.querySelectorAll('.cv-timeline-item, .cv-intro-text, .cv-pill-container, .cv-link-card, .cv-contact-item');
    
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
        const section = el.closest('.cv-section');
        let insertBeforeEl = el;
        let referenceTop = topRelativeToContainer;
        
        if (section) {
            const firstTarget = section.querySelector('.cv-timeline-item, .cv-intro-text, .cv-pill-container, .cv-link-card, .cv-contact-item');
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

function downloadPdfDirectly(autoClose = false) {
    if (isGeneratingPdf) return;
    isGeneratingPdf = true;

    const element = document.querySelector('.a4-page-container');
    if (!element) {
        isGeneratingPdf = false;
        return;
    }

    const clone = element.cloneNode(true);
    clone.classList.add('generating-pdf');
    
    // Lấy tên file từ cấu hình hoặc mặc định
    const fileName = (window.CV_CONFIG && window.CV_CONFIG.fileName) ? window.CV_CONFIG.fileName : 'Ho-so-nang-luc.pdf';

    const opt = {
        margin:       0,
        filename:     fileName,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, scrollX: 0, scrollY: 0 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    const btn = document.querySelector('.btn-action.print-pdf');
    const originalText = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span>⏳ Đang xuất file...</span>';
    }

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
            <div style="font-size: 14px; color: #475569; margin-bottom: 24px;">Vui lòng đợi giây lát. Trình duyệt đang tải Hồ sơ về máy và tab này sẽ tự động đóng.</div>
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
    
    const urlParams = new URLSearchParams(window.location.search);
    const isEncrypt = urlParams.get('encrypt') === '1';
    const password = urlParams.get('password') || '';

    if (isEncrypt && password) {
        html2pdf().from(clone).set(opt).output('blob')
        .then((pdfBlob) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const arrayBuffer = e.target.result;
                const wordArray = CryptoJS.lib.WordArray.create(new Uint8Array(arrayBuffer));
                const encrypted = CryptoJS.AES.encrypt(wordArray, password).toString();
                
                const encryptedBlob = new Blob([encrypted], { type: 'text/plain' });
                const downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(encryptedBlob);
                downloadLink.download = fileName + '.enc';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                
                clone.remove();
                isGeneratingPdf = false;
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }

                if (autoClose) {
                    if (overlay) {
                        overlay.innerHTML = `
                            <div style="font-size: 22px; font-weight: 700; color: #10b981; margin-bottom: 8px;">🎉 Mã hóa & xuất file PDF thành công!</div>
                            <div style="font-size: 14px; color: #475569;">Đang đóng tab này...</div>
                        `;
                    }
                    setTimeout(() => {
                        window.close();
                    }, 1000);
                }
            };
            reader.readAsArrayBuffer(pdfBlob);
        })
        .catch(err => {
            console.error('Lỗi mã hóa PDF:', err);
            clone.remove();
            isGeneratingPdf = false;
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
            if (overlay) overlay.remove();
            alert('Không thể mã hóa PDF trực tiếp. Vui lòng thử lại.');
        });
    } else {
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

            // Chạy lại phân trang để đảm bảo
            autoPaginate();

            alert('Không thể tải PDF trực tiếp. Vui lòng thử lại hoặc dùng tổ hợp Ctrl+P để lưu.');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    autoPaginate();

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('download') === '1') {
        const toolbar = document.getElementById('standalone-toolbar');
        if (toolbar) toolbar.style.display = 'none';

        window.addEventListener('load', () => {
            setTimeout(() => {
                downloadPdfDirectly(true);
            }, 800);
        });
    }
});

// Chạy phân trang khi thay đổi kích thước và khi tài nguyên tải xong
window.addEventListener('load', autoPaginate);
window.addEventListener('resize', autoPaginate);
