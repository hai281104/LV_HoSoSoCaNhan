/**
 * chung-chi.js
 * JavaScript cho chức năng quản lý Chứng chỉ & Chứng nhận
 */

document.addEventListener('DOMContentLoaded', function () {
    khoiTaoFormChungChi();

    // Nút mở modal thêm mới chứng chỉ
    const btnThemChungChi = document.getElementById('btn-them-chung-chi');
    if (btnThemChungChi) {
        btnThemChungChi.addEventListener('click', function () {
            moModalThemChungChi();
        });
    }

    // Khởi tạo các bộ lọc client-side
    khoiTaoBoLocChungChi();

    // Nút Sửa trong modal chi tiết chứng chỉ
    const btnDetailSuaChungChi = document.getElementById('btn-detail-sua-chung-chi');
    if (btnDetailSuaChungChi) {
        btnDetailSuaChungChi.addEventListener('click', function () {
            if (window.currentChungChiItem) {
                dongModal('modal-chi-tiet-chung-chi');
                moModalSuaChungChi(window.currentChungChiItem);
            }
        });
    }

    // Nút Xóa trong modal chi tiết chứng chỉ
    const btnDetailXoaChungChi = document.getElementById('btn-detail-xoa-chung-chi');
    if (btnDetailXoaChungChi) {
        btnDetailXoaChungChi.addEventListener('click', function () {
            if (window.currentChungChiItem && window.currentChungChiItem.id) {
                dongModal('modal-chi-tiet-chung-chi');
                xoaChungChi(window.currentChungChiItem.id);
            }
        });
    }
});

/**
 * Mở modal thêm mới (reset form)
 */
function moModalThemChungChi() {
    const form = document.getElementById('form-chung-chi');
    if (!form) return;

    form.reset();
    document.getElementById('input-cert-id').value = '';
    document.getElementById('input-cert-phan-loai').value = 'chuyen_mon';
    document.getElementById('modal-chung-chi-title').textContent = 'Thêm mới chứng chỉ';

    // Reset preview PDF
    const previewContainer = document.getElementById('cert-file-pdf-preview');
    if (previewContainer) previewContainer.style.display = 'none';
    const inputPdf = document.getElementById('input-cert-file-pdf');
    if (inputPdf) inputPdf.value = '';

    moModal('modal-chung-chi');
}

/**
 * Mở modal chỉnh sửa và điền dữ liệu có sẵn
 */
function moModalSuaChungChi(itemJson) {
    const form = document.getElementById('form-chung-chi');
    if (!form) return;

    try {
        const item = typeof itemJson === 'string' ? JSON.parse(itemJson) : itemJson;

        document.getElementById('input-cert-id').value = item.id || '';
        document.getElementById('input-cert-ten-chung-chi').value = item.ten_chung_chi || '';
        document.getElementById('input-cert-to-chuc-cap').value = item.to_chuc_cap || '';
        document.getElementById('input-cert-ma-chung-chi').value = item.ma_chung_chi || '';
        document.getElementById('input-cert-ngay-cap').value = item.ngay_cap || '';
        document.getElementById('input-cert-ngay-het-han').value = item.ngay_het_han || '';
        document.getElementById('input-cert-url-tap-tin').value = item.url_tap_tin || '';
        document.getElementById('input-cert-phan-loai').value = item.phan_loai || 'chuyen_mon';

        document.getElementById('modal-chung-chi-title').textContent = 'Cập nhật chứng chỉ';

        // Xử lý xem trước file PDF
        const previewContainer = document.getElementById('cert-file-pdf-preview');
        const previewLink = document.getElementById('cert-file-pdf-link');
        const inputPdf = document.getElementById('input-cert-file-pdf');
        if (inputPdf) inputPdf.value = '';

        if (previewContainer && previewLink) {
            if (item.file_pdf) {
                previewLink.href = window.location.origin + '/' + item.file_pdf;
                previewContainer.style.display = 'inline-flex';
            } else {
                previewContainer.style.display = 'none';
            }
        }

        moModal('modal-chung-chi');
    } catch (e) {
        console.error('Lỗi khi mở modal sửa chứng chỉ:', e);
        hienToast('error', 'Không thể hiển thị thông tin chứng chỉ.');
    }
}

