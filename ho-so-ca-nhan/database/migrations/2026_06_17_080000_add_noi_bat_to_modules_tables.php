<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoiBatToModulesTables extends Migration
{
    /**
     * Thêm cột noi_bat (boolean) vào 5 bảng module hồ sơ.
     */
    public function up()
    {
        $tables = ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'noi_bat')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->tinyInteger('noi_bat')->default(0)->after('id');
                });
            }
        }
    }

    /**
     * Xóa cột noi_bat khỏi các bảng.
     */
    public function down()
    {
        $tables = ['hoc_van', 'kinh_nghiem', 'du_an', 'chung_chi', 'thanh_tuu'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'noi_bat')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('noi_bat');
                });
            }
        }
    }
}
