/**
 * thanh-tuu.js
 * JavaScript cho chức năng quản lý Thành tựu cá nhân
 */

let achievementCropper = null;

document.addEventListener('DOMContentLoaded', function () {
    khoiTaoFormThanhTuu();
    khoiTaoCropperThanhTuu();
    khoiTaoBoLocThanhTuu();
    khoiTaoLightboxThanhTuu();

    // Nút mở modal thêm mới thành tựu
    const btnThemThanhTuu = document.getElementById('btn-them-thanh-tuu');
    if (btnThemThanhTuu) {
        btnThemThanhTuu.addEventListener('click', function () {
            moModalThemThanhTuu();
        });
    }

    // Đếm ký tự mô tả thành tựu
    const textareaMoTa = document.getElementById('input-achievement-desc');
    const descCounter = document.getElementById('achievement-desc-counter');
    if (textareaMoTa && descCounter) {
        textareaMoTa.addEventListener('input', function () {
            descCounter.textContent = this.value.length;
        });
    }

    // Nút Sửa trong modal chi tiết thành tựu
    const btnDetailSua = document.getElementById('btn-detail-sua-thanh-tuu');
    if (btnDetailSua) {
        btnDetailSua.addEventListener('click', function () {
            if (window.currentAchievementItem) {
                dongModal('modal-chi-tiet-thanh-tuu');
                moModalSuaThanhTuu(window.currentAchievementItem);
            }
        });
    }

    // Nút Xóa trong modal chi tiết thành tựu
    const btnDetailXoa = document.getElementById('btn-detail-xoa-thanh-tuu');
    if (btnDetailXoa) {
        btnDetailXoa.addEventListener('click', function () {
            if (window.currentAchievementItem) {
                dongModal('modal-chi-tiet-thanh-tuu');
                xoaThanhTuu(window.currentAchievementItem.id);
            }
        });
    }
});

/**
 * Mở modal thêm mới (reset form)
 */
function moModalThemThanhTuu() {
    try {
        const form = document.getElementById('form-thanh-tuu');
        if (!form) return;

        form.reset();
        
        const inputId = document.getElementById('input-achievement-id');
        if (inputId) inputId.value = '';
        
        const inputCover = document.getElementById('input-achievement-cover-base64');
        if (inputCover) inputCover.value = '';
        
        const inputCategory = document.getElementById('input-achievement-category');
        if (inputCategory) inputCategory.value = 'giai_thuong';
        
        const modalTitle = document.getElementById('modal-thanh-tuu-title');
        if (modalTitle) modalTitle.textContent = 'Thêm mới thành tựu';

        // Reset date fields and indicator
        const checkboxNoTime = document.getElementById('checkbox-no-time');
        const inputTimeSpecific = document.getElementById('input-time-specific');
        const indicatorTimeRequired = document.getElementById('indicator-time-required');
        if (checkboxNoTime) checkboxNoTime.checked = false;
        if (inputTimeSpecific) {
            inputTimeSpecific.value = '';
            inputTimeSpecific.disabled = false;
            inputTimeSpecific.required = true;
        }
        if (indicatorTimeRequired) indicatorTimeRequired.style.display = 'inline';

        // Reset Link input
        const linkInput = document.getElementById('input-achievement-link');
        if (linkInput) linkInput.value = '';

        // Reset crop & previews
        resetCoverImagePicker();

        // Reset character counter
        const descCounter = document.getElementById('achievement-desc-counter');
        if (descCounter) descCounter.textContent = '0';

        // Ẩn nút xóa bản ghi (vì là thêm mới) và xóa sự kiện click cũ
        const btnXoa = document.getElementById('btn-xoa-thanh-tuu');
        if (btnXoa) {
            btnXoa.style.display = 'none';
            btnXoa.onclick = null;
        }

        moModal('modal-thanh-tuu');
    } catch (err) {
        console.error('Lỗi khi mở modal thêm thành tựu:', err);
    }
}

/**
 * Mở modal chỉnh sửa và điền dữ liệu có sẵn
 */
