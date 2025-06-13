@extends('layout.user')

@section('konten')
    <div class="container py-5" style="margin-top: 50px">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show fw-bold" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show fw-bold" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Laporan</h5>
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
                <hr class="my-4">

                <form action="{{ url('laporan') }}" method="post" enctype="multipart/form-data" id="laporanForm">
                    @csrf
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Jenis Laporan</label>
                        <select class="form-select" id="inputGroupSelect01" name="name">
                            <option value="Syarat Unggah Nilai" selected>Syarat Unggah Nilai</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control d-inline" type="hidden" value="{{ $data->id }}" name="student_id">
                        <label class="input-group-text" for="inputGroupFile01">File Laporan</label>
                        <input class="form-control d-inline" type="file" id="formFile" name="document_path" accept=".pdf,.png,.jpg,.jpeg,.svg">
                        <button type="submit" class="btn btn-primary d-inline-block ms-3" id="submitBtn">Submit</button>
                    </div>
                    <small class="text-muted">Format yang didukung: PDF, PNG, JPG, SVG (Max: 5MB)</small>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Kegiatan</h6>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama File</th>
                            <th>Jenis File</th>
                            <th>Status Validasi</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->type }}</td>
                                <td>
                                    <span class="badge {{ $item->validation_status == 'Disetujui' ? 'bg-success' : ($item->validation_status == 'Ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $item->validation_status }}
                                    </span>
                                </td>
                                <td>{{ $item->information ?? '-' }}</td>
                                <td class="align-middle">
                                    <button class="btn btn-danger btn-sm font-weight-bold text-xs delete-btn" 
                                            data-id="{{ $item->id }}" 
                                            data-name="{{ $item->name }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-danger m-0">
                                        Belum ada data.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission dengan konfirmasi SweetAlert
            document.getElementById('laporanForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const fileInput = document.getElementById('formFile');
                const jenisLaporan = document.getElementById('inputGroupSelect01').value;
                
                // Validasi file
                if (!fileInput.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Silakan pilih file laporan terlebih dahulu!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Validasi format file
                const file = fileInput.files[0];
                const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'];
                const allowedExtensions = ['.pdf', '.png', '.jpg', '.jpeg', '.svg'];
                
                const fileExtension = file.name.toLowerCase().substring(file.name.lastIndexOf('.'));
                
                if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Didukung!',
                        text: 'File harus berformat PDF, PNG, JPG, atau SVG!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Validasi ukuran file (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar!',
                        text: 'Ukuran file maksimal 5MB!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Konfirmasi upload
                Swal.fire({
                    title: 'Konfirmasi Upload Laporan',
                    html: `
                        <p>Jenis Laporan: <strong>${jenisLaporan}</strong></p>
                        <p>File: <strong>${file.name}</strong></p>
                        <p>Ukuran: <strong>${(file.size / 1024 / 1024).toFixed(2)} MB</strong></p>
                        <br>
                        <p>Apakah Anda yakin ingin mengupload laporan ini?</p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Upload!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Mengupload Laporan...',
                            text: 'Mohon tunggu, laporan sedang diupload.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit form
                        this.submit();
                    }
                });
            });

            // Handle delete dengan konfirmasi SweetAlert
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Apakah Anda yakin ingin menghapus laporan:<br><strong>"${name}"</strong>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu, laporan sedang dihapus.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Create and submit delete form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `laporan/${id}`;
                            
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            
                            const tokenInput = document.createElement('input');
                            tokenInput.type = 'hidden';
                            tokenInput.name = '_token';
                            tokenInput.value = '{{ csrf_token() }}';
                            
                            form.appendChild(methodInput);
                            form.appendChild(tokenInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Handle success/error messages dengan SweetAlert
            @if (session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            @endif

            @if (session()->has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3085d6'
                });
            @endif
        });
    </script>
@endsection