/**
 * Khởi tạo sự kiện submit form
 */
function khoiTaoFormChungChi() {
    const form = document.getElementById('form-chung-chi');
    const btnSave = document.getElementById('btn-luu-chung-chi');
    if (!form || !btnSave) return;

    btnSave.addEventListener('click', function (e) {
        e.preventDefault();
        luuChungChi(btnSave);
    });
}

/**
 * Validate và gửi AJAX lưu chứng chỉ
 */
function luuChungChi(btn) {
    const form = document.getElementById('form-chung-chi');
    if (!form) return;

    const data = {
        id:            document.getElementById('input-cert-id').value || null,
        ten_chung_chi: document.getElementById('input-cert-ten-chung-chi').value.trim(),
        to_chuc_cap:   document.getElementById('input-cert-to-chuc-cap').value.trim(),
        ma_chung_chi:  document.getElementById('input-cert-ma-chung-chi').value.trim(),
        ngay_cap:      document.getElementById('input-cert-ngay-cap').value,
        ngay_het_han:  document.getElementById('input-cert-ngay-het-han').value,
        url_tap_tin:   document.getElementById('input-cert-url-tap-tin').value.trim(),
        phan_loai:     document.getElementById('input-cert-phan-loai').value,
    };

    console.log('[ChungChi] Saving payload:', data);

    // Client-side validations
    if (!['chuyen_mon', 'ngoai_ngu', 'ky_nang', 'khac'].includes(data.phan_loai)) {
        hienToast('error', 'Vui lòng chọn phân loại chứng chỉ hợp lệ.');
        document.getElementById('input-cert-phan-loai').focus();
        return;
    }
    // 1. Tên chứng chỉ: 2-100 ký tự
    if (!data.ten_chung_chi) {
        hienToast('error', 'Tên chứng chỉ không được để trống.');
        document.getElementById('input-cert-ten-chung-chi').focus();
        return;
    }
    if (data.ten_chung_chi.length < 2 || data.ten_chung_chi.length > 100) {
        hienToast('error', 'Tên chứng chỉ phải có độ dài từ 2 đến 100 ký tự.');
        document.getElementById('input-cert-ten-chung-chi').focus();
        return;
    }

    // 2. Tổ chức cấp: 2-100 ký tự
    if (!data.to_chuc_cap) {
        hienToast('error', 'Tổ chức cấp không được để trống.');
        document.getElementById('input-cert-to-chuc-cap').focus();
        return;
    }
    if (data.to_chuc_cap.length < 2 || data.to_chuc_cap.length > 100) {
        hienToast('error', 'Tổ chức cấp phải có độ dài từ 2 đến 100 ký tự.');
        document.getElementById('input-cert-to-chuc-cap').focus();
        return;
    }

    // 3. Mã chứng chỉ: tối đa 50 ký tự
    if (data.ma_chung_chi) {
        if (data.ma_chung_chi.length > 50) {
            hienToast('error', 'Mã chứng chỉ không được vượt quá 50 ký tự.');
            document.getElementById('input-cert-ma-chung-chi').focus();
            return;
        }
        const regexMa = /^[\p{L}\p{N}\s\-_:\.\/]+$/u;
        if (!regexMa.test(data.ma_chung_chi)) {
            hienToast('error', 'Mã chứng chỉ không hợp lệ (chỉ chấp nhận chữ, số, khoảng trắng, gạch nối, dấu chấm, hai chấm, và dấu gạch chéo).');
            document.getElementById('input-cert-ma-chung-chi').focus();
            return;
        }
    }

    // 4. Ngày cấp
    if (!data.ngay_cap) {
        hienToast('error', 'Vui lòng chọn ngày cấp chứng chỉ.');
        document.getElementById('input-cert-ngay-cap').focus();
        return;
    }

    // 5. Ngày hết hạn (nếu có) phải >= ngày cấp
    if (data.ngay_het_han) {
        const dateCap = new Date(data.ngay_cap);
        const dateHetHan = new Date(data.ngay_het_han);
        if (dateHetHan < dateCap) {
            hienToast('error', 'Ngày hết hạn phải lớn hơn hoặc bằng ngày cấp.');
            document.getElementById('input-cert-ngay-het-han').focus();
            return;
        }
    }

    // 6. Liên kết tập tin: tối đa 500 ký tự & phải là URL hợp lệ nếu điền
    if (data.url_tap_tin) {
        if (data.url_tap_tin.length > 500) {
            hienToast('error', 'Đường dẫn liên kết không được vượt quá 500 ký tự.');
            document.getElementById('input-cert-url-tap-tin').focus();
            return;
        }
        try {
            new URL(data.url_tap_tin);
        } catch (_) {
            hienToast('error', 'Liên kết tập tin phải là URL hợp lệ (VD: https://storage/aws.pdf).');
            document.getElementById('input-cert-url-tap-tin').focus();
            return;
        }
    }

    // 7. Kiểm tra tệp PDF đính kèm
    const filePdfInput = document.getElementById('input-cert-file-pdf');
    if (filePdfInput && filePdfInput.files.length > 0) {
        const file = filePdfInput.files[0];
        if (file.type !== 'application/pdf') {
            hienToast('error', 'Tệp tải lên phải có định dạng PDF.');
            filePdfInput.focus();
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            hienToast('error', 'Dung lượng tệp PDF không được vượt quá 5MB.');
            filePdfInput.focus();
            return;
        }
    }

    datTrangThaiLoading(btn, true);

    const urlLuu = window.ROUTES.luuChungChi;

    const formData = new FormData();
    formData.append('id', data.id || '');
    formData.append('ten_chung_chi', data.ten_chung_chi);
    formData.append('to_chuc_cap', data.to_chuc_cap);
    formData.append('ma_chung_chi', data.ma_chung_chi);
    formData.append('ngay_cap', data.ngay_cap);
    formData.append('ngay_het_han', data.ngay_het_han);
    formData.append('url_tap_tin', data.url_tap_tin);
    formData.append('phan_loai', data.phan_loai);
    if (filePdfInput && filePdfInput.files.length > 0) {
        formData.append('file_pdf', filePdfInput.files[0]);
    }

    fetch(urlLuu, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json',
        },
        body: formData,
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
                dongModal('modal-chung-chi');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[ChungChi] Save error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btn, false));
}

