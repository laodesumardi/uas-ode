<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
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
        .hero {
            background-image: url('https://source.unsplash.com/1600x900/?business,technology');
            background-size: cover;
            background-position: center;
        }
        nav {
            background: linear-gradient(to right, #6b46c1, #b794f4);
            color: white;
        }
        .btn {
            background-color: #6b46c1;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #553c9a;
        }
        .btn-primary {
            background-color: #805ad5;
        }
        .btn-primary:hover {
            background-color: #6b46c1;
        }
        .notification {
            background-color: #f9fafb;
            border-left: 4px solid #6b46c1;
            padding: 1rem;
            margin-bottom: 1rem;
            color: #4a5568;
        }
        .logo {
            height: 50px; /* Sesuaikan tinggi logo */
            flex: 0 0 auto; /* Pastikan logo tidak mengambil ruang tambahan */
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div id="app">
        <nav class="shadow-md py-4">
            <div class="container mx-auto flex justify-between items-center px-6">
                <img src="{{ asset('img/img.png') }}" alt="Logo" class="logo"> <!-- Ganti URL gambar logo dengan URL yang sesuai -->
                <div class="space-x-8 text-lg flex items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                Dashboard
                            </a>
                            <a href="{{ route('qrcode.index') }}" class="btn">
                                QRCODE
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <main class="text-center hero flex items-center justify-center h-screen">
            <div class="w-full h-full flex flex-col items-center justify-center text-black bg-white bg-opacity-80 px-6 py-16 rounded-lg shadow-lg">
                <div class="notification">
                   Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eligendi atque perspiciatis, adipisci quis a voluptates.
                </div>

                <h1 class="text-5xl font-bold mb-6">Selamat Datang di Platform Kami</h1>
                <p class="text-gray-700 max-w-2xl mx-auto mb-10">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ad aliquam cupiditate et odit quo!</p>
                <a href="#" class="btn btn-primary text-lg font-semibold">Pelajari Lebih Lanjut</a>
            </div>
        </main>
        <footer class="bg-white shadow-inner py-6">
            <div class="container mx-auto text-center">
                &copy; 2025 la ode sumardi. Semua Hak Dilindungi. |
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
