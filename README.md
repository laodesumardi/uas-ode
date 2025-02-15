Untuk mengimplementasikan fitur autentikasi menggunakan Laravel Breeze, berikut adalah langkah-langkah instalasi dan konfigurasi yang perlu Anda lakukan, beserta contoh kode yang relevan.

<h3>Langkah-langkah Instalasi Laravel Breeze</h3>

<h2>1 Instalasi Laravel: </h2>
<p>Jika Anda belum memiliki aplikasi Laravel, buatlah proyek baru dengan perintah berikut:</p>
<p>composer create-project --prefer-dist laravel/laravel nama_proyek
</p>

<h2>2 Instalasi Laravel Breeze: </h2>
<p>Setelah aplikasi Laravel terpasang, instal Laravel Breeze melalui Composer:</p>
<br>composer require laravel/breeze --dev

<h2>3 Menginstal Fitur Autentikasi:</h2>
<p>Jalankan perintah untuk menginstal scaffolding Breeze:</p>
<br> php artisan breeze:install

<h2>4 Instalasi Dependencies Frontend:</h2>
<p>Setelah menginstal Breeze, Anda perlu menginstal dependencies frontend menggunakan npm. Jalankan perintah berikut:</p>
<br>npm install && npm run dev

<h2>5 Konfigurasi Database:</h2>
<p>Sesuaikan file .env untuk mengonfigurasi database Anda. Misalnya:</p>
<p>
    DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
</p>

<h2>6 Jalankan Migrasi:</h2>
<p>Untuk membuat tabel yang dibutuhkan oleh Laravel Breeze, jalankan migrasi database:</p>
<br> php artisan migrate

<h2>7 Jalankan Aplikasi:</h2>
<p>Terakhir, jalankan server pengembangan untuk melihat autentikasi Breeze yang telah terinstal:</p>
<br>php artisan serve

<p>Anda dapat mengakses aplikasi di http://localhost:8000</p>

<h1>Contoh Kode Relevan</h1>
<p>Setelah mengikuti langkah-langkah di atas, Laravel Breeze secara otomatis menyediakan beberapa route dan tampilan untuk fitur autentikasi seperti login, registrasi, dan reset kata sandi.</p>

<h1>Route Default</h1>
<p>Breeze sudah menyediakan route default yang dapat Anda lihat di routes/web.php. Contoh route yang tersedia adalah:</p>

<p>use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
</p>

<h1>Mengaktifkan Verifikasi Email</h1>
<p>
    Jika Anda ingin menambahkan fitur verifikasi email, Anda bisa menambahkan middleware verifikasi email ke route dan memperbarui model User untuk menggunakan trait MustVerifyEmail. Berikut adalah contoh kode untuk menambahkan route verifikasi email:
</p>
<p>
    use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

</p>

<p>Dengan langkah-langkah dan contoh kode di atas, Anda dapat dengan mudah mengimplementasikan fitur autentikasi menggunakan Laravel Breeze dalam aplikasi Laravel Anda.</p>

<p>Untuk membuat middleware di Laravel yang mencegah serangan XSS (Cross-Site Scripting), Anda dapat mengikuti langkah-langkah berikut. Middleware ini akan menyaring input dari pengguna untuk menghapus tag HTML dan karakter berbahaya lainnya.</p>

<h1>Langkah-langkah Membuat Middleware untuk XSS Protection</h1>

<h2>1 Buat Middleware</h2>
<p>Jalankan perintah berikut di terminal untuk membuat middleware baru bernama XSS:</p>
<br>php artisan make:middleware XSS

<h2>2 Implementasikan Logika Middleware</h2>
<p>Buka file middleware yang baru saja dibuat di app/Http/Middleware/XSS.php dan tambahkan logika untuk menyaring input. Berikut adalah contoh implementasi:</p>

<p>
    <?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Menyaring input untuk menghapus tag HTML
        $input = $request->all();
        array_walk_recursive($input, function (&$value) {
            $value = strip_tags($value); // Menghapus tag HTML
        });

        // Mengganti input yang telah disaring ke dalam request
        $request->merge($input);

        return $next($request);
    }
}

</p>

<h2>3 Daftarkan Middleware</h2>
<p>Setelah membuat middleware, Anda perlu mendaftarkannya di app/Http/Kernel.php. Tambahkan middleware ke dalam array $routeMiddleware:</p>

<p>
    protected $routeMiddleware = [
    // Middleware lain...
    'xss' => \App\Http\Middleware\XSS::class,
];

</p>

<h2>4 Menggunakan Middleware di Rute
</h2>
<p>Sekarang Anda dapat menggunakan middleware ini pada rute tertentu. Misalnya, jika Anda memiliki rute yang menerima input dari pengguna, Anda bisa menambahkan middleware xss seperti berikut:</p>
<p>
    use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['xss']], function () {
    Route::post('/submit', [YourController::class, 'submit'])->name('submit');
});

