<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDichVuCaNhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dich_vu_ca_nhan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->string('ten_dich_vu', 100);
            $table->text('mo_ta');
            $table->string('zalo', 255);
            $table->string('gmail', 255);
            $table->unsignedBigInteger('id_cv')->nullable();
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->useCurrent();

            $table->foreign('id_nguoi_dung')->references('id')->on('nguoi_dung')->onDelete('cascade');
            $table->foreign('id_cv')->references('id')->on('cv_ca_nhan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dich_vu_ca_nhan');
    }
}
