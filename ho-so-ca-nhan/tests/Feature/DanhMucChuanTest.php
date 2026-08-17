<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DanhMucChuanTest extends TestCase
{
    protected $normalUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->normalUser = User::where('email', 'test@gmail.com')->first();
        
        $this->adminUser = User::where('vai_tro', 'quan_tri')->first();
        if (!$this->adminUser) {
            $this->adminUser = User::create([
                'ma_nguoi_dung' => 'ND-admin-test-catalog',
                'ho_ten' => 'Admin Catalog Test',
                'email' => 'admin-catalog-test@gmail.com',
                'so_dien_thoai' => '0999999991',
                'mat_khau' => bcrypt('123456'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
            ]);
        }

        // Clean up test items
        DB::table('ngon_ngu_lap_trinh')->where('ten_ngon_ngu', 'like', 'TestLang%')->delete();
        DB::table('ky_nang_mem')->where('ten_ky_nang', 'like', 'TestSkill%')->delete();
    }

    protected function tearDown(): void
    {
        DB::table('ngon_ngu_lap_trinh')->where('ten_ngon_ngu', 'like', 'TestLang%')->delete();
        DB::table('ky_nang_mem')->where('ten_ky_nang', 'like', 'TestSkill%')->delete();
        parent::tearDown();
    }

    /**
     * Test guest cannot access Catalog Index.
     */
    public function test_guest_cannot_access_catalog_index()
    {
        $response = $this->get(route('admin.danh-muc-chuan.index'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test normal user cannot access Catalog Index.
     */
    public function test_normal_user_cannot_access_catalog_index()
    {
        $response = $this->actingAs($this->normalUser)
            ->get(route('admin.danh-muc-chuan.index'));

        $response->assertRedirect(route('trang-chu'));
    }

    /**
     * Test admin can access Catalog Index.
     */
    public function test_admin_can_access_catalog_index()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.danh-muc-chuan.index'));

        $response->assertStatus(200);
        $response->assertSee('Danh mục chuẩn');
        $response->assertSee('Ngôn ngữ lập trình');
        $response->assertSee('Kỹ năng mềm');
    }

    /**
     * Test admin can save programming language with valid constraints.
     */
    public function test_admin_can_save_programming_language_within_bounds()
    {
        // 1. Valid save (2-20 characters)
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.luu'), [
                'ten_ngon_ngu' => 'TestLangPhp'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ngon_ngu_lap_trinh', ['ten_ngon_ngu' => 'TestLangPhp']);

        // 2. Length under 2 characters validation fails
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.luu'), [
                'ten_ngon_ngu' => 'T'
            ]);

        $response->assertSessionHasErrors(['ten_ngon_ngu']);

        // 3. Length over 20 characters validation fails
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.luu'), [
                'ten_ngon_ngu' => 'TestLangVeryLongProgrammingLanguageName'
            ]);

        $response->assertSessionHasErrors(['ten_ngon_ngu']);
    }

    /**
     * Test admin input is sanitized properly.
     */
    public function test_admin_input_is_sanitized_properly()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.luu'), [
                'ten_ngon_ngu' => ' <b>TestLangClean</b> '
            ]);

        $response->assertStatus(302);
        // HTML tags stripped, trailing whitespaces trimmed
        $this->assertDatabaseHas('ngon_ngu_lap_trinh', ['ten_ngon_ngu' => 'TestLangClean']);
        $this->assertDatabaseMissing('ngon_ngu_lap_trinh', ['ten_ngon_ngu' => ' <b>TestLangClean</b> ']);
    }

    /**
     * Test duplicate programming language prevention.
     */
    public function test_duplicate_programming_language_prevention()
    {
        // Save first one
        DB::table('ngon_ngu_lap_trinh')->insert(['ten_ngon_ngu' => 'TestLangPhp']);

        // Attempt duplicate
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.luu'), [
                'ten_ngon_ngu' => 'TestLangPhp'
            ]);

        $response->assertSessionHasErrors(['ten_ngon_ngu']);
    }

    /**
     * Test admin can update programming language.
     */
    public function test_admin_can_update_programming_language()
    {
        $id = DB::table('ngon_ngu_lap_trinh')->insertGetId(['ten_ngon_ngu' => 'TestLangOld']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.cap-nhat', $id), [
                'ten_ngon_ngu' => 'TestLangNew'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ngon_ngu_lap_trinh', ['id' => $id, 'ten_ngon_ngu' => 'TestLangNew']);
        $this->assertDatabaseMissing('ngon_ngu_lap_trinh', ['ten_ngon_ngu' => 'TestLangOld']);
    }

    /**
     * Test admin can delete programming language and triggers cascade clean.
     */
    public function test_admin_can_delete_programming_language_and_cleans_relations()
    {
        $langId = DB::table('ngon_ngu_lap_trinh')->insertGetId(['ten_ngon_ngu' => 'TestLangPhp']);
        
        // Link to normal user
        $relationId = DB::table('nguoi_dung_ngon_ngu_lap_trinh')->insertGetId([
            'nguoi_dung_id' => $this->normalUser->id,
            'ngon_ngu_lap_trinh_id' => $langId,
            'noi_bat' => 0
        ]);

        $this->assertDatabaseHas('nguoi_dung_ngon_ngu_lap_trinh', ['id' => $relationId]);

        // Delete programming language
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ngon-ngu.xoa', $langId));

        $response->assertStatus(302);
        
        // Verify both record and association are gone
        $this->assertDatabaseMissing('ngon_ngu_lap_trinh', ['id' => $langId]);
        $this->assertDatabaseMissing('nguoi_dung_ngon_ngu_lap_trinh', ['id' => $relationId]);
    }

    /**
     * Test admin can save soft skill with valid constraints.
     */
    public function test_admin_can_save_soft_skill_within_bounds()
    {
        // 1. Valid save (2-30 characters)
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.luu'), [
                'ten_ky_nang' => 'TestSkillCommunication'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ky_nang_mem', ['ten_ky_nang' => 'TestSkillCommunication']);

        // 2. Length under 2 characters validation fails
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.luu'), [
                'ten_ky_nang' => 'S'
            ]);

        $response->assertSessionHasErrors(['ten_ky_nang']);

        // 3. Length over 30 characters validation fails
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.luu'), [
                'ten_ky_nang' => 'TestSkillVeryLongSoftSkillTitleToValidateLengthConstraints'
            ]);

        $response->assertSessionHasErrors(['ten_ky_nang']);
    }

    /**
     * Test duplicate soft skill prevention.
     */
    public function test_duplicate_soft_skill_prevention()
    {
        // Save first one
        DB::table('ky_nang_mem')->insert(['ten_ky_nang' => 'TestSkillComm']);

        // Attempt duplicate
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.luu'), [
                'ten_ky_nang' => 'TestSkillComm'
            ]);

        $response->assertSessionHasErrors(['ten_ky_nang']);
    }

    /**
     * Test admin can update soft skill.
     */
    public function test_admin_can_update_soft_skill()
    {
        $id = DB::table('ky_nang_mem')->insertGetId(['ten_ky_nang' => 'TestSkillOld']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.cap-nhat', $id), [
                'ten_ky_nang' => 'TestSkillNew'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ky_nang_mem', ['id' => $id, 'ten_ky_nang' => 'TestSkillNew']);
        $this->assertDatabaseMissing('ky_nang_mem', ['ten_ky_nang' => 'TestSkillOld']);
    }

    /**
     * Test admin can delete soft skill and cleans associations.
     */
    public function test_admin_can_delete_soft_skill_and_cleans_relations()
    {
        $skillId = DB::table('ky_nang_mem')->insertGetId(['ten_ky_nang' => 'TestSkillComm']);

        // Link to normal user
        $relationId = DB::table('nguoi_dung_ky_nang_mem')->insertGetId([
            'nguoi_dung_id' => $this->normalUser->id,
            'ky_nang_mem_id' => $skillId,
            'noi_bat' => 0
        ]);

        $this->assertDatabaseHas('nguoi_dung_ky_nang_mem', ['id' => $relationId]);

        // Delete soft skill
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.danh-muc-chuan.ky-nang.xoa', $skillId));

        $response->assertStatus(302);

        // Verify both record and association are gone
        $this->assertDatabaseMissing('ky_nang_mem', ['id' => $skillId]);
        $this->assertDatabaseMissing('nguoi_dung_ky_nang_mem', ['id' => $relationId]);
    }

    /**
     * Test admin can query catalog index with default 100 rows pagination limit.
     */
    public function test_admin_can_query_catalog_with_default_100_rows()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.danh-muc-chuan.index', ['tab' => 'ngon_ngu']));

        $response->assertStatus(200);
        $danhSach = $response->viewData('danhSach');
        $this->assertEquals(100, $danhSach->perPage());
    }
}
