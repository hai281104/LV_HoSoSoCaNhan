<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruyCapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truy_cap', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->string('ip_dia_chi', 45)->nullable();
            $table->date('ngay_truy_cap')->index();
            $table->timestamp('ngay_tao')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truy_cap');
    }
}
