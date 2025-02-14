<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .logo {
            height: 50px;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-md py-4">
            <div class="container mx-auto flex justify-between items-center px-6">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('img/img.png') }}" alt="Logo" class="logo mr-2">
                    <span class="text-white text-lg font-semibold">QR Code App</span>
                </a>
                <div class="space-x-8 text-lg flex items-center">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/') }}"
                        class="bg-white text-purple-600 py-2 px-4 rounded-lg hover:bg-purple-100 transition duration-300 shadow-md">
                        HOME
                    </a>
                    <a href="{{ route('qrcode.index') }}"
                        class="bg-purple-800 text-white py-2 px-4 rounded-lg hover:bg-purple-900 transition duration-300 shadow-md">
                        QRCODE
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="bg-white text-purple-600 py-2 px-4 rounded-lg hover:bg-purple-100 transition duration-300 shadow-md">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="bg-purple-800 text-white py-2 px-4 rounded-lg hover:bg-purple-900 transition duration-300 shadow-md">
                        Register
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto mt-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="px-6 py-8">
                    <h1 class="text-3xl text-center font-bold text-purple-700 mb-4">QR Code untuk {{ $siswa->nama }}
                    </h1>
                    <div class="flex justify-center">
                        <div class="border-4 border-purple-400 rounded-lg p-4">
                            {!! $qrcode !!}
                        </div>
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('qrcode.index') }}"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-md">Kembali
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-inner py-6 mt-8">
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
