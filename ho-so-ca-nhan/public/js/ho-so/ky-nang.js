/**
 * ky-nang.js
 * JavaScript cho modal chỉnh sửa kỹ năng chuyên môn
 * Chip multi-select với tìm kiếm real-time
 */

/* KHỞI TẠO MODULE KỸ NĂNG */
document.addEventListener('DOMContentLoaded', function () {
    khoiTaoChipNgonNgu();
    khoiTaoChipKyNang();
    khoiTaoFormKyNang();

    // Sắp xếp ban đầu khi tải trang
    sapXepChips(document.getElementById('chips-ngon-ngu'));
    sapXepChips(document.getElementById('chips-ky-nang'));

    // Nút mở modal kỹ năng
    const btnMoKyNang = document.getElementById('btn-mo-modal-ky-nang');
    if (btnMoKyNang) {
        btnMoKyNang.addEventListener('click', () => moModal('modal-ky-nang'));
    }
});

/* HÀM SẮP XẾP CHIPS: Nổi bật lên đầu, sau đó đến Đã chọn, cuối cùng là Chưa chọn */
function sapXepChips(container) {
    if (!container) return;
    const chips = Array.from(container.querySelectorAll('.skill-chip'));
    chips.sort((a, b) => {
        const aFeatured = a.classList.contains('featured') ? 1 : 0;
        const bFeatured = b.classList.contains('featured') ? 1 : 0;
        if (aFeatured !== bFeatured) {
            return bFeatured - aFeatured;
        }
        const aSelected = a.classList.contains('selected') ? 1 : 0;
        const bSelected = b.classList.contains('selected') ? 1 : 0;
        if (aSelected !== bSelected) {
            return bSelected - aSelected;
        }
        return 0; // Giữ nguyên thứ tự ban đầu
    });
    // Thêm lại các phần tử đã sắp xếp vào container
    chips.forEach(chip => container.appendChild(chip));
}

/* CHIP NGÔN NGỮ LẬP TRÌNH */
function khoiTaoChipNgonNgu() {
    const searchInput  = document.getElementById('search-ngon-ngu');
    const container    = document.getElementById('chips-ngon-ngu');
    const countBadge   = document.getElementById('count-ngon-ngu');
    if (!container) return;

    const chips = container.querySelectorAll('.skill-chip');

    // Tìm kiếm filter
    searchInput && searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        chips.forEach(chip => {
            const ten = chip.textContent.toLowerCase();
            chip.style.display = ten.includes(query) ? '' : 'none';
        });
    });

    // Toggle chip khi click
    chips.forEach(chip => {
        chip.addEventListener('click', function (e) {
            if (e.target.closest('.skill-chip-star-wrapper')) {
                return;
            }
            this.classList.toggle('selected');
            if (!this.classList.contains('selected')) {
                this.classList.remove('featured');
                const starSvg = this.querySelector('.skill-chip-star');
                if (starSvg) {
                    starSvg.setAttribute('fill', 'none');
                }
            }
            capNhatSoLuong(container, countBadge);
            sapXepChips(container);
        });
    });

    // Khởi tạo đếm ban đầu
    capNhatSoLuong(container, countBadge);
}

/* CHIP KỸ NĂNG MỀM */
function khoiTaoChipKyNang() {
    const searchInput  = document.getElementById('search-ky-nang');
    const container    = document.getElementById('chips-ky-nang');
    const countBadge   = document.getElementById('count-ky-nang');
    if (!container) return;

    const chips = container.querySelectorAll('.skill-chip');

    // Tìm kiếm filter
    searchInput && searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        chips.forEach(chip => {
            const ten = chip.textContent.toLowerCase();
            chip.style.display = ten.includes(query) ? '' : 'none';
        });
    });

    // Toggle chip khi click
    chips.forEach(chip => {
        chip.addEventListener('click', function (e) {
            if (e.target.closest('.skill-chip-star-wrapper')) {
                return;
            }
            this.classList.toggle('selected');
            if (!this.classList.contains('selected')) {
                this.classList.remove('featured');
                const starSvg = this.querySelector('.skill-chip-star');
                if (starSvg) {
                    starSvg.setAttribute('fill', 'none');
                }
            }
            capNhatSoLuong(container, countBadge);
            sapXepChips(container);
        });
    });

    // Khởi tạo đếm ban đầu
    capNhatSoLuong(container, countBadge);
}

/* CẬP NHẬT SỐ LƯỢNG BADGE */
function capNhatSoLuong(container, badge) {
    if (!badge) return;
    const selected = container.querySelectorAll('.skill-chip.selected').length;
    badge.textContent = selected;
    badge.style.display = selected > 0 ? 'inline-flex' : 'none';
}

