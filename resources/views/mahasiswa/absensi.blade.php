@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">

        {{-- Informasi Absensi --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">📌 Informasi Absensi</h2>

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

        {{-- Kegiatan / Absensi --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">📅 Absensi Hari Ini <span
                    class="text-gray-500">({{ $now }})</span></h2>

            @if ($is_absen_datang)
                <p class="text-sm text-gray-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                    <strong>⚠️ Perhatian:</strong> Segera <strong>mengisi Absensi Kepulangan</strong> setelah
                    menyelesaikan Logbook hari ini! 🙏✨<br>
                    Thank you for today — we appreciate it!!! 🎉✨
                </p>

                <!-- FORM ABSENSI PULANG - DIPERBAIKI -->
                <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data" id="absensiPulangForm"
                    class="space-y-2">
                    @method('put')
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $data->id }}">

                    <div class="flex flex-col md:flex-row items-stretch gap-3">
                        <input type="file" name="out_proof" accept=".png,.jpg,.jpeg"
                            class="flex-1 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-100 file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700
                           hover:file:bg-gray-50 cursor-pointer transition"
                            required>

                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow transition">
                            Submit Absensi Pulang
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">PNG, JPG, JPEG — max 1MB</p>
                </form>
            @else
                <p class="text-sm text-gray-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                    <strong>⚠️ Perhatian:</strong> Silakan <strong>mengisi Absensi Kedatangan</strong> kalian sebelum
                    melanjutkan ke Logbook di hari ini!
                </p>

                <!-- FORM ABSENSI DATANG - DIPERBAIKI -->
                <form action="{{ url('absensi') }}" method="post" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $data->id }}">

                    <div class="flex flex-col md:flex-row items-stretch gap-3">
                        <input type="file" name="entry_proof" accept=".png,.jpg,.jpeg"
                            class="flex-1 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-100 file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700
                           hover:file:bg-gray-50 cursor-pointer transition"
                            required>

                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow transition">
                            Submit Absensi Datang
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">PNG, JPG, JPEG — max 1MB</p>
                </form>
            @endif
        </div>

    </div>
@endsection
