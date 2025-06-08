@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
        <div class="text-center">
            <div class="mb-3">
                @if ($data->img_path != null)
                    <img src="{{ URL::asset('storage/' . $data->img_path) }}" alt="" class="rounded-circle img-fluid"
                        style="height: 250px; width: 250px; object-fit: cover" id="btn" style="cursor: pointer;">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" id="btn"
                        style="cursor: pointer;" class="bi bi-person-square" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path
                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                    </svg>
                @endif
            </div>
            <small class="form-text text-muted" id="text-help">Tekan untuk mengganti foto profil.</small>
        </div>
        <div class="my-4">
            <form action="{{ url('gantiFoto') }}" id="form" style="display: none" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Pilih Foto Profil Baru</label>
                    <input type="file" class="form-control" id="exampleFormControlInput1" name="img_path">
                    <input type="hidden" class="form-control" name="oldimg" id="oldimg" value="{{ $data->img_path }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary ">Ganti Foto Profil</button>
                </div>
            </form>
        </div>
        <div class="text-center">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">NIM</span>
                <input type="text" class="form-control" disabled aria-describedby="basic-addon1"
                    value="{{ $data->registration_number }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Nama Lengkap</span>
                <input type="text" class="form-control" disabled aria-describedby="basic-addon1"
                    value="{{ $data->name }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="text" class="form-control" disabled aria-describedby="basic-addon1"
                    value="{{ $data->email }}">
            </div>
        </div>
    </div> <!-- end of container -->
    <!-- end of header -->
@endsection

@push('script')
    <script>
        var tombol = document.getElementById("btn");
        var form = document.getElementById("form");
        var txtHelp = document.getElementById("text-help");

        tombol.addEventListener("click", function() {
            if (form.style.display == "none") {
                form.style.display = "block"
                txtHelp.style.display = "none"
            } else {
                txtHelp.style.display = "block"
                form.style.display = "none"
            }
        });
    </script>
@endpush
