@extends('layout.user')

@section('konten')
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
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
@endsection
