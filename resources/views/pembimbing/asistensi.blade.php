@extends('layout.admin')

@section('konten')
    <form action="{{ url('add-asistensi') }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="validation_status" class="form-label">{{ __('messages.assistance') }}</label>
                    <select class="form-select" aria-label="{{ __('messages.select_validation') }}" name="validation_status" id="validation_status">
                        <option selected>{{ __('messages.select_validation') }}</option>
                        <option value="Disetujui">{{ __('messages.approved') }}</option>
                        <option value="Ditolak">{{ __('messages.rejected') }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="information" class="form-label">{{ __('messages.response') }}</label>
                    <input type="hidden" name="id" value="{{ $laporan->id }}">
                    <textarea class="form-control" name="information" id="information" rows="3" placeholder="{{ __('messages.enter_response_placeholder') }}"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
    </form>
@endsection
