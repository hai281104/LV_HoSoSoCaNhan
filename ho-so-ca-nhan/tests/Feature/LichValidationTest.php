<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LichValidationTest extends TestCase
{
    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
        // Lấy hoặc tạo user test khác
        $this->otherUser = User::where('email', '!=', 'test@gmail.com')->first();
        if (!$this->otherUser) {
            $this->otherUser = User::factory()->create([
                'email' => 'other_test@gmail.com',
                'password' => bcrypt('password123'),
                'ho_ten' => 'Other Test User'
            ]);
        }
    }

    /**
     * Test truy cập trang Lịch khi chưa đăng nhập sẽ bị chuyển hướng.
     */
    public function test_access_lich_page_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('ho-so.lich'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test truy cập trang Lịch khi đã đăng nhập thành công.
     */
    public function test_access_lich_page_authenticated_success()
    {
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.lich'));

        $response->assertStatus(200);
        $response->assertSee('Lịch trình & Quản lý công việc', false);
        $response->assertSee('Lên lịch công việc');
        $response->assertSee('Phân loại màu sắc');
    }

    /**
     * Test validation thất bại khi Tiêu đề trống.
     */
    public function test_validation_fails_when_tieu_de_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => '',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);
    }

    /**
     * Test validation thất bại khi Tiêu đề chứa ký tự đặc biệt lạ.
     */
    public function test_validation_fails_when_tieu_de_has_invalid_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Học @#$ Lịch',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);
    }

    /**
     * Test validation thất bại khi Tiêu đề quá ngắn (1 ký tự) hoặc quá dài (101 ký tự).
     */
    public function test_validation_fails_when_tieu_de_length_out_of_bounds()
    {
        // Quá ngắn
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'A',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);

        // Quá dài
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => str_repeat('A', 31),
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);
    }

    /**
     * Test validation thất bại khi Phân loại không hợp lệ.
     */
    public function test_validation_fails_when_phan_loai_is_invalid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Họp nhóm tốt nghiệp',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'khong_hop_le',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phan_loai']);
    }

    /**
     * Test validation thất bại khi Ngày kết thúc trước Ngày bắt đầu.
     */
    public function test_validation_fails_when_ngay_ket_thuc_before_ngay_bat_dau()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Họp nhóm tốt nghiệp',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-17',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ngay_ket_thuc']);
    }

    /**
     * Test validation thất bại khi Giờ kết thúc trước Giờ bắt đầu trong cùng một ngày.
     */
    public function test_validation_fails_when_gio_ket_thuc_before_gio_bat_dau_on_same_day()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Họp nhóm tốt nghiệp',
                'ngay_bat_dau' => '2026-06-18',
                'gio_bat_dau' => '10:00',
                'ngay_ket_thuc' => '2026-06-18',
                'gio_ket_thuc' => '09:00',
                'phan_loai' => 'ca_nhan',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['gio_ket_thuc']);
    }

    /**
     * Test validation thất bại khi mô tả quá dài (1001 ký tự).
     */
    public function test_validation_fails_when_mo_ta_too_long()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Họp nhóm tốt nghiệp',
                'ngay_bat_dau' => '2026-06-18',
                'ngay_ket_thuc' => '2026-06-18',
                'phan_loai' => 'ca_nhan',
                'mo_ta' => str_repeat('A', 101)
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mo_ta']);
    }

    /**
     * Test validation và lưu sự kiện thành công khi dữ liệu hợp lệ.
     */
    public function test_validation_passes_when_data_is_valid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.luu'), [
                'tieu_de' => 'Báo cáo luận văn tốt nghiệp',
                'ngay_bat_dau' => '2026-06-18',
                'gio_bat_dau' => '08:00',
                'ngay_ket_thuc' => '2026-06-18',
                'gio_ket_thuc' => '11:30',
                'phan_loai' => 'su_kien',
                'mo_ta' => 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Kiểm tra xem dữ liệu có trong DB
        $this->assertDatabaseHas('lich_cong_viec', [
            'id_nguoi_dung' => $this->user->id,
            'tieu_de' => 'Báo cáo luận văn tốt nghiệp',
            'ngay_bat_dau' => '2026-06-18',
            'gio_bat_dau' => '08:00:00',
            'ngay_ket_thuc' => '2026-06-18',
            'gio_ket_thuc' => '11:30:00',
            'phan_loai' => 'su_kien',
            'mo_ta' => 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.'
        ]);
    }

    /**
     * Test xóa sự kiện thành công.
     */
    public function test_delete_event_success()
    {
        // Tạo một sự kiện test
        $id = DB::table('lich_cong_viec')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'tieu_de' => 'Sự kiện chuẩn bị xóa',
            'ngay_bat_dau' => '2026-06-18',
            'ngay_ket_thuc' => '2026-06-18',
            'phan_loai' => 'khac',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        $this->assertDatabaseHas('lich_cong_viec', ['id' => $id]);

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.xoa', ['id' => $id]));

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
        $this->assertDatabaseMissing('lich_cong_viec', ['id' => $id]);
    }

    /**
     * Test xóa sự kiện của người dùng khác bị từ chối.
     */
    public function test_delete_event_unauthorized()
    {
        // Tạo sự kiện thuộc về user khác
        $id = DB::table('lich_cong_viec')->insertGetId([
            'id_nguoi_dung' => $this->otherUser->id,
            'tieu_de' => 'Sự kiện của user khác',
            'ngay_bat_dau' => '2026-06-18',
            'ngay_ket_thuc' => '2026-06-18',
            'phan_loai' => 'khac',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.lich.xoa', ['id' => $id]));

        $response->assertStatus(403);
        $response->assertJson(['thanh_cong' => false]);
        $this->assertDatabaseHas('lich_cong_viec', ['id' => $id]);
    }
}
