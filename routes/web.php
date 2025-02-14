<?php


use Mews\Captcha\Facades\Captcha;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\Auth1\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute yang dihasilkan oleh Laravel Breeze
// Mengimpor rute autentikasi dari Laravel Breeze
require __DIR__ . '/auth.php';
Route::get('/', function () {
    return view('welcome');
})->name('home');



// Dashboard hanya bisa diakses oleh user yang sudah login dan terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rute untuk logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    })->name('logout'); // Menamai rute logout
});

// Rute untuk pengelolaan profil pengguna
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('qrcode')->group(function () {
    Route::get('/', [QRCodeController::class, 'index'])->name('qrcode.index');
    Route::post('/store', [QRCodeController::class, 'store'])->name('qrcode.store');
    Route::get('/generate/{id}', [QRCodeController::class, 'generate'])->name('qrcode.generate');
});

Route::get('/captcha/reload', function () {
    return response()->json(['captcha' => Captcha::src()]);
});



// Menampilkan halaman login
Route::get('/login', [AuthenticatedSessionController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [AuthenticatedSessionController::class, 'login']);

// Proses logout
Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

// Refresh CAPTCHA
Route::get('/captcha/reload', [AuthenticatedSessionController::class, 'reloadCaptcha']);

Route::get('/register', [AuthenticatedSessionController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthenticatedSessionController::class, 'register']);

Route::get('/captcha/reload', [AuthenticatedSessionController::class, 'reloadCaptcha']);
