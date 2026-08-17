<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE nguoi_dung MODIFY ho_ten VARCHAR(500) NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY ma_nguoi_dung VARCHAR(500) NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY chuc_danh VARCHAR(500) NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY anh_dai_dien VARCHAR(500) NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY so_dien_thoai VARCHAR(500) NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY dia_chi TEXT NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY gioi_thieu TEXT NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY so_thich TEXT NULL");
        DB::statement("ALTER TABLE nguoi_dung MODIFY ke_hoach TEXT NULL");
    }

    public function down(): void
    {
    }
};
