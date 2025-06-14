<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | ISMEE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left Form Section -->
        <div class="p-8 flex flex-col justify-center bg-white relative">
            <a href="{{ url('/') }}"
                class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent text-2xl font-bold absolute top-4 left-8 hover:from-pink-600 hover:via-purple-600 hover:to-indigo-600 transition-all cursor-pointer">IISMEE</a>

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Masuk</h2>
                <p class="text-gray-600 text-sm">Masukan Email Anda di bawah ini</p>
                <p class="text-gray-600 text-sm">untuk masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="ex: rizal@gmail.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="ex: 123">
                </div>
                <div class="space-y-3">
                    <button type="submit"
                        class="w-full py-3 rounded-md bg-indigo-600 text-white font-semibold shadow-md hover:bg-indigo-700 transition-colors">
                        Masuk
                    </button>
                    <div class="text-center">
                        <a href="{{ url('daftar-pembimbing-industri') }}"
                            class="text-sm font-medium text-black hover:text-indigo-600 hover:underline">
                            Daftar sebagai Pembimbing Industri !
                        </a>
                    </div>
                </div>
            </form>

        </div>

        <!-- Right Section with Background Image -->
        <div class="relative min-h-screen bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ URL::asset('/img/bg.png') }}');">
            <!-- Dark Overlay untuk bikin text keliatan -->
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>

            <!-- Content di atas overlay -->
            <div
                class="relative z-10 flex flex-col justify-center items-end text-right min-h-screen px-8 -translate-y-16">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white drop-shadow-lg">Selamat</h2>
                    <h2 class="text-3xl font-bold text-white mb-4 drop-shadow-lg">Datang di SIAKAD</h2>
                    <p class="text-gray-100 text-lg italic drop-shadow-md">"Karena Setiap Data Akademik Itu Berharga"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // SweetAlert scripts
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}'
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        @if (session('errorLogin'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('errorLogin') }}'
            });
        @endif
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        @endif
    </script>
</body>

</html>
