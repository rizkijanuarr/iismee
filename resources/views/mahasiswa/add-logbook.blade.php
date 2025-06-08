@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
        <a name="" id="" class="btn btn-danger text-decoration-none" href="{{ url('logbook') }}"
            role="button"><i class="fas fa-arrow-left"></i>
            Kembali</a>
        <div class="card bg-success text-light my-4">
            <div class="card-body fw-bold">
                Tambahkan {{ $title }}
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('logbook') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="activity_name" class="form-label">Nama Kegiatan</label>
                <input type="text" class="form-control" name="activity_name" id="activity_name"
                    value="{{ old('activity_name') }}" placeholder="Nama Kegiatan">
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Foto Kegiatan</label>
                <input type="file" class="form-control" name="img" id="img" placeholder="Foto Kegiatan">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Kegiatan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div> <!-- end of container -->
    <!-- end of header -->
@endsection
