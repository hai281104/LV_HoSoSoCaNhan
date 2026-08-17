<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class NhatKyTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy hoặc tạo user test
        $this->user = User::where('email', 'test@gmail.com')->first();
        if (!$this->user) {
            $this->user = User::create([
                'ma_nguoi_dung' => 'ND-1234567890',
                'ho_ten' => 'Test User',
                'email' => 'test@gmail.com',
                'so_dien_thoai' => '0987654321',
                'mat_khau' => bcrypt('password123'),
                'vai_tro' => 'nguoi_dung',
                'trang_thai' => 'hoat_dong',
            ]);
        }
    }

    /**
     * Test guest cannot view logs page.
     */
    public function test_guest_cannot_view_logs_page()
    {
        $response = $this->get(route('ho-so.nhat-ky'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test authenticated user can access logs page and it records access log.
     */
    public function test_user_can_access_logs_page_and_records_access()
    {
        // Xóa log cũ của test user để kiểm tra chính xác
        DB::table('nhat_ky_hoat_dong')->where('id_nguoi_dung', $this->user->id)->delete();

        $response = $this->actingAs($this->user)->get(route('ho-so.nhat-ky'));
        $response->assertStatus(200);
        $response->assertSee('Hoạt động & Nhật ký');

        // Kiểm tra xem đã ghi log truy cập chưa
        $this->assertDatabaseHas('nhat_ky_hoat_dong', [
            'id_nguoi_dung' => $this->user->id,
            'loai_hoat_dong' => 'truy_cap',
            'mo_ta' => 'Đã xem danh sách nhật ký hoạt động cá nhân'
        ]);
    }

    /**
     * Test filter by type works correctly.
     */
    public function test_filter_by_type_works()
    {
        DB::table('nhat_ky_hoat_dong')->where('id_nguoi_dung', $this->user->id)->delete();

        // Chèn các logs giả lập
        DB::table('nhat_ky_hoat_dong')->insert([
            [
                'id_nguoi_dung' => $this->user->id,
                'loai_hoat_dong' => 'chinh_sua',
                'mo_ta' => 'Test log chỉnh sửa',
                'ngay_tao' => now(),
            ],
            [
                'id_nguoi_dung' => $this->user->id,
                'loai_hoat_dong' => 'bao_mat',
                'mo_ta' => 'Test log bảo mật',
                'ngay_tao' => now(),
            ],
        ]);

        // Gửi request lọc loai=chinh_sua
        $response = $this->actingAs($this->user)->get(route('ho-so.nhat-ky', ['loai' => 'chinh_sua']));
        $response->assertStatus(200);
        $response->assertSee('Test log chỉnh sửa');
        $response->assertDontSee('Test log bảo mật');
    }

    /**
     * Test delete logs history.
     */
    public function test_user_can_clear_logs_history()
    {
        // Đảm bảo có log trong database
        DB::table('nhat_ky_hoat_dong')->insert([
            'id_nguoi_dung' => $this->user->id,
            'loai_hoat_dong' => 'chinh_sua',
            'mo_ta' => 'Log tạm thời',
            'ngay_tao' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('ho-so.nhat-ky.xoa'));

        $response->assertStatus(200);
        $response->assertJson([
            'thanh_cong' => true,
        ]);

        // Ngoại trừ log xóa nhật ký vừa ghi nhận, toàn bộ các log khác phải biến mất
        $this->assertDatabaseHas('nhat_ky_hoat_dong', [
            'id_nguoi_dung' => $this->user->id,
            'loai_hoat_dong' => 'bao_mat',
            'mo_ta' => 'Đã xóa toàn bộ lịch sử nhật ký hoạt động'
        ]);

        $logsCount = DB::table('nhat_ky_hoat_dong')
            ->where('id_nguoi_dung', $this->user->id)
            ->count();

        $this->assertEquals(1, $logsCount); // chỉ còn 1 log bảo mật về hành động xóa vừa tạo
    }
}
