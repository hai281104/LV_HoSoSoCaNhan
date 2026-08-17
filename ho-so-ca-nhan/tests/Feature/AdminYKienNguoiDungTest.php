<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminYKienNguoiDungTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Retrieve or create test users
        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        if (!$this->normalUser) {
            $this->normalUser = User::create([
                'ma_nguoi_dung' => 'ND-normal-test-feedback',
                'ho_ten' => 'Normal User Feedback Test',
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
                'ma_nguoi_dung' => 'ND-admin-test-feedback',
                'ho_ten' => 'Admin Feedback Test',
                'email' => 'admin-feedback-test@gmail.com',
                'so_dien_thoai' => '0999999992',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }
    }

    /**
     * Test guest cannot access user feedback index.
     */
    public function test_guest_cannot_access_y_kien_nguoi_dung()
    {
        $response = $this->get(route('admin.y-kien-nguoi-dung.index'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test normal user cannot access user feedback index.
     */
    public function test_normal_user_cannot_access_y_kien_nguoi_dung()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.y-kien-nguoi-dung.index'));

        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can access user feedback index and see feedback list.
     */
    public function test_admin_can_access_y_kien_nguoi_dung()
    {
        // Truncate and insert mock feedback
        DB::table('dong_gop_y_kien')->truncate();
        DB::table('dong_gop_y_kien')->insert([
            'id_nguoi_dung' => $this->normalUser->id,
            'noi_dung' => 'First test feedback text',
            'ngay_tao' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.y-kien-nguoi-dung.index'));

        $response->assertStatus(200);
        $response->assertSee('Ý kiến đóng góp từ người dùng', false);
        $response->assertSee('First test feedback text');

        $danhSachDongGop = $response->viewData('danhSachDongGop');
        $this->assertNotNull($danhSachDongGop);
        $this->assertEquals(100, $danhSachDongGop->perPage());
    }

    /**
     * Test admin can filter/search user feedback.
     */
    public function test_admin_can_search_y_kien_nguoi_dung()
    {
        DB::table('dong_gop_y_kien')->truncate();
        DB::table('dong_gop_y_kien')->insert([
            [
                'id_nguoi_dung' => $this->normalUser->id,
                'noi_dung' => 'Important system suggestion',
                'ngay_tao' => now(),
            ],
            [
                'id_nguoi_dung' => $this->normalUser->id,
                'noi_dung' => 'Spam message text',
                'ngay_tao' => now(),
            ]
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.y-kien-nguoi-dung.index', ['search' => 'Important']));

        $response->assertStatus(200);
        $response->assertSee('Important system suggestion');
        $response->assertDontSee('Spam message text');
    }

    /**
     * Test admin can delete user feedback.
     */
    public function test_admin_can_delete_y_kien_nguoi_dung()
    {
        DB::table('dong_gop_y_kien')->truncate();
        $id = DB::table('dong_gop_y_kien')->insertGetId([
            'id_nguoi_dung' => $this->normalUser->id,
            'noi_dung' => 'To be deleted suggestion',
            'ngay_tao' => now(),
        ]);

        $this->assertEquals(1, DB::table('dong_gop_y_kien')->count());

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.y-kien-nguoi-dung.destroy', $id));

        $response->assertRedirect();
        $response->assertSessionHas('thanh_cong');

        $this->assertEquals(0, DB::table('dong_gop_y_kien')->count());
    }
}
