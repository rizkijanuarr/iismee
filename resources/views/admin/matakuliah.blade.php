@extends('layout.admin')

@section('konten')
    @php($forceEnable = true)
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        {{ __('messages.information') }}! <br/>
        {!! __('messages.subject_info_after_add') !!}
    </div>
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.manage') }} {{ $title }}</h4>
        </div>
        <div class="col">
            <a href="{{ url('manage-matakuliah/create') }}" class="btn btn-primary float-end">
                {{ __('messages.add') }} {{ $title }}
            </a>
            {{-- <form action="{{ url('setPenilaian') }}" method="post">
                @csrf
                <button
                    class="btn {{ $forceEnable ? 'btn-danger bg-gradient-danger' : 'btn-warning bg-gradient-warning' }} float-end me-2"
                    data-toggle="tooltip" onclick="return confirm('{{ __('messages.confirm') }}')">
                    {{ $forceEnable ? __('messages.disable') : __('messages.enable') }} {{ __('messages.period_evaluation') }}
                    {{ $forceEnable ? 'Nonaktifkan' : 'Aktifkan' }} Periode Penilaian
                </button>
            </form> --}}
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>{{ __('messages.data') }} {{ $title }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.subject_name') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.sks') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.nip') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.lecturer_name') }}</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">{{ __('messages.no_data') }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $data)
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
                                                    {{ $data->sks }}
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
                                            <a href="manage-matakuliah/{{ $data->subject_name }}/edit"
                                                class="edit btn font-weight-bold text-xs" data-original-title="Edit user"
                                                id="edit">
                                                {{ __('messages.edit') }}
                                            </a>
                                            @if (!$forceEnable)
                                                <form action="manage-matakuliah/{{ $data->subject_name }}" method="post"
                                                    class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button
                                                        class="btn btn-danger bg-gradient-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Hapus"
                                                        onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                        {{ __('messages.delete') }}
                                                    </button>
                                                </form>
                                            @endif
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
