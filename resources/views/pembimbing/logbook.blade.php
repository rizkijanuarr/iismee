@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <p>Data Mahasiswa :</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">NIM</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->registration_number }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Nama</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Kelas</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->class }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Nama Perusahaan</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->company->company_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Alamat</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->company->company_address }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Divisi</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->division }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Tipe Magang</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4" value="{{ $data->internship_type }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">Tgl. Mulai</span>
                                    <input type="text" class="form-control ps-3" id="basic-url"
                                        aria-describedby="basic-addon3 basic-addon4"
                                        value="{{ $data->date_start }} s/d {{ $data->date_end }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a name="" id="" class="btn btn-info text-decoration-none"
        href="{{ url('print-logbook/' . $data->registration_number) }}" target="_blank" role="button"><i
            class="fas fa-file-pdf"></i> Cetak Logbook</a>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                    style="width: 1%!important">No.
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto
                                    Kegiatan
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Tanggapan</th>
                                @if (auth()->user()->level == 'pembimbing')
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($logbook) == 0)
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">Belum Ada Data</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                            @foreach ($logbook as $key => $item)
                                <tr>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm text-center">
                                                {{ $key + 1 }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $item->activity_name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $item->activity_date }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $item->description }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                <img src="{{ URL::asset('storage/' . $item->img) }}" alt=""
                                                    style="height: 100px">
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $item->response ?? '-' }}
                                            </h6>
                                        </div>
                                    </td>
                                    @if (auth()->user()->level == 'pembimbing')
                                        <td class="align-middle text-center">
                                            <a href="{{ url('logbook-response/' . $item->id . '/add-response') }}"
                                                class="btn btn-warning font-weight-bold text-xs"
                                                data-original-title="Edit user" id="edit">
                                                Berikan Tanggapan
                                            </a>
                                        </td>
                                    @endif
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
