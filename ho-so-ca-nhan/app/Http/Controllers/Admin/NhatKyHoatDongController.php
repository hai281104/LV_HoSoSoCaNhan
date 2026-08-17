<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NhatKyHoatDongController extends Controller
{
    /**
     * Hiển thị danh sách nhật ký hoạt động của toàn hệ thống.
     */
    public function index(Request $request)
    {
        $nguoiDung = Auth::user();
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Quản trị viên';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

        // Tạo chữ cái tắt cho avatar
        $tenRutGon = '';
        if ($hoTen) {
            $cacTu = explode(' ', trim($hoTen));
            if (count($cacTu) >= 2) {
                $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
            } else {
                $tenRutGon = mb_substr($hoTen, 0, 2);
            }
            $tenRutGon = mb_strtoupper($tenRutGon);
        } else {
            $tenRutGon = 'AD';
        }

        $tab = $request->input('tab', 'tat_ca');
        $search = $request->input('search');
        $thang  = $request->get('thang', '');
        $nam    = $request->get('nam', '');

        $query = DB::table('nhat_ky_hoat_dong')
            ->join('nguoi_dung', 'nhat_ky_hoat_dong.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->select('nhat_ky_hoat_dong.*', 'nguoi_dung.ho_ten', 'nguoi_dung.email', 'nguoi_dung.ma_nguoi_dung');

        // Phân lọc theo Tab
        if ($tab && in_array($tab, ['truy_cap', 'chinh_sua', 'bao_mat'])) {
            $query->where('nhat_ky_hoat_dong.loai_hoat_dong', $tab);
        }

        // Tìm kiếm theo tên người dùng, email, mã người dùng, hoặc mô tả hoạt động
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nguoi_dung.ho_ten', 'like', '%' . $search . '%')
                  ->orWhere('nguoi_dung.email', 'like', '%' . $search . '%')
                  ->orWhere('nguoi_dung.ma_nguoi_dung', 'like', '%' . $search . '%')
                  ->orWhere('nhat_ky_hoat_dong.mo_ta', 'like', '%' . $search . '%');
            });
        }

        if ($thang !== '') {
            $query->whereMonth('nhat_ky_hoat_dong.ngay_tao', $thang);
        }

        if ($nam !== '') {
            $query->whereYear('nhat_ky_hoat_dong.ngay_tao', $nam);
        }

        // Phân trang 100 hàng mỗi trang
        $danhSachLog = $query->orderBy('nhat_ky_hoat_dong.ngay_tao', 'desc')
            ->paginate(100)
            ->withQueryString();

        // Lấy danh sách các năm hoạt động từ DB
        $danhSachNam = DB::table('nhat_ky_hoat_dong')
            ->selectRaw('YEAR(ngay_tao) as year')
            ->whereNotNull('ngay_tao')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($danhSachNam)) {
            $danhSachNam = [date('Y')];
        }

        return view('admin.nhat-ky-hoat-dong', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'tab', 'search', 'thang', 'nam', 'danhSachNam', 'danhSachLog'
        ));
    }
}
