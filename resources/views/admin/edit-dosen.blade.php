@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-dosen/' . $dosen->name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="lecturer_id_number" class="form-label">{{ __('messages.lecturer_table_nip') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="lecturer_id_number" id="lecturer_id_number"
                        value="{{ old('lecturer_id_number', $dosen->lecturer_id_number) }}" placeholder="{{ __('messages.placeholder_lecturer_id_number') }}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="name" id="name"
                        value="{{ old('name', $dosen->name) }}" placeholder="{{ __('messages.placeholder_full_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control shadow-sm focus:shadow-md" name="email" id="email"
                        value="{{ old('email', $dosen->email) }}" placeholder="{{ __('messages.placeholder_email') }}">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">{{ __('messages.lecturer_table_phone') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', $dosen->phone_number) }}" placeholder="{{ __('messages.placeholder_phone') }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
    </form>
@endsection
