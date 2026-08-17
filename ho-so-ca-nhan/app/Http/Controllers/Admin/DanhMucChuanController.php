<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DanhMucChuanController extends Controller
{
    /**
     * Hiển thị danh mục chuẩn (Ngôn ngữ lập trình & Kỹ năng mềm).
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

        $tab = $request->input('tab', 'ngon_ngu');
        $search = $request->input('search');

        $danhSach = null;

        if ($tab === 'ky_nang') {
            $query = DB::table('ky_nang_mem');
            if (!empty($search)) {
                $query->where('ten_ky_nang', 'like', '%' . $search . '%');
            }
            $danhSach = $query->orderBy('ten_ky_nang', 'asc')->paginate(100)->withQueryString();
        } else {
            $query = DB::table('ngon_ngu_lap_trinh');
            if (!empty($search)) {
                $query->where('ten_ngon_ngu', 'like', '%' . $search . '%');
            }
            $danhSach = $query->orderBy('ten_ngon_ngu', 'asc')->paginate(100)->withQueryString();
        }

        return view('admin.danh-muc-chuan', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'tab', 'search', 'danhSach'
        ));
    }

    /**
     * Thêm mới ngôn ngữ lập trình.
     */
    public function luuNgonNgu(Request $request)
    {
        // Làm sạch dữ liệu đầu vào
        if ($request->has('ten_ngon_ngu')) {
            $request->merge(['ten_ngon_ngu' => strip_tags(trim($request->input('ten_ngon_ngu')))]);
        }

        $request->validate([
            'ten_ngon_ngu' => 'required|string|min:2|max:20|unique:ngon_ngu_lap_trinh,ten_ngon_ngu',
        ], [
            'ten_ngon_ngu.required' => 'Tên ngôn ngữ lập trình không được để trống.',
            'ten_ngon_ngu.min' => 'Tên ngôn ngữ lập trình phải có từ 2 đến 20 ký tự.',
            'ten_ngon_ngu.max' => 'Tên ngôn ngữ lập trình phải có từ 2 đến 20 ký tự.',
            'ten_ngon_ngu.unique' => 'Ngôn ngữ lập trình này đã tồn tại trong danh mục.',
        ]);

        DB::table('ngon_ngu_lap_trinh')->insert([
            'ten_ngon_ngu' => $request->input('ten_ngon_ngu'),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã thêm ngôn ngữ lập trình mới: ' . $request->input('ten_ngon_ngu'));

        return redirect()->back()->with('thanh_cong', 'Đã thêm ngôn ngữ lập trình thành công!');
    }

    /**
     * Cập nhật ngôn ngữ lập trình.
     */
    public function capNhatNgonNgu(Request $request, $id)
    {
        // Làm sạch dữ liệu đầu vào
        if ($request->has('ten_ngon_ngu')) {
            $request->merge(['ten_ngon_ngu' => strip_tags(trim($request->input('ten_ngon_ngu')))]);
        }

        $request->validate([
            'ten_ngon_ngu' => 'required|string|min:2|max:20|unique:ngon_ngu_lap_trinh,ten_ngon_ngu,' . $id,
        ], [
            'ten_ngon_ngu.required' => 'Tên ngôn ngữ lập trình không được để trống.',
            'ten_ngon_ngu.min' => 'Tên ngôn ngữ lập trình phải có từ 2 đến 20 ký tự.',
            'ten_ngon_ngu.max' => 'Tên ngôn ngữ lập trình phải có từ 2 đến 20 ký tự.',
            'ten_ngon_ngu.unique' => 'Ngôn ngữ lập trình này đã tồn tại trong danh mục.',
        ]);

        $oldName = DB::table('ngon_ngu_lap_trinh')->where('id', $id)->value('ten_ngon_ngu');
        
        DB::table('ngon_ngu_lap_trinh')->where('id', $id)->update([
            'ten_ngon_ngu' => $request->input('ten_ngon_ngu'),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã cập nhật ngôn ngữ lập trình từ "' . $oldName . '" thành "' . $request->input('ten_ngon_ngu') . '"');

        return redirect()->back()->with('thanh_cong', 'Cập nhật ngôn ngữ lập trình thành công!');
    }

    /**
     * Xóa ngôn ngữ lập trình.
     */
    public function xoaNgonNgu($id)
    {
        $ngonNgu = DB::table('ngon_ngu_lap_trinh')->where('id', $id)->first();
        if (!$ngonNgu) {
            return redirect()->back()->with('error', 'Không tìm thấy ngôn ngữ lập trình cần xóa.');
        }

        // Dọn dẹp liên kết của người dùng trước
        DB::table('nguoi_dung_ngon_ngu_lap_trinh')->where('ngon_ngu_lap_trinh_id', $id)->delete();
        
        // Xóa ngôn ngữ lập trình
        DB::table('ngon_ngu_lap_trinh')->where('id', $id)->delete();

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã xóa ngôn ngữ lập trình: ' . $ngonNgu->ten_ngon_ngu);

        return redirect()->back()->with('thanh_cong', 'Đã xóa ngôn ngữ lập trình khỏi danh mục thành công!');
    }

    /**
     * Thêm mới kỹ năng mềm.
     */
    public function luuKyNang(Request $request)
    {
        // Làm sạch dữ liệu đầu vào
        if ($request->has('ten_ky_nang')) {
            $request->merge(['ten_ky_nang' => strip_tags(trim($request->input('ten_ky_nang')))]);
        }

        $request->validate([
            'ten_ky_nang' => 'required|string|min:2|max:30|unique:ky_nang_mem,ten_ky_nang',
        ], [
            'ten_ky_nang.required' => 'Tên kỹ năng mềm không được để trống.',
            'ten_ky_nang.min' => 'Tên kỹ năng mềm phải có từ 2 đến 30 ký tự.',
            'ten_ky_nang.max' => 'Tên kỹ năng mềm phải có từ 2 đến 30 ký tự.',
            'ten_ky_nang.unique' => 'Kỹ năng mềm này đã tồn tại trong danh mục.',
        ]);

        DB::table('ky_nang_mem')->insert([
            'ten_ky_nang' => $request->input('ten_ky_nang'),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã thêm kỹ năng mềm mới: ' . $request->input('ten_ky_nang'));

        return redirect()->back()->with('thanh_cong', 'Đã thêm kỹ năng mềm thành công!');
    }

    /**
     * Cập nhật kỹ năng mềm.
     */
    public function capNhatKyNang(Request $request, $id)
    {
        // Làm sạch dữ liệu đầu vào
        if ($request->has('ten_ky_nang')) {
            $request->merge(['ten_ky_nang' => strip_tags(trim($request->input('ten_ky_nang')))]);
        }

        $request->validate([
            'ten_ky_nang' => 'required|string|min:2|max:30|unique:ky_nang_mem,ten_ky_nang,' . $id,
        ], [
            'ten_ky_nang.required' => 'Tên kỹ năng mềm không được để trống.',
            'ten_ky_nang.min' => 'Tên kỹ năng mềm phải có từ 2 đến 30 ký tự.',
            'ten_ky_nang.max' => 'Tên kỹ năng mềm phải có từ 2 đến 30 ký tự.',
            'ten_ky_nang.unique' => 'Kỹ năng mềm này đã tồn tại trong danh mục.',
        ]);

        $oldName = DB::table('ky_nang_mem')->where('id', $id)->value('ten_ky_nang');

        DB::table('ky_nang_mem')->where('id', $id)->update([
            'ten_ky_nang' => $request->input('ten_ky_nang'),
        ]);

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã cập nhật kỹ năng mềm từ "' . $oldName . '" thành "' . $request->input('ten_ky_nang') . '"');

        return redirect()->back()->with('thanh_cong', 'Cập nhật kỹ năng mềm thành công!');
    }

    /**
     * Xóa kỹ năng mềm.
     */
    public function xoaKyNang($id)
    {
        $kyNang = DB::table('ky_nang_mem')->where('id', $id)->first();
        if (!$kyNang) {
            return redirect()->back()->with('error', 'Không tìm thấy kỹ năng mềm cần xóa.');
        }

        // Dọn dẹp liên kết của người dùng trước
        DB::table('nguoi_dung_ky_nang_mem')->where('ky_nang_mem_id', $id)->delete();

        // Xóa kỹ năng mềm
        DB::table('ky_nang_mem')->where('id', $id)->delete();

        Controller::ghiLog(Auth::id(), 'chinh_sua', 'Đã xóa kỹ năng mềm: ' . $kyNang->ten_ky_nang);

        return redirect()->back()->with('thanh_cong', 'Đã xóa kỹ năng mềm khỏi danh mục thành công!');
    }
}
