<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class NhatKyHeThongController extends Controller
{
    /**
     * Hiển thị nhật ký hệ thống (log file) và trạng thái cơ sở dữ liệu.
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

        $tab = $request->input('tab', 'log_he_thong');
        $search = $request->input('search');
        $levelFilter = $request->input('level', 'ALL');
        $thang  = $request->get('thang', '');
        $nam    = $request->get('nam', '');
        $danhSachNam = [date('Y')];

        $paginatedLogs = null;
        $dbInfo = [];
        $dbTables = [];

        if ($tab === 'co_so_du_lieu') {
            // Lấy thông tin driver và tên cơ sở dữ liệu
            $driver = DB::connection()->getDriverName();
            $dbName = config('database.connections.' . $driver . '.database') ?? 'N/A';

            $totalRows = 0;
            $totalSize = 0;

            if ($driver === 'mysql') {
                $dbTables = DB::select("
                    SELECT 
                        table_name AS 'table_name',
                        table_rows AS 'table_rows',
                        round(((data_length + index_length) / 1024 / 1024), 2) AS 'total_size_mb',
                        round((data_length / 1024 / 1024), 2) AS 'data_size_mb',
                        round((index_length / 1024 / 1024), 2) AS 'index_size_mb'
                    FROM information_schema.TABLES
                    WHERE table_schema = ?
                    ORDER BY (data_length + index_length) DESC
                ", [$dbName]);

                foreach ($dbTables as $table) {
                    $totalRows += intval($table->table_rows);
                    $totalSize += floatval($table->total_size_mb);
                }
            } else {
                // SQLite hoặc các Driver khác (cho môi trường kiểm thử)
                $dbTables = [];
                $sqliteTables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                foreach ($sqliteTables as $table) {
                    $count = DB::table($table->name)->count();
                    $totalRows += $count;
                    $dbTables[] = (object)[
                        'table_name' => $table->name,
                        'table_rows' => $count,
                        'data_size_mb' => 0.01,
                        'index_size_mb' => 0.01,
                        'total_size_mb' => 0.02
                    ];
                }
                $totalSize = count($dbTables) * 0.02;
            }

            $dbInfo = [
                'driver' => strtoupper($driver),
                'database_name' => basename($dbName),
                'total_tables' => count($dbTables),
                'total_rows' => $totalRows,
                'total_size_mb' => round($totalSize, 2)
            ];
        } else {
            // Log ứng dụng (Laravel Logs)
            $logPath = storage_path('logs/laravel.log');
            $logs = [];

            if (file_exists($logPath)) {
                // Đọc luồng ngược tối đa 500KB để bảo vệ hiệu năng
                $content = $this->readLastBytes($logPath, 512000);
                $logs = $this->parseLogs($content);
            }

            // Lấy danh sách các năm từ logs thô trước khi lọc
            $extractedYears = [];
            foreach ($logs as $log) {
                $y = substr($log['timestamp'], 0, 4);
                if ($y && !in_array($y, $extractedYears)) {
                    $extractedYears[] = $y;
                }
            }
            sort($extractedYears);
            $extractedYears = array_reverse($extractedYears);
            if (!empty($extractedYears)) {
                $danhSachNam = $extractedYears;
            }

            // Lọc log theo Cấp độ (Level)
            if ($levelFilter && $levelFilter !== 'ALL') {
                $logs = array_filter($logs, function ($log) use ($levelFilter) {
                    return $log['level'] === $levelFilter;
                });
            }

            // Lọc log theo Từ khóa (Search)
            if (!empty($search)) {
                $logs = array_filter($logs, function ($log) use ($search) {
                    return stripos($log['message'], $search) !== false;
                });
            }

            // Lọc log theo năm
            if ($nam !== '') {
                $logs = array_filter($logs, function ($log) use ($nam) {
                    return substr($log['timestamp'], 0, 4) === $nam;
                });
            }

            // Lọc log theo tháng
            if ($thang !== '') {
                $logs = array_filter($logs, function ($log) use ($thang) {
                    $monthStr = str_pad($thang, 2, '0', STR_PAD_LEFT);
                    return substr($log['timestamp'], 5, 2) === $monthStr;
                });
            }

            // Phân trang danh sách logs (100 bản ghi mỗi trang)
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 100;
            $currentItems = array_slice($logs, ($currentPage - 1) * $perPage, $perPage);
            
            $paginatedLogs = new LengthAwarePaginator(
                $currentItems,
                count($logs),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
            $paginatedLogs->withQueryString();
        }

        return view('admin.nhat-ky-he-thong', compact(
            'nguoiDung', 'hoTen', 'chucDanh', 'anhDaiDien', 'tenRutGon',
            'tab', 'search', 'levelFilter', 'thang', 'nam', 'danhSachNam', 'paginatedLogs', 'dbInfo', 'dbTables'
        ));
    }

    /**
     * Dọn dẹp (Làm sạch) file log hệ thống.
     */
    public function clear(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            file_put_contents($logPath, '');
            Controller::ghiLog(Auth::id(), 'bao_mat', 'Đã dọn dẹp (xóa trắng) file log hệ thống laravel.log');
            return redirect()->back()->with('thanh_cong', 'Đã dọn dẹp file log hệ thống thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy file log hệ thống.');
    }

    /**
     * Helper đọc tối đa N bytes từ cuối file.
     */
    private function readLastBytes($filePath, $bytes = 512000)
    {
        $fileSize = filesize($filePath);
        if ($fileSize <= 0) {
            return '';
        }
        $handle = fopen($filePath, 'r');
        if ($fileSize > $bytes) {
            fseek($handle, -$bytes, SEEK_END);
            // Bỏ qua dòng đầu tiên vì có thể bị cắt nửa dòng
            fgets($handle);
        }
        $content = '';
        while (!feof($handle)) {
            $content .= fread($handle, 8192);
        }
        fclose($handle);
        return $content;
    }

    /**
     * Helper phân tích cấu trúc file laravel.log.
     */
    private function parseLogs($content)
    {
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*?)(?=\n\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|\r\n\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)/s';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
        
        $logs = [];
        foreach ($matches as $match) {
            $logs[] = [
                'timestamp' => $match[1],
                'env' => $match[2],
                'level' => strtoupper($match[3]),
                'message' => trim($match[4])
            ];
        }
        
        // Đảo ngược để hiển thị log mới nhất lên đầu
        return array_reverse($logs);
    }
}
