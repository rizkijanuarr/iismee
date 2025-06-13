@extends('layout.user')

@section('konten')
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    
                    <!-- End Informasi Magang -->
                    <div class="text-container">
                        <div class="section-title">Welcome {{ auth()->user()->name }}</div>
                        <h3 class="h3-large">Internship Information System of Mechanical Enginering Education</h3>
                        <p class="p-large">Merupakan sebuah sistem informasi berbasis web yang digunakan untuk program magang
                            mahasiswa Pendidikan Teknik Mesin Unesa</p>
                        <a class="btn-solid-lg" href="{{ url('magang') }}">Magang</a>
                        @if ($cekAbsensiDatang != true)
                            <a class="quote text-decoration-none" href="{{ url('absensi') }}"><i
                                    class="fas fa-clipboard-check"></i>Absensi</a>
                        @else
                            <a class="quote text-decoration-none" href="{{ url('logbook') }}"><i class="fas fa-book"></i>Isi
                                Logbook</a>
                        @endif
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ URL::asset('img/header-illustration.svg') }}" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->

               
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of header -->
    <!-- end of header -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Informasi Penggunaan Aplikasi',
                html: `
                    <div style='text-align:left;'>
                        <b>Selama Magang</b>
                        <ul>
                            <li>Klik <b>Absensi/Logbook</b> untuk absen</li>
                            <li>Absen <b>Datang</b> setiap hari</li>
                            <li>Isi <b>Logbook</b> harian</li>
                            <li>Klik <b>Absensi Pulang</b> (<span class='badge bg-warning text-dark'>kuning</span>)</li>
                            <li>Ulangi tiap hari magang</li>
                            <li>Wajib isi <b>Surat Persetujuan</b></li>
                        </ul>
                        <b>Setelah Magang</b>
                        <ul>
                            <li>Klik <b>Laporan</b></li>
                            <li>Upload file laporan</li>
                            <li>Tunggu validasi dospem</li>
                            <li>Upload <b>Sertifikat Magang</b></li>
                            <li>Nilai konversi menunggu dosen industri</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal-wide'
                }
            });
        });
    </script>
@endsection
