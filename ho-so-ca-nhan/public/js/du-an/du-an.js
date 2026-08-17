/**
 * du-an.js
 * JavaScript cho chức năng quản lý Portfolio dự án
 */

document.addEventListener('DOMContentLoaded', function () {
    khoiTaoEventsDuAn();

    // Nút mở modal thêm mới dự án
    const btnThemDuAn = document.getElementById('btn-them-du-an');
    if (btnThemDuAn) {
        btnThemDuAn.addEventListener('click', function () {
            moModalThemDuAn();
        });
    }

    // Toggle disable cho ngày kết thúc khi check "Dự án đang thực hiện"
    const checkboxOngoing = document.getElementById('checkbox-project-ongoing');
    if (checkboxOngoing) {
        checkboxOngoing.addEventListener('change', function () {
            toggleProjectEndState(this.checked);
        });
    }

    // Đếm ký tự mô tả
    const textareaMoTa = document.getElementById('input-project-desc');
    if (textareaMoTa) {
        textareaMoTa.addEventListener('input', function () {
            capNhatDemKyTuProject(this);
        });
    }

    // Nút thêm dòng liên kết động
    const btnThemLienKet = document.getElementById('btn-them-lien-ket');
    if (btnThemLienKet) {
        btnThemLienKet.addEventListener('click', function () {
            themDongLienKet();
        });
    }



    // Khởi tạo bộ lọc cho trang dự án
    khoiTaoBoLocDuAn();

    // Nút Sửa trong modal chi tiết dự án
    const btnDetailSuaDuAn = document.getElementById('btn-detail-sua-du-an');
    if (btnDetailSuaDuAn) {
        btnDetailSuaDuAn.addEventListener('click', function () {
            if (window.currentProjectItem) {
                dongModal('modal-chi-tiet-du-an');
                moModalSuaDuAn(null, window.currentProjectItem);
            }
        });
    }

    // Nút Xóa trong modal chi tiết dự án
    const btnDetailXoaDuAn = document.getElementById('btn-detail-xoa-du-an');
    if (btnDetailXoaDuAn) {
        btnDetailXoaDuAn.addEventListener('click', function () {
            if (window.currentProjectItem && window.currentProjectItem.id) {
                dongModal('modal-chi-tiet-du-an');
                xoaDuAn(null, window.currentProjectItem.id);
            }
        });
    }
});

/**
 * Khởi tạo sự kiện submit form
 */
function khoiTaoEventsDuAn() {
    const btnSave = document.getElementById('btn-luu-du-an');
    if (btnSave) {
        btnSave.addEventListener('click', function (e) {
            e.preventDefault();
            luuDuAn(btnSave);
        });
    }
}

/**
 * Toggle trạng thái disabled cho ngày kết thúc
 */
function toggleProjectEndState(isOngoing) {
    const inputEnd = document.getElementById('input-project-end');
    if (!inputEnd) return;

    if (isOngoing) {
        inputEnd.value = '';
        inputEnd.disabled = true;
        inputEnd.classList.add('disabled');
    } else {
        inputEnd.disabled = false;
        inputEnd.classList.remove('disabled');
    }
}

/**
 * Cập nhật hiển thị số ký tự của textarea mô tả
 */
function capNhatDemKyTuProject(textarea) {
    const demEl = document.getElementById('project-desc-counter');
    if (demEl) {
        const count = textarea.value.length;
        demEl.textContent = count;
        if (count > 1000) {
            demEl.style.color = '#ef4444';
        } else {
            demEl.style.color = '';
        }
    }
}

/**
 * Mở modal thêm mới (reset form)
 */