</p>

<h2>5 Contoh Penggunaan dalam Controller</h2>
<p>Berikut adalah contoh bagaimana Anda dapat menangani data yang disubmit setelah melewati middleware XSS:</p>

<p>namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function submit(Request $request)
    {
        // Data sudah disaring dari tag HTML oleh middleware XSS
        $data = $request->all();

        // Lakukan sesuatu dengan data yang aman
        // Misalnya, simpan ke database atau proses lebih lanjut

        return response()->json(['message' => 'Data submitted successfully!', 'data' => $data]);
    }
}
</p>

<p>Untuk menambahkan logo sebagai watermark pada halaman login, navbar, dan footer menggunakan Laravel Blade, Anda dapat mengikuti langkah-langkah berikut. Kami akan membuat tampilan yang menggunakan logo secara dinamis, sehingga Anda dapat mengubah logo dengan mudah tanpa harus mengedit banyak file.</p>

<h1>Langkah-langkah Implementasi</h1>

<h2>1 Menyimpan Logo</h2>
<p>Pertama, simpan logo Anda di direktori publik aplikasi Laravel. Misalnya, simpan di public/images/logo.png.</p>

<h2>2 Membuat Layout Blade</h2>
<p>Buat file layout Blade yang akan digunakan untuk halaman login, navbar, dan footer. Misalnya, buat file resources/views/layouts/app.blade.php:</p>

<p>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        </a>
        <!-- Navbar content here -->
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer bg-light text-center py-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-footer">
        <p>© 2025 My Application</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

</p>

<h2>Halaman Login</h2>
<p>Kemudian, buat halaman login yang menggunakan layout tersebut. Misalnya, buat file resources/views/auth/login.blade.php:</p>
<p>@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-header">Login</div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection
</p>

<h2> 4 Menampilkan Logo Secara Dinamis</h2>
<p>Dengan menggunakan fungsi asset() dalam Blade, Anda dapat menampilkan logo secara dinamis di berbagai bagian aplikasi Anda. Fungsi ini menghasilkan URL yang benar untuk file yang disimpan di direktori publik.</p>

<h2>5 Menambahkan CSS untuk Watermark</h2>
<p>Jika Anda ingin menambahkan efek watermark pada logo, Anda bisa menambahkan beberapa CSS. Misalnya, tambahkan ke file CSS Anda:</p>
<p>
    .logo {
    width: 50px; /* Sesuaikan ukuran sesuai kebutuhan */
}

.logo-footer {
    width: 30px; /* Sesuaikan ukuran sesuai kebutuhan */
}

</p>

<h2>6 Menggunakan Logo di Tempat Lain</h2>
<p>Anda juga bisa menggunakan logo di tempat lain dalam aplikasi dengan cara yang sama. Cukup gunakan tag <img> dengan fungsi asset() untuk mendapatkan URL logo.</p>

<p>Untuk membuat fitur tanda tangan digital menggunakan QR Code di Laravel, Anda dapat mengikuti langkah-langkah berikut. Kami akan menggunakan paket simple-qrcode untuk menghasilkan QR Code yang berisi data tanda tangan digital dan menampilkannya pada halaman tertentu.</p>

<h1>Langkah-langkah Implementasi</h1>

<h2>1  Instalasi Paket QR Code</h2>
<p>
    Pertama, Anda perlu menginstal paket simple-qrcode. Jalankan perintah berikut di terminal Anda:
</p>
<p>composer require simplesoftwareio/simple-qrcode
</p>

<h2>2 Konfigurasi</h2>
<p>Setelah instalasi, Anda tidak perlu melakukan konfigurasi tambahan karena Laravel secara otomatis mendeteksi paket ini. Namun, jika Anda ingin mendaftarkan service provider dan alias secara manual, buka file config/app.php dan tambahkan:</p>

<p>
    'providers' => [
    // ...
    SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class,
],

'aliases' => [
    // ...
    'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class,
],

</p>

<h2>3 Membuat Controller</h2>
<p>Buat controller baru untuk menangani pembuatan QR Code. Jalankan perintah berikut:</p>
<p>php artisan make:controller QRCodeController
</p>
<p>Kemudian buka file app/Http/Controllers/QRCodeController.php dan tambahkan metode untuk menghasilkan QR Code:</p>

<p><?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    // Menampilkan halaman daftar data
    public function index()
    {
        $data = Siswa::all();
        return view('qrcode.index', compact('data'));
    }

    // Menyimpan data siswa ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'no_hp' => 'required|numeric',
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('qrcode.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Generate QR Code berdasarkan ID siswa
    public function generate($id)
    {
        $siswa = Siswa::findOrFail($id);
        $qrcode = QrCode::size(400)->generate("Nama: $siswa->nama, Kelas: $siswa->kelas, No HP: $siswa->no_hp");

        return view('qrcode.generate', compact('qrcode', 'siswa'));
    }
}

