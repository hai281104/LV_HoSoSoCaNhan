document.addEventListener('DOMContentLoaded', function () {
    khoiTaoTabs();
    khoiTaoFormDichVu();
    khoiTaoTimKiemCaNhan();
    khoiTaoTimKiemCongDong();
});

// ============================================================
// TAB CONTROL (ĐIỀU KHIỂN TAB)
// ============================================================
function khoiTaoTabs() {
    const cacNutTab = document.querySelectorAll('.tab-btn');
    cacNutTab.forEach(nut => {
        nut.addEventListener('click', function () {
            const tabMucTieu = this.getAttribute('data-tab');
            
            // Kích hoạt nút tab
            cacNutTab.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Kích hoạt panel tương ứng
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            const panel = document.getElementById(tabMucTieu);
            if (panel) panel.classList.add('active');
        });
    });
}

// ============================================================
// SERVICE CRUD AJAX (THAO TÁC NGHIỆP VỤ DỊCH VỤ)
// ============================================================
function khoiTaoFormDichVu() {
    const formDichVu = document.getElementById('form-dich-vu');
    const inputTieuDe = document.getElementById('input-service-title');
    const boDemTieuDe = document.getElementById('title-counter');
    const inputMoTa = document.getElementById('input-service-desc');
    const boDemMoTa = document.getElementById('desc-counter');
    const nutLuu = document.getElementById('btn-save-service');

    // Đếm ký tự tiêu đề
    if (inputTieuDe && boDemTieuDe) {
        inputTieuDe.addEventListener('input', function () {
            const doDai = this.value.length;
            boDemTieuDe.textContent = doDai;
            boDemTieuDe.parentElement.className = doDai > 50 ? 'counter-over' : '';
        });
    }

    // Đếm ký tự mô tả
    if (inputMoTa && boDemMoTa) {
        inputMoTa.addEventListener('input', function () {
            boDemMoTa.textContent = this.value.length;
        });
    }

    if (!formDichVu || !nutLuu) return;

    nutLuu.addEventListener('click', function () {
        const giaTriId        = document.getElementById('input-service-id').value;
        const giaTriTieuDe    = (inputTieuDe ? inputTieuDe.value : '').trim();
        const giaTriPhanLoai  = document.getElementById('input-service-category').value;
        const giaTriMoTa      = (inputMoTa ? inputMoTa.value : '').trim();
        const zaloTho         = document.getElementById('input-service-zalo').value.trim();
        const giaTriGmail     = document.getElementById('input-service-gmail').value.trim().toLowerCase();
        const giaTriCv        = document.getElementById('select-service-cv').value;

        // === Validate Tên dịch vụ ===
        if (!giaTriTieuDe) {
            hienToast('error', 'Tên dịch vụ không được để trống.');
            if (inputTieuDe) inputTieuDe.focus();
            return;
        }
        if (giaTriTieuDe.length < 2 || giaTriTieuDe.length > 50) {
            hienToast('error', 'Tên dịch vụ phải từ 2 đến 50 ký tự.');
            if (inputTieuDe) inputTieuDe.focus();
            return;
        }

        // === Validate Phân loại ===
        if (!giaTriPhanLoai) {
            hienToast('error', 'Vui lòng chọn lĩnh vực chuyên môn.');
            return;
        }

        // === Validate Mô tả ===
        if (!giaTriMoTa) {
            hienToast('error', 'Mô tả dịch vụ là bắt buộc.');
            if (inputMoTa) inputMoTa.focus();
            return;
        }
        if (giaTriMoTa.length > 2000) {
            hienToast('error', 'Mô tả không được vượt quá 2000 ký tự.');
            if (inputMoTa) inputMoTa.focus();
            return;
        }

        // === Validate Zalo (số điện thoại Việt Nam) ===
        if (!zaloTho) {
            hienToast('error', 'Số Zalo liên hệ là bắt buộc.');
            document.getElementById('input-service-zalo').focus();
            return;
        }
        const zaloDaChuanHoa = zaloTho.replace(/[\s.-]/g, '');
        const regexZalo = /^(0|\+84)[35789][0-9]{8}$/;
        if (!regexZalo.test(zaloDaChuanHoa)) {
            hienToast('error', 'Số Zalo không đúng định dạng (VD: 0912345678 hoặc +84912345678).');
            document.getElementById('input-service-zalo').focus();
            return;
        }
        document.getElementById('input-service-zalo').value = zaloDaChuanHoa;

        // === Validate Gmail ===
        if (!giaTriGmail) {
            hienToast('error', 'Email liên hệ là bắt buộc.');
            document.getElementById('input-service-gmail').focus();
            return;
        }
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexEmail.test(giaTriGmail)) {
            hienToast('error', 'Email không đúng định dạng (VD: example@gmail.com).');
            document.getElementById('input-service-gmail').focus();
            return;
        }
        document.getElementById('input-service-gmail').value = giaTriGmail;

        const duLieuGui = {
            id:          giaTriId || null,
            ten_dich_vu: giaTriTieuDe,
            phan_loai:   giaTriPhanLoai,
            mo_ta:       giaTriMoTa,
            zalo:        zaloDaChuanHoa,
            gmail:       giaTriGmail,
            id_cv:       giaTriCv ? parseInt(giaTriCv, 10) : null
        };

        datTrangThaiLoading(nutLuu, true);

        fetch(window.ROUTES.luuDichVu, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': layToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify(duLieuGui)
        })
        .then(async function(phanHoi) {
            const laJson = phanHoi.headers.get('content-type') && phanHoi.headers.get('content-type').includes('application/json');
            const duLieu = laJson ? await phanHoi.json() : null;
            if (!phanHoi.ok) {
                if (phanHoi.status === 422 && duLieu && duLieu.errors) {
                    throw new Error(Object.values(duLieu.errors).flat().join(', '));
                }
                throw new Error((duLieu && duLieu.thong_bao) || 'Lỗi máy chủ (' + phanHoi.status + ')');
            }
            return duLieu;
        })
        .then(function(duLieu) {
            if (duLieu && duLieu.thanh_cong) {
                hienToast('success', duLieu.thong_bao || 'Lưu dịch vụ thành công!');
                dongModal('modal-dich-vu');
                setTimeout(function() { window.location.reload(); }, 800);
            } else {
                hienToast('error', (duLieu && duLieu.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch(function(loi) {
            console.error('[DichVu] Save error:', loi);
            hienToast('error', loi.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(function() {
            datTrangThaiLoading(nutLuu, false);
        });
    });
}

// ============================================================
// EDIT MODAL PRE-FILL & TRIGGER (MỞ VÀ ĐIỀN THÔNG TIN MODAL SỬA)
// ============================================================
window.moModalDichVu = function(jsonDichVu) {
    const formDichVu = document.getElementById('form-dich-vu');
    if (!formDichVu) return;
    formDichVu.reset();

    const boDemMoTa  = document.getElementById('desc-counter');
    const boDemTieuDe = document.getElementById('title-counter');
    const nutLuu      = document.getElementById('btn-save-service');
    const chuNut      = nutLuu ? nutLuu.querySelector('.btn-text') : null;
    const phanTuTieuDe = document.getElementById('modal-dich-vu-title');
    const phanTuPhuDe  = phanTuTieuDe ? phanTuTieuDe.parentElement.querySelector('.modal-subtitle') : null;

    if (jsonDichVu) {
        const dichVu = typeof jsonDichVu === 'string' ? JSON.parse(jsonDichVu) : jsonDichVu;
        document.getElementById('input-service-id').value            = dichVu.id;
        document.getElementById('input-service-title').value         = dichVu.ten_dich_vu;
        document.getElementById('input-service-category').value      = dichVu.phan_loai || 'lap_trinh_web';
        document.getElementById('input-service-desc').value          = dichVu.mo_ta;
        document.getElementById('input-service-zalo').value          = dichVu.zalo;
        document.getElementById('input-service-gmail').value         = dichVu.gmail;
        document.getElementById('select-service-cv').value           = dichVu.id_cv || '';

        if (phanTuTieuDe) phanTuTieuDe.textContent = 'Cập nhật dịch vụ cá nhân';
        if (phanTuPhuDe) phanTuPhuDe.textContent = 'Chỉnh sửa thông tin dịch vụ, liên hệ và CV đính kèm';
        if (chuNut) chuNut.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Cập nhật';
        if (boDemMoTa) boDemMoTa.textContent = dichVu.mo_ta.length;
        if (boDemTieuDe) boDemTieuDe.textContent = dichVu.ten_dich_vu.length;
    } else {
        document.getElementById('input-service-id').value = '';
        if (phanTuTieuDe) phanTuTieuDe.textContent = 'Đăng ký dịch vụ mới';
        if (phanTuPhuDe) phanTuPhuDe.textContent = 'Diền thông tin dịch vụ, liên hệ và đính kèm CV nếu cần';
        if (chuNut) chuNut.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Đăng dịch vụ';
        document.getElementById('input-service-category').value = 'lap_trinh_web';
        if (boDemMoTa) boDemMoTa.textContent = '0';
        if (boDemTieuDe) { boDemTieuDe.textContent = '0'; boDemTieuDe.parentElement.className = ''; }

        document.getElementById('input-service-zalo').value  = window.USER_DATA.soDienThoai;
        document.getElementById('input-service-gmail').value = window.USER_DATA.email;
        document.getElementById('select-service-cv').value   = window.USER_DATA.cvChinhId;
    }
    moModal('modal-dich-vu');
};

// ============================================================
// DETAILS MODAL SHOW & ACTIONS (MỞ MODAL CHI TIẾT DỊCH VỤ)
// ============================================================
window.moModalChiTietDichVu = function(dichVu, laCuaToi) {
    if (!dichVu) return;

    // Parse nếu dữ liệu là chuỗi JSON
    const duLieu = typeof dichVu === 'string' ? JSON.parse(dichVu) : dichVu;

    // Cài đặt danh mục và tiêu đề
    const anhXaPhanLoai = {
        'lap_trinh_web': 'Lập trình Web',
        'toi_uu_sql': 'Tối ưu SQL/Database',
        'thiet_ke_uiux': 'Thiết kế UI/UX',
        'lap_trinh_mobile': 'Lập trình Mobile',
        'devops_cloud': 'DevOps & Cloud',
        'kiem_thu': 'Kiểm thử phần mềm',
        'an_ninh_mang': 'An ninh mạng / Bảo mật',
        'phan_tich_du_lieu': 'Phân tích dữ liệu (Data Analysis)',
        'tri_tue_nhan_tao': 'Trí tuệ nhân tạo (AI/Machine Learning)',
        'viet_lach_content': 'Viết lách / Biên dịch content',
        'quan_tri_du_an': 'Quản trị dự án (Project Management)',
        'khac': 'Lĩnh vực khác'
    };
    
    document.getElementById('modal-chi-tiet-category').textContent = anhXaPhanLoai[duLieu.phan_loai] || 'Lĩnh vực khác';
    document.getElementById('modal-chi-tiet-service-title').textContent = duLieu.ten_dich_vu;
    document.getElementById('modal-chi-tiet-service-desc').textContent = duLieu.mo_ta;

    // Định dạng ngày giờ
    const dinhDangNgayGio = function(chuoiNgay) {
        if (!chuoiNgay) return 'N/A';
        const d = new Date(chuoiNgay);
        if (isNaN(d.getTime())) return chuoiNgay;
        const pad = (n) => n.toString().padStart(2, '0');
        return `${pad(d.getHours())}:${pad(d.getMinutes())} ngày ${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()}`;
    };
    
    document.getElementById('modal-chi-tiet-created-at').textContent = dinhDangNgayGio(duLieu.ngay_tao);
    document.getElementById('modal-chi-tiet-updated-at').textContent = dinhDangNgayGio(duLieu.ngay_cap_nhat);

    // Chuẩn hóa số điện thoại Zalo
    const sdtZalo = (duLieu.zalo || '').replace(/[^0-9]/g, '');
    
    // Cài đặt Zalo & Gmail
    const phanTuGiaTriZalo = document.getElementById('modal-chi-tiet-zalo');
    const phanTuGiaTriGmail = document.getElementById('modal-chi-tiet-gmail');
    
    if (laCuaToi) {
        phanTuGiaTriZalo.innerHTML = `<a href="https://zalo.me/${sdtZalo}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();">${duLieu.zalo}</a>`;
        phanTuGiaTriGmail.innerHTML = `<a href="mailto:${duLieu.gmail}" onclick="event.stopPropagation();">${duLieu.gmail}</a>`;
    } else {
        phanTuGiaTriZalo.textContent = duLieu.zalo;
        phanTuGiaTriGmail.textContent = duLieu.gmail;
    }

    // CV đính kèm
    const khungChuaCv = document.getElementById('modal-chi-tiet-cv-container');
    if (duLieu.id_cv) {
        khungChuaCv.style.display = 'block';
        document.getElementById('modal-chi-tiet-cv-name').textContent = duLieu.ten_cv || 'Hồ sơ năng lực đính kèm';
        const urlXemCv = window.ROUTES.xemCv.replace('ID_PLACEHOLDER', duLieu.id);
        document.getElementById('modal-chi-tiet-cv-link').href = urlXemCv;
    } else {
        khungChuaCv.style.display = 'none';
    }

    // Thông tin người cung cấp
    const phanNguoiCungCap = document.getElementById('modal-chi-tiet-provider');
    if (!laCuaToi) {
        phanNguoiCungCap.style.display = 'flex';
        document.getElementById('modal-chi-tiet-provider-name').textContent = duLieu.ten_nguoi_dung || 'N/A';
        document.getElementById('modal-chi-tiet-provider-role').textContent = duLieu.chuc_danh_nguoi_dung || 'Thành viên';
        
        // Tạo avatar dạng chữ cái đầu
        const phanTuAvatar = document.getElementById('modal-chi-tiet-provider-avatar');
        if (duLieu.anh_nguoi_dung) {
            phanTuAvatar.innerHTML = `<img src="${window.location.origin}/${duLieu.anh_nguoi_dung}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">`;
        } else {
            let vietTat = 'ND';
            if (duLieu.ten_nguoi_dung) {
                const cacTu = duLieu.ten_nguoi_dung.trim().split(' ');
                if (cacTu.length >= 2) {
                    vietTat = cacTu[cacTu.length-2].substring(0,1) + cacTu[cacTu.length-1].substring(0,1);
                } else {
                    vietTat = duLieu.ten_nguoi_dung.substring(0, 2);
                }
                vietTat = vietTat.toUpperCase();
            }
            phanTuAvatar.innerHTML = `<span id="modal-chi-tiet-provider-init">${vietTat}</span>`;
        }
    } else {
        phanNguoiCungCap.style.display = 'none';
    }

    // Các hành động ở Footer và Trạng thái hiển thị
    const phanTuTrangThai = document.getElementById('modal-chi-tiet-footer-status');
    const hanhDongCuaToi = document.getElementById('modal-chi-tiet-my-actions');
    const hanhDongCongDong = document.getElementById('modal-chi-tiet-comm-actions');
    const phanDichVuKhac = document.getElementById('modal-chi-tiet-provider-services-section');

    if (laCuaToi) {
        hanhDongCuaToi.style.display = 'flex';
        hanhDongCongDong.style.display = 'none';
        if (phanDichVuKhac) phanDichVuKhac.style.display = 'none';
        
        if (duLieu.trang_thai_duyet === 0) {
            phanTuTrangThai.innerHTML = '<span class="approval-badge pending" style="background: rgba(245, 158, 11, 0.1); color: #d97706; font-weight:700; padding: 3px 8px; border-radius: 4px; font-size: 11px;">CHỜ DUYỆT</span> <span style="color:var(--text-secondary); margin-left:6px; font-size:11.5px;">Đang chờ Admin phê duyệt</span>';
        } else if (duLieu.trang_thai_duyet === 2) {
            let lyDoText = duLieu.ly_do_tu_choi ? `<br><span style="color:#ef4444; font-size:12px; font-weight:500;">Lý do: ${duLieu.ly_do_tu_choi}</span>` : '';
            phanTuTrangThai.innerHTML = '<span class="approval-badge rejected" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-weight:700; padding: 3px 8px; border-radius: 4px; font-size: 11px;">BỊ TỪ CHỐI</span>' + lyDoText;
        } else {
            const laDangAn = (duLieu.trang_thai === 0);
            phanTuTrangThai.innerHTML = laDangAn 
                ? '<span class="hidden-badge">Đang ẩn</span> <span style="color:var(--text-secondary); margin-left:6px; font-size:11.5px;">Dịch vụ không hiển thị cộng đồng</span>' 
                : '<span class="category-badge lap_trinh_web" style="background:rgba(16,185,129,0.1); color:#10b981; font-weight:700;">Đang hiển thị</span>';
        }
        
        // Gán sự kiện cho các nút hành động
        document.getElementById('modal-chi-tiet-btn-edit').onclick = function() {
            dongModal('modal-chi-tiet-dich-vu');
            setTimeout(function() { moModalDichVu(duLieu); }, 150);
        };
        
        document.getElementById('modal-chi-tiet-btn-delete').onclick = function() {
            dongModal('modal-chi-tiet-dich-vu');
            setTimeout(function() { xoaDichVu(duLieu.id, duLieu.ten_dich_vu); }, 150);
        };
    } else {
        hanhDongCuaToi.style.display = 'none';
        hanhDongCongDong.style.display = 'flex';
        phanTuTrangThai.innerHTML = '';
        
        document.getElementById('modal-chi-tiet-comm-zalo').href = `https://zalo.me/${sdtZalo}`;
        document.getElementById('modal-chi-tiet-comm-gmail').href = `mailto:${duLieu.gmail}`;

        // Show/Hide button to open all provider services modal
        const btnAllServices = document.getElementById('modal-chi-tiet-btn-all-services');
        if (btnAllServices) {
            btnAllServices.style.display = 'flex';
            btnAllServices.onclick = function() {
                window.currentProviderId = duLieu.id_nguoi_dung;
                window.currentViewingServiceId = duLieu.id;
                
                const avatarEl = document.getElementById('modal-all-services-avatar');
                const titleEl = document.getElementById('modal-all-services-title');
                if (titleEl) {
                    titleEl.textContent = `Toàn bộ dịch vụ của ${duLieu.ten_nguoi_dung || 'người này'}`;
                }
                if (avatarEl) {
                    let initials = 'ND';
                    if (duLieu.ten_nguoi_dung) {
                        const words = duLieu.ten_nguoi_dung.trim().split(' ');
                        if (words.length >= 2) {
                            initials = words[words.length - 2].substring(0, 1) + words[words.length - 1].substring(0, 1);
                        } else {
                            initials = duLieu.ten_nguoi_dung.substring(0, 2);
                        }
                    }
                    avatarEl.innerHTML = `<span id="modal-all-services-init">${initials.toUpperCase()}</span>`;
                }

                // Reset filters on opening
                const pSearch = document.getElementById('modal-provider-search');
                const pCategory = document.getElementById('modal-provider-category');
                const pSort = document.getElementById('modal-provider-sort');
                if (pSearch) pSearch.value = '';
                if (pCategory) pCategory.value = '';
                if (pSort) pSort.value = 'newest';

                window.taiDichVuCuaNguoiDung(duLieu.id_nguoi_dung, 1);
                moModal('modal-provider-all-services');
            };
        }
    }

    // Hide all services button for self-owned services
    if (laCuaToi) {
        const btnAllServices = document.getElementById('modal-chi-tiet-btn-all-services');
        if (btnAllServices) btnAllServices.style.display = 'none';
    }

    moModal('modal-chi-tiet-dich-vu');
};

// ============================================================
// DELETE SERVICE (XÓA DỊCH VỤ)
// ============================================================
window.xoaDichVu = function(id, tenDichVu) {
    if (!id) return;
    
    const name = tenDichVu ? `"${tenDichVu}"` : 'dịch vụ này';
    if (!confirm('Bạn có chắc chắn muốn xóa ' + name + ' này không?')) {
        return;
    }

    const urlXoa = window.ROUTES.xoaDichVu.replace('ID_PLACEHOLDER', id);

    fetch(urlXoa, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json'
        }
    })
    .then(async phanHoi => {
        const duLieu = await phanHoi.json().catch(() => null);
        if (!phanHoi.ok) throw new Error(duLieu && duLieu.thong_bao ? duLieu.thong_bao : 'Lỗi máy chủ (' + phanHoi.status + ')');
        return duLieu;
    })
    .then(duLieu => {
        if (duLieu && duLieu.thanh_cong) {
            hienToast('success', duLieu.thong_bao || 'Xóa dịch vụ thành công!');
            const theDichVu = document.getElementById('card-service-' + id);
            if (theDichVu) {
                theDichVu.style.transition = 'all 0.3s ease';
                theDichVu.style.opacity = '0';
                theDichVu.style.transform = 'scale(0.95)';
                setTimeout(function() { theDichVu.remove(); }, 320);
            }
            setTimeout(function() { window.location.reload(); }, 1200);
        } else {
            hienToast('error', (duLieu && duLieu.thong_bao) || 'Có lỗi xảy ra!');
        }
    })
    .catch(function(loi) {
        console.error('[DichVu] Delete error:', loi);
        hienToast('error', loi.message || 'Lỗi kết nối!');
    });
};

// ============================================================
// CLIENT SIDE SEARCH, SORT & FILTER FOR PERSONAL (TÌM KIẾM CÁ NHÂN)
// ============================================================
function khoiTaoTimKiemCaNhan() {
    const inputTimKiem = document.getElementById('search-personal-service');
    const locPhanLoai = document.getElementById('filter-personal-category');
    const chonSapXep = document.getElementById('sort-personal');
    const khungChua = document.getElementById('personal-services-grid');
    const phanTuKhongKetQua = document.getElementById('no-personal-results');
    const soLuongKetQua = document.getElementById('personal-result-count');
    const khungPhanTrang = document.getElementById('personal-pagination-container');

    if (!khungChua) return;

    let subTabHienTai = 'all';
    const cacNutSubTab = document.querySelectorAll('.sub-tab-btn');
    cacNutSubTab.forEach(nut => {
        nut.addEventListener('click', function () {
            cacNutSubTab.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            subTabHienTai = this.getAttribute('data-sub-tab');
            thucHienLoc(true);
        });
    });

    let trangHienTai = 1;
    const soLuongMoiTrang = 50;

    const thucHienLoc = function (datLaiTrang = true) {
        if (datLaiTrang === true) {
            trangHienTai = 1;
        }

        const tuKhoa = inputTimKiem ? inputTimKiem.value.trim().toLowerCase() : '';
        const phanLoaiDaChon = locPhanLoai ? locPhanLoai.value : '';
        const giaTriSapXep = chonSapXep ? chonSapXep.value : 'newest';
        const tatCaThe = Array.from(khungChua.querySelectorAll('.service-card'));
        
        // Lọc thẻ
        let cacTheDaLoc = tatCaThe.filter(function(theDichVu) {
            const title = (theDichVu.querySelector('.service-title')?.textContent || '').toLowerCase();
            const desc = (theDichVu.querySelector('.service-desc')?.textContent || '').toLowerCase();
            
            const categoryBadge = theDichVu.querySelector('.category-badge');
            let phanLoai = '';
            if (categoryBadge) {
                const classes = categoryBadge.className.split(' ');
                phanLoai = classes.length > 1 ? classes[1] : '';
            }
            
            const trangThai = theDichVu.getAttribute('data-status') || '';
            const trangThaiDuyet = theDichVu.getAttribute('data-approval') || '';

            const khopTuKhoa = !tuKhoa || title.includes(tuKhoa) || desc.includes(tuKhoa);
            const khopPhanLoai = !phanLoaiDaChon || phanLoai === phanLoaiDaChon;
            
            let khopSubTab = true;
            if (subTabHienTai === 'hien-thi') {
                khopSubTab = (trangThaiDuyet === '1' && trangThai === '1');
            } else if (subTabHienTai === 'dang-an') {
                khopSubTab = (trangThaiDuyet === '1' && trangThai === '0');
            } else if (subTabHienTai === 'cho-duyet') {
                khopSubTab = (trangThaiDuyet === '0');
            } else if (subTabHienTai === 'tu-choi') {
                khopSubTab = (trangThaiDuyet === '2');
            }

            return khopTuKhoa && khopPhanLoai && khopSubTab;
        });

        // Sắp xếp các thẻ đã lọc
        cacTheDaLoc.sort(function(a, b) {
            var ngayA = new Date(a.getAttribute('data-date') || 0);
            var ngayB = new Date(b.getAttribute('data-date') || 0);
            return giaTriSapXep === 'oldest' ? ngayA - ngayB : ngayB - ngayA;
        });

        const tongSoPhanTu = cacTheDaLoc.length;
        const tongSoTrang = Math.ceil(tongSoPhanTu / soLuongMoiTrang) || 1;

        if (trangHienTai > tongSoTrang) {
            trangHienTai = tongSoTrang;
        }
        if (trangHienTai < 1) {
            trangHienTai = 1;
        }

        // Ẩn tất cả thẻ trước
        tatCaThe.forEach(function(theDichVu) {
            theDichVu.style.display = 'none';
        });

        // Phân trang và hiển thị trang hiện tại
        const chiSoBatDau = (trangHienTai - 1) * soLuongMoiTrang;
        const chiSoKetThuc = chiSoBatDau + soLuongMoiTrang;
        const cacThePhanTrang = cacTheDaLoc.slice(chiSoBatDau, chiSoKetThuc);

        cacThePhanTrang.forEach(function(theDichVu) {
            theDichVu.style.display = '';
            khungChua.appendChild(theDichVu);
        });

        // Cập nhật số lượng kết quả
        if (soLuongKetQua) soLuongKetQua.textContent = tongSoPhanTu;

        // Trạng thái trống
        if (phanTuKhongKetQua) {
            phanTuKhongKetQua.style.display = tongSoPhanTu === 0 ? 'block' : 'none';
        }

        // Tạo giao diện điều khiển phân trang
        hienThiPhanTrang(tongSoTrang, tongSoPhanTu);
    };

    const hienThiPhanTrang = function (tongSoTrang, tongSoPhanTu) {
        if (!khungPhanTrang) return;

        if (tongSoTrang <= 1) {
            khungPhanTrang.style.display = 'none';
            khungPhanTrang.innerHTML = '';
            return;
        }

        khungPhanTrang.style.display = 'flex';
        
        let html = '';
        
        // Hiển thị thông tin phân trang ở bên trái
        const phanTuBatDau = (trangHienTai - 1) * soLuongMoiTrang + 1;
        const phanTuKetThuc = Math.min(trangHienTai * soLuongMoiTrang, tongSoPhanTu);
        html += `<div style="font-size:13px; color:var(--text-secondary);">Hiển thị ${phanTuBatDau}-${phanTuKetThuc} trong số ${tongSoPhanTu}</div>`;
        
        html += `<ul class="service-pagination">`;
        
        // Nút lùi trang
        const nutTruocVoHieu = trangHienTai === 1 ? 'disabled' : '';
        html += `<li class="service-page-item ${nutTruocVoHieu}">
            <a class="service-page-link" data-page="${trangHienTai - 1}">‹</a>
        </li>`;
        
        // Danh sách các số trang
        const soTrangHienThiToiDa = 5;
        let trangBatDau = Math.max(1, trangHienTai - 2);
        let trangKetThuc = Math.min(tongSoTrang, trangBatDau + soTrangHienThiToiDa - 1);
        if (trangKetThuc - trangBatDau + 1 < soTrangHienThiToiDa) {
            trangBatDau = Math.max(1, trangKetThuc - soTrangHienThiToiDa + 1);
        }

        if (trangBatDau > 1) {
            html += `<li class="service-page-item">
                <a class="service-page-link" data-page="1">1</a>
            </li>`;
            if (trangBatDau > 2) {
                html += `<li class="service-page-item disabled"><span class="service-page-link">...</span></li>`;
            }
        }

        for (let i = trangBatDau; i <= trangKetThuc; i++) {
            const activeClass = i === trangHienTai ? 'active' : '';
            html += `<li class="service-page-item ${activeClass}">
                <a class="service-page-link" data-page="${i}">${i}</a>
            </li>`;
        }

        if (trangKetThuc < tongSoTrang) {
            if (trangKetThuc < tongSoTrang - 1) {
                html += `<li class="service-page-item disabled"><span class="service-page-link">...</span></li>`;
            }
            html += `<li class="service-page-item">
                <a class="service-page-link" data-page="${tongSoTrang}">${tongSoTrang}</a>
            </li>`;
        }
        
        // Nút tiến trang
        const nutSauVoHieu = trangHienTai === tongSoTrang ? 'disabled' : '';
        html += `<li class="service-page-item ${nutSauVoHieu}">
            <a class="service-page-link" data-page="${trangHienTai + 1}">›</a>
        </li>`;
        
        html += `</ul>`;
        
        // Ô nhập trực tiếp chuyển trang
        html += `<div class="service-page-go-to">
            <span>Đi tới trang</span>
            <input type="number" min="1" max="${tongSoTrang}" value="${trangHienTai}" id="personal-go-to-input">
            <button type="button" class="btn-go-to-page" id="btn-personal-go-to">Đi</button>
        </div>`;
        
        khungPhanTrang.innerHTML = html;

        // Bắt sự kiện click các liên kết trang
        khungPhanTrang.querySelectorAll('.service-page-link[data-page]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (page >= 1 && page <= tongSoTrang && page !== trangHienTai) {
                    trangHienTai = page;
                    thucHienLoc(false);
                }
            });
        });

        // Bắt sự kiện nút Đi tới
        const goBtn = document.getElementById('btn-personal-go-to');
        const goInput = document.getElementById('personal-go-to-input');
        if (goBtn && goInput) {
            const thucHienDiChuyen = function() {
                const val = parseInt(goInput.value);
                if (val >= 1 && val <= tongSoTrang && val !== trangHienTai) {
                    trangHienTai = val;
                    thucHienLoc(false);
                } else if (val < 1 || val > tongSoTrang) {
                    hienToast('error', 'Trang không hợp lệ. Vui lòng nhập số từ 1 đến ' + tongSoTrang);
                }
            };
            goBtn.addEventListener('click', thucHienDiChuyen);
            goInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    thucHienDiChuyen();
                }
            });
        }
    };

    if (inputTimKiem) inputTimKiem.addEventListener('input', function() { thucHienLoc(true); });
    if (locPhanLoai) locPhanLoai.addEventListener('change', function() { thucHienLoc(true); });
    if (chonSapXep) chonSapXep.addEventListener('change', function() { thucHienLoc(true); });

    const nutDatLai = document.getElementById('btn-reset-personal-filters');
    if (nutDatLai) {
        nutDatLai.addEventListener('click', function() {
            if (inputTimKiem) inputTimKiem.value = '';
            if (locPhanLoai) locPhanLoai.value = '';
            if (chonSapXep) chonSapXep.value = 'newest';
            subTabHienTai = 'all';
            cacNutSubTab.forEach(btn => btn.classList.remove('active'));
            if (cacNutSubTab[0]) cacNutSubTab[0].classList.add('active');
            thucHienLoc(true);
        });
    }

    // Chạy bộ lọc ban đầu
    thucHienLoc(true);
}

