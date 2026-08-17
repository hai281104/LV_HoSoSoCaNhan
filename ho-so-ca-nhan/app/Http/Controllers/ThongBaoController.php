<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThongBaoController extends Controller
{
    /**
     * Lấy danh sách thông báo chưa đọc (và đã đọc) của người dùng.
     * GET /api/thong-bao
     */
    public function layThongBao(Request $request)
    {
        $nguoiDung = Auth::user();

        $danhSach = DB::table('thong_bao')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('ngay_tao', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($tb) {
                return [
                    'id'           => $tb->id,
                    'loai'         => $tb->loai,
                    'tieu_de'      => $tb->tieu_de,
                    'noi_dung'     => $tb->noi_dung,
                    'url_lien_ket' => $tb->url_lien_ket,
                    'da_doc'       => (bool) $tb->da_doc,
                    'thoi_gian'    => $this->formatThoiGian($tb->ngay_tao),
                ];
            });

        $soChuaDoc = DB::table('thong_bao')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('da_doc', 0)
            ->count();

        return response()->json([
            'thanh_cong'  => true,
            'danh_sach'   => $danhSach,
            'so_chua_doc' => $soChuaDoc,
        ]);
    }

    /**
     * Đánh dấu 1 thông báo đã đọc.
     * POST /api/thong-bao/{id}/doc
     */
    public function danhDauDaDoc($id)
    {
        $nguoiDung = Auth::user();

        $updated = DB::table('thong_bao')
            ->where('id', $id)
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->update(['da_doc' => 1]);

        if (!$updated) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông báo.'], 404);
        }

        return response()->json(['thanh_cong' => true]);
    }

    /**
     * Đánh dấu tất cả thông báo là đã đọc.
     * POST /api/thong-bao/doc-tat-ca
     */
    public function docTatCa()
    {
        $nguoiDung = Auth::user();

        DB::table('thong_bao')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('da_doc', 0)
            ->update(['da_doc' => 1]);

        return response()->json(['thanh_cong' => true]);
    }

    /**
     * Xóa 1 thông báo.
     * POST /api/thong-bao/{id}/xoa
     */
    public function xoa($id)
    {
        $nguoiDung = Auth::user();

        $deleted = DB::table('thong_bao')
            ->where('id', $id)
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->delete();

        if (!$deleted) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy thông báo.'], 404);
        }

        return response()->json(['thanh_cong' => true]);
    }

    /**
     * Format thời gian thành dạng "vừa xong", "3 phút trước"...
     */
    private function formatThoiGian($ngayTao)
    {
        try {
            $time = Carbon::parse($ngayTao)->setTimezone('Asia/Ho_Chi_Minh');
            $now  = Carbon::now('Asia/Ho_Chi_Minh');
            $diff = $now->diffInMinutes($time);

            if ($diff < 1)  return 'Vừa xong';
            if ($diff < 60) return $diff . ' phút trước';

            $diffH = $now->diffInHours($time);
            if ($diffH < 24) return $diffH . ' giờ trước';

            $diffD = $now->diffInDays($time);
            if ($diffD < 7)  return $diffD . ' ngày trước';

            return $time->format('d/m/Y H:i');
        } catch (\Exception $e) {
            return '';
        }
    }
}
