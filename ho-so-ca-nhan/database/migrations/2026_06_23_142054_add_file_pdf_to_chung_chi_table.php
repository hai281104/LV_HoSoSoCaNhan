<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilePdfToChungChiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chung_chi') && !Schema::hasColumn('chung_chi', 'file_pdf')) {
            Schema::table('chung_chi', function (Blueprint $table) {
                $table->string('file_pdf', 500)->nullable()->after('url_tap_tin');
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
        if (Schema::hasTable('chung_chi') && Schema::hasColumn('chung_chi', 'file_pdf')) {
            Schema::table('chung_chi', function (Blueprint $table) {
                $table->dropColumn('file_pdf');
            });
        }
    }
}
