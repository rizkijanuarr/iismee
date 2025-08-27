@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-pembimbing-industri') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="name" id="name" placeholder="{{ __('messages.placeholder_full_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control shadow-sm focus:shadow-md" name="email" id="email"
                        placeholder="{{ __('messages.placeholder_email') }}">
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">{{ __('messages.position') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="position" id="position" placeholder="{{ __('messages.position') }}">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">{{ __('messages.phone_number') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="phone_number" id="phone_number"
                        placeholder="{{ __('messages.phone_number') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="company_id" class="form-label">{{ __('messages.company_name') }}</label>
                    <select class="form-select shadow-sm focus:shadow-md" name="company_id" id="company_id" aria-label="{{ __('messages.select_company') }}">
                        <option selected>{{ __('messages.select_company') }}</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">{{ __('messages.company_phone') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="company_number" id="company_number" disabled
                        placeholder="{{ __('messages.placeholder_company_phone_auto') }}">
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">{{ __('messages.company_address') }}</label>
                    <textarea class="form-control shadow-sm focus:shadow-md" name="company_address" id="company_address" rows="3" disabled
                        placeholder="{{ __('messages.placeholder_company_address_auto') }}"></textarea>
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
            var url = "{{ url('getDataPerusahaan') }}";

            $.ajax({
                type: 'GET',
                url: url,
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
