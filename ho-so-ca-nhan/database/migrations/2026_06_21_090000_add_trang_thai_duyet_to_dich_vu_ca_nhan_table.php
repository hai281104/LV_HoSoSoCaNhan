<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTrangThaiDuyetToDichVuCaNhanTable extends Migration
{
    /**
     * Thêm cột trang_thai_duyet cho hệ thống duyệt dịch vụ của admin.
     * 0 = chờ duyệt, 1 = đã duyệt, 2 = từ chối
     */
    public function up()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->tinyInteger('trang_thai_duyet')->default(0)->after('trang_thai')
                  ->comment('0 = chờ duyệt, 1 = đã duyệt, 2 = từ chối');
            $table->text('ly_do_tu_choi')->nullable()->after('trang_thai_duyet')
                  ->comment('Lý do từ chối (nếu có)');
        });

        // Cập nhật các dịch vụ hiện có (trang_thai=1 => đã duyệt, trang_thai=0 => chờ duyệt)
        DB::table('dich_vu_ca_nhan')->update(['trang_thai_duyet' => 1]);
    }

    /**
     * Rollback migration.
     */
    public function down()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->dropColumn(['trang_thai_duyet', 'ly_do_tu_choi']);
        });
    }
}
