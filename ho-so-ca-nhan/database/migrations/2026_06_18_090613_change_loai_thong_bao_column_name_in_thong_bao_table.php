<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLoaiThongBaoColumnNameInThongBaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('thong_bao', 'loai_thong_bao') && !Schema::hasColumn('thong_bao', 'loai')) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `thong_bao` CHANGE `loai_thong_bao` `loai` VARCHAR(30)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('thong_bao', 'loai') && !Schema::hasColumn('thong_bao', 'loai_thong_bao')) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `thong_bao` CHANGE `loai` `loai_thong_bao` VARCHAR(30)');
        }
    }
}
