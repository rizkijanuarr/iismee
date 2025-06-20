@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">


        {{-- SECTION INFORMASI LAPORAN --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">🗂️ Informasi Laporan</h2>

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
        {{-- SECTION INFORMASI LAPORAN --}}



        {{-- SECTION UPLOAD LAPORAN MAGANG --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">📝 Pelaporan Magang</h2>
            </div>

            <form action="{{ route('laporan.store') }}" method="post" enctype="multipart/form-data" id="laporanForm"
                class="flex flex-col gap-4">
                @csrf

                {{-- Hidden Inputs --}}
                <input type="hidden" name="student_id" value="{{ $data->id }}">

                {{-- Upload & Submit --}}
                <div class="flex flex-col md:flex-row items-stretch gap-3">
                    {{-- File Input --}}
                    <input type="file" name="document_path" accept=".pdf"
                        class="flex-1 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700 hover:file:bg-gray-50 cursor-pointer transition"
                        required>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                        Submit
                    </button>
                </div>
            </form>

            <p class="text-xs text-gray-400 mt-2">PDF — max 2MB</p>
        </div>
        {{-- SECTION UPLOAD LAPORAN MAGANG --}}



        {{-- SECTION HASIL LAPORAN MAGANG --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">📊 Hasil Laporan Magang</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Nama File</th>
                            <th class="px-4 py-3">Jenis File</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($laporan->count() > 0)
                            @foreach ($laporan as $key => $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $key + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item->name }}</td>

                                    {{-- TYPE Badge --}}
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700">
                                            {{ strtoupper($item->type) }}
                                        </span>
                                    </td>

                                    {{-- VALIDATION STATUS Badge --}}
                                    <td class="px-4 py-3">
                                        @php
                                            $statusClass = match ($item->validation_status) {
                                                'Disetujui' => 'bg-green-100 text-green-700',
                                                'Ditolak' => 'bg-red-100 text-red-700',
                                                default => 'bg-yellow-100 text-yellow-700',
                                            };
                                        @endphp
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                            {{ $item->validation_status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">{{ $item->information ?? '-' }}</td>

                                    <td class="px-4 py-3">
                                        <button
                                            class="delete-btn inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md shadow transition delete-laporan"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm font-bold text-red-600">
                                    Belum ada data yang tersedia.
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
            </div>

        </div>
        {{-- SECTION HASIL LAPORAN MAGANG --}}

    </div>
    {{-- Load jQuery dan SweetAlert --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.delete-laporan').click(function(e) {
                e.preventDefault();
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Laporan?',
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
                            const form = $(`<form action="/laporan/${id}" method="POST">
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
    </script>
@endsection
