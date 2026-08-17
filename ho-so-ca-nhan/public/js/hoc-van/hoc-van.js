/**
 * hoc-van.js
 * JavaScript cho chức năng quản lý Học vấn & Trình độ
 */

document.addEventListener('DOMContentLoaded', function () {
    fillYearSelects();
    khoiTaoFormHocVan();

    // Nút mở modal thêm mới học vấn
    const btnThemHocVan = document.getElementById('btn-them-hoc-van');
    if (btnThemHocVan) {
        btnThemHocVan.addEventListener('click', function () {
            moModalThemHocVan();
        });
    }

    // Toggle disable cho năm kết thúc khi chọn trạng thái "Đang học"
    const selectTrangThai = document.getElementById('input-edu-trang-thai');
    if (selectTrangThai) {
        selectTrangThai.addEventListener('change', function () {
            toggleNamKetThucState(this.value);
        });
    }

    // Đếm ký tự mô tả
    const textareaMoTa = document.getElementById('input-edu-mo-ta');
    if (textareaMoTa) {
        textareaMoTa.addEventListener('input', function () {
            capNhatDemKyTu(this);
        });
    }

    // Bộ lọc học vấn
    const filterNam = document.getElementById('filter-nam');
    const filterTrangThai = document.getElementById('filter-trang-thai');
    const filterXepLoai = document.getElementById('filter-xep-loai');
    const filterNoiBat = document.getElementById('filter-noi-bat');
    const btnResetFilters = document.getElementById('btn-reset-filters');

    if (filterNam) filterNam.addEventListener('change', filterHocVan);
    if (filterTrangThai) filterTrangThai.addEventListener('change', filterHocVan);
    if (filterXepLoai) filterXepLoai.addEventListener('change', filterHocVan);
    if (filterNoiBat) filterNoiBat.addEventListener('change', filterHocVan);

    if (btnResetFilters) {
        btnResetFilters.addEventListener('click', function () {
            if (filterNam) filterNam.value = '';
            if (filterTrangThai) filterTrangThai.value = '';
            if (filterXepLoai) filterXepLoai.value = '';
            if (filterNoiBat) filterNoiBat.value = '';
            filterHocVan();
        });
    }

    // Nút Sửa trong modal chi tiết học vấn
    const btnDetailSua = document.getElementById('btn-detail-sua-hoc-van');
    if (btnDetailSua) {
        btnDetailSua.addEventListener('click', function () {
            if (window.currentHocVanItem) {
                dongModal('modal-chi-tiet-hoc-van');
                moModalSuaHocVan(window.currentHocVanItem);
            }
        });
    }

    // Nút Xóa trong modal chi tiết học vấn
    const btnDetailXoa = document.getElementById('btn-detail-xoa-hoc-van');
    if (btnDetailXoa) {
        btnDetailXoa.addEventListener('click', function () {
            if (window.currentHocVanItem) {
                dongModal('modal-chi-tiet-hoc-van');
                xoaHocVan(window.currentHocVanItem.id);
            }
        });
    }
});

/**
 * Tạo danh sách năm tự động cho select boxes
 */
function fillYearSelects() {
    const currentYear = new Date().getFullYear();
    const selectBatDau = document.getElementById('input-edu-nam-bat-dau');
    const selectKetThuc = document.getElementById('input-edu-nam-ket-thuc');
    
    if (!selectBatDau || !selectKetThuc) return;

    // Lưu giá trị cũ nếu có
    const valBatDau = selectBatDau.value;
    const valKetThuc = selectKetThuc.value;

    selectBatDau.innerHTML = '<option value="">Chọn năm</option>';
    selectKetThuc.innerHTML = '<option value="">Chọn năm</option>';

    // Start year: currentYear + 5 down to 1970
    for (let year = currentYear + 5; year >= 1970; year--) {
        const opt1 = document.createElement('option');
        opt1.value = year;
        opt1.textContent = year;
        selectBatDau.appendChild(opt1);
    }

    // End year: currentYear + 10 down to 1970
    for (let year = currentYear + 10; year >= 1970; year--) {
        const opt2 = document.createElement('option');
        opt2.value = year;
        opt2.textContent = year;
        selectKetThuc.appendChild(opt2);
    }

    if (valBatDau) selectBatDau.value = valBatDau;
    if (valKetThuc) selectKetThuc.value = valKetThuc;
}

/**
 * Toggle trạng thái disabled và required cho năm kết thúc
 */
