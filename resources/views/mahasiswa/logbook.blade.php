@extends('layout.user')

@section('konten')
    <div class="container py-5" style="margin-top: 50px">

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Logbook</h5>
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
                <h6>Aksi Logbook</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="p-4">
                    <div class="mb-3">
                        <a name="" id="" class="btn btn-success text-decoration-none me-2"
                            href="{{ url('logbook/create') }}" role="button"><i class="fas fa-plus"></i> Tambah Logbook</a>
                        <a name="" id="" class="btn btn-info text-decoration-none me-2"
                            href="{{ url('print-logbook') }}" target="_blank" role="button"><i class="fas fa-file-pdf"></i>
                            Cetak Logbook</a>
                        @if ($suratMagang != null)
                            <a name="" id="" class="btn btn-primary text-decoration-none me-2"
                                target="_blank" href="{{ '/storage/' . $suratMagang->document_path }}" role="button">Lihat
                                Surat
                                Persetujuan</a>
                        @endif
                        @if ($cekAbsensiDatang == true)
                            <a name="" id="" class="btn btn-warning text-decoration-none"
                                href="{{ url('absensi') }}" role="button"><i class="fas fa-clipboard-check"></i>
                                Absensi Pulang</a>
                        @endif
                    </div>

                    <form action="{{ url('upload-dokumen') }}" method="post" enctype="multipart/form-data" id="uploadSuratForm">
                        @csrf
                        <div class="input-group mb-3">
                            <input class="form-control d-inline" type="hidden" value="{{ $data->id }}"
                                name="student_id">
                            <input class="form-control d-inline" type="hidden" value="Surat Persetujuan Magang"
                                name="type">
                            <label class="input-group-text" for="formFile">Surat Persetujuan Magang</label>
                            <input class="form-control d-inline" type="file" id="formFile" name="document_path" accept=".pdf,.png,.jpg,.jpeg,.svg">
                            <button type="submit" class="btn btn-primary d-inline-block ms-3">Submit</button>
                        </div>
                        <small class="text-muted">Silakan upload surat persetujuan magang dari perusahaan</small>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h6>Kegiatan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive table-bordered border-dark p-3">
                    <table class="table align-items-center mb-0" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Kegiatan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bukti
                                    Kegiatan
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Masukan
                                    Pembimbing
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($logbook->count() > 0)
                                @foreach ($logbook as $key => $data)
                                    <tr>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $key + 1 }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->activity_name }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    {{ $data->activity_date }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    <img src="{{ URL::asset('storage/' . $data->img) }}" alt=""
                                                        style="height: 100px">
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">
                                                    -
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="logbook/{{ $data->id }}/edit"
                                                class="btn btn-warning font-weight-bold text-xs"
                                                data-original-title="Edit user" id="edit">
                                                Edit
                                            </a>
                                            <button class="btn btn-danger font-weight-bold text-xs delete-logbook"
                                                data-id="{{ $data->id }}"
                                                data-original-title="Hapus">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-danger m-0">
                                            Belum ada data.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> <!-- end of container -->

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Handle delete button clicks
        document.querySelectorAll('.delete-logbook').forEach(button => {
            button.addEventListener('click', function() {
                const logbookId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/logbook/${logbookId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat menghapus logbook!',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
            });
        });

        // Handle upload surat persetujuan magang
        document.getElementById('uploadSuratForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                let errorMsg = '';
                if (error.errors) {
                    for (let key in error.errors) {
                        errorMsg += error.errors[key][0] + '\n';
                    }
                } else {
                    errorMsg = error.message || 'Terjadi kesalahan saat upload dokumen!';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
@endsection
