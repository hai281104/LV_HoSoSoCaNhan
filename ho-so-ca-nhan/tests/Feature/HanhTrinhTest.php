<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HanhTrinhTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Lấy user test
        $this->user = User::where('email', 'test@gmail.com')->first();
    }

    /**
     * Test accessing timeline when unauthenticated redirects to login.
     */
    public function test_access_hanh_trinh_unauthenticated_redirects_to_login()
    {
        $response = $this->get(route('ho-so.hanh-trinh'));
        $response->assertRedirect(route('dang-nhap'));
    }

    /**
     * Test accessing timeline when authenticated displays all timeline cards, grouped and sorted.
     */
    public function test_access_hanh_trinh_authenticated_displays_data()
    {
        // 1. Insert Học vấn (Nam ket thuc: 2024 -> Năm 2024)
        DB::table('hoc_van')->insert([
            'id_nguoi_dung' => $this->user->id,
            'tieu_de' => 'Cử nhân CNTT Test',
            'ten_truong' => 'Trường Đại học Test',
            'nam_bat_dau' => 2020,
            'nam_ket_thuc' => 2024,
            'trang_thai' => 'da_tot_nghiep',
            'mo_ta' => 'Học tập lập trình phần mềm',
        ]);

        // 2. Insert Dự án (Ngay ket thuc: 2025-05-15 -> 15/05/2025)
        DB::table('du_an')->insert([
            'id_nguoi_dung' => $this->user->id,
            'ten_du_an' => 'Dự án CMS Test',
            'vai_tro' => 'Developer',
            'ngay_bat_dau' => '2025-01-01',
            'ngay_ket_thuc' => '2025-05-15',
            'mo_ta' => 'Phát triển hệ thống CMS',
        ]);

        // 3. Insert Chứng chỉ (Ngay het han: 2026-06-18 -> 18/06/2026)
        DB::table('chung_chi')->insert([
            'id_nguoi_dung' => $this->user->id,
            'ten_chung_chi' => 'Chứng chỉ AWS Test',
            'to_chuc_cap' => 'Amazon Web Services',
            'ngay_cap' => '2023-06-18',
            'ngay_het_han' => '2026-06-18',
            'phan_loai' => 'chuyen_mon',
        ]);

        // 4. Insert Thành tựu (Thoi gian: 10/2023 -> Tháng 10/2023)
        DB::table('thanh_tuu')->insert([
            'id_nguoi_dung' => $this->user->id,
            'ten_thanh_tuu' => 'Giải nhất Hackathon Test',
            'to_chuc_cap' => 'Đơn vị trao giải',
            'thoi_gian' => '10/2023',
            'phan_loai' => 'giai_thuong',
            'mo_ta' => 'Đạt giải nhất cuộc thi lập trình',
        ]);

        // 5. Insert Kinh nghiệm (Ngay ket thuc: 2022-04-20 -> 20/04/2022)
        DB::table('kinh_nghiem')->insert([
            'id_nguoi_dung' => $this->user->id,
            'vi_tri_cong_viec' => 'Junior Dev Test',
            'ten_cong_ty' => 'Công ty Cổ phần ABC',
            'ngay_bat_dau' => '2021-04-20',
            'ngay_ket_thuc' => '2022-04-20',
            'dang_lam_viec' => 0,
            'mo_ta_chi_tiet' => 'Lập trình website PHP',
        ]);

        // Access route
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.hanh-trinh'));

        $response->assertStatus(200);

        // Verify friendly date milestones are displayed
        $response->assertSee('Năm 2024');
        $response->assertSee('Năm 2025');
        $response->assertSee('Năm 2026');
        $response->assertSee('Năm 2023');
        $response->assertSee('Năm 2022');

        // Verify titles are displayed
        $response->assertSee('Cử nhân CNTT Test');
        $response->assertSee('Dự án CMS Test');
        $response->assertSee('Chứng chỉ AWS Test');
        $response->assertSee('Giải nhất Hackathon Test');
        $response->assertSee('Junior Dev Test');
    }

    /**
     * Test accessing timeline with no data displays empty state without error.
     */
    public function test_access_hanh_trinh_empty_data()
    {
        // Clear any pre-existing records for this user to ensure empty state
        DB::table('hoc_van')->where('id_nguoi_dung', $this->user->id)->delete();
        DB::table('du_an')->where('id_nguoi_dung', $this->user->id)->delete();
        DB::table('chung_chi')->where('id_nguoi_dung', $this->user->id)->delete();
        DB::table('thanh_tuu')->where('id_nguoi_dung', $this->user->id)->delete();
        DB::table('kinh_nghiem')->where('id_nguoi_dung', $this->user->id)->delete();

        // Access route with user that has no records (DatabaseTransactions ensures sandbox)
        $response = $this->actingAs($this->user)
            ->get(route('ho-so.hanh-trinh'));

        $response->assertStatus(200);
        $response->assertSee('Chưa có dữ liệu hành trình');
    }
}
