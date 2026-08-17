<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVaiTroToDuAnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('du_an') && !Schema::hasColumn('du_an', 'vai_tro')) {
            Schema::table('du_an', function (Blueprint $table) {
                $table->string('vai_tro', 100)->nullable()->after('ten_du_an');
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
        if (Schema::hasTable('du_an') && Schema::hasColumn('du_an', 'vai_tro')) {
            Schema::table('du_an', function (Blueprint $table) {
                $table->dropColumn('vai_tro');
            });
        }
    }
}
