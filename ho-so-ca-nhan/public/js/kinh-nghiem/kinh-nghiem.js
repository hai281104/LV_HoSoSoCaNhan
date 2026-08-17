document.addEventListener('DOMContentLoaded', function () {
    // Select elements
    const checkboxOngoing = document.getElementById('checkbox-exp-ongoing');
    const inputEnd = document.getElementById('input-exp-end');
    const spanEndRequired = document.getElementById('span-exp-end-required');
    const formExp = document.getElementById('form-kinh-nghiem');
    const btnLuuKinhNghiem = document.getElementById('btn-luu-kinh-nghiem');

    // Date picker coupling
    if (checkboxOngoing && inputEnd) {
        checkboxOngoing.addEventListener('change', function () {
            if (this.checked) {
                inputEnd.disabled = true;
                inputEnd.value = '';
                inputEnd.required = false;
                if (spanEndRequired) spanEndRequired.style.display = 'none';
            } else {
                inputEnd.disabled = false;
                inputEnd.required = true;
                if (spanEndRequired) spanEndRequired.style.display = 'inline';
            }
        });
    }

    // Word counter elements
    const textareaDesc = document.getElementById('input-exp-desc');
    const counterDesc = document.getElementById('exp-desc-counter');

    function capNhatDemKyTuExp(textarea) {
        if (!counterDesc) return;
        const count = textarea.value.length;
        counterDesc.textContent = count;
        if (count > 1000) {
            counterDesc.style.color = '#ef4444';
        } else {
            counterDesc.style.color = '';
        }
    }

    if (textareaDesc) {
        textareaDesc.addEventListener('input', function () {
            capNhatDemKyTuExp(this);
        });
    }

    // Modal Add
    window.moModalThemKinhNghiem = function () {
        document.getElementById('input-exp-id').value = '';
        formExp.reset();
        
        // Reset date fields state
        inputEnd.disabled = false;
        inputEnd.required = true;
        if (spanEndRequired) spanEndRequired.style.display = 'inline';
        if (checkboxOngoing) checkboxOngoing.checked = false;

        if (counterDesc) {
            counterDesc.textContent = '0';
            counterDesc.style.color = '';
        }

        document.getElementById('modal-kinh-nghiem-title').innerText = 'Thêm mới kinh nghiệm';
        moModal('modal-kinh-nghiem');
    };

    // Modal Edit
    window.moModalSuaKinhNghiem = function (event, item) {
        event.stopPropagation();
        
        document.getElementById('input-exp-id').value = item.id;
        document.getElementById('input-exp-position').value = item.vi_tri_cong_viec;
        document.getElementById('input-exp-company').value = item.ten_cong_ty;
        document.getElementById('input-exp-start').value = item.ngay_bat_dau;
        
        if (item.dang_lam_viec == 1) {
            if (checkboxOngoing) checkboxOngoing.checked = true;
            inputEnd.disabled = true;
            inputEnd.value = '';
            inputEnd.required = false;
            if (spanEndRequired) spanEndRequired.style.display = 'none';
        } else {
            if (checkboxOngoing) checkboxOngoing.checked = false;
            inputEnd.disabled = false;
            inputEnd.value = item.ngay_ket_thuc || '';
            inputEnd.required = true;
            if (spanEndRequired) spanEndRequired.style.display = 'inline';
        }

        document.getElementById('input-exp-desc').value = item.mo_ta_chi_tiet || '';
        if (textareaDesc) {
            capNhatDemKyTuExp(textareaDesc);
        }

        document.getElementById('modal-kinh-nghiem-title').innerText = 'Cập nhật kinh nghiệm';
        moModal('modal-kinh-nghiem');
    };

    // Save Exp (AJAX)
    if (btnLuuKinhNghiem) {
        btnLuuKinhNghiem.addEventListener('click', function () {
            // Validate standard HTML5 elements
            if (!formExp.reportValidity()) {
                return;
            }

            // Client side validations
            const pos = document.getElementById('input-exp-position').value.trim();
            const comp = document.getElementById('input-exp-company').value.trim();
            const start = document.getElementById('input-exp-start').value;
            const end = inputEnd.value;
            const ongoing = checkboxOngoing ? checkboxOngoing.checked : false;

            // Character validation (Regex matching backend)
            let validPos = true;
            let validComp = true;
            try {
                validPos = new RegExp("^[\\p{L}\\p{N}\\s]+$", "u").test(pos);
            } catch(e) { /* fallback if regex u not supported */ }

            try {
                validComp = new RegExp("^[\\p{L}\\p{N}\\s]+$", "u").test(comp);
            } catch(e) { /* fallback */ }

            if (!validPos) {
                hienToast('error', 'Vị trí công việc không được chứa ký tự đặc biệt.');
                return;
            }

            if (!validComp) {
                hienToast('error', 'Tên công ty không được chứa ký tự đặc biệt.');
                return;
            }

            // Character count validation for detailed description
            const desc = document.getElementById('input-exp-desc').value;
            if (desc && desc.length > 1000) {
                hienToast('error', 'Mô tả chi tiết không được vượt quá 1000 ký tự.');
                return;
            }

            if (!ongoing && end && new Date(end) < new Date(start)) {
                hienToast('error', 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.');
                return;
            }

            // Form data preparation
            const formData = new FormData(formExp);
            if (ongoing) {
                formData.set('dang_lam_viec', '1');
            } else {
                formData.set('dang_lam_viec', '0');
            }

            // AJAX submit
            btnLuuKinhNghiem.classList.add('loading');
            btnLuuKinhNghiem.disabled = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(window.ROUTES.luuKinhNghiem, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                btnLuuKinhNghiem.classList.remove('loading');
                btnLuuKinhNghiem.disabled = false;

                if (data.thanh_cong) {
                    hienToast('success', data.thong_bao);
                    dongModal('modal-kinh-nghiem');
                    setTimeout(() => location.reload(), 800);
                } else {
                    hienToast('error', data.thong_bao || 'Lỗi khi lưu kinh nghiệm.');
                }
            })
            .catch(error => {
                btnLuuKinhNghiem.classList.remove('loading');
                btnLuuKinhNghiem.disabled = false;
                hienToast('error', 'Có lỗi xảy ra: ' + error.message);
            });
        });
    }

    // Delete Exp (AJAX)
    window.xoaKinhNghiem = function (event, id) {
        event.stopPropagation();
        
        if (!confirm('Bạn có chắc chắn muốn xóa kinh nghiệm làm việc này?')) {
            return;
        }

        const url = window.ROUTES.xoaKinhNghiem.replace('ID_PLACEHOLDER', id);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.thanh_cong) {
                hienToast('success', data.thong_bao);
                setTimeout(() => location.reload(), 800);
            } else {
                hienToast('error', data.thong_bao || 'Lỗi khi xóa kinh nghiệm.');
            }
        })
        .catch(error => {
            hienToast('error', 'Có lỗi xảy ra: ' + error.message);
        });
    };

    // Modal Details (Read-only view)
    window.moModalChiTietKinhNghiem = function (event, item) {
        window.currentKinhNghiemItem = item;

        // Populate fields
        document.getElementById('detail-exp-position').innerText = item.vi_tri_cong_viec;
        document.getElementById('detail-exp-company').innerText = item.ten_cong_ty;

        // Formatted dates
        const parseFullDate = (dStr) => {
            if (!dStr) return 'Chưa cập nhật';
            const d = new Date(dStr);
            if (isNaN(d.getTime())) return dStr;
            const dd = String(d.getDate()).padStart(2, '0');
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const yyyy = d.getFullYear();
            return `${dd}/${mm}/${yyyy}`;
        };

        document.getElementById('detail-exp-start-date').innerText = parseFullDate(item.ngay_bat_dau);
        document.getElementById('detail-exp-end-date').innerText = item.dang_lam_viec == 1 ? 'Hiện tại' : (parseFullDate(item.ngay_ket_thuc) || 'Chưa cập nhật');

        // Status badge
        const statusEl = document.getElementById('detail-exp-status');
        if (item.dang_lam_viec == 1) {
            statusEl.innerHTML = '<span class="timeline-status status-dang_hoc">Đang làm việc</span>';
        } else {
            statusEl.innerHTML = '<span class="timeline-status status-da_tot_nghiep">Đã kết thúc</span>';
        }

        // Description
        document.getElementById('detail-exp-desc').innerText = item.mo_ta_chi_tiet || 'Không có mô tả chi tiết.';

        moModal('modal-chi-tiet-kinh-nghiem');
    };

    // Client-side Filters & Search
    const searchInput = document.getElementById('main-search-input');
    const selectTrangThai = document.getElementById('filter-trang-thai');
    const selectNam = document.getElementById('filter-nam');
    const selectNoiBat = document.getElementById('filter-noi-bat');
    const btnReset = document.getElementById('btn-reset-filters');

    function applyFilters() {
        const filterStatus = selectTrangThai ? selectTrangThai.value : '';
        const filterYear = selectNam ? selectNam.value : '';
        const filterNoiBat = selectNoiBat ? selectNoiBat.value : '';

        const timelineGroups = document.querySelectorAll('.timeline-group');
        let totalVisibleItems = 0;

        timelineGroups.forEach(group => {
            const items = group.querySelectorAll('.experience-list-item');
            let visibleInGroup = 0;

            items.forEach(item => {
                // Status match
                const isOngoing = item.getAttribute('data-dang-lam-viec') == '1';
                const matchStatus = filterStatus === '' || 
                    (filterStatus === 'dang_lam' && isOngoing) || 
                    (filterStatus === 'da_nghi' && !isOngoing);

                // Year filter match
                const startYear = parseInt(item.getAttribute('data-nam-bat-dau'), 10);
                const endYearAttr = item.getAttribute('data-nam-ket-thuc');
                const currentYear = new Date().getFullYear();
                const endYear = isOngoing ? currentYear : (endYearAttr ? parseInt(endYearAttr, 10) : currentYear);

                let matchYear = true;
                if (filterYear !== '') {
                    const targetYear = parseInt(filterYear, 10);
                    matchYear = (targetYear >= startYear && targetYear <= endYear);
                }

                // Outstanding match
                const noiBat = item.getAttribute('data-noi-bat') || '0';
                let matchNoiBat = true;
                if (filterNoiBat !== '') {
                    matchNoiBat = (noiBat === filterNoiBat);
                }

                if (matchStatus && matchYear && matchNoiBat) {
                    item.style.display = 'flex';
                    visibleInGroup++;
                    totalVisibleItems++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Set visibility of timeline group container
            if (visibleInGroup > 0) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });

        // Show/hide no results card
        const noResults = document.getElementById('no-filter-results');
        if (noResults) {
            if (totalVisibleItems === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    }

    // Connect event listeners
    if (selectTrangThai) {
        selectTrangThai.addEventListener('change', applyFilters);
    }
    if (selectNam) {
        selectNam.addEventListener('change', applyFilters);
    }
    if (selectNoiBat) {
        selectNoiBat.addEventListener('change', applyFilters);
    }
    if (btnReset) {
        btnReset.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (selectTrangThai) selectTrangThai.value = '';
            if (selectNam) selectNam.value = '';
            if (selectNoiBat) selectNoiBat.value = '';
            if (typeof highlightText === 'function') {
                highlightText('');
            }
            applyFilters();
        });
    }

    // Nút Sửa trong modal chi tiết kinh nghiệm
    const btnDetailSuaKinhNghiem = document.getElementById('btn-detail-sua-kinh-nghiem');
    if (btnDetailSuaKinhNghiem) {
        btnDetailSuaKinhNghiem.addEventListener('click', function () {
            if (window.currentKinhNghiemItem) {
                dongModal('modal-chi-tiet-kinh-nghiem');
                moModalSuaKinhNghiem(new Event('click'), window.currentKinhNghiemItem);
            }
        });
    }

    // Nút Xóa trong modal chi tiết kinh nghiệm
    const btnDetailXoaKinhNghiem = document.getElementById('btn-detail-xoa-kinh-nghiem');
    if (btnDetailXoaKinhNghiem) {
        btnDetailXoaKinhNghiem.addEventListener('click', function () {
            if (window.currentKinhNghiemItem && window.currentKinhNghiemItem.id) {
                dongModal('modal-chi-tiet-kinh-nghiem');
                xoaKinhNghiem(new Event('click'), window.currentKinhNghiemItem.id);
            }
        });
    }
});
