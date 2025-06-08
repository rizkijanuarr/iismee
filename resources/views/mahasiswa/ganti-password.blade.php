@extends('layout.user')

@section('konten')
    <div class="container mb-4" style="margin-top: 100px">
        <div class="my-4">
            <form action="{{ url('gantiPassword') }}" id="form" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                        value="{{ auth()->user()->name }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="email"
                        value="{{ auth()->user()->email }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" name="password"
                        placeholder="Masukkan Password Baru">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary ">Ganti Password</button>
                </div>
            </form>
        </div>
    </div> <!-- end of container -->
    <!-- end of header -->
@endsection
