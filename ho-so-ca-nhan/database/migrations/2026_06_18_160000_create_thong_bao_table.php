<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateThongBaoTable extends Migration
{
    public function up()
    {
        // Nếu bảng chưa tồn tại thì tạo mới
        if (!Schema::hasTable('thong_bao')) {
            Schema::create('thong_bao', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_nguoi_dung');
                $table->string('loai', 30);
                $table->string('tieu_de', 120);
                $table->text('noi_dung');
                $table->string('url_lien_ket', 500)->nullable();
                $table->boolean('da_doc')->default(false);
                $table->string('khoa_trung', 100)->nullable();
                $table->timestamp('ngay_tao')->useCurrent();

                $table->foreign('id_nguoi_dung')
                      ->references('id')
                      ->on('nguoi_dung')
                      ->onDelete('cascade');

                $table->index(['id_nguoi_dung', 'da_doc']);
                $table->index('khoa_trung');
            });
        } else {
            // Bảng đã tồn tại — thêm cột còn thiếu
            Schema::table('thong_bao', function (Blueprint $table) {
                if (!Schema::hasColumn('thong_bao', 'khoa_trung')) {
                    $table->string('khoa_trung', 100)->nullable()->after('da_doc');
                }
                if (!Schema::hasColumn('thong_bao', 'url_lien_ket')) {
                    $table->string('url_lien_ket', 500)->nullable()->after('noi_dung');
                }
            });

            // Thêm index nếu chưa có
            try {
                DB::statement('ALTER TABLE `thong_bao` ADD INDEX `thong_bao_khoa_trung_index` (`khoa_trung`)');
            } catch (\Exception $e) { /* index đã tồn tại */ }
            try {
                DB::statement('ALTER TABLE `thong_bao` ADD INDEX `thong_bao_id_nguoi_dung_da_doc_index` (`id_nguoi_dung`, `da_doc`)');
            } catch (\Exception $e) { /* index đã tồn tại */ }
        }
    }

    public function down()
    {
        Schema::dropIfExists('thong_bao');
    }
}
