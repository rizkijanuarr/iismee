@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
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
                <hr>
                <div class="my-3">
                    <a name="" id="" class="btn btn-success text-decoration-none"
                        href="{{ url('logbook/create') }}" role="button"><i class="fas fa-plus"></i> Tambah</a>
                    <a name="" id="" class="btn btn-info text-decoration-none"
                        href="{{ url('print-logbook') }}" target="_blank" role="button"><i
                            class="fas fa-file-pdf"></i> Cetak Logbook</a>
                    @if ($suratMagang != null)
                        <a name="" id="" class="btn btn-primary text-decoration-none" target="_blank"
                            href="{{ '/storage/' . $suratMagang->document_path }}" role="button">Lihat Surat
                            Persetujuan</a>
                    @endif
                    @if ($cekAbsensiDatang == true)
                        <a name="" id="" class="btn btn-warning text-decoration-none"
                            href="{{ url('absensi') }}" role="button"><i class="fas fa-clipboard-check"></i>
                            Absensi</a>
                    @endif
                </div>
                <form action="{{ url('upload-dokumen') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                            name="student_id">
                        <input class="form-control d-inline" type="hidden" value="Surat Persetujuan Magang"
                            name="type">
                        <label class="input-group-text" for="inputGroupFile01">Surat Persetujuan Magang</label>
                        <input class="form-control d-inline" type="file" id="formFile" name="document_path">
                        <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Kegiatan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive table-bordered border-dark p-3">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Kegiatan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bukti
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Masukan
                                    Pembimbing
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logbook as $key => $data)
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
                                                {{ $data->activity_name }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $data->activity_date }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                <img src="{{ URL::asset('storage/' . $data->img) }}" alt=""
                                                    style="height: 100px">
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{-- <div style="height: 50%">
                                                    <img src="{{ URL::asset('storage/' . $data->image) }}"
                                                        alt="">
                                                </div> --}}
                                                -
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <a href="logbook/{{ $data->id }}/edit"
                                            class="btn btn-warning font-weight-bold text-xs"
                                            data-original-title="Edit user" id="edit">
                                            Edit
                                        </a>
                                        <form action="logbook/{{ $data->id }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Hapus"
                                                onclick="return confirm('Apakah anda yakin?')">
                                                Hapus
                                            </button>
                                        </form>
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