function moModalSuaThanhTuu(itemJson) {
    const form = document.getElementById('form-thanh-tuu');
    if (!form) return;

    try {
        const item = typeof itemJson === 'string' ? JSON.parse(itemJson) : itemJson;

        document.getElementById('input-achievement-id').value = item.id || '';
        document.getElementById('input-achievement-name').value = item.ten_thanh_tuu || '';
        document.getElementById('input-achievement-issuer').value = item.to_chuc_cap || '';
        document.getElementById('input-achievement-time').value = item.thoi_gian || '';
        document.getElementById('input-achievement-category').value = item.phan_loai || 'giai_thuong';
        document.getElementById('input-achievement-desc').value = item.mo_ta || '';
        
        // Update character counter
        const descCounter = document.getElementById('achievement-desc-counter');
        if (descCounter) {
            descCounter.textContent = (item.mo_ta || '').length;
        }

        // Link minh chứng
        const linkInput = document.getElementById('input-achievement-link');
        if (linkInput) {
            linkInput.value = item.link_minh_chung || '';
        }

        // Parse thoi_gian
        const checkboxNoTime = document.getElementById('checkbox-no-time');
        const inputTimeSpecific = document.getElementById('input-time-specific');
        const indicatorTimeRequired = document.getElementById('indicator-time-required');
        
        let hasValidDate = false;
        if (item.thoi_gian) {
            const dateMatch = item.thoi_gian.trim().match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
            if (dateMatch) {
                const day = dateMatch[1];
                const month = dateMatch[2];
                const year = dateMatch[3];
                if (inputTimeSpecific) {
                    inputTimeSpecific.value = `${year}-${month}-${day}`;
                    inputTimeSpecific.disabled = false;
                    inputTimeSpecific.required = true;
                }
                if (checkboxNoTime) checkboxNoTime.checked = false;
                if (indicatorTimeRequired) indicatorTimeRequired.style.display = 'inline';
                hasValidDate = true;
            }
        }
        
        if (!hasValidDate) {
            if (inputTimeSpecific) {
                inputTimeSpecific.value = '';
                inputTimeSpecific.disabled = true;
                inputTimeSpecific.required = false;
            }
            if (checkboxNoTime) checkboxNoTime.checked = true;
            if (indicatorTimeRequired) indicatorTimeRequired.style.display = 'none';
        }

        // Reset crop & previews
        resetCoverImagePicker();

        // Điền ảnh hiện tại nếu có
        const previewImg = document.getElementById('cover-preview-img');
        const previewPlaceholder = document.getElementById('cover-preview-placeholder');
        const btnDeleteCover = document.getElementById('btn-delete-cover');
        const hiddenCoverInput = document.getElementById('input-achievement-cover-base64');

        if (item.anh_minh_hoa) {
            previewImg.src = '/' + item.anh_minh_hoa;
            previewImg.style.display = 'block';
            previewPlaceholder.style.display = 'none';
            btnDeleteCover.style.display = 'inline-flex';
            hiddenCoverInput.value = item.anh_minh_hoa; // Gán đường dẫn hiện tại
        }

        document.getElementById('modal-thanh-tuu-title').textContent = 'Cập nhật thành tựu';

        // Hiển thị nút xóa bản ghi
        const btnXoa = document.getElementById('btn-xoa-thanh-tuu');
        if (btnXoa) {
            btnXoa.style.display = 'inline-flex';
            // Cập nhật sự kiện click để xóa đúng ID
            btnXoa.onclick = function() {
                xoaThanhTuu(item.id);
            };
        }

        moModal('modal-thanh-tuu');
    } catch (e) {
        console.error('Lỗi khi mở modal sửa thành tựu:', e);
        hienToast('error', 'Không thể hiển thị thông tin thành tựu.');
    }
}

/**
 * Khởi tạo sự kiện submit form & nút xóa
 */
