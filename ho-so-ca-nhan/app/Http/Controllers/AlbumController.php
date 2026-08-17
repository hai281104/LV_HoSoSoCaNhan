<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    /**
     * Hiển thị danh sách Album sự kiện.
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

        // Lấy tất cả sự kiện của người dùng, sắp xếp theo ngày diễn ra giảm dần
        $tatCaSuKien = DB::table('album_su_kien')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $tongSoSuKien = $tatCaSuKien->count();
        $tongSoAnh = 0;
        $thangGanNhat = 'Chưa có';

        if ($tongSoSuKien > 0) {
            // Lấy tháng sự kiện mới nhất
            $latestEvent = $tatCaSuKien->first();
            $timeLatest = strtotime($latestEvent->ngay_dien_ra);
            $thangGanNhat = 'Tháng ' . date('n', $timeLatest) . ' · ' . date('Y', $timeLatest);
        }

        // Truy vấn danh sách ảnh cho từng sự kiện
        foreach ($tatCaSuKien as $sk) {
            $sk->anh_danh_sach = DB::table('album_hinh_anh')
                ->where('id_album', $sk->id)
                ->orderBy('thu_tu', 'asc')
                ->get();
            $tongSoAnh += $sk->anh_danh_sach->count();
        }

        // Group sự kiện theo Tháng/Năm
        $danhSachAlbumGrouped = $tatCaSuKien->groupBy(function ($item) {
            $time = strtotime($item->ngay_dien_ra);
            $month = date('n', $time);
            $year = date('Y', $time);
            return "Tháng {$month} · {$year}";
        });

        return view('ho-so.album', compact(
            'nguoiDung',
            'hoTen',
            'chucDanh',
            'anhDaiDien',
            'tenRutGon',
            'danhSachAlbumGrouped',
            'tatCaSuKien',
            'tongSoSuKien',
            'tongSoAnh',
            'thangGanNhat'
        ));
    }

    /**
     * Lưu thông tin Album sự kiện mới hoặc Cập nhật Album hiện tại.
     */
    public function luuAlbum(Request $request)
    {
        $nguoiDung = Auth::user();

        $request->validate([
            'ten_su_kien'  => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s\-_]+$/u'],
            'mo_ta'        => ['nullable', 'string', 'max:1000'],
            'ngay_su_kien' => ['required', 'date'],
        ], [
            'ten_su_kien.required'  => 'Tên sự kiện là bắt buộc.',
            'ten_su_kien.min'       => 'Tên sự kiện phải từ 2 đến 100 ký tự.',
            'ten_su_kien.max'       => 'Tên sự kiện phải từ 2 đến 100 ký tự.',
            'ten_su_kien.regex'     => 'Tên sự kiện không được chứa ký tự đặc biệt.',
            'mo_ta.max'             => 'Mô tả chi tiết không được vượt quá 1000 ký tự.',
            'ngay_su_kien.required' => 'Ngày sự kiện là bắt buộc.',
            'ngay_su_kien.date'     => 'Ngày sự kiện không đúng định dạng.',
        ]);

        $id = $request->input('id');
        $tenSuKien = $request->input('ten_su_kien');
        $moTa = $request->input('mo_ta') ?: null;
        $ngaySuKien = $request->input('ngay_su_kien');

        // Lấy danh sách ảnh cũ được giữ lại
        $anhCu = $request->input('anh_cu', []); // Mảng các URL/đường dẫn ảnh cũ
        if (!is_array($anhCu)) {
            $anhCu = [];
        }

        // Lấy danh sách ảnh mới tải lên
        $anhMoi = $request->file('anh_moi', []);
        if (!is_array($anhMoi)) {
            $anhMoi = [];
        }

        // Validate số lượng ảnh: tối thiểu 1, tối đa 5
        $tongSoAnh = count($anhCu) + count($anhMoi);
        if ($tongSoAnh < 1) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Sự kiện phải có tối thiểu 1 ảnh minh họa.'], 422);
        }
        if ($tongSoAnh > 5) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Sự kiện chỉ được có tối đa 5 ảnh minh họa.'], 422);
        }

        // Validate các file ảnh mới tải lên
        foreach ($anhMoi as $file) {
            if (!$file->isValid()) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'File ảnh tải lên bị lỗi.'], 422);
            }
            if ($file->getSize() > 2 * 1024 * 1024) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Dung lượng mỗi ảnh không được vượt quá 2MB.'], 422);
            }
            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($mime, $allowedMimes)) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Định dạng ảnh không hợp lệ. Chỉ hỗ trợ JPG, PNG, WebP.'], 422);
            }
        }

        // Tìm bản ghi cũ nếu là cập nhật
        $oldRecord = null;
        if ($id) {
            $oldRecord = DB::table('album_su_kien')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();
            if (!$oldRecord) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy sự kiện cần cập nhật.'], 403);
            }
        }

        DB::beginTransaction();
        try {
            $dataSuKien = [
                'tieu_de'       => $tenSuKien,
                'mo_ta'         => $moTa,
                'ngay_dien_ra'  => $ngaySuKien,
                'ngay_cap_nhat' => now(),
            ];

            if ($id) {
                // Cập nhật sự kiện
                DB::table('album_su_kien')->where('id', $id)->update($dataSuKien);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật album ảnh nổi bật: ' . $dataSuKien['tieu_de']);
                $idAlbum = $id;

                // Xóa các ảnh cũ không được giữ lại
                $imagesToKeep = [];
                $currentImages = DB::table('album_hinh_anh')->where('id_album', $idAlbum)->get();

                foreach ($currentImages as $img) {
                    if (in_array($img->url_hinh_anh, $anhCu)) {
                        $imagesToKeep[] = $img->id;
                    } else {
                        // Xóa file ảnh vật lý
                        if (file_exists(public_path($img->url_hinh_anh))) {
                            @unlink(public_path($img->url_hinh_anh));
                        }
                    }
                }

                // Delete records from table that are not kept
                DB::table('album_hinh_anh')
                    ->where('id_album', $idAlbum)
                    ->whereNotIn('id', $imagesToKeep)
                    ->delete();

                $msg = 'Cập nhật sự kiện thành công!';
            } else {
                // Thêm mới sự kiện
                $dataSuKien['id_nguoi_dung'] = $nguoiDung->id;
                $dataSuKien['ngay_tao'] = now();
                $idAlbum = DB::table('album_su_kien')->insertGetId($dataSuKien);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới album ảnh nổi bật: ' . $dataSuKien['tieu_de']);
                $msg = 'Đăng sự kiện mới thành công!';
            }

            // Xử lý upload ảnh mới
            $uploadDir = public_path('uploads/album/');
            if (!file_exists($uploadDir)) {
                if (!@mkdir($uploadDir, 0755, true)) {
                    throw new \Exception('Không thể tạo thư mục lưu trữ ảnh album. Vui lòng kiểm tra quyền ghi thư mục public/uploads/ trên host.');
                }
            }

            if (!is_writable($uploadDir)) {
                throw new \Exception('Thư mục uploads/album/ không có quyền ghi. Vui lòng CHMOD thư mục này thành 755 hoặc 777.');
            }

            // Lấy thứ tự hiện tại của các ảnh cũ được giữ lại
            $thuTu = 0;
            $keptImages = DB::table('album_hinh_anh')
                ->where('id_album', $idAlbum)
                ->orderBy('thu_tu', 'asc')
                ->get();
            
            // Cập nhật thứ tự các ảnh được giữ lại
            foreach ($keptImages as $kImg) {
                DB::table('album_hinh_anh')
                    ->where('id', $kImg->id)
                    ->update(['thu_tu' => $thuTu++]);
            }

            // Lưu các ảnh mới
            foreach ($anhMoi as $file) {
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $fileName);
                $path = 'uploads/album/' . $fileName;

                DB::table('album_hinh_anh')->insert([
                    'id_album'     => $idAlbum,
                    'url_hinh_anh' => $path,
                    'thu_tu'       => $thuTu++,
                    'ngay_tao'     => now()
                ]);
            }

            DB::commit();
            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa Album sự kiện.
     */
    public function xoaAlbum($id)
    {
        $nguoiDung = Auth::user();

        $suKien = DB::table('album_su_kien')
            ->where('id', $id)
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->first();

        if (!$suKien) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy sự kiện để xóa.'], 403);
        }

        DB::beginTransaction();
        try {
            // Lấy danh sách tất cả ảnh đính kèm
            $anhDanhSach = DB::table('album_hinh_anh')->where('id_album', $id)->get();
            
            // Xóa file ảnh vật lý
            foreach ($anhDanhSach as $img) {
                if (file_exists(public_path($img->url_hinh_anh))) {
                    @unlink(public_path($img->url_hinh_anh));
                }
            }

            // Xóa các dòng trong CSDL (khóa ngoại cascades nếu cấu hình cascade, nhưng thực hiện thủ công cho chắc chắn)
            DB::table('album_hinh_anh')->where('id_album', $id)->delete();
            DB::table('album_su_kien')->where('id', $id)->delete();

            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa album ảnh nổi bật: ' . $suKien->tieu_de);

            DB::commit();
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa sự kiện thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa sự kiện: ' . $e->getMessage()], 500);
        }
    }
}
