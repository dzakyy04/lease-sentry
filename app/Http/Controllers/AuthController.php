<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login';
        return view('auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }

        return back()->with('error', 'Email dan Password tidak sesuai');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function changePassword()
    {
        $title = 'Ubah Password';
        return view('pengaturan.ubah-password', compact('title'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'current_password.required' => 'Kolom password saat ini harus diisi.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa string.',
            'password.min' => 'Kolom password harus memiliki setidaknya 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Kolom konfirmasi password wajib diisi.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password baru harus berbeda dengan password saat ini!');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function forgotPasswordView()
    {
        $title = 'Lupa Password';
        return view('auth.forgot-password', compact('title'));
    }

    public function forgotPasswordSend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Mohon masukkan format email yang benar.',
            'email.exists' => 'Email tidak ditemukan dalam database.',
        ]);

        $token = Str::random(64);
        $expiresAt = Carbon::now()->addMinutes(60);

        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);

        Mail::send('email.forgot-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Kami telah mengirimkan link reset password ke email anda!');
    }

    public function resetPasswordView($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Mohon masukkan format email yang benar.',
            'email.exists' => 'Email tidak ditemukan dalam database.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa string.',
            'password.min' => 'Kolom password harus memiliki setidaknya 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Kolom konfirmasi password wajib diisi.',
        ]);


        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$updatePassword || Carbon::now()->gt($updatePassword->expires_at)) {
            return back()->with('error', 'Token kadaluarsa atau tidak valid!');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan!');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password baru harus berbeda dengan password lama!');
        }

        $user->update(['password' => Hash::make($request->password)]);

        PasswordReset::where(['email' => $request->email])->delete();

        return redirect('/login')->with('success', 'Password berhasil direset!');
    }
}