function khoiTaoFormThanhTuu() {
    const form = document.getElementById('form-thanh-tuu');
    const btnSave = document.getElementById('btn-luu-thanh-tuu');
    const checkboxNoTime = document.getElementById('checkbox-no-time');
    const inputTimeSpecific = document.getElementById('input-time-specific');
    const indicatorTimeRequired = document.getElementById('indicator-time-required');

    if (!form || !btnSave) return;

    if (checkboxNoTime && inputTimeSpecific) {
        checkboxNoTime.addEventListener('change', function() {
            if (checkboxNoTime.checked) {
                inputTimeSpecific.disabled = true;
                inputTimeSpecific.required = false;
                inputTimeSpecific.value = '';
                if (indicatorTimeRequired) indicatorTimeRequired.style.display = 'none';
            } else {
                inputTimeSpecific.disabled = false;
                inputTimeSpecific.required = true;
                if (indicatorTimeRequired) indicatorTimeRequired.style.display = 'inline';
            }
        });
    }

    btnSave.addEventListener('click', function (e) {
        e.preventDefault();
        luuThanhTuu(btnSave);
    });
}

/**
 * Validate và gửi AJAX lưu thành tựu
 */
function luuThanhTuu(btn) {
    const form = document.getElementById('form-thanh-tuu');
    if (!form) return;

    const checkboxNoTime = document.getElementById('checkbox-no-time');
    const inputTimeSpecific = document.getElementById('input-time-specific');
    let computedTime = '';

    if (checkboxNoTime && checkboxNoTime.checked) {
        computedTime = '';
    } else if (inputTimeSpecific) {
        const val = inputTimeSpecific.value; // YYYY-MM-DD
        if (!val) {
            hienToast('error', 'Thời gian đạt được không được để trống.');
            inputTimeSpecific.focus();
            return;
        }
        const parts = val.split('-');
        if (parts.length === 3) {
            computedTime = `${parts[2]}/${parts[1]}/${parts[0]}`;
        } else {
            hienToast('error', 'Thời gian đạt được không hợp lệ.');
            inputTimeSpecific.focus();
            return;
        }
    }

    document.getElementById('input-achievement-time').value = computedTime;

    const linkMinhChung = document.getElementById('input-achievement-link').value.trim();

    const data = {
        id:              document.getElementById('input-achievement-id').value || null,
        ten_thanh_tuu:   document.getElementById('input-achievement-name').value.trim(),
        to_chuc_cap:     document.getElementById('input-achievement-issuer').value.trim(),
        thoi_gian:       computedTime,
        phan_loai:       document.getElementById('input-achievement-category').value,
        mo_ta:           document.getElementById('input-achievement-desc').value.trim(),
        anh_minh_hoa:    document.getElementById('input-achievement-cover-base64').value.trim(),
        link_minh_chung: linkMinhChung || null,
    };

    console.log('[ThanhTuu] Saving payload:', data);

    // Client-side validations
    if (!['giai_thuong', 'hoc_bong', 'danh_hieu'].includes(data.phan_loai)) {
        hienToast('error', 'Vui lòng chọn phân loại thành tựu hợp lệ.');
        document.getElementById('input-achievement-category').focus();
        return;
    }

    const regexText = /^[\p{L}\p{N}\s,\.\-\(\)\/\+&]+$/u;
    const regexTime = /^[\p{L}\p{N}\s\-_:\.\/\(\)]+$/u;

    // 1. Tên thành tựu: 2-100 ký tự
    if (!data.ten_thanh_tuu) {
        hienToast('error', 'Tên thành tựu không được để trống.');
        document.getElementById('input-achievement-name').focus();
        return;
    }
    if (data.ten_thanh_tuu.length < 2 || data.ten_thanh_tuu.length > 100) {
        hienToast('error', 'Tên thành tựu phải có độ dài từ 2 đến 100 ký tự.');
        document.getElementById('input-achievement-name').focus();
        return;
    }

    // 2. Đơn vị trao: 2-100 ký tự (nếu có)
    if (data.to_chuc_cap) {
        if (data.to_chuc_cap.length < 2 || data.to_chuc_cap.length > 100) {
            hienToast('error', 'Đơn vị trao phải có độ dài từ 2 đến 100 ký tự.');
            document.getElementById('input-achievement-issuer').focus();
            return;
        }
        if (!regexText.test(data.to_chuc_cap)) {
            hienToast('error', 'Đơn vị trao không được chứa ký tự đặc biệt.');
            document.getElementById('input-achievement-issuer').focus();
            return;
        }
    }

    // 3. Thời gian: tối đa 50 ký tự (nếu có)
    if (data.thoi_gian) {
        if (data.thoi_gian.length > 50) {
            hienToast('error', 'Thời gian đạt được không được vượt quá 50 ký tự.');
            if (inputTimeSpecific) inputTimeSpecific.focus();
            return;
        }
        if (!regexTime.test(data.thoi_gian)) {
            hienToast('error', 'Thời gian chứa ký tự đặc biệt lạ.');
            if (inputTimeSpecific) inputTimeSpecific.focus();
            return;
        }
    }

    // 4. Mô tả: tối đa 500 ký tự
    if (data.mo_ta && data.mo_ta.length > 500) {
        hienToast('error', 'Mô tả chi tiết không được vượt quá 500 ký tự.');
        document.getElementById('input-achievement-desc').focus();
        return;
    }

    // 5. Link minh chứng
    if (data.link_minh_chung) {
        if (data.link_minh_chung.length > 500) {
            hienToast('error', 'Liên kết minh chứng không được vượt quá 500 ký tự.');
            document.getElementById('input-achievement-link').focus();
            return;
        }
        try {
            new URL(data.link_minh_chung);
        } catch (_) {
            hienToast('error', 'Liên kết minh chứng phải là định dạng URL hợp lệ (VD: https://example.com).');
            document.getElementById('input-achievement-link').focus();
            return;
        }
    }

    datTrangThaiLoading(btn, true);

    fetch(window.ROUTES.luuThanhTuu, {
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
                dongModal('modal-thanh-tuu');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[ThanhTuu] Save error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btn, false));
}