/* LẤY IDs ĐÃ CHỌN & NỔI BẬT */
function layIdsChon(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return [];
    return Array.from(container.querySelectorAll('.skill-chip.selected'))
        .map(chip => parseInt(chip.dataset.id))
        .filter(id => !isNaN(id));
}

function layIdsFeatured(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return [];
    return Array.from(container.querySelectorAll('.skill-chip.selected.featured'))
        .map(chip => parseInt(chip.dataset.id))
        .filter(id => !isNaN(id));
}

/* TOGGLE KỸ NĂNG NỔI BẬT (GẮN SAO) */
window.toggleFeaturedSkill = function (e, wrapper) {
    e.stopPropagation();
    const chip = wrapper.closest('.skill-chip');
    if (!chip || !chip.classList.contains('selected')) return;

    const container = chip.closest('.skill-chips-container');
    const isNgonNgu = container.id === 'chips-ngon-ngu';
    const starSvg = wrapper.querySelector('.skill-chip-star');
    const isCurrentlyFeatured = chip.classList.contains('featured');

    if (!isCurrentlyFeatured) {
        const featuredCount = container.querySelectorAll('.skill-chip.selected.featured').length;
        if (featuredCount >= 5) {
            const typeText = isNgonNgu ? 'ngôn ngữ lập trình' : 'kỹ năng mềm';
            hienToast('error', `Chỉ được chọn tối đa 5 ${typeText} nổi bật.`);
            return;
        }
        chip.classList.add('featured');
        if (starSvg) {
            starSvg.setAttribute('fill', 'currentColor');
        }
    } else {
        chip.classList.remove('featured');
        if (starSvg) {
            starSvg.setAttribute('fill', 'none');
        }
    }

    // Sắp xếp lại danh sách đưa nổi bật lên đầu
    sapXepChips(container);
};

/* FORM KỸ NĂNG: LƯU */
function khoiTaoFormKyNang() {
    const btnSave = document.getElementById('btn-luu-ky-nang');
    if (!btnSave) return;

    btnSave.addEventListener('click', function () {
        luuKyNang(this);
    });
}

function luuKyNang(btn) {
    const ngonNguIds = layIdsChon('chips-ngon-ngu');
    const kyNangIds  = layIdsChon('chips-ky-nang');
    const ngonNguNoiBatIds = layIdsFeatured('chips-ngon-ngu');
    const kyNangNoiBatIds  = layIdsFeatured('chips-ky-nang');

    if (ngonNguIds.length > 20) {
        hienToast('error', 'Số lượng ngôn ngữ lập trình không được vượt quá 20.');
        return;
    }
    if (kyNangIds.length > 20) {
        hienToast('error', 'Số lượng kỹ năng mềm không được vượt quá 20.');
        return;
    }
    if (ngonNguNoiBatIds.length > 5) {
        hienToast('error', 'Số lượng ngôn ngữ nổi bật không được vượt quá 5.');
        return;
    }
    if (kyNangNoiBatIds.length > 5) {
        hienToast('error', 'Số lượng kỹ năng mềm nổi bật không được vượt quá 5.');
        return;
    }

    datTrangThaiLoading(btn, true);

    fetch(window.ROUTES.capNhatKyNang, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            ngon_ngu_ids: ngonNguIds,
            ngon_ngu_noi_bat_ids: ngonNguNoiBatIds,
            ky_nang_ids:  kyNangIds,
            ky_nang_noi_bat_ids: kyNangNoiBatIds,
        }),
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
                hienToast('success', result.thong_bao || 'Cập nhật kỹ năng thành công!');
                setTimeout(() => window.location.reload(), 800);
            } else {
                hienToast('error', (result && result.thong_bao) || 'Có lỗi xảy ra!');
            }
        })
        .catch((err) => {
            console.error('[HoSo] Fetch error:', err);
            hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
        })
        .finally(() => datTrangThaiLoading(btn, false));
}

/* HELPER: Sử dụng lại từ chinh-sua.js
   (các hàm này đã được định nghĩa trong chinh-sua.js) */

// Fallback nếu chinh-sua.js chưa load
if (typeof moModal === 'undefined') {
    window.moModal = function (id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };
}

if (typeof dongModal === 'undefined') {
    window.dongModal = function (id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('active');
            document.body.style.overflow = '';
        }
    };
}

if (typeof hienToast === 'undefined') {
    window.hienToast = function (loai, msg) { alert(msg); };
}

if (typeof datTrangThaiLoading === 'undefined') {
    window.datTrangThaiLoading = function (btn, loading) {
        btn.disabled = loading;
    };
}

if (typeof layToken === 'undefined') {
    window.layToken = function () {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };
}
