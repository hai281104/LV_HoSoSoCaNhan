<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LichController extends Controller
{
    /**
     * Hiển thị trang Lịch / Công việc.
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

        // Lấy tất cả công việc của người dùng
        $suKien = DB::table('lich_cong_viec')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->get();

        // Lấy ngày lễ Việt Nam từ Google Calendar
        $ngayLe = $this->layNgayLeGoogle();

        return view('ho-so.lich', compact('nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon', 'suKien', 'ngayLe'));
    }

    /**
     * Lưu hoặc cập nhật công việc/sự kiện.
     */
    public function luuSuKien(Request $request)
    {
        $nguoiDung = Auth::user();

        $request->validate([
            'id'            => ['nullable', 'integer'],
            'tieu_de'       => ['required', 'string', 'min:2', 'max:30', 'regex:/^[\p{L}\p{N}\s\-_:\(\)\!\?\.\,\/]+$/u'],
            'ngay_bat_dau'   => ['required', 'date'],
            'gio_bat_dau'   => ['nullable', 'date_format:H:i'],
            'ngay_ket_thuc'  => ['required', 'date', 'after_or_equal:ngay_bat_dau'],
            'gio_ket_thuc'  => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $start_date = $request->input('ngay_bat_dau');
                    $end_date = $request->input('ngay_ket_thuc');
                    $start_time = $request->input('gio_bat_dau');
                    if ($start_date === $end_date && $start_time && $value && $value < $start_time) {
                        $fail('Giờ kết thúc phải sau giờ bắt đầu trong cùng một ngày.');
                    }
                }
            ],
            'phan_loai'     => ['required', 'in:ca_nhan,hop_tac,deadline,su_kien,khac'],
            'mo_ta'         => ['nullable', 'string', 'max:100'],
        ], [
            'tieu_de.required'     => 'Tiêu đề sự kiện không được để trống.',
            'tieu_de.min'          => 'Tiêu đề sự kiện phải từ 2 ký tự trở lên.',
            'tieu_de.max'          => 'Tiêu đề sự kiện không được vượt quá 30 ký tự.',
            'tieu_de.regex'        => 'Tiêu đề sự kiện chứa ký tự không hợp lệ.',
            'ngay_bat_dau.required'=> 'Ngày bắt đầu là bắt buộc.',
            'ngay_bat_dau.date'    => 'Ngày bắt đầu không đúng định dạng.',
            'gio_bat_dau.date_format' => 'Giờ bắt đầu không đúng định dạng (HH:MM).',
            'ngay_ket_thuc.required' => 'Ngày kết thúc là bắt buộc.',
            'ngay_ket_thuc.date'    => 'Ngày kết thúc không đúng định dạng.',
            'ngay_ket_thuc.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
            'gio_ket_thuc.date_format' => 'Giờ kết thúc không đúng định dạng (HH:MM).',
            'phan_loai.required'   => 'Phân loại công việc là bắt buộc.',
            'phan_loai.in'         => 'Phân loại công việc không hợp lệ.',
            'mo_ta.max'            => 'Mô tả chi tiết không được vượt quá 100 ký tự.',
        ]);

        $id = $request->input('id');
        
        $data = [
            'tieu_de'      => $request->input('tieu_de'),
            'ngay_bat_dau'  => $request->input('ngay_bat_dau'),
            'gio_bat_dau'  => $request->input('gio_bat_dau') ?: null,
            'ngay_ket_thuc' => $request->input('ngay_ket_thuc'),
            'gio_ket_thuc' => $request->input('gio_ket_thuc') ?: null,
            'phan_loai'    => $request->input('phan_loai'),
            'mo_ta'        => $request->input('mo_ta') ?: null,
        ];

        try {
            if ($id) {
                // Cập nhật
                $exists = DB::table('lich_cong_viec')
                    ->where('id', $id)
                    ->where('id_nguoi_dung', $nguoiDung->id)
                    ->exists();

                if (!$exists) {
                    return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy sự kiện cần cập nhật.'], 403);
                }

                $data['ngay_cap_nhat'] = now();
                DB::table('lich_cong_viec')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật sự kiện lịch: ' . $data['tieu_de']);
                $msg = 'Cập nhật sự kiện thành công!';
            } else {
                // Thêm mới
                $data['id_nguoi_dung'] = $nguoiDung->id;
                $data['ngay_tao'] = now();
                $data['ngay_cap_nhat'] = now();
                DB::table('lich_cong_viec')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Thêm mới sự kiện lịch: ' . $data['tieu_de']);
                $msg = 'Thêm sự kiện thành công!';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa sự kiện.
     */
    public function xoaSuKien($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('lich_cong_viec')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy sự kiện để xóa.'], 403);
            }

            $sk = DB::table('lich_cong_viec')->where('id', $id)->first();
            DB::table('lich_cong_viec')->where('id', $id)->delete();
            // Xóa toàn bộ thông báo liên quan đến sự kiện lịch này
            DB::table('thong_bao')->where('khoa_trung', 'like', 'lich_' . $id . '_%')->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa sự kiện lịch: ' . ($sk ? $sk->tieu_de : 'ID ' . $id));
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa sự kiện thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi khi xóa sự kiện: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Tải và parse ngày lễ Việt Nam từ Google Calendar (.ics), lưu cache 30 ngày.
     */
    private function layNgayLeGoogle()
    {
        return Cache::remember('vietnam_holidays', now()->addDays(30), function () {
            try {
                $response = Http::withoutVerifying()->timeout(10)->get('https://calendar.google.com/calendar/ical/vi.vietnamese%23holiday%40group.v.calendar.google.com/public/basic.ics');
                if ($response->successful()) {
                    $content = $response->body();
                    $lines = explode("\n", $content);
                    $events = [];
                    $currentEvent = null;
                    
                    foreach ($lines as $line) {
                        $line = rtrim($line, "\r");
                        if (empty($line)) continue;
                        
                        if (strpos($line, 'BEGIN:VEVENT') === 0) {
                            $currentEvent = [];
                        } elseif (strpos($line, 'END:VEVENT') === 0) {
                            if ($currentEvent && isset($currentEvent['start']) && isset($currentEvent['summary'])) {
                                $events[$currentEvent['start']] = $currentEvent['summary'];
                            }
                            $currentEvent = null;
                        } elseif ($currentEvent !== null) {
                            if (preg_match('/^DTSTART[;:][^:]*:(.*)$/', $line, $matches)) {
                                $dateVal = substr(trim($matches[1]), 0, 8);
                                if (strlen($dateVal) === 8) {
                                    $formattedDate = substr($dateVal, 0, 4) . '-' . substr($dateVal, 4, 2) . '-' . substr($dateVal, 6, 2);
                                    $currentEvent['start'] = $formattedDate;
                                }
                            } elseif (preg_match('/^SUMMARY:(.*)$/', $line, $matches)) {
                                $summary = trim($matches[1]);
                                // Giải mã ký tự đặc biệt trong ics
                                $summary = str_replace(['\\,', '\\;', '\\\\'], [',', ';', '\\'], $summary);
                                $currentEvent['summary'] = $summary;
                            }
                        }
                    }
                    return $events;
                }
            } catch (\Exception $e) {
                Log::error('Lỗi tải ngày lễ từ Google Calendar: ' . $e->getMessage());
            }
            return [];
        });
    }
}
