<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class XacThucController extends Controller
{
    /**
     * Hien thi form dang nhap.
     *
     * @return \Illuminate\View\View
     */
    public function hienThiFormDangNhap()
    {
        return view('xacthuc.dangnhap');
    }

    /**
     * Xu ly dang nhap nguoi dung.
     *
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dangNhap(Request $yeuCau)
    {
        if ($yeuCau->has('email')) {
            $yeuCau->merge([
                'email' => mb_strtolower(trim($yeuCau->input('email')), 'UTF-8')
            ]);
        }

        $luatKiemTra = [
            'email' => 'required|email',
            'mat_khau' => 'required|min:6',
        ];

        $thongBaoLoi = [
            'email.required' => 'Thu dien tu (Email) khong duoc de trong.',
            'email.email' => 'Thu dien tu (Email) khong dung dinh dang.',
            'mat_khau.required' => 'Mat khau khong duoc de trong.',
            'mat_khau.min' => 'Mat khau phai co it nhat 6 ky tu.',
        ];

        $yeuCau->validate($luatKiemTra, $thongBaoLoi);

        $thongTinXacThuc = [
            'email' => $yeuCau->input('email'),
            'password' => $yeuCau->input('mat_khau'), // Laravel core bat buoc dung khoa 'password'
        ];

        // Luon dat remember la false de bat buoc dang nhap lai khi dong trinh duyet/tab
        if (Auth::attempt($thongTinXacThuc, false)) {
            $nguoiDung = Auth::user();

            // Kiem tra trang thai hoat dong cua tai khoan
            if ($nguoiDung->trang_thai === 'bi_khoa') {
                if ($nguoiDung->khoa_den && now()->greaterThan($nguoiDung->khoa_den)) {
                    // Tu dong mo khoa
                    User::where('id', $nguoiDung->id)->update([
                        'trang_thai' => 'hoat_dong',
                        'ly_do_khoa' => null,
                        'ngay_khoa' => null,
                        'khoa_den' => null,
                    ]);
                    $nguoiDung->trang_thai = 'hoat_dong';
                }
            }

            if ($nguoiDung->trang_thai !== 'hoat_dong') {
                Auth::logout();
                $thongBaoKhoa = 'Tài khoản của bạn đã bị khóa.';
                if ($nguoiDung->ly_do_khoa) {
                    $thongBaoKhoa .= ' Lý do: ' . $nguoiDung->ly_do_khoa;
                }
                if ($nguoiDung->khoa_den) {
                    $thongBaoKhoa .= ' Thời hạn đến: ' . \Carbon\Carbon::parse($nguoiDung->khoa_den)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y');
                } else {
                    $thongBaoKhoa .= ' Khóa vĩnh viễn.';
                }
                return back()->withErrors([
                    'email' => $thongBaoKhoa,
                ])->withInput($yeuCau->only('email'));
            }

            $yeuCau->session()->regenerate();

            // Đăng xuất các thiết bị khác đang sử dụng tài khoản này
            Auth::logoutOtherDevices($yeuCau->input('mat_khau'), 'mat_khau');

            self::ghiLog($nguoiDung->id, 'bao_mat', 'Đăng nhập vào hệ thống thành công');

            // Ghi thông báo bảo mật: thiết bị đăng nhập
            $ua = $yeuCau->userAgent() ?? 'Không rõ';
            $ip = $yeuCau->ip() ?? 'Không rõ';
            // Rút gọn User-Agent (chỉ lấy phần Browser/OS)
            $uaRutGon = mb_substr($ua, 0, 80);
            \Illuminate\Support\Facades\DB::table('thong_bao')->insert([
                'id_nguoi_dung' => $nguoiDung->id,
                'loai'          => 'bao_mat',
                'tieu_de'       => '🔒 Đăng nhập thành công',
                'noi_dung'      => 'Thiết bị: ' . $uaRutGon . ' | IP: ' . $ip . ' | Lúc: ' . now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y'),
                'url_lien_ket'  => '/ho-so/nhat-ky',
                'da_doc'        => 0,
                'khoa_trung'    => null,
                'ngay_tao'      => now(),
            ]);

            if ($nguoiDung->vai_tro === 'quan_tri') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('trang-chu'));
        }

        return back()->withErrors([
            'email' => 'Thong tin dang nhap khong chinh xac.',
        ])->withInput($yeuCau->only('email'));
    }

    /**
     * Hien thi form dang ky.
     *
     * @return \Illuminate\View\View
     */
    public function hienThiFormDangKy()
    {
        return view('xacthuc.dangky');
    }

    /**
     * Xu ly dang ky tai khoan moi.
     *
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dangKy(Request $yeuCau)
    {
        if ($yeuCau->has('email')) {
            $yeuCau->merge([
                'email' => mb_strtolower(trim($yeuCau->input('email')), 'UTF-8')
            ]);
        }

        $luatKiemTra = [
            'ho_ten' => ['required', 'string', 'min:2', 'max:25', 'regex:/^[\p{L}\s]+$/u'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:nguoi_dung,email'],
            'so_dien_thoai' => ['required', 'string', 'regex:/^0(3|5|7|8|9)[0-9]{8}$/', 'unique:nguoi_dung,so_dien_thoai'],
            'mat_khau' => ['required', 'string', 'min:6', 'max:20'],
            'mat_khau_xac_nhan' => ['required', 'string', 'same:mat_khau'],
            'dong_y' => ['accepted'],
        ];

        $thongBaoLoi = [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'ho_ten.min' => 'Họ tên phải từ 2 đến 25 ký tự.',
            'ho_ten.max' => 'Họ tên phải từ 2 đến 25 ký tự.',
            'ho_ten.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng, không chứa số hay ký tự đặc biệt.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 150 ký tự.',
            'email.unique' => 'Email này đã được đăng ký sử dụng.',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.regex' => 'Số điện thoại phải gồm đúng 10 số và bắt đầu bằng các đầu số 03, 05, 07, 08, 09.',
            'so_dien_thoai.unique' => 'Số điện thoại này đã được đăng ký sử dụng.',
            'mat_khau.required' => 'Mật khẩu không được để trống.',
            'mat_khau.min' => 'Mật khẩu phải từ 6 đến 20 ký tự.',
            'mat_khau.max' => 'Mật khẩu phải từ 6 đến 20 ký tự.',
            'mat_khau_xac_nhan.required' => 'Xác nhận mật khẩu không được để trống.',
            'mat_khau_xac_nhan.same' => 'Mật khẩu xác nhận không trùng khớp.',
            'dong_y.accepted' => 'Bạn phải đồng ý với Điều khoản sử dụng và Chính sách bảo mật.',
        ];

        $yeuCau->validate($luatKiemTra, $thongBaoLoi);

        // Tu sinh ma nguoi dung giong nhu co so du lieu cu: ND-timestamp
        $maNguoiDung = 'ND-' . round(microtime(true) * 1000);

        $nguoiDungMoi = User::create([
            'ma_nguoi_dung' => $maNguoiDung,
            'ho_ten' => $yeuCau->input('ho_ten'),
            'email' => $yeuCau->input('email'),
            'so_dien_thoai' => $yeuCau->input('so_dien_thoai'),
            'mat_khau' => Hash::make($yeuCau->input('mat_khau')),
            'vai_tro' => 'nguoi_dung',
            'trang_thai' => 'hoat_dong',
        ]);

        // Dang nhap luon cho tai khoan moi
        Auth::login($nguoiDungMoi);

        $yeuCau->session()->regenerate();

        self::ghiLog($nguoiDungMoi->id, 'bao_mat', 'Đăng ký tài khoản mới thành công');

        // Ghi thông báo bảo mật: tài khoản mới
        \Illuminate\Support\Facades\DB::table('thong_bao')->insert([
            'id_nguoi_dung' => $nguoiDungMoi->id,
            'loai'          => 'bao_mat',
            'tieu_de'       => '🎊 Chào mừng bạn đến với DPCS!',
            'noi_dung'      => 'Tài khoản của bạn đã được tạo thành công. Hãy bắt đầu xây dựng hồ sơ cá nhân của mình ngay!',
            'url_lien_ket'  => '/ho-so',
            'da_doc'        => 0,
            'khoa_trung'    => null,
            'ngay_tao'      => now(),
        ]);

        if ($nguoiDungMoi->vai_tro === 'quan_tri') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('trang-chu');
    }

    /**
     * Dang xuat nguoi dung khoi he thong.
     *
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dangXuat(Request $yeuCau)
    {
        $userId = Auth::id();
        if ($userId) {
            \Illuminate\Support\Facades\DB::table('nguoi_dung')
                ->where('id', $userId)
                ->update(['hoat_dong_cuoi' => null]);
        }
        self::ghiLog($userId, 'bao_mat', 'Đăng xuất khỏi hệ thống');

        Auth::logout();

        $yeuCau->session()->invalidate();
        $yeuCau->session()->regenerateToken();

        return redirect()->route('dang-nhap');
    }

    /**
     * Hien thi trang bao tai khoan bi khoa.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function taiKhoanBiKhoa()
    {
        $nguoiDung = Auth::user();
        if ($nguoiDung->trang_thai !== 'bi_khoa') {
            return redirect()->route('trang-chu');
        }
        return view('xacthuc.bi-khoa', compact('nguoiDung'));
    }

    /**
     * Hien thi form quen mat khau.
     *
     * @return \Illuminate\View\View
     */
    public function hienThiFormQuenMatKhau()
    {
        return view('xacthuc.quenmatkhau');
    }

    /**
     * Xu ly gui email dat lai mat khau.
     *
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guiEmailDatLaiMatKhau(Request $yeuCau)
    {
        $yeuCau->validate(
            ['email' => 'required|email|exists:nguoi_dung,email'],
            [
                'email.required' => 'Email không được để trống.',
                'email.email' => 'Email không đúng định dạng.',
                'email.exists' => 'Email này không tồn tại trong hệ thống.',
            ]
        );

        $token = \Illuminate\Support\Str::random(60);

        \Illuminate\Support\Facades\DB::table('password_resets')->updateOrInsert(
            ['email' => $yeuCau->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        try {
            \Illuminate\Support\Facades\Mail::send('xacthuc.emails.reset', [
                'token' => $token,
                'email' => $yeuCau->email
            ], function($message) use ($yeuCau) {
                $message->to($yeuCau->email);
                $message->subject('Khôi phục mật khẩu - Hệ thống hồ sơ cá nhân (DPCS)');
            });

            return back()->with('status', 'Chúng tôi đã gửi đường dẫn khôi phục mật khẩu tới email của bạn. Vui lòng kiểm tra hộp thư.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi gửi email khôi phục mật khẩu: ' . $e->getMessage());

            $linkKhoiPhuc = route('password.reset', ['token' => $token]) . '?email=' . urlencode($yeuCau->email);

            if (config('app.env') === 'local') {
                return back()->with('status', 'Đã sinh liên kết khôi phục mật khẩu.')
                    ->with('warning', 'Hệ thống gửi mail local gặp sự cố. Bạn có thể nhấp trực tiếp vào đây để tiếp tục thử nghiệm: <a href="' . $linkKhoiPhuc . '" style="text-decoration: underline; font-weight: bold; color: #2563eb;">LIÊN KẾT ĐẶT LẠI MẬT KHẨU</a>');
            }

            return back()->withErrors(['email' => 'Không thể gửi email khôi phục mật khẩu vào lúc này. Vui lòng thử lại sau.']);
        }
    }

    /**
     * Hien thi form dat lai mat khau.
     *
     * @param  string  $token
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function hienThiFormDatLaiMatKhau($token, Request $yeuCau)
    {
        $email = $yeuCau->query('email');
        if (!$email) {
            return redirect()->route('quen-mat-khau')->withErrors(['email' => 'Yêu cầu không hợp lệ. Vui lòng nhập email khôi phục.']);
        }

        $banGhi = \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $email)->first();

        if (!$banGhi || $banGhi->token !== $token) {
            return redirect()->route('quen-mat-khau')->withErrors(['email' => 'Liên kết khôi phục mật khẩu không hợp lệ hoặc đã hết hạn.']);
        }

        $thoiHan = \Carbon\Carbon::parse($banGhi->created_at)->addMinutes(60);
        if (now()->greaterThan($thoiHan)) {
            \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $email)->delete();
            return redirect()->route('quen-mat-khau')->withErrors(['email' => 'Liên kết khôi phục mật khẩu đã hết hạn.']);
        }

        return view('xacthuc.datlaimatkhau', compact('token', 'email'));
    }

    /**
     * Xu ly cap nhat mat khau moi.
     *
     * @param  \Illuminate\Http\Request  $yeuCau
     * @return \Illuminate\Http\RedirectResponse
     */
    public function datLaiMatKhau(Request $yeuCau)
    {
        $yeuCau->validate(
            [
                'token' => 'required',
                'email' => 'required|email|exists:nguoi_dung,email',
                'mat_khau' => 'required|min:6|max:20',
                'mat_khau_xac_nhan' => 'required|same:mat_khau',
            ],
            [
                'email.required' => 'Email không được để trống.',
                'email.email' => 'Email không đúng định dạng.',
                'email.exists' => 'Email này không tồn tại trong hệ thống.',
                'mat_khau.required' => 'Mật khẩu mới không được để trống.',
                'mat_khau.min' => 'Mật khẩu mới phải có tối thiểu 6 ký tự.',
                'mat_khau.max' => 'Mật khẩu mới có tối đa 20 ký tự.',
                'mat_khau_xac_nhan.required' => 'Xác nhận mật khẩu không được để trống.',
                'mat_khau_xac_nhan.same' => 'Xác nhận mật khẩu không trùng khớp.',
            ]
        );

        $banGhi = \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $yeuCau->email)->first();

        if (!$banGhi || $banGhi->token !== $yeuCau->token) {
            return redirect()->route('quen-mat-khau')->withErrors(['email' => 'Liên kết xác minh không hợp lệ.']);
        }

        $thoiHan = \Carbon\Carbon::parse($banGhi->created_at)->addMinutes(60);
        if (now()->greaterThan($thoiHan)) {
            \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $yeuCau->email)->delete();
            return redirect()->route('quen-mat-khau')->withErrors(['email' => 'Yêu cầu khôi phục mật khẩu đã hết hạn.']);
        }

        $nguoiDung = User::where('email', $yeuCau->email)->first();
        if ($nguoiDung) {
            $nguoiDung->update([
                'mat_khau' => Hash::make($yeuCau->mat_khau)
            ]);

            \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $yeuCau->email)->delete();

            self::ghiLog($nguoiDung->id, 'bao_mat', 'Đổi mật khẩu thành công qua chức năng Quên mật khẩu');

            \Illuminate\Support\Facades\DB::table('thong_bao')->insert([
                'id_nguoi_dung' => $nguoiDung->id,
                'loai'          => 'bao_mat',
                'tieu_de'       => '🔒 Đã khôi phục mật khẩu thành công',
                'noi_dung'      => 'Mật khẩu của bạn đã được thay đổi thành công vào lúc ' . now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') . '.',
                'url_lien_ket'  => '/ho-so/nhat-ky',
                'da_doc'        => 0,
                'khoa_trung'    => null,
                'ngay_tao'      => now(),
            ]);

            return redirect()->route('dang-nhap')->with('success', 'Mật khẩu của bạn đã được đặt lại thành công. Vui lòng đăng nhập bằng mật khẩu mới.');
        }

        return back()->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
    }
}
