<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHoatDongCuoiToNguoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->timestamp('hoat_dong_cuoi')->nullable()->after('so_thich');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->dropColumn('hoat_dong_cuoi');
        });
    }
}
