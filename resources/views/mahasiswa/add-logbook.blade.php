@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-28">
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b pb-2 mb-2">
                <h2 class="text-2xl font-semibold text-gray-800 ">➕ Tambah Logbook</h2>
                <a href="{{ url('logbook') }}"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-md transition mb-4 hover:text-white hover:no-underline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <p class="text-sm text-gray-700 bg-blue-100 border border-blue-200 rounded-lg p-3 mb-4">
                <strong>💡 Tips:</strong> Foto terlalu besar? Kompres dulu untuk upload yang lebih cepat!
                <a href="https://www.iloveimg.com/id/kompres-gambar" target="_blank"
                    class="text-blue-600 hover:text-blue-800 underline font-medium">
                    Klik di sini untuk mengompres foto →
                </a>
            </p>

            <form action="{{ url('logbook') }}" method="POST" enctype="multipart/form-data" id="logbookForm"
                class="space-y-4 bg-white ">
                @csrf

                <div>
                    <label for="img" class="block text-sm font-medium text-gray-700">Foto Kegiatan</label>
                    <input type="file" name="img" id="img"
                        class="mt-1 block w-full text-sm text-gray-600 border border-gray-300 rounded-md bg-gray-50 file:mr-4 file:py-2 file:px-4
                           file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700
                           hover:file:bg-gray-100 transition cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">PNG, JPG, JPEG - max 1MB</p>
                </div>

                <div>
                    <label for="activity_name" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                    <input type="text" name="activity_name" id="activity_name" value="{{ old('activity_name') }}"
                        placeholder="Nama Kegiatan"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Kegiatan</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="Tuliskan deskripsi kegiatan...">{{ old('description') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                    Submit
                </button>
            </form>
        </div>

    </div>
@endsection
