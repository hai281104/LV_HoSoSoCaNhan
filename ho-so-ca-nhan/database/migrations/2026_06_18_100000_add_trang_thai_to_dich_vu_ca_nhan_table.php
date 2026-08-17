<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrangThaiToDichVuCaNhanTable extends Migration
{
    /**
     * Thêm cột trang_thai (1=hiển thị, 0=ẩn khỏi cộng đồng).
     */
    public function up()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->tinyInteger('trang_thai')->default(1)->after('phan_loai')
                  ->comment('1 = hiển thị lên cộng đồng, 0 = ẩn');
        });
    }

    /**
     * Rollback migration.
     */
    public function down()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->dropColumn('trang_thai');
        });
    }
}
