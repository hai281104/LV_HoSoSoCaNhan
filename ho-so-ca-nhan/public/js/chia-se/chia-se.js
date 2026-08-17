// Hàm XEM TRƯỚC CV (mở preview, không tự động tải)
// eslint-disable-next-line no-unused-vars
function xemTruocCvDaChon() {
    const theChon = document.getElementById('cv-select');
    if (!theChon) return;
    const idCv = theChon.value;
    const duongDan = `/ho-so/cv/${idCv}/xem-truoc`;
    window.open(duongDan, '_blank');
}

// Hàm tải xuống CV (mở và tự động tải PDF)
// eslint-disable-next-line no-unused-vars
function taiCvDaChon() {
    const theChon = document.getElementById('cv-select');
    if (!theChon) return;
    const idCv = theChon.value;
    const duongDan = `/ho-so/cv/${idCv}/xem-truoc?download=1`;
    window.open(duongDan, '_blank');
    hienToast('success', 'Đang chuẩn bị tải xuống file CV...');
}

// Hàm XEM TRƯỚC Hồ sơ (mở preview, không tự động tải)
// eslint-disable-next-line no-unused-vars
function xemTruocHoSo() {
    const duongDan = window.ROUTES.xemTruocIn;
    window.open(duongDan, '_blank');
}

// Khởi tạo biến lưu mật mã
let matKhauDaTaoHienTai = '';

function taoMatMaNgauNhien() {
    const kyTu = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let matMa = 'DPCS-';
    for (let i = 0; i < 6; i++) {
        matMa += kyTu.charAt(Math.floor(Math.random() * kyTu.length));
    }
    return matMa;
}

// Hàm xuất và tải Hồ sơ mã hóa
// eslint-disable-next-line no-unused-vars
function taiHoSo() {
    matKhauDaTaoHienTai = taoMatMaNgauNhien();
    document.getElementById('generated-passcode').innerText = matKhauDaTaoHienTai;
    document.getElementById('encrypt-modal-overlay').classList.add('active');
    hienToast('success', 'Đã khởi tạo mật mã bảo mật!');
}

// eslint-disable-next-line no-unused-vars
function dongModalMaHoa() {
    document.getElementById('encrypt-modal-overlay').classList.remove('active');
}

// eslint-disable-next-line no-unused-vars
function saoChepMatMa() {
    const codeText = document.getElementById('generated-passcode').innerText;
    navigator.clipboard.writeText(codeText).then(() => {
        hienToast('success', 'Đã sao chép mật mã!');
    }).catch(() => {
        hienToast('error', 'Không thể tự sao chép, vui lòng bôi đen và copy thủ công.');
    });
}

// eslint-disable-next-line no-unused-vars
function kichHoatTaiMaHoa() {
    const duongDan = `${window.ROUTES.xemTruocIn}?download=1&encrypt=1&password=${matKhauDaTaoHienTai}`;
    window.open(duongDan, '_blank');
    hienToast('success', 'Bắt đầu xuất và mã hóa file PDF...');
    dongModalMaHoa();
}

// Xử lý Giải mã & Mở file PDF mã hóa
// eslint-disable-next-line no-undef
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

// eslint-disable-next-line no-unused-vars
function giaiMaVaMoFile() {
    const dauVaoFile = document.getElementById('decrypt-file-input');
    const dauVaoMatKhau = document.getElementById('decrypt-password-input');
    
    if (!dauVaoFile.files || dauVaoFile.files.length === 0) {
        hienToast('error', 'Vui lòng chọn file đã mã hóa!');
        return;
    }
    const matKhau = dauVaoMatKhau.value.trim();
    if (!matKhau) {
        hienToast('error', 'Vui lòng nhập mật mã giải mã!');
        return;
    }

    const tepTin = dauVaoFile.files[0];
    const boDocTep = new FileReader();
    
    hienToast('info', 'Đang đọc tệp tin...');
    
    boDocTep.onload = function(e) {
        const noiDungTep = e.target.result;
        
        try {
            // Giải mã AES-256
            
            const duLieuGiaiMa = CryptoJS.AES.decrypt(noiDungTep, matKhau);
            if (duLieuGiaiMa.sigBytes <= 0) {
                throw new Error("Mật mã không chính xác hoặc tệp tin bị hỏng.");
            }
            
            const decryptedArrayBuffer = chuyenMangTuSangVungNhiPhan(duLieuGiaiMa);
            const mangKieu = new Uint8Array(decryptedArrayBuffer);
            
            hienToast('info', 'Đang kết xuất giao diện an toàn...');
            
            // Sử dụng PDF.js để nạp ArrayBuffer
            
            const loadingTask = pdfjsLib.getDocument({ data: mangKieu });
            loadingTask.promise.then(function(doiTuongPdf) {
                hienToast('success', 'Giải mã thành công!');
                hienThiPdfBaoMat(doiTuongPdf);
            }).catch(function(err) {
                console.error(err);
                hienToast('error', 'Không thể mở tài liệu. Mật mã không chính xác hoặc tệp bị hỏng!');
            });
        } catch (err) {
            console.error(err);
            hienToast('error', 'Giải mã thất bại! Vui lòng kiểm tra lại mật mã.');
        }
    };
    boDocTep.readAsText(tepTin);
}

