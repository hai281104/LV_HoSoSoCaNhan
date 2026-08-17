<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoTaToLichCongViecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lich_cong_viec', function (Blueprint $table) {
            $table->text('mo_ta')->nullable()->after('phan_loai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lich_cong_viec', function (Blueprint $table) {
            $table->dropColumn('mo_ta');
        });
    }
}
