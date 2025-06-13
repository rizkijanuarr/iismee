@php
    use App\Helpers\CustomHelper;
    $customHelper = new CustomHelper();
@endphp

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

        <!-- Data Magang -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Magang</h5>
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

                <!-- Upload Sertifikat -->
                <div class="col-md-12 mb-3">
                    <form action="{{ url('upload-dokumen') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <label for="formFile" class="form-label fw-semibold">Upload Sertifikat Magang</label>
                        <div class="input-group">
                            <input type="hidden" name="student_id" value="{{ $data->id }}">
                            <input type="hidden" name="type" value="Sertifikat Magang">
                            <input type="file" name="document_path" id="formFile" class="form-control" accept=".pdf,.png,.jpg,.jpeg,.svg">
                            <button type="submit" class="btn btn-primary ms-3" id="submitBtn">Submit</button>
                        </div>
                        <small class="text-muted">Format yang didukung: PDF, PNG, JPG, SVG (Max: 5MB)</small>
                    </form>
                    @php
                        $sertifikat = \App\Models\Document::where('student_id', $data->id)->where('type', 'Sertifikat Magang')->first();
                    @endphp
                    @if ($sertifikat)
                        <a target="_blank" href="{{ asset('storage/' . $sertifikat->document_path) }}" class="btn btn-info mt-2">
                            <i class="fas fa-file-pdf"></i> Lihat Sertifikat Magang
                        </a>
                    @endif
                </div>

                <div class="col-md-12">
                    <a href="{{ url('laporan') }}" class="btn btn-danger w-100">
                        <i class="far fa-file"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabel Konversi Mata Kuliah -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Daftar Mata Kuliah Konversi Magang</h6>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Mata Kuliah</th>
                            <th>DPMK</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Nilai Angka</th>
                            <th class="text-center">Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mpk as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->subject_name }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->sks }}</td>
                                <td class="text-center">{{ $item->nilai }}</td>
                                <td class="text-center">{{ $customHelper->konversiNilai($item->nilai) }}</td>
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
            // Konfirmasi sebelum upload
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const fileInput = document.getElementById('formFile');
                if (!fileInput.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Silakan pilih file terlebih dahulu!',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Upload',
                    text: 'Apakah Anda yakin ingin mengupload dokumen ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Upload!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form langsung tanpa loading
                        this.submit();
                    }
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