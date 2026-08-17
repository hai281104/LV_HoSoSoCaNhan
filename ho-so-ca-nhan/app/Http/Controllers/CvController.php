<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AIService;

class CvController extends Controller
{
    /**
     * Giao diện danh sách CV của người dùng.
     */
    public function index()
    {
        $nguoiDung = Auth::user();

        // Thống tin hiển thị sidebar
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;
        $tenRutGon = $this->getTenRutGon($hoTen);

        // Lấy danh sách CV cá nhân (chưa xóa)
        $danhSachCv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->orderBy('la_cv_chinh', 'desc')
            ->orderBy('ngay_cap_nhat', 'desc')
            ->get();

        // Decode json tùy chỉnh cho mỗi CV
        foreach ($danhSachCv as $cv) {
            $cv->tuy_chinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];
        }

        // Lấy danh sách các mẫu CV có sẵn (trang_thai = hoat_dong)
        $templates = DB::table('mau_cv')
            ->where('trang_thai', 'hoat_dong')
            ->whereNull('ngay_xoa')
            ->get();

        $isMobile = self::isMobile();

        return view('ho-so.cv.index', compact(
            'nguoiDung',
            'hoTen',
            'chucDanh',
            'anhDaiDien',
            'tenRutGon',
            'danhSachCv',
            'templates',
            'isMobile'
        ));
    }

    /**
     * Tạo mới một CV (thủ công hoặc tự động).
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_cv' => ['required', 'string', 'min:2', 'max:30', 'regex:/^[\p{L}0-9\s\-_]+$/u'],
            'mo_ta_ngan' => ['nullable', 'string', 'max:200'],
            'kieu_cv' => ['required', 'in:thu_cong,tu_dong'],
            'ma_template' => ['required', 'string', 'exists:mau_cv,ma_mau_cv'],
        ], [
            'ten_cv.required' => 'Tên CV không được để trống.',
            'ten_cv.min' => 'Tên CV phải từ 2 đến 30 ký tự.',
            'ten_cv.max' => 'Tên CV phải từ 2 đến 30 ký tự.',
            'ten_cv.regex' => 'Tên CV không được chứa ký tự đặc biệt.',
            'mo_ta_ngan.max' => 'Mô tả ngắn tối đa 200 ký tự.',
            'kieu_cv.required' => 'Kiểu tạo CV là bắt buộc.',
            'kieu_cv.in' => 'Kiểu tạo CV không hợp lệ.',
            'ma_template.required' => 'Bạn phải chọn một mẫu CV.',
            'ma_template.exists' => 'Mẫu CV đã chọn không tồn tại.',
        ]);

        $nguoiDung = Auth::user();

        // Chặn tạo CV thủ công trên di động
        if (self::isMobile() && $request->input('kieu_cv') === 'thu_cong') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'thanh_cong' => false,
                    'thong_bao' => 'Trên thiết bị di động, bạn chỉ được phép tạo CV tự động.'
                ], 403);
            }
            return redirect()->route('ho-so.cv.index')->with('loi', 'Trên thiết bị di động, bạn chỉ được phép tạo CV tự động.');
        }

        // Kiểm tra xem đã có CV nào chưa. Nếu chưa thì đây sẽ là CV chính
        $daCoCv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->exists();
        $laCvChinh = $daCoCv ? 0 : 1;

        // Cấu hình dữ liệu tùy chỉnh mặc định
        $duLieuTuyChinh = [
            'kieu_cv' => $request->input('kieu_cv'),
            'mo_ta_ngan' => $request->input('mo_ta_ngan') ?: '',
            'anh_dai_dien' => $nguoiDung->anh_dai_dien ?: '',
            'mau_chu_dao' => '#1e3a8a', // Deep Blue làm màu chủ đạo mặc định
            'hien_thi_cac_muc' => [
                'hoc_van' => true,
                'kinh_nghiem' => true,
                'du_an' => true,
                'chung_chi' => true,
                'thanh_tuu' => true,
                'ky_nang' => true,
                'lien_ket' => true,
                'so_thich' => true,
            ],
            'thu_tu_cac_muc' => [
                'hoc_van',
                'kinh_nghiem',
                'du_an',
                'chung_chi',
                'thanh_tuu',
                'ky_nang',
                'lien_ket',
                'so_thich',
            ],
            'trang_thai' => 'nhap' // 'nhap' hoặc 'chinh'
        ];

        // Nếu tạo thủ công, mặc định các phần chi tiết chưa được tích chọn
        if ($request->input('kieu_cv') === 'thu_cong') {
            $duLieuTuyChinh['lua_chon_items'] = [
                'hoc_van' => [],
                'kinh_nghiem' => [],
                'du_an' => [],
                'chung_chi' => [],
                'thanh_tuu' => [],
                'ky_nang' => [],
                'ngon_ngu' => [],
                'lien_ket' => [],
            ];
        }

        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $nguoiDung->id,
            'ten_cv' => $request->input('ten_cv'),
            'ma_template' => $request->input('ma_template'),
            'la_cv_chinh' => $laCvChinh,
            'du_lieu_tuy_chinh' => json_encode($duLieuTuyChinh),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Tạo mới CV: ' . $request->input('ten_cv'));

        if ($request->input('kieu_cv') === 'tu_dong') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'thanh_cong' => true,
                    'thong_bao' => 'Tạo CV tự động thành công!',
                    'redirect_url' => route('ho-so.cv.index')
                ]);
            }
            return redirect()->route('ho-so.cv.index')->with('thong_bao', 'Tạo CV tự động thành công!');
        } else {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'thanh_cong' => true,
                    'thong_bao' => 'Tạo CV thành công! Hãy tùy chỉnh CV của bạn.',
                    'redirect_url' => route('ho-so.cv.edit', $id)
                ]);
            }
            return redirect()->route('ho-so.cv.edit', $id)->with('thong_bao', 'Tạo CV thành công! Hãy tùy chỉnh CV của bạn.');
        }
    }

    /**
     * Giao diện chỉnh sửa CV thủ công (Live Customizer Split Layout).
     */
    public function edit($id)
    {
        if (self::isMobile()) {
            return redirect()->route('ho-so.cv.index')->with('loi', 'Tính năng chỉnh sửa CV không khả dụng trên thiết bị di động.');
        }

        $nguoiDung = Auth::user();
        
        $cv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('id', $id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return redirect()->route('ho-so.cv.index')->with('loi', 'Không tìm thấy CV yêu cầu.');
        }

        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;
        $tenRutGon = $this->getTenRutGon($hoTen);

        // Decode tùy chỉnh
        $tuyChinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];

        // Lấy danh sách các mẫu CV có sẵn để đổi template
        $templates = DB::table('mau_cv')
            ->where('trang_thai', 'hoat_dong')
            ->whereNull('ngay_xoa')
            ->get();

        // Lấy toàn bộ dữ liệu hồ sơ cá nhân để truyền vào iframe preview
        $profileData = $this->getRawProfileData($nguoiDung->id);

        return view('ho-so.cv.chinh-sua', compact(
            'nguoiDung',
            'hoTen',
            'chucDanh',
            'anhDaiDien',
            'tenRutGon',
            'cv',
            'tuyChinh',
            'templates',
            'profileData'
        ));
    }

    /**
     * Lưu thông tin cập nhật tùy chỉnh CV qua AJAX.
     */
    public function update(Request $request, $id)
    {
        if (self::isMobile()) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Tính năng chỉnh sửa CV không khả dụng trên thiết bị di động.'], 403);
        }

        $nguoiDung = Auth::user();
        
        $cv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('id', $id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy CV.'], 404);
        }

        $request->validate([
            'ten_cv' => ['required', 'string', 'min:2', 'max:30', 'regex:/^[\p{L}0-9\s\-_]+$/u'],
            'mo_ta_ngan' => ['nullable', 'string', 'max:200'],
            'ma_template' => ['required', 'string', 'exists:mau_cv,ma_mau_cv'],
            'mau_chu_dao' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'hien_thi_cac_muc' => ['required', 'array'],
            'thu_tu_cac_muc' => ['required', 'array'],
            'anh_dai_dien_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'noi_dung_chinh_sua' => ['nullable', 'string'],
            'lua_chon_items' => ['nullable', 'array'],
        ], [
            'ten_cv.required' => 'Tên CV không được để trống.',
            'ten_cv.min' => 'Tên CV phải từ 2 đến 30 ký tự.',
            'ten_cv.max' => 'Tên CV phải từ 2 đến 30 ký tự.',
            'ten_cv.regex' => 'Tên CV không được chứa ký tự đặc biệt.',
            'mo_ta_ngan.max' => 'Mô tả ngắn tối đa 200 ký tự.',
            'ma_template.required' => 'Bạn phải chọn một mẫu CV.',
            'ma_template.exists' => 'Mẫu CV đã chọn không tồn tại.',
            'mau_chu_dao.required' => 'Màu sắc chủ đạo là bắt buộc.',
            'mau_chu_dao.regex' => 'Màu sắc chủ đạo phải là mã màu HEX hợp lệ.',
        ]);

        $tuyChinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];

        // Xử lý upload ảnh đại diện riêng cho CV nếu có
        $anhDaiDienPath = $tuyChinh['anh_dai_dien'] ?? $nguoiDung->anh_dai_dien;
        if ($request->hasFile('anh_dai_dien_file')) {
            $file = $request->file('anh_dai_dien_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadDir = public_path('uploads/cv-avatars/');
            
            try {
                if (!file_exists($uploadDir)) {
                    if (!@mkdir($uploadDir, 0755, true)) {
                        return response()->json([
                            'thanh_cong' => false,
                            'thong_bao' => 'Không thể tạo thư mục lưu trữ ảnh đại diện CV tại: "' . $uploadDir . '". Vui lòng kiểm tra quyền ghi thư mục cha.'
                        ], 500);
                    }
                }

                if (!is_writable($uploadDir)) {
                    return response()->json([
                        'thanh_cong' => false,
                        'thong_bao' => 'Thư mục "' . $uploadDir . '" không có quyền ghi. Vui lòng CHMOD thư mục này thành 755 hoặc 777.'
                    ], 500);
                }

                // Xóa ảnh cũ nếu có
                if ($anhDaiDienPath && strpos($anhDaiDienPath, 'uploads/cv-avatars/') === 0 && file_exists(public_path($anhDaiDienPath))) {
                    @unlink(public_path($anhDaiDienPath));
                }
                $file->move($uploadDir, $filename);
                $anhDaiDienPath = 'uploads/cv-avatars/' . $filename;
            } catch (\Exception $e) {
                return response()->json([
                    'thanh_cong' => false,
                    'thong_bao' => 'Lỗi khi lưu ảnh đại diện CV lên host (Thư mục: "' . $uploadDir . '"): ' . $e->getMessage()
                ], 500);
            }
        }

        // Cập nhật cấu hình JSON
        $tuyChinh['kieu_cv'] = $tuyChinh['kieu_cv'] ?? 'thu_cong';
        $tuyChinh['mo_ta_ngan'] = $request->input('mo_ta_ngan') ?: '';
        $tuyChinh['anh_dai_dien'] = $anhDaiDienPath;
        $tuyChinh['mau_chu_dao'] = $request->input('mau_chu_dao');
        $tuyChinh['noi_dung_chinh_sua'] = json_decode($request->input('noi_dung_chinh_sua'), true) ?: [];
        $luaChonInput = $request->input('lua_chon_items') ?: [];
        $cacMucConfig = ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu', 'ky_nang', 'ngon_ngu', 'lien_ket'];
        $luaChonLuu = [];
        foreach ($cacMucConfig as $muc) {
            $luaChonLuu[$muc] = (isset($luaChonInput[$muc]) && is_array($luaChonInput[$muc])) ? $luaChonInput[$muc] : [];
        }
        $tuyChinh['lua_chon_items'] = $luaChonLuu;
        
        // Chuyển đổi hiển thị sang dạng boolean
        $hienThi = [];
        foreach ($request->input('hien_thi_cac_muc') as $muc => $val) {
            $hienThi[$muc] = filter_var($val, FILTER_VALIDATE_BOOLEAN);
        }
        $tuyChinh['hien_thi_cac_muc'] = $hienThi;
        $tuyChinh['thu_tu_cac_muc'] = $request->input('thu_tu_cac_muc');

        DB::table('cv_ca_nhan')
            ->where('id', $id)
            ->update([
                'ten_cv' => $request->input('ten_cv'),
                'ma_template' => $request->input('ma_template'),
                'du_lieu_tuy_chinh' => json_encode($tuyChinh),
                'ngay_cap_nhat' => now(),
            ]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật thông tin CV: ' . $request->input('ten_cv'));

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Cập nhật CV thành công!',
            'anh_dai_dien_url' => asset($anhDaiDienPath)
        ]);
    }

    /**
     * Xem trước CV (Full view chuẩn in ấn A4).
     */
    public function preview($id)
    {
        $nguoiDung = Auth::user();
        
        $cv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('id', $id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return redirect()->route('ho-so.cv.index')->with('loi', 'Không tìm thấy CV yêu cầu.');
        }

        $tuyChinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];
        $kieuCv = $tuyChinh['kieu_cv'] ?? 'thu_cong';

        // Lấy dữ liệu hồ sơ gốc
        $profileData = $this->getRawProfileData($nguoiDung->id);
        $profileData['nguoiDung'] = $nguoiDung;

        // Nếu là CV thủ công, tiến hành lọc và sắp xếp theo lựa chọn
        if ($kieuCv === 'thu_cong' && isset($tuyChinh['lua_chon_items'])) {
            $profileData = $this->filterAndSortManualData($profileData, $tuyChinh['lua_chon_items']);
        }

        // Nếu là CV tự động, thực hiện chọn thông tin nổi bật (outstanding data filtering)
        if ($kieuCv === 'tu_dong') {
            $profileData = $this->filterOutstandingData($profileData);
            // Sử dụng các tùy chỉnh đã lưu trong du_lieu_tuy_chinh, chỉ fallback nếu chưa thiết lập
            $tuyChinh['mau_chu_dao'] = $tuyChinh['mau_chu_dao'] ?? '#1e3a8a';
            $tuyChinh['hien_thi_cac_muc'] = $tuyChinh['hien_thi_cac_muc'] ?? [
                'hoc_van' => true,
                'kinh_nghiem' => true,
                'du_an' => true,
                'chung_chi' => true,
                'thanh_tuu' => true,
                'ky_nang' => true,
                'lien_ket' => true,
                'so_thich' => true,
            ];
            $tuyChinh['thu_tu_cac_muc'] = $tuyChinh['thu_tu_cac_muc'] ?? ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu', 'ky_nang', 'lien_ket', 'so_thich'];
            $tuyChinh['anh_dai_dien'] = $tuyChinh['anh_dai_dien'] ?? ($nguoiDung->anh_dai_dien ?: '');
        }

        // Xác định template file
        if ($kieuCv === 'tu_dong') {
            $templateView = 'ho-so.cv-templates.default_auto';
        } else {
            $templateRecord = DB::table('mau_cv')->where('ma_mau_cv', $cv->ma_template)->first();
            $templateView = $templateRecord ? $templateRecord->duong_dan_file : 'ho-so.cv-templates.template_classic';
        }

        return response()
            ->view('ho-so.cv.xem-truoc', compact(
                'cv',
                'tuyChinh',
                'profileData',
                'templateView'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Đặt CV này làm CV chính.
     */
    public function setMain($id)
    {
        $nguoiDung = Auth::user();

        // Check ownership
        $cv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('id', $id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return redirect()->route('ho-so.cv.index')->with('loi', 'Không tìm thấy CV yêu cầu.');
        }

        // Tắt CV chính của các CV khác
        DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->update(['la_cv_chinh' => 0]);

        // Đặt CV này làm chính
        DB::table('cv_ca_nhan')
            ->where('id', $id)
            ->update(['la_cv_chinh' => 1, 'ngay_cap_nhat' => now()]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Đặt CV làm CV chính: ' . $cv->ten_cv);

        return redirect()->route('ho-so.cv.index')->with('thong_bao', 'Đã thay đổi CV chính thành công!');
    }

    /**
     * Xóa mềm CV.
     */
    public function destroy($id)
    {
        $nguoiDung = Auth::user();

        // Check ownership
        $cv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->where('id', $id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy CV yêu cầu.'], 404);
            }
            return redirect()->route('ho-so.cv.index')->with('loi', 'Không tìm thấy CV yêu cầu.');
        }

        // Xóa ảnh đại diện riêng của CV nếu có
        $tuyChinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];
        $anhDaiDienPath = $tuyChinh['anh_dai_dien'] ?? null;
        if ($anhDaiDienPath && strpos($anhDaiDienPath, 'uploads/cv-avatars/') === 0 && file_exists(public_path($anhDaiDienPath))) {
            @unlink(public_path($anhDaiDienPath));
        }

        // Thực hiện xóa mềm
        DB::table('cv_ca_nhan')
            ->where('id', $id)
            ->update(['ngay_xoa' => now()]);

        self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa CV: ' . $cv->ten_cv);

        // Nếu xóa đúng CV chính, đặt một CV khác làm CV chính (nếu có)
        if ($cv->la_cv_chinh) {
            $otherCv = DB::table('cv_ca_nhan')
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->whereNull('ngay_xoa')
                ->first();
            if ($otherCv) {
                DB::table('cv_ca_nhan')->where('id', $otherCv->id)->update(['la_cv_chinh' => 1]);
            }
        }
 
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Đã xóa CV thành công!']);
        }
        return redirect()->route('ho-so.cv.index')->with('thong_bao', 'Đã xóa CV thành công!');
    }

    /**
     * Helper tạo tên rút gọn cho avatar chữ cái.
     */
    private function getTenRutGon($hoTen)
    {
        if ($hoTen) {
            $cacTu = explode(' ', trim($hoTen));
            if (count($cacTu) >= 2) {
                $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
            } else {
                $tenRutGon = mb_substr($hoTen, 0, 2);
            }
            return mb_strtoupper($tenRutGon);
        }
        return 'ND';
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
     * Helper lọc "Thông tin nổi bật" cho CV tự động.
     */
    private function filterOutstandingData($data)
    {
        // Helper: lấy mục nổi bật, nếu không có thì fallback lấy N mục đầu
        $layNoiBat = function ($collection, $limit) {
            $noiBat = $collection->where('noi_bat', 1);
            return $noiBat->count() > 0 ? $noiBat : $collection->take($limit);
        };

        // 1. Học vấn: ưu tiên nổi bật, fallback 2 mục
        $data['hocVan'] = $layNoiBat(
            $data['hocVan']->sortBy(fn($item) => $item->trang_thai === 'dang_hoc' ? 0 : 1),
            2
        );

        // 2. Kinh nghiệm: ưu tiên nổi bật, fallback 3 mục
        $data['kinhNghiem'] = $layNoiBat($data['kinhNghiem'], 3);

        // 3. Dự án: ưu tiên nổi bật, fallback 3 mục
        $data['duAn'] = $layNoiBat($data['duAn'], 3);

        // 4. Chứng chỉ: ưu tiên nổi bật, fallback 3 mục
        $data['chungChi'] = $layNoiBat($data['chungChi'], 3);

        // 5. Thành tựu: ưu tiên nổi bật, fallback 3 mục
        $data['thanhTuu'] = $layNoiBat($data['thanhTuu'], 3);

        // 6. Kỹ năng & Ngôn ngữ: Tối đa 10 kỹ năng tổng hợp
        $data['ngonNgu'] = array_slice($data['ngonNgu'], 0, 5);
        $data['kyNang']  = array_slice($data['kyNang'],  0, 5);

        return $data;
    }

    /**
     * Lọc và sắp xếp dữ liệu CV thủ công theo cấu hình người dùng kéo thả & chọn lọc.
     */
    private function filterAndSortManualData($data, $luaChon)
    {
        $categories = [
            'hocVan' => 'hoc_van',
            'kinhNghiem' => 'kinh_nghiem',
            'duAn' => 'du_an',
            'chungChi' => 'chung_chi',
            'thanhTuu' => 'thanh_tuu',
            'lienKetMxh' => 'lien_ket'
        ];

        foreach ($categories as $dataKey => $configKey) {
            if (isset($luaChon[$configKey]) && is_array($luaChon[$configKey])) {
                $allowedIds = array_map('intval', $luaChon[$configKey]);
                
                $sorted = collect();
                foreach ($allowedIds as $id) {
                    $item = collect($data[$dataKey])->firstWhere('id', $id);
                    if ($item) {
                        $sorted->push($item);
                    }
                }
                $data[$dataKey] = $sorted;
            } else {
                $data[$dataKey] = collect();
            }
        }

        // Đối với kỹ năng và ngôn ngữ là mảng chuỗi
        $stringCategories = [
            'ngonNgu' => 'ngon_ngu',
            'kyNang' => 'ky_nang'
        ];

        foreach ($stringCategories as $dataKey => $configKey) {
            if (isset($luaChon[$configKey]) && is_array($luaChon[$configKey])) {
                $allowedStrings = $luaChon[$configKey];
                $sorted = [];
                foreach ($allowedStrings as $str) {
                    if (in_array($str, $data[$dataKey])) {
                        $sorted[] = $str;
                    }
                }
                $data[$dataKey] = $sorted;
            } else {
                $data[$dataKey] = [];
            }
        }

        return $data;
    }

    /**
     * Tự động tạo CV bằng AI
     */
    public function storeWithAI(Request $request, AIService $aiService)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        $nguoiDung = Auth::user();

        // Lấy dữ liệu hồ sơ hiện tại
        $profileData = [
            'ho_ten' => $nguoiDung->ho_ten,
            'chuc_danh' => $nguoiDung->chuc_danh,
            'email' => $nguoiDung->email,
            'sdt' => $nguoiDung->so_dien_thoai,
            'dia_chi' => $nguoiDung->dia_chi,
        ];
        $profileData = array_merge($profileData, $this->getRawProfileData($nguoiDung->id));

        // Gọi AI Service
        $cvData = $aiService->generateCv($request->input('prompt'), $profileData);

        if (!$cvData) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không thể kết nối với AI lúc này. Vui lòng thử lại sau.'], 500);
        }

        // Kiểm tra xem đã có CV nào chưa
        $daCoCv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->exists();
        $laCvChinh = $daCoCv ? 0 : 1;

        // Lưu vào DB
        $cvId = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $nguoiDung->id,
            'ten_cv' => $cvData['tieu_de'] ?? 'CV Tạo bởi AI',
            'ma_template' => $cvData['ma_template'] ?? 'template_classic',
            'la_cv_chinh' => $laCvChinh,
            'du_lieu_tuy_chinh' => json_encode([
                'ho_ten' => $nguoiDung->ho_ten,
                'chuc_danh' => $nguoiDung->chuc_danh,
                'anh_dai_dien' => $nguoiDung->anh_dai_dien,
                'email' => $nguoiDung->email,
                'sdt' => $nguoiDung->so_dien_thoai,
                'dia_chi' => $nguoiDung->dia_chi,
                'muc_tieu' => $cvData['muc_tieu_nghe_nghiep'] ?? '',
                'kinh_nghiem' => $cvData['kinh_nghiem'] ?? '',
                'hoc_van' => $cvData['hoc_van'] ?? '',
                'ky_nang' => $cvData['ky_nang'] ?? '',
                'du_an' => $cvData['du_an'] ?? '',
                'chung_chi' => $cvData['chung_chi'] ?? '',
                'hoat_dong' => $cvData['hoat_dong'] ?? '',
                'mau_chu_dao' => $cvData['mau_chu_dao'] ?? '#1e3a8a'
            ]),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Tạo CV bằng AI thành công!',
            'redirect' => route('ho-so.cv.edit', ['id' => $cvId])
        ]);
    }

    /**
     * Viết lại văn bản bằng AI
     */
    public function aiImproveText(Request $request, AIService $aiService)
    {
        $request->validate([
            'text' => 'required|string|max:3000'
        ]);

        $improvedText = $aiService->improveText($request->input('text'));

        return response()->json([
            'thanh_cong' => true,
            'improved_text' => $improvedText
        ]);
    }

    /**
     * Đánh giá CV bằng AI
     */
    public function aiEvaluate($id, Request $request, AIService $aiService)
    {
        $nguoiDung = Auth::user();
        
        $cv = DB::table('cv_ca_nhan')
            ->where('id', $id)
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy CV'], 404);
        }

        // Lấy toàn bộ dữ liệu hồ sơ thực tế của người dùng
        $profileData = [
            'ho_ten' => $nguoiDung->ho_ten,
            'chuc_danh' => $nguoiDung->chuc_danh,
            'email' => $nguoiDung->email,
            'so_dien_thoai' => $nguoiDung->so_dien_thoai,
            'dia_chi' => $nguoiDung->dia_chi,
        ];
        $profileData = array_merge($profileData, $this->getRawProfileData($nguoiDung->id));

        $cvData = [
            'ten_cv' => $cv->ten_cv,
            'du_lieu_tuy_chinh' => json_decode($cv->du_lieu_tuy_chinh, true),
            'du_lieu_ho_so_goc' => $profileData
        ];

        $evaluation = $aiService->evaluateCv($cvData);

        if (!$evaluation) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi kết nối AI'], 500);
        }

        return response()->json([
            'thanh_cong' => true,
            'evaluation' => $evaluation
        ]);
    }
}