/**
 * Xóa thông tin thành tựu
 */
function xoaThanhTuu(id) {
    if (!id) return;

    if (!confirm('Bạn có chắc chắn muốn xóa thành tựu này không?')) {
        return;
    }

    let urlXoa = window.ROUTES.xoaThanhTuu;
    urlXoa = urlXoa.includes('ID_PLACEHOLDER')
        ? urlXoa.replace('ID_PLACEHOLDER', id)
        : (urlXoa.endsWith('/') ? urlXoa + id : urlXoa + '/' + id);

    fetch(urlXoa, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
        .then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            const result = isJson ? await res.json() : null;

            if (!res.ok) {
                if (result && result.thong_bao) {
                    throw new Error(result.thong_bao);
                }
                throw new Error('Lỗi máy chủ (' + res.status + ')');
            }
            return result;
        })
        .then(result => {
            if (result && result.thanh_cong) {
                hienToast('success', result.thong_bao || 'Xóa thành công!');
                dongModal('modal-thanh-tuu');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[ThanhTuu] Delete error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        });
}

/**
 * Khởi tạo Cropper cho ảnh bìa thành tựu (16:9)
 */
function khoiTaoCropperThanhTuu() {
    const fileInput = document.getElementById('cover-file-input');
    const btnUpload = document.getElementById('btn-upload-cover');
    const btnDelete = document.getElementById('btn-delete-cover');
    const cropSection = document.getElementById('cover-crop-section');
    const cropImage = document.getElementById('cover-crop-image');
    
    const btnApply = document.getElementById('btn-cover-crop-apply');
    const btnCancel = document.getElementById('btn-cover-crop-cancel');

    if (!fileInput || !btnUpload) return;

    btnUpload.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Định dạng hợp lệ
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            hienToast('error', 'Chỉ hỗ trợ định dạng ảnh JPG, PNG, WebP!');
            return;
        }

        // Kiểm tra dung lượng tối đa 2MB
        if (file.size > 2 * 1024 * 1024) {
            hienToast('error', 'Kích thước ảnh bìa không được vượt quá 2MB!');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            cropImage.src = e.target.result;
            cropSection.classList.add('visible');

            // Ẩn preview box khi đang trong chế độ cắt ảnh
            const previewBox = document.querySelector('.cover-preview-box');
            if (previewBox) {
                previewBox.style.display = 'none';
            }

            if (achievementCropper) {
                achievementCropper.destroy();
                achievementCropper = null;
            }

            // Khởi tạo Cropper tỷ lệ 16:9
            achievementCropper = new Cropper(cropImage, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                guides: true,
                center: true,
                background: true
            });
        };
        reader.readAsDataURL(file);
    });

    btnApply && btnApply.addEventListener('click', function () {
        if (!achievementCropper) return;

        // Trích xuất canvas đã cắt ảnh
        const canvas = achievementCropper.getCroppedCanvas({
            width: 800,  // Khóa kích thước để tối ưu hóa truyền tải & lưu trữ
            height: 450
        });

        if (canvas) {
            const base64Data = canvas.toDataURL('image/jpeg', 0.85); // Nén ảnh 85% chất lượng
            
            document.getElementById('input-achievement-cover-base64').value = base64Data;
            
            const previewImg = document.getElementById('cover-preview-img');
            previewImg.src = base64Data;
            previewImg.style.display = 'block';
            
            document.getElementById('cover-preview-placeholder').style.display = 'none';
            btnDelete.style.display = 'inline-flex';
        }

        // Hiển thị lại preview box sau khi cắt xong
        const previewBox = document.querySelector('.cover-preview-box');
        if (previewBox) {
            previewBox.style.display = '';
        }

        // Dọn dẹp cropper
        cropSection.classList.remove('visible');
        if (achievementCropper) {
            achievementCropper.destroy();
            achievementCropper = null;
        }
        fileInput.value = '';
    });

    btnCancel && btnCancel.addEventListener('click', function () {
        // Hiển thị lại preview box khi huỷ cắt ảnh
        const previewBox = document.querySelector('.cover-preview-box');
        if (previewBox) {
            previewBox.style.display = '';
        }

        cropSection.classList.remove('visible');
        if (achievementCropper) {
            achievementCropper.destroy();
            achievementCropper = null;
        }
        fileInput.value = '';
    });

    btnDelete && btnDelete.addEventListener('click', function () {
        document.getElementById('input-achievement-cover-base64').value = '';
        const previewImg = document.getElementById('cover-preview-img');
        previewImg.src = '';
        previewImg.style.display = 'none';
        
        document.getElementById('cover-preview-placeholder').style.display = 'flex';
        btnDelete.style.display = 'none';
        fileInput.value = '';
    });
}

