<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $title }}
    </title>
    <!--     Fonts and icons     -->
    <!-- Removed Soft UI/Bootstrap & icon CSS to avoid conflicts with Tailwind -->
    <!-- Tailwind & SweetAlert for unified styling like login page -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left Form Section -->
        <div class="p-8 lg:px-16 flex flex-col justify-center bg-white relative">
            <a href="{{ url('/') }}" class="group inline-block absolute top-4 left-8 cursor-pointer">
                <span class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent text-2xl font-bold transition-all group-hover:from-pink-600 group-hover:via-purple-600 group-hover:to-indigo-600">IISMEE</span>
                <span class="block h-0.5 mt-0.5 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-full"></span>
            </a>

            <div class="max-w-2xl w-full mx-auto">
            <div class="text-center mb-8 mt-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Registrasi Pembimbing Industri</h2>
                <p class="text-gray-600 text-sm">Isi data Anda di bawah ini</p>
                <p class="text-gray-600 text-sm">untuk membuat akun pembimbing industri</p>
            </div>

            <form action="{{ url('daftar') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="Rizal Akbar">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="rizal@gmail.com" autocomplete="email">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="********" autocomplete="new-password">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">No. Telepon</label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="081234567890" autocomplete="tel">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Jabatan</label>
                    <input type="text" name="position" value="{{ old('position') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        placeholder="HRD / Supervisor">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="company_id" class="block text-sm font-semibold text-gray-800 mb-2">Nama Perusahaan</label>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" id="toggle-other-company" class="rounded border-gray-300 shadow-sm focus:shadow-md" {{ old('company_name_other') ? 'checked' : '' }}>
                            <span>Perusahaan belum ada?</span>
                        </label>
                    </div>
                    <select name="company_id" id="company_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white {{ old('company_name_other') ? 'hidden' : '' }}">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}" {{ old('company_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->company_name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="other-company-wrapper" class="mt-3 {{ old('company_name_other') ? '' : 'hidden' }}">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Perusahaan</label>
                        <input type="text" name="company_name_other" value="{{ old('company_name_other') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                            placeholder="PT. Akedemik Digital">

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Perusahaan</label>
                            <input type="text" name="company_address" value="{{ old('company_address') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                                placeholder="Jl. Ketintang No. 10, Surabaya">
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nomor Telepon Perusahaan</label>
                            <input type="text" name="company_number" value="{{ old('company_number') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                                placeholder="08571234567">
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Centang "Perusahaan belum ada?" untuk mengisi data perusahaan baru.</p>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <button type="submit"
                        class="w-full py-3 rounded-md text-white font-semibold shadow-md bg-gradient-to-r hover:bg-gradient-to-l from-pink-500 via-purple-500 to-indigo-500 hover:from-pink-600 hover:via-purple-600 hover:to-indigo-600 transition-all">
                        Daftar
                    </button>
                    <div class="text-center">
                        <a href="{{ route('login') }}"
                           class="group inline-block text-sm font-medium text-black transition-all duration-300 hover:text-transparent hover:bg-clip-text hover:bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500">
                            <span>Sudah punya akun? Masuk di sini</span>
                            <span class="block h-0.5 mt-0.5 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-full"></span>
                        </a>
                    </div>
                </div>
            </form>
            </div>
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
                    <p class="text-gray-100 text-lg italic drop-shadow-md">"Karena Setiap Data Akademik Itu Berharga"</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle input 'Nama Perusahaan' manual via checkbox
        document.addEventListener('DOMContentLoaded', function () {
            const selectEl = document.getElementById('company_id');
            const otherWrap = document.getElementById('other-company-wrapper');
            const toggleCb = document.getElementById('toggle-other-company');
            const otherInput = document.querySelector('input[name="company_name_other"]');
            const otherAddress = document.querySelector('input[name="company_address"]');
            const otherNumber = document.querySelector('input[name="company_number"]');
            function syncOtherVisibility() {
                const useOther = toggleCb && toggleCb.checked;
                if (otherWrap) otherWrap.classList.toggle('hidden', !useOther);
                if (selectEl) selectEl.classList.toggle('hidden', useOther);
                // Clear the inactive field to avoid sending both
                if (useOther && selectEl) selectEl.value = '';
                if (!useOther) {
                    if (otherInput) otherInput.value = '';
                    if (otherAddress) otherAddress.value = '';
                    if (otherNumber) otherNumber.value = '';
                }
            }
            if (toggleCb) toggleCb.addEventListener('change', syncOtherVisibility);
            syncOtherVisibility();
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: @json(session('success')),
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error'))
            });
        @endif
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: @json(implode('<br>', $errors->all()))
            });
        @endif
    </script>
</body>

</html>
