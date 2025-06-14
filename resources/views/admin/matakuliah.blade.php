@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        Informasi!
        <ul>
            <li>1. Untuk menambahkan Mata Kuliah klik <strong>Nonaktifkan Periode Penilaian</strong></li>
            <li>2. Kemudian klik fitur <strong>Aspek Penilaian</strong></li>
            <li>3. Kemudian klik fitur <strong>Magang</strong></li>
            <li>4. Kemudian kembali lagi ke halaman ini dan klik <strong>Aktifkan Periode Penilaian</strong></li>
        </ul>
    </div>
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">Manage {{ $title }}</h4>
        </div>
        <div class="col">
            @if ($penilaian->is_enable == false)
                <a href="{{ url('manage-matakuliah/create') }}" class="btn btn-primary float-end">
                    Tambahkan {{ $title }}
                </a>
            @endif
            <form action="{{ url('setPenilaian') }}" method="post">
                @csrf
                <button
                    class="btn {{ $penilaian->is_enable == true ? 'btn-danger bg-gradient-danger' : 'btn-warning bg-gradient-warning' }} float-end me-2"
                    data-toggle="tooltip" onclick="return confirm('Apakah anda yakin?')">
                    {{ $penilaian->is_enable == true ? 'Nonaktifkan' : 'Aktifkan' }} Periode Penilaian
                </button>
            </form>
        </div>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Mata
                                    Kuliah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SKS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Dosen
                                    Pengajar
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">Belum Ada Data</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $data)
                                    <tr>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->subject_name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->sks }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['lecturer_id_number'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['name'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="manage-matakuliah/{{ $data->subject_name }}/edit"
                                                class="edit btn font-weight-bold text-xs" data-original-title="Edit user"
                                                id="edit">
                                                Edit
                                            </a>
                                            @if ($penilaian->is_enable == false)
                                                <form action="manage-matakuliah/{{ $data->subject_name }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button
                                                        class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Hapus"
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
            </div>
        </div>
    </div>
@endsection
