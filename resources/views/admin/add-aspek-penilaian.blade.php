@extends('layout.admin')

@section('konten')
    <form action="{{ url('aspek-penilaian') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="subject_id" class="form-label">{{ __('messages.subject') }}</label>
                    <select class="form-select shadow-sm focus:shadow-md" name="subject_id" id="subject_id" required>
                        <option value="" selected disabled>{{ __('messages.select_subject') }}</option>
                        @foreach ($matakuliah as $item)
                            <option value="{{ $item->id }}">{{ $item->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.assessment_aspect_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="name" id="name"
                        placeholder="{{ __('messages.assessment_aspect_name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('messages.assessment_aspect_description') }}</label>
                    <input id="description" type="hidden" name="description" required>
                    <trix-editor input="description" class="shadow-sm focus:shadow-md"
                        placeholder="{{ __('messages.assessment_aspect_description_placeholder') }}"></trix-editor>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
    </form>
@endsection