// Chuyển đổi WordArray của CryptoJS thành ArrayBuffer
function chuyenMangTuSangVungNhiPhan(wordArray) {
    const cacTu = wordArray.words;
    const soByteDacTrung = wordArray.sigBytes;
    const mangU8 = new Uint8Array(soByteDacTrung);
    for (let i = 0; i < soByteDacTrung; i++) {
        const byteDuLieu = (cacTu[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
        mangU8[i] = byteDuLieu;
    }
    return mangU8.buffer;
}

// Vẽ tài liệu PDF ra các thẻ canvas
function hienThiPdfBaoMat(doiTuongPdf) {
    const khungChua = document.getElementById('viewer-canvas-container');
    khungChua.innerHTML = ''; // Đặt lại
    
    let cacLoiHuaHienThi = [];
    for (let soTrang = 1; soTrang <= doiTuongPdf.numPages; soTrang++) {
        const pagePromise = doiTuongPdf.getPage(soTrang).then(function(page) {
            const khungNhin = page.getViewport({ scale: 1.5 });
            const theCanvas = document.createElement('canvas');
            const context = theCanvas.getContext('2d');
            theCanvas.height = khungNhin.height;
            theCanvas.width = khungNhin.width;
            
            // Chặn chuột phải trực tiếp trên canvas
            theCanvas.oncontextmenu = () => false;
            
            const nguCanhHienThi = {
                canvasContext: context,
                viewport: khungNhin
            };
            
            return page.render(nguCanhHienThi).promise.then(() => {
                khungChua.appendChild(theCanvas);
            });
        });
        cacLoiHuaHienThi.push(pagePromise);
    }
    
    Promise.all(cacLoiHuaHienThi).then(() => {
        // Hiển thị trình xem toàn màn hình
        document.getElementById('secure-pdf-viewer').classList.add('active');
        
        // Lắng nghe chặn phím tắt & chuột phải
        document.addEventListener('keydown', chanPhimTatTrinhXemBaoMat);
        document.addEventListener('contextmenu', chanMenuChuotPhai);
    });
}

// eslint-disable-next-line no-unused-vars
function dongTrinhXemBaoMat() {
    document.getElementById('secure-pdf-viewer').classList.remove('active');
    document.getElementById('viewer-canvas-container').innerHTML = '';
    
    document.removeEventListener('keydown', chanPhimTatTrinhXemBaoMat);
    document.removeEventListener('contextmenu', chanMenuChuotPhai);
    
    // Reset inputs
    document.getElementById('decrypt-file-input').value = '';
    document.getElementById('decrypt-password-input').value = '';
}

function chanPhimTatTrinhXemBaoMat(e) {
    // Chặn Ctrl+S, Ctrl+P, Ctrl+C, Ctrl+U
    if (e.ctrlKey && (e.key === 's' || e.key === 'p' || e.key === 'c' || e.key === 'u' || e.key === 'S' || e.key === 'P' || e.key === 'C' || e.key === 'U')) {
        e.preventDefault();
        hienToast('warning', 'Chế độ xem bảo mật: Hành động này bị chặn!');
        return false;
    }
}

function chanMenuChuotPhai(e) {
    e.preventDefault();
    return false;
}

// Gửi CV qua MXH
// eslint-disable-next-line no-unused-vars
function chiaSeCv(platform) {
    const theChon = document.getElementById('cv-select');
    if (!theChon) return;
    const name = theChon.tagName === 'SELECT'
        ? theChon.options[theChon.selectedIndex].getAttribute('data-name')
        : theChon.getAttribute('data-name');
    
    if (platform === 'zalo') {
        window.open('https://chat.zalo.me/', '_blank');
        hienToast('info', 'Đã mở Zalo Web. Hãy đính kèm tệp "' + name + '.pdf" vừa tải về để gửi.');
    } else if (platform === 'gmail') {
        const subject = encodeURIComponent('Hồ sơ xin việc - ' + name);
        const body = encodeURIComponent('Chào anh/chị,\n\nTối gửi kèm file PDF CV của tôi: ' + name + ' để ứng tuyển.\n\nRất mong nhận được phản hồi từ anh/chị.\n\nTrân trọng!');
        window.open('https://mail.google.com/mail/?view=cm&fs=1&su=' + subject + '&body=' + body, '_blank');
        hienToast('info', 'Đã mở Gmail Web. Hãy đính kèm tệp "' + name + '.pdf" vừa tải về để gửi.');
    }
}

// Gửi Profile qua MXH
// eslint-disable-next-line no-unused-vars
function chiaSeHoSo(platform) {
    const tenNguoiDung = window.USER_DATA.hoTen;
    if (platform === 'zalo') {
        window.open('https://chat.zalo.me/', '_blank');
        hienToast('info', 'Đã mở Zalo Web. Hãy đính kèm tệp "Ho-so-nang-luc-' + tenNguoiDung.replace(/\s+/g, '-').normalize("NFD").replace(/[\u0300-\u036f]/g, "") + '.pdf" vừa tải về để gửi.');
    } else if (platform === 'gmail') {
        const subject = encodeURIComponent('Hồ sơ năng lực cá nhân - ' + tenNguoiDung);
        const body = encodeURIComponent('Chào anh/chị,\n\nTối gửi kèm file PDF Hồ sơ năng lực cá nhân của tôi để quý công ty tham khảo.\n\nRất mong nhận được phản hồi từ anh/chị.\n\nTrân trọng!');
        window.open('https://mail.google.com/mail/?view=cm&fs=1&su=' + subject + '&body=' + body, '_blank');
        hienToast('info', 'Đã mở Gmail Web. Hãy đính kèm tệp "Ho-so-nang-luc-' + tenNguoiDung.replace(/\s+/g, '-').normalize("NFD").replace(/[\u0300-\u036f]/g, "") + '.pdf" vừa tải về để gửi.');
    }
}
