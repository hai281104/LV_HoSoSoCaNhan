<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KinhNghiemValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Vị trí công việc trống.
     */
    public function test_validation_fails_when_vi_tri_cong_viec_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => '',
                'ten_cong_ty'      => 'Công ty A',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vi_tri_cong_viec']);
    }

    /**
     * Test validation thất bại khi Vị trí công việc chứa ký tự đặc biệt bất hợp pháp.
     */
    public function test_validation_fails_when_vi_tri_cong_viec_contains_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer @ IT',
                'ten_cong_ty'      => 'Công ty A',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['vi_tri_cong_viec']);
    }

    /**
     * Test validation thất bại khi Tên công ty trống.
     */
    public function test_validation_fails_when_ten_cong_ty_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer',
                'ten_cong_ty'      => '',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_cong_ty']);
    }

    /**
     * Test validation thất bại khi Tên công ty chứa ký tự đặc biệt bất hợp pháp.
     */
    public function test_validation_fails_when_ten_cong_ty_contains_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer',
                'ten_cong_ty'      => 'Công ty #1',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_cong_ty']);
    }

    /**
     * Test validation thất bại khi ngày kết thúc trước ngày bắt đầu.
     */
    public function test_validation_fails_when_end_date_is_before_start_date()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer',
                'ten_cong_ty'      => 'Công ty A',
                'ngay_bat_dau'     => '2023-01-01',
                'ngay_ket_thuc'    => '2022-12-31',
                'dang_lam_viec'    => '0',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ngay_ket_thuc']);
    }

    /**
     * Test validation thành công với dữ liệu hợp lệ (Công việc đang làm).
     */
    public function test_validation_passes_for_ongoing_experience()
    {
        // Sử dụng transaction để tự động rollback khi test xong
        DB::beginTransaction();

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Lập trình viên Full stack',
                'ten_cong_ty'      => 'Công ty TNHH RD Việt Nam',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
                'mo_ta_chi_tiet'   => 'Lập trình hệ thống CRM cho khách hàng.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        DB::rollBack();
    }

    /**
     * Test validation thành công với dữ liệu hợp lệ (Công việc đã kết thúc).
     */
    public function test_validation_passes_for_completed_experience()
    {
        DB::beginTransaction();

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Thực tập sinh IT',
                'ten_cong_ty'      => 'FPT Software',
                'ngay_bat_dau'     => '2022-06-01',
                'ngay_ket_thuc'    => '2022-12-31',
                'dang_lam_viec'    => '0',
                'mo_ta_chi_tiet'   => 'Học hỏi và phát triển dự án.',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        DB::rollBack();
    }

    /**
     * Test validation thất bại khi mô tả chi tiết vượt quá 1000 ký tự.
     */
    public function test_validation_fails_when_description_exceeds_1000_characters()
    {
        $largeDescription = str_repeat('a', 1001);

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer',
                'ten_cong_ty'      => 'Cong ty A',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
                'mo_ta_chi_tiet'   => $largeDescription,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mo_ta_chi_tiet']);
    }

    /**
     * Test validation thành công khi mô tả chi tiết có đúng 1000 ký tự.
     */
    public function test_validation_passes_when_description_has_exactly_1000_characters()
    {
        DB::beginTransaction();

        $description1000Chars = str_repeat('a', 1000);

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.kinh-nghiem.luu'), [
                'vi_tri_cong_viec' => 'Developer',
                'ten_cong_ty'      => 'Cong ty A',
                'ngay_bat_dau'     => '2023-01-01',
                'dang_lam_viec'    => '1',
                'mo_ta_chi_tiet'   => $description1000Chars,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        DB::rollBack();
    }
}
