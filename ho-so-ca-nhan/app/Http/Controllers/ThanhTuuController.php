<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThanhTuuController extends Controller
{
    /**
     * Hiển thị trang danh sách Thành tựu.
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

        // Lấy danh sách thành tựu
        $danhSachThanhTuu = DB::table('thanh_tuu')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('id', 'desc')
            ->get();

        // Tính toán thống kê
        $tongSoThanhTuu = $danhSachThanhTuu->count();
        $giaiThuongCount = $danhSachThanhTuu->where('phan_loai', 'giai_thuong')->count();
        $hocBongCount = $danhSachThanhTuu->where('phan_loai', 'hoc_bong')->count();
        $danhHieuCount = $danhSachThanhTuu->where('phan_loai', 'danh_hieu')->count();

        return view('ho-so.thanh-tuu', compact(
            'nguoiDung', 
            'danhSachThanhTuu', 
            'tenRutGon', 
            'hoTen', 
            'chucDanh', 
            'anhDaiDien',
            'tongSoThanhTuu',
            'giaiThuongCount',
            'hocBongCount',
            'danhHieuCount'
        ));
    }

    /**
     * Lưu hoặc cập nhật thông tin thành tựu.
     */
    public function luuThanhTuu(Request $request)
    {
        $nguoiDung = Auth::user();

        // Làm sạch dữ liệu đầu vào để ngăn chặn tấn công XSS
        if ($request->has('ten_thanh_tuu')) {
            $request->merge(['ten_thanh_tuu' => strip_tags(trim($request->input('ten_thanh_tuu')))]);
        }
        if ($request->has('to_chuc_cap')) {
            $request->merge(['to_chuc_cap' => strip_tags(trim($request->input('to_chuc_cap')))]);
        }

        $request->validate([
            'id'              => ['nullable', 'integer'],
            'ten_thanh_tuu'   => ['required', 'string', 'min:2', 'max:100'],
            'to_chuc_cap'     => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s,\.\-\(\)\/\+&]+$/u'],
            'thoi_gian'       => ['nullable', 'string', 'max:50', 'regex:/^[\p{L}\p{N}\s\-_:\.\/\(\)]+$/u'],
            'phan_loai'       => ['required', 'string', 'in:giai_thuong,hoc_bong,danh_hieu'],
            'mo_ta'           => ['nullable', 'string', 'max:500'],
            'anh_minh_hoa'    => ['nullable', 'string'],
            'link_minh_chung' => ['nullable', 'url', 'max:500'],
        ], [
            'ten_thanh_tuu.required' => 'Tên thành tựu không được để trống.',
            'ten_thanh_tuu.min'      => 'Tên thành tựu phải từ 2 ký tự trở lên.',
            'ten_thanh_tuu.max'      => 'Tên thành tựu không được vượt quá 100 ký tự.',
            'to_chuc_cap.min'        => 'Đơn vị trao phải từ 2 ký tự trở lên.',
            'to_chuc_cap.max'        => 'Đơn vị trao không được vượt quá 100 ký tự.',
            'to_chuc_cap.regex'      => 'Đơn vị trao không được chứa ký tự đặc biệt lạ.',
            'thoi_gian.max'          => 'Thời gian đạt được không được vượt quá 50 ký tự.',
            'thoi_gian.regex'        => 'Thời gian đạt được không được chứa ký tự đặc biệt lạ (chỉ hỗ trợ chữ, số, gạch ngang, gạch chéo, và dấu ngoặc).',
            'phan_loai.required'     => 'Phân loại thành tựu là bắt buộc.',
            'phan_loai.in'           => 'Phân loại thành tựu không hợp lệ.',
            'mo_ta.max'              => 'Mô tả chi tiết không được vượt quá 500 ký tự.',
            'link_minh_chung.url'    => 'Liên kết minh chứng phải là định dạng URL hợp lệ (VD: https://example.com).',
            'link_minh_chung.max'    => 'Liên kết minh chứng không được vượt quá 500 ký tự.',
        ]);

        $id = $request->input('id');
        $tenThanhTuu = $request->input('ten_thanh_tuu');
        $toChucCap   = $request->input('to_chuc_cap') ?: null;
        $thoiGian    = $request->input('thoi_gian') ?: null;
        $phanLoai    = $request->input('phan_loai');
        $moTa        = $request->input('mo_ta') ?: null;
        $anhMinhHoa  = $request->input('anh_minh_hoa');
        $linkMinhChung = $request->input('link_minh_chung') ?: null;

        // Tìm xem bản ghi cũ có tồn tại không
        $oldRecord = null;
        if ($id) {
            $oldRecord = DB::table('thanh_tuu')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$oldRecord) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thành tựu cần cập nhật.'], 403);
            }
        }

        // Xử lý lưu ảnh bìa minh họa (crop base64)
        $savedImagePath = $oldRecord ? $oldRecord->anh_minh_hoa : null;

        if ($anhMinhHoa && preg_match('/^data:image\/(png|jpg|jpeg|webp);base64,/', $anhMinhHoa, $matches)) {
            // Có upload ảnh bìa mới
            $imageData = substr($anhMinhHoa, strpos($anhMinhHoa, ',') + 1);
            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không thể xử lý ảnh.'], 422);
            }

            // Kiểm tra kích thước (tối đa 2MB)
            if (strlen($imageData) > 2 * 1024 * 1024) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Kích thước ảnh bìa không được vượt quá 2MB.'], 422);
            }

            $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $fileName = Str::uuid() . '.' . $extension;
            $uploadDir = public_path('uploads/thanh-tuu/');

            try {
                if (!file_exists($uploadDir)) {
                    if (!@mkdir($uploadDir, 0755, true)) {
                        return response()->json([
                            'thanh_cong' => false,
                            'thong_bao' => 'Không thể tạo thư mục lưu trữ ảnh thành tựu. Vui lòng kiểm tra quyền ghi thư mục public/uploads/ trên host.'
                        ], 500);
                    }
                }

                if (!is_writable($uploadDir)) {
                    return response()->json([
                        'thanh_cong' => false,
                        'thong_bao' => 'Thư mục uploads/thanh-tuu/ không có quyền ghi. Vui lòng CHMOD thư mục này thành 755 hoặc 777.'
                    ], 500);
                }

                // Xóa ảnh cũ nếu có
                if ($savedImagePath && file_exists(public_path($savedImagePath))) {
                    @unlink(public_path($savedImagePath));
                }

                if (file_put_contents($uploadDir . $fileName, $imageData) === false) {
                    return response()->json([
                        'thanh_cong' => false,
                        'thong_bao' => 'Ghi tệp ảnh thành tựu thất bại. Vui lòng kiểm tra quyền ghi hoặc dung lượng host.'
                    ], 500);
                }
                $savedImagePath = 'uploads/thanh-tuu/' . $fileName;
            } catch (\Exception $e) {
                return response()->json([
                    'thanh_cong' => false,
                    'thong_bao' => 'Lỗi khi lưu ảnh thành tựu lên host: ' . $e->getMessage()
                ], 500);
            }

        } else if (empty($anhMinhHoa) && $request->has('anh_minh_hoa')) {
            // Người dùng muốn xóa ảnh bìa cũ
            if ($savedImagePath && file_exists(public_path($savedImagePath))) {
                @unlink(public_path($savedImagePath));
            }
            $savedImagePath = null;
        }

        $data = [
            'ten_thanh_tuu'   => $tenThanhTuu,
            'to_chuc_cap'     => $toChucCap,
            'thoi_gian'       => $thoiGian,
            'phan_loai'       => $phanLoai,
            'mo_ta'           => $moTa,
            'anh_minh_hoa'    => $savedImagePath,
            'link_minh_chung' => $linkMinhChung,
        ];

        try {
            if ($id) {
                DB::table('thanh_tuu')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật thành tựu: ' . $data['ten_thanh_tuu']);
                $msg = 'Cập nhật thành tựu thành công!';
            } else {
                $data['id_nguoi_dung'] = $nguoiDung->id;
                DB::table('thanh_tuu')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới thành tựu: ' . $data['ten_thanh_tuu']);
                $msg = 'Thêm mới thành tựu thành công!';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa thông tin thành tựu.
     */
    public function xoaThanhTuu($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('thanh_tuu')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thành tựu để xóa.'], 403);
            }

            // Xóa ảnh bìa đính kèm nếu có
            if ($record->anh_minh_hoa && file_exists(public_path($record->anh_minh_hoa))) {
                @unlink(public_path($record->anh_minh_hoa));
            }

            DB::table('thanh_tuu')->where('id', $id)->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa thành tựu: ' . $record->ten_thanh_tuu);
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa thành tựu thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bật/tắt trạng thái nổi bật của mục thành tựu.
     */
    public function toggleNoiBat($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('thanh_tuu')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thành tựu.'], 403);
            }

            $newValue = $record->noi_bat ? 0 : 1;
            DB::table('thanh_tuu')->where('id', $id)->update(['noi_bat' => $newValue]);

            $statusText = $newValue ? 'nổi bật' : 'thường';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Đã chuyển thành tựu '{$record->ten_thanh_tuu}' sang chế độ {$statusText}");

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

