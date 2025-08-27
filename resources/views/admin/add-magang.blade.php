@extends('layout.admin')

@section('konten')
    <div class="row justify-content-between">
        <div class="col">
            <h4 class="mb-4">{{ $title }}</h4>
        </div>
    </div>

    <form action="{{ route('internship.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0 text-black">{{ __('messages.internship_supervisor') }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label text-black">{{ __('messages.internship_select_supervisor') }}</label>
                    <select class="form-select shadow-sm @error('lecturer_id') is-invalid @enderror"
                            name="lecturer_id"
                            id="lecturer_id"
                            required>
                        <option value="" selected disabled>{{ __('messages.select_option') }}</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->lecturer['id'] }}" {{ old('lecturer_id') == $item->lecturer['id'] ? 'selected' : '' }}>
                                {{ $item->lecturer['name'] }} ({{ $item->lecturer['lecturer_id_number'] ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('lecturer_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="text-black">{{ __('messages.internship_student_data') }}</h6>
                    <p class="text-sm text-secondary mb-0">{{ __('messages.select_students_for_internship') }}</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (count($mhs) == 0)
                        <div class="text-center p-4">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('messages.no_students_available') }}
                            </div>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
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
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('messages.internship_start_date') }}
                                        </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mhs as $data)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="form-check">
                                                    <input class="form-check-input student-checkbox"
                                                           type="checkbox"
                                                           name="student_id[]"
                                                           value="{{ $data->id }}"
                                                           id="student_{{ $data->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm text-black">
                                                        {{ $data->registration_number }}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm text-black">
                                                    {{ $data->name }}
                                                </h6>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0">{{ $data->class ?? 'N/A' }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $data->company->company_name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0">{{ $data->division ?? 'N/A' }}</p>
                                            </td>
                                            {{-- <td>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $data->date_start }}
                                                </p>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('messages.submit_button') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        // Fungsi untuk select/deselect semua checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    @endpush
@endsection
