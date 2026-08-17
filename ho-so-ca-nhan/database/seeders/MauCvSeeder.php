<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MauCvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mau_cv')->updateOrInsert(
            ['ma_mau_cv' => 'template_classic'],
            [
                'ten_mau' => 'Cổ điển đơn giản (Classic)',
                'phien_ban' => 'v1.0',
                'kich_thuoc_file' => 0,
                'anh_xem_truoc' => 'uploads/cv-templates/classic.png',
                'duong_dan_file' => 'ho-so.cv-templates.template_classic',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now(),
            ]
        );

        DB::table('mau_cv')->updateOrInsert(
            ['ma_mau_cv' => 'template_modern'],
            [
                'ten_mau' => 'Hiện đại chuyên nghiệp (Modern)',
                'phien_ban' => 'v1.0',
                'kich_thuoc_file' => 0,
                'anh_xem_truoc' => 'uploads/cv-templates/modern.png',
                'duong_dan_file' => 'ho-so.cv-templates.template_modern',
                'trang_thai' => 'hoat_dong',
                'ngay_tao' => now(),
                'ngay_cap_nhat' => now(),
            ]
        );
    }
}
