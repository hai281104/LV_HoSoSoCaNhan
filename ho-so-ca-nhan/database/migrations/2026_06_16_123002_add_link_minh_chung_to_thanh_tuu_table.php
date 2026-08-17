<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkMinhChungToThanhTuuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thanh_tuu', function (Blueprint $table) {
            $table->string('link_minh_chung', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thanh_tuu', function (Blueprint $table) {
            $table->dropColumn('link_minh_chung');
        });
    }
}
