@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-matakuliah') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" name="subject_name" id="subject_name">
                </div>
                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" class="form-control" name="sks" id="sks">
                </div>
                <div class="mb-3">
                    <label for="max_score" class="form-label">Skor Maksimal Per Aspek</label>
                    <input type="number" class="form-control" name="max_score" id="max_score">
                </div>
                <div class="mb-3">
                    <label for="lecturer_id" class="form-label">Dosen Pengajar</label>
                    <select class="form-select" name="lecturer_id" id="lecturer_id" aria-label="Default select example">
                        <option selected>Pilih Dosen Pengajar</option>
                        @foreach ($dosen as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
