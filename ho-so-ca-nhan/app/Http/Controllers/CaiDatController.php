<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CaiDatController extends Controller
{
    /**
     * Đổi mật khẩu người dùng.
     */
    public function doiMatKhau(Request $request)
    {
        $nguoiDung = Auth::user();

        $luatKiemTra = [
            'mat_khau_cu' => ['required', 'string'],
            'mat_khau' => ['required', 'string', 'min:6', 'max:20'],
            'mat_khau_xac_nhan' => ['required', 'string', 'same:mat_khau'],
        ];

        $thongBaoLoi = [
            'mat_khau_cu.required' => 'Mật khẩu hiện tại không được để trống.',
            'mat_khau.required' => 'Mật khẩu mới không được để trống.',
            'mat_khau.min' => 'Mật khẩu mới phải từ 6 đến 20 ký tự.',
            'mat_khau.max' => 'Mật khẩu mới phải từ 6 đến 20 ký tự.',
            'mat_khau_xac_nhan.required' => 'Xác nhận mật khẩu mới không được để trống.',
            'mat_khau_xac_nhan.same' => 'Mật khẩu xác nhận không trùng khớp.',
        ];

        $request->validate($luatKiemTra, $thongBaoLoi);

        if (!Hash::check($request->input('mat_khau_cu'), $nguoiDung->mat_khau)) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => 'Mật khẩu hiện tại không chính xác.'
            ], 422);
        }

        // Cập nhật mật khẩu mới và đăng xuất các thiết bị khác đang hoạt động
        Auth::logoutOtherDevices($request->input('mat_khau'), 'mat_khau');

        // Cập nhật ngày cập nhật cho tài khoản
        DB::table('nguoi_dung')
            ->where('id', $nguoiDung->id)
            ->update([
                'ngay_cap_nhat' => now()
            ]);

        self::ghiLog($nguoiDung->id, 'bao_mat', 'Đổi mật khẩu tài khoản thành công');

        // Ghi thông báo bảo mật
        DB::table('thong_bao')->insert([
            'id_nguoi_dung' => $nguoiDung->id,
            'loai'          => 'bao_mat',
            'tieu_de'       => '🔒 Đổi mật khẩu thành công',
            'noi_dung'      => 'Mật khẩu của bạn đã được thay đổi vào lúc ' . now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') . '. Nếu không phải bạn thực hiện, vui lòng liên hệ quản trị viên ngay lập tức.',
            'url_lien_ket'  => null,
            'da_doc'        => 0,
            'khoa_trung'    => null,
            'ngay_tao'      => now(),
        ]);

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Thay đổi mật khẩu thành công.'
        ]);
    }

    /**
     * Bật/tắt trạng thái nhận thông báo.
     */
    public function doiThongBao(Request $request)
    {
        $nguoiDung = Auth::user();

        $thongBaoBat = $request->input('thong_bao_bat') ? 1 : 0;

        DB::table('nguoi_dung')
            ->where('id', $nguoiDung->id)
            ->update([
                'thong_bao_bat' => $thongBaoBat,
                'ngay_cap_nhat' => now()
            ]);

        $moTa = $thongBaoBat ? 'Bật nhận thông báo hệ thống' : 'Tắt nhận thông báo hệ thống';
        self::ghiLog($nguoiDung->id, 'chinh_sua', $moTa);

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Cập nhật cấu hình thông báo thành công.',
            'thong_bao_bat' => $thongBaoBat
        ]);
    }

    /**
     * Xóa tài khoản (xóa mềm).
     */
    public function xoaTaiKhoan(Request $request)
    {
        $nguoiDung = Auth::user();

        $xacNhan = strtolower(trim($request->input('xac_nhan') ?? ''));

        if ($xacNhan !== 'delete') {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => 'Vui lòng nhập chính xác chữ "delete" để xác nhận xóa.'
            ], 422);
        }

        self::ghiLog($nguoiDung->id, 'bao_mat', 'Yêu cầu xóa tài khoản (xóa mềm) thành công');

        // Thực hiện xóa mềm
        DB::table('nguoi_dung')
            ->where('id', $nguoiDung->id)
            ->update([
                'trang_thai' => 'da_xoa',
                'ngay_xoa' => now(),
                'ngay_cap_nhat' => now()
            ]);

        // Đăng xuất người dùng và hủy session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Tài khoản của bạn đã được xóa thành công.'
        ]);
    }

    /**
     * Gửi đóng góp ý kiến.
     */
    public function guiDongGopYKien(Request $request)
    {
        $nguoiDung = Auth::user();

        $request->validate([
            'noi_dung' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'noi_dung.required' => 'Nội dung đóng góp không được để trống.',
            'noi_dung.min' => 'Nội dung đóng góp phải từ 10 ký tự trở lên.',
            'noi_dung.max' => 'Nội dung đóng góp không được vượt quá 1000 ký tự.',
        ]);

        DB::table('dong_gop_y_kien')->insert([
            'id_nguoi_dung' => $nguoiDung->id,
            'noi_dung' => $request->input('noi_dung'),
            'ngay_tao' => now()
        ]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Gửi ý kiến đóng góp thành công');

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Cảm ơn ý kiến đóng góp quý báu của bạn!'
        ]);
    }
}