function moModalThemDuAn() {
    const form = document.getElementById('form-du-an');
    if (!form) return;

    form.reset();
    document.getElementById('input-project-id').value = '';
    document.getElementById('input-project-role').value = '';
    document.getElementById('modal-du-an-title').textContent = 'Thêm dự án mới';
    
    // Clear liên kết động
    const wrapper = document.getElementById('wrapper-lien-ket');
    if (wrapper) wrapper.innerHTML = '';

    // Hiển thị lại nút thêm liên kết
    const btnThemLienKet = document.getElementById('btn-them-lien-ket');
    if (btnThemLienKet) btnThemLienKet.style.display = '';

    // Mặc định thiết lập trạng thái chưa check ongoing
    const checkboxOngoing = document.getElementById('checkbox-project-ongoing');
    if (checkboxOngoing) checkboxOngoing.checked = false;
    toggleProjectEndState(false);
    
    const demEl = document.getElementById('project-desc-counter');
    if (demEl) demEl.textContent = '0';

    moModal('modal-du-an');
}

/**
 * Mở modal chỉnh sửa và điền dữ liệu có sẵn
 */
function moModalSuaDuAn(event, item) {
    if (event) {
        if (typeof event.stopPropagation === 'function') {
            event.stopPropagation();
        }
    }
    console.log('[DuAn] moModalSuaDuAn called with item:', item);
    const form = document.getElementById('form-du-an');
    if (!form) return;

    try {
        document.getElementById('input-project-id').value = item.id || '';
        document.getElementById('input-project-name').value = item.ten_du_an || '';
        document.getElementById('input-project-role').value = item.vai_tro || '';
        document.getElementById('input-project-start').value = item.ngay_bat_dau || '';
        
        const isOngoing = !item.ngay_ket_thuc;
        const checkboxOngoing = document.getElementById('checkbox-project-ongoing');
        if (checkboxOngoing) checkboxOngoing.checked = isOngoing;
        
        toggleProjectEndState(isOngoing);
        document.getElementById('input-project-end').value = item.ngay_ket_thuc || '';
        
        // Tags/Từ khóa (mảng JSON chuyển thành chuỗi phân cách dấu phẩy)
        const tags = Array.isArray(item.tu_khoa) ? item.tu_khoa.join(', ') : '';
        document.getElementById('input-project-tags').value = tags;
        
        const moTa = item.mo_ta || '';
        const textarea = document.getElementById('input-project-desc');
        textarea.value = moTa;
        capNhatDemKyTuProject(textarea);

        // Đổ các dòng liên kết ngoài
        const wrapper = document.getElementById('wrapper-lien-ket');
        if (wrapper) {
            wrapper.innerHTML = '';
            if (Array.isArray(item.lien_ket) && item.lien_ket.length > 0) {
                item.lien_ket.forEach(lk => {
                    themDongLienKet(lk.loai_lien_ket, lk.nhan_hien_thi || '', lk.duong_dan);
                });
            }
        }

        // Kiểm tra số lượng liên kết để ẩn/hiện nút thêm
        const btnThemLienKet = document.getElementById('btn-them-lien-ket');
        if (btnThemLienKet) {
            if (Array.isArray(item.lien_ket) && item.lien_ket.length >= 5) {
                btnThemLienKet.style.display = 'none';
            } else {
                btnThemLienKet.style.display = '';
            }
        }

        document.getElementById('modal-du-an-title').textContent = 'Cập nhật thông tin dự án';
        moModal('modal-du-an');
    } catch (e) {
        console.error('Lỗi khi mở modal sửa dự án:', e);
        hienToast('error', 'Không thể hiển thị thông tin dự án.');
    }
}

/**
 * Thêm dòng liên kết động trong modal
 */
