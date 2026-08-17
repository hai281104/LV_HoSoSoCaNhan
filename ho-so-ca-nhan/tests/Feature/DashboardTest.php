<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test accessing dashboard when unauthenticated redirects to login.
     */
    public function test_access_dashboard_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('trang-chu'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test accessing dashboard when authenticated displays all 7 statistics cards.
     */
    public function test_access_dashboard_authenticated_displays_all_stats()
    {
        $response = $this->actingAs($this->user)
            ->get(route('trang-chu'));

        $response->assertStatus(200);
        $response->assertSee('Thống kê tổng quan');
        $response->assertSee('Quản lý CV');
        $response->assertSee('Portfolio dự án');
        $response->assertSee('Học vấn & Trình độ', false);
        $response->assertSee('Kinh nghiệm làm việc');
        $response->assertSee('Chứng chỉ');
        $response->assertSee('Thành tựu');
        $response->assertSee('Album ảnh nổi bật');
    }
}
