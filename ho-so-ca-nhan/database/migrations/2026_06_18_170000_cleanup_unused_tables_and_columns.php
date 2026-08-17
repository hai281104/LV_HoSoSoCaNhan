<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupUnusedTablesAndColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop unused tables
        Schema::dropIfExists('users');
        Schema::dropIfExists('dich_vu');
        Schema::dropIfExists('nhat_ky_he_thong');

        // Drop unused column from thong_bao table
        if (Schema::hasTable('thong_bao') && Schema::hasColumn('thong_bao', 'duong_dan')) {
            Schema::table('thong_bao', function (Blueprint $table) {
                $table->dropColumn('duong_dan');
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
        // Recreate the tables if they were dropped
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('dich_vu')) {
            Schema::create('dich_vu', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->string('ma_dich_vu', 50);
                $table->integer('id_nguoi_dung');
                $table->string('tieu_de', 255);
                $table->string('phan_loai', 100);
                $table->text('noi_dung');
                $table->enum('trang_thai', ['hoat_dong', 'tam_dung', 'da_xoa']);
                $table->timestamp('ngay_xoa')->nullable();
                $table->timestamp('ngay_tao')->nullable();
            });
        }

        if (!Schema::hasTable('nhat_ky_he_thong')) {
            Schema::create('nhat_ky_he_thong', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('id_nguoi_dung');
                $table->string('loai_hanh_dong', 50);
                $table->text('chi_tiet');
                $table->string('dia_chi_ip', 45);
                $table->string('thong_tin_thiet_bi', 255);
                $table->timestamp('ngay_tao')->nullable();
            });
        }

        if (Schema::hasTable('thong_bao') && !Schema::hasColumn('thong_bao', 'duong_dan')) {
            Schema::table('thong_bao', function (Blueprint $table) {
                $table->string('duong_dan', 500)->nullable()->after('loai');
            });
        }
    }
}
