<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên đăng nhập',
            'name.unique' => 'Tên đăng nhập này đã được sử dụng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_STUDENT,
            'status' => User::STATUS_ACTIVE,
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'is_verified' => false,
        ]);

        // Send OTP Email
        Mail::to($user->email)->send(new OtpVerificationMail($otp));

        return redirect()->route('register.verify', ['email' => $user->email])
            ->with('success', 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra.');
    }

    public function showVerify(Request $request)
    {
        $email = $request->email;
        if (!$email) {
            return redirect()->route('register.form');
        }
        return view('auth.verify', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP',
            'otp.size' => 'Mã OTP phải có 6 chữ số',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác hoặc đã hết hạn.'])->withInput();
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'is_verified' => true,
        ]);

        Auth::login($user);
        $this->syncCart($user);

        return $this->redirectByRole($user);
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $user = User::where('email', $request->email)->first();
        
        if ($user->is_verified) {
            return redirect()->route('login.form')->with('info', 'Tài khoản này đã được xác thực.');
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpVerificationMail($otp));

        return back()->with('success', 'Mã OTP mới đã được gửi đến email của bạn.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập email hoặc tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // Admin login bypass - không cần xác thực OTP
        if ($request->name === 'admin' && $request->password === '1234') {
            $admin = User::where('name', 'admin')->first();
            if ($admin) {
                Auth::login($admin, $request->boolean('remember'));
                $request->session()->regenerate();
                $this->syncCart($admin);
                return $this->redirectByRole($admin);
            }
        }

        // Check if the input 'name' is an email or a username
        $loginField = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginField => $request->name,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember')))
        {
            return back()->withErrors(['name' => 'Tên đăng nhập / Email hoặc mật khẩu không chính xác'])->withInput();
        }

        $request->session()->regenerate();

        $user = Auth::user();
        
        if (!$user->is_verified) {
            $email = $user->email;
            Auth::logout();
            
            // Re-generate OTP if someone tries to login unverified
            $otp = rand(100000, 999999);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);
            Mail::to($user->email)->send(new OtpVerificationMail($otp));

            return redirect()->route('register.verify', ['email' => $email])
                ->with('error', 'Tài khoản của bạn chưa được xác thực. Mã OTP mới đã được gửi.');
        }

        $this->syncCart($user);

        if ($user->status !== User::STATUS_ACTIVE) {
            Auth::logout();
            return redirect()->route('login.form')->withErrors(['account' => 'Tài khoản của bạn đã bị khóa.']);
        }

        return $this->redirectByRole($user);
    }

    private function syncCart($user)
    {
        $sessionCart = session('cart', []);
        foreach ($sessionCart as $courseId) {
            CartItem::updateOrCreate([
                'user_id' => $user->id,
                'course_id' => $courseId,
            ]);
        }
        session()->forget('cart');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đã đăng xuất thành công');
    }

    protected function redirectByRole(User $user)
    {
        return redirect()->route('home')->with('success', 'Chào mừng quay trở lại, ' . $user->name . '!');
    }
}
