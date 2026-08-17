<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminNhatKyTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        
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
    }

    /**
     * Test guest cannot access system activity log page.
     */
    public function test_guest_cannot_access_activity_log()
    {
        $response = $this->get(route('admin.nhat-ky-hoat-dong.index'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test normal user cannot access system activity log page.
     */
    public function test_normal_user_cannot_access_activity_log()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.nhat-ky-hoat-dong.index'));

        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can access system activity log page.
     */
    public function test_admin_can_access_activity_log()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-hoat-dong.index'));

        $response->assertStatus(200);
        $response->assertSee('Nhật ký hoạt động hệ thống');
        $response->assertSee('Tìm người dùng');
        
        $danhSachLog = $response->viewData('danhSachLog');
        $this->assertEquals(100, $danhSachLog->perPage());
    }

    /**
     * Test admin can filter activity log page by tab and query.
     */
    public function test_admin_can_filter_activity_log()
    {
        // Clear all logs for this test
        DB::table('nhat_ky_hoat_dong')->truncate();

        // Create normal user activity logs
        DB::table('nhat_ky_hoat_dong')->insert([
            [
                'id_nguoi_dung' => $this->normalUser->id,
                'loai_hoat_dong' => 'truy_cap',
                'mo_ta' => 'Da xem trang chu',
                'ngay_tao' => now(),
            ],
            [
                'id_nguoi_dung' => $this->normalUser->id,
                'loai_hoat_dong' => 'chinh_sua',
                'mo_ta' => 'Sua ho so',
                'ngay_tao' => now(),
            ]
        ]);

        // Filter by tab = truy_cap
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-hoat-dong.index', ['tab' => 'truy_cap']));

        $response->assertStatus(200);
        $danhSachLog = $response->viewData('danhSachLog');
        $this->assertCount(1, $danhSachLog);
        $this->assertEquals('Da xem trang chu', $danhSachLog->first()->mo_ta);

        // Search by description
        $responseSearch = $this->actingAs($this->adminUser)
            ->get(route('admin.nhat-ky-hoat-dong.index', ['search' => 'Sua ho so']));

        $responseSearch->assertStatus(200);
        $danhSachLogSearch = $responseSearch->viewData('danhSachLog');
        $this->assertCount(1, $danhSachLogSearch);
        $this->assertEquals('chinh_sua', $danhSachLogSearch->first()->loai_hoat_dong);
    }
}
