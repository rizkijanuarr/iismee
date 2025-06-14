@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">

        {{-- SECTION INFORMASI LOGBOOK --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">📋 Informasi Logbook</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ $label }}</label>
                        <input type="text" value="{{ $value }}" readonly
                            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-gray-200 text-gray-800 focus:outline-none">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SECTION SPTJM --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">


            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">Surat Persetujuan Magang (SPTJM)</h2>
                @php
                    $sertifikat = \App\Models\Document::where('student_id', $data->id)
                        ->where('type', 'Sertifikat Magang')
                        ->first();
                @endphp

                @if ($suratMagang != null)
                    <a href="{{ '/storage/' . $suratMagang->document_path }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                        <i class="fas fa-eye"></i> Lihat Surat SPTJM
                    </a>
                @endif
            </div>

            <p class="text-sm text-gray-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                <strong>Perhatian:</strong> Selama periode Magang, mahasiswa <span class="font-semibold">diwajibkan
                    melampirkan Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)</span> sebagai salah satu syarat
                administratif.
            </p>

            <form action="{{ url('upload-dokumen') }}" method="POST" enctype="multipart/form-data" id="uploadSuratForm"
                class="flex flex-col md:flex-row items-stretch gap-3">
                @csrf
                <input type="hidden" name="student_id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="Surat Persetujuan Magang">

                <input type="file" name="document_path" accept=".pdf,.png,.jpg,.jpeg,.svg"
                    class="flex-1 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-100 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700
                        hover:file:bg-gray-50 cursor-pointer transition"
                    required>

                <button type="submit"
                    class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                    Submit
                </button>
            </form>

            <p class="text-xs text-gray-400 mt-2">PDF — max 2MB</p>
        </div>

        {{-- SECTION KEGIATAN --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800 ">📌 Kegiatan</h2>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ $hasLogbookToday ? 'javascript:void(0)' : url('logbook/create') }}"
                        class="inline-flex items-center gap-2 
                        {{ $hasLogbookToday ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }} 
                         text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white"
                        {{ $hasLogbookToday ? 'onclick="showAlreadyExistsAlert()"' : '' }}>
                        <i class="fas fa-plus"></i>
                        {{ $hasLogbookToday ? 'Sudah Ada Logbook Hari Ini' : 'Tambah Logbook' }}
                    </a>

                    <a href="{{ url('print-logbook') }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                        <i class="fas fa-file-pdf"></i> Cetak Logbook
                    </a>

                    @if ($cekAbsensiDatang == true)
                        <a href="{{ url('absensi') }}"
                            class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                            <i class="fas fa-clipboard-check "></i> Absensi Pulang
                        </a>
                    @endif
                </div>
            </div>
            <p class="text-sm text-black-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                <strong>💡 Perhatian:</strong> Satu hari untuk satu logbook. Edit/hapus jika salah. Dan jangan lupa klik <!>
                    <strong>Absensi Pulang!</strong> Good luck for today!<u />
            </p>





            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Nama Kegiatan</th>
                            <th class="px-4 py-3">Tanggal Kegiatan</th>
                            <th class="px-4 py-3">Bukti Kegiatan</th>
                            <th class="px-4 py-3">Masukan Pembimbing</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($logbook->count() > 0)
                            @foreach ($logbook as $key => $data)
                                <tr>
                                    <td class="px-4 py-3">{{ $key + 1 }}</td>
                                    <td class="px-4 py-3">{{ $data->activity_name }}</td>
                                    <td class="px-4 py-3">{{ $data->activity_date }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/' . $data->img) }}" alt="Bukti Kegiatan"
                                            class="h-24 object-cover rounded-md border">
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">-</td>
                                    <td class="px-4 py-3 space-x-2">
                                        <a href="{{ url('logbook/' . $data->id . '/edit') }}"
                                            class="inline-block hover:text-white hover:no-underline px-4 py-2 text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <button
                                            class="inline-block hover:text-white hover:no-underline px-4 py-2 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-600 delete-logbook"
                                            data-id="{{ $data->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm font-bold text-red-600">
                                    Belum ada data logbook yang tersedia.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Load jQuery dan SweetAlert --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.delete-logbook').click(function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Logbook?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus data',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        setTimeout(() => {
                            const form = $(`<form action="/logbook/${id}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>`);

                            $('body').append(form);
                            form.submit();
                        }, 2000);
                    }
                });
            });
        });

        function showAlreadyExistsAlert() {
            Swal.fire({
                title: 'Tidak Dapat Menambah',
                text: 'Anda sudah membuat logbook hari ini!',
                icon: 'info',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        }
    </script>
@endsection
