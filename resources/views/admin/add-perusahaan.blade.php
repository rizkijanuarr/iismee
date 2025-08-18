@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-perusahaan') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Nama Perusahaan <span class="text-red-500">*</span></label>
                    <input type="text" class="form-control" name="company_name" id="company_name" placeholder="PT. Akedemik Digital"
                        required>
                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">No. Telepon Perusahaan <span
                            class="text-red-500">*</span></label>
                    <input type="number" class="form-control" name="company_number" id="company_number"
                        placeholder="08123456789" required>
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">Alamat Perusahaan <span
                            class="text-red-500">*</span></label>
                    <textarea class="form-control" name="company_address" id="company_address" rows="3"
                        placeholder="Jl. Ketintang No.10" required></textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
