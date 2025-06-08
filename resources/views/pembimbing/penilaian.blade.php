@php
    use Carbon\Carbon;
@endphp

@extends('layout.admin')

@section('konten')
    <div class="row mb-4 justify-content-between" style="overflow: hidden">
        <div class="col-6">
            <h4>Daftar Mahasiswa </h4>
            <a class="btn btn-primary ms-auto" class="" target="_blank" href="{{ url('cetak-penilaian/') }}">Cetak
                Penilaian</a>
        </div>
    </div>
    <div class="row">
        @foreach ($mahasiswa as $item)
            <div class="col-md-4">
                <div class="card mb-3" style="width: 30rem;">
                    <div class="card-body">
                        @php
                            if (Carbon::now()->greaterThan(Carbon::parse($item->student->date_start)) && Carbon::now()->lessThan(Carbon::parse($item->student->date_end))) {
                                $periodeMagang = 'Sedang Berlangsung';
                                $warna = 'success';
                            } elseif (Carbon::now()->greaterThan(Carbon::parse($item->student->date_end))) {
                                $periodeMagang = 'Sudah Berakhir';
                                $warna = 'danger';
                            } else {
                                $periodeMagang = 'Belum Dimulai';
                                $warna = 'warning';
                            }
                        @endphp
                        <span class="badge text-bg-{{ $warna }} mb-3">
                            {{ $periodeMagang }}
                        </span>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                @if ($item->student->img_path != null)
                                    <img src="{{ URL::asset('storage/' . $item->student->img_path) }}" alt=""
                                        class="rounded-circle img-fluid"
                                        style="height: 80px; width: 80px; object-fit: cover" id="btn"
                                        style="cursor: pointer;">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title ellipsis">{{ $item->student->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">
                                    {{ $item->student->registration_number }} </h6>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <b> Nama Instansi : </b> {{ $item->company_name }}
                            </li>
                            <li>
                                <b> Divisi : </b> {{ $item->student->division }}
                            </li>
                            <li>
                                <b> Jenis Magang : </b> {{ $item->student->internship_type }}
                            </li>
                            <li>
                                <b> Jenis Konversi : </b> Konversi Matakuliah Umum
                            </li>
                            <li>
                                <b> Tanggal Pelaksanaan : </b> {{ $item->student->date_start }} S/D
                                {{ $item->student->date_end }}
                            </li>
                        </ul>
                        <div class="d-flex align-items-center">
                            @if ($penilaian->is_enable == true)
                                @if ($item->is_assessment == true)
                                    <a href="penilaian/{{ $item->student->registration_number }}/edit"
                                        class="btn btn-warning btn-sm card-link fw-bold text-dark"
                                        style="margin-bottom: 0!important">Ubah
                                        Nilai</a>
                                @else
                                    <a href="penilaian/{{ $item->student->registration_number }}"
                                        class="btn btn-primary btn-sm card-link fw-bold"
                                        style="margin-bottom: 0!important">Nilai</a>
                                @endif
                            @endif
                            <a href="penilaian/{{ $item->student->registration_number }}/show"
                                class="btn btn-light btn-sm card-link fw-bold" style="margin-bottom: 0!important">Lihat</a>
                            <div class="dropdown ms-auto">
                                <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item"
                                            href="{{ url('logbook-show/' . $item->student->registration_number) }}">Lihat
                                            Logbook</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('laporan-show/' . $item->student->registration_number) }}">Lihat
                                            Laporan</a></li>
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ url('cetak-absensi/' . $item->student->registration_number) }}">Cetak
                                            Absensi</a></li>
                                    @if ($item->document_path)
                                        <li><a class="dropdown-item" href="{{ url('storage/' . $item->document_path) }}"
                                                target="_blank">Lihat Surat Balasan</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
