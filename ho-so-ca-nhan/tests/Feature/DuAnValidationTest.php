<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuAnValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Tên dự án trống.
     */
    public function test_validation_fails_when_ten_du_an_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => '',
                'vai_tro' => 'Backend Developer',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_du_an']);
    }

    /**
     * Test validation thành công khi Tên dự án chứa ký tự đặc biệt (đã bỏ luật cấm).
     */
    public function test_validation_passes_when_ten_du_an_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Dự án @!#$ *()_+',
                'vai_tro' => 'Backend Developer',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thất bại khi Vai trò trống.
     */
    public function test_validation_fails_when_vai_tro_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Du an test',
                'vai_tro' => '',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vai_tro']);
    }

    /**
     * Test validation thành công khi Vai trò chứa ký tự đặc biệt (đã bỏ luật cấm).
     */
    public function test_validation_passes_when_vai_tro_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Du an test',
                'vai_tro' => 'Backend & Frontend *()',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thất bại khi Vai trò quá ngắn (1 ký tự) hoặc quá dài (51 ký tự).
     */
    public function test_validation_fails_when_vai_tro_length_out_of_bounds()
    {
        // Quá ngắn
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Du an test',
                'vai_tro' => 'A',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vai_tro']);

        // Quá dài (51 ký tự)
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Du an test',
                'vai_tro' => str_repeat('A', 51),
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vai_tro']);
    }

    /**
     * Test validation thất bại khi Tên dự án quá dài (101 ký tự).
     */
    public function test_validation_fails_when_ten_du_an_length_out_of_bounds()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => str_repeat('A', 101),
                'vai_tro' => 'Backend Developer',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_du_an']);
    }

    /**
     * Test dữ liệu được làm sạch XSS (loại bỏ thẻ HTML) cho tên dự án và vai trò.
     */
    public function test_xss_sanitization_strips_html_tags()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => '<script>alert("xss")</script>Dự án XSS',
                'vai_tro' => '<b>Fullstack</b> Developer',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Kiểm tra trong database xem bản ghi vừa được tạo có bị strip tags chưa
        $duAn = \Illuminate\Support\Facades\DB::table('du_an')
            ->where('id_nguoi_dung', $this->user->id)
            ->orderBy('id', 'desc')
            ->first();

        $this->assertNotNull($duAn);
        $this->assertEquals('alert("xss")Dự án XSS', $duAn->ten_du_an);
        $this->assertEquals('Fullstack Developer', $duAn->vai_tro);
    }

    /**
     * Test validation thành công khi từ khóa công nghệ chứa khoảng trắng, gạch chéo (/), ampersand (&).
     */
    public function test_validation_passes_when_tu_khoa_has_spaces_and_symbols()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Dự án test tag',
                'vai_tro' => 'Developer',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
                'tu_khoa' => ['HTML / CSS', 'R & D', 'React Native', 'C++'],
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thành công khi dữ liệu hợp lệ (hỗ trợ tiếng Việt).
     */
    public function test_validation_passes_when_data_is_valid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.du-an.luu'), [
                'ten_du_an' => 'Du an test',
                'vai_tro' => 'Lập trình viên Fullstack',
                'ngay_bat_dau' => '2023-01-01',
                'mo_ta' => 'Mo ta chi tiet du an.',
                'tu_khoa' => ['Laravel', 'MySQL'],
                'lien_ket' => [
                    [
                        'loai_lien_ket' => 'github',
                        'duong_dan' => 'https://github.com/test',
                        'nhan_hien_thi' => 'GitHub Repo',
                    ]
                ],
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }
}
