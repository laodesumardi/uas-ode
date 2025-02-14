<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>QR Code</title>
</head>
<body>
    <h1>QR Code</h1>
    <div>{!! $qrcode !!}</div> <!-- Menampilkan QR Code -->
    <br />
    <a href="{{ url('/') }}">Kembali ke Halaman Utama</a> <!-- Link kembali -->
</body>
</html>
