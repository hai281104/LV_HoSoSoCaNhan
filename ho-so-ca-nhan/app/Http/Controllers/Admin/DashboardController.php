<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan admin.
     */
    public function index()
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

        // 1. Người dùng mới (tính từ đầu tháng tới hiện tại)
        $startOfMonth = now()->startOfMonth()->toDateTimeString();
        $newUsersCount = User::where('ngay_tao', '>=', $startOfMonth)
            ->whereNull('ngay_xoa')
            ->count();

        // 2. Tài khoản đang online (hoạt động trong vòng 5 phút qua)
        $onlineThreshold = now()->subMinutes(5)->toDateTimeString();
        $onlineUsersCount = User::where('hoat_dong_cuoi', '>=', $onlineThreshold)
            ->whereNull('ngay_xoa')
            ->count();

        // 3. Truy cập (Tổng lượt truy cập mọi lúc)
        $totalAccess = DB::table('truy_cap')->count();

        // 4. Tổng lượt truy cập hôm nay
        $todayAccess = DB::table('truy_cap')
            ->where('ngay_truy_cap', now()->toDateString())
            ->count();

        // 5. Dữ liệu biểu đồ tăng trưởng người dùng (6 tháng gần nhất)
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;

            $count = User::whereYear('ngay_tao', $year)
                ->whereMonth('ngay_tao', $month)
                ->whereNull('ngay_xoa')
                ->count();

            $chartLabels[] = 'Tháng ' . $date->format('m/Y');
            $chartData[] = $count;
        }

        return view('admin.dashboard', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'newUsersCount', 'onlineUsersCount', 'totalAccess', 'todayAccess',
            'chartLabels', 'chartData'
        ));
    }
}
