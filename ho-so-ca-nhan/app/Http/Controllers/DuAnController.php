<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DuAnController extends Controller
{
    /**
     * Hien thi trang Portfolio du an.
     */
    public function index()
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

        // Lấy tất cả dự án không phân trang để thống kê và lọc
        $tatCaDuAn = DB::table('du_an')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->get();

        $tongSoDuAn = $tatCaDuAn->count();
        $dangThucHienCount = $tatCaDuAn->whereNull('ngay_ket_thuc')->count();
        $daHoanThanhCount = $tongSoDuAn - $dangThucHienCount;

        // Trích xuất danh sách công nghệ và số lượng sử dụng
        $techCounts = [];
        foreach ($tatCaDuAn as $da_item) {
            $tags = json_decode($da_item->tu_khoa, true) ?: [];
            foreach ($tags as $tag) {
                $tagClean = trim($tag);
                if ($tagClean !== '') {
                    $tagKey = mb_strtolower($tagClean);
                    if (!isset($techCounts[$tagKey])) {
                        $techCounts[$tagKey] = [
                            'name' => $tagClean,
                            'count' => 0
                        ];
                    }
                    $techCounts[$tagKey]['count']++;
                }
            }
        }

        // Sắp xếp các công nghệ theo số lượng sử dụng giảm dần
        uasort($techCounts, function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        // Lấy danh sách tên công nghệ duy nhất để làm filter
        $cacCongNghe = array_map(function($item) {
            return $item['name'];
        }, $techCounts);
        asort($cacCongNghe); // Sắp xếp theo bảng chữ cái cho filter dropdown

        // Lấy toàn bộ danh sách dự án không phân trang
        $danhSachDuAn = DB::table('du_an')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->orderBy('id', 'desc')
            ->get();

        // Decode tu_khoa (JSON string to array) cho từng dự án và lấy danh sách liên kết
        $projectIds = [];
        foreach ($danhSachDuAn as $da) {
            $da->tu_khoa = json_decode($da->tu_khoa, true) ?: [];
            $projectIds[] = $da->id;
            $da->lien_ket = [];
        }

        if (!empty($projectIds)) {
            $tatCaLienKet = DB::table('du_an_lien_ket')
                ->whereIn('id_du_an', $projectIds)
                ->orderBy('thu_tu', 'asc')
                ->get();

            // Nhóm liên kết theo id_du_an
            $groupedLienKet = [];
            foreach ($tatCaLienKet as $lk) {
                $groupedLienKet[$lk->id_du_an][] = $lk;
            }

            foreach ($danhSachDuAn as $da) {
                if (isset($groupedLienKet[$da->id])) {
                    $da->lien_ket = $groupedLienKet[$da->id];
                }
            }
        }

        return view('ho-so.du-an', compact(
            'nguoiDung', 
            'danhSachDuAn', 
            'tenRutGon', 
            'hoTen', 
            'chucDanh', 
            'anhDaiDien',
            'tongSoDuAn',
            'dangThucHienCount',
            'daHoanThanhCount',
            'techCounts',
            'cacCongNghe'
        ));
    }

    public function luuDuAn(Request $request)
    {
        $nguoiDung = Auth::user();

        // Sanitize input to prevent XSS
        if ($request->has('ten_du_an')) {
            $request->merge(['ten_du_an' => strip_tags(trim($request->input('ten_du_an')))]);
        }
        if ($request->has('vai_tro')) {
            $request->merge(['vai_tro' => strip_tags(trim($request->input('vai_tro')))]);
        }

        $request->validate([
            'id'                     => ['nullable', 'integer'],
            'ten_du_an'              => ['required', 'string', 'min:2', 'max:100'],
            'vai_tro'                => ['required', 'string', 'min:2', 'max:50'],
            'ngay_bat_dau'           => ['required', 'date'],
            'ngay_ket_thuc'          => ['nullable', 'date', 'after_or_equal:ngay_bat_dau'],
            'mo_ta'                  => ['required', 'string'],
            'tu_khoa'                => ['nullable', 'array'],
            'tu_khoa.*'              => ['string', 'max:50', 'regex:/^[\p{L}\p{N}\s\-\.\+#\/&]+$/u'],
            'lien_ket'               => ['nullable', 'array', 'max:5'],
            'lien_ket.*.loai_lien_ket'=> ['required', 'string', 'in:github,demo,other'],
            'lien_ket.*.duong_dan'    => ['required', 'url', 'max:500'],
            'lien_ket.*.nhan_hien_thi'=> ['nullable', 'string', 'max:100'],
        ], [
            'ten_du_an.required'     => 'Tên dự án không được để trống.',
            'ten_du_an.min'          => 'Tên dự án phải từ 2 đến 100 ký tự.',
            'ten_du_an.max'          => 'Tên dự án phải từ 2 đến 100 ký tự.',
            'vai_tro.required'       => 'Vai trò trong dự án không được để trống.',
            'vai_tro.min'            => 'Vai trò phải từ 2 đến 50 ký tự.',
            'vai_tro.max'            => 'Vai trò phải từ 2 đến 50 ký tự.',
            'ngay_bat_dau.required'  => 'Ngày bắt đầu thực hiện là bắt buộc.',
            'ngay_bat_dau.date'      => 'Ngày bắt đầu không đúng định dạng ngày.',
            'ngay_ket_thuc.date'     => 'Ngày kết thúc không đúng định dạng ngày.',
            'ngay_ket_thuc.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
            'mo_ta.required'         => 'Mô tả chi tiết dự án không được để trống.',
            'tu_khoa.*.regex'        => 'Từ khóa công nghệ không được chứa ký tự đặc biệt.',
            'lien_ket.max'           => 'Mỗi dự án chỉ được thêm tối đa 5 liên kết.',
            'lien_ket.*.loai_lien_ket.required' => 'Loại liên kết là bắt buộc.',
            'lien_ket.*.loai_lien_ket.in'       => 'Loại liên kết không hợp lệ.',
            'lien_ket.*.duong_dan.required'     => 'Đường dẫn liên kết không được để trống.',
            'lien_ket.*.duong_dan.url'          => 'Đường dẫn liên kết phải là định dạng URL hợp lệ.',
            'lien_ket.*.duong_dan.max'          => 'Đường dẫn không được vượt quá 500 ký tự.',
            'lien_ket.*.nhan_hien_thi.max'      => 'Nhãn hiển thị không được vượt quá 100 ký tự.',
        ]);

        $id = $request->input('id');

        $data = [
            'ten_du_an'     => $request->input('ten_du_an'),
            'vai_tro'       => $request->input('vai_tro'),
            'mo_ta'         => $request->input('mo_ta'),
            'ngay_bat_dau'  => $request->input('ngay_bat_dau'),
            'ngay_ket_thuc' => $request->input('ngay_ket_thuc') ?: null,
            'tu_khoa'       => json_encode($request->input('tu_khoa', [])),
        ];

        $lienKetList = $request->input('lien_ket', []);

        try {
            DB::beginTransaction();

            if ($id) {
                // Update
                $exists = DB::table('du_an')
                    ->where('id', $id)
                    ->where('id_nguoi_dung', $nguoiDung->id)
                    ->whereNull('ngay_xoa')
                    ->exists();

                if (!$exists) {
                    DB::rollBack();
                    return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dự án cần cập nhật.'], 403);
                }

                DB::table('du_an')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật dự án: ' . $data['ten_du_an']);
                $projectId = $id;

                // Xóa các liên kết cũ
                DB::table('du_an_lien_ket')->where('id_du_an', $projectId)->delete();

                $msg = 'Cập nhật dự án thành công!';
            } else {
                // Insert
                $data['id_nguoi_dung'] = $nguoiDung->id;
                $data['ngay_tao'] = now();
                $projectId = DB::table('du_an')->insertGetId($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới dự án: ' . $data['ten_du_an']);

                $msg = 'Thêm mới dự án thành công!';
            }

            // Chèn các liên kết mới
            if (!empty($lienKetList)) {
                $insertLienKet = [];
                foreach ($lienKetList as $index => $lk) {
                    if (!empty($lk['duong_dan'])) {
                        $insertLienKet[] = [
                            'id_du_an'      => $projectId,
                            'loai_lien_ket' => $lk['loai_lien_ket'],
                            'duong_dan'     => $lk['duong_dan'],
                            'nhan_hien_thi' => $lk['nhan_hien_thi'] ?: null,
                            'thu_tu'        => $index + 1
                        ];
                    }
                }

                if (!empty($insertLienKet)) {
                    DB::table('du_an_lien_ket')->insert($insertLienKet);
                }
            }

            DB::commit();
            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xoa mem thong tin du an.
     */
    public function xoaDuAn($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('du_an')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->whereNull('ngay_xoa')
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dự án để xóa.'], 403);
            }

            $da = DB::table('du_an')->where('id', $id)->first();
            // Xóa mềm: cập nhật ngay_xoa
            DB::table('du_an')->where('id', $id)->update(['ngay_xoa' => now()]);
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa dự án: ' . ($da ? $da->ten_du_an : 'ID ' . $id));

            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa dự án thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bật/tắt trạng thái nổi bật của mục dự án.
     */
    public function toggleNoiBat($id)
    {
        $nguoiDung = Auth::user();

        try {
            $record = DB::table('du_an')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->whereNull('ngay_xoa')
                ->first();

            if (!$record) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dự án.'], 403);
            }

            $newValue = $record->noi_bat ? 0 : 1;
            DB::table('du_an')->where('id', $id)->update(['noi_bat' => $newValue]);

            $statusText = $newValue ? 'nổi bật' : 'thường';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Đã chuyển dự án '{$record->ten_du_an}' sang chế độ {$statusText}");

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

