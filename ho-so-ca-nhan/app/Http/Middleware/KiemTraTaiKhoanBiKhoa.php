<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KiemTraTaiKhoanBiKhoa
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
        if (Auth::check()) {
            $user = User::find(Auth::id());

            if ($user && $user->trang_thai === 'bi_khoa') {
                // Kiểm tra xem thời hạn khóa đã hết chưa (nếu khóa có thời hạn)
                if ($user->khoa_den && now()->greaterThan($user->khoa_den)) {
                    // Tự động mở khóa tài khoản
                    $user->update([
                        'trang_thai' => 'hoat_dong',
                        'ly_do_khoa' => null,
                        'ngay_khoa' => null,
                        'khoa_den' => null,
                    ]);
                } else {
                    // Tài khoản đang bị khóa hiệu lực
                    // Chỉ cho phép truy cập trang báo khóa và đăng xuất
                    if (!$request->routeIs('tai-khoan.bi-khoa') && !$request->routeIs('dang-xuat') && !$request->is('dang-xuat')) {
                        if ($request->ajax() || $request->wantsJson()) {
                            return response()->json([
                                'error' => 'tai_khoan_bi_khoa',
                                'message' => 'Tài khoản của bạn đã bị khóa.',
                                'ly_do_khoa' => $user->ly_do_khoa,
                                'ngay_khoa' => $user->ngay_khoa,
                                'khoa_den' => $user->khoa_den,
                            ], 403);
                        }
                        return redirect()->route('tai-khoan.bi-khoa');
                    }
                }
            } else {
                // Nếu tài khoản không bị khóa mà cố vào trang báo khóa thì chuyển về trang chủ
                if ($request->routeIs('tai-khoan.bi-khoa')) {
                    return redirect()->route('trang-chu');
                }
            }
        }

        return $next($request);
    }
}
