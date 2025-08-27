@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        {{ __('messages.dosen_info') }}
    </div>
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.lecturer_manage_title', ['title' => $title]) }}</h4>
        </div>
        <div class="col">
            <a href="{{ route('manage-dosen.template') }}" class="btn btn-warning btn-sm bg-gradient-warning float-end ms-2">
                {{ __('messages.lecturer_download_template') }}
            </a>
            <form action="{{ route('manage-dosen.import') }}" method="POST" enctype="multipart/form-data" class="d-inline float-end ms-2">
                @csrf
                <div class="d-flex align-items-center">
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="form-control form-control-sm shadow-sm focus:shadow-md me-2" required>
                    <button type="submit" class="btn btn-success btn-sm bg-gradient-success">{{ __('messages.lecturer_import_excel') }}</button>
                </div>
            </form>
            <a href="{{ url('manage-dosen/create') }}" class="btn btn-primary float-end">
                {{ __('messages.lecturer_add', ['title' => $title]) }}
            </a>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ __('messages.lecturer_data_title', ['title' => $title]) }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_table_nip') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_table_full_name') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_table_email') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_table_phone') }}
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">{{ __('messages.lecturer_table_no_data') }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
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
                                            <a href="manage-dosen/{{ $data->name }}/edit"
                                                class="edit btn font-weight-bold text-xs" data-original-title="Edit user"
                                                id="edit">
                                                {{ __('messages.lecturer_edit') }}
                                            </a>
                                            <form action="manage-dosen/{{ $data->name }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="{{ __('messages.lecturer_delete') }}"
                                                    onclick="return confirm('{{ __('messages.lecturer_delete_confirm') }}')">
                                                    {{ __('messages.lecturer_delete') }}
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