// ============================================================
// CLIENT SIDE SEARCH, SORT & FILTER FOR COMMUNITY (TÌM KIẾM CỘNG ĐỒNG)
// ============================================================
function khoiTaoTimKiemCongDong() {
    const inputTimKiem = document.getElementById('search-community-service');
    const locPhanLoai = document.getElementById('filter-community-category');
    const chonSapXep = document.getElementById('sort-community');
    const khungChua = document.getElementById('community-services-container');
    const phanTuKhongKetQua = document.getElementById('no-community-results');
    const soLuongKetQua = document.getElementById('community-result-count');
    const khungPhanTrang = document.getElementById('community-pagination-container');

    if (!khungChua) return;

    let trangHienTai = 1;
    const soLuongMoiTrang = 50;

    const thucHienLoc = function (datLaiTrang = true) {
        if (datLaiTrang === true) {
            trangHienTai = 1;
        }

        const tuKhoa = inputTimKiem ? inputTimKiem.value.trim().toLowerCase() : '';
        const phanLoaiDaChon = locPhanLoai ? locPhanLoai.value : '';
        const giaTriSapXep = chonSapXep ? chonSapXep.value : 'newest';
        const tatCaThe = Array.from(khungChua.querySelectorAll('.community-card'));

        // Lọc thẻ
        let cacTheDaLoc = tatCaThe.filter(function(theDichVu) {
            const title = theDichVu.getAttribute('data-service-title') || '';
            const name = theDichVu.getAttribute('data-provider-name') || '';
            const desc = theDichVu.getAttribute('data-desc') || '';
            const phanLoai = theDichVu.getAttribute('data-category') || '';

            const khopTuKhoa = !tuKhoa || title.includes(tuKhoa) || name.includes(tuKhoa) || desc.includes(tuKhoa);
            const khopPhanLoai = !phanLoaiDaChon || phanLoai === phanLoaiDaChon;

            return khopTuKhoa && khopPhanLoai;
        });

        // Sắp xếp các thẻ đã lọc
        cacTheDaLoc.sort(function(a, b) {
            var ngayA = new Date(a.getAttribute('data-date') || 0);
            var ngayB = new Date(b.getAttribute('data-date') || 0);
            return giaTriSapXep === 'oldest' ? ngayA - ngayB : ngayB - ngayA;
        });

        const tongSoPhanTu = cacTheDaLoc.length;
        const tongSoTrang = Math.ceil(tongSoPhanTu / soLuongMoiTrang) || 1;

        if (trangHienTai > tongSoTrang) {
            trangHienTai = tongSoTrang;
        }
        if (trangHienTai < 1) {
            trangHienTai = 1;
        }

        // Ẩn tất cả thẻ trước
        tatCaThe.forEach(function(theDichVu) {
            theDichVu.style.display = 'none';
        });

        // Phân trang và hiển thị trang hiện tại
        const chiSoBatDau = (trangHienTai - 1) * soLuongMoiTrang;
        const chiSoKetThuc = chiSoBatDau + soLuongMoiTrang;
        const cacThePhanTrang = cacTheDaLoc.slice(chiSoBatDau, chiSoKetThuc);

        cacThePhanTrang.forEach(function(theDichVu) {
            theDichVu.style.display = '';
            khungChua.appendChild(theDichVu);
        });

        // Cập nhật số lượng kết quả
        if (soLuongKetQua) soLuongKetQua.textContent = tongSoPhanTu;

        // Trạng thái trống
        if (phanTuKhongKetQua) {
            phanTuKhongKetQua.style.display = tongSoPhanTu === 0 ? 'block' : 'none';
        }

        // Tạo giao diện điều khiển phân trang
        hienThiPhanTrang(tongSoTrang, tongSoPhanTu);
    };

    const hienThiPhanTrang = function (tongSoTrang, tongSoPhanTu) {
        if (!khungPhanTrang) return;

        if (tongSoTrang <= 1) {
            khungPhanTrang.style.display = 'none';
            khungPhanTrang.innerHTML = '';
            return;
        }

        khungPhanTrang.style.display = 'flex';
        
        let html = '';
        
        // Hiển thị thông tin phân trang ở bên trái
        const phanTuBatDau = (trangHienTai - 1) * soLuongMoiTrang + 1;
        const phanTuKetThuc = Math.min(trangHienTai * soLuongMoiTrang, tongSoPhanTu);
        html += `<div style="font-size:13px; color:var(--text-secondary);">Hiển thị ${phanTuBatDau}-${phanTuKetThuc} trong số ${tongSoPhanTu}</div>`;
        
        html += `<ul class="service-pagination">`;
        
        // Nút lùi trang
        const nutTruocVoHieu = trangHienTai === 1 ? 'disabled' : '';
        html += `<li class="service-page-item ${nutTruocVoHieu}">
            <a class="service-page-link" data-page="${trangHienTai - 1}">‹</a>
        </li>`;
        
        // Danh sách các số trang
        const soTrangHienThiToiDa = 5;
        let trangBatDau = Math.max(1, trangHienTai - 2);
        let trangKetThuc = Math.min(tongSoTrang, trangBatDau + soTrangHienThiToiDa - 1);
        if (trangKetThuc - trangBatDau + 1 < soTrangHienThiToiDa) {
            trangBatDau = Math.max(1, trangKetThuc - soTrangHienThiToiDa + 1);
        }

        if (trangBatDau > 1) {
            html += `<li class="service-page-item">
                <a class="service-page-link" data-page="1">1</a>
            </li>`;
            if (trangBatDau > 2) {
                html += `<li class="service-page-item disabled"><span class="service-page-link">...</span></li>`;
            }
        }

        for (let i = trangBatDau; i <= trangKetThuc; i++) {
            const activeClass = i === trangHienTai ? 'active' : '';
            html += `<li class="service-page-item ${activeClass}">
                <a class="service-page-link" data-page="${i}">${i}</a>
            </li>`;
        }

        if (trangKetThuc < tongSoTrang) {
            if (trangKetThuc < tongSoTrang - 1) {
                html += `<li class="service-page-item disabled"><span class="service-page-link">...</span></li>`;
            }
            html += `<li class="service-page-item">
                <a class="service-page-link" data-page="${tongSoTrang}">${tongSoTrang}</a>
            </li>`;
        }
        
        // Nút tiến trang
        const nutSauVoHieu = trangHienTai === tongSoTrang ? 'disabled' : '';
        html += `<li class="service-page-item ${nutSauVoHieu}">
            <a class="service-page-link" data-page="${trangHienTai + 1}">›</a>
        </li>`;
        
        html += `</ul>`;
        
        // Ô nhập trực tiếp chuyển trang
        html += `<div class="service-page-go-to">
            <span>Đi tới trang</span>
            <input type="number" min="1" max="${tongSoTrang}" value="${trangHienTai}" id="community-go-to-input">
            <button type="button" class="btn-go-to-page" id="btn-community-go-to">Đi</button>
        </div>`;
        
        khungPhanTrang.innerHTML = html;

        // Bắt sự kiện click các liên kết trang
        khungPhanTrang.querySelectorAll('.service-page-link[data-page]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (page >= 1 && page <= tongSoTrang && page !== trangHienTai) {
                    trangHienTai = page;
                    thucHienLoc(false);
                }
            });
        });

        // Bắt sự kiện nút Đi tới
        const goBtn = document.getElementById('btn-community-go-to');
        const goInput = document.getElementById('community-go-to-input');
        if (goBtn && goInput) {
            const thucHienDiChuyen = function() {
                const val = parseInt(goInput.value);
                if (val >= 1 && val <= tongSoTrang && val !== trangHienTai) {
                    trangHienTai = val;
                    thucHienLoc(false);
                } else if (val < 1 || val > tongSoTrang) {
                    hienToast('error', 'Trang không hợp lệ. Vui lòng nhập số từ 1 đến ' + tongSoTrang);
                }
            };
            goBtn.addEventListener('click', thucHienDiChuyen);
            goInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    thucHienDiChuyen();
                }
            });
        }
    };

    if (inputTimKiem) inputTimKiem.addEventListener('input', function() { thucHienLoc(true); });
    if (locPhanLoai) locPhanLoai.addEventListener('change', function() { thucHienLoc(true); });
    if (chonSapXep) chonSapXep.addEventListener('change', function() { thucHienLoc(true); });

    const nutDatLai = document.getElementById('btn-reset-community-filters');
    if (nutDatLai) {
        nutDatLai.addEventListener('click', function() {
            if (inputTimKiem) inputTimKiem.value = '';
            if (locPhanLoai) locPhanLoai.value = '';
            if (chonSapXep) chonSapXep.value = 'newest';
            thucHienLoc(true);
        });
    }

    // Chạy bộ lọc ban đầu
    thucHienLoc(true);
}

