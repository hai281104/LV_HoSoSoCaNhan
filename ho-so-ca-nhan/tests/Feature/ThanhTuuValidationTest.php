<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThanhTuuValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Tên thành tựu trống.
     */
    public function test_validation_fails_when_ten_thanh_tuu_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => '',
                'phan_loai' => 'giai_thuong',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_thanh_tuu']);
    }

    /**
     * Test validation thành công khi Tên thành tựu chứa ký tự đặc biệt (đã gỡ bỏ luật cấm).
     */
    public function test_validation_passes_when_ten_thanh_tuu_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Giải Nhất Hackathon @#$%^&*()_+ 2026',
                'phan_loai' => 'giai_thuong',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test dữ liệu được làm sạch XSS (loại bỏ thẻ HTML) cho tên thành tựu.
     */
    public function test_xss_sanitization_strips_html_tags_in_achievement()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => '<script>alert("xss")</script>Giải Nhất',
                'phan_loai' => 'giai_thuong',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Kiểm tra trong database xem bản ghi vừa được tạo có bị strip tags chưa
        $thanhTuu = \Illuminate\Support\Facades\DB::table('thanh_tuu')
            ->where('id_nguoi_dung', $this->user->id)
            ->orderBy('id', 'desc')
            ->first();

        $this->assertNotNull($thanhTuu);
        $this->assertEquals('alert("xss")Giải Nhất', $thanhTuu->ten_thanh_tuu);
    }

    /**
     * Test validation thất bại khi Tên thành tựu quá ngắn (1 ký tự) hoặc quá dài (101 ký tự).
     */
    public function test_validation_fails_when_ten_thanh_tuu_length_out_of_bounds()
    {
        // Quá ngắn
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'A',
                'phan_loai' => 'giai_thuong',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_thanh_tuu']);

        // Quá dài
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => str_repeat('A', 101),
                'phan_loai' => 'giai_thuong',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_thanh_tuu']);
    }

    /**
     * Test validation thất bại khi Phân loại không hợp lệ.
     */
    public function test_validation_fails_when_phan_loai_is_invalid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng loại giỏi',
                'phan_loai' => 'khong_hop_le',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phan_loai']);
    }

    /**
     * Test validation thất bại khi Tổ chức cấp chứa ký tự đặc biệt.
     */
    public function test_validation_fails_when_to_chuc_cap_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng loại giỏi',
                'phan_loai' => 'hoc_bong',
                'to_chuc_cap' => 'Đại học Bách Khoa #',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to_chuc_cap']);
    }

    /**
     * Test validation thất bại khi Thời gian chứa ký tự đặc biệt lạ.
     */
    public function test_validation_fails_when_thoi_gian_has_invalid_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng loại giỏi',
                'phan_loai' => 'hoc_bong',
                'thoi_gian' => 'Năm học 2025 *',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['thoi_gian']);
    }

    /**
     * Test validation thất bại khi Mô tả quá dài (501 ký tự).
     */
    public function test_validation_fails_when_mo_ta_is_too_long()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng Khuyến khích',
                'phan_loai' => 'hoc_bong',
                'mo_ta' => str_repeat('A', 501),
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mo_ta']);
    }

    /**
     * Test validation thất bại khi Link minh chứng không đúng định dạng URL.
     */
    public function test_validation_fails_when_link_minh_chung_is_invalid_url()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng Khuyến khích',
                'phan_loai' => 'hoc_bong',
                'link_minh_chung' => 'not-a-valid-url',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['link_minh_chung']);
    }

    /**
     * Test validation thành công khi dữ liệu hợp lệ.
     */
    public function test_validation_passes_when_data_is_valid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.thanh-tuu.luu'), [
                'ten_thanh_tuu' => 'Học bổng Khuyến khích học tập',
                'phan_loai' => 'hoc_bong',
                'to_chuc_cap' => 'Khoa Công nghệ thông tin',
                'thoi_gian' => 'Học kỳ I (2024 - 2025)',
                'mo_ta' => 'Đạt thành tích học tập xuất sắc loại giỏi.',
                'link_minh_chung' => 'https://drive.google.com/some-file-link',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }
}