function toggleNamKetThucState(trangThai) {
    const selectKetThuc = document.getElementById('input-edu-nam-ket-thuc');
    const asterisk = document.querySelector('.nam-ket-thuc-required');
    const labelKetThuc = document.querySelector('label[for="input-edu-nam-ket-thuc"]');
    if (!selectKetThuc) return;

    if (trangThai === 'dang_hoc') {
        selectKetThuc.disabled = false;
        selectKetThuc.classList.remove('disabled');
        selectKetThuc.removeAttribute('required');
        if (labelKetThuc) {
            labelKetThuc.innerHTML = 'Năm dự kiến tốt nghiệp <span class="nam-ket-thuc-required text-red-500" style="color:#ef4444; display: none;">*</span>';
        }
        if (asterisk) asterisk.style.display = 'none';
    } else {
        selectKetThuc.disabled = false;
        selectKetThuc.classList.remove('disabled');
        selectKetThuc.setAttribute('required', 'required');
        if (labelKetThuc) {
            labelKetThuc.innerHTML = 'Năm kết thúc <span class="nam-ket-thuc-required text-red-500" style="color:#ef4444;">*</span>';
        }
        if (asterisk) asterisk.style.display = '';
    }
}

/**
 * Cập nhật hiển thị số ký tự của textarea mô tả
 */
