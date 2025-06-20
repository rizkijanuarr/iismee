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
                                <th class="text-uppercase text-secondary text-m font-weight-bolder opacity-7"
                                    style="width: 1%!important">No.
                                </th>
                                <th class="text-uppercase text-secondary text-m font-weight-bolder opacity-7">Mata Kuliah
                                </th>
                                <th class="text-uppercase text-secondary text-m font-weight-bolder opacity-7">NIP
                                </th>
                                <th class="text-uppercase text-secondary text-m font-weight-bolder opacity-7">Nama Dosen
                                    Pengajar</th>
                                <th class="text-uppercase text-secondary text-m font-weight-bolder opacity-7 text-center">
                                    Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($matakuliah) == 0)
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">Belum Ada Data</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                            @foreach ($matakuliah as $key => $item)
                                <tr>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-m text-center">
                                                {{ $key + 1 }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-m">
                                                {{ $item->subject_name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-m">
                                                {{ $item->lecturer_id_number }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-m">
                                                {{ $item->name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-m text-center">
                                                {{ $item->nilai }}
                                            </h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div id="{{ $item->id }}">
                                            <div class="table-responsive p-0">
                                                <table class="table align-items-center mb-0 table-sm table-striped"
                                                    id="datatable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7"
                                                                style="width: 90%!important">
                                                                Aspek Penilaian</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">
                                                                Skor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($item->assesmentAspect as $aspek)
                                                            <tr>
                                                                <td style="white-space: normal !important">
                                                                    <div class="my-auto">
                                                                        <h6 class="mb-0 text-sm">
                                                                            {{ $aspek->name }}
                                                                        </h6>
                                                                    </div>
                                                                </td>
                                                                @foreach ($aspek->assessment as $assessment)
                                                                    @if ($assessment->student_id == $data->id)
                                                                        <td style="white-space: normal !important">
                                                                            <div class="my-auto">
                                                                                <h6 class="mb-0 text-sm text-center">
                                                                                    {{ $assessment->score }}
                                                                                </h6>
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