function themDongLienKet(loai = 'github', nhan = '', url = '') {
    const wrapper = document.getElementById('wrapper-lien-ket');
    if (!wrapper) return;

    const existingRows = document.querySelectorAll('.lien-ket-row').length;
    if (existingRows >= 5) {
        hienToast('error', 'Mỗi dự án chỉ được thêm tối đa 5 liên kết.');
        return;
    }

    const row = document.createElement('div');
    row.className = 'lien-ket-row';
    
    // Select loại liên kết
    const selectHtml = `
        <select class="select-loai-lk">
            <option value="github" ${loai === 'github' ? 'selected' : ''}>GitHub</option>
            <option value="demo" ${loai === 'demo' ? 'selected' : ''}>Demo/Web</option>
            <option value="other" ${loai === 'other' ? 'selected' : ''}>Khác</option>
        </select>
    `;

    row.innerHTML = `
        ${selectHtml}
        <input type="text" class="input-nhan-lk" placeholder="Nhãn (VD: GitHub)" value="${nhan}" style="width: 90px; flex-shrink: 1; min-width: 0;">
        <input type="url" class="input-url-lk" placeholder="https://..." value="${url}" style="flex: 1; min-width: 0;" required>
        <button type="button" class="btn-remove-link" onclick="xoaDongLienKet(this)" title="Xóa dòng">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    `;

    wrapper.appendChild(row);

    // Ẩn nút thêm nếu đã đủ 5 liên kết
    const currentRows = document.querySelectorAll('.lien-ket-row').length;
    const btnThemLienKet = document.getElementById('btn-them-lien-ket');
    if (currentRows >= 5 && btnThemLienKet) {
        btnThemLienKet.style.display = 'none';
    }
}

/**
 * Xóa một dòng liên kết
 */
function xoaDongLienKet(btn) {
    if (!btn) return;
    const row = btn.closest('.lien-ket-row');
    if (row) {
        row.style.animation = 'slideDown 0.2s ease reverse forwards';
        setTimeout(() => {
            row.remove();
            const btnThemLienKet = document.getElementById('btn-them-lien-ket');
            const currentRows = document.querySelectorAll('.lien-ket-row').length;
            if (currentRows < 5 && btnThemLienKet) {
                btnThemLienKet.style.display = '';
            }
        }, 200);
    }
}

/**
 * Validate và gửi AJAX lưu dự án
 */
