<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChungChiValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test validation thất bại khi Tên chứng chỉ trống.
     */
    public function test_validation_fails_when_ten_chung_chi_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => '',
                'to_chuc_cap' => 'AWS Enterprise',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_chung_chi']);
    }

    /**
     * Test validation thành công khi Tên chứng chỉ chứa ký tự đặc biệt.
     */
    public function test_validation_passes_when_ten_chung_chi_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Certified Practitioner @#$ *()',
                'to_chuc_cap' => 'AWS Enterprise',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thất bại khi Tổ chức cấp trống.
     */
    public function test_validation_fails_when_to_chuc_cap_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Solutions Architect',
                'to_chuc_cap' => '',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to_chuc_cap']);
    }

    /**
     * Test validation thành công khi Tổ chức cấp chứa ký tự đặc biệt.
     */
    public function test_validation_passes_when_to_chuc_cap_has_special_characters()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Solutions Architect',
                'to_chuc_cap' => 'Amazon Web Services & Partners *()',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }

    /**
     * Test validation thất bại khi Tên chứng chỉ quá dài (101 ký tự).
     */
    public function test_validation_fails_when_ten_chung_chi_length_out_of_bounds()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => str_repeat('A', 101),
                'to_chuc_cap' => 'AWS Enterprise',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_chung_chi']);
    }

    /**
     * Test validation thất bại khi Tổ chức cấp quá dài (101 ký tự).
     */
    public function test_validation_fails_when_to_chuc_cap_length_out_of_bounds()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Solutions Architect',
                'to_chuc_cap' => str_repeat('A', 101),
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to_chuc_cap']);
    }

    /**
     * Test dữ liệu được làm sạch XSS (loại bỏ thẻ HTML) cho tên chứng chỉ và tổ chức cấp.
     */
    public function test_xss_sanitization_strips_html_tags_in_certificate()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => '<script>alert("xss")</script>Certificate XSS',
                'to_chuc_cap' => '<b>Amazon</b> Web Services',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Kiểm tra trong database xem bản ghi vừa được tạo có bị strip tags chưa
        $chungChi = \Illuminate\Support\Facades\DB::table('chung_chi')
            ->where('id_nguoi_dung', $this->user->id)
            ->orderBy('id', 'desc')
            ->first();

        $this->assertNotNull($chungChi);
        $this->assertEquals('alert("xss")Certificate XSS', $chungChi->ten_chung_chi);
        $this->assertEquals('Amazon Web Services', $chungChi->to_chuc_cap);
    }

    /**
     * Test validation thất bại khi tệp tải lên không phải là định dạng PDF.
     */
    public function test_validation_fails_when_file_pdf_is_not_pdf()
    {
        $file = \Illuminate\Http\UploadedFile::fake()->create('image.png', 200, 'image/png');

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Solutions Architect',
                'to_chuc_cap' => 'AWS Enterprise',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
                'file_pdf' => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file_pdf']);
    }

    /**
     * Test validation thành công khi tải lên tệp PDF hợp lệ.
     */
    public function test_validation_succeeds_with_pdf_upload()
    {
        $file = \Illuminate\Http\UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.chung-chi.luu'), [
                'ten_chung_chi' => 'AWS Advanced Security',
                'to_chuc_cap' => 'AWS Enterprise',
                'ngay_cap' => '2023-01-01',
                'phan_loai' => 'chuyen_mon',
                'file_pdf' => $file,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Lấy bản ghi từ DB
        $chungChi = \Illuminate\Support\Facades\DB::table('chung_chi')
            ->where('id_nguoi_dung', $this->user->id)
            ->where('ten_chung_chi', 'AWS Advanced Security')
            ->first();

        $this->assertNotNull($chungChi);
        $this->assertNotNull($chungChi->file_pdf);
        $this->assertStringContainsString('uploads/chung-chi/', $chungChi->file_pdf);

        // Cleanup file created on disk by test
        $filePath = public_path($chungChi->file_pdf);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
