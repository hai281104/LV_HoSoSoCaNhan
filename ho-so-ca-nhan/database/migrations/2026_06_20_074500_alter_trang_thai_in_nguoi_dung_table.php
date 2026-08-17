<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTrangThaiInNguoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE nguoi_dung MODIFY COLUMN trang_thai VARCHAR(50) DEFAULT 'hoat_dong'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE nguoi_dung MODIFY COLUMN trang_thai ENUM('hoat_dong', 'tam_dung', 'da_xoa') DEFAULT 'hoat_dong'");
        }
    }
}
