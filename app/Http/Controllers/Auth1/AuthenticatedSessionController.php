<?php

namespace App\Http\Controllers\Auth1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'CAPTCHA yang dimasukkan salah.'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function reloadCaptch()
    {
        return response()->json(['captcha' => captcha_src('flat')]);
    }

    // Menampilkan Halaman Registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Registrasi dengan Validasi CAPTCHA
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'CAPTCHA yang dimasukkan salah.'
        ]);

        // Simpan User ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Auto login setelah registrasi berhasil
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // Fungsi untuk Reload CAPTCHA
    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_src('flat')]);
    }
}
