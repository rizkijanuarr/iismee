@extends('layout.admin')


@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">Manage {{ $title }}</h4>
        </div>
        @if ($penilaian->is_enable == false)
            <div class="col">
                <a href="{{ url('aspek-penilaian/create') }}" class="btn btn-primary float-end">
                    Tambahkan {{ $title }}
                </a>
            </div>
        @endif
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success fw-bold alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close text-light" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Dosen
                                    Pengajar</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matakuliah as $data)
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
                                        <button class="btn btn-primary btn-detail" data-target="#{{ $data->id }}">Lihat
                                            Detail</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div id="{{ $data->id }}" class="detail">
                                            <table class="table align-items-center mb-0 table-sm" id="datatable">
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
                                                    @foreach ($data->assesmentAspect as $aspek)
                                                        <tr>
                                                            <td style="white-space: normal !important">
                                                                <div class="my-auto">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {{ $aspek->name }}
                                                                    </h6>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: normal !important">
                                                                <div class="my-auto">
                                                                    <h6 class="mb-0 text-sm">
                                                                        {!! $aspek->description !!}
                                                                    </h6>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                <a href="{{ url('/aspek-penilaian/' . $aspek->id . '/edit') }}"
                                                                    class="edit btn font-weight-bold text-xs"
                                                                    data-original-title="Edit user" id="edit">
                                                                    Edit
                                                                </a>
                                                                @if ($penilaian->is_enable == false)
                                                                    <form
                                                                        action="{{ url('aspek-penilaian/') . $aspek->id }}"
                                                                        method="post" class="d-inline">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button
                                                                            class="btn btn-danger font-weight-bold text-xs"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Hapus"
                                                                            onclick="return confirm('Apakah anda yakin?')">
                                                                            Hapus
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