</p>

<h2>4 Menambahkan Rute</h2>
<p>Tambahkan rute untuk mengakses metode yang baru saja dibuat di routes/web.php:</p>
<p>use App\Http\Controllers\QRCodeController;

Route::get('/generate-qrcode', [QRCodeController::class, 'generateSignatureQRCode']);
</p>

<h2>5 Membuat form untuk menginput data<h2>
    <p><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code Generator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Input Data</h1>
    <form action="{{ route('qrcode') }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="kelas" placeholder="Masukkan Kelas" required>
        </div>
        <div class="form-group">
            <input type="number" class="form-control" name="uas" placeholder="Masukkan No hp" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <h2 class="mt-5">Daftar Data</h2>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>nomor hp</th></th>
                <th>QR Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->uas }}</td>
                    <td><a href="{{ route('generate', $item->id) }}" class="btn btn-success">Generate QR</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</p>

<h2>6 Membuat Tampilan Blade</h2>
<p>Buat file tampilan Blade untuk menampilkan QR Code yang dihasilkan. Buat file resources/views/qrcode.blade.php:</p>
<p><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Signature</title>
</head>
<body>
    <h1>QR Code Tanda Tangan Digital</h1>
    <div>
        {!! $qrCodeImage !!}
    </div>
</body>
</html>
</p>

sekarang anda bisa mengakses qrcode


<p>Untuk mengimplementasikan Captcha pada form login atau registrasi di Laravel, kita akan menggunakan paket mews/captcha. Berikut adalah langkah-langkah lengkap untuk mengintegrasikan Captcha guna mencegah serangan bot.</p>

<h1>Langkah-langkah Implementasi Captcha</h1>

<h2>1 Instalasi Paket Captcha
</h2>
<p>Jalankan perintah berikut untuk menginstal paket mews/captcha:</p>
<p>composer require mews/captcha
</p>

<h2>2 Daftarkan Service Provider</h2>
<p>Setelah instalasi, Anda perlu mendaftarkan service provider dan alias di file config/app.php. Tambahkan kode berikut:</p>
<p>
    'providers' => [
    // ...
    Mews\Captcha\CaptchaServiceProvider::class,
],

'aliases' => [
    // ...
    'Captcha' => Mews\Captcha\Facades\Captcha::class,
],

</p>

<h2>3 Publish Konfigurasi</h2>
<p>Jalankan perintah berikut untuk mempublish file konfigurasi:</p>
<p>php artisan vendor:publish --
    provider="Mews\Captcha\CaptchaServiceProvider"

    <br>
    File konfigurasi akan muncul di config/captcha.php, di mana Anda dapat menyesuaikan pengaturan Captcha sesuai kebutuhan.
</p>

<h2>4 Tambahkan Route</h2>
<p>Tambahkan route baru untuk melakukan reload captcha di routes/web.php:</p>
<p>Route::get('/reload-captcha', [App\Http\Controllers\Auth\RegisterController::class, 'reloadCaptcha']);
</p>

<h2>5 Edit RegisterController</h2>
<p>Buka file app/Http/Controllers/Auth/RegisterController.php dan tambahkan validasi untuk captcha serta fungsi untuk reload captcha:</p>
<p>use Mews\Captcha\Facades\Captcha;

protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'captcha' => ['required', 'captcha'], // Validasi captcha
    ]);
}

public function reloadCaptcha()
{
    return response()->json(['captcha' => captcha_img()]);
}
</p>

<h2>6  Edit Tampilan Form Registrasi</h2>
<p>Buka file resources/views/auth/register.blade.php dan tambahkan bagian untuk menampilkan captcha:</p>

<p>@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <br />
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- Input fields for name, email, password -->
                        <!-- ... -->

                        <!-- Captcha Section -->
                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                            <div class="col-md-6 captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" id="reload">Reload</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Enter Captcha</label>
                            <div class="col-md-6">
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '/reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
@endpush
@endsection
</p>

<h2>7 Menambahkan @stack('scripts')</h2>
<p>Pastikan Anda menambahkan @stack('scripts') di file layout Blade Anda (layouts/app.blade.php) sebelum tag penutup </body> agar skrip dapat berfungsi dengan baik.</p>

<p><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body>
    <!-- Body content -->

    @stack('scripts')
</body>
</html>
</p>

<h2>8Uji Coba</h2>
<p>Setelah menyelesaikan semua langkah di atas, Anda dapat menguji form registrasi dengan membuka URL /register. Cobalah untuk memasukkan data yang benar dan pastikan bahwa jika Anda memasukkan captcha yang salah, sistem tidak akan melanjutkan pendaftaran.</p>




