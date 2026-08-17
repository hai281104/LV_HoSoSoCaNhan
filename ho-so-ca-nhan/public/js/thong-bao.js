/**
 * thong-bao.js — Hệ thống thông báo DPCS
 * Polling tự động mỗi 60 giây, cập nhật badge và dropdown.
 */
(function () {
    'use strict';

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let pollingTimer = null;
    let isDropdownOpen = false;

    // ---------------------------------------------------------
    // Khởi tạo khi DOM ready
    // ---------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        bindToggle();
        bindDocumentClick();
        fetchThongBao();           // Lần đầu ngay khi load
        pollingTimer = setInterval(fetchThongBao, 60000); // Mỗi 60s
    });

    // ---------------------------------------------------------
    // Lấy thông báo từ server
    // ---------------------------------------------------------
    function fetchThongBao() {
        const url = window.API_THONG_BAO_ROUTES?.fetch ?? '/api/thong-bao';
        fetch(url, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(r => r.ok ? r.json() : null)
        .then(data => {
            if (!data || !data.thanh_cong) return;
            renderBadge(data.so_chua_doc);
            renderDanhSach(data.danh_sach);
        })
        .catch(() => { /* silent fail */ });
    }

    // ---------------------------------------------------------
    // Render badge số lượng chưa đọc
    // ---------------------------------------------------------
    function renderBadge(count) {
        const badge = document.getElementById('notif-badge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    // ---------------------------------------------------------
    // Render danh sách thông báo trong dropdown
    // ---------------------------------------------------------
    function renderDanhSach(items) {
        const list = document.getElementById('notif-list');
        if (!list) return;

        if (!items || items.length === 0) {
            list.innerHTML = `
                <div class="notif-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p>Không có thông báo mới</p>
                </div>`;
            return;
        }

        list.innerHTML = items.map(item => buildItemHTML(item)).join('');

        // Bind sự kiện xóa
        list.querySelectorAll('.notif-delete-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const id = this.dataset.id;
                xoaThongBao(id, this.closest('.notif-item'));
            });
        });

        // Bind sự kiện click vào item (đánh dấu đã đọc)
        list.querySelectorAll('.notif-item').forEach(item => {
            item.addEventListener('click', function () {
                const id = this.dataset.id;
                const url = this.dataset.url;
                if (!this.classList.contains('read')) {
                    danhDauDaDoc(id, this);
                }
                if (url) {
                    window.location.href = url;
                }
            });
        });
    }

    // ---------------------------------------------------------
    // Build HTML cho từng item thông báo
    // ---------------------------------------------------------
    function buildItemHTML(item) {
        const iconMap = {
            'bao_mat':       { icon: '🔒', cls: 'notif-icon-security' },
            'ngay_le':       { icon: '🎉', cls: 'notif-icon-holiday' },
            'chung_chi':     { icon: '📜', cls: 'notif-icon-cert' },
            'lich_cong_viec':{ icon: '📅', cls: 'notif-icon-schedule' },
        };
        const meta = iconMap[item.loai] || { icon: '🔔', cls: 'notif-icon-default' };
        const readClass = item.da_doc ? 'read' : 'unread';

        return `
        <div class="notif-item ${readClass}" data-id="${item.id}" data-url="${item.url_lien_ket || ''}">
            <div class="notif-icon ${meta.cls}">${meta.icon}</div>
            <div class="notif-content">
                <div class="notif-title">${escapeHtml(item.tieu_de)}</div>
                <div class="notif-body">${escapeHtml(item.noi_dung)}</div>
                <div class="notif-time">${escapeHtml(item.thoi_gian)}</div>
            </div>
            <button class="notif-delete-btn" data-id="${item.id}" title="Xóa thông báo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>`;
    }

    // ---------------------------------------------------------
    // Đánh dấu 1 thông báo đã đọc
    // ---------------------------------------------------------
    function danhDauDaDoc(id, el) {
        const url = window.API_THONG_BAO_ROUTES?.docPattern 
            ? window.API_THONG_BAO_ROUTES.docPattern.replace(':id', id)
            : '/api/thong-bao/' + id + '/doc';
        postJson(url).then(() => {
            if (el) {
                el.classList.remove('unread');
                el.classList.add('read');
            }
            // Giảm badge
            const badge = document.getElementById('notif-badge');
            if (badge && badge.style.display !== 'none') {
                const cur = parseInt(badge.textContent) || 0;
                const next = cur - 1;
                if (next <= 0) {
                    badge.style.display = 'none';
                } else {
                    badge.textContent = next;
                }
            }
        });
    }

    // ---------------------------------------------------------
    // Đánh dấu tất cả đã đọc
    // ---------------------------------------------------------
    window.docTatCaThongBao = function () {
        const url = window.API_THONG_BAO_ROUTES?.docTatCa ?? '/api/thong-bao/doc-tat-ca';
        postJson(url).then(() => {
            document.querySelectorAll('.notif-item.unread').forEach(el => {
                el.classList.remove('unread');
                el.classList.add('read');
            });
            renderBadge(0);
        });
    };

    // ---------------------------------------------------------
    // Xóa thông báo
    // ---------------------------------------------------------
    function xoaThongBao(id, el) {
        const url = window.API_THONG_BAO_ROUTES?.xoaPattern 
            ? window.API_THONG_BAO_ROUTES.xoaPattern.replace(':id', id)
            : '/api/thong-bao/' + id + '/xoa';
        postJson(url).then(data => {
            if (data && data.thanh_cong) {
                if (el) {
                    el.style.transition = 'opacity 0.2s, max-height 0.3s';
                    el.style.opacity = '0';
                    el.style.overflow = 'hidden';
                    el.style.maxHeight = el.offsetHeight + 'px';
                    setTimeout(() => {
                        el.style.maxHeight = '0';
                        el.style.padding = '0';
                        setTimeout(() => el.remove(), 300);
                    }, 200);
                }
                // Cập nhật lại dữ liệu
                setTimeout(fetchThongBao, 400);
            }
        });
    }

    // ---------------------------------------------------------
    // Toggle dropdown
    // ---------------------------------------------------------
    function bindToggle() {
        const btn = document.getElementById('notif-btn');
        const dropdown = document.getElementById('notif-dropdown');
        if (!btn || !dropdown) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            isDropdownOpen = !isDropdownOpen;
            dropdown.classList.toggle('open', isDropdownOpen);
            btn.setAttribute('aria-expanded', isDropdownOpen);

            if (isDropdownOpen) {
                fetchThongBao(); // Refresh khi mở dropdown
            }
        });
    }

    function bindDocumentClick() {
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('notif-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeDropdown();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDropdown();
        });
    }

    function closeDropdown() {
        const dropdown = document.getElementById('notif-dropdown');
        const btn = document.getElementById('notif-btn');
        if (dropdown) dropdown.classList.remove('open');
        if (btn) btn.setAttribute('aria-expanded', 'false');
        isDropdownOpen = false;
    }

    // ---------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------
    function postJson(url) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
            },
        }).then(r => r.ok ? r.json() : null).catch(() => null);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

})();