// ============================================================
// TOGGLE VISIBILITY (THAY ĐỔI TRẠNG THÁI ẨN/HIỆN CỘNG ĐỒNG)
// ============================================================
window.doiTrangThaiDichVu = function(id) {
    var nut = document.getElementById('toggle-btn-' + id);
    if (!nut) return;

    var noiDungGoc = nut.innerHTML;
    nut.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;animation:spin 0.7s linear infinite;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
    nut.disabled = true;

    var urlTrangThai = window.ROUTES.doiTrangThaiDichVu.replace('ID_PLACEHOLDER', id);

    fetch(urlTrangThai, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json'
        }
    })
    .then(function(phanHoi) { return phanHoi.json(); })
    .then(function(duLieu) {
        if (duLieu && duLieu.thanh_cong) {
            hienToast('success', duLieu.thong_bao);
            var theDichVu = document.getElementById('card-service-' + id);
            var gioDaAn = (duLieu.trang_thai === 0);

            if (theDichVu) {
                if (gioDaAn) {
                    theDichVu.classList.add('is-hidden');
                } else {
                    theDichVu.classList.remove('is-hidden');
                }
                // Cập nhật nhãn Đang ẩn
                var nhan = theDichVu.querySelector('.hidden-badge');
                if (nhan) nhan.style.display = gioDaAn ? '' : 'none';
            }

            // Cập nhật nút bật/tắt
            if (gioDaAn) {
                nut.classList.remove('eye-on');
                nut.classList.add('eye-off');
                nut.title = 'Đang ẩn — Click để hiển thị cộng đồng';
                nut.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>';
            } else {
                nut.classList.remove('eye-off');
                nut.classList.add('eye-on');
                nut.title = 'Đang hiển thị cộng đồng — Click để ẩn';
                nut.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
            }
        } else {
            hienToast('error', (duLieu && duLieu.thong_bao) || 'Có lỗi xảy ra!');
            nut.innerHTML = noiDungGoc;
        }
    })
    .catch(function(loi) {
        console.error('[DichVu] Toggle error:', loi);
        hienToast('error', 'Lỗi kết nối!');
        nut.innerHTML = noiDungGoc;
        nut.disabled = false;
    });
};

