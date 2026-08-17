<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YKienNguoiDungController extends Controller
{
    /**
     * Hiển thị danh sách ý kiến đóng góp của người dùng.
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

        $search = $request->input('search');
        $thang  = $request->get('thang', '');
        $nam    = $request->get('nam', '');

        $query = DB::table('dong_gop_y_kien')
            ->join('nguoi_dung', 'dong_gop_y_kien.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->select('dong_gop_y_kien.*', 'nguoi_dung.ho_ten', 'nguoi_dung.email', 'nguoi_dung.ma_nguoi_dung');

        // Tìm kiếm theo tên người dùng, email, mã người dùng hoặc nội dung đóng góp
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nguoi_dung.ho_ten', 'like', '%' . $search . '%')
                  ->orWhere('nguoi_dung.email', 'like', '%' . $search . '%')
                  ->orWhere('nguoi_dung.ma_nguoi_dung', 'like', '%' . $search . '%')
                  ->orWhere('dong_gop_y_kien.noi_dung', 'like', '%' . $search . '%');
            });
        }

        if ($thang !== '') {
            $query->whereMonth('dong_gop_y_kien.ngay_tao', $thang);
        }

        if ($nam !== '') {
            $query->whereYear('dong_gop_y_kien.ngay_tao', $nam);
        }

        // Phân trang mặc định là 100 hàng mỗi trang
        $danhSachDongGop = $query->orderBy('dong_gop_y_kien.ngay_tao', 'desc')
            ->paginate(100)
            ->withQueryString();

        // Lấy danh sách các năm đóng góp từ DB
        $danhSachNam = DB::table('dong_gop_y_kien')
            ->selectRaw('YEAR(ngay_tao) as year')
            ->whereNotNull('ngay_tao')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($danhSachNam)) {
            $danhSachNam = [date('Y')];
        }

        return view('admin.y-kien-nguoi-dung', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'search', 'thang', 'nam', 'danhSachNam', 'danhSachDongGop'
        ));
    }

    /**
     * Xóa ý kiến đóng góp của người dùng.
     */
    public function destroy($id)
    {
        $feedback = DB::table('dong_gop_y_kien')->where('id', $id)->first();
        if ($feedback) {
            DB::table('dong_gop_y_kien')->where('id', $id)->delete();
            Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã xóa ý kiến đóng góp ID: ' . $id);
            return redirect()->back()->with('thanh_cong', 'Xóa ý kiến đóng góp thành công.');
        }

        return redirect()->back()->with('error', 'Không tìm thấy ý kiến đóng góp.');
    }
}
