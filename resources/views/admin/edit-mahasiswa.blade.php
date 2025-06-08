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
    <form action="{{ url('manage-mahasiswa/' . $mahasiswa->name) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="registration_number" class="form-label">NIM</label>
                    <input type="number" class="form-control" name="registration_number" id="registration_number"
                        value="{{ old('registation_number', $mahasiswa->registration_number) }}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', $mahasiswa->name) }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $mahasiswa->email) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Kelas</label>
                    <input type="text" class="form-control" name="class" id="class"
                        value="{{ old('class', $mahasiswa->class) }}">
                </div>
                <div class="mb-3">
                    <label for="date_start" class="form-label">Tanggal Mulai</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3" name="date_start" id="date_start"
                            aria-label="date_start" aria-describedby="basic-addon1"
                            value="{{ old('date_start', $mahasiswa->date_start) }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date_end" class="form-label">Tanggal Selesai</label>
                    <div class="input-group date" id="datepicker">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3" name="date_end" id="date_end" aria-label="date_end"
                            aria-describedby="basic-addon1" value="{{ old('date_end', $mahasiswa->date_end) }}">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="company_name" class="form-label">Nama Perusahaan</label>
                    <select class="form-select" name="company_id" id="company_id" aria-label="Default select example">
                        <option selected>Pilih Perusahaan</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}"
                                {{ old('company_id', $mahasiswa->company_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->company_name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">No. Telepon Perusahaan</label>
                    <input type="number" class="form-control" name="company_number" id="company_number"
                        value="{{ old('company_number', $mahasiswa->company->company_number) }}" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">Alamat Perusahaan</label>
                    <textarea class="form-control" name="company_address" id="company_address" rows="3" readonly disabled>{{ old('company_address', $mahasiswa->company->company_address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="division" class="form-label">Divisi</label>
                    <input type="text" class="form-control" name="division" id="division"
                        value="{{ old('division', $mahasiswa->division) }}">
                </div>
                <div class="mb-3">
                    <label for="internship_type" class="form-label">Kategori Magang</label>
                    <select class="form-select" name="internship_type" id="internship_type"
                        aria-label="Default select example">
                        <option selected>Pilih Kategori Magang</option>
                        <option value="MSIB"
                            {{ old('internship_type', $mahasiswa->internship_type) == 'MSIB' ? 'selected' : '' }}>MSIB
                        </option>
                        <option value="Reguler"
                            {{ old('internship_type', $mahasiswa->internship_type) == 'Reguler' ? 'selected' : '' }}>
                            Reguler
                        </option>
                    </select>
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
