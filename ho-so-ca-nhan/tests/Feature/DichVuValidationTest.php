<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DichVuValidationTest extends TestCase
{
    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test sẵn có
        $this->user = User::where('email', 'test@gmail.com')->first();
        if (!$this->user) {
            $this->user = User::factory()->create([
                'email' => 'test@gmail.com',
                'password' => bcrypt('password123'),
                'ho_ten' => 'Test User',
                'so_dien_thoai' => '0987654321',
                'dia_chi' => 'Hà Nội'
            ]);
        }
        
        // Lấy hoặc tạo user test khác
        $this->otherUser = User::where('email', '!=', 'test@gmail.com')->first();
        if (!$this->otherUser) {
            $this->otherUser = User::factory()->create([
                'email' => 'other_test@gmail.com',
                'password' => bcrypt('password123'),
                'ho_ten' => 'Other Test User',
                'so_dien_thoai' => '0387654321',
                'dia_chi' => 'TP HCM'
            ]);
        }
    }

    /**
     * Test truy cập trang Dịch vụ khi chưa đăng nhập sẽ bị chuyển hướng.
     */
    public function test_access_dich_vu_page_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('ho-so.dich-vu'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test truy cập trang Dịch vụ khi đã đăng nhập thành công.
     */
    public function test_access_dich_vu_page_authenticated_success()
    {
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.dich-vu'));

        $response->assertStatus(200);
        $response->assertSee('Dịch vụ cá nhân');
        $response->assertSee('Dịch vụ của tôi');
        $response->assertSee('Cộng đồng');
        $response->assertSee('Đăng ký dịch vụ mới');
    }

    /**
     * Test validation thất bại khi Tên dịch vụ trống.
     */
    public function test_validation_fails_when_ten_dich_vu_is_empty()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => '',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['ten_dich_vu']);
    }

    /**
     * Test validation thất bại khi Tên dịch vụ quá ngắn hoặc quá dài.
     */
    public function test_validation_fails_when_ten_dich_vu_length_out_of_bounds()
    {
        // Quá ngắn (1 ký tự)
        $response1 = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'A',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);
        $response1->assertStatus(422);
        $response1->assertJsonValidationErrors(['ten_dich_vu']);

        // Quá dài (51 ký tự)
        $response2 = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => str_repeat('A', 51),
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);
        $response2->assertStatus(422);
        $response2->assertJsonValidationErrors(['ten_dich_vu']);
    }

    /**
     * Test validation thất bại khi phân loại không hợp lệ.
     */
    public function test_validation_fails_when_phan_loai_is_invalid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ lập trình',
                'phan_loai' => 'invalid_category',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['phan_loai']);
    }

    /**
     * Test validation thất bại khi Zalo hoặc Gmail trống.
     */
    public function test_validation_fails_when_contact_info_is_empty()
    {
        // Trống Zalo
        $response1 = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ lập trình',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '',
                'gmail' => 'test@gmail.com'
            ]);
        $response1->assertStatus(422);
        $response1->assertJsonValidationErrors(['zalo']);

        // Trống Gmail
        $response2 = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ lập trình',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => ''
            ]);
        $response2->assertStatus(422);
        $response2->assertJsonValidationErrors(['gmail']);
    }

    /**
     * Test validation thất bại khi định dạng Gmail không hợp lệ.
     */
    public function test_validation_fails_when_gmail_is_invalid()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ lập trình',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ chi tiết',
                'zalo' => '0987654321',
                'gmail' => 'invalid-email-format'
            ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['gmail']);
    }

    /**
     * Test lưu dịch vụ mới thành công.
     */
    public function test_save_new_service_success()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ test tự động',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => 'Mô tả dịch vụ test tự động có độ dài hợp lệ',
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'thanh_cong' => true,
        ]);
        $response->assertJsonFragment([
            'thanh_cong' => true
        ]);
        $this->assertStringContainsString('Đăng ký dịch vụ thành công', $response->json('thong_bao'));

        $this->assertDatabaseHas('dich_vu_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_dich_vu' => 'Dịch vụ test tự động',
            'phan_loai' => 'lap_trinh_web'
        ]);
    }

    /**
     * Test lưu dịch vụ với phân loại mới thành công.
     */
    public function test_save_service_with_new_category_success()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ an ninh mạng',
                'phan_loai' => 'an_ninh_mang',
                'mo_ta' => 'Cung cấp các giải pháp bảo mật và an ninh mạng',
                'zalo' => '0987654321',
                'gmail' => 'security@gmail.com'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'thanh_cong' => true,
        ]);
        $response->assertJsonFragment([
            'thanh_cong' => true
        ]);
        $this->assertStringContainsString('Đăng ký dịch vụ thành công', $response->json('thong_bao'));

        $this->assertDatabaseHas('dich_vu_ca_nhan', [
            'id_nguoi_dung' => $this->user->id,
            'ten_dich_vu' => 'Dịch vụ an ninh mạng',
            'phan_loai' => 'an_ninh_mang'
        ]);
    }

    /**
     * Test cập nhật dịch vụ hiện tại thành công.
     */
    public function test_update_existing_service_success()
    {
        // 1. Tạo dịch vụ trước
        $id = DB::table('dich_vu_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_dich_vu' => 'Dịch vụ cũ',
            'phan_loai' => 'lap_trinh_web',
            'mo_ta' => 'Mô tả cũ',
            'zalo' => '0987654321',
            'gmail' => 'test@gmail.com',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        // 2. Gửi request cập nhật
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'id' => $id,
                'ten_dich_vu' => 'Dịch vụ đã sửa',
                'phan_loai' => 'toi_uu_sql',
                'mo_ta' => 'Mô tả đã sửa',
                'zalo' => '0387654321',
                'gmail' => 'newtest@gmail.com'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'thanh_cong' => true,
        ]);
        $response->assertJsonFragment([
            'thanh_cong' => true
        ]);
        $this->assertStringContainsString('Cập nhật dịch vụ thành công', $response->json('thong_bao'));

        $this->assertDatabaseHas('dich_vu_ca_nhan', [
            'id' => $id,
            'ten_dich_vu' => 'Dịch vụ đã sửa',
            'phan_loai' => 'toi_uu_sql',
            'zalo' => '0387654321'
        ]);
    }

    /**
     * Test xóa dịch vụ thành công.
     */
    public function test_delete_service_success()
    {
        // 1. Tạo dịch vụ
        $id = DB::table('dich_vu_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->user->id,
            'ten_dich_vu' => 'Dịch vụ cần xóa',
            'phan_loai' => 'lap_trinh_web',
            'mo_ta' => 'Mô tả',
            'zalo' => '0987654321',
            'gmail' => 'test@gmail.com',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        // 2. Gửi request xóa
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.xoa', $id));

        $response->assertStatus(200);
        $response->assertJson([
            'thanh_cong' => true,
            'thong_bao' => 'Xóa dịch vụ thành công!'
        ]);

        $this->assertDatabaseMissing('dich_vu_ca_nhan', [
            'id' => $id
        ]);
    }

    /**
     * Test xóa dịch vụ của người dùng khác sẽ bị chặn (trả về 403).
     */
    public function test_delete_service_owned_by_other_user_fails()
    {
        // 1. Tạo dịch vụ của otherUser
        $id = DB::table('dich_vu_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->otherUser->id,
            'ten_dich_vu' => 'Dịch vụ của other',
            'phan_loai' => 'lap_trinh_web',
            'mo_ta' => 'Mô tả',
            'zalo' => '0987654321',
            'gmail' => 'other@gmail.com',
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        // 2. Đăng nhập bằng user và cố gắng xóa dịch vụ của otherUser
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.xoa', $id));

        $response->assertStatus(403);
        $response->assertJson([
            'thanh_cong' => false,
            'thong_bao' => 'Không tìm thấy dịch vụ để xóa.'
        ]);

        // Đảm bảo bản ghi vẫn còn trong DB
        $this->assertDatabaseHas('dich_vu_ca_nhan', [
            'id' => $id
        ]);
    }

    /**
     * Test xem CV đính kèm với thông tin nhạy cảm được che đi.
     */
    public function test_view_linked_cv_sensitive_details_are_masked()
    {
        // 1. Tạo CV mẫu cho otherUser
        $cvId = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->otherUser->id,
            'ten_cv' => 'CV của other',
            'ma_template' => 'template_classic',
            'du_lieu_tuy_chinh' => json_encode([
                'kieu_cv' => 'tu_dong',
                'noi_dung_chinh_sua' => [
                    'email' => 'other_test@gmail.com',
                    'so_dien_thoai' => '0387654321',
                    'dia_chi' => '123 Đường ABC, TP HCM'
                ]
            ]),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        // 2. Tạo dịch vụ liên kết CV này cho otherUser
        $serviceId = DB::table('dich_vu_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $this->otherUser->id,
            'ten_dich_vu' => 'Dịch vụ của other đính kèm CV',
            'phan_loai' => 'lap_trinh_web',
            'mo_ta' => 'Mô tả',
            'zalo' => '0387654321',
            'gmail' => 'other_test@gmail.com',
            'id_cv' => $cvId,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now()
        ]);

        // 3. Đăng nhập bằng user và xem CV của otherUser
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.dich-vu.xem-cv', $serviceId));

        $response->assertStatus(200);
        
        // Kiểm tra xem các thông tin nhạy cảm đã bị che đi chưa
        $response->assertDontSee('other_test@gmail.com');
        $response->assertDontSee('0387654321');
        $response->assertDontSee('123 Đường ABC');
        
        // Kiểm tra xem các chuỗi đã che có xuất hiện không
        // regex của email: oth***@gmail.com hoặc ot*********@gmail.com
        // số điện thoại: 038***321
        $response->assertSee('038***321');
    }

    /**
     * Test tự động làm sạch và chuẩn hóa số Zalo, Gmail, và lọc XSS.
     */
    public function test_service_input_is_cleaned_and_sanitized()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => '<script>alert("xss")</script>Lập trình Python',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => '<b>Mô tả</b> gói dịch vụ <i>Python</i>',
                'zalo' => '  0912. 345 - 678  ', // có khoảng trắng, chấm, gạch ngang
                'gmail' => '  CONTACT_Us@Gmail.Com  ' // có viết hoa và khoảng trắng
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);

        // Lấy bản ghi từ DB để kiểm chứng
        $dichVu = DB::table('dich_vu_ca_nhan')
            ->where('id_nguoi_dung', $this->user->id)
            ->orderBy('id', 'desc')
            ->first();

        $this->assertNotNull($dichVu);
        // Kiểm tra XSS đã được lọc bỏ tag
        $this->assertEquals('alert("xss")Lập trình Python', $dichVu->ten_dich_vu);
        $this->assertEquals('Mô tả gói dịch vụ Python', $dichVu->mo_ta);
        // Kiểm tra số Zalo được chuẩn hóa
        $this->assertEquals('0912345678', $dichVu->zalo);
        // Kiểm tra Gmail được đưa về chữ thường và cắt khoảng trắng
        $this->assertEquals('contact_us@gmail.com', $dichVu->gmail);
    }

    /**
     * Test validation thất bại khi mô tả dịch vụ vượt quá 2000 ký tự.
     */
    public function test_validation_fails_when_mo_ta_exceeds_max_limit()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ lập trình',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => str_repeat('A', 2001),
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['mo_ta']);
    }

    /**
     * Test validation thành công khi mô tả dịch vụ đạt đúng 2000 ký tự.
     */
    public function test_validation_succeeds_when_mo_ta_is_exactly_2000_chars()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('ho-so.dich-vu.luu'), [
                'ten_dich_vu' => 'Dịch vụ 2000 ký tự',
                'phan_loai' => 'lap_trinh_web',
                'mo_ta' => str_repeat('A', 2000),
                'zalo' => '0987654321',
                'gmail' => 'test@gmail.com'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['thanh_cong' => true]);
    }
}
