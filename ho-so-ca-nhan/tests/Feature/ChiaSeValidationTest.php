<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ChiaSeValidationTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test sẵn có
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test truy cập trang chia sẻ hồ sơ khi chưa đăng nhập sẽ bị chuyển hướng.
     */
    public function test_access_chia_se_page_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('ho-so.chia-se'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test truy cập trang chia sẻ hồ sơ khi đã đăng nhập thành công.
     */
    public function test_access_chia_se_page_authenticated_success()
    {
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.chia-se'));

        $response->assertStatus(200);
        $response->assertSee('Chia sẻ hồ sơ');
        $response->assertSee('Tải & Gửi nhanh CV', false);
        $response->assertSee('Tải & Gửi nhanh Hồ sơ', false);
        $response->assertSee('Gửi nhanh file đã tải');
        $response->assertSee('Xem Hồ sơ Bảo mật');
        $response->assertSee('decrypt-file-input');
        $response->assertSee('decrypt-password-input');
    }

    /**
     * Test truy cập trang xem trước in khi chưa đăng nhập sẽ bị chuyển hướng.
     */
    public function test_access_xem_truoc_in_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('ho-so.xem-truoc-in'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test truy cập trang xem trước in khi đã đăng nhập thành công.
     */
    public function test_access_xem_truoc_in_authenticated_success()
    {
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.xem-truoc-in'));

        $response->assertStatus(200);
        $response->assertSee('HỒ SƠ NĂNG LỰC CÁ NHÂN');
    }
}
