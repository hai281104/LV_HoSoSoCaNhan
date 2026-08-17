<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NguoiDungController extends Controller
{
    /**
     * Hiển thị danh sách quản lý người dùng.
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
        $tab = $request->input('tab', 'hoat_dong');
        $search = $request->input('search');

        $query = User::query()
            ->where('vai_tro', '!=', 'quan_tri')
            ->whereNull('ngay_xoa');

        // Phân lọc theo Tab
        if ($tab === 'bi_khoa') {
            $query->where('trang_thai', 'bi_khoa');
        } else {
            $query->where('trang_thai', 'hoat_dong');
        }

        // Tìm kiếm theo mã người dùng, tên hoặc email
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ma_nguoi_dung', 'like', '%' . $search . '%')
                  ->orWhere('ho_ten', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $danhSachNguoiDung = $query->orderBy('id', 'desc')->paginate(100)->withQueryString();

        return view('admin.nguoi-dung', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'tab', 'search', 'danhSachNguoiDung'
        ));
    }

    /**
     * Khóa tài khoản người dùng.
     */
    public function khoa(Request $request, $id)
    {
        $rules = [
            'ly_do_khoa' => 'required|string|min:3|max:500',
            'kieu_khoa' => 'required|in:vinh_vien,co_thoi_han',
        ];

        if ($request->input('kieu_khoa') === 'co_thoi_han') {
            $rules['khoa_den'] = 'required|date|after:now';
        }

        $request->validate($rules, [
            'ly_do_khoa.required' => 'Lý do khóa không được để trống.',
            'ly_do_khoa.min' => 'Lý do khóa phải có ít nhất 3 ký tự.',
            'khoa_den.required' => 'Vui lòng chọn thời gian hết hạn khóa.',
            'khoa_den.after' => 'Thời gian hết hạn khóa phải ở tương lai.',
        ]);

        $user = User::findOrFail($id);

        if ($user->vai_tro === 'quan_tri') {
            return redirect()->back()->with('error', 'Không thể khóa tài khoản quản trị viên.');
        }

        $khoaDen = null;
        if ($request->input('kieu_khoa') === 'co_thoi_han') {
            $khoaDen = $request->input('khoa_den');
        }

        $user->update([
            'trang_thai' => 'bi_khoa',
            'ly_do_khoa' => $request->input('ly_do_khoa'),
            'ngay_khoa' => now(),
            'khoa_den' => $khoaDen,
        ]);

        // Ghi nhật ký hệ thống hành động của admin
        \App\Http\Controllers\Controller::ghiLog(Auth::id(), 'bao_mat', 'Đã khóa tài khoản người dùng ' . $user->email . '. Lý do: ' . $request->input('ly_do_khoa'));

        return redirect()->back()->with('thanh_cong', 'Đã khóa tài khoản thành công!');
    }

    /**
     * Mở khóa tài khoản người dùng.
     */
    public function moKhoa($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'trang_thai' => 'hoat_dong',
            'ly_do_khoa' => null,
            'ngay_khoa' => null,
            'khoa_den' => null,
        ]);

        // Ghi nhật ký hệ thống hành động của admin
        \App\Http\Controllers\Controller::ghiLog(Auth::id(), 'bao_mat', 'Đã mở khóa tài khoản người dùng ' . $user->email);

        return redirect()->back()->with('thanh_cong', 'Đã mở khóa tài khoản thành công!');
    }
}
