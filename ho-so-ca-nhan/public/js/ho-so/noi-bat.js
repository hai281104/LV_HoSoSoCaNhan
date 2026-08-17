/**
 * noi-bat.js
 * AJAX toggle "Nổi bật" dùng chung cho tất cả module hồ sơ.
 * Sử dụng: window.ROUTES.toggleNoiBat[module] phải được khai báo trong từng view.
 */

/**
 * Toggle trạng thái nổi bật cho một bản ghi.
 * @param {string} module  - 'hoc_van' | 'kinh_nghiem' | 'du_an' | 'chung_chi' | 'thanh_tuu'
 * @param {number} id      - ID của bản ghi
 * @param {HTMLElement} btn - Nút star được click
 */
function toggleNoiBat(module, id, btn) {
    if (!btn || btn.dataset.loading === 'true') return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')
        ? document.querySelector('meta[name="csrf-token"]').content
        : '';

    // Lấy route từ window.ROUTES
    const routes = window.ROUTES && window.ROUTES.toggleNoiBat;
    if (!routes || !routes[module]) {
        console.error('[toggleNoiBat] Route không tìm thấy cho module:', module);
        return;
    }

    const url = routes[module].replace('__ID__', id);

    // Đặt trạng thái loading
    btn.dataset.loading = 'true';
    btn.style.opacity = '0.5';
    btn.style.pointerEvents = 'none';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.thanh_cong) {
            const isNoiBat = data.noi_bat === 1;

            // Cập nhật trạng thái nút
            btn.dataset.noiBat = isNoiBat ? '1' : '0';
            btn.title = isNoiBat ? 'Bỏ đánh dấu nổi bật' : 'Đánh dấu nổi bật';
            btn.classList.toggle('active', isNoiBat);

            // Cập nhật thuộc tính data-noi-bat trên phần tử bọc ngoài phục vụ bộ lọc
            const filteredItem = btn.closest('.timeline-item') || btn.closest('.experience-list-item') 
                                || btn.closest('.project-card') || btn.closest('.certificate-card') 
                                || btn.closest('.achievement-card');
            if (filteredItem) {
                filteredItem.dataset.noiBat = isNoiBat ? '1' : '0';
            }

            // Cập nhật badge trên card cha
            const card = btn.closest('[data-id]') || btn.closest('.education-card') 
                        || btn.closest('.experience-list-item') || btn.closest('.project-card')
                        || btn.closest('.certificate-card') || btn.closest('.achievement-card');

            if (card) {
                let badge = card.querySelector('.badge-noi-bat');
                if (isNoiBat) {
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'badge-noi-bat';
                        badge.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg> Nổi bật';

                        // Thêm vào vị trí phù hợp tùy card (ưu tiên tên/tiêu đề để đồng bộ layout)
                        const header = card.querySelector('.achievement-name, .certificate-name, .education-card-header, .item-header, .card-header, .project-card-header, .cert-card-header, .achieve-card-header, .certificate-card-header, .achievement-card-header');
                        if (header) {
                            header.insertBefore(badge, header.firstChild);
                        } else {
                            card.insertBefore(badge, card.firstChild);
                        }
                    }
                } else {
                    if (badge) badge.remove();
                }
            }

            // Hiện toast
            showNoiBatToast(data.thong_bao, isNoiBat);
        } else {
            showNoiBatToast(data.thong_bao || 'Có lỗi xảy ra.', false, true);
        }
    })
    .catch(() => {
        showNoiBatToast('Lỗi kết nối máy chủ.', false, true);
    })
    .finally(() => {
        btn.dataset.loading = 'false';
        btn.style.opacity = '';
        btn.style.pointerEvents = '';
    });
}

/**
 * Hiện toast thông báo cho toggle nổi bật.
 */
function showNoiBatToast(message, isSuccess = true, isError = false) {
    // Dùng hàm showToast chung nếu có
    if (typeof showToast === 'function') {
        showToast(message, isError ? 'error' : (isSuccess ? 'success' : 'info'));
        return;
    }

    // Fallback toast đơn giản
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.style.cssText = `
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 500;
        color: #fff;
        background: ${isError ? '#ef4444' : '#10b981'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    `;
    toast.innerHTML = (isSuccess && !isError ? '⭐ ' : isError ? '❌ ' : 'ℹ️ ') + message;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}
