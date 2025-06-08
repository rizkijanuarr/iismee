@extends('layout.admin')

@section('konten')
    @if (session()->has('success'))
        <div class="alert alert-success fw-bold alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Data Dosen</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Lengkap
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Telepon
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $data->lecturer_id_number }}
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
                                                {{ $data->email }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ $data->phone_number }}
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ url('manage-dpl') }}" method="post" class="d-inline">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="visually-hidden" for="inputName">Hidden input label</label>
                                                <input type="hidden" class="form-control" name="lecturer_id"
                                                    id="lecturer_id" placeholder="" value="{{ $data->id }}"
                                                    style="display: none !important">
                                            </div>
                                            <div class="mb-3">
                                                <label class="visually-hidden" for="inputName">Hidden input label</label>
                                                <input type="hidden" class="form-control" name="email" id="email"
                                                    placeholder="" value="{{ $data->email }}"
                                                    style="display: none !important">
                                            </div>
                                            <button class="btn btn-primary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Tambah" onclick="return confirm('Apakah anda yakin?')">
                                                Tambahkan
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
    </div>
@endsection
