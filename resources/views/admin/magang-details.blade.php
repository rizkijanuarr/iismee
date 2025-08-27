@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ $title }}</h4>
        </div>
        {{-- <div class="col">
            <a href="{{ route('internship.index') }}" class="btn btn-secondary float-end">
                <i class="fas fa-arrow-left me-2"></i>{{ __('messages.back') }}
            </a>
        </div> --}}
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0 text-black">{{ __('messages.internship_supervisor_data') }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-black">{{ __('messages.lecturer_id_number') }}</label>
                        <p class="mb-0">{{ $magang->lecturer['lecturer_id_number'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-black">{{ __('messages.full_name') }}</label>
                        <p class="mb-0">{{ $magang->lecturer['name'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-black">{{ __('messages.email') }}</label>
                        <p class="mb-0">{{ $magang->lecturer['email'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-black">{{ __('messages.phone_number') }}</label>
                        <p class="mb-0">{{ $magang->lecturer['phone_number'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="text-black">{{ __('messages.internship_student_data') }}</h6>
                <p class="text-sm text-secondary mb-0">{{ __('messages.students_under_supervision') }}</p>
            </div>
            <div class="card-body px-0 pt-0 pb-2
                @if (count($data) == 0)
                    <div class="text-center p-4">
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('messages.no_students_found') }}
                        </div>
                    </div>
                @else
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('messages.student_id') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.full_name') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.class') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.company') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.division') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.address') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.internship_start_date') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.internship_end_date') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('messages.internship_type') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm text-black">
                                                    {{ $item->student['registration_number'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm text-black">
                                                    {{ $item->student['name'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student['class'] ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student->company['name'] ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student['division'] ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student->company['address'] ?? 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student['internship_start_date'] ? \Carbon\Carbon::parse($item->student['internship_start_date'])->format('d M Y') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student['internship_end_date'] ? \Carbon\Carbon::parse($item->student['internship_end_date'])->format('d M Y') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $item->student['internship_type'] ?? 'N/A' }}
                                            </p>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable if needed
            if (document.getElementById('datatable')) {
                new simpleDatatables.DataTable('#datatable', {
                    searchable: true,
                    fixedHeight: true,
                    perPage: 10,
                    perPageSelect: [10, 25, 50, 100]
                });
            }
        });
    </script>
    @endpush
@endsection