function luuDuAn(btn) {
    const form = document.getElementById('form-du-an');
    if (!form) return;

    // Phân tích từ khóa tags
    const tagsRaw = document.getElementById('input-project-tags').value;
    const tuKhoa = tagsRaw ? tagsRaw.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0) : [];

    // Lấy danh sách liên kết động
    const lienKet = [];
    const rows = document.querySelectorAll('.lien-ket-row');
    let hasInvalidUrl = false;

    rows.forEach(row => {
        const loai_lien_ket = row.querySelector('.select-loai-lk').value;
        const nhan_hien_thi = row.querySelector('.input-nhan-lk').value.trim();
        const duong_dan = row.querySelector('.input-url-lk').value.trim();

        if (duong_dan) {
            // Kiểm tra tính hợp lệ sơ bộ của URL
            try {
                new URL(duong_dan);
            } catch (_) {
                hasInvalidUrl = true;
                row.querySelector('.input-url-lk').style.borderColor = '#ef4444';
            }
            
            lienKet.push({
                loai_lien_ket,
                nhan_hien_thi,
                duong_dan
            });
        }
    });

    const isOngoing = document.getElementById('checkbox-project-ongoing').checked;

    const data = {
        id:            document.getElementById('input-project-id').value || null,
        ten_du_an:     document.getElementById('input-project-name').value.trim(),
        vai_tro:       document.getElementById('input-project-role').value.trim(),
        ngay_bat_dau:  document.getElementById('input-project-start').value,
        ngay_ket_thuc: isOngoing ? null : document.getElementById('input-project-end').value,
        mo_ta:         document.getElementById('input-project-desc').value.trim(),
        tu_khoa:       tuKhoa,
        lien_ket:      lienKet
    };

    // Client-side validations
    const regexNoSpecial = /^[\p{L}\p{N}\s]+$/u;

    if (!data.ten_du_an || data.ten_du_an.length < 2 || data.ten_du_an.length > 100) {
        hienToast('error', 'Tên dự án phải có độ dài từ 2 đến 100 ký tự.');
        document.getElementById('input-project-name').focus();
        return;
    }

    if (!data.vai_tro) {
        hienToast('error', 'Vai trò trong dự án không được để trống.');
        document.getElementById('input-project-role').focus();
        return;
    }

    if (data.vai_tro.length < 2 || data.vai_tro.length > 50) {
        hienToast('error', 'Vai trò phải có độ dài từ 2 đến 50 ký tự.');
        document.getElementById('input-project-role').focus();
        return;
    }

    if (!data.ngay_bat_dau) {
        hienToast('error', 'Vui lòng chọn ngày bắt đầu thực hiện.');
        document.getElementById('input-project-start').focus();
        return;
    }

    if (!isOngoing) {
        if (!data.ngay_ket_thuc) {
            hienToast('error', 'Vui lòng chọn ngày kết thúc hoặc tích chọn "Dự án đang thực hiện".');
            document.getElementById('input-project-end').focus();
            return;
        }

        const start = new Date(data.ngay_bat_dau);
        const end = new Date(data.ngay_ket_thuc);
        if (end < start) {
            hienToast('error', 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.');
            document.getElementById('input-project-end').focus();
            return;
        }
    }

    if (hasInvalidUrl) {
        hienToast('error', 'Vui lòng nhập định dạng URL hợp lệ (VD: https://github.com ).');
        return;
    }

    // Kiểm tra ký tự đặc biệt của từ khóa công nghệ (hỗ trợ dấu cách, dấu chấm, cộng, thăng, gạch chéo, ampersand, v.v.)
    const tagRegex = /^[a-zA-Z0-9\s\-\.\+#\/&àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]+$/i;
    let tagInvalid = false;
    for (let i = 0; i < data.tu_khoa.length; i++) {
        if (!tagRegex.test(data.tu_khoa[i])) {
            tagInvalid = true;
            break;
        }
    }
    if (tagInvalid) {
        hienToast('error', 'Từ khóa công nghệ không được chứa ký tự đặc biệt lạ.');
        document.getElementById('input-project-tags').focus();
        return;
    }

    // Kiểm tra số lượng liên kết ngoài tối đa là 5
    if (data.lien_ket.length > 5) {
        hienToast('error', 'Mỗi dự án chỉ được thêm tối đa 5 liên kết.');
        return;
    }

    if (!data.mo_ta) {
        hienToast('error', 'Mô tả chi tiết dự án không được để trống.');
        document.getElementById('input-project-desc').focus();
        return;
    }

    if (data.mo_ta.length > 1000) {
        hienToast('error', 'Mô tả chi tiết dự án không được vượt quá 1000 ký tự.');
        document.getElementById('input-project-desc').focus();
        return;
    }

    datTrangThaiLoading(btn, true);

    const urlLuu = window.ROUTES.luuDuAn;
    console.log('[DuAn] luuDuAn URL:', urlLuu, 'data:', data);

    fetch(urlLuu, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'X-Requested-With': 'XMLHttpRequest',
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
                dongModal('modal-du-an');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[DuAn] Fetch error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btn, false));
}

/**
 * Xóa thông tin dự án (Xóa mềm)
 */
