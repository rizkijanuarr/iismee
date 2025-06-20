@extends('layout.admin')

@section('konten')
    <form action="{{ url('manage-pembimbing-industri') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Gumilar Agung">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="gumilaragung@gmailcom">
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="position" id="position" placeholder="Lead Engineer">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" name="phone_number" id="phone_number"
                        placeholder="08123456789">
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
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@push('script')
    <script>
        $('#company_id').change(function() {
            var company_id = $(this).val();
            var url = "{{ url('getDataPerusahaan') }}";

            $.ajax({
                type: 'GET',
                url: url,
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
