@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-matakuliah/' . $matakuliah->subject_name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="subject_name" class="form-label">{{ __('messages.subject_name') }}</label>
                    <input type="text" class="form-control shadow-sm focus:shadow-md" name="subject_name" id="subject_name"
                        value="{{ old('subject_name', $matakuliah->subject_name) }}"
                        placeholder="{{ __('messages.subject_name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="sks" class="form-label">{{ __('messages.sks') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="sks" id="sks"
                        value="{{ old('sks', $matakuliah->sks) }}"
                        placeholder="{{ __('messages.sks') }}" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="max_score" class="form-label">{{ __('messages.max_score') }}</label>
                    <input type="number" class="form-control shadow-sm focus:shadow-md" name="max_score" id="max_score"
                        value="{{ old('max_score', $matakuliah->max_score) }}"
                        placeholder="{{ __('messages.max_score') }}" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">{{ __('messages.lecturer_name') }}</label>
                    <select class="form-select shadow-sm focus:shadow-md" name="lecturer_id" id="lecturer_id" required>
                        <option value="">{{ __('messages.select_lecturer') }}</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}"
                                {{ old('lecturer_id', $matakuliah->lecturer_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.submit_button') }}</button>
            </div>
        </div>
    </form>
@endsection