function resetCoverImagePicker() {
    try {
        const previewImg = document.getElementById('cover-preview-img');
        if (previewImg) {
            previewImg.src = '';
            previewImg.style.display = 'none';
        }

        const previewPlaceholder = document.getElementById('cover-preview-placeholder');
        if (previewPlaceholder) {
            previewPlaceholder.style.display = 'flex';
        }
        
        const btnDeleteCover = document.getElementById('btn-delete-cover');
        if (btnDeleteCover) {
            btnDeleteCover.style.display = 'none';
        }
        
        const cropSection = document.getElementById('cover-crop-section');
        if (cropSection) {
            cropSection.classList.remove('visible');
        }

        // Đảm bảo preview box được hiển thị lại
        const previewBox = document.querySelector('.cover-preview-box');
        if (previewBox) {
            previewBox.style.display = '';
        }
        
        if (achievementCropper) {
            achievementCropper.destroy();
            achievementCropper = null;
        }
        
        const fileInput = document.getElementById('cover-file-input');
        if (fileInput) {
            fileInput.value = '';
        }
    } catch (err) {
        console.error('Lỗi khi reset bộ chọn ảnh:', err);
    }
}

/**
 * Mở modal xem chi tiết thành tựu (Read-Only)
 */
function moModalChiTietThanhTuu(event, itemJson) {
    // Không kích hoạt nếu nhấn vào nút chỉnh sửa
    if (event && event.target && event.target.closest('.btn-achievement-edit')) {
        return;
    }

    try {
        const item = typeof itemJson === 'string' ? JSON.parse(itemJson) : itemJson;
        window.currentAchievementItem = item;

        document.getElementById('detail-achievement-name').textContent = item.ten_thanh_tuu || '';
        document.getElementById('detail-achievement-issuer').textContent = item.to_chuc_cap || 'Chưa cập nhật';
        document.getElementById('detail-achievement-time').textContent = item.thoi_gian || 'Chưa cập nhật';
        document.getElementById('detail-achievement-desc').textContent = item.mo_ta || 'Không có mô tả chi tiết.';

        // Phân loại badge
        const badgeCategory = document.getElementById('detail-achievement-category');
        if (badgeCategory) {
            let badgeText = 'Danh hiệu';
            let badgeClass = 'badge-danh-hieu';

            if (item.phan_loai === 'giai_thuong') {
                badgeText = 'Giải thưởng';
                badgeClass = 'badge-giai-thuong';
            } else if (item.phan_loai === 'hoc_bong') {
                badgeText = 'Học bổng';
                badgeClass = 'badge-hoc-bong';
            }

            badgeCategory.textContent = badgeText;
            badgeCategory.className = 'achievement-badge-pill ' + badgeClass;
        }

        // Link minh chứng
        const linkContainer = document.getElementById('detail-achievement-link-container');
        const linkEl = document.getElementById('detail-achievement-link');
        if (item.link_minh_chung) {
            linkEl.href = item.link_minh_chung;
            if (linkContainer) linkContainer.style.display = 'flex';
        } else {
            linkEl.href = '';
            if (linkContainer) linkContainer.style.display = 'none';
        }

        // Ảnh bìa đính kèm
        const bannerWrapper = document.getElementById('detail-achievement-banner-wrapper');
        const bannerImg = document.getElementById('detail-achievement-banner');
        const bannerPlaceholder = document.getElementById('detail-achievement-banner-placeholder');

        if (item.anh_minh_hoa) {
            bannerImg.src = '/' + item.anh_minh_hoa;
            bannerWrapper.style.display = 'block';
            if (bannerPlaceholder) bannerPlaceholder.style.display = 'none';
        } else {
            bannerImg.src = '';
            bannerWrapper.style.display = 'none';
            if (bannerPlaceholder) bannerPlaceholder.style.display = 'flex';
        }

        moModal('modal-chi-tiet-thanh-tuu');
    } catch (e) {
        console.error('Lỗi khi mở modal xem chi tiết thành tựu:', e);
        hienToast('error', 'Không thể hiển thị thông tin chi tiết thành tựu.');
    }
}

