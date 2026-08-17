<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MauCvController extends Controller
{
    /**
     * Hiển thị danh sách mẫu CV.
     */
    public function index(Request $request)
    {
        $nguoiDung = Auth::user();
        $hoTen = $nguoiDung->ho_ten;
        $chucDanh = $nguoiDung->chuc_danh ?? 'Quản trị viên';
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
            $tenRutGon = 'AD';
        }

        // Lấy bộ lọc từ Request
        $search = $request->input('search');
        $trangThai = $request->input('trang_thai');

        $query = DB::table('mau_cv')
            ->whereNull('ngay_xoa');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ma_mau_cv', 'like', '%' . $search . '%')
                  ->orWhere('ten_mau', 'like', '%' . $search . '%');
            });
        }

        if (!empty($trangThai)) {
            $query->where('trang_thai', $trangThai);
        }

        $danhSachMauCv = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        foreach ($danhSachMauCv as $tpl) {
            $viewPath = resource_path('views/' . str_replace('.', '/', $tpl->duong_dan_file) . '.blade.php');
            $tpl->noi_dung_view = (file_exists($viewPath) && is_file($viewPath)) ? file_get_contents($viewPath) : '';
        }

        return view('admin.mau-cv', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'search', 'trangThai', 'danhSachMauCv'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_mau_cv' => [
                'required', 'string', 'max:50', 'regex:/^[a-z0-9_\-]+$/', 'unique:mau_cv,ma_mau_cv',
                function ($attribute, $value, $fail) {
                    if ($value === 'default_auto') {
                        $fail('Mã mẫu CV "default_auto" là từ khóa hệ thống dành cho CV tự động và không thể sử dụng.');
                    }
                }
            ],
            'ten_mau' => 'required|string|max:150',
            'phien_ban' => 'nullable|string|max:20',
            'trang_thai' => 'required|in:hoat_dong,tam_an',
            'anh_xem_truoc_file' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'noi_dung_view' => 'required|string|min:10',
        ], [
            'ma_mau_cv.required' => 'Mã mẫu CV không được để trống.',
            'ma_mau_cv.unique' => 'Mã mẫu CV đã tồn tại trên hệ thống.',
            'ma_mau_cv.regex' => 'Mã mẫu CV chỉ được chứa chữ thường không dấu, số, gạch dưới và gạch ngang.',
            'ten_mau.required' => 'Tên mẫu CV không được để trống.',
            'anh_xem_truoc_file.required' => 'Ảnh xem trước không được để trống.',
            'anh_xem_truoc_file.image' => 'File tải lên phải là hình ảnh.',
            'anh_xem_truoc_file.max' => 'Ảnh xem trước không vượt quá 2MB.',
            'noi_dung_view.required' => 'Nội dung mã nguồn Blade View không được để trống.',
            'noi_dung_view.min' => 'Nội dung mã nguồn phải chứa ít nhất 10 ký tự.',
        ]);

        try {
            $anhPath = null;
            if ($request->hasFile('anh_xem_truoc_file')) {
                $file = $request->file('anh_xem_truoc_file');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                $uploadDir = public_path('uploads/cv-templates');
                if (!file_exists($uploadDir)) {
                    if (!@mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                        return redirect()->back()->withInput()->with('error', 'Không thể tạo thư mục lưu trữ ảnh xem trước tại: ' . $uploadDir . '. Vui lòng kiểm tra và cấp quyền ghi cho thư mục này trên cPanel.');
                    }
                }
                
                $file->move($uploadDir, $filename);
                $anhPath = 'uploads/cv-templates/' . $filename;
            }

            // Tạo tệp tin view blade vật lý
            $maMauCv = $request->input('ma_mau_cv');
            $duongDanFile = 'ho-so.cv-templates.' . $maMauCv;
            $viewPath = resource_path('views/ho-so/cv-templates/' . $maMauCv . '.blade.php');
            
            $directory = dirname($viewPath);
            if (!file_exists($directory)) {
                if (!@mkdir($directory, 0775, true) && !is_dir($directory)) {
                    return redirect()->back()->withInput()->with('error', 'Không thể tạo thư mục chứa giao diện tại: ' . $directory . '. Vui lòng kiểm tra quyền ghi trên thư mục resources/views của cPanel.');
                }
            }
            
            if (@file_put_contents($viewPath, $request->input('noi_dung_view')) === false) {
                return redirect()->back()->withInput()->with('error', 'Không thể ghi nội dung vào file giao diện: ' . $viewPath . '. Vui lòng kiểm tra quyền ghi (Write Permission) trên thư mục hoặc file này.');
            }
            
            $kichThuoc = @filesize($viewPath) ?: 0;

            DB::table('mau_cv')->insert([
                'ma_mau_cv' => $maMauCv,
                'ten_mau' => $request->input('ten_mau'),
                'phien_ban' => $request->input('phien_ban') ?: 'v1.0',
                'kich_thuoc_file' => $kichThuoc,
                'anh_xem_truoc' => $anhPath,
                'duong_dan_file' => $duongDanFile,
                'trang_thai' => $request->input('trang_thai'),
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now(),
            ]);

            Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã thêm mới mẫu CV: ' . $request->input('ten_mau') . ' (' . $maMauCv . ')');

            return redirect()->route('admin.mau-cv.index')->with('thanh_cong', 'Đã thêm mẫu CV mới thành công!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi đăng mẫu CV: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $mauCv = DB::table('mau_cv')->where('id', $id)->whereNull('ngay_xoa')->first();
        if (!$mauCv) {
            return redirect()->route('admin.mau-cv.index')->with('error', 'Không tìm thấy mẫu CV yêu cầu.');
        }

        $request->validate([
            'ten_mau' => 'required|string|max:150',
            'phien_ban' => 'nullable|string|max:20',
            'trang_thai' => 'required|in:hoat_dong,tam_an',
            'anh_xem_truoc_file' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'noi_dung_view' => 'required|string|min:10',
        ], [
            'ten_mau.required' => 'Tên mẫu CV không được để trống.',
            'anh_xem_truoc_file.image' => 'File tải lên phải là hình ảnh.',
            'anh_xem_truoc_file.max' => 'Ảnh xem trước không vượt quá 2MB.',
            'noi_dung_view.required' => 'Nội dung mã nguồn Blade View không được để trống.',
            'noi_dung_view.min' => 'Nội dung mã nguồn phải chứa ít nhất 10 ký tự.',
        ]);

        try {
            $anhPath = $mauCv->anh_xem_truoc;
            if ($request->hasFile('anh_xem_truoc_file')) {
                // Xóa ảnh cũ nếu có
                if ($anhPath && file_exists(public_path($anhPath))) {
                    @unlink(public_path($anhPath));
                }
                
                $file = $request->file('anh_xem_truoc_file');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                $uploadDir = public_path('uploads/cv-templates');
                if (!file_exists($uploadDir)) {
                    if (!@mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                        return redirect()->back()->withInput()->with('error', 'Không thể tạo thư mục lưu trữ ảnh xem trước tại: ' . $uploadDir . '. Vui lòng kiểm tra và cấp quyền ghi cho thư mục này trên cPanel.');
                    }
                }
                
                $file->move($uploadDir, $filename);
                $anhPath = 'uploads/cv-templates/' . $filename;
            }

            // Ghi nội dung mã nguồn vào tệp tin blade view vật lý
            $viewPath = resource_path('views/' . str_replace('.', '/', $mauCv->duong_dan_file) . '.blade.php');
            
            $directory = dirname($viewPath);
            if (!file_exists($directory)) {
                if (!@mkdir($directory, 0775, true) && !is_dir($directory)) {
                    return redirect()->back()->withInput()->with('error', 'Không thể tạo thư mục chứa giao diện tại: ' . $directory . '. Vui lòng kiểm tra quyền ghi trên thư mục resources/views của cPanel.');
                }
            }
            
            if (@file_put_contents($viewPath, $request->input('noi_dung_view')) === false) {
                return redirect()->back()->withInput()->with('error', 'Không thể ghi nội dung vào file giao diện: ' . $viewPath . '. Vui lòng kiểm tra quyền ghi (Write Permission) trên thư mục hoặc file này.');
            }
            
            $kichThuoc = @filesize($viewPath) ?: 0;

            DB::table('mau_cv')->where('id', $id)->update([
                'ten_mau' => $request->input('ten_mau'),
                'phien_ban' => $request->input('phien_ban') ?: 'v1.0',
                'kich_thuoc_file' => $kichThuoc,
                'anh_xem_truoc' => $anhPath,
                'trang_thai' => $request->input('trang_thai'),
                'ngay_cap_nhat' => now(),
            ]);

            Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã cập nhật mẫu CV: ' . $request->input('ten_mau') . ' (' . $mauCv->ma_mau_cv . ')');

            return redirect()->route('admin.mau-cv.index')->with('thanh_cong', 'Đã cập nhật mẫu CV thành công!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi khi cập nhật mẫu CV: ' . $e->getMessage());
        }
    }

    /**
     * Đổi trạng thái mẫu CV.
     */
    public function doiTrangThai(Request $request, $id)
    {
        $mauCv = DB::table('mau_cv')->where('id', $id)->whereNull('ngay_xoa')->first();
        if (!$mauCv) {
            return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy mẫu CV.'], 404);
        }

        $trangThaiMoi = $mauCv->trang_thai === 'hoat_dong' ? 'tam_an' : 'hoat_dong';

        DB::table('mau_cv')->where('id', $id)->update([
            'trang_thai' => $trangThaiMoi,
            'ngay_cap_nhat' => now(),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Thay đổi trạng thái mẫu CV ' . $mauCv->ten_mau . ' sang ' . ($trangThaiMoi === 'hoat_dong' ? 'Hoạt động' : 'Tạm ẩn'));

        return response()->json([
            'thanh_cong' => true,
            'thong_bao' => 'Đã thay đổi trạng thái mẫu CV thành công!',
            'trang_thai_moi' => $trangThaiMoi,
        ]);
    }

    /**
     * Xóa mềm mẫu CV.
     */
    public function destroy($id)
    {
        $mauCv = DB::table('mau_cv')->where('id', $id)->whereNull('ngay_xoa')->first();
        if (!$mauCv) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['thanh_cong' => false, 'thong_bao' => 'Không tìm thấy mẫu CV.'], 404);
            }
            return redirect()->route('admin.mau-cv.index')->with('error', 'Không tìm thấy mẫu CV yêu cầu.');
        }

        DB::table('mau_cv')->where('id', $id)->update([
            'ngay_xoa' => now(),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã xóa mềm mẫu CV: ' . $mauCv->ten_mau);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['thanh_cong' => true, 'thong_bao' => 'Đã xóa mẫu CV thành công!']);
        }

        return redirect()->route('admin.mau-cv.index')->with('thanh_cong', 'Đã xóa mẫu CV thành công!');
    }

    /**
     * Tạo mẫu CV bằng AI
     */
    public function generateAiTemplate(Request $request, \App\Services\AIService $aiService)
    {
        @set_time_limit(180);

        $request->validate([
            'prompt' => 'nullable|string|max:1000',
            'mau_anh_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096'
        ]);

        $prompt = $request->input('prompt') ?: '';
        $imagePath = null;

        if ($request->hasFile('mau_anh_file')) {
            $imagePath = $request->file('mau_anh_file')->getRealPath();
        }

        if (empty($prompt) && !$imagePath) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => 'Vui lòng nhập mô tả hoặc tải lên 1 hình ảnh mẫu CV.'
            ], 422);
        }

        $bladeCode = $aiService->generateCvTemplateCode($prompt, $imagePath);

        if (!$bladeCode) {
            return response()->json([
                'thanh_cong' => false,
                'thong_bao' => 'Không thể kết nối hoặc phân tích hình ảnh/sinh mã giao diện từ AI. Vui lòng thử lại sau.'
            ], 500);
        }

        return response()->json([
            'thanh_cong' => true,
            'blade_code' => $bladeCode
        ]);
    }
}
