<?php

use App\Http\Controllers\XacThucController;
use App\Http\Controllers\HoSoController;
use App\Http\Controllers\HocVanController;
use App\Http\Controllers\DuAnController;
use App\Http\Controllers\ChungChiController;
use App\Http\Controllers\ThanhTuuController;
use App\Http\Controllers\KinhNghiemController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CvController;

use App\Http\Controllers\NhatKyController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\CaiDatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['guest', 'throttle:auth_attempts'])->group(function () {
    Route::get('/dang-nhap', [XacThucController::class, 'hienThiFormDangNhap'])->name('dang-nhap');
    Route::post('/dang-nhap', [XacThucController::class, 'dangNhap']);
    Route::get('/dang-ky', [XacThucController::class, 'hienThiFormDangKy'])->name('dang-ky');
    Route::post('/dang-ky', [XacThucController::class, 'dangKy']);

    // Quên mật khẩu & Đặt lại mật khẩu
    Route::get('/quen-mat-khau', [XacThucController::class, 'hienThiFormQuenMatKhau'])->name('quen-mat-khau');
    Route::post('/quen-mat-khau', [XacThucController::class, 'guiEmailDatLaiMatKhau']);
    Route::get('/dat-lai-mat-khau/{token}', [XacThucController::class, 'hienThiFormDatLaiMatKhau'])->name('password.reset');
    Route::post('/dat-lai-mat-khau', [XacThucController::class, 'datLaiMatKhau'])->name('password.update');
});

