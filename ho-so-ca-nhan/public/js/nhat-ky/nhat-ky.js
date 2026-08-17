// Xóa lịch sử nhật ký
const nutXoaNhatKy = document.getElementById('btn-clear-logs-history');
if (nutXoaNhatKy) {
    nutXoaNhatKy.addEventListener('click', function() {
        if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ lịch sử hoạt động và nhật ký bảo mật của mình? Hành động này không thể hoàn tác!')) {
            return;
        }

        datTrangThaiLoading(nutXoaNhatKy, true);

        fetch(window.ROUTES.xoaNhatKy, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': layToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(async phanHoi => {
            const duLieu = await phanHoi.json().catch(() => null);
            if (!phanHoi.ok) throw new Error(duLieu && duLieu.thong_bao ? duLieu.thong_bao : 'Lỗi máy chủ (' + phanHoi.status + ')');
            return duLieu;
        })
        .then(duLieu => {
            if (duLieu && duLieu.thanh_cong) {
                hienToast('success', duLieu.thong_bao || 'Đã xóa toàn bộ nhật ký!');
                setTimeout(() => {
                    window.location.href = window.ROUTES.nhatKy;
                }, 1200);
            } else {
                hienToast('error', (duLieu && duLieu.thong_bao) || 'Có lỗi xảy ra!');
                datTrangThaiLoading(nutXoaNhatKy, false);
            }
        })
        .catch(loi => {
            console.error('[NhatKy] Delete error:', loi);
            hienToast('error', loi.message || 'Lỗi kết nối!');
            datTrangThaiLoading(nutXoaNhatKy, false);
        });
    });
}
