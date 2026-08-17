<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KiemSoatTruyCap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Chỉ xử lý các yêu cầu GET và không phải AJAX/JSON
        if ($request->isMethod('get') && !$request->ajax() && !$request->wantsJson()) {
            $sessionId = session()->getId();
            $today = now()->toDateString();

            // Kiểm tra xem session đã truy cập trong ngày hôm nay chưa
            $exists = DB::table('truy_cap')
                ->where('session_id', $sessionId)
                ->where('ngay_truy_cap', $today)
                ->exists();

            if (!$exists) {
                try {
                    DB::table('truy_cap')->insert([
                        'session_id' => $sessionId,
                        'ip_dia_chi' => $request->ip(),
                        'ngay_truy_cap' => $today,
                        'ngay_tao' => now(),
                    ]);
                } catch (\Exception $e) {
                    // Bỏ qua lỗi nếu có trùng lặp hoặc lỗi ghi DB
                }
            }

            // Nếu người dùng đã đăng nhập, cập nhật thời gian hoạt động cuối cùng
            if (Auth::check()) {
                try {
                    DB::table('nguoi_dung')
                        ->where('id', Auth::id())
                        ->update(['hoat_dong_cuoi' => now()]);
                } catch (\Exception $e) {
                    // Bỏ qua lỗi
                }
            }
        }

        return $next($request);
    }
}
