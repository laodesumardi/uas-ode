<!DOCTYPE html>
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
