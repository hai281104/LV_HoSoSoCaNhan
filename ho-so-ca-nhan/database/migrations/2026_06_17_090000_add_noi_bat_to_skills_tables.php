<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoiBatToSkillsTables extends Migration
{
    public function up()
    {
        if (Schema::hasTable('nguoi_dung_ngon_ngu_lap_trinh') && !Schema::hasColumn('nguoi_dung_ngon_ngu_lap_trinh', 'noi_bat')) {
            Schema::table('nguoi_dung_ngon_ngu_lap_trinh', function (Blueprint $table) {
                $table->tinyInteger('noi_bat')->default(0);
            });
        }
        if (Schema::hasTable('nguoi_dung_ky_nang_mem') && !Schema::hasColumn('nguoi_dung_ky_nang_mem', 'noi_bat')) {
            Schema::table('nguoi_dung_ky_nang_mem', function (Blueprint $table) {
                $table->tinyInteger('noi_bat')->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('nguoi_dung_ngon_ngu_lap_trinh') && Schema::hasColumn('nguoi_dung_ngon_ngu_lap_trinh', 'noi_bat')) {
            Schema::table('nguoi_dung_ngon_ngu_lap_trinh', function (Blueprint $table) {
                $table->dropColumn('noi_bat');
            });
        }
        if (Schema::hasTable('nguoi_dung_ky_nang_mem') && Schema::hasColumn('nguoi_dung_ky_nang_mem', 'noi_bat')) {
            Schema::table('nguoi_dung_ky_nang_mem', function (Blueprint $table) {
                $table->dropColumn('noi_bat');
            });
        }
    }
}
