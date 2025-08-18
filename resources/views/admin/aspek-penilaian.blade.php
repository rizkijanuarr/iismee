@extends('layout.admin')

@section('konten')
<div class="alert alert-danger bg-gradient-danger mt-3 text-white">
    <i class="bi bi-info-circle-fill me-2"></i>
    Informasi! <br/>
    Aspek Peniliaian minimal memiliki 3 Aspek Penilaian dari satu Mata Kuliah
</div>
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">Manage {{ $title }}</h4>
        </div>
        @if (isset($penilaian) && $penilaian->is_enable == false)
            <div class="col">
                <a href="{{ url('aspek-penilaian/create') }}" class="btn btn-primary float-end">
                    Tambahkan {{ $title }}
                </a>
            </div>
        @endif
    </div>

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Data {{ $title }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mata Kuliah
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Dosen
                                    Pengajar</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($matakuliah) === 0)
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">Belum Ada Data</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($matakuliah as $mk)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $mk->subject_name }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $mk->lecturer['lecturer_id_number'] ?? '-' }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $mk->lecturer['name'] ?? '-' }}</h6>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-primary btn-detail"
                                                data-target="#detail-{{ $mk->id }}">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div id="detail-{{ $mk->id }}" class="detail">
                                                <table class="table align-items-center mb-0 table-sm"
                                                    id="datatable-{{ $mk->id }}">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Aspek Penilaian</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Deskripsi</th>
                                                            <th class="text-secondary opacity-7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($mk->assesmentAspect) === 0)
                                                            <tr>
                                                                <td colspan="3" class="text-center">
                                                                    <div class="alert alert-danger bg-gradient-danger"
                                                                        role="alert">
                                                                        <h6 class="mb-0 text-white">Belum Ada Data</h6>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($mk->assesmentAspect as $aspek)
                                                                <tr>
                                                                    <td style="white-space: normal !important">
                                                                        <h6 class="mb-0 text-sm">{{ $aspek->name }}</h6>
                                                                    </td>
                                                                    <td style="white-space: normal !important">
                                                                        <h6 class="mb-0 text-sm">{!! $aspek->description !!}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <a href="{{ url('/aspek-penilaian/' . $aspek->id . '/edit') }}"
                                                                            class="edit btn font-weight-bold text-xs">
                                                                            Edit
                                                                        </a>
                                                                        @if (isset($penilaian) && $penilaian->is_enable == false)
                                                                            <form
                                                                                action="{{ url('aspek-penilaian/' . $aspek->id) }}"
                                                                                method="post" class="d-inline">
                                                                                @method('delete')
                                                                                @csrf
                                                                                <button
                                                                                    class="btn btn-danger font-weight-bold text-xs"
                                                                                    onclick="return confirm('Apakah anda yakin?')">
                                                                                    Hapus
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
