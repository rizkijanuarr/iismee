@extends('layout.admin')

@section('konten')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success fw-bold alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ url('manage-magang') }}" method="POST">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="lecturer_id" class="form-label">Dosen Pembimbing Lapangan</label>
                <select class="form-select" name="lecturer_id" id="lecturer_id" aria-label="Default select example">
                    <option selected>Pilih Dosen Pembimbing Lapangan</option>
                    @foreach ($dosen as $item)
                        <option value="{{ $item->lecturer['id'] }}">{{ $item->lecturer['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Mahasiswa</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                        Lengkap
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelas
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                        Perusahaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Divisi
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                        Mulai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                        Selesai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe
                                        Magang
                                    </th>
                                    <th class="opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mhs as $data)
                                    <tr>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->registration_number }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->class }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->company->company_name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->division }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->company->company_address }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->date_start }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->date_end }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->internship_type }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label class="visually-hidden" for="inputName">Hidden input label</label>
                                                <input type="hidden" class="form-control" name="student_id[]"
                                                    id="student_id" placeholder="" value="{{ $data->id }}"
                                                    style="display: none !important">
                                            </div>
                                            <button class="btn btn-primary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Tambah" onclick="return confirm('Apakah anda yakin?')"
                                                value="{{ $data->id }}" name="tambahkan">
                                                Tambahkan
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
