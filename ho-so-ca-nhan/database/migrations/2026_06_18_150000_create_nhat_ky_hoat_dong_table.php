<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhatKyHoatDongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhat_ky_hoat_dong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->string('loai_hoat_dong'); // 'truy_cap', 'chinh_sua', 'bao_mat'
            $table->text('mo_ta');
            $table->string('ip_dia_chi', 45)->nullable();
            $table->text('thiet_bi')->nullable();
            $table->timestamp('ngay_tao')->useCurrent();

            $table->foreign('id_nguoi_dung')->references('id')->on('nguoi_dung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhat_ky_hoat_dong');
    }
}
