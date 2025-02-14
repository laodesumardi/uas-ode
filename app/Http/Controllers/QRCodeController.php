<?php

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
