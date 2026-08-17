<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChungChiController extends Controller
{
    /**
     * Hiển thị trang Chứng chỉ & Chứng nhận.
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

        // Lấy danh sách chứng chỉ
        $danhSachChungChi = DB::table('chung_chi')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('ho-so.chung-chi', compact('nguoiDung', 'danhSachChungChi', 'tenRutGon', 'hoTen', 'chucDanh', 'anhDaiDien'));
    }

    /**
     * Lưu hoặc cập nhật thông tin chứng chỉ.
     */
    public function luuChungChi(Request $request)
    {
        $nguoiDung = Auth::user();

        // Sanitize input to prevent XSS
        if ($request->has('ten_chung_chi')) {
            $request->merge(['ten_chung_chi' => strip_tags(trim($request->input('ten_chung_chi')))]);
        }
        if ($request->has('to_chuc_cap')) {
            $request->merge(['to_chuc_cap' => strip_tags(trim($request->input('to_chuc_cap')))]);
        }

        $request->validate([
            'id'            => ['nullable', 'integer'],
            'ten_chung_chi' => ['required', 'string', 'min:2', 'max:100'],
            'to_chuc_cap'   => ['required', 'string', 'min:2', 'max:100'],
            'ma_chung_chi'  => ['nullable', 'string', 'max:50', 'regex:/^[\p{L}\p{N}\s\-_:\.\/]+$/u'],
            'ngay_cap'      => ['required', 'date'],
            'ngay_het_han'  => ['nullable', 'date', 'after_or_equal:ngay_cap'],
            'url_tap_tin'   => ['nullable', 'url', 'max:500'],
            'phan_loai'     => ['required', 'string', 'in:chuyen_mon,ngoai_ngu,ky_nang,khac'],
            'file_pdf'      => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'ten_chung_chi.required' => 'Tên chứng chỉ không được để trống.',
            'ten_chung_chi.min' => 'Tên chứng chỉ phải từ 2 ký tự trở lên.',
            'ten_chung_chi.max' => 'Tên chứng chỉ không được vượt quá 100 ký tự.',
            'to_chuc_cap.required' => 'Tổ chức cấp không được để trống.',
            'to_chuc_cap.min' => 'Tổ chức cấp phải từ 2 ký tự trở lên.',
            'to_chuc_cap.max' => 'Tổ chức cấp không được vượt quá 100 ký tự.',
            'ma_chung_chi.max' => 'Mã chứng chỉ không được vượt quá 50 ký tự.',
            'ma_chung_chi.regex' => 'Mã chứng chỉ không hợp lệ (chỉ chấp nhận chữ, số, khoảng trắng, gạch nối, dấu chấm, hai chấm, và dấu gạch chéo).',
            'ngay_cap.required' => 'Ngày cấp chứng chỉ là bắt buộc.',
            'ngay_cap.date' => 'Ngày cấp không đúng định dạng ngày.',
            'ngay_het_han.date' => 'Ngày hết hạn không đúng định dạng ngày.',
            'ngay_het_han.after_or_equal' => 'Ngày hết hạn phải lớn hơn hoặc bằng ngày cấp.',
            'url_tap_tin.url' => 'Liên kết tập tin phải là định dạng URL hợp lệ (VD: https://example.com/file.pdf).',
            'url_tap_tin.max' => 'Đường dẫn liên kết không được vượt quá 500 ký tự.',
            'phan_loai.required' => 'Phân loại chứng chỉ là bắt buộc.',
            'phan_loai.in' => 'Phân loại chứng chỉ không hợp lệ.',
            'file_pdf.file' => 'Tệp tải lên phải là một tệp tin.',
            'file_pdf.mimes' => 'Chứng chỉ tải lên phải có định dạng PDF.',
            'file_pdf.max' => 'Dung lượng tệp PDF không được vượt quá 5MB.',
        ]);

        $id = $request->input('id');
        $oldRecord = null;
        if ($id) {
            $oldRecord = DB::table('chung_chi')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();
            if (!$oldRecord) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy chứng chỉ cần cập nhật.'], 403);
            }
        }

        $data = [
            'ten_chung_chi' => $request->input('ten_chung_chi'),
            'to_chuc_cap'   => $request->input('to_chuc_cap'),
            'ma_chung_chi'  => $request->input('ma_chung_chi') ?: null,
            'ngay_cap'      => $request->input('ngay_cap'),
            'ngay_het_han'  => $request->input('ngay_het_han') ?: null,
            'url_tap_tin'   => $request->input('url_tap_tin') ?: null,
            'phan_loai'     => $request->input('phan_loai'),
        ];

        // Xử lý tệp PDF tải lên
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/chung-chi'), $fileName);
            $data['file_pdf'] = 'uploads/chung-chi/' . $fileName;

            // Xóa file cũ nếu có
            if ($oldRecord && $oldRecord->file_pdf) {
                $oldPath = public_path($oldRecord->file_pdf);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        try {
            if ($id) {
                // Cập nhật
                DB::table('chung_chi')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật chứng chỉ: ' . $data['ten_chung_chi']);
                $msg = 'Cập nhật chứng chỉ thành công!';
            } else {
                // Thêm mới
                $data['id_nguoi_dung'] = $nguoiDung->id;
                DB::table('chung_chi')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới chứng chỉ: ' . $data['ten_chung_chi']);
                $msg = 'Thêm mới chứng chỉ thành công!';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa thông tin chứng chỉ.
     */
    public function xoaChungChi($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('chung_chi')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy chứng chỉ để xóa.'], 403);
            }

            $cc = DB::table('chung_chi')->where('id', $id)->first();
            if ($cc && $cc->file_pdf) {
                $filePath = public_path($cc->file_pdf);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            DB::table('chung_chi')->where('id', $id)->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa chứng chỉ: ' . ($cc ? $cc->ten_chung_chi : 'ID ' . $id));
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa chứng chỉ thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bật/tắt trạng thái nổi bật của mục chứng chỉ.
     */
    public function toggleNoiBat($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('chung_chi')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy chứng chỉ.'], 403);
            }

            $newValue = $record->noi_bat ? 0 : 1;
            DB::table('chung_chi')->where('id', $id)->update(['noi_bat' => $newValue]);

            $statusText = $newValue ? 'nổi bật' : 'thường';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Đã chuyển chứng chỉ '{$record->ten_chung_chi}' sang chế độ {$statusText}");

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

