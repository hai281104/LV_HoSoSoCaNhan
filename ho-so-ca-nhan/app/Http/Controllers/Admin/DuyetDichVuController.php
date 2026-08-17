<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DuyetDichVuController extends Controller
{
    /**
     * Helper tạo tên rút gọn cho avatar chữ cái.
     */
    private function getTenRutGon($hoTen)
    {
        if ($hoTen) {
            $cacTu = explode(' ', trim($hoTen));
            if (count($cacTu) >= 2) {
                $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
            } else {
                $tenRutGon = mb_substr($hoTen, 0, 2);
            }
            return mb_strtoupper($tenRutGon);
        }
        return 'AD';
    }

    /**
     * Hiển thị trang duyệt dịch vụ admin.
     */
    public function index(Request $request)
    {
        $nguoiDung = Auth::user();
        $hoTen     = $nguoiDung->ho_ten;
        $chucDanh  = $nguoiDung->chuc_danh ?? 'Quản trị viên';
        $anhDaiDien = $nguoiDung->anh_dai_dien;
        $tenRutGon = $this->getTenRutGon($hoTen);

        $tab     = $request->get('tab', 'cho_duyet');
        $search  = trim($request->get('search', ''));
        $thang   = $request->get('thang', '');
        $nam     = $request->get('nam', '');
        $linhVuc = $request->get('linh_vuc', '');

        // Map tab -> trang_thai_duyet
        $trangThaiMap = [
            'cho_duyet'  => 0,
            'da_duyet'   => 1,
            'tu_choi'    => 2,
        ];

        $trangThaiDuyet = $trangThaiMap[$tab] ?? 0;

        $query = DB::table('dich_vu_ca_nhan')
            ->join('nguoi_dung', 'dich_vu_ca_nhan.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->where('dich_vu_ca_nhan.trang_thai_duyet', $trangThaiDuyet)
            ->select(
                'dich_vu_ca_nhan.*',
                'nguoi_dung.ho_ten as ten_nguoi_dung',
                'nguoi_dung.ma_nguoi_dung',
                'nguoi_dung.email as email_nguoi_dung',
                'nguoi_dung.anh_dai_dien as anh_nguoi_dung'
            );

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('dich_vu_ca_nhan.ten_dich_vu', 'like', "%{$search}%")
                  ->orWhere('nguoi_dung.ho_ten', 'like', "%{$search}%")
                  ->orWhere('nguoi_dung.ma_nguoi_dung', 'like', "%{$search}%");
            });
        }

        if ($thang !== '') {
            $query->whereMonth('dich_vu_ca_nhan.ngay_tao', $thang);
        }

        if ($nam !== '') {
            $query->whereYear('dich_vu_ca_nhan.ngay_tao', $nam);
        }

        if ($linhVuc !== '') {
            $query->where('dich_vu_ca_nhan.phan_loai', $linhVuc);
        }

        $danhSachDichVu = $query->orderBy('dich_vu_ca_nhan.ngay_tao', 'desc')
            ->paginate(100)
            ->appends(['tab' => $tab, 'search' => $search, 'thang' => $thang, 'nam' => $nam, 'linh_vuc' => $linhVuc]);

        $catMap = [
            'lap_trinh_web' => 'Lập trình Web',
            'toi_uu_sql' => 'Tối ưu SQL/Database',
            'thiet_ke_uiux' => 'Thiết kế UI/UX',
            'lap_trinh_mobile' => 'Lập trình Mobile',
            'devops_cloud' => 'DevOps & Cloud',
            'kiem_thu' => 'Kiểm thử phần mềm',
            'an_ninh_mang' => 'An ninh mạng / Bảo mật',
            'phan_tich_du_lieu' => 'Phân tích dữ liệu (Data Analysis)',
            'tri_tue_nhan_tao' => 'Trí tuệ nhân tạo (AI/Machine Learning)',
            'viet_lach_content' => 'Viết lách / Biên dịch content',
            'quan_tri_du_an' => 'Quản trị dự án (Project Management)',
            'khac' => 'Lĩnh vực khác'
        ];

        // Đếm số lượng mỗi tab để hiện badge
        $soCho  = DB::table('dich_vu_ca_nhan')->where('trang_thai_duyet', 0)->count();
        $soDuyet = DB::table('dich_vu_ca_nhan')->where('trang_thai_duyet', 1)->count();
        $soTuChoi = DB::table('dich_vu_ca_nhan')->where('trang_thai_duyet', 2)->count();

        // Lấy danh sách các năm đăng bài từ DB
        $danhSachNam = DB::table('dich_vu_ca_nhan')
            ->selectRaw('YEAR(ngay_tao) as year')
            ->whereNotNull('ngay_tao')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($danhSachNam)) {
            $danhSachNam = [date('Y')];
        }

        return view('admin.duyet-dich-vu', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'danhSachDichVu', 'tab', 'search', 'thang', 'nam', 'linhVuc', 'danhSachNam',
            'soCho', 'soDuyet', 'soTuChoi', 'catMap'
        ));
    }

    /**
     * Duyệt dịch vụ (chuyển sang trang_thai_duyet = 1 và trang_thai = 1 để hiện lên cộng đồng).
     */
    public function duyet($id)
    {
        try {
            $dichVu = DB::table('dich_vu_ca_nhan')->where('id', $id)->first();
            if (!$dichVu) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dịch vụ.'], 404);
            }

            DB::table('dich_vu_ca_nhan')->where('id', $id)->update([
                'trang_thai_duyet' => 1,
                'ly_do_tu_choi'    => null,
                'trang_thai'       => 1, // Hiển thị lên cộng đồng
                'ngay_cap_nhat'    => now(),
            ]);

            // Ghi nhật ký
            self::ghiLog(Auth::id(), 'chinh_sua', 'Admin duyệt dịch vụ: ' . $dichVu->ten_dich_vu . ' (ID: ' . $id . ')');

            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Đã duyệt dịch vụ thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Từ chối dịch vụ (trang_thai_duyet = 2).
     */
    public function tuChoi($id)
    {
        try {
            $dichVu = DB::table('dich_vu_ca_nhan')->where('id', $id)->first();
            if (!$dichVu) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dịch vụ.'], 404);
            }

            DB::table('dich_vu_ca_nhan')->where('id', $id)->update([
                'trang_thai_duyet' => 2,
                'ly_do_tu_choi'    => null,
                'trang_thai'       => 0, // Ẩn khỏi cộng đồng
                'ngay_cap_nhat'    => now(),
            ]);

            // Ghi nhật ký
            self::ghiLog(Auth::id(), 'chinh_sua', 'Admin từ chối dịch vụ: ' . $dichVu->ten_dich_vu . ' (ID: ' . $id . ')');

            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Đã từ chối dịch vụ.']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}
