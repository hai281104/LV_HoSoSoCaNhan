/**
 * lien-ket.js
 * JavaScript cho quản lý liên kết chuyên môn (MXH)
 * Thêm / xóa link rows, lưu qua AJAX
 */

/* DANH SÁCH NỀN TẢNG HỖ TRỢ */
const NEN_TANG = [
    { value: 'Facebook',   label: 'Facebook',   placeholder: 'https://facebook.com/username' },
    { value: 'GitHub',     label: 'GitHub',      placeholder: 'https://github.com/username' },
    { value: 'LinkedIn',   label: 'LinkedIn',    placeholder: 'https://linkedin.com/in/username' },
    { value: 'Twitter/X',  label: 'Twitter / X', placeholder: 'https://x.com/username' },
    { value: 'Instagram',  label: 'Instagram',   placeholder: 'https://instagram.com/username' },
    { value: 'YouTube',    label: 'YouTube',     placeholder: 'https://youtube.com/@channel' },
    { value: 'TikTok',     label: 'TikTok',      placeholder: 'https://tiktok.com/@username' },
    { value: 'Portfolio',  label: 'Portfolio',   placeholder: 'https://myportfolio.com' },
    { value: 'Khác',       label: 'Khác',        placeholder: 'https://...' },
];

/* KHỞI TẠO */
document.addEventListener('DOMContentLoaded', function () {
    khoiTaoFormLienKet();
    khoiTaoBtnThem();
    khoiTaoNutLuu();
});

/* KHỞI TẠO FORM LIÊN KẾT */
function khoiTaoFormLienKet() {
    // Gắn sự kiện xoá cho các row đã có sẵn (từ server-side render)
    document.querySelectorAll('.link-row').forEach(row => {
        ganSuKienXoaRow(row);
        ganSuKienChonNenTang(row);
    });
}

/* NÚT THÊM LIÊN KẾT MỚI */
function khoiTaoBtnThem() {
    const btnThem = document.getElementById('btn-them-lien-ket');
    if (!btnThem) return;

    btnThem.addEventListener('click', function () {
        const container = document.getElementById('link-rows-container');
        if (!container) return;

        const soRow = container.querySelectorAll('.link-row').length;

        if (soRow >= 10) {
            hienToast('error', 'Tối đa 10 liên kết!');
            return;
        }

        const row = taoLinkRow(soRow);
        container.appendChild(row);
        ganSuKienXoaRow(row);
        ganSuKienChonNenTang(row);

        // Animate
        row.style.opacity = '0';
        row.style.transform = 'translateY(-8px)';
        requestAnimationFrame(() => {
            row.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        });

        // Focus vào input URL mới
        setTimeout(() => row.querySelector('.link-url-input')?.focus(), 50);
    });
}

/* TẠO ROW LIÊN KẾT MỚI */
function taoLinkRow(index) {
    const optionsHtml = NEN_TANG.map(nt =>
        `<option value="${nt.value}">${nt.label}</option>`
    ).join('');

    const row = document.createElement('div');
    row.className = 'link-row';
    row.innerHTML = `
        <select class="form-select link-platform-select" name="lien_ket[${index}][ten_nen_tang]">
            ${optionsHtml}
        </select>
        <input
            type="url"
            class="form-input link-url-input"
            name="lien_ket[${index}][duong_dan]"
            placeholder="https://facebook.com/username"
            autocomplete="off"
        >
        <button type="button" class="btn-remove-link" title="Xóa liên kết">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    return row;
}

/* GẮN SỰ KIỆN XÓA ROW */
function ganSuKienXoaRow(row) {
    const btnXoa = row.querySelector('.btn-remove-link');
    if (!btnXoa) return;

    btnXoa.addEventListener('click', function () {
        row.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-8px)';
        setTimeout(() => {
            row.remove();
            capNhatIndexRows();
        }, 200);
    });
}

/* GẮN SỰ KIỆN CHỌN NỀN TẢNG (cập nhật placeholder URL) */
function ganSuKienChonNenTang(row) {
    const select    = row.querySelector('.link-platform-select');
    const urlInput  = row.querySelector('.link-url-input');
    if (!select || !urlInput) return;

    select.addEventListener('change', function () {
        const found = NEN_TANG.find(nt => nt.value === this.value);
        if (found) {
            urlInput.placeholder = found.placeholder;
        }
    });
}

/* CẬP NHẬT INDEX CÁC ROW (sau khi xóa) */
function capNhatIndexRows() {
    const rows = document.querySelectorAll('#link-rows-container .link-row');
    rows.forEach((row, i) => {
        const select   = row.querySelector('.link-platform-select');
        const urlInput = row.querySelector('.link-url-input');
        if (select)   select.name   = `lien_ket[${i}][ten_nen_tang]`;
        if (urlInput) urlInput.name = `lien_ket[${i}][duong_dan]`;
    });
}

/* NÚT LƯU LIÊN KẾT */
function khoiTaoNutLuu() {
    const btnLuu = document.getElementById('btn-luu-lien-ket');
    if (!btnLuu) return;

    btnLuu.addEventListener('click', function () {
        luuLienKet(this);
    });
}

function luuLienKet(btn) {
    const rows = document.querySelectorAll('#link-rows-container .link-row');
    const danhSach = [];
    let coLoi = false;

    rows.forEach((row, i) => {
        const tenNenTang = row.querySelector('.link-platform-select')?.value || '';
        const duongDan   = row.querySelector('.link-url-input')?.value?.trim() || '';

        if (!duongDan) return; // Bỏ qua row trống

        // Validate URL cơ bản
        try {
            new URL(duongDan);
        } catch {
            hienToast('error', `Liên kết #${i + 1} không hợp lệ! Vui lòng nhập URL đầy đủ (bao gồm https://).`);
            coLoi = true;
            return;
        }

        danhSach.push({ ten_nen_tang: tenNenTang, duong_dan: duongDan });
    });

    if (coLoi) return;

    datTrangThaiLoading(btn, true);

    fetch(window.ROUTES.capNhatLienKet, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': layToken(),
            'Accept': 'application/json',
        },
        body: JSON.stringify({ lien_ket: danhSach }),
    })
        .then(res => res.json())
        .then(result => {
            if (result.thanh_cong) {
                hienToast('success', result.thong_bao || 'Cập nhật liên kết thành công!');
                // Reload trang để cập nhật danh sách liên kết
                setTimeout(() => window.location.reload(), 800);
            } else {
                const errors = result.errors
                    ? Object.values(result.errors).flat().join(', ')
                    : result.thong_bao;
                hienToast('error', errors || 'Có lỗi xảy ra!');
            }
        })
        .catch(() => hienToast('error', 'Lỗi kết nối! Vui lòng thử lại.'))
        .finally(() => datTrangThaiLoading(btn, false));
}

/* HELPER FALLBACKS (nếu chinh-sua.js chưa load) */
if (typeof hienToast === 'undefined') {
    window.hienToast = function (type, msg) { alert(msg); };
}

if (typeof datTrangThaiLoading === 'undefined') {
    window.datTrangThaiLoading = function (btn, loading) { btn.disabled = loading; };
}

if (typeof layToken === 'undefined') {
    window.layToken = function () {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    };
}
