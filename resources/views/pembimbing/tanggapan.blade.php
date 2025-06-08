@extends('layout.admin')

@section('konten')
    <form action="{{ url('add-response') }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Tanggapan</label>
                    <input type="hidden" name="id" value="{{ $logbook->id }}">
                    <textarea class="form-control" name="response" id="response" rows="3"></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
