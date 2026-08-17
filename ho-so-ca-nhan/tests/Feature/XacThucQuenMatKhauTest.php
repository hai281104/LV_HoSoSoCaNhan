<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class XacThucQuenMatKhauTest extends TestCase
{
    protected $testEmail = 'test_quen_mat_khau@example.com';
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Xoa sach du lieu cu cua test email neu co
        User::where('email', $this->testEmail)->delete();
        DB::table('password_resets')->where('email', $this->testEmail)->delete();

        // Tao nguoi dung thu nghiem
        $this->user = User::create([
            'ma_nguoi_dung' => 'ND-' . round(microtime(true) * 1000),
            'ho_ten' => 'Người Dùng Test Quên Mật Khẩu',
            'email' => $this->testEmail,
            'so_dien_thoai' => '0987654322',
            'mat_khau' => Hash::make('password123'),
            'vai_tro' => 'nguoi_dung',
            'trang_thai' => 'hoat_dong',
        ]);
    }

    protected function tearDown(): void
    {
        // Cleanup sau test
        if ($this->user) {
            $this->user->delete();
        }
        DB::table('password_resets')->where('email', $this->testEmail)->delete();
        parent::tearDown();
    }

    /**
     * Test hien thi form quen mat khau.
     */
    public function test_hien_thi_form_quen_mat_khau()
    {
        $response = $this->get(route('quen-mat-khau'));
        $response->assertStatus(200);
        $response->assertSee('Quên mật khẩu');
        $response->assertSee('Email tài khoản');
    }

    /**
     * Test yeu cau quen mat khau voi email khong ton tai.
     */
    public function test_quen_mat_khau_email_khong_ton_tai()
    {
        $response = $this->from(route('quen-mat-khau'))
            ->post('/quen-mat-khau', [
                'email' => 'khong_ton_tai@example.com',
            ]);

        $response->assertRedirect(route('quen-mat-khau'));
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test yeu cau quen mat khau voi email hop le.
     */
    public function test_quen_mat_khau_email_hop_le()
    {
        $response = $this->from(route('quen-mat-khau'))
            ->post('/quen-mat-khau', [
                'email' => $this->testEmail,
            ]);

        $response->assertRedirect(route('quen-mat-khau'));
        $response->assertSessionHas('status');

        // Kiem tra xem token co duoc tao trong DB khong
        $this->assertDatabaseHas('password_resets', [
            'email' => $this->testEmail
        ]);
    }

    /**
     * Test hien thi form dat lai mat khau voi token hop le va khong hop le.
     */
    public function test_hien_thi_form_dat_lai_mat_khau()
    {
        // Tao token gia lap
        $token = 'test_token_123456';
        DB::table('password_resets')->insert([
            'email' => $this->testEmail,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Thu voi token khong hop le
        $responseInvalid = $this->get(route('password.reset', ['token' => 'token_sai']) . '?email=' . urlencode($this->testEmail));
        $responseInvalid->assertRedirect(route('quen-mat-khau'));
        $responseInvalid->assertSessionHasErrors('email');

        // Thu voi token hop le
        $responseValid = $this->get(route('password.reset', ['token' => $token]) . '?email=' . urlencode($this->testEmail));
        $responseValid->assertStatus(200);
        $responseValid->assertSee('Đặt lại mật khẩu');
        $responseValid->assertSee('Mật khẩu mới');
    }

    /**
     * Test cap nhat mat khau moi thanh cong.
     */
    public function test_cap_nhat_mat_khau_moi_thanh_cong()
    {
        // Tao token gia lap
        $token = 'test_token_update_123';
        DB::table('password_resets')->insert([
            'email' => $this->testEmail,
            'token' => $token,
            'created_at' => now(),
        ]);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $this->testEmail,
            'mat_khau' => 'newpassword123',
            'mat_khau_xac_nhan' => 'newpassword123',
        ]);

        $response->assertRedirect(route('dang-nhap'));
        $response->assertSessionHas('success');

        // Xac thuc mat khau moi da duoc bam va luu
        $userMoi = User::where('email', $this->testEmail)->first();
        $this->assertTrue(Hash::check('newpassword123', $userMoi->mat_khau));

        // Token reset phai bi xoa khoi bang password_resets
        $this->assertDatabaseMissing('password_resets', [
            'email' => $this->testEmail
        ]);
    }
}
