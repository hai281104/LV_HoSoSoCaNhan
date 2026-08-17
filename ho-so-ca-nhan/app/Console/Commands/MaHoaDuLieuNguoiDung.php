<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class MaHoaDuLieuNguoiDung extends Command
{
    /**
     * Tên lệnh Artisan.
     *
     * @var string
     */
    protected $signature = 'encrypt:user-data';

    /**
     * Mô tả lệnh.
     *
     * @var string
     */
    protected $description = 'Mã hóa AES-256 cho toàn bộ dữ liệu thông tin cá nhân của người dùng hiện có trong cơ sở dữ liệu';

    /**
     * Thực thi lệnh.
     */
    public function handle()
    {
        $this->info('Đang bắt đầu quá trình quét và mã hóa AES-256 cho dữ liệu người dùng...');

        $users = DB::table('nguoi_dung')->get();
        $fields = ['ho_ten', 'ma_nguoi_dung', 'chuc_danh', 'anh_dai_dien', 'so_dien_thoai', 'dia_chi', 'gioi_thieu', 'so_thich', 'ke_hoach'];

        $count = 0;
        foreach ($users as $user) {
            $updates = [];
            foreach ($fields as $field) {
                $val = $user->$field;
                if (!empty($val) && is_string($val)) {
                    // Kiểm tra xem đã được mã hóa AES-256 chưa
                    $isEncrypted = false;
                    try {
                        Crypt::decryptString($val);
                        $isEncrypted = true;
                    } catch (\Throwable $e) {
                        $isEncrypted = false;
                    }

                    if (!$isEncrypted) {
                        $updates[$field] = Crypt::encryptString($val);
                    }
                }
            }

            if (!empty($updates)) {
                $updates['ngay_cap_nhat'] = now();
                DB::table('nguoi_dung')->where('id', $user->id)->update($updates);
                $count++;
            }
        }

        $this->info("Hoàn tất! Đã mã hóa dữ liệu thành công cho {$count} người dùng.");
        return 0;
    }
}
