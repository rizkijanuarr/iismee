@php
    use App\Helpers\CustomHelper;
    $customHelper = new CustomHelper();
    
@endphp

@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
        <div class="card mb-3">
            <div class="card-header">
                Data Magang Anda
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">NIM</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->registration_number }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Nama</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->name }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Kelas</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->class }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Perusahaan</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->company->company_name }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Divisi</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->division }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Tipe Magang</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->internship_type }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Tgl. Mulai</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->date_start }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Tgl. Selesai</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" value="{{ $data->date_end }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <form action="{{ url('upload-dokumen') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="formFile" class="form-label">Upload Sertifikat Magang</label>
                            <div class="input-group mb-3">
                                <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                    name="student_id">
                                <input class="form-control d-inline" type="hidden" value="Sertifikat Magang"
                                    name="type">
                                <input class="form-control d-inline" type="file" id="formFile" name="document_path">
                                <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <a name="#" class="btn btn-danger mt-4 text-decoration-none ms-auto"
                                href="{{ url('laporan') }}" role="button"><i class="far fa-file"></i> Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Daftar Matakuliah Konversi Magang </h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive table-bordered border-dark p-3">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Mata
                                    Kuliah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DPMK
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    SKS
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    nilai angka
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Nilai huruf
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mpk as $key => $data)
                                <tr>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $key + 1 }}
                                            </h6>
                                        </div>
                                    </td>
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
                                                {{ $data->name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm text-center">
                                                {{ $data->sks }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm text-center">
                                                {{ $data->nilai }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm text-center">
                                                {{ $customHelper->konversiNilai($data->nilai) }}
                                            </h6>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end of container -->
    <!-- end of header -->
@endsection
