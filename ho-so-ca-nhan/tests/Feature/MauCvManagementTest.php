<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MauCvManagementTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        
        // Find or create admin user for testing
        $this->adminUser = User::where('vai_tro', 'quan_tri')->first();
        if (!$this->adminUser) {
            $this->adminUser = User::create([
                'ma_nguoi_dung' => 'ND-admin-test-cv',
                'ho_ten' => 'Admin CV Test',
                'email' => 'admin-cv-test@gmail.com',
                'so_dien_thoai' => '0999999992',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }

        // Clean up any test templates that might be left over
        DB::table('mau_cv')->where('ma_mau_cv', 'like', 'test_tpl_%')->delete();
    }

    protected function tearDown(): void
    {
        // Clean up test templates
        DB::table('mau_cv')->where('ma_mau_cv', 'like', 'test_tpl_%')->delete();
        parent::tearDown();
    }

    /**
     * Test accessing CV template list when unauthenticated redirects to login.
     */
    public function test_access_mau_cv_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('admin.mau-cv.index'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test accessing CV template list as normal user redirects back.
     */
    public function test_access_mau_cv_as_normal_user_redirects_back()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.mau-cv.index'));
            
        $response->assertRedirect(route('trang-chu'));
        $response->assertSessionHas('error');
    }

    /**
     * Test accessing CV template list as admin succeeds.
     */
    public function test_access_mau_cv_as_admin_succeeds()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.mau-cv.index'));
            
        $response->assertStatus(200);
        $response->assertSee('Quản lý mẫu CV');
        $response->assertSee('Mã mẫu CV');
        $response->assertSee('Tên gọi');
    }

    /**
     * Test admin can create a CV template.
     */
    public function test_admin_can_create_mau_cv_successfully()
    {
        $file = UploadedFile::fake()->image('test_preview.png');

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.mau-cv.store'), [
                'ma_mau_cv' => 'test_tpl_creative',
                'ten_mau' => 'Mẫu Sáng Tạo Test',
                'phien_ban' => 'v1.0',
                'trang_thai' => 'hoat_dong',
                'anh_xem_truoc_file' => $file,
                'noi_dung_view' => '@php // Test content @endphp <div>Creative Template Test</div>',
            ]);

        $response->assertRedirect(route('admin.mau-cv.index'));
        $response->assertSessionHas('thanh_cong');

        // Check if database has record
        $this->assertDatabaseHas('mau_cv', [
            'ma_mau_cv' => 'test_tpl_creative',
            'ten_mau' => 'Mẫu Sáng Tạo Test',
            'trang_thai' => 'hoat_dong',
        ]);

        // Verify physical file was uploaded
        $record = DB::table('mau_cv')->where('ma_mau_cv', 'test_tpl_creative')->first();
        $this->assertNotNull($record->anh_xem_truoc);
        $filePath = public_path($record->anh_xem_truoc);
        $this->assertTrue(file_exists($filePath));

        // Verify physical blade view file was created
        $viewPath = resource_path('views/ho-so/cv-templates/test_tpl_creative.blade.php');
        $this->assertTrue(file_exists($viewPath));
        $this->assertEquals('@php // Test content @endphp <div>Creative Template Test</div>', file_get_contents($viewPath));

        // Cleanup physical files
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        if (file_exists($viewPath)) {
            @unlink($viewPath);
        }
    }

    /**
     * Test validation fails when missing fields.
     */
    public function test_admin_create_mau_cv_validation_fails_when_missing_fields()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.mau-cv.store'), [
                'ma_mau_cv' => '',
                'ten_mau' => '',
                'noi_dung_view' => '',
            ]);

        $response->assertSessionHasErrors(['ma_mau_cv', 'ten_mau', 'noi_dung_view', 'anh_xem_truoc_file']);
    }

    /**
     * Test admin can update an existing template.
     */
    public function test_admin_can_update_mau_cv_successfully()
    {
        // 1. Create a dummy template view file first to simulate index/update
        $viewPath = resource_path('views/ho-so/cv-templates/test_tpl_update.blade.php');
        $directory = dirname($viewPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($viewPath, '@php // Original content @endphp');

        // Create a dummy template in database
        $id = DB::table('mau_cv')->insertGetId([
            'ma_mau_cv' => 'test_tpl_update',
            'ten_mau' => 'Tên Ban Đầu',
            'phien_ban' => 'v1.0',
            'kich_thuoc_file' => filesize($viewPath),
            'anh_xem_truoc' => 'uploads/cv-templates/classic.png',
            'duong_dan_file' => 'ho-so.cv-templates.test_tpl_update',
            'trang_thai' => 'hoat_dong',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // 2. Update it
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.mau-cv.update', $id), [
                'ten_mau' => 'Tên Cập Nhật',
                'phien_ban' => 'v1.1',
                'trang_thai' => 'tam_an',
                'noi_dung_view' => '@php // Updated content @endphp <div>Updated template body</div>',
            ]);

        $response->assertRedirect(route('admin.mau-cv.index'));
        $response->assertSessionHas('thanh_cong');

        // Check if database updated
        $this->assertDatabaseHas('mau_cv', [
            'id' => $id,
            'ten_mau' => 'Tên Cập Nhật',
            'phien_ban' => 'v1.1',
            'trang_thai' => 'tam_an',
        ]);

        // Verify physical view file was updated
        $this->assertTrue(file_exists($viewPath));
        $this->assertEquals('@php // Updated content @endphp <div>Updated template body</div>', file_get_contents($viewPath));

        // Cleanup
        if (file_exists($viewPath)) {
            @unlink($viewPath);
        }
    }

    /**
     * Test admin can toggle template status.
     */
    public function test_admin_can_toggle_mau_cv_status()
    {
        $id = DB::table('mau_cv')->insertGetId([
            'ma_mau_cv' => 'test_tpl_toggle',
            'ten_mau' => 'Mẫu Toggle Status',
            'phien_ban' => 'v1.0',
            'trang_thai' => 'hoat_dong',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('admin.mau-cv.doi-trang-thai', $id));

        $response->assertStatus(200);
        $response->assertJsonPath('thanh_cong', true);
        $response->assertJsonPath('trang_thai_moi', 'tam_an');

        // Verify state in database
        $record = DB::table('mau_cv')->where('id', $id)->first();
        $this->assertEquals('tam_an', $record->trang_thai);
    }

    /**
     * Test admin can soft delete a template.
     */
    public function test_admin_can_soft_delete_mau_cv_successfully()
    {
        $id = DB::table('mau_cv')->insertGetId([
            'ma_mau_cv' => 'test_tpl_delete',
            'ten_mau' => 'Mẫu Sắp Xóa',
            'phien_ban' => 'v1.0',
            'trang_thai' => 'hoat_dong',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.mau-cv.destroy', $id));

        $response->assertRedirect(route('admin.mau-cv.index'));
        
        // Verify soft deleted (ngay_xoa is filled)
        $record = DB::table('mau_cv')->where('id', $id)->first();
        $this->assertNotNull($record->ngay_xoa);
    }

    /**
     * Test admin cannot create a template with reserved 'default_auto' ma_mau_cv.
     */
    public function test_admin_cannot_create_mau_cv_with_reserved_ma_mau_cv()
    {
        $file = UploadedFile::fake()->image('test_preview.png');

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.mau-cv.store'), [
                'ma_mau_cv' => 'default_auto',
                'ten_mau' => 'Mẫu Hệ Thống Giả Mạo',
                'phien_ban' => 'v1.0',
                'trang_thai' => 'hoat_dong',
                'anh_xem_truoc_file' => $file,
                'noi_dung_view' => '@php // Exploit attempt @endphp',
            ]);

        $response->assertSessionHasErrors(['ma_mau_cv']);
        $this->assertDatabaseMissing('mau_cv', [
            'ma_mau_cv' => 'default_auto'
        ]);
    }
}