/**
 * Khởi tạo chức năng Lightbox xem ảnh lớn
 */
function khoiTaoLightboxThanhTuu() {
    const bannerWrapper = document.getElementById('detail-achievement-banner-wrapper');
    const bannerImg = document.getElementById('detail-achievement-banner');
    const lightbox = document.getElementById('achievementLightbox');
    const lightboxImg = document.getElementById('lightboxImage');
    const lightboxClose = lightbox ? lightbox.querySelector('.lightbox-close') : null;

    if (!bannerWrapper || !lightbox || !lightboxImg) return;

    // Khi click vào banner trong chi tiết
    bannerWrapper.addEventListener('click', function () {
        if (bannerImg && bannerImg.src) {
            lightboxImg.src = bannerImg.src;
            lightbox.style.display = 'flex';
            setTimeout(() => {
                lightbox.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
    });

    const closeLightbox = function () {
        lightbox.classList.remove('active');
        setTimeout(() => {
            lightbox.style.display = 'none';
        }, 300);
        document.body.style.overflow = '';
    };

    lightboxClose && lightboxClose.addEventListener('click', closeLightbox);
    
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox || e.target === lightboxClose) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox();
        }
    });
}

/**
 * Khởi tạo sự kiện cho bộ lọc client-side
 */
