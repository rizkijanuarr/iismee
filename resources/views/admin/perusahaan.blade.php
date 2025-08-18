@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">Manage {{ $title }}</h4>
        </div>
        <div class="col">
            <a href="{{ route('manage-perusahaan.template') }}" class="btn btn-warning btn-sm bg-gradient-warning float-end ms-2">
                Download Template
            </a>
            <form action="{{ route('manage-perusahaan.import') }}" method="POST" enctype="multipart/form-data" class="d-inline float-end ms-2">
                @csrf
                <div class="d-flex align-items-center">
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control form-control-sm shadow-sm me-2" required>
                    <button type="submit" class="btn btn-success btn-sm bg-gradient-success">Import Excel</button>
                </div>
            </form>
            <a href="{{ url('manage-perusahaan/create') }}" class="btn btn-primary float-end">
                Tambahkan {{ $title }}
            </a>
        </div>
    </div>
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success bg-gradient-success text-white" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger bg-gradient-danger text-white" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Data {{ $title }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Perusahaan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Telepon
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="4" class="text-center">
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
                                                    {{ $data->company_name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->company_number }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->company_address }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="manage-perusahaan/{{ $data->id }}/edit"
                                                class="edit btn font-weight-bold text-xs" data-original-title="Edit user"
                                                id="edit">
                                                Edit
                                            </a>
                                            <form action="manage-perusahaan/{{ $data->id }}" method="post"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Hapus"
                                                    onclick="return confirm('Apakah anda yakin?')">
                                                    Hapus
                                                </button>
                                            </form>
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
