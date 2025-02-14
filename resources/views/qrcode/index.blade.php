<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <!-- Tambahkan Font Awesome untuk ikon (opsional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .hero {
            background-image: url('https://source.unsplash.com/1600x900/?business,technology');
            background-size: cover;
            background-position: center;
        }

        .logo {
            height: 50px;
            /* Sesuaikan tinggi logo */
            flex: 0 0 auto;
            /* Pastikan logo tidak mengambil ruang tambahan */
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-purple-600 shadow-md py-4">
            <div class="container mx-auto flex justify-between items-center px-6">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('img/img.png') }}" alt="Logo" class="logo mr-2">
                    <span class="text-white text-lg font-semibold">Nama Aplikasi</span>
                </a>
                <div class="space-x-8 text-lg flex items-center">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/') }}"
                        class="bg-white text-purple-600 py-2 px-4 rounded hover:bg-purple-100">
                        HOME
                    </a>
                    <a href="{{ route('qrcode.index') }}"
                        class="bg-purple-800 text-white py-2 px-4 rounded hover:bg-purple-900">
                        QRCODE
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="bg-white text-purple-600 py-2 px-4 rounded hover:bg-purple-100">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="bg-purple-800 text-white py-2 px-4 rounded hover:bg-purple-900">
                        Register
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto mt-8 p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-2xl font-semibold mb-4">QR Code Generator</h1>

            <!-- Form Input Data -->
            <form action="{{ route('qrcode.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                    <input type="text" id="nama" name="nama"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-4">
                    <label for="kelas" class="block text-gray-700 text-sm font-bold mb-2">Kelas:</label>
                    <input type="text" id="kelas" name="kelas"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Masukkan Kelas" required>
                </div>
                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No HP:</label>
                    <input type="text" id="no_hp" name="no_hp"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Masukkan No HP" required>
                </div>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
            </form>

            <!-- Tabel Data -->
            <h2 class="text-xl font-semibold mt-8 mb-4">Daftar Siswa</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nama
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Kelas
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nomor HP
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                QR Code
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $item->nama }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $item->kelas }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $item->no_hp }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="{{ route('qrcode.generate', $item->id) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Generate
                                    QR</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-inner py-6">
            <div class="container mx-auto text-center">
                &copy; 2025 Perusahaan Anda. Semua Hak Dilindungi. |
                <a href="#" class="text-purple-600 hover:text-purple-800">Kebijakan Privasi</a> |
                <a href="#" class="text-purple-600 hover:text-purple-800">Syarat dan Ketentuan</a>
            </div>
        </footer>
    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                isLoggedIn: false
            },
            mounted() {
                // Simulasi pemeriksaan status login
                axios.get('/api/user')
                    .then(response => {
                        if (response.data) {
                            this.isLoggedIn = true;
                        }
                    })
                    .catch(error => {
                        console.log('Gagal memeriksa status login', error);
                    });
            }
        });
    </script>
</body>

</html>
