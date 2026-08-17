<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HoSoController extends Controller
{
    /**
     * Hien thi trang ho so ca nhan.
     */
    public function index()
    {
        $nguoiDung = Auth::user();

        // Lay danh sach ngon ngu lap trinh cua nguoi dung (ca noi bat)
        $ngonNguPivot = DB::table('nguoi_dung_ngon_ngu_lap_trinh')
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->get();
        $ngonNguDaChon = $ngonNguPivot->pluck('ngon_ngu_lap_trinh_id')->toArray();
        $ngonNguNoiBat = $ngonNguPivot->where('noi_bat', 1)->pluck('ngon_ngu_lap_trinh_id')->toArray();

        // Lay danh sach ky nang mem cua nguoi dung (ca noi bat)
        $kyNangPivot = DB::table('nguoi_dung_ky_nang_mem')
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->get();
        $kyNangDaChon = $kyNangPivot->pluck('ky_nang_mem_id')->toArray();
        $kyNangNoiBat = $kyNangPivot->where('noi_bat', 1)->pluck('ky_nang_mem_id')->toArray();

        // Lay tat ca ngon ngu lap trinh (master data)
        $tatCaNgonNgu = DB::table('ngon_ngu_lap_trinh')
            ->orderBy('ten_ngon_ngu')
            ->get();

        // Lay tat ca ky nang mem (master data)
        $tatCaKyNang = DB::table('ky_nang_mem')
            ->orderBy('ten_ky_nang')
            ->get();

        // Lay ten ngon ngu da chon (de hien thi, uu tien noi bat)
        $ngonNguLapTrinh = DB::table('nguoi_dung_ngon_ngu_lap_trinh')
            ->join('ngon_ngu_lap_trinh', 'nguoi_dung_ngon_ngu_lap_trinh.ngon_ngu_lap_trinh_id', '=', 'ngon_ngu_lap_trinh.id')
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->orderBy('nguoi_dung_ngon_ngu_lap_trinh.noi_bat', 'desc')
            ->orderBy('ngon_ngu_lap_trinh.ten_ngon_ngu', 'asc')
            ->pluck('ten_ngon_ngu')
            ->toArray();

        // Lay ten ky nang mem da chon (de hien thi, uu tien noi bat)
        $kyNangMem = DB::table('nguoi_dung_ky_nang_mem')
            ->join('ky_nang_mem', 'nguoi_dung_ky_nang_mem.ky_nang_mem_id', '=', 'ky_nang_mem.id')
            ->where('nguoi_dung_id', $nguoiDung->id)
            ->orderBy('nguoi_dung_ky_nang_mem.noi_bat', 'desc')
            ->orderBy('ky_nang_mem.ten_ky_nang', 'asc')
            ->pluck('ten_ky_nang')
            ->toArray();

        // Lay lien ket mxh
        $lienKetMxh = DB::table('lien_ket_mxh')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('thu_tu')
            ->get();

        return view('ho-so.index', compact(
            'nguoiDung',
            'ngonNguDaChon',
            'kyNangDaChon',
            'ngonNguNoiBat',
            'kyNangNoiBat',
            'tatCaNgonNgu',
            'tatCaKyNang',
            'ngonNguLapTrinh',
            'kyNangMem',
            'lienKetMxh'
        ));
    }

    /**
     * Cap nhat thong tin co ban cua ho so.
     */
    public function capNhatCoBan(Request $request)
    {
        $request->validate([
            'ho_ten'        => ['required', 'string', 'min:2', 'max:25', 'regex:/^[\p{L}\s]+$/u'],
            'chuc_danh'     => ['nullable', 'string', 'min:2', 'max:30'],
            'ngay_sinh'     => ['nullable', 'date', 'before_or_equal:today'],
            'dia_chi'       => ['nullable', 'string', 'min:2', 'max:100'],
            'so_dien_thoai' => ['required', 'string', 'regex:/^0(3|5|7|8|9)[0-9]{8}$/', 'unique:nguoi_dung,so_dien_thoai,' . Auth::id()],
            'gioi_thieu'    => ['nullable', 'string', 'max:1000'],
            'so_thich'      => ['nullable', 'string', 'min:2', 'max:50'],
        ], [
            'ho_ten.required' => 'Họ và tên không được để trống.',
            'ho_ten.min' => 'Họ và tên phải có độ dài từ 2 đến 25 ký tự.',
            'ho_ten.max' => 'Họ và tên phải có độ dài từ 2 đến 25 ký tự.',
            'ho_ten.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng, không chứa số hay ký tự đặc biệt.',
            'chuc_danh.min' => 'Chức danh phải có độ dài từ 2 đến 30 ký tự.',
            'chuc_danh.max' => 'Chức danh phải có độ dài từ 2 đến 30 ký tự.',
            'ngay_sinh.date' => 'Ngày sinh không đúng định dạng ngày.',
            'ngay_sinh.before_or_equal' => 'Ngày sinh không thể ở tương lai.',
            'dia_chi.min' => 'Khu vực sinh sống phải có độ dài từ 2 đến 100 ký tự.',
            'dia_chi.max' => 'Khu vực sinh sống phải có độ dài từ 2 đến 100 ký tự.',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.regex' => 'Số điện thoại phải gồm đúng 10 số và bắt đầu bằng các đầu số 03, 05, 07, 08, 09.',
            'so_dien_thoai.unique' => 'Số điện thoại này đã được đăng ký sử dụng.',
            'gioi_thieu.max' => 'Giới thiệu bản thân không được vượt quá 1000 ký tự.',
            'so_thich.min' => 'Sở thích cá nhân phải từ 2 đến 50 ký tự.',
            'so_thich.max' => 'Sở thích cá nhân phải từ 2 đến 50 ký tự.',
        ]);

        $nguoiDung = Auth::user();

        // Chuyen empty string thanh null va loc bo the HTML cho cac truong text
        $chucDanh    = $request->input('chuc_danh')    ?: null;
        $ngaySinh    = $request->input('ngay_sinh')    ?: null;
        $diaChi      = $request->input('dia_chi')      ?: null;
        $soDienThoai = $request->input('so_dien_thoai') ?: null;
        $gioiThieu   = $request->input('gioi_thieu')   ?: null;
        $soThich     = $request->input('so_thich')     ?: null;

        try {
            $nguoiDung->update([
                'ho_ten'        => $request->input('ho_ten'),
                'chuc_danh'     => $chucDanh,
                'ngay_sinh'     => $ngaySinh,
                'dia_chi'       => $diaChi,
                'so_dien_thoai' => $soDienThoai,
                'gioi_thieu'    => $gioiThieu,
                'so_thich'      => $soThich,
                'ngay_cap_nhat' => now(),
            ]);

            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật thông tin cơ bản: ' . $request->input('ho_ten'));

            return response()->json([
                'thanh_cong' => true,
                'thong_bao'  => 'Cập nhật hồ sơ thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao'  => 'Lỗi khi lưu dữ liệu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cap nhat avatar sau khi crop.
     */
    public function capNhatAvatar(Request $request)
    {
        $request->validate([
            'avatar_data' => 'required|string',
        ]);

        $nguoiDung = Auth::user();
        $avatarData = $request->input('avatar_data');

        // Kiem tra dinh dang base64
        if (!preg_match('/^data:image\/(png|jpg|jpeg|webp);base64,/', $avatarData, $matches)) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Định dạng ảnh không hợp lệ.'], 422);
        }

        $imageData = substr($avatarData, strpos($avatarData, ',') + 1);
        $imageData = base64_decode($imageData);

        if ($imageData === false) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không thể xử lý ảnh.'], 422);
        }

        // Kiem tra kich thuoc anh (toi da 2MB = 2097152 bytes)
        if (strlen($imageData) > 2 * 1024 * 1024) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Kích thước ảnh đại diện không được vượt quá 2MB.'], 422);
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $fileName = Str::uuid() . '.' . $extension;
        $uploadDir = public_path('uploads/avatar/');

        try {
            if (!file_exists($uploadDir)) {
                if (!@mkdir($uploadDir, 0755, true)) {
                    return response()->json([
                        'thanh_cong' => false,
                        'thong_bao' => 'Không thể tạo thư mục lưu trữ ảnh đại diện tại: "' . $uploadDir . '". Vui lòng kiểm tra quyền ghi thư mục cha.'
                    ], 500);
                }
            }

            if (!is_writable($uploadDir)) {
                return response()->json([
                    'thanh_cong' => false,
                    'thong_bao' => 'Thư mục "' . $uploadDir . '" không có quyền ghi. Vui lòng CHMOD thư mục này thành 755 hoặc 777.'
                ], 500);
            }

            // Xoa avatar cu neu co
            if ($nguoiDung->anh_dai_dien && file_exists(public_path($nguoiDung->anh_dai_dien))) {
                @unlink(public_path($nguoiDung->anh_dai_dien));
            }

            if (file_put_contents($uploadDir . $fileName, $imageData) === false) {
                return response()->json([
                    'thanh_cong' => false,
                    'thong_bao' => 'Ghi tệp ảnh đại diện thất bại tại: "' . $uploadDir . $fileName . '". Vui lòng kiểm tra quyền ghi hoặc dung lượng host.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => 'Lỗi khi tải ảnh lên host (Thư mục: "' . $uploadDir . '"): ' . $e->getMessage()
            ], 500);
        }

        $duongDan = 'uploads/avatar/' . $fileName;

        $nguoiDung->update([
            'anh_dai_dien' => $duongDan,
            'ngay_cap_nhat' => now(),
        ]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật ảnh đại diện mới');

        return response()->json([
            'thanh_cong'  => true,
            'thong_bao'   => 'Cập nhật avatar thành công!',
            'duong_dan'   => asset($duongDan),
        ]);
    }

    /**
     * Cap nhat ky nang chuyen mon.
     */
    public function capNhatKyNang(Request $request)
    {
        $request->validate([
            'ngon_ngu_ids'           => ['nullable', 'array', 'max:20'],
            'ngon_ngu_ids.*'         => ['integer', 'exists:ngon_ngu_lap_trinh,id'],
            'ngon_ngu_noi_bat_ids'   => ['nullable', 'array', 'max:5'],
            'ngon_ngu_noi_bat_ids.*' => ['integer', 'exists:ngon_ngu_lap_trinh,id'],
            'ky_nang_ids'            => ['nullable', 'array', 'max:20'],
            'ky_nang_ids.*'          => ['integer', 'exists:ky_nang_mem,id'],
            'ky_nang_noi_bat_ids'    => ['nullable', 'array', 'max:5'],
            'ky_nang_noi_bat_ids.*'  => ['integer', 'exists:ky_nang_mem,id'],
        ], [
            'ngon_ngu_ids.array' => 'Dữ liệu ngôn ngữ lập trình không hợp lệ.',
            'ngon_ngu_ids.max' => 'Số lượng ngôn ngữ lập trình không được vượt quá 20.',
            'ngon_ngu_ids.*.integer' => 'Mã ngôn ngữ lập trình phải là số nguyên.',
            'ngon_ngu_ids.*.exists' => 'Ngôn ngữ lập trình đã chọn không tồn tại.',
            'ngon_ngu_noi_bat_ids.max' => 'Số lượng ngôn ngữ lập trình nổi bật tối đa là 5.',
            'ky_nang_ids.array' => 'Dữ liệu kỹ năng mềm không hợp lệ.',
            'ky_nang_ids.max' => 'Số lượng kỹ năng mềm không được vượt quá 20.',
            'ky_nang_ids.*.integer' => 'Mã kỹ năng mềm phải là số nguyên.',
            'ky_nang_ids.*.exists' => 'Kỹ năng mềm đã chọn không tồn tại.',
            'ky_nang_noi_bat_ids.max' => 'Số lượng kỹ năng mềm nổi bật tối đa là 5.',
        ]);

        $nguoiDung = Auth::user();
        $ngonNguIds = $request->input('ngon_ngu_ids', []);
        $ngonNguNoiBatIds = $request->input('ngon_ngu_noi_bat_ids', []);
        $kyNangIds  = $request->input('ky_nang_ids', []);
        $kyNangNoiBatIds = $request->input('ky_nang_noi_bat_ids', []);

        // Xoa tat ca cu roi insert lai
        DB::table('nguoi_dung_ngon_ngu_lap_trinh')->where('nguoi_dung_id', $nguoiDung->id)->delete();
        DB::table('nguoi_dung_ky_nang_mem')->where('nguoi_dung_id', $nguoiDung->id)->delete();

        // Insert ngon ngu moi
        if (!empty($ngonNguIds)) {
            $insertNgonNgu = array_map(function($id) use ($nguoiDung, $ngonNguNoiBatIds) {
                return [
                    'nguoi_dung_id'          => $nguoiDung->id,
                    'ngon_ngu_lap_trinh_id'  => $id,
                    'noi_bat'                => in_array($id, $ngonNguNoiBatIds) ? 1 : 0,
                ];
            }, $ngonNguIds);
            DB::table('nguoi_dung_ngon_ngu_lap_trinh')->insert($insertNgonNgu);
        }

        // Insert ky nang mem moi
        if (!empty($kyNangIds)) {
            $insertKyNang = array_map(function($id) use ($nguoiDung, $kyNangNoiBatIds) {
                return [
                    'nguoi_dung_id'  => $nguoiDung->id,
                    'ky_nang_mem_id' => $id,
                    'noi_bat'        => in_array($id, $kyNangNoiBatIds) ? 1 : 0,
                ];
            }, $kyNangIds);
            DB::table('nguoi_dung_ky_nang_mem')->insert($insertKyNang);
        }

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật kỹ năng chuyên môn');

        return response()->json([
            'thanh_cong' => true,
            'thong_bao'  => 'Cập nhật kỹ năng thành công!',
        ]);
    }

    /**
     * Cap nhat lien ket mang xa hoi.
     */
    public function capNhatLienKet(Request $request)
    {
        $request->validate([
            'lien_ket'                => 'nullable|array|max:10',
            'lien_ket.*.ten_nen_tang' => 'required|string|max:100',
            'lien_ket.*.duong_dan'    => 'required|url|max:500',
        ], [
            'lien_ket.array' => 'Dữ liệu liên kết không hợp lệ.',
            'lien_ket.max' => 'Bạn chỉ được thêm tối đa 10 liên kết liên hệ.',
            'lien_ket.*.ten_nen_tang.required' => 'Tên nền tảng không được để trống.',
            'lien_ket.*.ten_nen_tang.max' => 'Tên nền tảng không được vượt quá 100 ký tự.',
            'lien_ket.*.duong_dan.required' => 'Đường dẫn liên kết không được để trống.',
            'lien_ket.*.duong_dan.url' => 'Đường dẫn liên kết phải là định dạng URL hợp lệ (VD: https://github.com/... ).',
            'lien_ket.*.duong_dan.max' => 'Đường dẫn liên kết không được vượt quá 500 ký tự.',
        ]);

        $nguoiDung = Auth::user();
        $danhSach  = $request->input('lien_ket', []);

        // Xoa het lien ket cu
        DB::table('lien_ket_mxh')->where('id_nguoi_dung', $nguoiDung->id)->delete();

        // Insert moi
        foreach ($danhSach as $thuTu => $item) {
            if (!empty($item['ten_nen_tang']) && !empty($item['duong_dan'])) {
                DB::table('lien_ket_mxh')->insert([
                    'id_nguoi_dung' => $nguoiDung->id,
                    'ten_nen_tang'  => $item['ten_nen_tang'],
                    'duong_dan'     => $item['duong_dan'],
                    'hien_thi'      => 1,
                    'thu_tu'        => $thuTu + 1,
                    'ngay_tao'      => now(),
                ]);
            }
        }

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật các liên kết mạng xã hội');

        return response()->json([
            'thanh_cong' => true,
            'thong_bao'  => 'Cập nhật liên kết thành công!',
        ]);
    }

    /**
     * Hiển thị trang giao diện chia sẻ hồ sơ.
     */
    public function chiaSe()
    {
        $nguoiDung = Auth::user();
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

        // Tạo chữ cái tắt cho avatar
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

        // Lấy danh sách CV cá nhân (chưa xóa)
        $danhSachCv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->orderBy('la_cv_chinh', 'desc')
            ->orderBy('ngay_cap_nhat', 'desc')
            ->get();

        return view('ho-so.chia-se', compact('nguoiDung', 'danhSachCv', 'tenRutGon', 'hoTen', 'chucDanh', 'anhDaiDien'));
    }

    /**
     * Trang kết xuất hồ sơ năng lực đầy đủ dạng A4 để in/tải PDF.
     */
    public function xemTruocIn()
    {
        $nguoiDung = Auth::user();

        // Lấy toàn bộ dữ liệu hồ sơ cá nhân
        $profileData = $this->getRawProfileData($nguoiDung->id);
        $profileData['nguoiDung'] = $nguoiDung;

        if (request()->input('encrypt') == 1) {
            self::ghiLog($nguoiDung->id, 'bao_mat', 'Đã mã hóa bảo mật mật khẩu cho hồ sơ PDF');
        } elseif (request()->input('download') == 1) {
            self::ghiLog($nguoiDung->id, 'bao_mat', 'Đã xuất và tải xuống hồ sơ PDF');
        } else {
            self::ghiLog($nguoiDung->id, 'truy_cap', 'Đã xem trước bản in hồ sơ A4');
        }

        return view('ho-so.xem-truoc-in', compact('nguoiDung', 'profileData'));
    }

    /**
     * Tải hồ sơ năng lực dạng PDF (chuyển hướng sang trang xem trước có cờ download)
     */
    public function taiHoSoPdf()
    {
        return redirect()->route('ho-so.xem-truoc-in', ['download' => 1]);
    }

    /**
     * Helper lấy toàn bộ dữ liệu thô của hồ sơ cá nhân.
     */
    private function getRawProfileData($userId)
    {
        $lienKetMxh = DB::table('lien_ket_mxh')
            ->where('id_nguoi_dung', $userId)
            ->orderBy('thu_tu')
            ->get();

        $hocVan = DB::table('hoc_van')
            ->where('id_nguoi_dung', $userId)
            ->orderByRaw('CASE WHEN trang_thai = "dang_hoc" OR nam_ket_thuc IS NULL THEN 1 ELSE 0 END DESC')
            ->orderBy('nam_ket_thuc', 'desc')
            ->orderBy('nam_bat_dau', 'desc')
            ->get();

        $kinhNghiem = DB::table('kinh_nghiem')
            ->where('id_nguoi_dung', $userId)
            ->orderBy('dang_lam_viec', 'desc')
            ->orderBy('ngay_ket_thuc', 'desc')
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();

        $duAn = DB::table('du_an')
            ->where('id_nguoi_dung', $userId)
            ->whereNull('ngay_xoa')
            ->orderBy('ngay_ket_thuc', 'desc')
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();

        // Lấy danh sách liên kết của các dự án
        $projectIds = $duAn->pluck('id')->toArray();
        $groupedLienKet = [];
        if (!empty($projectIds)) {
            $tatCaLienKet = DB::table('du_an_lien_ket')
                ->whereIn('id_du_an', $projectIds)
                ->orderBy('thu_tu', 'asc')
                ->get();
            foreach ($tatCaLienKet as $lk) {
                $groupedLienKet[$lk->id_du_an][] = $lk;
            }
        }

        foreach ($duAn as $item) {
            $item->mo_ta_ngan = null;
            $item->mo_ta_chi_tiet = $item->mo_ta;
            $item->lien_ket = null;
            
            if (isset($groupedLienKet[$item->id]) && !empty($groupedLienKet[$item->id])) {
                // Ưu tiên chọn các link loại demo, github, website
                $selectedLink = null;
                foreach ($groupedLienKet[$item->id] as $lk) {
                    if (in_array($lk->loai_lien_ket, ['demo', 'github', 'website'])) {
                        $selectedLink = $lk->duong_dan;
                        break;
                    }
                }
                $item->lien_ket = $selectedLink ?: $groupedLienKet[$item->id][0]->duong_dan;
            }
        }

        $chungChi = DB::table('chung_chi')
            ->where('id_nguoi_dung', $userId)
            ->orderBy('ngay_cap', 'desc')
            ->get();

        $thanhTuu = DB::table('thanh_tuu')
            ->where('id_nguoi_dung', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $ngonNgu = DB::table('nguoi_dung_ngon_ngu_lap_trinh')
            ->join('ngon_ngu_lap_trinh', 'nguoi_dung_ngon_ngu_lap_trinh.ngon_ngu_lap_trinh_id', '=', 'ngon_ngu_lap_trinh.id')
            ->where('nguoi_dung_id', $userId)
            ->orderBy('nguoi_dung_ngon_ngu_lap_trinh.noi_bat', 'desc')
            ->orderBy('ngon_ngu_lap_trinh.ten_ngon_ngu', 'asc')
            ->pluck('ten_ngon_ngu')
            ->toArray();

        $kyNang = DB::table('nguoi_dung_ky_nang_mem')
            ->join('ky_nang_mem', 'nguoi_dung_ky_nang_mem.ky_nang_mem_id', '=', 'ky_nang_mem.id')
            ->where('nguoi_dung_id', $userId)
            ->orderBy('nguoi_dung_ky_nang_mem.noi_bat', 'desc')
            ->orderBy('ky_nang_mem.ten_ky_nang', 'asc')
            ->pluck('ten_ky_nang')
            ->toArray();

        return [
            'lienKetMxh' => $lienKetMxh,
            'hocVan' => $hocVan,
            'kinhNghiem' => $kinhNghiem,
            'duAn' => $duAn,
            'chungChi' => $chungChi,
            'thanhTuu' => $thanhTuu,
            'ngonNgu' => $ngonNgu,
            'kyNang' => $kyNang,
        ];
    }

    /**
     * Hien thi trang Dashboard tong quan.
     */
    public function dashboard()
    {
        $nguoiDung = Auth::user();
        
        $userId = $nguoiDung->id;

        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

        // Tạo chữ cái tắt cho avatar
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

        // Thống kê số lượng
        $cvCount = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $userId)
            ->whereNull('ngay_xoa')
            ->count();

        $duAnCount = DB::table('du_an')
            ->where('id_nguoi_dung', $userId)
            ->whereNull('ngay_xoa')
            ->count();

        $hocVanCount = DB::table('hoc_van')
            ->where('id_nguoi_dung', $userId)
            ->count();

        $kinhNghiemCount = DB::table('kinh_nghiem')
            ->where('id_nguoi_dung', $userId)
            ->count();

        $chungChiCount = DB::table('chung_chi')
            ->where('id_nguoi_dung', $userId)
            ->count();

        $thanhTuuCount = DB::table('thanh_tuu')
            ->where('id_nguoi_dung', $userId)
            ->count();

        $suKienCount = DB::table('album_su_kien')
            ->where('id_nguoi_dung', $userId)
            ->count();

        // Độ hoàn thiện hồ sơ (tổng hợp 5 trường cơ bản)
        $fields = [
            'email' => 'Thư điện tử',
            'so_dien_thoai' => 'Số điện thoại',
            'dia_chi' => 'Khu vực sinh sống',
            'gioi_thieu' => 'Giới thiệu bản thân',
            'so_thich' => 'Sở thích cá nhân'
        ];
        $filledFields = 0;
        $missingFields = [];
        foreach ($fields as $key => $label) {
            if (!empty($nguoiDung->$key)) {
                $filledFields++;
            } else {
                $missingFields[] = $label;
            }
        }
        $doHoanThien = round(($filledFields / count($fields)) * 100);

        return view('ho-so.dashboard', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'cvCount', 'duAnCount', 'hocVanCount', 'kinhNghiemCount',
            'chungChiCount', 'thanhTuuCount', 'suKienCount', 'doHoanThien',
            'missingFields'
        ));
    }

    /**
     * Hien thi trang hanh trinh phat trien (Timeline).
     */
    public function hanhTrinh()
    {
        $nguoiDung = Auth::user();
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;

        // Tạo chữ cái viết tắt từ họ tên để hiển thị avatar
        $tenRutGon = 'ND';
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

        // Lấy các bản ghi người dùng từ 5 danh mục (học vấn, dự án, chứng chỉ, thành tựu, kinh nghiệm)
        $hocVan = DB::table('hoc_van')->where('id_nguoi_dung', $nguoiDung->id)->get();
        $duAn = DB::table('du_an')->where('id_nguoi_dung', $nguoiDung->id)->whereNull('ngay_xoa')->get();
        $chungChi = DB::table('chung_chi')->where('id_nguoi_dung', $nguoiDung->id)->get();
        $thanhTuu = DB::table('thanh_tuu')->where('id_nguoi_dung', $nguoiDung->id)->get();
        $kinhNghiem = DB::table('kinh_nghiem')->where('id_nguoi_dung', $nguoiDung->id)->get();

        $timelineItems = [];

        // 1. Học vấn mapping
        foreach ($hocVan as $item) {
            $resolvedDate = $item->nam_ket_thuc ? "{$item->nam_ket_thuc}-12-31" : ($item->nam_bat_dau ? "{$item->nam_bat_dau}-12-31" : date('Y-m-d'));
            $timelineItems[] = [
                'type' => 'hoc_van',
                'title' => $item->tieu_de,
                'subtitle' => $item->ten_truong,
                'date' => $resolvedDate,
                'display_date' => $item->nam_ket_thuc ? ($item->nam_bat_dau == $item->nam_ket_thuc ? $item->nam_bat_dau : "{$item->nam_bat_dau} - {$item->nam_ket_thuc}") : "{$item->nam_bat_dau} - Hiện tại",
                'original_data' => $item,
            ];
        }

        // 2. Dự án mapping
        foreach ($duAn as $item) {
            $resolvedDate = $item->ngay_ket_thuc ?: $item->ngay_bat_dau ?: ($item->ngay_tao ? date('Y-m-d', strtotime($item->ngay_tao)) : date('Y-m-d'));
            $batDauFormatted = $item->ngay_bat_dau ? date('m/Y', strtotime($item->ngay_bat_dau)) : '';
            $ketThucFormatted = $item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : ($item->ngay_bat_dau ? 'Hiện tại' : '');
            
            $displayDate = '';
            if ($batDauFormatted && $ketThucFormatted) {
                $displayDate = "{$batDauFormatted} - {$ketThucFormatted}";
            } elseif ($batDauFormatted) {
                $displayDate = "{$batDauFormatted} - Hiện tại";
            } elseif ($item->ngay_tao) {
                $displayDate = "Tạo ngày " . date('d/m/Y', strtotime($item->ngay_tao));
            } else {
                $displayDate = 'Chưa xác định thời gian';
            }

            $timelineItems[] = [
                'type' => 'du_an',
                'title' => $item->ten_du_an,
                'subtitle' => $item->vai_tro ?: 'Thành viên',
                'date' => $resolvedDate,
                'display_date' => $displayDate,
                'original_data' => $item,
            ];
        }

        // 3. Chứng chỉ mapping
        foreach ($chungChi as $item) {
            $resolvedDate = $item->ngay_het_han ?: $item->ngay_cap ?: date('Y-m-d');
            $capFormatted = $item->ngay_cap ? date('d/m/Y', strtotime($item->ngay_cap)) : '';
            $timelineItems[] = [
                'type' => 'chung_chi',
                'title' => $item->ten_chung_chi,
                'subtitle' => $item->to_chuc_cap,
                'date' => $resolvedDate,
                'display_date' => $item->ngay_cap ? ($item->ngay_het_han ? "Cấp ngày {$capFormatted} (Hết hạn: " . date('d/m/Y', strtotime($item->ngay_het_han)) . ")" : "Cấp ngày {$capFormatted} (Vô thời hạn)") : "Chưa xác định thời gian",
                'original_data' => $item,
            ];
        }

        // 4. Thành tựu mapping
        foreach ($thanhTuu as $item) {
            $resolvedDate = date('Y-m-d');
            if ($item->thoi_gian) {
                if (preg_match('/(\d{1,2})[\/\-](\d{4})/', $item->thoi_gian, $matches)) {
                    $month = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                    $resolvedDate = "{$matches[2]}-{$month}-01";
                } elseif (preg_match_all('/\d{4}/', $item->thoi_gian, $matches)) {
                    $lastYear = end($matches[0]);
                    $resolvedDate = "{$lastYear}-12-31";
                }
            }
            $timelineItems[] = [
                'type' => 'thanh_tuu',
                'title' => $item->ten_thanh_tuu,
                'subtitle' => $item->to_chuc_cap ?: 'Chưa cập nhật đơn vị',
                'date' => $resolvedDate,
                'display_date' => $item->thoi_gian ?: 'Chưa cập nhật thời gian',
                'original_data' => $item,
            ];
        }

        // 5. Kinh nghiệm mapping
        foreach ($kinhNghiem as $item) {
            $resolvedDate = ($item->dang_lam_viec ? null : $item->ngay_ket_thuc) ?: $item->ngay_bat_dau ?: date('Y-m-d');
            $batDauFormatted = $item->ngay_bat_dau ? date('m/Y', strtotime($item->ngay_bat_dau)) : '';
            $ketThucFormatted = $item->dang_lam_viec ? 'Hiện tại' : ($item->ngay_ket_thuc ? date('m/Y', strtotime($item->ngay_ket_thuc)) : 'Hiện tại');
            $timelineItems[] = [
                'type' => 'kinh_nghiem',
                'title' => $item->vi_tri_cong_viec,
                'subtitle' => $item->ten_cong_ty,
                'date' => $resolvedDate,
                'display_date' => $batDauFormatted ? "{$batDauFormatted} - {$ketThucFormatted}" : "Chưa xác định thời gian",
                'original_data' => $item,
            ];
        }

        // Sắp xếp các mục theo ngày giải quyết giảm dần (mới nhất trước).
        // Nếu các ngày giống nhau, bản ghi được tạo trước sẽ xếp trên (thứ tự tăng dần theo id).
        usort($timelineItems, function ($a, $b) {
            $dateCompare = strcmp($b['date'], $a['date']);
            if ($dateCompare !== 0) {
                return $dateCompare;
            }

            // Cùng ngày: kiểm tra xem có cùng loại không
            if ($a['type'] === $b['type']) {
                return $a['original_data']->id <=> $b['original_data']->id;
            }

            // Khác loại: kiểm tra ngày tạo ngay_tao
            $aCreated = isset($a['original_data']->ngay_tao) ? $a['original_data']->ngay_tao : null;
            $bCreated = isset($b['original_data']->ngay_tao) ? $b['original_data']->ngay_tao : null;

            if ($aCreated && $bCreated) {
                return strcmp($aCreated, $bCreated);
            } elseif ($aCreated) {
                return -1; // Tạo trước xếp lên trên
            } elseif ($bCreated) {
                return 1;
            }

            // Dự phòng: so sánh ID bản ghi
            return $a['original_data']->id <=> $b['original_data']->id;
        });

        // Nhóm các mục theo năm (để hiển thị nhãn thân thiện)
        $groupedTimeline = [];
        foreach ($timelineItems as $item) {
            $year = substr($item['date'], 0, 4);
            $friendlyDate = 'Năm ' . $year;
            $groupedTimeline[$friendlyDate][] = $item;
        }

        return view('ho-so.hanh-trinh', compact('nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon', 'groupedTimeline'));
    }
}
