/**
 * chinh-sua.js
 * JavaScript cho modal chỉnh sửa thông tin cơ bản & avatar crop
 * Dùng Cropper.js (CDN)
 */

/* UTILITY: TOAST NOTIFICATION */
function hienToast(loai, noiDung) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const iconSvg = loai === 'success'
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon">
               <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
           </svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon">
               <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
           </svg>`;

    const toast = document.createElement('div');
    toast.className = `toast ${loai}`;
    toast.innerHTML = `${iconSvg}<span>${noiDung}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'toastOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

/* UTILITY: SET LOADING STATE */
function datTrangThaiLoading(btn, dangLoading) {
    if (dangLoading) {
        btn.disabled = true;
        btn.classList.add('loading');
    } else {
        btn.disabled = false;
        btn.classList.remove('loading');
    }
}

/* UTILITY: CSRF TOKEN */
function layToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* MODAL: MỞ / ĐÓNG */
function moModal(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function dongModal(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// Đóng modal khi click ra ngoài
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        dongModal(e.target.id);
        // Dừng cropper nếu đang chạy
        if (window._cropperInstance) {
            window._cropperInstance.destroy();
            window._cropperInstance = null;
        }
    }
});

// Đóng modal khi nhấn Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(m => {
            dongModal(m.id);
        });
        if (window._cropperInstance) {
            window._cropperInstance.destroy();
            window._cropperInstance = null;
        }
    }
});

/* TAB SWITCHING TRONG MODAL */
function khoiTaoTabs(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;

    modal.querySelectorAll('.modal-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            const panelId = this.dataset.panel;

            // Bỏ active tất cả tabs
            modal.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
            modal.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

            // Active tab và panel được chọn
            this.classList.add('active');
            const panel = modal.querySelector(`#${panelId}`);
            if (panel) panel.classList.add('active');
        });
    });
}

/* AVATAR CROP */
let cropperInstance = null;
let currentRatio = 1; // mặc định 1:1

function khoiTaoAvatarCrop() {
    const fileInput    = document.getElementById('avatar-file-input');
    const cropSection  = document.getElementById('crop-section');
    const cropImage    = document.getElementById('crop-image');
    const btnUpload    = document.getElementById('btn-upload-avatar');
    const btnCropApply = document.getElementById('btn-crop-apply');
    const btnCropCancel = document.getElementById('btn-crop-cancel');

    if (!fileInput) return;

    // Nút chọn file
    btnUpload && btnUpload.addEventListener('click', () => fileInput.click());

    // Khi chọn file
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Kiểm tra định dạng
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            hienToast('error', 'Chỉ hỗ trợ ảnh JPG, PNG, WebP!');
            return;
        }

        // Kiểm tra kích thước (tối đa 2MB)
        if (file.size > 2 * 1024 * 1024) {
            hienToast('error', 'Kích thước ảnh không được vượt quá 2MB!');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            cropImage.src = e.target.result;
            cropSection.classList.add('visible');

            // Hủy cropper cũ nếu có
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }

            // Khởi tạo Cropper.js
            cropperInstance = new Cropper(cropImage, {
                aspectRatio: currentRatio,
                viewMode: 1,
                autoCropArea: 0.85,
                responsive: true,
                guides: true,
                center: true,
                highlight: false,
                background: true,
            });

            window._cropperInstance = cropperInstance;
        };
        reader.readAsDataURL(file);
    });

    // Chọn tỉ lệ crop
    document.querySelectorAll('.crop-ratio-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.crop-ratio-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const ratioText = this.dataset.ratio;
            if (ratioText === 'free') {
                currentRatio = NaN;
            } else {
                const parts = ratioText.split(':');
                currentRatio = parseInt(parts[0]) / parseInt(parts[1]);
            }

            if (cropperInstance) {
                cropperInstance.setAspectRatio(currentRatio);
            }
        });
    });

    // Apply crop → upload
    btnCropApply && btnCropApply.addEventListener('click', function () {
        if (!cropperInstance) return;

        const canvas = cropperInstance.getCroppedCanvas({
            maxWidth: 800,
            maxHeight: 800,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        if (!canvas) {
            hienToast('error', 'Không thể xử lý ảnh. Vui lòng thử lại!');
            return;
        }

        const base64Data = canvas.toDataURL('image/jpeg', 0.92);
        uploadAvatar(base64Data, this);
    });

    // Huỷ crop
    btnCropCancel && btnCropCancel.addEventListener('click', function () {
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
            window._cropperInstance = null;
        }
        cropSection.classList.remove('visible');
        fileInput.value = '';
    });
}

