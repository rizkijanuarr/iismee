@extends('layout.user')

@section('konten')
    <div class="container py-5" style="margin-top: 50px">

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Absensi</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $fields = [
                            'NIM' => $data->registration_number ?? 'Belum ada NIM',
                            'Nama' => $data->name ?? 'Belum ada Nama',
                            'Kelas' => $data->class ?? 'Belum ada Kelas',
                            'Perusahaan' => $data->company->company_name ?? 'Belum ada Perusahaan',
                            'Divisi' => $data->division ?? 'Belum ada Divisi',
                            'Tipe Magang' => $data->internship_type ?? 'Belum ada Tipe Magang',
                            'Tgl. Mulai' => $data->date_start ?? 'Belum ada Tanggal Mulai',
                            'Tgl. Selesai' => $data->date_end ?? 'Belum ada Tanggal Selesai',
                            'Pembimbing' => $data->internship->lecturer->name ?? 'Belum ada Pembimbing',
                        ];
                    @endphp

                    @foreach ($fields as $label => $value)
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ $label }}</label>
                            <input type="text" class="form-control" value="{{ $value }}" readonly>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h6>Kegiatan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-4">
                    <h5 class="mb-3">Absensi {{ $now }}</h5>
                    @if ($is_absen_datang == true)
                        <h6 class="mb-3">Silahkan Mengisi Absensi Pulang !</h6>
                        <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data"
                            id="absensiPulangForm">
                            @method('put')
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                    name="student_id">
                                <label class="input-group-text" for="outProofFile">Bukti Absensi Pulang</label>
                                <input class="form-control d-inline" type="file" id="outProofFile" name="out_proof"
                                    accept=".pdf,.png,.jpg,.jpeg,.svg">
                                <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                            </div>
                            <small class="text-muted">Format yang didukung: PDF, PNG, JPG, SVG (Max: 5MB)</small>
                        </form>
                    @else
                        <h6 class="mb-3">Sebelum Mengisi Logbook, Silahkan Absen Datang Terlebih Dahulu !</h6>
                        <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data"
                            id="absensiDatangForm">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                    name="student_id">
                                <label class="input-group-text" for="entryProofFile">Bukti Absensi Datang</label>
                                <input class="form-control d-inline" type="file" id="entryProofFile" name="entry_proof"
                                    accept=".pdf,.png,.jpg,.jpeg,.svg">
                                <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                            </div>
                            <small class="text-muted">Format yang didukung: PDF, PNG, JPG, SVG (Max: 5MB)</small>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div> <!-- end of container -->

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tampilkan SweetAlert untuk success message
        @if (session()->has('success'))
            @if (str_contains(session('success'), 'Absensi datang'))
                Swal.fire({
                    icon: 'success',
                    title: 'Absensi Datang Berhasil!',
                    text: 'Silahkan klik OK untuk melanjutkan ke halaman Logbook',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/logbook';
                    }
                });
            @else
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif
        @endif

        // Function untuk validasi file
        function validateFile(file) {
            const allowedTypes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'];
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes

            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Diperlukan',
                    text: 'Silahkan pilih file bukti absensi terlebih dahulu!',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Valid',
                    text: 'Hanya file PDF, PNG, JPG, JPEG, dan SVG yang diperbolehkan!',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file maksimal 5MB!',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            return true;
        }

        // Handle form absensi datang
        document.getElementById('absensiDatangForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const fileInput = document.getElementById('entryProofFile');
            const file = fileInput.files[0];

            if (!validateFile(file)) {
                return false;
            }

            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Absensi Datang Berhasil!',
                    text: 'Silahkan klik OK untuk melanjutkan ke halaman Logbook',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/logbook';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat menyimpan absensi!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        });

        // Handle form absensi pulang
        document.getElementById('absensiPulangForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const fileInput = document.getElementById('outProofFile');
            const file = fileInput.files[0];

            if (!validateFile(file)) {
                return false;
            }

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Absensi Pulang Berhasil!',
                    text: 'Silahkan klik OK untuk melanjutkan ke halaman Logbook',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/logbook';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat menyimpan absensi pulang!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        });

        // Tampilkan SweetAlert untuk validation errors
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '• {{ $error }}\n';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: errorMessages,
                confirmButtonColor: '#3085d6'
            });
        @endif
    </script>
@endsection
