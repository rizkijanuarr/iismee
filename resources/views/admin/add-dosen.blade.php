@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Password Dosen</strong> secara sistem generate <strong>1234</strong>
    </div>
    <form action="{{ url('manage-dosen') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="lecturer_id_number" class="form-label">NIP</label>
                    <input type="number" class="form-control" name="lecturer_id_number" id="lecturer_id_number"
                        placeholder="20051397012">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Rizal">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="rizal@gmail.com">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number"
                        placeholder="08123456789">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
