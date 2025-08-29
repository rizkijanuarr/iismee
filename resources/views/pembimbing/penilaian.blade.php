@php
    use Carbon\Carbon;
@endphp

@extends('layout.admin')

@section('konten')
    <div class="row mb-4 justify-content-between" style="overflow: hidden">
        <div class="col-6">
            <h4>@lang('messages.assessment_student_list')</h4>
            <a class="btn btn-primary ms-auto" target="_blank" href="{{ url('cetak-penilaian/') }}">
                @lang('messages.print_assessment')
            </a>
        </div>
    </div>
    <div class="row">
        @foreach ($mahasiswa as $item)
            <div class="col-md-4">
                <div class="card mb-3" style="width: rem;">
                    <div class="card-body">
                        @php
                            if (Carbon::now()->greaterThan(Carbon::parse($item->student->date_start)) && Carbon::now()->lessThan(Carbon::parse($item->student->date_end))) {
                                $periodeMagang = __('messages.internship_ongoing');
                                $warna = 'success';
                            } elseif (Carbon::now()->greaterThan(Carbon::parse($item->student->date_end))) {
                                $periodeMagang = __('messages.internship_ended');
                                $warna = 'danger';
                            } else {
                                $periodeMagang = __('messages.internship_not_started');
                                $warna = 'warning';
                            }
                        @endphp
                        <span class="badge text-bg-{{ $warna }} mb-3">
                            {{ $periodeMagang }}
                        </span>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                @if ($item->student->img_path != null)
                                    <img src="{{ URL::asset('storage/' . $item->student->img_path) }}" alt=""
                                        class="rounded-circle img-fluid"
                                        style="height: 80px; width: 80px; object-fit: cover" id="btn"
                                        style="cursor: pointer;">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                        fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title ellipsis">{{ $item->student->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">
                                    {{ $item->student->registration_number }} </h6>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <b>@lang('messages.institution_name') : </b> {{ $item->company_name }}
                            </li>
                            <li>
                                <b>@lang('messages.division') : </b> {{ $item->student->division }}
                            </li>
                            <li>
                                <b>@lang('messages.internship_type') : </b> {{ $item->student->internship_type }}
                            </li>
                            <li>
                                <b>@lang('messages.conversion_type') : </b> @lang('messages.general_subject_conversion')
                            </li>
                            <li>
                                <b>@lang('messages.execution_date') : </b> {{ $item->student->date_start }} @lang('messages.to') {{ $item->student->date_end }}
                            </li>
                        </ul>
                        <div class="d-flex align-items-center">
                            @if ($penilaian->is_enable == true)
                                @if ($item->is_assessment == true)
                                    <a href="penilaian/{{ $item->student->registration_number }}/edit"
                                        class="btn btn-warning btn-sm card-link fw-bold text-dark"
                                        style="margin-bottom: 0!important">@lang('messages.edit_score')</a>
                                @else
                                    <a href="penilaian/{{ $item->student->registration_number }}"
                                        class="btn btn-primary btn-sm card-link fw-bold"
                                        style="margin-bottom: 0!important">@lang('messages.score')</a>
                                @endif
                            @endif
                            <a href="penilaian/{{ $item->student->registration_number }}/show"
                                class="btn btn-light btn-sm card-link fw-bold" style="margin-bottom: 0!important">@lang('messages.view')</a>
                            <div class="dropdown ms-auto">
                                <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('logbook-show/' . $item->student->registration_number) }}">
                                            @lang('messages.view_logbook')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('laporan-show/' . $item->student->registration_number) }}">
                                            @lang('messages.view_report')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" target="_blank" href="{{ url('cetak-absensi/' . $item->student->registration_number) }}">
                                            @lang('messages.print_attendance')
                                        </a>
                                    </li>
                                    @if ($item->document_path)
                                        <li>
                                            <a class="dropdown-item" href="{{ url('storage/' . $item->document_path) }}" target="_blank">
                                                @lang('messages.view_response_letter')
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
