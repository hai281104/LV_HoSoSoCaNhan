<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'nguoi_dung';

    /**
     * Vo hieu hoa tu dong quan ly timestamps cua Eloquent vi database quan ly qua ngay_tao va ngay_cap_nhat.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ma_nguoi_dung',
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'ngay_sinh',
        'dia_chi',
        'chuc_danh',
        'gioi_thieu',
        'anh_dai_dien',
        'vai_tro',
        'trang_thai',
        'so_thich',
        'ke_hoach',
        'thong_bao_bat',
        'hoat_dong_cuoi',
        'ly_do_khoa',
        'ngay_khoa',
        'khoa_den',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mat_khau',
    ];

    /**
     * The attributes that should be cast.
     * Mã hóa AES-256 tự động cho các thông tin cá nhân.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ho_ten' => 'encrypted',
        'ma_nguoi_dung' => 'encrypted',
        'chuc_danh' => 'encrypted',
        'anh_dai_dien' => 'encrypted',
        'so_dien_thoai' => 'encrypted',
        'dia_chi' => 'encrypted',
        'gioi_thieu' => 'encrypted',
        'so_thich' => 'encrypted',
        'ke_hoach' => 'encrypted',
    ];

    /**
     * Helper giải mã chuỗi mã hóa AES-256 an toàn.
     */
    public static function safeDecrypt($value)
    {
        if (empty($value) || !is_string($value)) {
            return $value;
        }

        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($value);
        } catch (\Throwable $e) {
            return $value;
        }
    }

    /**
     * Helper giải mã đối tượng hoặc mảng người dùng lấy từ DB::table.
     */
    public static function decryptUserRecord($user)
    {
        if (!$user) return $user;
        $fields = ['ho_ten', 'ma_nguoi_dung', 'chuc_danh', 'anh_dai_dien', 'so_dien_thoai', 'dia_chi', 'gioi_thieu', 'so_thich', 'ke_hoach'];
        
        if (is_object($user)) {
            foreach ($fields as $field) {
                if (isset($user->$field)) {
                    $user->$field = static::safeDecrypt($user->$field);
                }
            }
        } elseif (is_array($user)) {
            foreach ($fields as $field) {
                if (isset($user[$field])) {
                    $user[$field] = static::safeDecrypt($user[$field]);
                }
            }
        }
        return $user;
    }

    /**
     * Lay mat khau dung cho xac thuc.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    /**
     * Vo hieu hoa remember_token vi bang nguoi_dung khong co cot nay.
     */
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Khong lam gi ca
    }

    public function getRememberTokenName()
    {
        return '';
    }

}