Route::middleware(['auth', 'kiem_tra_khoa'])->group(function () {
    Route::post('/dang-xuat', [XacThucController::class, 'dangXuat'])->name('dang-xuat');
    Route::get('/tai-khoan-bi-khoa', [XacThucController::class, 'taiKhoanBiKhoa'])->name('tai-khoan.bi-khoa');

    Route::middleware('nguoi_dung')->group(function () {
        // Trang chu Dashboard
        Route::get('/trang-chu', [HoSoController::class, 'dashboard'])->name('trang-chu');

    // Ho so ca nhan
    Route::get('/ho-so', [HoSoController::class, 'index'])->name('ho-so');
    Route::get('/ho-so/hanh-trinh', [HoSoController::class, 'hanhTrinh'])->name('ho-so.hanh-trinh');
    Route::post('/ho-so/cap-nhat-co-ban', [HoSoController::class, 'capNhatCoBan'])->name('ho-so.cap-nhat-co-ban');
    Route::post('/ho-so/cap-nhat-avatar', [HoSoController::class, 'capNhatAvatar'])->name('ho-so.cap-nhat-avatar');
    Route::post('/ho-so/cap-nhat-ky-nang', [HoSoController::class, 'capNhatKyNang'])->name('ho-so.cap-nhat-ky-nang');
    Route::post('/ho-so/cap-nhat-lien-ket', [HoSoController::class, 'capNhatLienKet'])->name('ho-so.cap-nhat-lien-ket');

    // Hoc van & Trinh do
    Route::get('/ho-so/hoc-van', [HocVanController::class, 'hocVan'])->name('ho-so.hoc-van');
    Route::post('/ho-so/hoc-van/luu', [HocVanController::class, 'luuHocVan'])->name('ho-so.hoc-van.luu');
    Route::post('/ho-so/hoc-van/xoa/{id}', [HocVanController::class, 'xoaHocVan'])->name('ho-so.hoc-van.xoa');
    Route::post('/ho-so/hoc-van/{id}/toggle-noi-bat', [HocVanController::class, 'toggleNoiBat'])->name('ho-so.hoc-van.toggle-noi-bat');

    // Portfolio du an
    Route::get('/ho-so/du-an', [DuAnController::class, 'index'])->name('ho-so.du-an');
    Route::post('/ho-so/du-an/luu', [DuAnController::class, 'luuDuAn'])->name('ho-so.du-an.luu');
    Route::post('/ho-so/du-an/xoa/{id}', [DuAnController::class, 'xoaDuAn'])->name('ho-so.du-an.xoa');
    Route::post('/ho-so/du-an/{id}/toggle-noi-bat', [DuAnController::class, 'toggleNoiBat'])->name('ho-so.du-an.toggle-noi-bat');

    // Chung chi & Chung nhan
    Route::get('/ho-so/chung-chi', [ChungChiController::class, 'index'])->name('ho-so.chung-chi');
    Route::post('/ho-so/chung-chi/luu', [ChungChiController::class, 'luuChungChi'])->name('ho-so.chung-chi.luu');
    Route::post('/ho-so/chung-chi/xoa/{id}', [ChungChiController::class, 'xoaChungChi'])->name('ho-so.chung-chi.xoa');
    Route::post('/ho-so/chung-chi/{id}/toggle-noi-bat', [ChungChiController::class, 'toggleNoiBat'])->name('ho-so.chung-chi.toggle-noi-bat');

    // Thanh tuu
    Route::get('/ho-so/thanh-tuu', [ThanhTuuController::class, 'index'])->name('ho-so.thanh-tuu');
    Route::post('/ho-so/thanh-tuu/luu', [ThanhTuuController::class, 'luuThanhTuu'])->name('ho-so.thanh-tuu.luu');
    Route::post('/ho-so/thanh-tuu/xoa/{id}', [ThanhTuuController::class, 'xoaThanhTuu'])->name('ho-so.thanh-tuu.xoa');
    Route::post('/ho-so/thanh-tuu/{id}/toggle-noi-bat', [ThanhTuuController::class, 'toggleNoiBat'])->name('ho-so.thanh-tuu.toggle-noi-bat');

    // Kinh nghiem lam viec
    Route::get('/ho-so/kinh-nghiem', [KinhNghiemController::class, 'index'])->name('ho-so.kinh-nghiem');
    Route::post('/ho-so/kinh-nghiem/luu', [KinhNghiemController::class, 'luuKinhNghiem'])->name('ho-so.kinh-nghiem.luu');
    Route::post('/ho-so/kinh-nghiem/xoa/{id}', [KinhNghiemController::class, 'xoaKinhNghiem'])->name('ho-so.kinh-nghiem.xoa');
    Route::post('/ho-so/kinh-nghiem/{id}/toggle-noi-bat', [KinhNghiemController::class, 'toggleNoiBat'])->name('ho-so.kinh-nghiem.toggle-noi-bat');

    // Album anh noi bat
    Route::get('/ho-so/album', [AlbumController::class, 'index'])->name('ho-so.album');
    Route::post('/ho-so/album/luu', [AlbumController::class, 'luuAlbum'])->name('ho-so.album.luu');
    Route::post('/ho-so/album/xoa/{id}', [AlbumController::class, 'xoaAlbum'])->name('ho-so.album.xoa');

    // Quan ly CV
    Route::get('/ho-so/cv', [CvController::class, 'index'])->name('ho-so.cv.index');
    Route::post('/ho-so/cv/tao', [CvController::class, 'store'])->name('ho-so.cv.store');
    Route::get('/ho-so/cv/{id}/chinh-sua', [CvController::class, 'edit'])->name('ho-so.cv.edit');
    Route::post('/ho-so/cv/{id}/cap-nhat', [CvController::class, 'update'])->name('ho-so.cv.update');
    Route::get('/ho-so/cv/{id}/xem-truoc', [CvController::class, 'preview'])->name('ho-so.cv.preview');
    Route::post('/ho-so/cv/{id}/xoa', [CvController::class, 'destroy'])->name('ho-so.cv.destroy');
    Route::post('/ho-so/cv/{id}/kich-hoat', [CvController::class, 'setMain'])->name('ho-so.cv.set-main');

    // AI Features cho CV
    Route::post('/ho-so/cv/tao-bang-ai', [CvController::class, 'storeWithAI'])->name('ho-so.cv.store-ai');
    Route::post('/ho-so/cv/ai-improve-text', [CvController::class, 'aiImproveText'])->name('ho-so.cv.ai-improve-text');
    Route::post('/ho-so/cv/{id}/ai-evaluate', [CvController::class, 'aiEvaluate'])->name('ho-so.cv.ai-evaluate');

    // Chia sẻ hồ sơ & Xuất PDF
    Route::get('/ho-so/chia-se', [HoSoController::class, 'chiaSe'])->name('ho-so.chia-se');
    Route::get('/ho-so/tai-ho-so-pdf', [HoSoController::class, 'taiHoSoPdf'])->name('ho-so.tai-ho-so-pdf');
    Route::get('/ho-so/xem-truoc-in', [HoSoController::class, 'xemTruocIn'])->name('ho-so.xem-truoc-in');



    // Nhật ký hoạt động & bảo mật
    Route::get('/ho-so/nhat-ky', [NhatKyController::class, 'index'])->name('ho-so.nhat-ky');
    Route::post('/ho-so/nhat-ky/xoa', [NhatKyController::class, 'xoaNhatKy'])->name('ho-so.nhat-ky.xoa');

    // Thông báo (notification API)
    Route::get('/api/thong-bao', [ThongBaoController::class, 'layThongBao'])->name('thong-bao.lay');
    Route::post('/api/thong-bao/doc-tat-ca', [ThongBaoController::class, 'docTatCa'])->name('thong-bao.doc-tat-ca');
    Route::post('/api/thong-bao/{id}/doc', [ThongBaoController::class, 'danhDauDaDoc'])->name('thong-bao.doc');
    Route::post('/api/thong-bao/{id}/xoa', [ThongBaoController::class, 'xoa'])->name('thong-bao.xoa');

    // Cài đặt & Đóng góp ý kiến
    Route::post('/ho-so/cai-dat/doi-mat-khau', [CaiDatController::class, 'doiMatKhau'])->name('cai-dat.doi-mat-khau');
    Route::post('/ho-so/cai-dat/thong-bao', [CaiDatController::class, 'doiThongBao'])->name('cai-dat.thong-bao');
    Route::post('/ho-so/cai-dat/xoa-tai-khoan', [CaiDatController::class, 'xoaTaiKhoan'])->name('cai-dat.xoa-tai-khoan');
    Route::post('/ho-so/cai-dat/y-kien', [CaiDatController::class, 'guiDongGopYKien'])->name('cai-dat.y-kien');
    });

    // Tuyen duong Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/nguoi-dung', [\App\Http\Controllers\Admin\NguoiDungController::class, 'index'])->name('nguoi-dung.index');
        Route::post('/nguoi-dung/{id}/khoa', [\App\Http\Controllers\Admin\NguoiDungController::class, 'khoa'])->name('nguoi-dung.khoa');
        Route::post('/nguoi-dung/{id}/mo-khoa', [\App\Http\Controllers\Admin\NguoiDungController::class, 'moKhoa'])->name('nguoi-dung.mo-khoa');
        
        // Quản lý Mẫu CV
        Route::get('/mau-cv', [\App\Http\Controllers\Admin\MauCvController::class, 'index'])->name('mau-cv.index');
        Route::post('/mau-cv/luu', [\App\Http\Controllers\Admin\MauCvController::class, 'store'])->name('mau-cv.store');
        Route::post('/mau-cv/generate-ai', [\App\Http\Controllers\Admin\MauCvController::class, 'generateAiTemplate'])->name('mau-cv.generate-ai');
        Route::post('/mau-cv/{id}/cap-nhat', [\App\Http\Controllers\Admin\MauCvController::class, 'update'])->name('mau-cv.update');
        Route::post('/mau-cv/{id}/xoa', [\App\Http\Controllers\Admin\MauCvController::class, 'destroy'])->name('mau-cv.destroy');
        Route::post('/mau-cv/{id}/doi-trang-thai', [\App\Http\Controllers\Admin\MauCvController::class, 'doiTrangThai'])->name('mau-cv.doi-trang-thai');

        // Quản lý Danh mục chuẩn (Kỹ năng mềm & Ngôn ngữ lập trình)
        Route::get('/danh-muc-chuan', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'index'])->name('danh-muc-chuan.index');
        Route::post('/danh-muc-chuan/ngon-ngu/luu', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'luuNgonNgu'])->name('danh-muc-chuan.ngon-ngu.luu');
        Route::post('/danh-muc-chuan/ngon-ngu/{id}/cap-nhat', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'capNhatNgonNgu'])->name('danh-muc-chuan.ngon-ngu.cap-nhat');
        Route::post('/danh-muc-chuan/ngon-ngu/{id}/xoa', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'xoaNgonNgu'])->name('danh-muc-chuan.ngon-ngu.xoa');
        
        Route::post('/danh-muc-chuan/ky-nang/luu', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'luuKyNang'])->name('danh-muc-chuan.ky-nang.luu');
        Route::post('/danh-muc-chuan/ky-nang/{id}/cap-nhat', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'capNhatKyNang'])->name('danh-muc-chuan.ky-nang.cap-nhat');
        Route::post('/danh-muc-chuan/ky-nang/{id}/xoa', [\App\Http\Controllers\Admin\DanhMucChuanController::class, 'xoaKyNang'])->name('danh-muc-chuan.ky-nang.xoa');

        // Nhật ký hoạt động của người dùng
        Route::get('/nhat-ky-hoat-dong', [\App\Http\Controllers\Admin\NhatKyHoatDongController::class, 'index'])->name('nhat-ky-hoat-dong.index');

        // Nhật ký hệ thống & Cơ sở dữ liệu
        Route::get('/nhat-ky-he-thong', [\App\Http\Controllers\Admin\NhatKyHeThongController::class, 'index'])->name('nhat-ky-he-thong.index');
        Route::post('/nhat-ky-he-thong/xoa', [\App\Http\Controllers\Admin\NhatKyHeThongController::class, 'clear'])->name('nhat-ky-he-thong.clear');

        // Ý kiến đóng góp của người dùng
        Route::get('/y-kien-nguoi-dung', [\App\Http\Controllers\Admin\YKienNguoiDungController::class, 'index'])->name('y-kien-nguoi-dung.index');
        Route::post('/y-kien-nguoi-dung/{id}/xoa', [\App\Http\Controllers\Admin\YKienNguoiDungController::class, 'destroy'])->name('y-kien-nguoi-dung.destroy');

    });
});
