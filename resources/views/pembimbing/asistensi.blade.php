@extends('layout.admin')

@section('konten')
    <form action="{{ url('add-asistensi') }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Asistensi</label>
                    <select class="form-select" aria-label="Default select example" name="validation_status">
                        <option selected>Pilih Validasi</option>
                        <option value="Disetujui">Setuju</option>
                        <option value="Ditolak">Tolak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tanggapan</label>
                    <input type="hidden" name="id" value="{{ $laporan->id }}">
                    <textarea class="form-control" name="information" id="information" rows="3"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