function xoaDuAn(event, id) {
    if (event) {
        if (typeof event.stopPropagation === 'function') {
            event.stopPropagation();
        }
        if (typeof event.preventDefault === 'function') {
            event.preventDefault();
        }
    }
    console.log('[DuAn] xoaDuAn called with ID:', id);
    if (!id) return;
    
    if (!confirm('Bạn có chắc chắn muốn xóa dự án này khỏi Portfolio không?')) {
        return;
    }

    const baseRoute = window.ROUTES.xoaDuAn;
    const urlXoa = baseRoute.includes('ID_PLACEHOLDER')
        ? baseRoute.replace('ID_PLACEHOLDER', id)
        : (baseRoute.endsWith('/') ? baseRoute + id : baseRoute + '/' + id);

    console.log('[DuAn] xoaDuAn URL:', urlXoa);

    fetch(urlXoa, {
        method: 'POST',
        credentials: 'same-origin',
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
            console.error('[DuAn] Delete error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        });
}



/**
 * Khởi tạo sự kiện cho các bộ lọc dự án
 */
function khoiTaoBoLocDuAn() {
    const filterInputs = [
        'filter-cong-nghe',
        'filter-ngay-bat-dau-tu',
        'filter-ngay-bat-dau-den',
        'filter-ngay-ket-thuc-tu',
        'filter-ngay-ket-thuc-den',
        'filter-noi-bat'
    ];

    filterInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', applyProjectFilters);
            el.addEventListener('input', applyProjectFilters);
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

            applyProjectFilters();
        });
    }

    // Gắn sự kiện cho thanh tìm kiếm chính để chạy applyProjectFilters
    const searchInput = document.getElementById('main-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', applyProjectFilters);
    }
}

/**
 * Áp dụng bộ lọc và ẩn/hiện card dự án
 */
