@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
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
        <div class="card my-3">
            <div class="card-header">
                {{ $title }}
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
                                    aria-describedby="basic-addon3 basic-addon4"
                                    value="{{ $data->date_start }} s/d {{ $data->date_end }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Pembimbing</span>
                                <input type="text" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4"
                                    value="{{ $data->internship->lecturer->name }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Kegiatan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-4">
                    <h5 class="mb-3">Absensi {{ $now }}</h5>
                    @if ($is_absen_datang == true)
                        <h6 class="mb-3">Silahkan Mengisi Absensi Pulang !</h6>
                        <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                    name="student_id">
                                <label class="input-group-text" for="inputGroupFile01">Bukti Absensi Pulang</label>
                                <input class="form-control d-inline" type="file" id="formFile" name="out_proof">
                                <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                            </div>
                        </form>
                    @else
                        <h6 class="mb-3">Sebelum Mengisi Logbook Silahkan Absen Terlebih Dahulu !</h6>
                        <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                    name="student_id">
                                <label class="input-group-text" for="inputGroupFile01">Bukti Absensi Datang</label>
                                <input class="form-control d-inline" type="file" id="formFile" name="entry_proof">
                                <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div> <!-- end of container -->
    <!-- end of header -->
@endsection
