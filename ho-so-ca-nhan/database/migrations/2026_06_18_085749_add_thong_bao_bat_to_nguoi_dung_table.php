<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThongBaoBatToNguoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->boolean('thong_bao_bat')->default(1)->after('trang_thai');
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
            $table->dropColumn('thong_bao_bat');
        });
    }
}
