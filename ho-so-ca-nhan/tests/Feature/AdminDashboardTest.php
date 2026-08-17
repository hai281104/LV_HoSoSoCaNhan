<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        
        // Find or create an admin user for testing
        $this->adminUser = User::where('vai_tro', 'quan_tri')->first();
        if (!$this->adminUser) {
            $this->adminUser = User::create([
                'ma_nguoi_dung' => 'ND-admin-test',
                'ho_ten' => 'Admin Test',
                'email' => 'admin-test@gmail.com',
                'so_dien_thoai' => '0999999991',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }
    }

    /**
     * Test accessing admin dashboard when unauthenticated redirects to login.
     */
    public function test_access_admin_dashboard_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test accessing admin dashboard when logged in as a normal user redirects to user dashboard.
     */
    public function test_access_admin_dashboard_as_normal_user_redirects_back()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.dashboard'));
            
        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test accessing admin dashboard when logged in as an admin is successful.
     */
    public function test_access_admin_dashboard_as_admin_succeeds()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.dashboard'));
            
        $response->assertStatus(200);
        $response->assertSee('Hệ thống Quản trị');
        $response->assertSee('Người dùng mới');
        $response->assertSee('Tài khoản online');
        $response->assertSee('Tổng truy cập');
        $response->assertSee('Truy cập hôm nay');
        $response->assertSee('Biểu đồ tăng trưởng người dùng');
    }

    /**
     * Test admin is redirected when trying to access personal CV design section.
     */
    public function test_admin_cannot_access_own_cv_designer()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('ho-so.cv.index'));
            
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    /**
     * Test user dashboard redirects admin user to admin dashboard.
     */
    public function test_user_dashboard_redirects_admin()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('trang-chu'));
            
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    /**
     * Test KiemSoatTruyCap middleware logs session-based traffic.
     */
    public function test_traffic_control_middleware_records_visits()
    {
        DB::table('truy_cap')->truncate();
        
        // Simulating visitor access (GET request)
        $this->get(route('landing'));
        
        $this->assertEquals(1, DB::table('truy_cap')->count());
    }

    /**
     * Test active tracking middleware updates hoat_dong_cuoi for authenticated users.
     */
    public function test_active_tracking_updates_last_active_time()
    {
        // Set hoat_dong_cuoi to null
        DB::table('nguoi_dung')->where('id', $this->normalUser->id)->update(['hoat_dong_cuoi' => null]);
        
        $this->actingAs($this->normalUser)->get(route('trang-chu'));
        
        $updatedUser = User::find($this->normalUser->id);
        $this->assertNotNull($updatedUser->hoat_dong_cuoi);
    }

    /**
     * Test accessing user management dashboard as admin is successful.
     */
    public function test_access_user_management_as_admin_succeeds()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nguoi-dung.index'));
            
        $response->assertStatus(200);
        $response->assertSee('Quản lý người dùng');
        $response->assertSee('Hoạt động');
        $response->assertSee('Bị khóa');
        $response->assertSee('Tìm kiếm');
    }

    /**
     * Test accessing user management dashboard as normal user redirects back.
     */
    public function test_access_user_management_as_normal_user_fails()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.nguoi-dung.index'));
            
        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can lock a user permanently.
     */
    public function test_admin_can_lock_user_permanently()
    {
        // Restore user to active first
        $this->normalUser->update([
            'trang_thai' => 'hoat_dong',
            'ly_do_khoa' => null,
            'ngay_khoa' => null,
            'khoa_den' => null,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.nguoi-dung.khoa', ['id' => $this->normalUser->id]), [
                'ly_do_khoa' => 'Vi pham quy che he thong',
                'kieu_khoa' => 'vinh_vien',
            ]);
            
        $response->assertRedirect();
        
        $updatedUser = User::find($this->normalUser->id);
        $this->assertEquals('bi_khoa', $updatedUser->trang_thai);
        $this->assertEquals('Vi pham quy che he thong', $updatedUser->ly_do_khoa);
        $this->assertNull($updatedUser->khoa_den);
    }

    /**
     * Test admin can lock a user temporarily.
     */
    public function test_admin_can_lock_user_temporarily()
    {
        // Restore user to active
        $this->normalUser->update([
            'trang_thai' => 'hoat_dong',
            'ly_do_khoa' => null,
            'ngay_khoa' => null,
            'khoa_den' => null,
        ]);

        $futureDate = now()->addDays(5)->format('Y-m-d\TH:i');

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.nguoi-dung.khoa', ['id' => $this->normalUser->id]), [
                'ly_do_khoa' => 'Vi pham spam tin nhan',
                'kieu_khoa' => 'co_thoi_han',
                'khoa_den' => $futureDate,
            ]);
            
        $response->assertRedirect();
        
        $updatedUser = User::find($this->normalUser->id);
        $this->assertEquals('bi_khoa', $updatedUser->trang_thai);
        $this->assertEquals('Vi pham spam tin nhan', $updatedUser->ly_do_khoa);
        $this->assertNotNull($updatedUser->khoa_den);
    }

    /**
     * Test locked user is redirected to locked notification page.
     */
    public function test_locked_user_redirected_to_lock_screen()
    {
        // Force lock the user
        $this->normalUser->update([
            'trang_thai' => 'bi_khoa',
            'ly_do_khoa' => 'Spam content',
            'ngay_khoa' => now(),
            'khoa_den' => null, // Permanent
        ]);

        $response = $this->actingAs($this->normalUser)
            ->get(route('trang-chu'));
            
        $response->assertRedirect(route('tai-khoan.bi-khoa'));
        
        // Assert viewing the lock page works
        $responseLocked = $this->actingAs($this->normalUser)->get(route('tai-khoan.bi-khoa'));
        $responseLocked->assertStatus(200);
        $responseLocked->assertSee('Tài khoản đã bị khóa');
        $responseLocked->assertSee('Spam content');
    }

    /**
     * Test expired locked user is automatically unlocked.
     */
    public function test_expired_locked_user_auto_unlocked()
    {
        // Force lock the user but in the past (expired)
        $this->normalUser->update([
            'trang_thai' => 'bi_khoa',
            'ly_do_khoa' => 'Test lock',
            'ngay_khoa' => now()->subDays(2),
            'khoa_den' => now()->subMinutes(10), // Expired 10 mins ago
        ]);

        $response = $this->actingAs($this->normalUser)
            ->get(route('trang-chu'));
            
        // Should not redirect to lock page, should redirect to admin dash because of HoSoController::dashboard redirect check if admin (wait, this is normalUser, so it should stay on trang-chu / load dashboard)
        // Wait, normalUser goes to trang-chu which returns 200
        $response->assertStatus(200);
        
        // Verify database state is updated to hoat_dong
        $updatedUser = User::find($this->normalUser->id);
        $this->assertEquals('hoat_dong', $updatedUser->trang_thai);
        $this->assertNull($updatedUser->ly_do_khoa);
        $this->assertNull($updatedUser->khoa_den);
    }

    /**
     * Test admin can unlock a user.
     */
    public function test_admin_can_unlock_user()
    {
        // Force lock the user
        $this->normalUser->update([
            'trang_thai' => 'bi_khoa',
            'ly_do_khoa' => 'Lock test',
            'ngay_khoa' => now(),
            'khoa_den' => null,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.nguoi-dung.mo-khoa', ['id' => $this->normalUser->id]));
            
        $response->assertRedirect();
        
        $updatedUser = User::find($this->normalUser->id);
        $this->assertEquals('hoat_dong', $updatedUser->trang_thai);
        $this->assertNull($updatedUser->ly_do_khoa);
    }

    /**
     * Test admin can query user management with default 100 rows pagination limit.
     */
    public function test_admin_can_query_user_management_with_default_100_rows()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nguoi-dung.index'));

        $response->assertStatus(200);
        $danhSach = $response->viewData('danhSachNguoiDung');
        $this->assertEquals(100, $danhSach->perPage());
    }
}
