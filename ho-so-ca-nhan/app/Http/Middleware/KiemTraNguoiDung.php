<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraNguoiDung
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
        if (Auth::check() && Auth::user()->vai_tro === 'nguoi_dung') {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->vai_tro === 'quan_tri') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Tài khoản quản trị không được phép thực hiện chức năng này.'], 403);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Tài khoản quản trị không thể truy cập khu vực của người dùng.');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Vui lòng đăng nhập.'], 401);
        }

        return redirect()->route('dang-nhap');
    }
}