// Reset trạng thái disabled sau khi bấm
document.addEventListener('click', function(e) {
    if (e.target && e.target.id && e.target.id.startsWith('toggle-btn-')) {
        setTimeout(function() { e.target.disabled = false; }, 3000);
    }
});

// ============================================================
// MODAL DYNAMIC OTHER SERVICES BY PROVIDER
// ============================================================
window.currentProviderId = null;
window.currentViewingServiceId = null;

window.taiDichVuCuaNguoiDung = function(userId, page) {
    if (!userId) return;
    
    page = page || 1;
    const pSearch = document.getElementById('modal-provider-search');
    const pCategory = document.getElementById('modal-provider-category');
    const pSort = document.getElementById('modal-provider-sort');
    
    const tuKhoa = pSearch ? pSearch.value.trim() : '';
    const linhVuc = pCategory ? pCategory.value : '';
    const sapXep = pSort ? pSort.value : 'newest';

    // Show or hide clear button based on filters status
    const clearBtn = document.getElementById('modal-provider-clear-btn');
    if (clearBtn) {
        if (tuKhoa !== '' || linhVuc !== '') {
            clearBtn.style.display = 'inline-flex';
        } else {
            clearBtn.style.display = 'none';
        }
    }
    
    const listContainer = document.getElementById('modal-provider-services-list');
    const paginationContainer = document.getElementById('modal-provider-services-pagination');
    
    if (!listContainer) return;
    
    listContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #94a3b8;"><span class="spinner" style="display: inline-block; width: 16px; height: 16px; border: 2px solid #e2e8f0; border-top-color: #3b82f6; border-radius: 50%; animation: spin 1s linear infinite;"></span> Đang tải dịch vụ...</div>';
    if (paginationContainer) paginationContainer.innerHTML = '';
    
    let url = `/ho-so/dich-vu/user/${userId}?page=${page}&sap_xep=${sapXep}`;
    if (tuKhoa) url += `&tu_khoa=${encodeURIComponent(tuKhoa)}`;
    if (linhVuc) url += `&linh_vuc=${encodeURIComponent(linhVuc)}`;
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        if (!res.thanh_cong) {
            listContainer.innerHTML = '<div style="color: #ef4444; padding: 10px; text-align: center;">Có lỗi xảy ra khi tải dữ liệu!</div>';
            return;
        }
        
        const dichVuList = res.dich_vu || [];
        const paging = res.dieu_huong || {};

        // Cập nhật phụ đề hiển thị số lượng dịch vụ
        const subtitleEl = document.getElementById('modal-all-services-subtitle');
        if (subtitleEl) {
            subtitleEl.textContent = `Tìm thấy tất cả ${paging.total || 0} dịch vụ đã duyệt`;
        }
        
        if (dichVuList.length === 0) {
            listContainer.innerHTML = '<div style="color: #94a3b8; text-align: center; padding: 20px; font-style: italic; font-size: 13px;">Không tìm thấy dịch vụ nào.</div>';
            return;
        }
        
        const catMap = {
            'lap_trinh_web': 'Lập trình Web',
            'toi_uu_sql': 'Tối ưu SQL/Database',
            'thiet_ke_uiux': 'Thiết kế UI/UX',
            'lap_trinh_mobile': 'Lập trình Mobile',
            'devops_cloud': 'DevOps & Cloud',
            'kiem_thu': 'Kiểm thử phần mềm',
            'an_ninh_mang': 'An ninh mạng / Bảo mật',
            'phan_tich_du_lieu': 'Phân tích dữ liệu (Data Analysis)',
            'tri_tue_nhan_tao': 'Trí tuệ nhân tạo (AI/Machine Learning)',
            'viet_lach_content': 'Viết lách / Biên dịch content',
            'quan_tri_du_an': 'Quản trị dự án (Project Management)',
            'khac': 'Lĩnh vực khác'
        };
        
        let html = '';
        dichVuList.forEach(item => {
            const isCurrent = item.id === window.currentViewingServiceId;
            const cardStyle = isCurrent 
                ? 'border: 2px solid var(--accent-blue); background: #f0f7ff; cursor: default;' 
                : 'border: 1px solid #e2e8f0; background: #ffffff; cursor: pointer;';
            const hoverClass = isCurrent ? '' : 'service-card-mini-hover';
            
            // Format date
            let dateStr = 'N/A';
            if (item.ngay_cap_nhat) {
                const d = new Date(item.ngay_cap_nhat);
                const pad = (n) => n.toString().padStart(2, '0');
                dateStr = `${pad(d.getHours())}:${pad(d.getMinutes())} ${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()}`;
            }
            
            html += `
                <div class="service-card-mini ${hoverClass}" style="${cardStyle} padding: 12px; border-radius: 8px; transition: all 0.2s ease;" 
                     onclick="${isCurrent ? 'event.stopPropagation();' : `event.stopPropagation(); window.switchViewingService(${JSON.stringify(item).replace(/"/g, '&quot;')})`}">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                        <h5 style="margin: 0; font-size: 13.5px; font-weight: 700; color: var(--text-primary); line-height: 1.4;">${item.ten_dich_vu}</h5>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            ${isCurrent ? '<span style="background: var(--accent-blue); color: #ffffff; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 700; text-transform: uppercase;">Đang xem</span>' : ''}
                            <span class="category-badge ${item.phan_loai}" style="font-size: 10px; padding: 2px 6px; border-radius: 4px; font-weight: 600; white-space: nowrap;">${catMap[item.phan_loai] || 'Khác'}</span>
                        </div>
                    </div>
                    <p style="margin: 6px 0 0 0; font-size: 12px; color: var(--text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: pre-line;">${item.mo_ta}</p>
                    <div style="margin-top: 8px; display: flex; justify-content: space-between; align-items: center; font-size: 10.5px; color: #94a3b8;">
                        <span>Cập nhật: ${dateStr}</span>
                        ${isCurrent ? '' : '<span style="color: var(--accent-blue); font-weight: 600; font-size: 11px;">Xem chi tiết &rarr;</span>'}
                    </div>
                </div>
            `;
        });
        listContainer.innerHTML = html;
        
        // Render pagination
        if (paging.last_page > 1 && paginationContainer) {
            let pagHtml = '';
            for (let i = 1; i <= paging.last_page; i++) {
                const isCurrentPage = i === paging.current_page;
                const btnStyle = isCurrentPage
                    ? 'background: var(--accent-blue); color: #ffffff; border-color: var(--accent-blue); font-weight: 700;'
                    : 'background: #ffffff; color: var(--text-secondary); border-color: #cbd5e1;';
                pagHtml += `<button type="button" onclick="window.taiDichVuCuaNguoiDung(${userId}, ${i})" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 11.5px; border: 1px solid; border-radius: 6px; cursor: pointer; transition: all 0.15s ease; ${btnStyle}">${i}</button>`;
            }
            paginationContainer.innerHTML = pagHtml;
        }
    })
    .catch(err => {
        console.error(err);
        listContainer.innerHTML = '<div style="color: #ef4444; padding: 10px; text-align: center;">Lỗi kết nối mạng!</div>';
    });
};

window.switchViewingService = function(newService) {
    // Close the list modal first
    dongModal('modal-provider-all-services');
    
    // Open the new service detail modal after a small delay
    setTimeout(function() {
        window.moModalChiTietDichVu(newService, false);
    }, 200);
};

// Bind modal provider service filters
document.addEventListener('DOMContentLoaded', function () {
    const modalFilterBtn = document.getElementById('modal-provider-filter-btn');
    if (modalFilterBtn) {
        modalFilterBtn.addEventListener('click', function() {
            if (window.currentProviderId) {
                window.taiDichVuCuaNguoiDung(window.currentProviderId, 1);
            }
        });
    }
    const modalSearchInput = document.getElementById('modal-provider-search');
    if (modalSearchInput) {
        modalSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && window.currentProviderId) {
                window.taiDichVuCuaNguoiDung(window.currentProviderId, 1);
            }
        });
    }
    const modalClearBtn = document.getElementById('modal-provider-clear-btn');
    if (modalClearBtn) {
        modalClearBtn.addEventListener('click', function() {
            const pSearch = document.getElementById('modal-provider-search');
            const pCategory = document.getElementById('modal-provider-category');
            const pSort = document.getElementById('modal-provider-sort');
            if (pSearch) pSearch.value = '';
            if (pCategory) pCategory.value = '';
            if (pSort) pSort.value = 'newest';
            
            if (window.currentProviderId) {
                window.taiDichVuCuaNguoiDung(window.currentProviderId, 1);
            }
        });
    }
});
