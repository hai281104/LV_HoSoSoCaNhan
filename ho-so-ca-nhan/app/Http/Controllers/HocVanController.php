<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HocVanController extends Controller
{
    /**
     * Hien thi trang hoc van va trinh do.
     */
    public function hocVan()
    {
        $nguoiDung = Auth::user();

        // Tao chu cai tat cho sidebar
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

        $danhSachHocVan = DB::table('hoc_van')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderByRaw('CASE WHEN trang_thai = "dang_hoc" OR nam_ket_thuc IS NULL THEN 1 ELSE 0 END DESC')
            ->orderBy('nam_ket_thuc', 'desc')
            ->orderBy('nam_bat_dau', 'desc')
            ->get();

        return view('ho-so.hoc-van', compact('nguoiDung', 'danhSachHocVan', 'tenRutGon', 'hoTen', 'chucDanh', 'anhDaiDien'));
    }

    /**
     * Luu hoac cap nhat thong tin hoc van.
     */
    public function luuHocVan(Request $request)
    {
        $nguoiDung = Auth::user();
        
        // Sanitize GPA (handle formats like "3.5/4", "8,5")
        $gpa = $request->input('gpa');
        if ($gpa !== null && $gpa !== '') {
            $gpa = str_replace(',', '.', $gpa);
            if (strpos($gpa, '/') !== false) {
                $gpa = explode('/', $gpa)[0];
            }
            $gpa = trim($gpa);
            $request->merge(['gpa' => $gpa]);
        }

        $request->validate([
            'id'            => ['nullable', 'integer'],
            'tieu_de'       => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\p{L}\p{N}\s,\.\-\(\)\/\+]+$/u'],
            'ten_truong'    => ['required', 'string', 'min:2', 'max:200', 'regex:/^[\p{L}\p{N}\s,\.\-\(\)\/\+]+$/u'],
            'nam_bat_dau'   => ['required', 'integer', 'min:1900', 'max:2100'],
            'nam_ket_thuc'  => [
                'required_unless:trang_thai,dang_hoc',
                'nullable',
                'integer',
                'gte:nam_bat_dau',
                'max:2100',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('trang_thai') === 'da_tot_nghiep' && $value > (int)date('Y')) {
                        $fail('Năm tốt nghiệp không thể lớn hơn năm hiện tại.');
                    }
                }
            ],
            'trang_thai'    => ['required', 'in:dang_hoc,da_tot_nghiep,bao_luu,tam_dung'],
            'xep_loai'      => ['nullable', 'in:Xuất sắc,Giỏi,Khá,Trung bình,Khác'],
            'gpa'           => ['nullable', 'numeric', 'between:0,10'],
            'khoa'          => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s,\.\-\(\)\/\+]+$/u'],
            'nganh'         => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s,\.\-\(\)\/\+]+$/u'],
            'mo_ta'         => ['nullable', 'string', 'max:1000'],
        ], [
            'tieu_de.required' => 'Tiêu đề bằng cấp / chứng chỉ không được để trống.',
            'tieu_de.min' => 'Tiêu đề phải từ 2 đến 50 ký tự.',
            'tieu_de.max' => 'Tiêu đề phải từ 2 đến 50 ký tự.',
            'tieu_de.regex' => 'Tiêu đề bằng cấp / chứng chỉ không được chứa ký tự đặc biệt lạ.',
            'ten_truong.required' => 'Tên trường / tổ chức đào tạo không được để trống.',
            'ten_truong.min' => 'Tên trường phải từ 2 đến 200 ký tự.',
            'ten_truong.max' => 'Tên trường phải từ 2 đến 200 ký tự.',
            'ten_truong.regex' => 'Tên trường / tổ chức đào tạo không được chứa ký tự đặc biệt lạ.',
            'nam_bat_dau.required' => 'Năm bắt đầu là bắt buộc.',
            'nam_bat_dau.integer' => 'Năm bắt đầu phải là số nguyên.',
            'nam_ket_thuc.required_unless' => 'Năm kết thúc là bắt buộc khi đã hoàn thành hoặc dừng học.',
            'nam_ket_thuc.integer' => 'Năm kết thúc phải là số nguyên.',
            'nam_ket_thuc.gte' => 'Năm kết thúc phải lớn hơn hoặc bằng năm bắt đầu.',
            'trang_thai.required' => 'Trạng thái học tập là bắt buộc.',
            'trang_thai.in' => 'Trạng thái học tập không hợp lệ.',
            'xep_loai.in' => 'Xếp loại học lực không hợp lệ.',
            'gpa.numeric' => 'GPA phải là giá trị số.',
            'gpa.between' => 'Điểm GPA phải nằm trong khoảng từ 0 đến 10.',
            'khoa.min' => 'Tên khoa phải từ 2 đến 100 ký tự.',
            'khoa.max' => 'Tên khoa phải từ 2 đến 100 ký tự.',
            'khoa.regex' => 'Tên khoa không được chứa ký tự đặc biệt lạ.',
            'nganh.min' => 'Tên ngành học phải từ 2 đến 100 ký tự.',
            'nganh.max' => 'Tên ngành học phải từ 2 đến 100 ký tự.',
            'nganh.regex' => 'Tên ngành học không được chứa ký tự đặc biệt lạ.',
            'mo_ta.max' => 'Mô tả chi tiết không được vượt quá 1000 ký tự.',
        ]);

        $id = $request->input('id');

        $data = [
            'tieu_de'       => $request->input('tieu_de'),
            'ten_truong'    => $request->input('ten_truong'),
            'nam_bat_dau'   => (int)$request->input('nam_bat_dau'),
            'nam_ket_thuc'  => $request->input('trang_thai') !== 'dang_hoc' ? (int)$request->input('nam_ket_thuc') : null,
            'xep_loai'      => $request->input('xep_loai') ?: null,
            'gpa'           => $request->input('gpa') !== null && $request->input('gpa') !== '' ? (float)$request->input('gpa') : null,
            'khoa'          => $request->input('khoa') ?: null,
            'nganh'         => $request->input('nganh') ?: null,
            'trang_thai'    => $request->input('trang_thai'),
            'mo_ta'         => $request->input('mo_ta') ?: null,
        ];

        try {
            if ($id) {
                // Update
                $exists = DB::table('hoc_van')
                    ->where('id', $id)
                    ->where('id_nguoi_dung', $nguoiDung->id)
                    ->exists();
                if (!$exists) {
                    return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông tin học vấn cần cập nhật.'], 403);
                }

                DB::table('hoc_van')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật học vấn: ' . $data['tieu_de'] . ' tại ' . $data['ten_truong']);
                $msg = 'Cập nhật học vấn thành công!';
            } else {
                // Insert
                $data['id_nguoi_dung'] = $nguoiDung->id;
                DB::table('hoc_van')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới học vấn: ' . $data['tieu_de'] . ' tại ' . $data['ten_truong']);
                $msg = 'Thêm mới học vấn thành công!';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    public function xoaHocVan($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('hoc_van')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông tin học vấn để xóa.'], 403);
            }

            $hv = DB::table('hoc_van')->where('id', $id)->first();
            DB::table('hoc_van')->where('id', $id)->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa học vấn: ' . ($hv ? $hv->tieu_de : 'ID ' . $id));
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa học vấn thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bật/tắt trạng thái nổi bật của mục học vấn.
     */
    public function toggleNoiBat($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('hoc_van')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy mục học vấn.'], 403);
            }

            $newValue = $record->noi_bat ? 0 : 1;
            DB::table('hoc_van')->where('id', $id)->update(['noi_bat' => $newValue]);

            $statusText = $newValue ? 'nổi bật' : 'thường';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Đã chuyển học vấn '{$record->tieu_de}' sang chế độ {$statusText}");

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
