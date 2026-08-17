<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NhatKyController extends Controller
{
    /**
     * Hiển thị danh sách nhật ký hoạt động.
     */
    public function index(Request $request)
    {
        $nguoiDung = Auth::user();
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

        // Tạo chữ cái viết tắt từ họ tên để hiển thị avatar
        $tenRutGon = 'ND';
        if ($hoTen) {
            $cacTu = explode(' ', trim($hoTen));
            if (count($cacTu) >= 2) {
                $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
            } else {
                $tenRutGon = mb_substr($hoTen, 0, 2);
            }
            $tenRutGon = mb_strtoupper($tenRutGon);
        }

        // Lọc theo loại hoạt động
        $loai = $request->input('loai');
        
        $query = DB::table('nhat_ky_hoat_dong')
            ->where('id_nguoi_dung', $nguoiDung->id);

        // Tính toán các số liệu thống kê trước khi áp dụng bộ lọc
        $stats = DB::table('nhat_ky_hoat_dong')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->select('loai_hoat_dong', DB::raw('count(*) as total'))
            ->groupBy('loai_hoat_dong')
            ->pluck('total', 'loai_hoat_dong')
            ->toArray();
        $soTong = array_sum($stats);
        $soTruyCap = $stats['truy_cap'] ?? 0;
        $soChinhSua = $stats['chinh_sua'] ?? 0;
        $soBaoMat = $stats['bao_mat'] ?? 0;

        if ($loai && in_array($loai, ['truy_cap', 'chinh_sua', 'bao_mat'])) {
            $query->where('loai_hoat_dong', $loai);
        }

        $danhSachLog = $query->orderBy('ngay_tao', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Ghi lại hoạt động xem nhật ký
        self::ghiLog($nguoiDung->id, 'truy_cap', 'Đã xem danh sách nhật ký hoạt động cá nhân');

        return view('ho-so.nhat-ky', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon', 'danhSachLog', 'loai',
            'soTong', 'soTruyCap', 'soChinhSua', 'soBaoMat'
        ));
    }

    /**
     * Xóa toàn bộ nhật ký của người dùng.
     */
    public function xoaNhatKy()
    {
        $nguoiDung = Auth::user();
        
        DB::table('nhat_ky_hoat_dong')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->delete();

        self::ghiLog($nguoiDung->id, 'bao_mat', 'Đã xóa toàn bộ lịch sử nhật ký hoạt động');

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Đã xóa sạch nhật ký hoạt động thành công!',
        ]);
    }
}
