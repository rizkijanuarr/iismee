@extends('layout.admin')

@section('konten')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('manage-pembimbing-industri/' . $pembimbingIndustri->id) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', $pembimbingIndustri->name) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $pembimbingIndustri->email) }}" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="position" id="position"
                        value="{{ old('position', $pembimbingIndustri->position) }}">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', $pembimbingIndustri->phone_number) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Nama Perusahaan</label>
                    <select class="form-select" name="company_id" id="company_id" aria-label="Default select example">
                        <option selected>Pilih Perusahaan</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}"
                                {{ old('company_id', $pembimbingIndustri->company_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->company_name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">No. Telepon Perusahaan</label>
                    <input type="number" class="form-control" name="company_number" id="company_number"
                        value="{{ old('company_number', $pembimbingIndustri->company->company_number) }}" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">Alamat Perusahaan</label>
                    <textarea class="form-control" name="company_address" id="company_address" rows="3" readonly disabled>{{ old('company_address', $pembimbingIndustri->company->company_address) }}</textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')
    <script>
        $('#company_id').change(function() {
            var company_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: './getDataPerusahaan',
                data: {
                    company_id: company_id
                },
                success: function(data) {
                    $('#company_number').val(data.company_number);
                    $('#company_address').val(data.company_address);
                }
            });
        });
    </script>
@endpush
