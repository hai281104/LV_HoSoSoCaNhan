<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminNhatKyHeThongTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;
    protected $laravelLogPath;
    protected $logBackupPath;

    protected function setUp(): void
    {
        parent::setUp();

        // Retrieve or create test users
        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        if (!$this->normalUser) {
            $this->normalUser = User::create([
                'ma_nguoi_dung' => 'ND-normal-test-log',
                'ho_ten' => 'Normal User Log Test',
                'email' => 'test@gmail.com',
                'so_dien_thoai' => '0999999991',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'nguoi_dung',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }

        $this->adminUser = User::where('vai_tro', 'quan_tri')->first();
        if (!$this->adminUser) {
            $this->adminUser = User::create([
                'ma_nguoi_dung' => 'ND-admin-test-log',
                'ho_ten' => 'Admin Log Test',
                'email' => 'admin-log-test@gmail.com',
                'so_dien_thoai' => '0999999992',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }

        // Backup existing laravel.log
        $this->laravelLogPath = storage_path('logs/laravel.log');
        $this->logBackupPath = storage_path('logs/laravel.log.bak.test');
        if (file_exists($this->laravelLogPath)) {
            rename($this->laravelLogPath, $this->logBackupPath);
        }

        // Ensure directory exists
        if (!is_dir(dirname($this->laravelLogPath))) {
            mkdir(dirname($this->laravelLogPath), 0755, true);
        }
    }

    protected function tearDown(): void
    {
        // Restore laravel.log backup
        if (file_exists($this->laravelLogPath)) {
            unlink($this->laravelLogPath);
        }
        if (file_exists($this->logBackupPath)) {
            rename($this->logBackupPath, $this->laravelLogPath);
        }

        parent::tearDown();
    }

    /**
     * Helper to write dummy logs into the laravel.log file.
     */
    private function writeTestLogs(array $logs)
    {
        $content = '';
        foreach ($logs as $log) {
            $content .= sprintf("[%s] %s.%s: %s\n", $log['time'], $log['env'] ?? 'local', $log['level'], $log['message']);
        }
        file_put_contents($this->laravelLogPath, $content);
    }

    /**
     * Test guest cannot access system log page.
     */
    public function test_guest_cannot_access_nhat_ky_he_thong()
    {
        $response = $this->get(route('admin.nhat-ky-he-thong.index'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test normal user cannot access system log page.
     */
    public function test_normal_user_cannot_access_nhat_ky_he_thong()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.nhat-ky-he-thong.index'));

        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can access system log page.
     */
    public function test_admin_can_access_nhat_ky_he_thong()
    {
        $this->writeTestLogs([
            ['time' => '2026-06-20 12:00:00', 'level' => 'ERROR', 'message' => 'Something crashed here'],
            ['time' => '2026-06-20 12:01:00', 'level' => 'INFO', 'message' => 'App is loading'],
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-he-thong.index'));

        $response->assertStatus(200);
        $response->assertSee('Nhật ký hệ thống & Database', false);
        $response->assertSee('Something crashed here');
        $response->assertSee('App is loading');
        
        $paginatedLogs = $response->viewData('paginatedLogs');
        $this->assertNotNull($paginatedLogs);
        $this->assertEquals(100, $paginatedLogs->perPage());
    }

    /**
     * Test admin can filter logs by level.
     */
    public function test_admin_can_filter_logs_by_level()
    {
        $this->writeTestLogs([
            ['time' => '2026-06-20 12:00:00', 'level' => 'ERROR', 'message' => 'Crash log'],
            ['time' => '2026-06-20 12:01:00', 'level' => 'INFO', 'message' => 'Info log'],
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-he-thong.index', ['level' => 'ERROR']));

        $response->assertStatus(200);
        $response->assertSee('Crash log');
        $response->assertDontSee('Info log');
    }

    /**
     * Test admin can search logs.
     */
    public function test_admin_can_search_logs()
    {
        $this->writeTestLogs([
            ['time' => '2026-06-20 12:00:00', 'level' => 'ERROR', 'message' => 'Database timeout error'],
            ['time' => '2026-06-20 12:01:00', 'level' => 'ERROR', 'message' => 'Validation failed'],
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-he-thong.index', ['search' => 'Database']));

        $response->assertStatus(200);
        $response->assertSee('Database timeout error');
        $response->assertDontSee('Validation failed');
    }

    /**
     * Test admin can access database tab.
     */
    public function test_admin_can_access_database_tab()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-he-thong.index', ['tab' => 'co_so_du_lieu']));

        $response->assertStatus(200);
        $response->assertSee('Hệ quản trị (DBMS)');
        $response->assertSee('Tên Cơ sở dữ liệu');
        
        $dbInfo = $response->viewData('dbInfo');
        $this->assertNotEmpty($dbInfo);
        $this->assertArrayHasKey('driver', $dbInfo);
        $this->assertArrayHasKey('total_tables', $dbInfo);
    }

    /**
     * Test admin can clear logs.
     */
    public function test_admin_can_clear_logs()
    {
        $this->writeTestLogs([
            ['time' => '2026-06-20 12:00:00', 'level' => 'ERROR', 'message' => 'Trash error'],
        ]);

        $this->assertFileExists($this->laravelLogPath);
        $this->assertNotEmpty(file_get_contents($this->laravelLogPath));

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.nhat-ky-he-thong.clear'));

        $response->assertRedirect();
        $response->assertSessionHas('thanh_cong');

        // Check if log file is now empty
        $this->assertFileExists($this->laravelLogPath);
        $this->assertEmpty(file_get_contents($this->laravelLogPath));
    }
}