function applyProjectFilters() {
    const searchInput = document.getElementById('main-search-input');
    const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
    
    const congNghe = document.getElementById('filter-cong-nghe') ? document.getElementById('filter-cong-nghe').value.trim().toLowerCase() : '';
    const ngayBatDauTu = document.getElementById('filter-ngay-bat-dau-tu') ? document.getElementById('filter-ngay-bat-dau-tu').value : '';
    const ngayBatDauDen = document.getElementById('filter-ngay-bat-dau-den') ? document.getElementById('filter-ngay-bat-dau-den').value : '';
    const ngayKetThucTu = document.getElementById('filter-ngay-ket-thuc-tu') ? document.getElementById('filter-ngay-ket-thuc-tu').value : '';
    const ngayKetThucDen = document.getElementById('filter-ngay-ket-thuc-den') ? document.getElementById('filter-ngay-ket-thuc-den').value : '';
    const filterNoiBat = document.getElementById('filter-noi-bat') ? document.getElementById('filter-noi-bat').value : '';

    const cards = document.querySelectorAll('.project-card');
    let visibleCount = 0;

    cards.forEach(card => {
        let isMatch = true;

        // 1. Lọc theo từ khóa tìm kiếm chính
        if (keyword) {
            const textContent = card.textContent.toLowerCase();
            if (!textContent.includes(keyword)) {
                isMatch = false;
            }
        }

        // 2. Lọc theo từ khóa công nghệ (dropdown)
        if (isMatch && congNghe) {
            const cardTuKhoaRaw = card.getAttribute('data-tu-khoa'); // lowercase array JSON
            try {
                const tags = JSON.parse(cardTuKhoaRaw) || [];
                if (!tags.includes(congNghe)) {
                    isMatch = false;
                }
            } catch (e) {
                isMatch = false;
            }
        }

        // 3. Lọc theo ngày bắt đầu
        if (isMatch) {
            const cardNgayBatDau = card.getAttribute('data-ngay-bat-dau'); // YYYY-MM-DD
            if (cardNgayBatDau) {
                if (ngayBatDauTu && cardNgayBatDau < ngayBatDauTu) {
                    isMatch = false;
                }
                if (ngayBatDauDen && cardNgayBatDau > ngayBatDauDen) {
                    isMatch = false;
                }
            } else if (ngayBatDauTu || ngayBatDauDen) {
                isMatch = false;
            }
        }

        // 4. Lọc theo ngày kết thúc
        if (isMatch) {
            const cardNgayKetThuc = card.getAttribute('data-ngay-ket-thuc'); // YYYY-MM-DD or empty
            if (cardNgayKetThuc) {
                if (ngayKetThucTu && cardNgayKetThuc < ngayKetThucTu) {
                    isMatch = false;
                }
                if (ngayKetThucDen && cardNgayKetThuc > ngayKetThucDen) {
                    isMatch = false;
                }
            } else if (ngayKetThucTu || ngayKetThucDen) {
                // Nếu lọc ngày kết thúc nhưng card không có ngày kết thúc (dự án đang diễn ra)
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
 * Mở modal xem chi tiết dự án (chỉ xem, không sửa)
 */
function moModalChiTietDuAn(event, item) {
    if (event) {
        // Ngăn chặn nếu click trúng các nút hành động (sửa, xóa hoặc liên kết)
        if (event.target.closest('.project-card-actions-inline') || event.target.closest('.project-links')) {
            return;
        }
    }

    try {
        window.currentProjectItem = item;
        document.getElementById('detail-project-name').textContent = item.ten_du_an || 'Chưa cập nhật';
        document.getElementById('detail-project-role').textContent = item.vai_tro || 'Chưa cập nhật';
        
        // Thời gian
        const dinhDangThangNam = (dateStr) => {
            if (!dateStr) return '';
            const parts = dateStr.split('-');
            if (parts.length >= 2) {
                return `${parts[1]}/${parts[0]}`;
            }
            return dateStr;
        };

        const batDau = dinhDangThangNam(item.ngay_bat_dau);
        const ketThuc = item.ngay_ket_thuc ? dinhDangThangNam(item.ngay_ket_thuc) : 'Hiện tại';
        document.getElementById('detail-project-time').textContent = `${batDau} - ${ketThuc}`;
        
        // Công nghệ sử dụng
        const tagsContainer = document.getElementById('detail-project-tags');
        tagsContainer.innerHTML = '';
        const tags = Array.isArray(item.tu_khoa) ? item.tu_khoa : (item.tu_khoa ? JSON.parse(item.tu_khoa) : []);
        if (tags.length > 0) {
            tags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'project-tag';
                span.textContent = tag;
                tagsContainer.appendChild(span);
            });
        } else {
            tagsContainer.innerHTML = '<span style="font-size:12px; color:var(--text-secondary); font-style:italic;">Không có từ khóa công nghệ.</span>';
        }
        
        // Mô tả chi tiết
        document.getElementById('detail-project-desc').textContent = item.mo_ta || 'Không có mô tả chi tiết.';
        
        // Liên kết ngoài
        const linksContainer = document.getElementById('detail-project-links');
        linksContainer.innerHTML = '';
        const links = Array.isArray(item.lien_ket) ? item.lien_ket : [];
        if (links.length > 0) {
            links.forEach(lk => {
                const a = document.createElement('a');
                a.href = lk.duong_dan;
                a.target = '_blank';
                a.className = 'project-link-icon';
                a.style.display = 'inline-flex';
                a.style.borderRadius = '20px';
                a.style.padding = '4px 12px';
                a.style.fontSize = '12px';
                a.style.width = 'auto';
                a.style.height = 'auto';
                a.style.textDecoration = 'none';
                a.style.gap = '6px';
                a.style.alignItems = 'center';
                a.title = lk.nhan_hien_thi || lk.loai_lien_ket;

                let iconSvg = '';
                if (lk.loai_lien_ket === 'github') {
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.579.688.481C19.137 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>';
                } else if (lk.loai_lien_ket === 'demo') {
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>';
                } else {
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>';
                }
                
                a.innerHTML = `${iconSvg} <span>${lk.nhan_hien_thi || lk.loai_lien_ket}</span>`;
                linksContainer.appendChild(a);
            });
        } else {
            linksContainer.innerHTML = '<span style="font-size:12px; color:var(--text-secondary); font-style:italic;">Không có liên kết.</span>';
        }
        
        moModal('modal-chi-tiet-du-an');
    } catch (e) {
        console.error('Lỗi khi hiển thị chi tiết dự án:', e);
        hienToast('error', 'Không thể hiển thị thông tin chi tiết dự án.');
    }
}
