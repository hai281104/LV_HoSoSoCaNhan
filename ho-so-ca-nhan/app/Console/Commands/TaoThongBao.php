<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaoThongBao extends Command
{
    protected $signature = 'thong-bao:tao';
    protected $description = 'Sinh thông báo tự động: ngày lễ, chứng chỉ hết hạn, lịch công việc sắp đến hạn';

    public function handle()
    {
        $this->info('[TaoThongBao] Bắt đầu sinh thông báo: ' . now()->format('Y-m-d H:i:s'));

        $this->donDepThongBaoRac();
        $this->thongBaoNgayLe();
        $this->thongBaoChungChi();
        $this->thongBaoLichCongViec();

        $this->info('[TaoThongBao] Hoàn thành.');
        return 0;
    }

    private function donDepThongBaoRac()
    {
        // Xóa thông báo lịch của sự kiện đã bị xóa khỏi hệ thống
        $lichIds = DB::table('lich_cong_viec')->pluck('id')->toArray();
        $thongBaoLich = DB::table('thong_bao')->where('loai', 'lich_cong_viec')->get();

        $xoaCount = 0;
        foreach ($thongBaoLich as $tb) {
            if (preg_match('/^lich_(\d+)_/', $tb->khoa_trung, $matches)) {
                $idLich = (int)$matches[1];
                if (!in_array($idLich, $lichIds)) {
                    DB::table('thong_bao')->where('id', $tb->id)->delete();
                    $xoaCount++;
                }
            }
        }

        if ($xoaCount > 0) {
            $this->line("  [Dọn dẹp] Đã dọn {$xoaCount} thông báo lịch rác.");
        }
    }

    //   
    // 1. Thông báo ngày lễ (trước 1 ngày)
    //   
    private function thongBaoNgayLe()
    {
        $ngayLe = $this->layNgayLeGoogle();
        if (empty($ngayLe)) {
            $this->line('  [Ngày lễ] Không lấy được dữ liệu ngày lễ.');
            return;
        }

        $ngayMai = Carbon::tomorrow('Asia/Ho_Chi_Minh')->format('Y-m-d');
        if (!isset($ngayLe[$ngayMai])) {
            $this->line('  [Ngày lễ] Không có ngày lễ vào ngày mai (' . $ngayMai . ').');
            return;
        }

        $tenNgayLe = $ngayLe[$ngayMai];
        $nguoiDungIds = DB::table('nguoi_dung')
            ->where('trang_thai', 'hoat_dong')
            ->where('thong_bao_bat', 1)
            ->pluck('id');
        $soSinh = 0;

        foreach ($nguoiDungIds as $userId) {
            $khoaTrung = 'ngay_le_' . $userId . '_' . $ngayMai;
            $exists = DB::table('thong_bao')
                ->where('khoa_trung', $khoaTrung)
                ->exists();

            if (!$exists) {
                DB::table('thong_bao')->insert([
                    'id_nguoi_dung' => $userId,
                    'loai'          => 'ngay_le',
                    'tieu_de'       => '🎉 Ngày lễ sắp đến: ' . $tenNgayLe,
                    'noi_dung'      => 'Ngày mai (' . Carbon::parse($ngayMai)->format('d/m/Y') . ') là ' . $tenNgayLe . '. Chúc bạn một ngày lễ vui vẻ!',
                    'url_lien_ket'  => null,
                    'da_doc'        => 0,
                    'khoa_trung'    => $khoaTrung,
                    'ngay_tao'      => now(),
                ]);
                $soSinh++;
            }
        }

        $this->line("  [Ngày lễ] Đã sinh {$soSinh} thông báo cho ngày lễ '{$tenNgayLe}' vào {$ngayMai}.");
    }

    //   
    // 2. Thông báo chứng chỉ sắp hết hạn (trước 3 ngày)
    //   
    private function thongBaoChungChi()
    {
        $han3Ngay = Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('Y-m-d');
        $homNay   = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

        $chungChis = DB::table('chung_chi')
            ->join('nguoi_dung', 'chung_chi.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->where('nguoi_dung.trang_thai', 'hoat_dong')
            ->where('nguoi_dung.thong_bao_bat', 1)
            ->whereNotNull('chung_chi.ngay_het_han')
            ->where('chung_chi.ngay_het_han', $han3Ngay)
            ->select('chung_chi.*')
            ->get();

        $soSinh = 0;

        foreach ($chungChis as $cc) {
            $khoaTrung = 'chung_chi_' . $cc->id . '_3ngay_' . $homNay;
            $exists = DB::table('thong_bao')
                ->where('khoa_trung', $khoaTrung)
                ->exists();

            if (!$exists) {
                DB::table('thong_bao')->insert([
                    'id_nguoi_dung' => $cc->id_nguoi_dung,
                    'loai'          => 'chung_chi',
                    'tieu_de'       => ' Chứng chỉ sắp hết hạn: ' . $cc->ten_chung_chi,
                    'noi_dung'      => "Chứng chỉ \"{$cc->ten_chung_chi}\" (cấp bởi {$cc->to_chuc_cap}) sẽ hết hạn vào ngày " . Carbon::parse($cc->ngay_het_han)->format('d/m/Y') . '. Hãy cân nhắc gia hạn hoặc cập nhật kịp thời.',
                    'url_lien_ket'  => '/ho-so/chung-chi',
                    'da_doc'        => 0,
                    'khoa_trung'    => $khoaTrung,
                    'ngay_tao'      => now(),
                ]);
                $soSinh++;
            }
        }

        $this->line("  [Chứng chỉ] Đã sinh {$soSinh} thông báo hết hạn (còn 3 ngày).");
    }

    //   
    // 3. Thông báo lịch công việc (trước 3 ngày, 1 ngày, 3 tiếng)
    //   
    private function thongBaoLichCongViec()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $homNay = $now->format('Y-m-d');

        // Lấy tất cả công việc chưa hết hạn của người dùng hoạt động và bật thông báo
        $congViecs = DB::table('lich_cong_viec')
            ->join('nguoi_dung', 'lich_cong_viec.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->where('nguoi_dung.trang_thai', 'hoat_dong')
            ->where('nguoi_dung.thong_bao_bat', 1)
            ->where('lich_cong_viec.ngay_ket_thuc', '>=', $homNay)
            ->select('lich_cong_viec.*')
            ->get();

        $soSinh = 0;

        foreach ($congViecs as $cv) {
            // Tạo Carbon deadline từ ngay_ket_thuc + gio_ket_thuc
            $thoiGianKetThuc = $cv->gio_ket_thuc
                ? Carbon::parse($cv->ngay_ket_thuc . ' ' . $cv->gio_ket_thuc, 'Asia/Ho_Chi_Minh')
                : Carbon::parse($cv->ngay_ket_thuc . ' 23:59:00', 'Asia/Ho_Chi_Minh');

            $diffMinutes = $now->diffInMinutes($thoiGianKetThuc, false);

            // Nếu đã quá hạn thì bỏ qua
            if ($diffMinutes < 0) continue;

            $this->taoThongBaoNeuCan($cv, $thoiGianKetThuc, $diffMinutes, $homNay, $soSinh);
        }

        $this->line("  [Lịch CV] Đã sinh {$soSinh} thông báo lịch công việc.");
    }

    private function taoThongBaoNeuCan($cv, $thoiGianKetThuc, $diffMinutes, $homNay, &$soSinh)
    {
        $nguoiDungId = $cv->id_nguoi_dung;
        $ngayKt      = $thoiGianKetThuc->format('d/m/Y');
        $gioKt       = $thoiGianKetThuc->format('H:i');

        // --- Trước 3 ngày (khoảng 4318–4322 phút) ---
        if ($diffMinutes >= (3 * 24 * 60 - 15) && $diffMinutes <= (3 * 24 * 60 + 15)) {
            $khoaTrung = 'lich_' . $cv->id . '_3ngay_' . $homNay;
            if (!DB::table('thong_bao')->where('khoa_trung', $khoaTrung)->exists()) {
                DB::table('thong_bao')->insert([
                    'id_nguoi_dung' => $nguoiDungId,
                    'loai'          => 'lich_cong_viec',
                    'tieu_de'       => '📅 Công việc sắp đến hạn (3 ngày): ' . $cv->tieu_de,
                    'noi_dung'      => "Công việc \"{$cv->tieu_de}\" sẽ đến hạn vào lúc {$gioKt} ngày {$ngayKt}. Còn 3 ngày, hãy chuẩn bị!",
                    'url_lien_ket'  => '/ho-so/lich',
                    'da_doc'        => 0,
                    'khoa_trung'    => $khoaTrung,
                    'ngay_tao'      => now(),
                ]);
                $soSinh++;
            }
        }

        // --- Trước 1 ngày (khoảng 1425–1440 phút, tức ~24h ±15 phút) ---
        if ($diffMinutes >= (1 * 24 * 60 - 15) && $diffMinutes <= (1 * 24 * 60 + 15)) {
            $khoaTrung = 'lich_' . $cv->id . '_1ngay_' . $homNay;
            if (!DB::table('thong_bao')->where('khoa_trung', $khoaTrung)->exists()) {
                DB::table('thong_bao')->insert([
                    'id_nguoi_dung' => $nguoiDungId,
                    'loai'          => 'lich_cong_viec',
                    'tieu_de'       => '⚠️ Công việc sắp đến hạn (1 ngày): ' . $cv->tieu_de,
                    'noi_dung'      => "Công việc \"{$cv->tieu_de}\" sẽ đến hạn vào lúc {$gioKt} ngày {$ngayKt}. Chỉ còn 1 ngày!",
                    'url_lien_ket'  => '/ho-so/lich',
                    'da_doc'        => 0,
                    'khoa_trung'    => $khoaTrung,
                    'ngay_tao'      => now(),
                ]);
                $soSinh++;
            }
        }

        // --- Trước 3 tiếng (165–195 phút) ---
        if ($diffMinutes >= (3 * 60 - 15) && $diffMinutes <= (3 * 60 + 15)) {
            $khoaTrung = 'lich_' . $cv->id . '_3h_' . now()->format('Y-m-d_H');
            if (!DB::table('thong_bao')->where('khoa_trung', $khoaTrung)->exists()) {
                DB::table('thong_bao')->insert([
                    'id_nguoi_dung' => $nguoiDungId,
                    'loai'          => 'lich_cong_viec',
                    'tieu_de'       => ' Công việc sắp đến hạn (3 tiếng): ' . $cv->tieu_de,
                    'noi_dung'      => "Công việc \"{$cv->tieu_de}\" sẽ đến hạn lúc {$gioKt} hôm nay. Chỉ còn khoảng 3 tiếng!",
                    'url_lien_ket'  => '/ho-so/lich',
                    'da_doc'        => 0,
                    'khoa_trung'    => $khoaTrung,
                    'ngay_tao'      => now(),
                ]);
                $soSinh++;
            }
        }
    }

    //   
    // Helper: Lấy ngày lễ từ Google Calendar (cache 30 ngày)
    //   
    private function layNgayLeGoogle()
    {
        return Cache::remember('vietnam_holidays', now()->addDays(30), function () {
            try {
                $response = Http::withoutVerifying()->timeout(10)->get(
                    'https://calendar.google.com/calendar/ical/vi.vietnamese%23holiday%40group.v.calendar.google.com/public/basic.ics'
                );
                if ($response->successful()) {
                    $lines = explode("\n", $response->body());
                    $events = [];
                    $currentEvent = null;

                    foreach ($lines as $line) {
                        $line = rtrim($line, "\r");
                        if (empty($line)) continue;

                        if (str_starts_with($line, 'BEGIN:VEVENT')) {
                            $currentEvent = [];
                        } elseif (str_starts_with($line, 'END:VEVENT')) {
                            if ($currentEvent && isset($currentEvent['start'], $currentEvent['summary'])) {
                                $events[$currentEvent['start']] = $currentEvent['summary'];
                            }
                            $currentEvent = null;
                        } elseif ($currentEvent !== null) {
                            if (preg_match('/^DTSTART[;:][^:]*:(.*)$/', $line, $m)) {
                                $d = substr(trim($m[1]), 0, 8);
                                if (strlen($d) === 8) {
                                    $currentEvent['start'] = substr($d, 0, 4) . '-' . substr($d, 4, 2) . '-' . substr($d, 6, 2);
                                }
                            } elseif (preg_match('/^SUMMARY:(.*)$/', $line, $m)) {
                                $sum = trim($m[1]);
                                $sum = str_replace(['\\,', '\\;', '\\\\'], [',', ';', '\\'], $sum);
                                $currentEvent['summary'] = $sum;
                            }
                        }
                    }
                    return $events;
                }
            } catch (\Exception $e) {
                Log::error('TaoThongBao - Lỗi tải ngày lễ: ' . $e->getMessage());
            }
            return [];
        });
    }
}
