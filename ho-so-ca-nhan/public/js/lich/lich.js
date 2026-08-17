function khoiTaoLich() {
    // Trạng thái quản lý ngày tháng
    let ngayHienTai = new Date(); // Theo dõi tháng/năm đang được điều hướng
    let ngayDaChon = new Date(); // Theo dõi ngày được chọn trên lịch nhỏ
    
    let suKienChiTietHienTai = null; // Lưu trữ sự kiện đang được xem chi tiết

    const anhXaPhanLoai = {
        ca_nhan: 'Cá nhân',
        hop_tac: 'Hợp tác / Hội nhóm',
        deadline: 'Deadline công việc',
        su_kien: 'Sự kiện / Hội thảo',
        khac: 'Khác'
    };

    // Các phần tử DOM lịch nhỏ (Mini Calendar)
    const thangNamNho = document.getElementById('mini-month-year');
    const khungNgayNho = document.getElementById('mini-days-container');
    const nutNhoTruoc = document.getElementById('btn-mini-prev');
    const nutNhoSau = document.getElementById('btn-mini-next');

    // Các phần tử DOM lịch lớn (Large Calendar)
    const thangNamLon = document.getElementById('large-month-year');
    const khungNgayLon = document.getElementById('large-days-container');
    const nutLonTruoc = document.getElementById('btn-large-prev');
    const nutLonSau = document.getElementById('btn-large-next');
    const nutLonHomNay = document.getElementById('btn-large-today');

    // Form thêm/sửa lịch
    const formLich = document.getElementById('form-lich');
    const inputIdSuKien = document.getElementById('input-event-id');
    const inputTieuDeSuKien = document.getElementById('input-event-title');
    const inputNgayBatDau = document.getElementById('input-start-date');
    const inputGioBatDau = document.getElementById('input-start-time');
    const inputNgayKetThuc = document.getElementById('input-end-date');
    const inputGioKetThuc = document.getElementById('input-end-time');
    const inputPhanLoaiSuKien = document.getElementById('input-event-category');
    const inputMoTaSuKien = document.getElementById('input-event-desc');
    const nutLuuLich = document.getElementById('btn-luu-lich');

    // Modal xem chi tiết
    const modalChiTietLich = document.getElementById('modal-chi-tiet-lich');
    const hienTieuDeSuKien = document.getElementById('display-event-title');
    const hienNhanPhanLoaiSuKien = document.getElementById('display-event-category-badge');
    const hienDauPhanLoaiSuKien = document.getElementById('display-event-category-bullet');
    const hienChuPhanLoaiSuKien = document.getElementById('display-event-category-text');
    const hienBatDauSuKien = document.getElementById('display-event-start');
    const hienKetThucSuKien = document.getElementById('display-event-end');
    const hienMoTaSuKien = document.getElementById('display-event-desc');
    const khungHienMoTaSuKien = document.getElementById('display-event-desc-wrapper');
    const nutSuaLich = document.getElementById('btn-sua-lich');
    const nutXoaLich = document.getElementById('btn-xoa-lich');

    // Chọn giờ/phút tiếng Việt 24h
    const chonGioBatDau = document.getElementById('select-start-hour');
    const chonPhutBatDau = document.getElementById('select-start-minute');
    const chonGioKetThuc = document.getElementById('select-end-hour');
    const chonPhutKetThuc = document.getElementById('select-end-minute');

    // Đồng bộ dropdown vào hidden inputs
    function capNhatGioBatDau() {
        let h = chonGioBatDau ? chonGioBatDau.value : '';
        let m = chonPhutBatDau ? chonPhutBatDau.value : '';
        if (h && !m) {
            chonPhutBatDau.value = '00';
            m = '00';
        }
        if (!h && m) {
            chonGioBatDau.value = '00';
            h = '00';
        }
        if (h && m) {
            inputGioBatDau.value = `${h}:${m}`;
        } else {
            inputGioBatDau.value = '';
        }
    }

    function capNhatGioKetThuc() {
        let h = chonGioKetThuc ? chonGioKetThuc.value : '';
        let m = chonPhutKetThuc ? chonPhutKetThuc.value : '';
        if (h && !m) {
            chonPhutKetThuc.value = '00';
            m = '00';
        }
        if (!h && m) {
            chonGioKetThuc.value = '00';
            h = '00';
        }
        if (h && m) {
            inputGioKetThuc.value = `${h}:${m}`;
        } else {
            inputGioKetThuc.value = '';
        }
    }

    if (chonGioBatDau && chonPhutBatDau) {
        chonGioBatDau.addEventListener('change', capNhatGioBatDau);
        chonPhutBatDau.addEventListener('change', capNhatGioBatDau);
    }
    if (chonGioKetThuc && chonPhutKetThuc) {
        chonGioKetThuc.addEventListener('change', capNhatGioKetThuc);
        chonPhutKetThuc.addEventListener('change', capNhatGioKetThuc);
    }

    // Các hàm phụ trợ
    function dinhDangTenThang(nam, thang) {
        return `Tháng ${thang + 1}, ${nam}`;
    }

    function dinhDangTenThangLon(nam, thang) {
        return `Tháng ${thang + 1} năm ${nam}`;
    }

    function laySoNgayTrongThang(nam, thang) {
        return new Date(nam, thang + 1, 0).getDate();
    }

    function themSoKhong(num) {
        return num < 10 ? '0' + num : num;
    }

    function dinhDangChuoiNgay(y, m, d) {
        return `${y}-${themSoKhong(m + 1)}-${themSoKhong(d)}`;
    }

    function maHoaHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Lọc sự kiện trùng khớp với chuỗi ngày YYYY-MM-DD
    function laySuKienTheoNgay(chuoiNgay) {
        return (window.SU_KIEN_DATA || []).filter(e => {
            return chuoiNgay >= e.ngay_bat_dau && chuoiNgay <= e.ngay_ket_thuc;
        }).sort((a, b) => {
            const timeA = a.gio_bat_dau || '00:00';
            const timeB = b.gio_bat_dau || '00:00';
            return timeA.localeCompare(timeB);
        });
    }

    // Tính toán các vị trí ô hiển thị sự kiện trong bảng lịch lớn
    function tinhToanOChuaSuKien(danhSachNgayTrongKhung) {
        const firstDate = danhSachNgayTrongKhung[0];
        const lastDate = danhSachNgayTrongKhung[danhSachNgayTrongKhung.length - 1];
        
        // Lọc tất cả sự kiện nằm trong khoảng thời gian hiển thị của bảng lịch
        const visibleEvents = (window.SU_KIEN_DATA || []).filter(e => {
            return e.ngay_bat_dau <= lastDate && e.ngay_ket_thuc >= firstDate;
        });

        // Sắp xếp: Thời lượng dài hơn lên trước, sau đó tới ngày bắt đầu, giờ bắt đầu và ID
        visibleEvents.sort((a, b) => {
            const durA = new Date(a.ngay_ket_thuc) - new Date(a.ngay_bat_dau);
            const durB = new Date(b.ngay_ket_thuc) - new Date(b.ngay_bat_dau);
            if (durA !== durB) return durB - durA;
            
            if (a.ngay_bat_dau !== b.ngay_bat_dau) return a.ngay_bat_dau.localeCompare(b.ngay_bat_dau);
            
            const timeA = a.gio_bat_dau || '00:00';
            const timeB = b.gio_bat_dau || '00:00';
            if (timeA !== timeB) return timeA.localeCompare(timeB);
            
            return a.id - b.id;
        });

        const eventSlots = {}; // { eventId: slotIndex }
        const dateSlots = {};  // { dateStr: [eventId, eventId, ...] }

        visibleEvents.forEach(e => {
            let slot = 0;
            while (true) {
                let isFree = true;
                let current = new Date(e.ngay_bat_dau);
                const end = new Date(e.ngay_ket_thuc);
                while (current <= end) {
                    const curStr = dinhDangChuoiNgay(current.getFullYear(), current.getMonth(), current.getDate());
                    if (danhSachNgayTrongKhung.includes(curStr)) {
                        if (dateSlots[curStr] && dateSlots[curStr][slot] !== undefined) {
                            isFree = false;
                            break;
                        }
                    }
                    current.setDate(current.getDate() + 1);
                }
                if (isFree) {
                    break;
                }
                slot++;
            }

            eventSlots[e.id] = slot;

            // Đánh dấu ô đã bị chiếm
            let current = new Date(e.ngay_bat_dau);
            const end = new Date(e.ngay_ket_thuc);
            while (current <= end) {
                const curStr = dinhDangChuoiNgay(current.getFullYear(), current.getMonth(), current.getDate());
                if (danhSachNgayTrongKhung.includes(curStr)) {
                    if (!dateSlots[curStr]) {
                        dateSlots[curStr] = [];
                    }
                    dateSlots[curStr][slot] = e.id;
                }
                current.setDate(current.getDate() + 1);
            }
        });

        return { eventSlots, dateSlots };
    }

    // Vẽ lại cả hai lịch
    function hienThiLich() {
        hienThiLichNho();
        hienThiLichLon();
    }

    // Vẽ lịch nhỏ
    function hienThiLichNho() {
        if (!khungNgayNho) return;
        
        const nam = ngayHienTai.getFullYear();
        const thang = ngayHienTai.getMonth();

        thangNamNho.textContent = dinhDangTenThang(nam, thang);
        khungNgayNho.innerHTML = '';

        // Thứ của ngày đầu tiên trong tháng (Lịch bắt đầu từ Thứ Hai)
        let firstDayIdx = new Date(nam, thang, 1).getDay();
        let chiSoBatDau = firstDayIdx === 0 ? 6 : firstDayIdx - 1;

        const soNgayTrongThang = new Date(nam, thang + 1, 0).getDate();
        const soNgayThangTruoc = new Date(nam, thang, 0).getDate();

        // 1. Ngày cuối cùng của tháng trước
        for (let i = chiSoBatDau - 1; i >= 0; i--) {
            const d = soNgayThangTruoc - i;
            const oNgay = document.createElement('div');
            oNgay.className = 'mini-day-cell other-month';
            oNgay.textContent = d;
            
            const thangMucTieu = thang === 0 ? 11 : thang - 1;
            const namMucTieu = thang === 0 ? nam - 1 : nam;
            const chuoiNgay = dinhDangChuoiNgay(namMucTieu, thangMucTieu, d);
            oNgay.dataset.date = chuoiNgay;
            
            themSuKienOLichNho(oNgay, chuoiNgay);
            khungNgayNho.appendChild(oNgay);
        }

        // 2. Các ngày trong tháng hiện tại
        const homNay = new Date();
        const chuoiHomNay = dinhDangChuoiNgay(homNay.getFullYear(), homNay.getMonth(), homNay.getDate());
        const chuoiNgayDaChon = dinhDangChuoiNgay(ngayDaChon.getFullYear(), ngayDaChon.getMonth(), ngayDaChon.getDate());

        for (let d = 1; d <= soNgayTrongThang; d++) {
            const oNgay = document.createElement('div');
            oNgay.className = 'mini-day-cell';
            oNgay.textContent = d;

            const chuoiNgay = dinhDangChuoiNgay(nam, thang, d);
            oNgay.dataset.date = chuoiNgay;

            if (chuoiNgay === chuoiHomNay) oNgay.classList.add('today');
            if (chuoiNgay === chuoiNgayDaChon) oNgay.classList.add('selected');

            themSuKienOLichNho(oNgay, chuoiNgay);
            khungNgayNho.appendChild(oNgay);
        }

        // 3. Các ngày đầu của tháng sau (Điền đầy bảng 35 hoặc 42 ô)
        const tongSoO = chiSoBatDau + soNgayTrongThang;
        const soNgayConLai = tongSoO <= 35 ? 35 - tongSoO : 42 - tongSoO;
        for (let d = 1; d <= soNgayConLai; d++) {
            const oNgay = document.createElement('div');
            oNgay.className = 'mini-day-cell other-month';
            oNgay.textContent = d;

            const thangMucTieu = thang === 11 ? 0 : thang + 1;
            const namMucTieu = thang === 11 ? nam + 1 : nam;
            const chuoiNgay = dinhDangChuoiNgay(namMucTieu, thangMucTieu, d);
            oNgay.dataset.date = chuoiNgay;

            themSuKienOLichNho(oNgay, chuoiNgay);
            khungNgayNho.appendChild(oNgay);
        }
    }

    function themSuKienOLichNho(oNgay, chuoiNgay) {
        // Thêm tooltip ngày lễ nếu có
        if (window.NGAY_LE_DATA && window.NGAY_LE_DATA[chuoiNgay]) {
            oNgay.title = window.NGAY_LE_DATA[chuoiNgay];
        }

        // Hiển thị chấm tròn nhỏ ứng với sự kiện trong ngày
        const dateEvents = laySuKienTheoNgay(chuoiNgay);
        if (dateEvents.length > 0) {
            const dotWrapper = document.createElement('div');
            dotWrapper.className = 'event-dot-wrapper';
            // Giới hạn hiển thị tối đa 3 chấm
            dateEvents.slice(0, 3).forEach(e => {
                const dot = document.createElement('span');
                dot.className = `event-dot ${e.phan_loai}`;
                dotWrapper.appendChild(dot);
            });
            oNgay.appendChild(dotWrapper);
        }

        oNgay.addEventListener('click', function () {
            const parsedDate = new Date(chuoiNgay);
            ngayDaChon = parsedDate;
            ngayHienTai = new Date(parsedDate.getFullYear(), parsedDate.getMonth(), 1);
            hienThiLich();
            
            // Làm nổi bật ô lịch lớn tương ứng bằng hiệu ứng nhấp nháy màu nền
            const largeCell = khungNgayLon.querySelector(`[data-date="${chuoiNgay}"]`);
            if (largeCell) {
                largeCell.style.backgroundColor = '#eff6ff';
                setTimeout(() => {
                    largeCell.style.backgroundColor = '';
                }, 800);
            }
        });
    }

    // Vẽ lịch lớn
    function hienThiLichLon() {
        if (!khungNgayLon) return;

        const nam = ngayHienTai.getFullYear();
        const thang = ngayHienTai.getMonth();

        thangNamLon.textContent = dinhDangTenThangLon(nam, thang);
        khungNgayLon.innerHTML = '';

        let firstDayIdx = new Date(nam, thang, 1).getDay();
        let chiSoBatDau = firstDayIdx === 0 ? 6 : firstDayIdx - 1;

        const soNgayTrongThang = new Date(nam, thang + 1, 0).getDate();
        const soNgayThangTruoc = new Date(nam, thang, 0).getDate();

        const homNay = new Date();
        const chuoiHomNay = dinhDangChuoiNgay(homNay.getFullYear(), homNay.getMonth(), homNay.getDate());

        // Tạo danh sách các chuỗi ngày trong bảng
        const danhSachNgayTrongKhung = [];
        // 1. Ngày tháng trước
        for (let i = chiSoBatDau - 1; i >= 0; i--) {
            const d = soNgayThangTruoc - i;
            const thangMucTieu = thang === 0 ? 11 : thang - 1;
            const namMucTieu = thang === 0 ? nam - 1 : nam;
            danhSachNgayTrongKhung.push(dinhDangChuoiNgay(namMucTieu, thangMucTieu, d));
        }
        // 2. Ngày tháng hiện tại
        for (let d = 1; d <= soNgayTrongThang; d++) {
            danhSachNgayTrongKhung.push(dinhDangChuoiNgay(nam, thang, d));
        }
        // 3. Ngày tháng sau
        const tongSoO = chiSoBatDau + soNgayTrongThang;
        const soNgayConLai = tongSoO <= 35 ? 35 - tongSoO : 42 - tongSoO;
        for (let d = 1; d <= soNgayConLai; d++) {
            const thangMucTieu = thang === 11 ? 0 : thang + 1;
            const namMucTieu = thang === 11 ? nam + 1 : nam;
            danhSachNgayTrongKhung.push(dinhDangChuoiNgay(namMucTieu, thangMucTieu, d));
        }

        // Tính toán các vị trí sự kiện
        const { dateSlots } = tinhToanOChuaSuKien(danhSachNgayTrongKhung);
        const banDoSuKien = {};
        (window.SU_KIEN_DATA || []).forEach(e => {
            banDoSuKien[e.id] = e;
        });

        let gridIdx = 0;
        // 1. Ngày tháng trước
        for (let i = chiSoBatDau - 1; i >= 0; i--) {
            const d = soNgayThangTruoc - i;
            const chuoiNgay = danhSachNgayTrongKhung[gridIdx++];
            const oNgay = taoOLichLon(d, chuoiNgay, true, chuoiHomNay, dateSlots, banDoSuKien);
            khungNgayLon.appendChild(oNgay);
        }

        // 2. Ngày tháng hiện tại
        for (let d = 1; d <= soNgayTrongThang; d++) {
            const chuoiNgay = danhSachNgayTrongKhung[gridIdx++];
            const oNgay = taoOLichLon(d, chuoiNgay, false, chuoiHomNay, dateSlots, banDoSuKien);
            khungNgayLon.appendChild(oNgay);
        }

        // 3. Ngày tháng sau
        for (let d = 1; d <= soNgayConLai; d++) {
            const chuoiNgay = danhSachNgayTrongKhung[gridIdx++];
            const oNgay = taoOLichLon(d, chuoiNgay, true, chuoiHomNay, dateSlots, banDoSuKien);
            khungNgayLon.appendChild(oNgay);
        }
    }

    function taoOLichLon(soNgay, chuoiNgay, laThangKhac, chuoiHomNay, dateSlots, banDoSuKien) {
        const oNgay = document.createElement('div');
        oNgay.className = 'large-day-cell';
        if (laThangKhac) oNgay.classList.add('other-month');
        if (chuoiNgay === chuoiHomNay) oNgay.classList.add('today');
        oNgay.dataset.date = chuoiNgay;

        // Khung chứa số ngày và ngày lễ
        const khungSoNgay = document.createElement('div');
        khungSoNgay.className = 'large-day-number-wrapper';

        // Gắn ngày lễ VN nếu có
        if (window.NGAY_LE_DATA && window.NGAY_LE_DATA[chuoiNgay]) {
            const nhanNgayLe = document.createElement('span');
            nhanNgayLe.className = 'holiday-label';
            nhanNgayLe.textContent = window.NGAY_LE_DATA[chuoiNgay];
            nhanNgayLe.title = window.NGAY_LE_DATA[chuoiNgay];
            const chk = document.getElementById('toggle-holidays');
            nhanNgayLe.style.display = (chk && !chk.checked) ? 'none' : 'inline-block';
            khungSoNgay.appendChild(nhanNgayLe);
        }

        const chuSoNgay = document.createElement('span');
        chuSoNgay.className = 'large-day-number';
        chuSoNgay.textContent = soNgay;
        khungSoNgay.appendChild(chuSoNgay);
        oNgay.appendChild(khungSoNgay);

        // Khung chứa nhãn sự kiện
        const khungChuaNhan = document.createElement('div');
        khungChuaNhan.className = 'event-pills-container';

        const cacIdSuKienTrongNgay = dateSlots[chuoiNgay] || [];
        cacIdSuKienTrongNgay.forEach(eventId => {
            if (eventId === undefined || eventId === null) {
                // Tạo khoảng trống để đồng bộ chiều dọc
                const khoangTrong = document.createElement('div');
                khoangTrong.className = 'event-pill';
                khoangTrong.style.visibility = 'hidden';
                khoangTrong.style.border = 'none';
                khoangTrong.innerHTML = '&nbsp;';
                khungChuaNhan.appendChild(khoangTrong);
            } else {
                const e = banDoSuKien[eventId];
                if (!e) return;

                const nhanSuKien = document.createElement('div');
                nhanSuKien.className = `event-pill ${e.phan_loai}`;
                nhanSuKien.dataset.eventId = e.id;

                // Thêm class tạo viền bo nếu sự kiện kéo dài nhiều ngày
                if (e.ngay_bat_dau !== e.ngay_ket_thuc) {
                    if (chuoiNgay === e.ngay_bat_dau) {
                        nhanSuKien.classList.add('span-start');
                    } else if (chuoiNgay === e.ngay_ket_thuc) {
                        nhanSuKien.classList.add('span-end');
                    } else {
                        nhanSuKien.classList.add('span-middle');
                    }
                }

                const chuGio = document.createElement('span');
                chuGio.className = 'event-pill-time';
                // Ẩn giờ ở các ngày giữa/cuối của sự kiện dài ngày
                if (e.ngay_bat_dau !== e.ngay_ket_thuc && chuoiNgay !== e.ngay_bat_dau) {
                    chuGio.textContent = '';
                } else {
                    chuGio.textContent = e.gio_bat_dau ? e.gio_bat_dau.substring(0, 5) : 'Cả ngày';
                }

                const chuTieuDe = document.createElement('span');
                chuTieuDe.className = 'event-pill-title';
                if (e.ngay_bat_dau !== e.ngay_ket_thuc && chuoiNgay !== e.ngay_bat_dau) {
                    chuTieuDe.textContent = `(tiếp) ${e.tieu_de}`;
                } else {
                    chuTieuDe.textContent = e.tieu_de;
                }

                nhanSuKien.appendChild(chuGio);
                nhanSuKien.appendChild(chuTieuDe);

                nhanSuKien.addEventListener('click', function (event) {
                    event.stopPropagation(); // Tránh kích hoạt click vào ô ngày để thêm sự kiện
                    moModalChiTietSuKien(e);
                });

                khungChuaNhan.appendChild(nhanSuKien);
            }
        });

        oNgay.appendChild(khungChuaNhan);

        // Đăng ký sự kiện click ô để thêm công việc mới
        oNgay.addEventListener('click', function () {
            moModalThemLich(chuoiNgay);
        });

        return oNgay;
    }

    // Điều hướng tháng/năm lịch lớn và lịch nhỏ
    if (nutNhoTruoc) {
        nutNhoTruoc.addEventListener('click', function () {
            ngayHienTai.setMonth(ngayHienTai.getMonth() - 1);
            hienThiLich();
        });
    }
    if (nutNhoSau) {
        nutNhoSau.addEventListener('click', function () {
            ngayHienTai.setMonth(ngayHienTai.getMonth() + 1);
            hienThiLich();
        });
    }

    if (nutLonTruoc) {
        nutLonTruoc.addEventListener('click', function () {
            ngayHienTai.setMonth(ngayHienTai.getMonth() - 1);
            hienThiLich();
        });
    }
    if (nutLonSau) {
        nutLonSau.addEventListener('click', function () {
            ngayHienTai.setMonth(ngayHienTai.getMonth() + 1);
            hienThiLich();
        });
    }
    if (nutLonHomNay) {
        nutLonHomNay.addEventListener('click', function () {
            ngayHienTai = new Date();
            ngayDaChon = new Date();
            hienThiLich();
        });
    }

    // Vẽ giao diện lần đầu tiên
    hienThiLich();

    // Bắt sự kiện bật tắt ngày lễ VN
    const nutBatTatNgayLe = document.getElementById('toggle-holidays');
    if (nutBatTatNgayLe) {
        nutBatTatNgayLe.addEventListener('change', function () {
            const hienThi = this.checked;
            document.querySelectorAll('.holiday-label').forEach(el => {
                el.style.display = hienThi ? 'inline-block' : 'none';
            });
        });
    }

    // ---------------------------------------------------------
    // MỞ MODAL THÊM / SỬA SỰ KIỆN
    // ---------------------------------------------------------
    window.moModalThemLich = function (chuoiNgay) {
        if (!formLich) return;
        formLich.reset();
        if (inputIdSuKien) inputIdSuKien.value = '';
        if (chonGioBatDau) chonGioBatDau.value = '';
        if (chonPhutBatDau) chonPhutBatDau.value = '';
        if (chonGioKetThuc) chonGioKetThuc.value = '';
        if (chonPhutKetThuc) chonPhutKetThuc.value = '';

        const ngayMacDinh = chuoiNgay || dinhDangChuoiNgay(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        if (inputNgayBatDau) inputNgayBatDau.value = ngayMacDinh;
        if (inputNgayKetThuc) inputNgayKetThuc.value = ngayMacDinh;

        document.getElementById('modal-lich-title').textContent = 'Lên lịch công việc';
        moModal('modal-lich');
    };

    const btnThemLich = document.getElementById('btn-them-lich');
    if (btnThemLich) {
        btnThemLich.addEventListener('click', function () {
            moModalThemLich(null);
        });
    }

    // Mở modal xem chi tiết sự kiện
    function moModalChiTietSuKien(duLieuSuKien) {
        suKienChiTietHienTai = duLieuSuKien;

        if (hienTieuDeSuKien) hienTieuDeSuKien.textContent = duLieuSuKien.tieu_de;
        
        // Thiết lập nhãn màu phân loại
        if (hienNhanPhanLoaiSuKien) {
            hienNhanPhanLoaiSuKien.className = `category-badge-pill ${duLieuSuKien.phan_loai}`;
            hienDauPhanLoaiSuKien.className = `category-bullet ${duLieuSuKien.phan_loai}`;
            hienChuPhanLoaiSuKien.textContent = anhXaPhanLoai[duLieuSuKien.phan_loai] || duLieuSuKien.phan_loai;
        }

        // Định dạng hiển thị ngày giờ (kiểu Việt Nam)
        const dinhDangNgayGio = (giaTriNgay, giaTriGio) => {
            const cacPhan = giaTriNgay.split('-');
            const ngayDaDinhDang = cacPhan.length === 3 ? `${cacPhan[2]}/${cacPhan[1]}/${cacPhan[0]}` : giaTriNgay;
            return giaTriGio ? `${giaTriGio.substring(0, 5)} ngày ${ngayDaDinhDang}` : ngayDaDinhDang;
        };

        if (hienBatDauSuKien) hienBatDauSuKien.textContent = dinhDangNgayGio(duLieuSuKien.ngay_bat_dau, duLieuSuKien.gio_bat_dau);
        if (hienKetThucSuKien) hienKetThucSuKien.textContent = dinhDangNgayGio(duLieuSuKien.ngay_ket_thuc, duLieuSuKien.gio_ket_thuc);

        if (khungHienMoTaSuKien) {
            if (duLieuSuKien.mo_ta) {
                hienMoTaSuKien.textContent = duLieuSuKien.mo_ta;
                khungHienMoTaSuKien.style.display = 'flex';
            } else {
                hienMoTaSuKien.textContent = '';
                khungHienMoTaSuKien.style.display = 'none';
            }
        }

        moModal('modal-chi-tiet-lich');
    }

    // Nhấp vào nút sửa lịch trong modal chi tiết
    if (nutSuaLich) {
        nutSuaLich.addEventListener('click', function () {
            if (!suKienChiTietHienTai) return;
            dongModal('modal-chi-tiet-lich');

            const e = suKienChiTietHienTai;

            if (inputIdSuKien) inputIdSuKien.value = e.id;
            if (inputTieuDeSuKien) inputTieuDeSuKien.value = e.tieu_de;
            if (inputNgayBatDau) inputNgayBatDau.value = e.ngay_bat_dau;
            if (inputGioBatDau) inputGioBatDau.value = e.gio_bat_dau ? e.gio_bat_dau.substring(0, 5) : '';
            if (chonGioBatDau && chonPhutBatDau) {
                if (e.gio_bat_dau) {
                    const cacPhan = e.gio_bat_dau.split(':');
                    chonGioBatDau.value = cacPhan[0];
                    chonPhutBatDau.value = cacPhan[1];
                } else {
                    chonGioBatDau.value = '';
                    chonPhutBatDau.value = '';
                }
            }
            if (inputNgayKetThuc) inputNgayKetThuc.value = e.ngay_ket_thuc;
            if (inputGioKetThuc) inputGioKetThuc.value = e.gio_ket_thuc ? e.gio_ket_thuc.substring(0, 5) : '';
            if (chonGioKetThuc && chonPhutKetThuc) {
                if (e.gio_ket_thuc) {
                    const cacPhan = e.gio_ket_thuc.split(':');
                    chonGioKetThuc.value = cacPhan[0];
                    chonPhutKetThuc.value = cacPhan[1];
                } else {
                    chonGioKetThuc.value = '';
                    chonPhutKetThuc.value = '';
                }
            }
            if (inputPhanLoaiSuKien) inputPhanLoaiSuKien.value = e.phan_loai;
            if (inputMoTaSuKien) inputMoTaSuKien.value = e.mo_ta || '';

            document.getElementById('modal-lich-title').textContent = 'Chỉnh sửa lịch trình';
            moModal('modal-lich');
        });
    }

    // Submit lưu lịch làm việc bằng AJAX
    if (nutLuuLich) {
        nutLuuLich.addEventListener('click', function (event) {
            event.preventDefault();

            if (!formLich) return;

            // Thực hiện validate client-side cơ bản
            const giaTriTieuDe = inputTieuDeSuKien ? inputTieuDeSuKien.value.trim() : '';
            const giaTriNgayBatDau = inputNgayBatDau ? inputNgayBatDau.value : '';
            const giaTriGioBatDau = inputGioBatDau ? inputGioBatDau.value : '';
            const giaTriNgayKetThuc = inputNgayKetThuc ? inputNgayKetThuc.value : '';
            const giaTriGioKetThuc = inputGioKetThuc ? inputGioKetThuc.value : '';
            const giaTriPhanLoai = inputPhanLoaiSuKien ? inputPhanLoaiSuKien.value : '';
            const giaTriMoTa = inputMoTaSuKien ? inputMoTaSuKien.value.trim() : '';

            if (!giaTriTieuDe) {
                hienToast('error', 'Tiêu đề sự kiện không được để trống.');
                if (inputTieuDeSuKien) inputTieuDeSuKien.focus();
                return;
            }
            if (giaTriTieuDe.length < 2 || giaTriTieuDe.length > 30) {
                hienToast('error', 'Tiêu đề sự kiện phải từ 2 đến 30 ký tự.');
                if (inputTieuDeSuKien) inputTieuDeSuKien.focus();
                return;
            }

            // Regex tiêu đề
            const regexTieuDe = /^[^<>]+$/;
            if (!regexTieuDe.test(giaTriTieuDe)) {
                hienToast('error', 'Tiêu đề sự kiện chứa ký tự không hợp lệ.');
                if (inputTieuDeSuKien) inputTieuDeSuKien.focus();
                return;
            }

            if (!giaTriNgayBatDau) {
                hienToast('error', 'Ngày bắt đầu là bắt buộc.');
                if (inputNgayBatDau) inputNgayBatDau.focus();
                return;
            }
            if (!giaTriNgayKetThuc) {
                hienToast('error', 'Ngày kết thúc là bắt buộc.');
                if (inputNgayKetThuc) inputNgayKetThuc.focus();
                return;
            }

            if (new Date(giaTriNgayBatDau) > new Date(giaTriNgayKetThuc)) {
                hienToast('error', 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.');
                if (inputNgayKetThuc) inputNgayKetThuc.focus();
                return;
            }

            if (giaTriNgayBatDau === giaTriNgayKetThuc && giaTriGioBatDau && giaTriGioKetThuc && giaTriGioKetThuc < giaTriGioBatDau) {
                hienToast('error', 'Giờ kết thúc phải sau giờ bắt đầu trong cùng một ngày.');
                if (inputGioKetThuc) inputGioKetThuc.focus();
                return;
            }

            if (giaTriMoTa.length > 100) {
                hienToast('error', 'Mô tả chi tiết không được vượt quá 100 ký tự.');
                if (inputMoTaSuKien) inputMoTaSuKien.focus();
                return;
            }

            const duLieuGui = {
                id: inputIdSuKien ? inputIdSuKien.value : null,
                tieu_de: giaTriTieuDe,
                ngay_bat_dau: giaTriNgayBatDau,
                gio_bat_dau: giaTriGioBatDau || null,
                ngay_ket_thuc: giaTriNgayKetThuc,
                gio_ket_thuc: giaTriGioKetThuc || null,
                phan_loai: giaTriPhanLoai,
                mo_ta: giaTriMoTa || null
            };

            datTrangThaiLoading(nutLuuLich, true);

            fetch(window.ROUTES.luuLich, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': layToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(duLieuGui)
            })
            .then(async phanHoi => {
                const laJson = phanHoi.headers.get('content-type')?.includes('application/json');
                const duLieu = laJson ? await phanHoi.json() : null;

                if (!phanHoi.ok) {
                    if (phanHoi.status === 422 && duLieu && duLieu.errors) {
                        const errorMsg = Object.values(duLieu.errors).flat().join(', ');
                        throw new Error(errorMsg);
                    }
                    if (duLieu && duLieu.thong_bao) {
                        throw new Error(duLieu.thong_bao);
                    }
                    throw new Error('Lỗi máy chủ (' + phanHoi.status + ')');
                }
                return duLieu;
            })
            .then(duLieu => {
                if (duLieu.thanh_cong) {
                    hienToast('success', duLieu.thong_bao || 'Lưu lịch làm việc thành công!');
                    dongModal('modal-lich');
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    hienToast('error', duLieu.thong_bao || 'Có lỗi xảy ra!');
                }
            })
            .catch(err => {
                console.error('[Lich] Save error:', err);
                hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
            })
            .finally(() => {
                datTrangThaiLoading(nutLuuLich, false);
            });
        });
    }

    // Trigger xóa lịch làm việc bằng AJAX
    if (nutXoaLich) {
        nutXoaLich.addEventListener('click', function () {
            if (!suKienChiTietHienTai) return;

            if (confirm('Bạn có chắc chắn muốn xóa sự kiện này? Hành động này không thể hoàn tác.')) {
                dongModal('modal-chi-tiet-lich');

                const urlXoa = window.ROUTES.xoaLich.replace('ID_PLACEHOLDER', suKienChiTietHienTai.id);

                fetch(urlXoa, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': layToken(),
                        'Accept': 'application/json'
                    }
                })
                .then(async phanHoi => {
                    const laJson = phanHoi.headers.get('content-type')?.includes('application/json');
                    const duLieu = laJson ? await phanHoi.json() : null;

                    if (!phanHoi.ok) {
                        if (duLieu && duLieu.thong_bao) {
                            throw new Error(duLieu.thong_bao);
                        }
                        throw new Error('Lỗi máy chủ (' + phanHoi.status + ')');
                    }
                    return duLieu;
                })
                .then(duLieu => {
                    if (duLieu.thanh_cong) {
                        hienToast('success', duLieu.thong_bao || 'Xóa sự kiện thành công!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else {
                        hienToast('error', duLieu.thong_bao || 'Có lỗi xảy ra!');
                    }
                })
                .catch(err => {
                    console.error('[Lich] Delete error:', err);
                    hienToast('error', err.message || 'Lỗi kết nối! Vui lòng thử lại.');
                });
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', khoiTaoLich);
} else {
    khoiTaoLich();
}
