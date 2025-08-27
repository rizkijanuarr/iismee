@extends('layout.admin')

@section('konten')
<div class="alert alert-danger bg-gradient-danger mt-3 text-white">
    <i class="bi bi-info-circle-fill me-2"></i>
    {!! __('messages.assessment_aspect_min_required') !!}
</div>
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ __('messages.manage') }} {{ $title }}</h4>
        </div>
        @if (isset($penilaian) && $penilaian->is_enable == true)
            <div class="col">
                <a href="{{ url('aspek-penilaian/create') }}" class="btn btn-primary float-end">
                    {{ __('messages.add') }} {{ $title }}
                </a>
            </div>
        @endif
    </div>

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="text-black">{{ __('messages.data') }} {{ $title }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('messages.subject') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('messages.nip') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('messages.lecturer_name') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($matakuliah) === 0)
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-danger bg-gradient-danger" role="alert">
                                            <h6 class="mb-0 text-white">{{ __('messages.no_data') }}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($matakuliah as $mk)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm text-black">{{ $mk->subject_name }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $mk->lecturer->nip ?? __('messages.not_available') }}</p>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $mk->lecturer['name'] ?? '-' }}</h6>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-primary btn-detail"
                                                data-target="#detail-{{ $mk->id }}">
                                                {{ __('messages.view_details') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div id="detail-{{ $mk->id }}" class="detail">
                                                <table class="table align-items-center mb-0 table-sm"
                                                    id="datatable-{{ $mk->id }}">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                {{ __('messages.assessment_aspect') }}</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                {{ __('messages.assessment_aspect_description') }}</th>
                                                            <th class="text-secondary opacity-7"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($mk->assesmentAspect) === 0)
                                                            <tr>
                                                                <td colspan="3" class="text-center">
                                                                    <div class="alert alert-danger bg-gradient-danger"
                                                                        role="alert">
                                                                        <h6 class="mb-0 text-white">{{ __('messages.no_data') }}</h6>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($mk->assesmentAspect as $aspek)
                                                                <tr>
                                                                    <td style="white-space: normal !important">
                                                                        <h6 class="mb-0 text-sm text-black">{{ $aspek->name }}</h6>
                                                                    </td>
                                                                    <td style="white-space: normal !important">
                                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit(strip_tags($aspek->description), 100) ?: __('messages.no_description') }}</p>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <div class="d-flex gap-1">
                                                                            <a href="{{ url('aspek-penilaian/' . $aspek->id . '/edit') }}" 
                                                                               class="btn btn-link text-warning text-gradient px-3 mb-0">
                                                                                <i class="fas fa-pencil-alt me-2" aria-hidden="true"></i>{{ __('messages.edit') }}
                                                                            </a>
                                                                            <form action="{{ url('aspek-penilaian', $aspek->id) }}" 
                                                                                  method="POST" 
                                                                                  class="d-inline"
                                                                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                                                    <i class="far fa-trash-alt me-2" aria-hidden="true"></i>{{ __('messages.delete') }}
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
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
