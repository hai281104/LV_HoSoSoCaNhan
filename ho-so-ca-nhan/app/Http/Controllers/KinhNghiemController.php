<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KinhNghiemController extends Controller
{
    /**
     * Hiển thị trang Kinh nghiệm làm việc.
     */
    public function index()
    {
        $nguoiDung = Auth::user();

        // Tạo chữ cái tắt cho sidebar
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

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
            $tenRutGon = 'ND';
        }

        // Lấy danh sách kinh nghiệm làm việc (không phân trang)
        $tatCaKinhNghiem = DB::table('kinh_nghiem')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('dang_lam_viec', 'desc')
            ->orderBy('ngay_ket_thuc', 'desc')
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();

        $tongSoKinhNghiem = $tatCaKinhNghiem->count();
        $dangLamViecCount = $tatCaKinhNghiem->where('dang_lam_viec', 1)->count();
        $daKetThucCount = $tongSoKinhNghiem - $dangLamViecCount;

        // Group kinh nghiệm theo khoảng thời gian để hiển thị
        $danhSachKinhNghiem = $tatCaKinhNghiem->groupBy(function ($item) {
            $batDau = date('m/Y', strtotime($item->ngay_bat_dau));
            $ketThuc = $item->dang_lam_viec ? 'Hiện tại' : ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại');
            return $batDau . ' - ' . $ketThuc;
        });

        return view('ho-so.kinh-nghiem', compact(
            'nguoiDung',
            'hoTen',
            'chucDanh',
            'anhDaiDien',
            'tenRutGon',
            'danhSachKinhNghiem',
            'tatCaKinhNghiem',
            'tongSoKinhNghiem',
            'dangLamViecCount',
            'daKetThucCount'
        ));
    }

    /**
     * Lưu thông tin kinh nghiệm làm việc (Thêm mới hoặc Cập nhật).
     */
    public function luuKinhNghiem(Request $request)
    {
        $nguoiDung = Auth::user();

        $request->validate([
            'vi_tri_cong_viec' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s]+$/u'],
            'ten_cong_ty'      => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s]+$/u'],
            'ngay_bat_dau'     => ['required', 'date'],
            'ngay_ket_thuc'    => [$request->input('dang_lam_viec') != 1 ? 'required' : 'nullable', 'date', 'after_or_equal:ngay_bat_dau'],
            'dang_lam_viec'    => ['nullable', 'in:0,1'],
            'mo_ta_chi_tiet'   => ['nullable', 'string', 'max:1000'],
        ], [
            'vi_tri_cong_viec.required' => 'Vị trí công việc là bắt buộc.',
            'vi_tri_cong_viec.min'      => 'Vị trí công việc phải từ 2 đến 100 ký tự.',
            'vi_tri_cong_viec.max'      => 'Vị trí công việc phải từ 2 đến 100 ký tự.',
            'vi_tri_cong_viec.regex'    => 'Vị trí công việc không được chứa ký tự đặc biệt.',
            'ten_cong_ty.required'      => 'Tên công ty là bắt buộc.',
            'ten_cong_ty.min'           => 'Tên công ty phải từ 2 đến 100 ký tự.',
            'ten_cong_ty.max'           => 'Tên công ty phải từ 2 đến 100 ký tự.',
            'ten_cong_ty.regex'         => 'Tên công ty không được chứa ký tự đặc biệt.',
            'ngay_bat_dau.required'     => 'Ngày bắt đầu là bắt buộc.',
            'ngay_bat_dau.date'         => 'Ngày bắt đầu không đúng định dạng.',
            'ngay_ket_thuc.required'    => 'Ngày kết thúc là bắt buộc khi không tích chọn Đang làm việc.',
            'ngay_ket_thuc.date'        => 'Ngày kết thúc không đúng định dạng.',
            'ngay_ket_thuc.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
            'mo_ta_chi_tiet.max'        => 'Mô tả chi tiết không được vượt quá 1000 ký tự.',
        ]);

        $id = $request->input('id');
        $dangLamViec = (int)$request->input('dang_lam_viec', 0);

        $data = [
            'vi_tri_cong_viec' => $request->input('vi_tri_cong_viec'),
            'ten_cong_ty'      => $request->input('ten_cong_ty'),
            'ngay_bat_dau'     => $request->input('ngay_bat_dau'),
            'ngay_ket_thuc'    => $dangLamViec !== 1 ? $request->input('ngay_ket_thuc') : null,
            'dang_lam_viec'    => $dangLamViec,
            'mo_ta_chi_tiet'   => $request->input('mo_ta_chi_tiet') ?: null,
        ];

        try {
            if ($id) {
                // Cập nhật
                $exists = DB::table('kinh_nghiem')
                    ->where('id', $id)
                    ->where('id_nguoi_dung', $nguoiDung->id)
                    ->exists();

                if (!$exists) {
                    return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông tin kinh nghiệm để cập nhật.'], 403);
                }

                DB::table('kinh_nghiem')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật kinh nghiệm làm việc: ' . $data['vi_tri_cong_viec'] . ' tại ' . $data['ten_cong_ty']);
                $msg = 'Cập nhật kinh nghiệm làm việc thành công!';
            } else {
                // Thêm mới
                $data['id_nguoi_dung'] = $nguoiDung->id;
                DB::table('kinh_nghiem')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới kinh nghiệm làm việc: ' . $data['vi_tri_cong_viec'] . ' tại ' . $data['ten_cong_ty']);
                $msg = 'Thêm mới kinh nghiệm làm việc thành công!';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa kinh nghiệm làm việc.
     */
    public function xoaKinhNghiem($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('kinh_nghiem')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông tin kinh nghiệm để xóa.'], 403);
            }

            $kn = DB::table('kinh_nghiem')->where('id', $id)->first();
            DB::table('kinh_nghiem')->where('id', $id)->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa kinh nghiệm làm việc: ' . ($kn ? $kn->vi_tri_cong_viec . ' tại ' . $kn->ten_cong_ty : 'ID ' . $id));
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa kinh nghiệm làm việc thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bật/tắt trạng thái nổi bật của mục kinh nghiệm.
     */
    public function toggleNoiBat($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('kinh_nghiem')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy mục kinh nghiệm.'], 403);
            }

            $newValue = $record->noi_bat ? 0 : 1;
            DB::table('kinh_nghiem')->where('id', $id)->update(['noi_bat' => $newValue]);

            $statusText = $newValue ? 'nổi bật' : 'thường';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Đã chuyển kinh nghiệm tại '{$record->ten_cong_ty}' sang chế độ {$statusText}");

            return response()->json([
                'thanh_cong' => true,
                'noi_bat' => $newValue,
                'thong_bao' => $newValue ? 'Đã đánh dấu nổi bật!' : 'Đã bỏ đánh dấu nổi bật.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}