/**
 * Xóa thông tin chứng chỉ
 */
function xoaChungChi(id, urlXoa = null) {
    console.log('[ChungChi] xoaChungChi called with ID:', id, 'url:', urlXoa);
    if (!id) return;

    if (!confirm('Bạn có chắc chắn muốn xóa chứng chỉ này không?')) {
        return;
    }

    if (!urlXoa) {
        if (!window.ROUTES || !window.ROUTES.xoaChungChi) {
            console.error('[ChungChi] Delete route not configured');
            hienToast('error', 'Không thể xóa do cấu hình đường dẫn không hợp lệ.');
            return;
        }
        const baseRoute = window.ROUTES.xoaChungChi;
        urlXoa = baseRoute.includes('ID_PLACEHOLDER')
            ? baseRoute.replace('ID_PLACEHOLDER', id)
            : (baseRoute.endsWith('/') ? baseRoute + id : baseRoute + '/' + id);
    }

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
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[ChungChi] Delete error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        });
}

/**
 * Khởi tạo sự kiện cho các bộ lọc
 */
function khoiTaoBoLocChungChi() {
    const filterInputs = [
        'filter-phan-loai',
        'filter-ngay-cap-tu',
        'filter-ngay-cap-den',
        'filter-ngay-het-han-tu',
        'filter-ngay-het-han-den',
        'filter-noi-bat'
    ];

    filterInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', applyFilters);
            el.addEventListener('input', applyFilters);
        }
    });

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

    // Nút Đặt lại
    const btnReset = document.getElementById('btn-reset-filters');
    if (btnReset) {
        btnReset.addEventListener('click', function () {
            filterInputs.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });

            // Collapse dates panel on reset
            if (dateFiltersPanel && dateFiltersPanel.classList.contains('show')) {
                dateFiltersPanel.classList.remove('show');
                if (btnToggleDates) btnToggleDates.classList.remove('active');
                if (toggleIcon) toggleIcon.style.transform = 'rotate(0deg)';
            }

            applyFilters();
        });
    }

    // Gắn thêm sự kiện cho thanh tìm kiếm chính để chạy applyFilters
    const searchInput = document.getElementById('main-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
}

