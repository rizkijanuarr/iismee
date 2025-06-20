@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-dosen/' . $dosen->name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="lecturer_id_number" class="form-label">NIP</label>
                    <input type="number" class="form-control" name="lecturer_id_number" id="lecturer_id_number"
                        value="{{ old('lecturer_id_number', $dosen->lecturer_id_number) }}" placeholder="2005197">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', $dosen->name) }}" placeholder="Budi Utomo">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $dosen->email) }}" placeholder="budiutomo@gmailcom">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', $dosen->phone_number) }}" placeholder="08123456789">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
