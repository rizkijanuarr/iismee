@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-perusahaan/' . $perusahaan->id) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="company_name" class="form-label">{{ __("messages.company_name") }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="company_name" id="company_name" value="{{ old('company_name', $perusahaan->company_name) }}" placeholder="{{ __("messages.placeholder_company_name") }}">
                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">{{ __("messages.company_phone") }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="company_number" id="company_number" value="{{ old('company_number', $perusahaan->company_number) }}" placeholder="{{ __("messages.placeholder_company_phone") }}">
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">{{ __("messages.company_address") }}</label>
                    <textarea class="form-control shadow-sm focus:shadow-md" name="company_address" id="company_address" rows="3" placeholder="{{ __("messages.placeholder_company_address") }}">{{ old('company_address', $perusahaan->company_address) }}</textarea>
                </div>
            </div>
        </div>
    <button type="submit" class="btn btn-primary">{{ __("messages.submit_button") }}</button>
    </form>
@endsection