function khoiTaoBoLocThanhTuu() {
    const filterSelect = document.getElementById('filter-phan-loai');
    const searchInput = document.getElementById('main-search-input');
    const btnReset = document.getElementById('btn-reset-filters');
    const filterTu = document.getElementById('filter-ngay-dat-duoc-tu');
    const filterDen = document.getElementById('filter-ngay-dat-duoc-den');
    const filterNoiBat = document.getElementById('filter-noi-bat');

    const parseVietnameseDate = function(str) {
        if (!str) return null;
        const parts = str.trim().split('/');
        if (parts.length === 3) {
            const d = parseInt(parts[0], 10);
            const m = parseInt(parts[1], 10) - 1;
            const y = parseInt(parts[2], 10);
            if (!isNaN(d) && !isNaN(m) && !isNaN(y)) {
                return new Date(y, m, d);
            }
        }
        return null;
    };

    const applyFilters = function() {
        const phanLoai = filterSelect ? filterSelect.value : '';
        const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
        
        const dateTuVal = filterTu ? filterTu.value : '';
        const dateDenVal = filterDen ? filterDen.value : '';
        const valNoiBat = filterNoiBat ? filterNoiBat.value : '';

        const dateTu = dateTuVal ? new Date(dateTuVal) : null;
        if (dateTu) dateTu.setHours(0, 0, 0, 0);

        const dateDen = dateDenVal ? new Date(dateDenVal) : null;
        if (dateDen) dateDen.setHours(23, 59, 59, 999);

        const cards = document.querySelectorAll('.achievement-card');
        let visibleCount = 0;

        cards.forEach(card => {
            let isMatch = true;

            // 1. Phân loại
            if (phanLoai) {
                const cardPhanLoai = card.getAttribute('data-phan-loai');
                if (cardPhanLoai !== phanLoai) {
                    isMatch = false;
                }
            }

            // 2. Từ khóa tìm kiếm
            if (isMatch && keyword) {
                const textContent = card.textContent.toLowerCase();
                if (!textContent.includes(keyword)) {
                    isMatch = false;
                }
            }

            // 3. Lọc theo ngày đạt được
            if (isMatch && (dateTu || dateDen)) {
                const cardThoiGian = card.getAttribute('data-thoi-gian');
                const cardDate = parseVietnameseDate(cardThoiGian);
                if (cardDate) {
                    if (dateTu && cardDate < dateTu) {
                        isMatch = false;
                    }
                    if (dateDen && cardDate > dateDen) {
                        isMatch = false;
                    }
                } else {
                    isMatch = false;
                }
            }

            // 4. Lọc theo nổi bật
            if (isMatch && valNoiBat) {
                const cardNoiBat = card.getAttribute('data-noi-bat') || '0';
                if (cardNoiBat !== valNoiBat) {
                    isMatch = false;
                }
            }

            if (isMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Toggle kết quả trống
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            if (visibleCount === 0 && cards.length > 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    };

    if (filterSelect) {
        filterSelect.addEventListener('change', applyFilters);
    }
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    if (filterTu) {
        filterTu.addEventListener('change', applyFilters);
        filterTu.addEventListener('input', applyFilters);
    }
    if (filterDen) {
        filterDen.addEventListener('change', applyFilters);
        filterDen.addEventListener('input', applyFilters);
    }
    if (filterNoiBat) {
        filterNoiBat.addEventListener('change', applyFilters);
    }

    // Toggle date filters panel
    const btnToggleDates = document.getElementById('btn-toggle-date-filters');
    const dateFiltersPanel = document.getElementById('date-filters-panel');
    const toggleIcon = document.getElementById('toggle-dates-icon');
    
    if (btnToggleDates && dateFiltersPanel) {
        btnToggleDates.addEventListener('click', function () {
            const isShown = dateFiltersPanel.classList.toggle('show');
            btnToggleDates.classList.toggle('active', isShown);
            if (toggleIcon) {
                toggleIcon.style.transform = isShown ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    }

    if (btnReset) {
        btnReset.addEventListener('click', function () {
            if (filterSelect) filterSelect.value = '';
            if (searchInput) searchInput.value = '';
            if (filterTu) filterTu.value = '';
            if (filterDen) filterDen.value = '';
            if (filterNoiBat) filterNoiBat.value = '';

            // Collapse dates panel on reset
            if (dateFiltersPanel && dateFiltersPanel.classList.contains('show')) {
                dateFiltersPanel.classList.remove('show');
                if (btnToggleDates) btnToggleDates.classList.remove('active');
                if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
            }

            applyFilters();
        });
    }
}
