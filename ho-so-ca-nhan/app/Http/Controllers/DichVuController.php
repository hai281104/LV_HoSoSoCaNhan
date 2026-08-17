<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DichVuController extends Controller
{
    /**
     * Giao diện quản lý dịch vụ cá nhân & cộng đồng.
     */
    public function index()
    {
        $nguoiDung = Auth::user();

        // Thông tin hiển thị sidebar
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Chưa cập nhật';
        $anhDaiDien = $nguoiDung->anh_dai_dien;
        $tenRutGon = $this->getTenRutGon($hoTen);

        // Lấy danh sách CV cá nhân để đính kèm
        $danhSachCv = DB::table('cv_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->whereNull('ngay_xoa')
            ->orderBy('la_cv_chinh', 'desc')
            ->orderBy('ngay_cap_nhat', 'desc')
            ->get();

        // 1. Tab cá nhân: Dịch vụ của bản thân
        $dichVuCaNhan = DB::table('dich_vu_ca_nhan')
            ->where('id_nguoi_dung', $nguoiDung->id)
            ->orderBy('ngay_cap_nhat', 'desc')
            ->get();

        // Map tên CV cho dễ hiển thị
        foreach ($dichVuCaNhan as $dv) {
            $dv->ten_cv = '';
            if ($dv->id_cv) {
                $cv = DB::table('cv_ca_nhan')->where('id', $dv->id_cv)->first();
                if ($cv) {
                    $dv->ten_cv = $cv->ten_cv;
                }
            }
        }

        // 2. Tab cộng đồng: Dịch vụ của người dùng khác (chỉ hiển thị đã được admin duyệt + người dùng đặt hiển thị)
        $dichVuCongDong = DB::table('dich_vu_ca_nhan')
            ->join('nguoi_dung', 'dich_vu_ca_nhan.id_nguoi_dung', '=', 'nguoi_dung.id')
            ->where('dich_vu_ca_nhan.id_nguoi_dung', '!=', $nguoiDung->id)
            ->where('dich_vu_ca_nhan.trang_thai', 1)
            ->where('dich_vu_ca_nhan.trang_thai_duyet', 1)
            ->select('dich_vu_ca_nhan.*', 'nguoi_dung.ho_ten as ten_nguoi_dung', 'nguoi_dung.chuc_danh as chuc_danh_nguoi_dung', 'nguoi_dung.anh_dai_dien as anh_nguoi_dung')
            ->orderBy('dich_vu_ca_nhan.ngay_cap_nhat', 'desc')
            ->get();

        // Map tên CV cho dễ hiển thị
        foreach ($dichVuCongDong as $dv) {
            $dv->ten_cv = '';
            if ($dv->id_cv) {
                $cv = DB::table('cv_ca_nhan')->where('id', $dv->id_cv)->first();
                if ($cv) {
                    $dv->ten_cv = $cv->ten_cv;
                }
            }
        }

        return view('ho-so.dich-vu', compact(
            'nguoiDung',
            'hoTen',
            'chucDanh',
            'anhDaiDien',
            'tenRutGon',
            'danhSachCv',
            'dichVuCaNhan',
            'dichVuCongDong'
        ));
    }

    /**
     * Lưu hoặc cập nhật dịch vụ cá nhân.
     */
    public function luuDichVu(Request $request)
    {
        $nguoiDung = Auth::user();

        // Sanitize input to prevent XSS and clean contact info
        if ($request->has('ten_dich_vu')) {
            $request->merge(['ten_dich_vu' => strip_tags(trim($request->input('ten_dich_vu')))]);
        }
        if ($request->has('mo_ta')) {
            $request->merge(['mo_ta' => strip_tags(trim($request->input('mo_ta')))]);
        }
        if ($request->has('zalo')) {
            $request->merge(['zalo' => preg_replace('/[\s.-]/', '', trim($request->input('zalo')))]);
        }
        if ($request->has('gmail')) {
            $request->merge(['gmail' => strtolower(trim($request->input('gmail')))]);
        }

        $request->validate([
            'id'          => ['nullable', 'integer'],
            'ten_dich_vu' => ['required', 'string', 'min:2', 'max:50'],
            'phan_loai'   => ['required', 'string', 'in:lap_trinh_web,toi_uu_sql,thiet_ke_uiux,lap_trinh_mobile,devops_cloud,kiem_thu,an_ninh_mang,phan_tich_du_lieu,tri_tue_nhan_tao,viet_lach_content,quan_tri_du_an,khac'],
            'mo_ta'       => ['required', 'string', 'max:2000'],
            'zalo'        => ['required', 'string', 'max:20', 'regex:/^(0|\+84)(3|5|7|8|9)[0-9]{8}$/'],
            'gmail'       => ['required', 'email', 'max:100'],
            'id_cv'       => ['nullable', 'integer', 'exists:cv_ca_nhan,id'],
        ], [
            'ten_dich_vu.required' => 'Tên dịch vụ không được để trống.',
            'ten_dich_vu.min'      => 'Tên dịch vụ phải từ 2 đến 50 ký tự.',
            'ten_dich_vu.max'      => 'Tên dịch vụ không được vượt quá 50 ký tự.',
            'phan_loai.required'   => 'Phân loại dịch vụ là bắt buộc.',
            'phan_loai.in'         => 'Phân loại dịch vụ không hợp lệ.',
            'mo_ta.required'       => 'Mô tả dịch vụ là bắt buộc.',
            'mo_ta.max'            => 'Mô tả dịch vụ không được vượt quá 2000 ký tự.',
            'zalo.required'        => 'Thông tin liên hệ Zalo là bắt buộc.',
            'zalo.regex'           => 'Số Zalo không đúng định dạng (VD: 0912345678 hoặc +84912345678).',
            'zalo.max'             => 'Số Zalo không được vượt quá 20 ký tự.',
            'gmail.required'       => 'Gmail liên hệ là bắt buộc.',
            'gmail.email'          => 'Gmail không đúng định dạng email.',
            'gmail.max'            => 'Gmail không được vượt quá 100 ký tự.',
            'id_cv.exists'         => 'CV đính kèm không tồn tại.',
        ]);

        $id = $request->input('id');
        $idCv = $request->input('id_cv') ?: null;

        // Nếu có chọn CV, kiểm tra quyền sở hữu
        if ($idCv) {
            $cvExists = DB::table('cv_ca_nhan')
                ->where('id', $idCv)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->whereNull('ngay_xoa')
                ->exists();
            if (!$cvExists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Bạn không sở hữu CV này.'], 403);
            }
        }

        $data = [
            'ten_dich_vu'   => $request->input('ten_dich_vu'),
            'phan_loai'     => $request->input('phan_loai'),
            'mo_ta'         => $request->input('mo_ta'),
            'zalo'          => $request->input('zalo'),
            'gmail'         => $request->input('gmail'),
            'id_cv'         => $idCv,
            'ngay_cap_nhat' => now(),
        ];

        try {
            if ($id) {
                // Cập nhật dịch vụ
                $exists = DB::table('dich_vu_ca_nhan')
                    ->where('id', $id)
                    ->where('id_nguoi_dung', $nguoiDung->id)
                    ->exists();

                if (!$exists) {
                    return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dịch vụ cần cập nhật.'], 403);
                }

                DB::table('dich_vu_ca_nhan')->where('id', $id)->update($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Cập nhật dịch vụ cá nhân: ' . $data['ten_dich_vu']);
                // Sau khi cập nhật, đặt lại trạng thái chờ duyệt
                DB::table('dich_vu_ca_nhan')->where('id', $id)->update([
                    'trang_thai_duyet' => 0,
                    'trang_thai'       => 0,
                    'ly_do_tu_choi'    => null,
                ]);
                $msg = 'Cập nhật dịch vụ thành công! Dịch vụ đang chờ admin duyệt lại.';
            } else {
                // Đăng dịch vụ mới - mặc định chờ duyệt
                $data['id_nguoi_dung'] = $nguoiDung->id;
                $data['ngay_tao'] = now();
                $data['trang_thai'] = 0;          // Ẩn khỏi cộng đồng cho đến khi được duyệt
                $data['trang_thai_duyet'] = 0;    // Chờ admin duyệt
                DB::table('dich_vu_ca_nhan')->insert($data);
                self::ghiLog($nguoiDung->id, 'chinh_sua', 'Đăng ký dịch vụ cá nhân mới (chờ duyệt): ' . $data['ten_dich_vu']);
                $msg = 'Đăng ký dịch vụ thành công! Dịch vụ đang chờ admin duyệt.';
            }

            return response()->json(['thanh_cong' => true, 'thong_bao' => $msg]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa dịch vụ cá nhân.
     */
    public function xoaDichVu($id)
    {
        $nguoiDung = Auth::user();

        try {
            $exists = DB::table('dich_vu_ca_nhan')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->exists();

            if (!$exists) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dịch vụ để xóa.'], 403);
            }

            $dv = DB::table('dich_vu_ca_nhan')->where('id', $id)->first();
            DB::table('dich_vu_ca_nhan')->where('id', $id)->delete();
            self::ghiLog($nguoiDung->id, 'chinh_sua', 'Xóa dịch vụ cá nhân: ' . ($dv ? $dv->ten_dich_vu : 'ID ' . $id));
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Xóa dịch vụ thành công!']);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Đổi trạng thái hiển thị (ẩn/hiện) dịch vụ cá nhân.
     */
    public function doiTrangThai($id)
    {
        $nguoiDung = Auth::user();

        try {
            $dichVu = DB::table('dich_vu_ca_nhan')
                ->where('id', $id)
                ->where('id_nguoi_dung', $nguoiDung->id)
                ->first();

            if (!$dichVu) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy dịch vụ.'], 403);
            }

            $newStatus = $dichVu->trang_thai ? 0 : 1;

            DB::table('dich_vu_ca_nhan')->where('id', $id)->update([
                'trang_thai'    => $newStatus,
                'ngay_cap_nhat' => now(),
            ]);

            $statusText = $newStatus ? 'hiển thị' : 'ẩn';
            self::ghiLog($nguoiDung->id, 'chinh_sua', "Thay đổi trạng thái dịch vụ '{$dichVu->ten_dich_vu}' thành: {$statusText}");

            $msg = $newStatus
                ? 'Dịch vụ đã được hiển thị lên cộng đồng.'
                : 'Dịch vụ đã được ẩn khỏi cộng đồng.';

            return response()->json([
                'thanh_cong'  => true,
                'trang_thai'  => $newStatus,
                'thong_bao'   => $msg,
            ]);
        } catch (\Exception $e) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xem CV được đính kèm vào dịch vụ và che thông tin nhạy cảm.
     */
    public function xemCv($id)
    {
        // 1. Kiểm tra dịch vụ có tồn tại
        $dichVu = DB::table('dich_vu_ca_nhan')->where('id', $id)->first();
        if (!$dichVu || !$dichVu->id_cv) {
            return redirect()->back()->with('loi', 'Dịch vụ hoặc CV không tồn tại.');
        }

        // 2. Lấy thông tin CV đính kèm
        $cv = DB::table('cv_ca_nhan')
            ->where('id', $dichVu->id_cv)
            ->whereNull('ngay_xoa')
            ->first();

        if (!$cv) {
            return redirect()->back()->with('loi', 'CV đã bị gỡ hoặc không tồn tại.');
        }

        // 3. Lấy thông tin chủ sở hữu CV và che thông tin nhạy cảm
        $owner = DB::table('nguoi_dung')->where('id', $cv->id_nguoi_dung)->first();
        if (!$owner) {
            return redirect()->back()->with('loi', 'Không tìm thấy thông tin chủ sở hữu.');
        }

        // Giải mã AES-256 cho dữ liệu thô từ DB::table
        $owner = \App\Models\User::decryptUserRecord($owner);

        // Tạo bản sao chủ sở hữu và che thông tin
        $maskedOwner = clone $owner;
        $maskedOwner->email = $this->maskValue($owner->email, 'email');
        $maskedOwner->so_dien_thoai = $this->maskValue($owner->so_dien_thoai, 'so_dien_thoai');
        $maskedOwner->dia_chi = $this->maskValue($owner->dia_chi, 'dia_chi');

        // 4. Lấy dữ liệu profile thô của owner
        $profileData = $this->getRawProfileData($owner->id);
        $profileData['nguoiDung'] = $maskedOwner;

        // 5. Decode tuy_chinh và che các thông tin chỉnh sửa tùy chọn trong JSON
        $tuyChinh = json_decode($cv->du_lieu_tuy_chinh, true) ?: [];
        if (isset($tuyChinh['noi_dung_chinh_sua'])) {
            if (isset($tuyChinh['noi_dung_chinh_sua']['email'])) {
                $tuyChinh['noi_dung_chinh_sua']['email'] = $this->maskValue($tuyChinh['noi_dung_chinh_sua']['email'], 'email');
            }
            if (isset($tuyChinh['noi_dung_chinh_sua']['so_dien_thoai'])) {
                $tuyChinh['noi_dung_chinh_sua']['so_dien_thoai'] = $this->maskValue($tuyChinh['noi_dung_chinh_sua']['so_dien_thoai'], 'so_dien_thoai');
            }
            if (isset($tuyChinh['noi_dung_chinh_sua']['dia_chi'])) {
                $tuyChinh['noi_dung_chinh_sua']['dia_chi'] = $this->maskValue($tuyChinh['noi_dung_chinh_sua']['dia_chi'], 'dia_chi');
            }
        }

        $kieuCv = $tuyChinh['kieu_cv'] ?? 'thu_cong';

        // Lọc dữ liệu theo kiểu CV
        if ($kieuCv === 'thu_cong' && isset($tuyChinh['lua_chon_items'])) {
            $profileData = $this->filterAndSortManualData($profileData, $tuyChinh['lua_chon_items']);
        }
        if ($kieuCv === 'tu_dong') {
            $profileData = $this->filterOutstandingData($profileData);
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
            $tuyChinh['anh_dai_dien'] = $tuyChinh['anh_dai_dien'] ?? ($owner->anh_dai_dien ?: '');
        }

        // Xác định template file
        if ($kieuCv === 'tu_dong') {
            $templateView = 'ho-so.cv-templates.default_auto';
        } else {
            $templateRecord = DB::table('mau_cv')->where('ma_mau_cv', $cv->ma_template)->first();
            $templateView = $templateRecord ? $templateRecord->duong_dan_file : 'ho-so.cv-templates.template_classic';
        }

        // Thiết lập biến để chuyển hướng nút Back
        $isPublicView = true;

        return response()
            ->view('ho-so.cv.xem-truoc', compact(
                'cv',
                'tuyChinh',
                'profileData',
                'templateView',
                'isPublicView'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Hàm che thông tin nhạy cảm.
     */
    private function maskValue($value, $type)
    {
        if (empty($value)) return '';

        if ($type === 'email') {
            $parts = explode('@', $value);
            if (count($parts) === 2) {
                $name = $parts[0];
                $domain = $parts[1];
                if (strlen($name) <= 2) {
                    return substr($name, 0, 1) . '***@' . $domain;
                }
                return substr($name, 0, 2) . str_repeat('*', max(3, strlen($name) - 2)) . '@' . $domain;
            }
            return '******';
        }

        if ($type === 'so_dien_thoai') {
            if (strlen($value) <= 6) {
                return str_repeat('*', strlen($value));
            }
            return substr($value, 0, 3) . '***' . substr($value, -3);
        }

        if ($type === 'dia_chi') {
            return str_repeat('*', 8);
        }

        return $value;
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
     * Lấy toàn bộ dữ liệu thô của hồ sơ cá nhân.
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
        $layNoiBat = function ($collection, $limit) {
            $noiBat = $collection->where('noi_bat', 1);
            return $noiBat->count() > 0 ? $noiBat : $collection->take($limit);
        };

        $data['hocVan'] = $layNoiBat(
            $data['hocVan']->sortBy(fn($item) => $item->trang_thai === 'dang_hoc' ? 0 : 1),
            2
        );

        $data['kinhNghiem'] = $layNoiBat($data['kinhNghiem'], 3);
        $data['duAn'] = $layNoiBat($data['duAn'], 3);
        $data['chungChi'] = $layNoiBat($data['chungChi'], 3);
        $data['thanhTuu'] = $layNoiBat($data['thanhTuu'], 3);

        $data['ngonNgu'] = array_slice($data['ngonNgu'], 0, 5);
        $data['kyNang']  = array_slice($data['kyNang'],  0, 5);

        return $data;
    }

    /**
     * Lọc và sắp xếp dữ liệu CV thủ công theo cấu hình.
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
     * Lấy toàn bộ dịch vụ đã duyệt & hiển thị của một người dùng cụ thể (có tìm kiếm, lọc, phân trang).
     */
    public function layDichVuCuaNguoiDung(Request $request, $userId)
    {
        $tuKhoa = $request->input('tu_khoa');
        $linhVuc = $request->input('linh_vuc');
        $sapXep = $request->input('sap_xep', 'newest');
        $page = intval($request->input('page', 1));
        $perPage = 4; // 4 items per page inside modal

        $query = DB::table('dich_vu_ca_nhan')
            ->where('id_nguoi_dung', $userId)
            ->where('trang_thai', 1)
            ->where('trang_thai_duyet', 1);

        if (!empty($tuKhoa)) {
            $query->where(function ($q) use ($tuKhoa) {
                $q->where('ten_dich_vu', 'like', '%' . $tuKhoa . '%')
                  ->orWhere('mo_ta', 'like', '%' . $tuKhoa . '%');
            });
        }

        if (!empty($linhVuc)) {
            $query->where('phan_loai', $linhVuc);
        }

        if ($sapXep === 'oldest') {
            $query->orderBy('ngay_cap_nhat', 'asc');
        } else {
            $query->orderBy('ngay_cap_nhat', 'desc');
        }

        $total = $query->count();
        $offset = ($page - 1) * $perPage;
        
        $dichVu = $query->offset($offset)->limit($perPage)->get();

        // Map tên CV cho dễ hiển thị
        foreach ($dichVu as $dv) {
            $dv->ten_cv = '';
            if ($dv->id_cv) {
                $cv = DB::table('cv_ca_nhan')->where('id', $dv->id_cv)->first();
                if ($cv) {
                    $dv->ten_cv = $cv->ten_cv;
                }
            }
        }

        return response()->json([
            'thanh_cong' => true,
            'dieu_huong' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => (int)ceil($total / $perPage),
            ],
            'dich_vu' => $dichVu,
        ]);
    }
}
