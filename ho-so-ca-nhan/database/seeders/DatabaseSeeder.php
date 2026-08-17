<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Dọn dẹp cơ sở dữ liệu (Trừ bảng mau_cv, ky_nang_mem, ngon_ngu_lap_trinh)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tablesToTruncate = [
            'album_hinh_anh',
            'album_su_kien',
            'chung_chi',
            'cv_ca_nhan',
            'dich_vu_ca_nhan',
            'dong_gop_y_kien',
            'du_an',
            'du_an_lien_ket',
            'hoc_van',
            'kinh_nghiem',
            'lich_cong_viec',
            'lien_ket_mxh',
            'nguoi_dung_ky_nang_mem',
            'nguoi_dung_ngon_ngu_lap_trinh',
            'nhat_ky_hoat_dong',
            'personal_access_tokens',
            'thanh_tuu',
            'thong_bao',
            'truy_cap',
            'nguoi_dung'
        ];

        foreach ($tablesToTruncate as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Tạo các tài khoản theo yêu cầu (Password: 123456)
        $hashedPassword = Hash::make('123456');

        // Tài khoản test@gmail.com để tất cả các unit test cũ chạy được thành công
        $testUserId = DB::table('nguoi_dung')->insertGetId([
            'ma_nguoi_dung' => 'ND-test',
            'ho_ten' => 'Người Dùng Test',
            'email' => 'test@gmail.com',
            'mat_khau' => $hashedPassword,
            'so_dien_thoai' => '0900000000',
            'ngay_sinh' => '2000-01-01',
            'dia_chi' => 'Hà Nội, Việt Nam',
            'chuc_danh' => 'QA Engineer',
            'gioi_thieu' => 'Tài khoản dùng cho mục đích kiểm thử tự động.',
            'vai_tro' => 'nguoi_dung',
            'trang_thai' => 'hoat_dong',
            'thong_bao_bat' => 1,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // Tài khoản nguoidunga@gmail.com
        $userAId = DB::table('nguoi_dung')->insertGetId([
            'ma_nguoi_dung' => 'ND-nguoidunga',
            'ho_ten' => 'Người Dùng A',
            'email' => 'nguoidunga@gmail.com',
            'mat_khau' => $hashedPassword,
            'so_dien_thoai' => '0912345678',
            'ngay_sinh' => '2000-01-01',
            'dia_chi' => 'Hà Nội, Việt Nam',
            'chuc_danh' => 'Lập trình viên PHP/Laravel',
            'gioi_thieu' => 'Tôi là Nguyễn Văn A, một lập trình viên backend đam mê xây dựng hệ thống web ổn định, bảo mật và hiệu năng cao.',
            'vai_tro' => 'nguoi_dung',
            'trang_thai' => 'hoat_dong',
            'thong_bao_bat' => 1,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // Tài khoản nguoidungb@gmail.com
        $userBId = DB::table('nguoi_dung')->insertGetId([
            'ma_nguoi_dung' => 'ND-nguoidungb',
            'ho_ten' => 'Người Dùng B',
            'email' => 'nguoidungb@gmail.com',
            'mat_khau' => $hashedPassword,
            'so_dien_thoai' => '0987654321',
            'ngay_sinh' => '2001-05-15',
            'dia_chi' => 'TP. Hồ Chí Minh, Việt Nam',
            'chuc_danh' => 'Nhà thiết kế giao diện UI/UX',
            'gioi_thieu' => 'Tôi là Trần Thị B, có kinh nghiệm 2 năm thiết kế giao diện sản phẩm số, tập trung vào trải nghiệm tối ưu của người dùng.',
            'vai_tro' => 'nguoi_dung',
            'trang_thai' => 'hoat_dong',
            'thong_bao_bat' => 1,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // Tài khoản admin@gmail.com
        DB::table('nguoi_dung')->insert([
            'ma_nguoi_dung' => 'ND-admin',
            'ho_ten' => 'Quản Trị Viên',
            'email' => 'admin@gmail.com',
            'mat_khau' => $hashedPassword,
            'so_dien_thoai' => '0909090909',
            'ngay_sinh' => '1995-10-10',
            'dia_chi' => 'Đà Nẵng, Việt Nam',
            'chuc_danh' => 'Quản trị viên hệ thống',
            'gioi_thieu' => 'Tôi phụ trách điều hành, quản trị nội dung và quản lý người dùng trên nền tảng DPCS.',
            'vai_tro' => 'quan_tri',
            'trang_thai' => 'hoat_dong',
            'thong_bao_bat' => 1,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // 3. Đảm bảo seed dữ liệu mẫu cho CV template (mau_cv) hoạt động
        $this->call(MauCvSeeder::class);

        // 4. Tạo dữ liệu mẫu cho Người Dùng A
        // CV Cá nhân
        $cvId = DB::table('cv_ca_nhan')->insertGetId([
            'id_nguoi_dung' => $userAId,
            'ten_cv' => 'CV Backend Developer - Nguyễn Văn A',
            'ma_template' => 'template_classic',
            'la_cv_chinh' => 1,
            'du_lieu_tuy_chinh' => json_encode([
                'muc_tieu' => 'Trở thành lập trình viên backend chuyên nghiệp, đóng góp giải pháp hệ thống tối ưu cho sự phát triển của công ty.',
                'ky_nang' => ['PHP', 'Laravel', 'MySQL', 'Git', 'RESTful API', 'Docker']
            ]),
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // Học vấn
        DB::table('hoc_van')->insert([
            'noi_bat' => 1,
            'id_nguoi_dung' => $userAId,
            'tieu_de' => 'Cử nhân Công nghệ thông tin',
            'ten_truong' => 'Đại học Bách Khoa',
            'xep_loai' => 'Giỏi',
            'gpa' => '3.4/4.0',
            'khoa' => 'Khoa Công nghệ thông tin',
            'nganh' => 'Kỹ thuật Phần mềm',
            'trang_thai' => 'da_tot_nghiep',
            'mo_ta' => 'Nghiên cứu về thuật toán, thiết kế hệ thống phần mềm, cơ sở dữ liệu và bảo mật thông tin.',
            'nam_bat_dau' => 2020,
            'nam_ket_thuc' => 2024,
        ]);

        // Kinh nghiệm
        DB::table('kinh_nghiem')->insert([
            'noi_bat' => 1,
            'id_nguoi_dung' => $userAId,
            'vi_tri_cong_viec' => 'Lập trình viên Backend PHP (Laravel)',
            'ten_cong_ty' => 'Công ty Công nghệ ABC',
            'ngay_bat_dau' => '2024-06-01',
            'dang_lam_viec' => 1,
            'mo_ta_chi_tiet' => 'Phát triển APIs cho ứng dụng di động, thiết kế cơ sở dữ liệu tối ưu hóa tốc độ tìm kiếm và viết kiểm thử tự động (Unit Test).',
        ]);

        // Chứng chỉ
        DB::table('chung_chi')->insert([
            'noi_bat' => 1,
            'id_nguoi_dung' => $userAId,
            'ten_chung_chi' => 'Laravel Certified Developer',
            'to_chuc_cap' => 'Laravel.com',
            'ngay_cap' => '2025-01-20',
            'ma_chung_chi' => 'LC-990-123X',
            'phan_loai' => 'Chuyên môn',
        ]);

        // Dự án
        $duAnId = DB::table('du_an')->insertGetId([
            'noi_bat' => 1,
            'id_nguoi_dung' => $userAId,
            'ten_du_an' => 'Hệ thống Quản lý và Tạo CV tự động',
            'vai_tro' => 'Backend Lead',
            'mo_ta' => 'Xây dựng toàn bộ hệ thống lưu trữ, phân tích log lỗi, hiển thị dung lượng DB và bảo mật xác thực của hệ thống.',
            'ngay_bat_dau' => '2025-02-10',
            'ngay_ket_thuc' => '2025-05-15',
            'tu_khoa' => json_encode(['Laravel', 'MySQL', 'CSS', 'Javascript']),
            'ngay_tao' => now(),
        ]);

        DB::table('du_an_lien_ket')->insert([
            'id_du_an' => $duAnId,
            'loai_lien_ket' => 'github',
            'duong_dan' => 'https://github.com/nguoidunga/ho-so-ca-nhan',
            'nhan_hien_thi' => 'Mã nguồn Dự án',
            'thu_tu' => 1
        ]);

        // Thành tựu
        DB::table('thanh_tuu')->insert([
            'noi_bat' => 1,
            'id_nguoi_dung' => $userAId,
            'ten_thanh_tuu' => 'Giải nhất cuộc thi Sáng tạo sinh viên Bách Khoa',
            'to_chuc_cap' => 'Trường Đại học Bách Khoa',
            'thoi_gian' => '2023',
            'phan_loai' => 'Học tập & Nghiên cứu',
            'mo_ta' => 'Giải thưởng dành cho giải pháp quản lý chi tiêu cá nhân thông minh ứng dụng AI.',
        ]);

        // Lịch công việc
        DB::table('lich_cong_viec')->insert([
            [
                'id_nguoi_dung' => $userAId,
                'tieu_de' => 'Giao ban dự án mới',
                'ngay_bat_dau' => date('Y-m-d', strtotime('+1 day')),
                'gio_bat_dau' => '09:00:00',
                'ngay_ket_thuc' => date('Y-m-d', strtotime('+1 day')),
                'gio_ket_thuc' => '10:30:00',
                'phan_loai' => 'hop_tac',
                'mo_ta' => 'Họp bàn về các tính năng phát triển trong sprint mới.',
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now(),
            ],
            [
                'id_nguoi_dung' => $userAId,
                'tieu_de' => 'Hạn hoàn thành báo cáo tháng',
                'ngay_bat_dau' => date('Y-m-d', strtotime('+3 days')),
                'gio_bat_dau' => '17:00:00',
                'ngay_ket_thuc' => date('Y-m-d', strtotime('+3 days')),
                'gio_ket_thuc' => '17:30:00',
                'phan_loai' => 'deadline',
                'mo_ta' => 'Gửi báo cáo hiệu suất công việc lên hệ thống cho Quản lý.',
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now(),
            ]
        ]);

        // Liên kết MXH
        DB::table('lien_ket_mxh')->insert([
            [
                'id_nguoi_dung' => $userAId,
                'ten_nen_tang' => 'LinkedIn',
                'duong_dan' => 'https://linkedin.com/in/nguoidunga',
                'hien_thi' => 1,
                'thu_tu' => 1,
                'ngay_tao' => now(),
            ],
            [
                'id_nguoi_dung' => $userAId,
                'ten_nen_tang' => 'Github',
                'duong_dan' => 'https://github.com/nguoidunga',
                'hien_thi' => 1,
                'thu_tu' => 2,
                'ngay_tao' => now(),
            ]
        ]);

        // Dịch vụ cá nhân
        DB::table('dich_vu_ca_nhan')->insert([
            'id_nguoi_dung' => $userAId,
            'ten_dich_vu' => 'Tư vấn Thiết kế Hệ thống Backend',
            'phan_loai' => 'Tư vấn kỹ thuật',
            'trang_thai' => 1,
            'mo_ta' => 'Hỗ trợ thiết kế database, cấu trúc APIs chuẩn RESTful, tích hợp các hệ thống logging và giám sát ứng dụng.',
            'zalo' => '0912345678',
            'gmail' => 'nguoidunga@gmail.com',
            'id_cv' => $cvId,
            'ngay_tao' => now(),
            'ngay_cap_nhat' => now(),
        ]);

        // 5. Tạo dữ liệu mẫu chung khác (Ý kiến đóng góp, Nhật ký, Thông báo)
        DB::table('dong_gop_y_kien')->insert([
            [
                'id_nguoi_dung' => $userAId,
                'noi_dung' => 'Giao diện hồng pastel rất đẹp và thân thiện với người dùng, các thao tác tạo CV cực kỳ nhanh chóng.',
                'ngay_tao' => now()->subHours(2),
            ],
            [
                'id_nguoi_dung' => $userBId,
                'noi_dung' => 'Mong ban quản trị bổ sung thêm một số mẫu template CV đa dạng ngành nghề hơn nữa.',
                'ngay_tao' => now()->subHour(),
            ]
        ]);

        DB::table('nhat_ky_hoat_dong')->insert([
            [
                'id_nguoi_dung' => $userAId,
                'loai_hoat_dong' => 'truy_cap',
                'mo_ta' => 'Đăng nhập vào hệ thống',
                'ip_dia_chi' => '127.0.0.1',
                'thiet_bi' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'ngay_tao' => now()->subMinutes(30),
            ],
            [
                'id_nguoi_dung' => $userAId,
                'loai_hoat_dong' => 'chinh_sua',
                'mo_ta' => 'Cập nhật thông tin học vấn',
                'ip_dia_chi' => '127.0.0.1',
                'thiet_bi' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'ngay_tao' => now()->subMinutes(15),
            ],
            [
                'id_nguoi_dung' => $userBId,
                'loai_hoat_dong' => 'truy_cap',
                'mo_ta' => 'Đăng nhập vào hệ thống',
                'ip_dia_chi' => '127.0.0.1',
                'thiet_bi' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'ngay_tao' => now()->subMinutes(5),
            ]
        ]);

        DB::table('thong_bao')->insert([
            'id_nguoi_dung' => $userAId,
            'tieu_de' => '🚀 Tài khoản kích hoạt thành công',
            'noi_dung' => 'Chào mừng bạn đến với Hệ thống quản lý hồ sơ cá nhân DPCS. Hãy bắt đầu tạo CV đầu tiên của mình ngay bây giờ.',
            'url_lien_ket' => null,
            'loai' => 'he_thong',
            'da_doc' => 0,
            'khoa_trung' => 'welcome_user_' . $userAId,
            'ngay_tao' => now(),
        ]);

        DB::table('truy_cap')->insert([
            [
                'session_id' => 'sess_1234567890',
                'ip_dia_chi' => '127.0.0.1',
                'ngay_truy_cap' => date('Y-m-d'),
                'ngay_tao' => now(),
            ],
            [
                'session_id' => 'sess_0987654321',
                'ip_dia_chi' => '127.0.0.1',
                'ngay_truy_cap' => date('Y-m-d'),
                'ngay_tao' => now()->subMinutes(10),
            ]
        ]);
    }
}
