@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-matakuliah/' . $matakuliah->subject_name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" name="subject_name" id="subject_name"
                        value="{{ old('subject_name', $matakuliah->subject_name) }}" placeholder="Mekanika Teknik">
                </div>
                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" class="form-control" name="sks" id="sks"
                        value="{{ old('sks', $matakuliah->sks) }}" placeholder="3">
                </div>
                <div class="mb-3">
                    <label for="max_score" class="form-label">Skor Maksimal Per Aspek</label>
                    <input type="number" class="form-control" name="max_score" id="max_score"
                        value="{{ old('max_score', $matakuliah->max_score) }}" placeholder="100">
                </div>
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">Dosen Pengajar</label>
                    <select class="form-select" name="lecturer_id" id="lecturer_id" aria-label="Default select example">
                        <option selected>Pilih Dosen Pengajar</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}"
                                {{ old('lecturer_id', $item->id) == $matakuliah->lecturer_id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
