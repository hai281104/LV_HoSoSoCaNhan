<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HocVanValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy hoặc tạo user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Tiêu đề chứa ký tự đặc biệt.
     */
    public function test_validation_fails_when_tieu_de_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cử nhân CNTT @',
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);
    }

    /**
     * Test validation thất bại khi Tiêu đề vượt quá 50 ký tự.
     */
    public function test_validation_fails_when_tieu_de_exceeds_50_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => str_repeat('A', 51),
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tieu_de']);
    }

    /**
     * Test validation thất bại khi Trường chứa ký tự đặc biệt.
     */
    public function test_validation_fails_when_ten_truong_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Cong nghe Thong tin',
                'ten_truong' => 'Dai hoc Can Tho #',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_truong']);
    }

    /**
     * Test validation thất bại khi Khoa hoặc Ngành học chứa ký tự đặc biệt.
     */
    public function test_validation_fails_when_khoa_or_nganh_has_special_characters()
    {
        // Test Khoa chứa ký tự đặc biệt
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Cong nghe Thong tin',
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
                'khoa' => 'Khoa CNTT $',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['khoa']);

        // Test Ngành học chứa ký tự đặc biệt
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Cong nghe Thong tin',
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
                'nganh' => 'Ky thuat phan mem %',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nganh']);
    }

    /**
     * Test validation thất bại khi Khoa hoặc Ngành vượt quá 100 ký tự.
     */
    public function test_validation_fails_when_khoa_or_nganh_exceeds_100_characters()
    {
        // Test Khoa vượt quá 100 ký tự
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Cong nghe Thong tin',
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
                'khoa' => str_repeat('A', 101),
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['khoa']);

        // Test Ngành vượt quá 100 ký tự
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Cong nghe Thong tin',
                'ten_truong' => 'Dai hoc Can Tho',
                'nam_bat_dau' => 2020,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2024,
                'nganh' => str_repeat('A', 101),
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nganh']);
    }

    /**
     * Test validation thành công khi dữ liệu hợp lệ (không ký tự đặc biệt, đúng độ dài).
     */
    public function test_validation_passes_when_data_is_valid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'Cu nhan Khoa hoc May tinh',
                'ten_truong' => 'Dai hoc Bach Khoa',
                'khoa' => 'Cong nghe Thong tin',
                'nganh' => 'Khoa hoc May tinh',
                'nam_bat_dau' => 2021,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2025,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thành công khi chứa các dấu câu cơ bản được phép.
     */
    public function test_validation_passes_with_allowed_punctuation_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.hoc-van.luu'), [
                'tieu_de' => 'B.S. Computer Science (Honor)',
                'ten_truong' => 'Đại học KHTN, ĐHQG-HCM / CTU+',
                'khoa' => 'Khoa học Máy tính (DI-CS)',
                'nganh' => 'B.S. Computer Science',
                'nam_bat_dau' => 2021,
                'trang_thai' => 'da_tot_nghiep',
                'nam_ket_thuc' => 2025,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }
}
