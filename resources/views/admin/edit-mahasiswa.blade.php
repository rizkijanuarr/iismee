@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-mahasiswa/' . $mahasiswa->name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="registration_number" class="form-label text-dark">{{ __('messages.student_table_nim') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="registration_number" id="registration_number"
                        value="{{ old('registration_number', $mahasiswa->registration_number) }}" placeholder="{{ __('messages.placeholder_registration_number') }}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label text-dark">{{ __('messages.student_table_full_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="name" id="name"
                        value="{{ old('name', $mahasiswa->name) }}" placeholder="{{ __('messages.placeholder_full_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-dark">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control shadow-sm focus:shadow-md" name="email" id="email"
                        value="{{ old('email', $mahasiswa->email) }}" placeholder="{{ __('messages.placeholder_email') }}">
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label text-dark">{{ __('messages.student_table_class') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="class" id="class"
                        value="{{ old('class', $mahasiswa->class) }}" placeholder="{{ __('messages.placeholder_class') }}">
                </div>
                <div class="mb-3">
                    <label for="date_start" class="form-label text-dark">{{ __('messages.student_table_date_start') }}</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3 shadow-sm focus:shadow-md" name="date_start" id="date_start"
                            aria-label="date_start" aria-describedby="basic-addon1"
                            value="{{ old('date_start', $mahasiswa->date_start) }}" placeholder="{{ __('messages.placeholder_date_start') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date_end" class="form-label text-dark">{{ __('messages.student_table_date_end') }}</label>
                    <div class="input-group date" id="datepicker">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3 shadow-sm focus:shadow-md" name="date_end" id="date_end" aria-label="date_end"
                            aria-describedby="basic-addon1" value="{{ old('date_end', $mahasiswa->date_end) }}"
                            placeholder="{{ __('messages.placeholder_date_end') }}">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="company_name" class="form-label text-dark">{{ __('messages.company_name') }}</label>
                    <select class="form-select shadow-sm focus:shadow-md" name="company_id" id="company_id" aria-label="Default select example">
                        <option selected>{{ __('messages.select_company') }}</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}"
                                {{ old('company_id', $mahasiswa->company_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->company_name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label text-dark">{{ __('messages.company_phone') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="company_number" id="company_number"
                        value="{{ old('company_number', $mahasiswa->company->company_number) }}" disabled
                        placeholder="{{ __('messages.placeholder_company_phone_auto') }}">
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label text-dark">{{ __('messages.company_address') }}</label>
                    <textarea class="form-control shadow-sm focus:shadow-md" name="company_address" id="company_address" rows="3" disabled
                        placeholder="{{ __('messages.placeholder_company_address_auto') }}">{{ old('company_address', $mahasiswa->company->company_address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="division" class="form-label text-dark">{{ __('messages.student_table_division') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="division" id="division"
                        value="{{ old('division', $mahasiswa->division) }}" placeholder="{{ __('messages.placeholder_division') }}">
                </div>
                <div class="mb-3">
                    <label for="internship_type" class="form-label text-dark">{{ __('messages.internship_type') }}</label>
                    <select class="form-select shadow-sm focus:shadow-md" name="internship_type" id="internship_type"
                        aria-label="Default select example">
                        <option selected>{{ __('messages.select_internship_type') }}</option>
                        <option value="MSIB"
                            {{ old('internship_type', $mahasiswa->internship_type) == 'MSIB' ? 'selected' : '' }}>MSIB
                        </option>
                        <option value="Reguler"
                            {{ old('internship_type', $mahasiswa->internship_type) == 'Reguler' ? 'selected' : '' }}>
                            Reguler
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
    </form>
@endsection

@push('script')
    <script>
        $('#company_id').change(function() {
            var company_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: './getDataPerusahaan',
                data: {
                    company_id: company_id
                },
                success: function(data) {
                    $('#company_number').val(data.company_number);
                    $('#company_address').val(data.company_address);
                }
            });
        });
    </script>
@endpush
