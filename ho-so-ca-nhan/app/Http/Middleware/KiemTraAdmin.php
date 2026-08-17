<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraAdmin
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
        if (Auth::check() && Auth::user()->vai_tro === 'quan_tri') {
            return $next($request);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Bạn không có quyền truy cập khu vực này.'], 403);
        }

        return redirect()->route('trang-chu')->with('error', 'Bạn không có quyền truy cập khu vực quản trị.');
    }
}
