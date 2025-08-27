@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>{{ __('messages.industrial_advisor_registration_info_title') }}</strong>
        <ul class="mt-2 list-disc list-inside">
            <li>{!! __('messages.industrial_advisor_registration_info_line1') !!}</li>
            <li>{!! __('messages.industrial_advisor_registration_info_line2') !!}</li>
        </ul>
    </div>

    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.industrial_advisor_manage_title', ['title' => $title]) }}</h4>
        </div>
        <div class="col">
            <a href="{{ url('manage-pembimbing-industri/create') }}" class="btn btn-primary float-end">
                {{ __('messages.industrial_advisor_add', ['title' => $title]) }}
            </a>
            @if ($jml > 0)
                <a href="{{ url('konfirmasi-pembimbing-industri') }}" class="btn btn-info float-end me-2 position-relative">
                    {{ __('messages.industrial_advisor_confirm_registration') }}
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $jml }}
                        <span class="visually-hidden">Jumlah</span>
                    </span>
                </a>
            @endif
            <form action="{{ url('setRegistrasi') }}" method="post">
                @csrf
                <button
                    class="btn {{ $registrasi->is_enable == true ? 'btn-danger bg-gradient-danger' : 'btn-warning bg-gradient-warning' }} float-end me-2"
                    data-toggle="tooltip" onclick="return confirm('Apakah anda yakin?')">
                    {{ __($registrasi->is_enable ? 'messages.industrial_advisor_disable' : 'messages.industrial_advisor_enable') }} {{ __('messages.industrial_advisor_registration_toggle', ['action' => '']) }}
                </button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ __('messages.industrial_advisor_data_title', ['title' => $title]) }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.industrial_advisor_table_full_name') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.industrial_advisor_table_email') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.industrial_advisor_table_phone') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.industrial_advisor_table_company') }}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">{{ __('messages.industrial_advisor_table_no_data') }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $data)
                                    <tr>
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
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->company->company_name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ url('manage-pembimbing-industri/' . $data->id . '/edit') }}"
                                                class="edit btn font-weight-bold text-xs" data-original-title="{{ __('messages.industrial_advisor_edit') }}"
                                                id="edit">
                                                {{ __('messages.industrial_advisor_edit') }}
                                            </a>
                                            <form action="{{ url('manage-pembimbing-industri/' . $data->id) }}"
                                                method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="{{ __('messages.industrial_advisor_delete') }}"
                                                    onclick="return confirm('{{ __('messages.industrial_advisor_delete_confirm') }}')">
                                                    {{ __('messages.industrial_advisor_delete') }}
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
