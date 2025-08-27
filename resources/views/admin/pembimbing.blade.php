@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.supervisor_manage_title', ['title' => $title]) }}</h4>
        </div>
        <div class="col">
            <a href="{{ url('manage-dpl/create') }}" class="btn btn-primary float-end">
                {{ __('messages.supervisor_add', ['title' => $title]) }}
            </a>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ __('messages.supervisor_data_title', ['title' => $title]) }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.supervisor_table_nip') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.supervisor_table_full_name') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.supervisor_table_email') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.supervisor_table_phone') }}
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">{{ __('messages.supervisor_table_no_data') }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $data)
                                    <tr>
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
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['email'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->lecturer['phone_number'] }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <form action="manage-dpl/{{ $data->id }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="{{ __('messages.supervisor_delete') }}"
                                                    onclick="return confirm('{{ __('messages.supervisor_delete_confirm') }}')">
                                                    {{ __('messages.supervisor_delete') }}
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