function uploadAvatar(base64Data, btn) {
    datTrangThaiLoading(btn, true);
    btn.textContent = 'Đang tải...';

    const urlCapNhat = btn.closest('[data-upload-url]')
        ? btn.closest('[data-upload-url]').dataset.uploadUrl
        : window.ROUTES.capNhatAvatar;

    fetch(urlCapNhat, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json',
        },
        body: JSON.stringify({ avatar_data: base64Data }),
    })
        .then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            const result = isJson ? await res.json() : null;

            if (!res.ok) {
                if (res.status === 422 && result && result.errors) {
                    const errorMsg = Object.values(result.errors).flat().join(', ');
                    throw new Error(errorMsg);
                }
                if (result && result.thong_bao) {
                    throw new Error(result.thong_bao);
                }
                throw new Error('Lỗi máy chủ (' + res.status + ')');
            }
            return result;
        })
        .then(data => {
            if (data && data.thanh_cong) {
                hienToast('success', data.thong_bao || 'Cập nhật avatar thành công!');

                // Cập nhật avatar trên trang
                capNhatHienThiAvatar(data.duong_dan);

                // Đóng phần crop
                const cropSection = document.getElementById('crop-section');
                if (cropSection) cropSection.classList.remove('visible');

                if (cropperInstance) {
                    cropperInstance.destroy();
                    cropperInstance = null;
                    window._cropperInstance = null;
                }

                const fileInput = document.getElementById('avatar-file-input');
                if (fileInput) fileInput.value = '';

                // Đóng modal
                dongModal('modal-chinh-sua');
            } else {
                hienToast('error', (data && data.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[HoSo] Avatar upload error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => {
            btn.textContent = 'Áp dụng & Lưu ảnh';
            datTrangThaiLoading(btn, false);
        });
}

function capNhatHienThiAvatar(duongDan) {
    // Cập nhật tất cả ảnh avatar trên trang
    document.querySelectorAll('.js-avatar-img').forEach(img => {
        img.src = duongDan;
        img.style.display = 'block';
    });
    // Ẩn text avatar (initials)
    document.querySelectorAll('.js-avatar-initials').forEach(el => {
        el.style.display = 'none';
    });
    // Cập nhật preview trong modal
    const previewEl = document.getElementById('modal-avatar-preview');
    if (previewEl) {
        previewEl.innerHTML = `<img src="${duongDan}" alt="Avatar" style="width:100%;height:100%;object-fit:cover;">`;
    }
}

/* FORM THÔNG TIN CƠ BẢN */
function khoiTaoFormCoBan() {
    const form   = document.getElementById('form-chinh-sua-co-ban');
    const btnSave = document.getElementById('btn-luu-chinh-sua');
    if (!form || !btnSave) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        luuThongTinCoBan();
    });
}

function luuThongTinCoBan() {
    const form   = document.getElementById('form-chinh-sua-co-ban');
    const btnSave = document.getElementById('btn-luu-chinh-sua');
    if (!form || !btnSave) return;

    const data = {
        ho_ten:         form.querySelector('[name="ho_ten"]')?.value || '',
        chuc_danh:      form.querySelector('[name="chuc_danh"]')?.value || '',
        ngay_sinh:      form.querySelector('[name="ngay_sinh"]')?.value || '',
        dia_chi:        form.querySelector('[name="dia_chi"]')?.value || '',
        so_dien_thoai:  form.querySelector('[name="so_dien_thoai"]')?.value || '',
        gioi_thieu:     form.querySelector('[name="gioi_thieu"]')?.value || '',
        so_thich:       form.querySelector('[name="so_thich"]')?.value || '',
    };

    if (!data.ho_ten.trim()) {
        hienToast('error', 'Họ và tên không được để trống.');
        form.querySelector('[name="ho_ten"]')?.focus();
        return;
    }
    if (data.ho_ten.length < 2 || data.ho_ten.length > 25) {
        hienToast('error', 'Họ và tên phải có độ dài từ 2 đến 25 ký tự.');
        form.querySelector('[name="ho_ten"]')?.focus();
        return;
    }
    if (data.chuc_danh && (data.chuc_danh.length < 2 || data.chuc_danh.length > 30)) {
        hienToast('error', 'Chức danh phải có độ dài từ 2 đến 30 ký tự.');
        form.querySelector('[name="chuc_danh"]')?.focus();
        return;
    }
    if (data.ngay_sinh) {
        const ngaySinhDate = new Date(data.ngay_sinh);
        const homNay = new Date();
        homNay.setHours(0, 0, 0, 0);
        if (ngaySinhDate > homNay) {
            hienToast('error', 'Ngày sinh không thể ở tương lai.');
            form.querySelector('[name="ngay_sinh"]')?.focus();
            return;
        }
    }
    if (data.so_dien_thoai) {
        const cleanPhone = data.so_dien_thoai.replace(/[\s.-]/g, '');
        const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
        if (!phoneRegex.test(cleanPhone)) {
            hienToast('error', 'Số điện thoại không đúng định dạng (VD: 0912345678 hoặc +84912345678).');
            form.querySelector('[name="so_dien_thoai"]')?.focus();
            return;
        }
        data.so_dien_thoai = cleanPhone;
    }
    if (data.dia_chi && (data.dia_chi.length < 2 || data.dia_chi.length > 30)) {
        hienToast('error', 'Khu vực sinh sống phải có độ dài từ 2 đến 30 ký tự.');
        form.querySelector('[name="dia_chi"]')?.focus();
        return;
    }
    if (data.gioi_thieu && data.gioi_thieu.length > 1000) {
        hienToast('error', 'Giới thiệu bản thân không được vượt quá 1000 ký tự.');
        form.querySelector('[name="gioi_thieu"]')?.focus();
        return;
    }
    if (data.so_thich && data.so_thich.length > 30) {
        hienToast('error', 'Sở thích cá nhân không được vượt quá 30 ký tự.');
        form.querySelector('[name="so_thich"]')?.focus();
        return;
    }

    datTrangThaiLoading(btnSave, true);

    fetch(window.ROUTES.capNhatCoBan, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            const result = isJson ? await res.json() : null;

            if (!res.ok) {
                if (res.status === 422 && result && result.errors) {
                    const errorMsg = Object.values(result.errors).flat().join(', ');
                    throw new Error(errorMsg);
                }
                if (result && result.thong_bao) {
                    throw new Error(result.thong_bao);
                }
                throw new Error('Lỗi máy chủ (' + res.status + ')');
            }
            return result;
        })
        .then(result => {
            if (result && result.thanh_cong) {
                hienToast('success', result.thong_bao || 'Cập nhật thành công!');
                capNhatHienThiCoBan(data);
                dongModal('modal-chinh-sua');
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[HoSo] Fetch error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btnSave, false));
}

function capNhatHienThiCoBan(data) {
    // Cập nhật tên và chức danh hiển thị trên trang
    const elHoTen    = document.getElementById('display-ho-ten');
    const elChucDanh = document.getElementById('display-chuc-danh');
    const elNgaySinh = document.getElementById('display-ngay-sinh');
    const elDiaChi   = document.getElementById('display-dia-chi');
    const elSdt      = document.getElementById('display-so-dien-thoai');
    const elGioiThieu = document.getElementById('display-gioi-thieu');
    const elSoThich  = document.getElementById('display-so-thich');
    const elSidebarName = document.getElementById('sidebar-user-name');
    const elSidebarRole = document.getElementById('sidebar-user-role');

    if (elHoTen)    elHoTen.textContent    = data.ho_ten;
    if (elChucDanh) elChucDanh.textContent = data.chuc_danh || 'Chưa cập nhật';
    if (elNgaySinh && data.ngay_sinh) {
        const parts = data.ngay_sinh.split('-');
        elNgaySinh.textContent = parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : data.ngay_sinh;
    }
    if (elDiaChi)    elDiaChi.textContent    = data.dia_chi    || 'Chưa cập nhật';
    if (elSdt)       elSdt.textContent       = data.so_dien_thoai || 'Chưa cập nhật';
    if (elGioiThieu) {
        if (data.gioi_thieu) {
            elGioiThieu.textContent = data.gioi_thieu;
        } else {
            elGioiThieu.innerHTML = '<span style="font-style: italic; color: #94a3b8;">Chưa có thông tin giới thiệu bản thân.</span>';
        }
    }
    if (elSoThich)   elSoThich.textContent   = data.so_thich   || 'Chưa cập nhật';
    if (elSidebarName) elSidebarName.textContent = data.ho_ten;
    if (elSidebarRole) elSidebarRole.textContent = data.chuc_danh || '';

    // Cập nhật initials avatar
    const tenRutGon = taoTenRutGon(data.ho_ten);
    document.querySelectorAll('.js-avatar-initials').forEach(el => {
        el.textContent = tenRutGon;
    });
    document.querySelectorAll('.js-avatar-initials-sm').forEach(el => {
        el.textContent = tenRutGon;
    });
}

function taoTenRutGon(hoTen) {
    if (!hoTen) return 'ND';
    const cacTu = hoTen.trim().split(/\s+/);
    if (cacTu.length >= 2) {
        return (cacTu[cacTu.length - 2][0] + cacTu[cacTu.length - 1][0]).toUpperCase();
    }
    return hoTen.substring(0, 2).toUpperCase();
}

/* KHỞI TẠO */
document.addEventListener('DOMContentLoaded', function () {
    // Khởi tạo tabs
    khoiTaoTabs('modal-chinh-sua');

    // Khởi tạo form cơ bản
    khoiTaoFormCoBan();

    // Khởi tạo avatar crop
    khoiTaoAvatarCrop();

    // Nút mở modal chỉnh sửa hồ sơ
    const btnMoModal = document.getElementById('btn-mo-modal-chinh-sua');
    if (btnMoModal) {
        btnMoModal.addEventListener('click', () => moModal('modal-chinh-sua'));
    }

    // Nút đóng modal
    document.querySelectorAll('[data-dong-modal]').forEach(btn => {
        btn.addEventListener('click', function () {
            dongModal(this.dataset.dongModal);
        });
    });

    // Khởi tạo menu sidebar trên mobile
    const btnToggleSidebar = document.getElementById('btn-toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (btnToggleSidebar && sidebar && sidebarOverlay) {
        btnToggleSidebar.addEventListener('click', function () {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        sidebar.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        });
    }

    // Xử lý collapse/expand sidebar trên desktop
    const btnCollapseSidebar = document.getElementById('btn-collapse-sidebar');
    if (btnCollapseSidebar && sidebar) {
        // Khôi phục trạng thái từ localStorage
        const sidebarCollapsed = localStorage.getItem('sidebar-collapsed');
        if (sidebarCollapsed === 'true') {
            sidebar.classList.add('collapsed');
            document.body.classList.add('sidebar-collapsed');
        }

        btnCollapseSidebar.addEventListener('click', function (e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
            
            // Lưu trạng thái vào localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
        });
    }
});