function capNhatDemKyTu(textarea) {
    const demEl = document.getElementById('edu-desc-counter');
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
function moModalThemHocVan() {
    const form = document.getElementById('form-hoc-van');
    if (!form) return;

    form.reset();
    document.getElementById('input-edu-id').value = '';
    document.getElementById('modal-hoc-van-title').textContent = 'Cập nhật học vấn & trình độ';
    
    // Ẩn nút xóa học vấn khi thêm mới
    const btnXoa = document.getElementById('btn-xoa-hoc-van');
    if (btnXoa) btnXoa.style.display = 'none';

    // Mặc định thiết lập trạng thái Đang học/Tốt nghiệp để toggle năm kết thúc đúng cách
    toggleNamKetThucState('da_tot_nghiep');
    
    const demEl = document.getElementById('edu-desc-counter');
    if (demEl) demEl.textContent = '0';

    moModal('modal-hoc-van');
}

/**
 * Mở modal chỉnh sửa và điền dữ liệu có sẵn
 */
function moModalSuaHocVan(itemJson) {
    const form = document.getElementById('form-hoc-van');
    if (!form) return;

    try {
        const item = typeof itemJson === 'string' ? JSON.parse(itemJson) : itemJson;
        
        document.getElementById('input-edu-id').value = item.id || '';
        document.getElementById('input-edu-tieu-de').value = item.tieu_de || '';
        document.getElementById('input-edu-ten-truong').value = item.ten_truong || '';
        document.getElementById('input-edu-nam-bat-dau').value = item.nam_bat_dau || '';
        
        const trangThai = item.trang_thai || 'da_tot_nghiep';
        document.getElementById('input-edu-trang-thai').value = trangThai;
        
        toggleNamKetThucState(trangThai);
        document.getElementById('input-edu-nam-ket-thuc').value = item.nam_ket_thuc || '';
        
        document.getElementById('input-edu-khoa').value = item.khoa || '';
        document.getElementById('input-edu-nganh').value = item.nganh || '';
        document.getElementById('input-edu-xep-loai').value = item.xep_loai || '';
        document.getElementById('input-edu-gpa').value = item.gpa !== null ? item.gpa : '';
        
        const moTa = item.mo_ta || '';
        const textarea = document.getElementById('input-edu-mo-ta');
        textarea.value = moTa;
        capNhatDemKyTu(textarea);

        document.getElementById('modal-hoc-van-title').textContent = 'Cập nhật học vấn & trình độ';
        
        // Hiện nút xóa học vấn khi chỉnh sửa
        const btnXoa = document.getElementById('btn-xoa-hoc-van');
        if (btnXoa) {
            btnXoa.style.display = 'inline-flex';
            btnXoa.onclick = function() {
                xoaHocVan(item.id);
            };
        }

        moModal('modal-hoc-van');
    } catch (e) {
        console.error('Lỗi khi mở modal sửa học vấn:', e);
        hienToast('error', 'Không thể hiển thị thông tin học vấn.');
    }
}

/**
 * Khởi tạo sự kiện submit form
 */
function khoiTaoFormHocVan() {
    const form = document.getElementById('form-hoc-van');
    const btnSave = document.getElementById('btn-luu-hoc-van');
    if (!form || !btnSave) return;

    btnSave.addEventListener('click', function (e) {
        e.preventDefault();
        luuHocVan(btnSave);
    });
}

/**
 * Validate và gửi AJAX lưu học vấn
 */
function luuHocVan(btn) {
    const form = document.getElementById('form-hoc-van');
    if (!form) return;

    let gpaValue = document.getElementById('input-edu-gpa').value.trim();
    if (gpaValue !== '') {
        gpaValue = gpaValue.replace(',', '.');
        if (gpaValue.includes('/')) {
            gpaValue = gpaValue.split('/')[0].trim();
        }
    }

    const data = {
        id:          document.getElementById('input-edu-id').value || null,
        tieu_de:     document.getElementById('input-edu-tieu-de').value.trim(),
        ten_truong:  document.getElementById('input-edu-ten-truong').value.trim(),
        nam_bat_dau: document.getElementById('input-edu-nam-bat-dau').value,
        nam_ket_thuc:document.getElementById('input-edu-nam-ket-thuc').value,
        trang_thai:  document.getElementById('input-edu-trang-thai').value,
        khoa:        document.getElementById('input-edu-khoa').value.trim(),
        nganh:       document.getElementById('input-edu-nganh').value.trim(),
        xep_loai:    document.getElementById('input-edu-xep-loai').value,
        gpa:         gpaValue,
        mo_ta:       document.getElementById('input-edu-mo-ta').value.trim(),
    };

    console.log('[HocVan] Saving payload:', data);

    // Client-side validations
    const regexNoSpecial = /^[\p{L}\p{N}\s,\.\-\(\)\/\+]+$/u;

    // 1. Tiêu đề bằng cấp: 2-50 ký tự, không ký tự đặc biệt lạ
    if (!data.tieu_de) {
        hienToast('error', 'Tiêu đề bằng cấp / chứng chỉ không được để trống.');
        document.getElementById('input-edu-tieu-de').focus();
        return;
    }
    if (data.tieu_de.length < 2 || data.tieu_de.length > 50) {
        hienToast('error', 'Tiêu đề bằng cấp / chứng chỉ phải từ 2 đến 50 ký tự.');
        document.getElementById('input-edu-tieu-de').focus();
        return;
    }
    if (!regexNoSpecial.test(data.tieu_de)) {
        hienToast('error', 'Tiêu đề bằng cấp / chứng chỉ không được chứa ký tự đặc biệt lạ.');
        document.getElementById('input-edu-tieu-de').focus();
        return;
    }

    // 2. Trường đào tạo: 2-200 ký tự, không ký tự đặc biệt lạ
    if (!data.ten_truong) {
        hienToast('error', 'Trường / Tổ chức đào tạo không được để trống.');
        document.getElementById('input-edu-ten-truong').focus();
        return;
    }
    if (data.ten_truong.length < 2 || data.ten_truong.length > 200) {
        hienToast('error', 'Trường / Tổ chức đào tạo phải từ 2 đến 200 ký tự.');
        document.getElementById('input-edu-ten-truong').focus();
        return;
    }
    if (!regexNoSpecial.test(data.ten_truong)) {
        hienToast('error', 'Trường / Tổ chức đào tạo không được chứa ký tự đặc biệt lạ.');
        document.getElementById('input-edu-ten-truong').focus();
        return;
    }

    // 3. Năm bắt đầu
    if (!data.nam_bat_dau) {
        hienToast('error', 'Vui lòng chọn năm bắt đầu.');
        document.getElementById('input-edu-nam-bat-dau').focus();
        return;
    }

    // 4. Năm kết thúc (nếu không phải đang học)
    if (data.trang_thai !== 'dang_hoc') {
        if (!data.nam_ket_thuc) {
            hienToast('error', 'Vui lòng chọn năm kết thúc.');
            document.getElementById('input-edu-nam-ket-thuc').focus();
            return;
        }
        if (parseInt(data.nam_ket_thuc) < parseInt(data.nam_bat_dau)) {
            hienToast('error', 'Năm kết thúc phải lớn hơn hoặc bằng năm bắt đầu.');
            document.getElementById('input-edu-nam-ket-thuc').focus();
            return;
        }
        if (data.trang_thai === 'da_tot_nghiep') {
            const currentYear = new Date().getFullYear();
            if (parseInt(data.nam_ket_thuc) > currentYear) {
                hienToast('error', 'Năm tốt nghiệp không thể lớn hơn năm hiện tại.');
                document.getElementById('input-edu-nam-ket-thuc').focus();
                return;
            }
        }
    } else {
        if (data.nam_ket_thuc) {
            if (parseInt(data.nam_ket_thuc) < parseInt(data.nam_bat_dau)) {
                hienToast('error', 'Năm dự kiến tốt nghiệp phải lớn hơn hoặc bằng năm bắt đầu.');
                document.getElementById('input-edu-nam-ket-thuc').focus();
                return;
            }
        }
    }

    // 5. Điểm GPA: 0 đến 10
    if (data.gpa !== '') {
        const gpaVal = parseFloat(data.gpa);
        if (isNaN(gpaVal) || gpaVal < 0 || gpaVal > 10) {
            hienToast('error', 'Điểm GPA phải nằm trong khoảng từ 0 đến 10.');
            document.getElementById('input-edu-gpa').focus();
            return;
        }
    }

    // Khoa: 2 đến 100 ký tự, không ký tự đặc biệt lạ (nếu có nhập)
    if (data.khoa) {
        if (data.khoa.length < 2 || data.khoa.length > 100) {
            hienToast('error', 'Tên khoa phải từ 2 đến 100 ký tự.');
            document.getElementById('input-edu-khoa').focus();
            return;
        }
        if (!regexNoSpecial.test(data.khoa)) {
            hienToast('error', 'Tên khoa không được chứa ký tự đặc biệt lạ.');
            document.getElementById('input-edu-khoa').focus();
            return;
        }
    }

    // Ngành học: 2 đến 100 ký tự, không ký tự đặc biệt lạ (nếu có nhập)
    if (data.nganh) {
        if (data.nganh.length < 2 || data.nganh.length > 100) {
            hienToast('error', 'Tên ngành học phải từ 2 đến 100 ký tự.');
            document.getElementById('input-edu-nganh').focus();
            return;
        }
        if (!regexNoSpecial.test(data.nganh)) {
            hienToast('error', 'Tên ngành học không được chứa ký tự đặc biệt lạ.');
            document.getElementById('input-edu-nganh').focus();
            return;
        }
    }

    // 6. Mô tả tối đa 1000 ký tự
    if (data.mo_ta.length > 1000) {
        hienToast('error', 'Mô tả chi tiết không được vượt quá 1000 ký tự.');
        document.getElementById('input-edu-mo-ta').focus();
        return;
    }

    datTrangThaiLoading(btn, true);

    const urlLuu = window.ROUTES.luuHocVan;

    fetch(urlLuu, {
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
                dongModal('modal-hoc-van');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[HocVan] Fetch error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btn, false));
}

/**
 * Xóa thông tin học vấn
 */
function xoaHocVan(id, urlXoa = null) {
    console.log('[HocVan] xoaHocVan called with ID:', id, 'url:', urlXoa);
    if (!id) {
        console.warn('[HocVan] No ID provided for deletion');
        return;
    }
    
    if (!confirm('Bạn có chắc chắn muốn xóa mục học vấn & trình độ này không?')) {
        console.log('[HocVan] Deletion cancelled by user');
        return;
    }

    if (!urlXoa) {
        if (!window.ROUTES || !window.ROUTES.xoaHocVan) {
            console.error('[HocVan] Delete route not configured');
            hienToast('error', 'Không thể xóa do cấu hình đường dẫn không hợp lệ.');
            return;
        }
        const baseRoute = window.ROUTES.xoaHocVan;
        urlXoa = baseRoute.includes('ID_PLACEHOLDER')
            ? baseRoute.replace('ID_PLACEHOLDER', id)
            : (baseRoute.endsWith('/') ? baseRoute + id : baseRoute + '/' + id);
    }

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
            console.error('[HocVan] Delete error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        });
}

/**
 * Mở modal xem chi tiết học vấn (chỉ xem, không sửa)
 */
function moModalChiTietHocVan(event, itemJson) {
    // Ngăn chặn nếu click trúng các nút hành động (dù đã stopPropagation, phòng hờ)
    if (event.target.closest('.education-actions')) {
        return;
    }

    try {
        const item = typeof itemJson === 'string' ? JSON.parse(itemJson) : itemJson;
        window.currentHocVanItem = item;
        
        document.getElementById('detail-edu-tieu-de').textContent = item.tieu_de || 'Chưa cập nhật';
        document.getElementById('detail-edu-ten-truong').textContent = item.ten_truong || 'Chưa cập nhật';
        
        // Thời gian
        const namBatDau = item.nam_bat_dau;
        const namKetThuc = item.trang_thai === 'dang_hoc' ? 'Hiện tại' : (item.nam_ket_thuc || 'Chưa cập nhật');
        document.getElementById('detail-edu-thoi-gian').textContent = `${namBatDau} - ${namKetThuc}`;
        
        // Khoa / Ngành học
        document.getElementById('detail-edu-khoa').textContent = item.khoa || '-';
        document.getElementById('detail-edu-nganh').textContent = item.nganh || '-';
        
        // Trạng thái học tập
        const statusEl = document.getElementById('detail-edu-trang-thai');
        statusEl.className = 'timeline-status'; // reset
        if (item.trang_thai === 'dang_hoc') {
            statusEl.textContent = 'Đang học';
            statusEl.classList.add('status-dang_hoc');
            statusEl.removeAttribute('style');
        } else if (item.trang_thai === 'da_tot_nghiep') {
            statusEl.textContent = 'Đã hoàn thành';
            statusEl.classList.add('status-da_tot_nghiep');
            statusEl.removeAttribute('style');
        } else if (item.trang_thai === 'bao_luu') {
            statusEl.textContent = 'Bảo lưu';
            statusEl.style.backgroundColor = '#f3e8ff';
            statusEl.style.color = '#7c3aed';
        } else if (item.trang_thai === 'tam_dung') {
            statusEl.textContent = 'Tạm dừng';
            statusEl.classList.add('status-tam_dung');
            statusEl.removeAttribute('style');
        } else {
            statusEl.textContent = 'Chưa xác định';
            statusEl.removeAttribute('style');
        }

        // Xếp loại / GPA
        document.getElementById('detail-edu-xep-loai').textContent = item.xep_loai || 'Chưa xếp loại';
        
        const gpaContainer = document.getElementById('detail-edu-gpa-container');
        const gpaEl = document.getElementById('detail-edu-gpa');
        if (item.gpa !== null && item.gpa !== undefined && item.gpa !== '') {
            gpaEl.textContent = item.gpa;
            gpaContainer.style.display = 'inline';
        } else {
            gpaContainer.style.display = 'none';
        }
        
        // Mô tả
        const moTaEl = document.getElementById('detail-edu-mo-ta');
        if (item.mo_ta) {
            moTaEl.textContent = item.mo_ta;
            moTaEl.style.display = 'block';
        } else {
            moTaEl.textContent = 'Không có mô tả chi tiết.';
        }

        moModal('modal-chi-tiet-hoc-van');
    } catch (e) {
        console.error('Lỗi khi hiển thị chi tiết học vấn:', e);
        hienToast('error', 'Không thể hiển thị thông tin chi tiết học vấn.');
    }
}

/**
 * Lọc danh sách học vấn dựa trên năm, trạng thái, xếp loại
 */
function filterHocVan() {
    const filterNam = document.getElementById('filter-nam') ? document.getElementById('filter-nam').value : '';
    const filterTrangThai = document.getElementById('filter-trang-thai') ? document.getElementById('filter-trang-thai').value : '';
    const filterXepLoai = document.getElementById('filter-xep-loai') ? document.getElementById('filter-xep-loai').value : '';
    const filterNoiBat = document.getElementById('filter-noi-bat') ? document.getElementById('filter-noi-bat').value : '';

    const timelineItems = document.querySelectorAll('.timeline-item');
    let visibleCount = 0;

    timelineItems.forEach(item => {
        const namBatDau = parseInt(item.getAttribute('data-nam-bat-dau')) || 0;
        const namKetThuc = parseInt(item.getAttribute('data-nam-ket-thuc')) || new Date().getFullYear();
        const trangThai = item.getAttribute('data-trang-thai') || '';
        const xepLoai = item.getAttribute('data-xep-loai') || '';
        const noiBat = item.getAttribute('data-noi-bat') || '0';

        let matchNam = true;
        let matchTrangThai = true;
        let matchXepLoai = true;
        let matchNoiBat = true;

        if (filterNam) {
            const yr = parseInt(filterNam);
            // kiểm tra năm được chọn nằm trong khoảng namBatDau đến namKetThuc
            matchNam = (yr >= namBatDau && yr <= namKetThuc);
        }

        if (filterTrangThai) {
            matchTrangThai = (trangThai === filterTrangThai);
        }

        if (filterXepLoai) {
            matchXepLoai = (xepLoai === filterXepLoai);
        }

        if (filterNoiBat) {
            matchNoiBat = (noiBat === filterNoiBat);
        }

        if (matchNam && matchTrangThai && matchXepLoai && matchNoiBat) {
            item.style.display = '';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const noResultsCard = document.getElementById('no-filter-results');
    if (noResultsCard) {
        if (visibleCount === 0 && timelineItems.length > 0) {
            noResultsCard.style.display = '';
        } else {
            noResultsCard.style.display = 'none';
        }
    }
}
