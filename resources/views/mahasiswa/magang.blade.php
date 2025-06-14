@php
    use App\Helpers\CustomHelper;
    $customHelper = new CustomHelper();
@endphp

@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">

        {{-- SECTION INFORMASI LOGBOOK --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">📋 Informasi Magang</h2>

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

        {{-- SECTION UPLOAD SERTIFIKAT --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">🏅 Sertifikat Magang</h2>
                @php
                    $sertifikat = \App\Models\Document::where('student_id', $data->id)
                        ->where('type', 'Sertifikat Magang')
                        ->first();
                @endphp

                @if ($sertifikat)
                    <a target="_blank" href="{{ asset('storage/' . $sertifikat->document_path) }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                        <i class="fas fa-eye"></i> Lihat Sertifikat Magang
                    </a>
                @endif
            </div>

            <p class="text-sm text-gray-700 bg-blue-100 border border-blue-200 rounded-lg p-3 mb-4">
                <strong> 💡 Perhatian:</strong> Selama periode Magang berlangsung, mahasiswa
                <span class="font-semibold">diwajibkan melampirkan Sertifikat Magang</span>
                sebagai salah satu syarat administratif.
            </p>

            <form action="{{ url('upload-dokumen') }}" method="POST" enctype="multipart/form-data" id="uploadForm"
                class="flex flex-col md:flex-row items-stretch gap-3">
                @csrf
                <input type="hidden" name="student_id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="Sertifikat Magang">

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


        {{-- SECTION KONVERSI MATAKULIAH --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800 ">📚 Daftar MK</h2>
            </div>
            <p class="text-sm text-gray-700 bg-blue-100 border border-blue-200 rounded-lg p-3 mb-4">
                <strong>💡 Perhatian:</strong> Jika Anda bertanya mengapa masih kosong data MK,
                <strong>karena Dosen Pembimbing belum melakukan penilaian.</strong>
                Harap <strong>cek secara berkala</strong> serta <strong>berkabar ke dosen pembimbing kalian</strong>!
            </p>


            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Nama Mata Kuliah</th>
                            <th class="px-4 py-3">DPMK</th>
                            <th class="px-4 py-3">Skor</th>
                            <th class="px-4 py-3">Nilai Angka</th>
                            <th class="px-4 py-3">Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($mpk->count() > 0)
                            @foreach ($mpk as $key => $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $key + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item->subject_name }}</td>
                                    <td class="px-4 py-3">{{ $item->name }}</td>
                                    <td class="px-4 py-3">{{ $item->sks }}</td>
                                    <td class="px-4 py-3">{{ $item->nilai }}</td>
                                    <td class="px-4 py-3">{{ $customHelper->konversiNilai($item->nilai) }}</td>
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

    </div>
@endsection
