@extends('layout.admin')

@section('konten')
    <form action="{{ url('add-response') }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="response" class="form-label">{{ __('messages.response') }}</label>
                    <input type="hidden" name="id" value="{{ $logbook->id }}">
                    <textarea class="form-control" name="response" id="response" rows="3" placeholder="{{ __('messages.enter_response_placeholder') }}"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
    </form>
@endsection
