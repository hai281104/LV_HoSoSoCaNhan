<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhanLoaiToDichVuCaNhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->string('phan_loai', 50)->default('lap_trinh_web')->after('ten_dich_vu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->dropColumn('phan_loai');
        });
    }
}
