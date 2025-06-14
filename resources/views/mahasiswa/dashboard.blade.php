@extends('layout.user')

@section('konten')
    <header class="bg-white py-12 pt-[200px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12">

                <!-- KIRI: Informasi Text -->
                <div class="w-full lg:w-1/2 space-y-6">
                    <div>
                        <span class="inline-block bg-pink-100 text-pink-600 text-sm font-bold px-4 py-1 rounded-full">
                            Welcome {{ auth()->user()->name }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                        Internship Information System of Mechanical Engineering Education
                    </h1>

                    <p class="text-gray-600 text-lg">
                        Merupakan sebuah sistem informasi berbasis web yang digunakan untuk program magang mahasiswa
                        Pendidikan Teknik Mesin Unesa.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-4">
                        <a href="{{ url('magang') }}"
                            class="bg-pink-500 hover:no-underline hover:bg-pink-600 hover:text-white text-white font-semibold py-2 px-6 rounded-full shadow transition">
                            <i class="fas fa-book mr-2"></i> Magang
                        </a>

                        @if (!$cekAbsensiDatang)
                            <a href="{{ url('absensi') }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-6 rounded-full shadow transition hover:no-underline hover:text-white">
                                <i class="fas fa-clipboard-check mr-2"></i> Absensi
                            </a>
                        @else
                            <a href="{{ url('logbook') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-full shadow transition">
                                <i class="fas fa-book mr-2"></i> Isi Logbook
                            </a>
                        @endif

                        <button onclick="showPanduan()"
                            class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 px-6 rounded-full shadow transition">
                            <i class="fas fa-info-circle mr-2"></i> Lihat Panduan
                        </button>
                    </div>
                </div>

                <!-- KANAN: Gambar -->
                <div class="w-full lg:w-1/2">
                    <img src="{{ URL::asset('img/header-illustration.svg') }}" alt="Ilustrasi Header" class="w-full h-auto">
                </div>

            </div>
        </div>
    </header>

    <script>
        function showPanduan() {
            Swal.fire({
                icon: 'info',
                title: 'Panduan Penggunaan',
                html: `
                    <div style='text-align:left;'>
                        <b>Selama Magang</b>
                        <ul class="list-disc pl-5">
                            <li>Klik <b>Absensi/Logbook</b> untuk absen</li>
                            <li>Absen <b>Datang</b> setiap hari</li>
                            <li>Isi <b>Logbook</b> harian</li>
                            <li>Klik <b>Absensi Pulang</b> (<span class='bg-yellow-400 text-black px-1 rounded'>kuning</span>)</li>
                            <li>Ulangi tiap hari magang</li>
                            <li>Wajib isi <b>Surat Persetujuan</b></li>
                        </ul>
                        <br/>
                        <b>Setelah Magang</b>
                        <ul class="list-disc pl-5">
                            <li>Klik <b>Laporan</b></li>
                            <li>Upload file laporan</li>
                            <li>Tunggu validasi dospem</li>
                            <li>Upload <b>Sertifikat Magang</b></li>
                            <li>Nilai konversi menunggu dosen industri</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection
