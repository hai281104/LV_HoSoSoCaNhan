<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CvValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test sẵn có
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test truy cập trang danh sách CV thành công.
     */
    public function test_access_cv_list_success()
    {
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.cv.index'));

        $response->assertStatus(200);
        $response->assertSee('Danh sách CV cá nhân');
    }

    /**
     * Test tạo CV thủ công thành công.
     */
    public function test_create_cv_success()
    {
        $response = $this->actingAs($this->user)
            ->post(route('ho-so.cv.store'), [
                'ten_cv' => 'CV Test Thủ Công',
                'mo_ta_ngan' => 'Mô tả ngắn test',
                'kieu_cv' => 'thu_cong',
                'ma_template' => 'template_classic'
            ]);

        // Kiểm tra chuyển hướng về trang chỉnh sửa
        $response->assertStatus(302);
        
        // Kiểm tra xem dữ liệu có trong DB không
        $this->assertDatabaseHas('cv_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Test Thủ Công',
            'ma_template' => 'template_classic'
        ]);

        // Cleanup
        DB::table('cv_ca_nhan')->where('ten_cv', 'CV Test Thủ Công')->delete();
    }

    /**
     * Test validation thất bại khi thiếu trường bắt buộc khi tạo CV.
     */
    public function test_create_cv_validation_fails_when_missing_fields()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.cv.store'), [
                'ten_cv' => '', // Trống
                'kieu_cv' => 'invalid_type', // Sai kiểu
                'ma_template' => 'template_non_exist' // Không tồn tại
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_cv', 'kieu_cv', 'ma_template']);
    }

    /**
     * Test cập nhật cấu hình CV thành công.
     */
    public function test_update_cv_settings_success()
    {
        // Tạo CV nháp
        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Ban Dau',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode(['kieu_cv' => 'thu_cong', 'mau_chu_dao' => '#1e3a8a']),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.cv.update', $id), [
                'ten_cv' => 'CV Da Cap Nhat',
                'mo_ta_ngan' => 'Mo ta cap nhat',
                'ma_template' => 'template_modern',
                'mau_chu_dao' => '#2563eb',
                'hien_thi_cac_muc' => [
                    'hoc_van' => 'true',
                    'kinh_nghiem' => 'false'
                ],
                'thu_tu_cac_muc' => [
                    'hoc_van',
                    'kinh_nghiem',
                    'du_an'
                ]
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('thanh_cong', true);

        // Kiểm tra DB cập nhật
        $this->assertDatabaseHas('cv_ca_nhan', [
            'id' => $id,
            'ten_cv' => 'CV Da Cap Nhat',
            'ma_template' => 'template_modern'
        ]);

        // Cleanup
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }

    /**
     * Test xóa CV thành công.
     */
    public function test_delete_cv_success()
    {
        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Xóa Tạm',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode([]),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('ho-so.cv.destroy', $id));

        $response->assertStatus(302);
        
        // Kiểm tra xóa mềm (ngay_xoa được điền ngày)
        $cv = DB::table('cv_ca_nhan')->where('id', $id)->first();
        $this->assertNotNull($cv->ngay_xoa);

        // Cleanup
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }

    /**
     * Test xóa CV và xóa tệp ảnh đại diện riêng vật lý.
     */
    public function test_delete_cv_deletes_custom_avatar_file()
    {
        $uploadDir = public_path('uploads/cv-avatars/');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = 'test_avatar_' . time() . '.png';
        $filepath = $uploadDir . $filename;
        file_put_contents($filepath, 'fake image content');

        $this->assertTrue(file_exists($filepath));

        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Xóa Tạm Có Ảnh',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode([
                'anh_dai_dien' => 'uploads/cv-avatars/' . $filename
            ]),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('ho-so.cv.destroy', $id));

        $response->assertStatus(302);

        // Kiểm tra tệp tin vật lý đã bị xóa
        $this->assertFalse(file_exists($filepath));

        // Cleanup DB
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }

    /**
     * Test truy cập trang danh sách CV trên di động thành công.
     */
    public function test_mobile_access_cv_list_success()
    {
        $response = $this->actingAs($this->user)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)'])
            ->get(route('ho-so.cv.index'));

        $response->assertStatus(200);
        $response->assertSee('Danh sách CV cá nhân');
    }

    /**
     * Test di động tạo CV tự động thành công.
     */
    public function test_mobile_create_cv_automatic_success()
    {
        $response = $this->actingAs($this->user)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)'])
            ->post(route('ho-so.cv.store'), [
                'ten_cv' => 'CV Mobile Auto',
                'mo_ta_ngan' => 'Mô tả mobile auto',
                'kieu_cv' => 'tu_dong',
                'ma_template' => 'template_classic'
            ]);

        $response->assertStatus(302);
        
        // Kiểm tra xem dữ liệu có trong DB không
        $this->assertDatabaseHas('cv_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Mobile Auto',
            'ma_template' => 'template_classic'
        ]);

        // Cleanup
        DB::table('cv_ca_nhan')->where('ten_cv', 'CV Mobile Auto')->delete();
    }

    /**
     * Test di động tạo CV thủ công bị chặn (403).
     */
    public function test_mobile_create_cv_manual_fails()
    {
        // Thử tạo trực tiếp qua post thông thường
        $response = $this->actingAs($this->user)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)'])
            ->post(route('ho-so.cv.store'), [
                'ten_cv' => 'CV Mobile Manual',
                'mo_ta_ngan' => 'Mô tả mobile manual',
                'kieu_cv' => 'thu_cong',
                'ma_template' => 'template_classic'
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('loi', 'Trên thiết bị di động, bạn chỉ được phép tạo CV tự động.');

        // Thử tạo qua AJAX
        $responseAjax = $this->actingAs($this->user)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json'
            ])
            ->post(route('ho-so.cv.store'), [
                'ten_cv' => 'CV Mobile Manual Ajax',
                'mo_ta_ngan' => 'Mô tả mobile manual',
                'kieu_cv' => 'thu_cong',
                'ma_template' => 'template_classic'
            ]);

        $responseAjax->assertStatus(403);
        $responseAjax->assertJsonPath('thanh_cong', false);
        $responseAjax->assertJsonPath('thong_bao', 'Trên thiết bị di động, bạn chỉ được phép tạo CV tự động.');

        // Kiểm tra xem dữ liệu KHÔNG có trong DB
        $this->assertDatabaseMissing('cv_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Mobile Manual'
        ]);
        $this->assertDatabaseMissing('cv_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Mobile Manual Ajax'
        ]);
    }

    /**
     * Test di động truy cập trang chỉnh sửa CV bị chặn.
     */
    public function test_mobile_access_edit_cv_fails()
    {
        // Tạo CV nháp
        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Mobile Edit Test',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode(['kieu_cv' => 'thu_cong', 'mau_chu_dao' => '#1e3a8a']),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)'])
            ->get(route('ho-so.cv.edit', $id));

        $response->assertStatus(302);
        $response->assertRedirect(route('ho-so.cv.index'));
        $response->assertSessionHas('loi', 'Tính năng chỉnh sửa CV không khả dụng trên thiết bị di động.');

        // Cleanup
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }

    /**
     * Test di động cập nhật CV bị chặn (403).
     */
    public function test_mobile_update_cv_fails()
    {
        // Tạo CV nháp
        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Mobile Update Test',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode(['kieu_cv' => 'thu_cong', 'mau_chu_dao' => '#1e3a8a']),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)',
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json'
            ])
            ->postJson(route('ho-so.cv.update', $id), [
                'ten_cv' => 'CV Mobile Update Cap Nhat',
                'mo_ta_ngan' => 'Mo ta cap nhat',
                'ma_template' => 'template_modern',
                'mau_chu_dao' => '#2563eb',
                'hien_thi_cac_muc' => [
                    'hoc_van' => 'true'
                ],
                'thu_tu_cac_muc' => [
                    'hoc_van'
                ]
            ]);

        $response->assertStatus(403);
        $response->assertJsonPath('thanh_cong', false);
        $response->assertJsonPath('thong_bao', 'Tính năng chỉnh sửa CV không khả dụng trên thiết bị di động.');

        // Cleanup
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }

    /**
     * Test previewing automatic CV uses default_auto template.
     */
    public function test_preview_automatic_cv_uses_default_auto_template()
    {
        // 1. Tạo CV tự động
        $id = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_cv' => 'CV Tự Động Test View',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 0,
            'du_lieu_tuy_chinh' => json_encode(['kieu_cv' => 'tu_dong', 'mau_chu_dao' => '#1e3a8a']),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('ho-so.cv.preview', $id));

        $response->assertStatus(200);
        // Xác nhận view của template default_auto được tải
        $response->assertViewHas('templateView', 'ho-so.cv-templates.default_auto');

        // Cleanup
        DB::table('cv_ca_nhan')->where('id', $id)->delete();
    }
}
