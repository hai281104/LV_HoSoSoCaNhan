<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLockFieldsToNguoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->text('ly_do_khoa')->nullable()->after('hoat_dong_cuoi');
            $table->timestamp('ngay_khoa')->nullable()->after('ly_do_khoa');
            $table->timestamp('khoa_den')->nullable()->after('ngay_khoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->dropColumn(['ly_do_khoa', 'ngay_khoa', 'khoa_den']);
        });
    }
}
