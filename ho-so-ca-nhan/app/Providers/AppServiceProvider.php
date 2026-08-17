<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Laravel\Sanctum\Sanctum::ignoreMigrations();

        // Cấu hình lại đường dẫn thư mục public động cho cPanel / Hosting
        $this->app->bind('path.public', function() {
            // 1. Ưu tiên cấu hình thủ công từ .env
            if (env('PUBLIC_PATH')) {
                return env('PUBLIC_PATH');
            }
            
            // 2. Kiểm tra nếu thư mục public_html / httpdocs / www tồn tại ngay trong project root (Thường gặp khi đổi tên thư mục public trên host)
            foreach (['public_html', 'httpdocs', 'www'] as $folder) {
                if (file_exists(base_path($folder))) {
                    return base_path($folder);
                }
            }
            
            // 3. Tự động dò cấu trúc cPanel Case 1: project nằm cạnh thư mục webroot
            // (Ví dụ: project ở /home/user/project, webroot ở /home/user/public_html)
            foreach (['public_html', 'httpdocs', 'www'] as $folder) {
                $parentWebroot = dirname(base_path()) . '/' . $folder;
                if (file_exists($parentWebroot)) {
                    // Tránh trường hợp project root trùng với thư mục webroot
                    $realWebroot = realpath($parentWebroot);
                    $realBasePath = realpath(base_path());
                    if ($realWebroot && $realBasePath && $realWebroot !== $realBasePath) {
                        return $parentWebroot;
                    }
                }
            }
            
            // 4. Tự động dò cấu trúc cPanel Case 2: project nằm trong thư mục webroot nhưng chuyển assets ra ngoài
            // (Ví dụ: project ở /home/user/public_html/project, webroot ở /home/user/public_html)
            $siblingPublicHtml = dirname(base_path());
            if (file_exists($siblingPublicHtml . '/index.php') && !file_exists($siblingPublicHtml . '/artisan')) {
                $realSibling = realpath($siblingPublicHtml);
                $realBasePath = realpath(base_path());
                if ($realSibling && $realBasePath && $realSibling !== $realBasePath) {
                    return $siblingPublicHtml;
                }
            }
            
            // 5. Mặc định cho môi trường phát triển cục bộ (Local)
            return base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::composer(['ho-so.*', 'trangchu', 'ho-so.partials.sidebar'], function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $userId = $user->id;
                
                // Fetch counts from database
                $hocVanCount = \Illuminate\Support\Facades\DB::table('hoc_van')->where('id_nguoi_dung', $userId)->count();
                $duAnCount = \Illuminate\Support\Facades\DB::table('du_an')->where('id_nguoi_dung', $userId)->whereNull('ngay_xoa')->count();
                $cvCount = \Illuminate\Support\Facades\DB::table('cv_ca_nhan')->where('id_nguoi_dung', $userId)->whereNull('ngay_xoa')->count();
                $chungChiCount = \Illuminate\Support\Facades\DB::table('chung_chi')->where('id_nguoi_dung', $userId)->count();
                $thanhTuuCount = \Illuminate\Support\Facades\DB::table('thanh_tuu')->where('id_nguoi_dung', $userId)->count();
                $kinhNghiemCount = \Illuminate\Support\Facades\DB::table('kinh_nghiem')->where('id_nguoi_dung', $userId)->count();
                $albumCount = \Illuminate\Support\Facades\DB::table('album_su_kien')->where('id_nguoi_dung', $userId)->count();
                $lichCount = \Illuminate\Support\Facades\DB::table('lich_cong_viec')->where('id_nguoi_dung', $userId)->count();
                $dichVuCount = \Illuminate\Support\Facades\DB::table('dich_vu_ca_nhan')->where('id_nguoi_dung', $userId)->count();
                
                // Initials logic
                $tenRutGon = 'ND';
                if ($user->ho_ten) {
                    $cacTu = explode(' ', trim($user->ho_ten));
                    if (count($cacTu) >= 2) {
                        $tenRutGon = mb_substr($cacTu[count($cacTu)-2], 0, 1) . mb_substr($cacTu[count($cacTu)-1], 0, 1);
                    } else {
                        $tenRutGon = mb_substr($user->ho_ten, 0, 2);
                    }
                    $tenRutGon = mb_strtoupper($tenRutGon);
                }

                $view->with([
                    'sidebarHocVanCount' => $hocVanCount,
                    'sidebarDuAnCount' => $duAnCount,
                    'sidebarCvCount' => $cvCount,
                    'sidebarChungChiCount' => $chungChiCount,
                    'sidebarThanhTuuCount' => $thanhTuuCount,
                    'sidebarKinhNghiemCount' => $kinhNghiemCount,
                    'sidebarAlbumCount' => $albumCount,
                    'sidebarLichCount' => $lichCount,
                    'sidebarDichVuCount' => $dichVuCount,
                    'hoTen' => $user->ho_ten,
                    'chucDanh' => $user->chuc_danh,
                    'anhDaiDien' => $user->anh_dai_dien,
                    'tenRutGon' => $tenRutGon,
                ]);
            }
        });
    }
}
