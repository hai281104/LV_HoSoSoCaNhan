/**
 * cai-dat.js — Quản lý tương tác Menu Avatar & Modal Cài đặt, Chính sách, Đóng góp ý kiến
 */
(function () {
    'use strict';

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    document.addEventListener('DOMContentLoaded', function () {
        khoiTaoAvatarDropdown();
        khoiTaoSettingsModals();
    });

    // -------------------------------------------------------------
    // 1. QUẢN LÝ AVATAR POPUP MENU (DROPDOWN)
    // -------------------------------------------------------------
    function khoiTaoAvatarDropdown() {
        const trigger = document.getElementById('avatarTrigger');
        const dropdown = document.getElementById('avatarDropdown');

        if (!trigger || !dropdown) return;

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
            // Cập nhật background cho trigger khi mở menu
            if (dropdown.classList.contains('open')) {
                trigger.style.backgroundColor = 'rgba(255, 255, 255, 0.05)';
            } else {
                trigger.style.backgroundColor = '';
            }
        });

        // Tránh đóng dropdown khi quét chọn văn bản rồi thả chuột ở ngoài
        let mousedownInside = false;
        document.addEventListener('mousedown', function (e) {
            mousedownInside = trigger.contains(e.target) || dropdown.contains(e.target);
        });

        // Click ra ngoài để đóng dropdown
        document.addEventListener('click', function (e) {
            if (!mousedownInside && !trigger.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
                trigger.style.backgroundColor = '';
            }
        });

        // Rê chuột ra ngoài khu vực người dùng thì tự động đóng menu (có độ trễ ngắn 200ms để mượt mà)
        const userContainer = document.querySelector('.sidebar-user');
        let mouseLeaveTimeout = null;
        if (userContainer) {
            userContainer.addEventListener('mouseleave', function () {
                mouseLeaveTimeout = setTimeout(() => {
                    dropdown.classList.remove('open');
                    trigger.style.backgroundColor = '';
                }, 200);
            });

            userContainer.addEventListener('mouseenter', function () {
                if (mouseLeaveTimeout) {
                    clearTimeout(mouseLeaveTimeout);
                    mouseLeaveTimeout = null;
                }
            });
        }

        // Đóng dropdown khi bấm nút Esc
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                dropdown.classList.remove('open');
                trigger.style.backgroundColor = '';
            }
        });
    }

    // -------------------------------------------------------------
    // 2. QUẢN LÝ CÁC MODAL & TAB CÀI ĐẶT
    // -------------------------------------------------------------
    function khoiTaoSettingsModals() {
        // Triggers
        const btnOpenSettings = document.getElementById('btn-open-settings');
        const btnOpenPolicy = document.getElementById('btn-open-policy');
        const btnOpenFeedback = document.getElementById('btn-open-feedback');

        // Modals
        const settingsModal = document.getElementById('settingsModal');
        const policyModal = document.getElementById('policyModal');
        const feedbackModal = document.getElementById('feedbackModal');

        // Bấm mở Modal Cài đặt
        if (btnOpenSettings && settingsModal) {
            btnOpenSettings.addEventListener('click', function () {
                dongTatCaModals();
                const dropdown = document.getElementById('avatarDropdown');
                const trigger = document.getElementById('avatarTrigger');
                if (dropdown) dropdown.classList.remove('open');
                if (trigger) trigger.style.backgroundColor = '';
                settingsModal.style.display = 'flex';
                setTimeout(() => settingsModal.classList.add('open'), 10);
            });
        }

        // Bấm mở Modal Chính sách
        if (btnOpenPolicy && policyModal) {
            btnOpenPolicy.addEventListener('click', function () {
                dongTatCaModals();
                const dropdown = document.getElementById('avatarDropdown');
                const trigger = document.getElementById('avatarTrigger');
                if (dropdown) dropdown.classList.remove('open');
                if (trigger) trigger.style.backgroundColor = '';
                policyModal.style.display = 'flex';
                setTimeout(() => policyModal.classList.add('open'), 10);
            });
        }

        // Bấm mở Modal Đóng góp ý kiến
        if (btnOpenFeedback && feedbackModal) {
            btnOpenFeedback.addEventListener('click', function () {
                dongTatCaModals();
                const dropdown = document.getElementById('avatarDropdown');
                const trigger = document.getElementById('avatarTrigger');
                if (dropdown) dropdown.classList.remove('open');
                if (trigger) trigger.style.backgroundColor = '';
                feedbackModal.style.display = 'flex';
                setTimeout(() => feedbackModal.classList.add('open'), 10);
            });
        }

        // Đóng modal khi bấm phím Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                dongSettingsModal();
                dongPolicyModal();
                dongFeedbackModal();
            }
        });

        // Đóng modal khi click ra ngoài vùng card
        [settingsModal, policyModal, feedbackModal].forEach(modal => {
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        if (modal === settingsModal) dongSettingsModal();
                        else if (modal === policyModal) dongPolicyModal();
                        else if (modal === feedbackModal) dongFeedbackModal();
                    }
                });
            }
        });

        // Tab switches inside Settings
        const tabButtons = document.querySelectorAll('.cai-dat-tab-btn');
        const tabPanes = document.querySelectorAll('.cai-dat-tab-pane');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.dataset.target;

                tabButtons.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                this.classList.add('active');
                const pane = document.getElementById(targetId);
                if (pane) pane.classList.add('active');
            });
        });

        // Xóa tài khoản: Kiểm tra từ khóa xác nhận "delete"
        const inputXacNhanXoa = document.getElementById('inputXacNhanXoa');
        const btnXoaTaiKhoan = document.getElementById('btnXoaTaiKhoan');

        if (inputXacNhanXoa && btnXoaTaiKhoan) {
            inputXacNhanXoa.addEventListener('input', function () {
                const value = this.value.trim().toLowerCase();
                if (value === 'delete') {
                    btnXoaTaiKhoan.removeAttribute('disabled');
                } else {
                    btnXoaTaiKhoan.setAttribute('disabled', 'true');
                }
            });
        }

        // --- SUBMIT CÁC FORM AJAX ---
        // 1. Đổi mật khẩu
        const formDoiMatKhau = document.getElementById('formDoiMatKhau');
        if (formDoiMatKhau) {
            formDoiMatKhau.addEventListener('submit', function (e) {
                e.preventDefault();
                xoaCacLoiForm(formDoiMatKhau);

                const btnSubmit = document.getElementById('btnSubmitDoiMatKhau');
                btnSubmit.setAttribute('disabled', 'true');
                btnSubmit.textContent = 'Đang cập nhật...';

                const formData = new FormData(formDoiMatKhau);
                const jsonData = {};
                formData.forEach((value, key) => jsonData[key] = value);

                guiAjax('/ho-so/cai-dat/doi-mat-khau', jsonData)
                    .then(data => {
                        if (data && data.thanh_cong) {
                            hienThiToast(data.thong_bao, 'success');
                            formDoiMatKhau.reset();
                            dongSettingsModal();
                        } else if (data && data.errors) {
                            hienThiLoiForm(formDoiMatKhau, data.errors);
                            hienThiToast('Vui lòng kiểm tra lại thông tin.', 'error');
                        } else {
                            hienThiToast(data?.thong_bao ?? 'Đã xảy ra lỗi. Vui lòng thử lại.', 'error');
                        }
                    })
                    .finally(() => {
                        btnSubmit.removeAttribute('disabled');
                        btnSubmit.textContent = 'Cập nhật mật khẩu';
                    });
            });
        }

        // 2. Bật/tắt thông báo
        const toggleThongBao = document.getElementById('toggleThongBao');
        if (toggleThongBao) {
            toggleThongBao.addEventListener('change', function () {
                const checked = this.checked;
                guiAjax('/ho-so/cai-dat/thong-bao', { thong_bao_bat: checked ? 1 : 0 })
                    .then(data => {
                        if (data && data.thanh_cong) {
                            hienThiToast(data.thong_bao, 'success');
                        } else {
                            hienThiToast('Không thể cập nhật cấu hình thông báo.', 'error');
                            // Khôi phục lại trạng thái toggle cũ
                            toggleThongBao.checked = !checked;
                        }
                    })
                    .catch(() => {
                        hienThiToast('Đã xảy ra lỗi kết nối.', 'error');
                        toggleThongBao.checked = !checked;
                    });
            });
        }

        // 3. Xóa tài khoản
        if (btnXoaTaiKhoan) {
            btnXoaTaiKhoan.addEventListener('click', function () {
                if (!confirm('Bạn có chắc chắn muốn xóa tài khoản này không? Hành động này sẽ vô hiệu hóa tài khoản ngay lập tức.')) {
                    return;
                }

                btnXoaTaiKhoan.setAttribute('disabled', 'true');
                btnXoaTaiKhoan.textContent = 'Đang xử lý...';

                guiAjax('/ho-so/cai-dat/xoa-tai-khoan', { xac_nhan: inputXacNhanXoa.value })
                    .then(data => {
                        if (data && data.thanh_cong) {
                            hienThiToast(data.thong_bao, 'success');
                            setTimeout(() => {
                                window.location.href = '/dang-nhap';
                            }, 1500);
                        } else {
                            hienThiToast(data?.thong_bao ?? 'Lỗi khi xóa tài khoản.', 'error');
                            btnXoaTaiKhoan.removeAttribute('disabled');
                            btnXoaTaiKhoan.textContent = 'Xóa tài khoản của tôi';
                        }
                    })
                    .catch(() => {
                        hienThiToast('Lỗi kết nối máy chủ.', 'error');
                        btnXoaTaiKhoan.removeAttribute('disabled');
                        btnXoaTaiKhoan.textContent = 'Xóa tài khoản của tôi';
                    });
            });
        }

        // 4. Gửi đóng góp ý kiến
        const formFeedback = document.getElementById('formFeedback');
        if (formFeedback) {
            formFeedback.addEventListener('submit', function (e) {
                e.preventDefault();
                xoaCacLoiForm(formFeedback);

                const btnSubmit = document.getElementById('btnSubmitFeedback');
                btnSubmit.setAttribute('disabled', 'true');
                btnSubmit.textContent = 'Đang gửi...';

                const formData = new FormData(formFeedback);
                const jsonData = {};
                formData.forEach((value, key) => jsonData[key] = value);

                guiAjax('/ho-so/cai-dat/y-kien', jsonData)
                    .then(data => {
                        if (data && data.thanh_cong) {
                            hienThiToast(data.thong_bao, 'success');
                            formFeedback.reset();
                            dongFeedbackModal();
                        } else if (data && data.errors) {
                            hienThiLoiForm(formFeedback, data.errors);
                        } else {
                            hienThiToast(data?.thong_bao ?? 'Đã xảy ra lỗi khi gửi ý kiến.', 'error');
                        }
                    })
                    .finally(() => {
                        btnSubmit.removeAttribute('disabled');
                        btnSubmit.textContent = 'Gửi đóng góp';
                    });
            });
        }
    }

    // -------------------------------------------------------------
    // HÀM HELPER ĐÓNG MỞ CÁC MODAL
    // -------------------------------------------------------------
    function dongTatCaModals() {
        const modals = document.querySelectorAll('.cai-dat-modal-overlay');
        modals.forEach(m => {
            m.classList.remove('open');
            m.style.display = 'none';
        });
    }

    window.dongSettingsModal = function () {
        const modal = document.getElementById('settingsModal');
        if (modal) {
            modal.classList.remove('open');
            setTimeout(() => {
                modal.style.display = 'none';
                // Reset form mật khẩu và input delete khi đóng
                const formDoiMatKhau = document.getElementById('formDoiMatKhau');
                if (formDoiMatKhau) {
                    formDoiMatKhau.reset();
                    xoaCacLoiForm(formDoiMatKhau);
                }
                const inputXacNhanXoa = document.getElementById('inputXacNhanXoa');
                const btnXoaTaiKhoan = document.getElementById('btnXoaTaiKhoan');
                if (inputXacNhanXoa && btnXoaTaiKhoan) {
                    inputXacNhanXoa.value = '';
                    btnXoaTaiKhoan.setAttribute('disabled', 'true');
                }
            }, 300);
        }
    };

    window.dongPolicyModal = function () {
        const modal = document.getElementById('policyModal');
        if (modal) {
            modal.classList.remove('open');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    };

    window.dongFeedbackModal = function () {
        const modal = document.getElementById('feedbackModal');
        if (modal) {
            modal.classList.remove('open');
            setTimeout(() => {
                modal.style.display = 'none';
                const formFeedback = document.getElementById('formFeedback');
                if (formFeedback) {
                    formFeedback.reset();
                    xoaCacLoiForm(formFeedback);
                }
            }, 300);
        }
    };

    // -------------------------------------------------------------
    // HÀM GỬI AJAX VÀ THỂ HIỆN LỖI/TOAST
    // -------------------------------------------------------------
    function guiAjax(url, bodyData = {}) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(bodyData)
        })
        .then(response => {
            if (response.status === 422) {
                return response.json(); // Trả về lỗi validate
            }
            if (response.ok) {
                return response.json();
            }
            return response.json().then(err => Promise.reject(err)).catch(() => Promise.reject({ thong_bao: 'Lỗi không xác định.' }));
        })
        .catch(err => {
            console.error('AJAX Error:', err);
            return { thanh_cong: false, thong_bao: err.message ?? 'Đã xảy ra lỗi khi kết nối máy chủ.' };
        });
    }

    function hienThiLoiForm(formEl, errors) {
        Object.keys(errors).forEach(fieldName => {
            const errorMsg = errors[fieldName][0] ?? 'Lỗi không hợp lệ.';
            const errSpan = formEl.querySelector(`#err-${fieldName}`);
            if (errSpan) {
                errSpan.textContent = errorMsg;
                errSpan.style.display = 'block';
            }
            // Thêm class lỗi vào input
            const inputEl = formEl.querySelector(`[name="${fieldName}"]`);
            if (inputEl) {
                inputEl.style.borderColor = '#ef4444';
            }
        });
    }

    function xoaCacLoiForm(formEl) {
        formEl.querySelectorAll('.cai-dat-error-msg').forEach(span => {
            span.textContent = '';
            span.style.display = 'none';
        });
        formEl.querySelectorAll('.cai-dat-input, .cai-dat-textarea').forEach(input => {
            input.style.borderColor = '';
        });
    }

    // Custom Toast Helper
    function hienThiToast(message, type = 'success') {
        // Xóa toast cũ nếu có
        const oldToast = document.querySelector('.cai-dat-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.className = `cai-dat-toast ${type}`;
        
        // Cấu trúc css cho toast
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '8px';
        toast.style.color = '#ffffff';
        toast.style.fontSize = '13.5px';
        toast.style.fontWeight = '600';
        toast.style.zIndex = '9999';
        toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.3)';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '8px';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';

        let icon = '';
        if (type === 'success') {
            toast.style.backgroundColor = '#10b981'; // Xanh lá
            icon = '✓';
        } else if (type === 'error') {
            toast.style.backgroundColor = '#ef4444'; // Đỏ
            icon = '✕';
        } else {
            toast.style.backgroundColor = '#3b82f6'; // Xanh dương
            icon = 'ℹ';
        }

        toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
        document.body.appendChild(toast);

        // Animation in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 50);

        // Animation out
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

})();