/**
 * Áp dụng bộ lọc và ẩn/hiện card chứng chỉ
 */
function applyFilters() {
    const searchInput = document.getElementById('main-search-input');
    const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
    
    const phanLoai = document.getElementById('filter-phan-loai') ? document.getElementById('filter-phan-loai').value : '';
    const ngayCapTu = document.getElementById('filter-ngay-cap-tu') ? document.getElementById('filter-ngay-cap-tu').value : '';
    const ngayCapDen = document.getElementById('filter-ngay-cap-den') ? document.getElementById('filter-ngay-cap-den').value : '';
    const ngayHetHanTu = document.getElementById('filter-ngay-het-han-tu') ? document.getElementById('filter-ngay-het-han-tu').value : '';
    const ngayHetHanDen = document.getElementById('filter-ngay-het-han-den') ? document.getElementById('filter-ngay-het-han-den').value : '';
    const filterNoiBat = document.getElementById('filter-noi-bat') ? document.getElementById('filter-noi-bat').value : '';

    const cards = document.querySelectorAll('.certificate-card');
    let visibleCount = 0;

    cards.forEach(card => {
        let isMatch = true;

        // 1. Lọc theo từ khóa tìm kiếm
        if (keyword) {
            const textContent = card.textContent.toLowerCase();
            if (!textContent.includes(keyword)) {
                isMatch = false;
            }
        }

        // 2. Lọc theo phân loại
        if (isMatch && phanLoai) {
            const cardPhanLoai = card.getAttribute('data-phan-loai');
            if (cardPhanLoai !== phanLoai) {
                isMatch = false;
            }
        }

        // 3. Lọc theo ngày cấp
        if (isMatch) {
            const cardNgayCap = card.getAttribute('data-ngay-cap'); // YYYY-MM-DD
            if (cardNgayCap) {
                if (ngayCapTu && cardNgayCap < ngayCapTu) {
                    isMatch = false;
                }
                if (ngayCapDen && cardNgayCap > ngayCapDen) {
                    isMatch = false;
                }
            } else if (ngayCapTu || ngayCapDen) {
                isMatch = false;
            }
        }

        // 4. Lọc theo ngày hết hạn
        if (isMatch) {
            const cardNgayHetHan = card.getAttribute('data-ngay-het-han'); // YYYY-MM-DD
            if (cardNgayHetHan) {
                if (ngayHetHanTu && cardNgayHetHan < ngayHetHanTu) {
                    isMatch = false;
                }
                if (ngayHetHanDen && cardNgayHetHan > ngayHetHanDen) {
                    isMatch = false;
                }
            } else if (ngayHetHanTu || ngayHetHanDen) {
                // Nếu lọc ngày hết hạn nhưng card không có ngày hết hạn (không hết hạn)
                isMatch = false;
            }
        }

        // 5. Lọc theo nổi bật
        if (isMatch && filterNoiBat) {
            const cardNoiBat = card.getAttribute('data-noi-bat') || '0';
            if (cardNoiBat !== filterNoiBat) {
                isMatch = false;
            }
        }

        // Hiển thị hoặc ẩn card
        if (isMatch) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Hiển thị hoặc ẩn card thông báo khi không tìm thấy kết quả phù hợp
    const noResultsEl = document.getElementById('no-filter-results');
    if (noResultsEl) {
        if (visibleCount === 0 && cards.length > 0) {
            noResultsEl.style.display = 'block';
        } else {
            noResultsEl.style.display = 'none';
        }
    }
}

/**
 * Mở modal xem chi tiết chứng chỉ
 */
function moModalChiTietChungChi(event, item) {
    // Ngăn chặn nếu người dùng click vào các phần tử con có cơ chế xử lý riêng biệt
    if (event && event.target && (event.target.closest('.certificate-card-actions') || event.target.closest('.certificate-card-footer'))) {
        return;
    }

    try {
        const data = typeof item === 'string' ? JSON.parse(item) : item;
        window.currentChungChiItem = data;

        document.getElementById('detail-cert-name').textContent = data.ten_chung_chi || '';
        document.getElementById('detail-cert-issuer').textContent = data.to_chuc_cap || '';
        
        // Phân loại badge
        const badgeCategory = document.getElementById('detail-cert-category');
        if (badgeCategory) {
            let phanLoaiText = 'Khác';
            let phanLoaiClass = 'category-khac';
            
            if (data.phan_loai === 'chuyen_mon') {
                phanLoaiText = 'Chuyên môn';
                phanLoaiClass = 'category-chuyen-mon';
            } else if (data.phan_loai === 'ngoai_ngu') {
                phanLoaiText = 'Ngoại ngữ';
                phanLoaiClass = 'category-ngoai-ngu';
            } else if (data.phan_loai === 'ky_nang') {
                phanLoaiText = 'Kỹ năng mềm';
                phanLoaiClass = 'category-ky-nang';
            }
            
            badgeCategory.textContent = phanLoaiText;
            badgeCategory.className = 'certificate-category-badge ' + phanLoaiClass;
        }

        document.getElementById('detail-cert-code').textContent = data.ma_chung_chi || '-';

        // Ngày cấp & hết hạn
        const formatNgay = function (ngayStr) {
            if (!ngayStr) return '';
            const parts = ngayStr.split('-');
            if (parts.length === 3) {
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            return ngayStr;
        };

        document.getElementById('detail-cert-date-issued').textContent = formatNgay(data.ngay_cap) || 'Chưa cập nhật';
        document.getElementById('detail-cert-date-expired').textContent = formatNgay(data.ngay_het_han) || 'Không hết hạn';

        // Trạng thái hiệu lực
        const badgeStatus = document.getElementById('detail-cert-status');
        if (badgeStatus) {
            let isExpired = false;
            if (data.ngay_het_han) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const dateHetHan = new Date(data.ngay_het_han);
                dateHetHan.setHours(0, 0, 0, 0);
                isExpired = dateHetHan < today;
            }

            if (isExpired) {
                badgeStatus.textContent = 'Hết hạn';
                badgeStatus.className = 'certificate-status-badge status-expired';
            } else {
                badgeStatus.textContent = 'Còn hiệu lực';
                badgeStatus.className = 'certificate-status-badge status-valid';
            }
        }

        // Link tập tin đính kèm
        const linkGroup = document.getElementById('detail-cert-link-group');
        const linkEl = document.getElementById('detail-cert-link');
        if (linkGroup && linkEl) {
            if (data.url_tap_tin) {
                linkEl.href = data.url_tap_tin;
                linkGroup.style.display = 'block';
            } else {
                linkEl.href = '#';
                linkGroup.style.display = 'none';
            }
        }

        // Tệp PDF đính kèm
        const pdfGroup = document.getElementById('detail-cert-pdf-group');
        const pdfLinkEl = document.getElementById('detail-cert-pdf-link');
        if (pdfGroup && pdfLinkEl) {
            if (data.file_pdf) {
                pdfLinkEl.href = window.location.origin + '/' + data.file_pdf;
                pdfGroup.style.display = 'block';
            } else {
                pdfLinkEl.href = '#';
                pdfGroup.style.display = 'none';
            }
        }

        moModal('modal-chi-tiet-chung-chi');
    } catch (e) {
        console.error('Lỗi khi mở modal xem chi tiết chứng chỉ:', e);
        hienToast('error', 'Không thể hiển thị thông tin chi tiết chứng chỉ.');
    }
}

