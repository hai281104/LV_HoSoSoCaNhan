<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlTapTinToChungChiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chung_chi') && !Schema::hasColumn('chung_chi', 'url_tap_tin')) {
            Schema::table('chung_chi', function (Blueprint $table) {
                $table->string('url_tap_tin', 500)->nullable()->after('ma_chung_chi');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('chung_chi') && Schema::hasColumn('chung_chi', 'url_tap_tin')) {
            Schema::table('chung_chi', function (Blueprint $table) {
                $table->dropColumn('url_tap_tin');
            });
        }
    }
}
