@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        {{ __('messages.lecturer_password_notice', ['password' => '1234']) }}
    </div>
    <form action="{{ url('manage-dosen') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="lecturer_id_number" class="form-label">{{ __('messages.lecturer_table_nip') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="lecturer_id_number" id="lecturer_id_number"
                        placeholder="{{ __('messages.placeholder_lecturer_id_number') }}" value="{{ old('lecturer_id_number') }}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="name" id="name" placeholder="{{ __('messages.placeholder_full_name') }}" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control shadow-sm focus:shadow-md" name="email" id="email"
                        placeholder="{{ __('messages.placeholder_email') }}" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">{{ __('messages.lecturer_table_phone') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="phone_number" id="phone_number"
                        placeholder="{{ __('messages.placeholder_phone') }}" value="{{ old('phone_number') }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
    </form>
@endsection
