@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-perusahaan') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="company_name" class="form-label">{{ __('messages.company_name') }} <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="company_name" id="company_name" placeholder="{{ __('messages.placeholder_company_name') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">{{ __('messages.company_phone') }} <span
                            class="text-red-500">*</span></label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="company_number" id="company_number"
                        placeholder="{{ __('messages.placeholder_company_phone') }}" required>
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">{{ __('messages.company_address') }} <span
                            class="text-red-500">*</span></label>
                    <textarea class="form-control shadow-sm focus:shadow-md" name="company_address" id="company_address" rows="3"
                        placeholder="{{ __('messages.placeholder_company_address') }}" required></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
    </form>
@endsection
