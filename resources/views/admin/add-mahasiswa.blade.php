@extends('layout.admin')

@section('konten')
    <div class="alert alert-danger bg-gradient-danger mt-3 text-white">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Password Mahasiswa</strong> secara sistem generate <strong>1234</strong>
    </div>
    <form action="{{ url('manage-mahasiswa') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="registration_number" class="form-label">NIM</label>
                    <input type="number" class="form-control" name="registration_number" id="registration_number"
                        placeholder="2099123">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Budi Utomo">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="budiutomo@gmailcom">
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Kelas</label>
                    <input type="text" class="form-control" name="class" id="class"
                        placeholder="2020A Teknik Mesin">
                </div>
                <div class="mb-3">
                    <label for="date_start" class="form-label">Tanggal Mulai</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3" name="date_start" id="date_start"
                            aria-label="date_start" aria-describedby="basic-addon1" placeholder="2022-01-01">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date_end" class="form-label">Tanggal Selesai</label>
                    <div class="input-group date" id="datepicker">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar2-date-fill"></i></span>
                        <input type="date" class="form-control ps-3" name="date_end" id="date_end" aria-label="date_end"
                            aria-describedby="basic-addon1" placeholder="2022-01-01">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="company_id" class="form-label">Nama Perusahaan</label>
                    <select class="form-select" name="company_id" id="company_id" aria-label="Default select example">
                        <option selected>Pilih Perusahaan</option>
                        @foreach ($perusahaan as $item)
                            <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="company_number" class="form-label">No. Telepon Perusahaan</label>
                    <input type="number" class="form-control" name="company_number" id="company_number" disabled
                        placeholder="Secara sistem otomatis terisi, setelah memilih perusahaan">
                </div>
                <div class="mb-3">
                    <label for="company_address" class="form-label">Alamat Perusahaan</label>
                    <textarea class="form-control" name="company_address" id="company_address" rows="3" disabled
                        placeholder="Secara sistem otomatis terisi, setelah memilih perusahaan"></textarea>
                </div>
                <div class="mb-3">
                    <label for="division" class="form-label">Divisi</label>
                    <input type="text" class="form-control" name="division" id="division"
                        placeholder="Teknologi Informasi">
                </div>
                <div class="mb-3">
                    <label for="internship_type" class="form-label">Kategori Magang</label>
                    <select class="form-select" name="internship_type" id="internship_type"
                        aria-label="Default select example">
                        <option selected>Pilih Kategori Magang</option>
                        <option value="MSIB">MSIB</option>
                        <option value="Reguler">Reguler</option>
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
