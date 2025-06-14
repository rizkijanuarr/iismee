@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">
        {{-- SECTION INFORMASI Profil --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">🪪 Informasi Profil</h2>

            <div class="max-w-xl mx-auto">
                <div class="text-center">
                    <div class="mb-4">
                        @if ($data->img_path != null)
                            <img src="{{ asset('storage/' . $data->img_path) }}" alt="Foto Profil" id="btn"
                                class="h-40 w-40 object-cover rounded-full mx-auto shadow-lg cursor-pointer transition hover:scale-105">
                        @else
                            <div id="btn"
                                class="w-40 h-40 flex items-center justify-center rounded-full bg-gray-200 text-gray-500 mx-auto shadow cursor-pointer transition hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                                    class="bi bi-person-square" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <p id="text-help" class="text-sm text-gray-500">Klik gambar untuk mengganti foto profil.</p>
                </div>

                <div class="my-6">
                    <form action="{{ url('gantiFoto') }}" id="form" method="POST" enctype="multipart/form-data"
                        class="hidden space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label for="exampleFormControlInput1" class="block text-sm font-medium text-gray-700">Pilih Foto
                                Profil Baru</label>
                            <input type="file" id="exampleFormControlInput1" name="img_path"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm file:border-0 file:bg-white file:py-2 file:px-4 file:text-gray-700 file:font-semibold file:rounded-md hover:file:bg-gray-100">
                            <input type="hidden" name="oldimg" value="{{ $data->img_path }}">
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition">
                                Ganti Foto Profil
                            </button>
                        </div>
                    </form>
                </div>

                {{-- SECTION VALUE PROFIL --}}
                <div class="space-y-4">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" id="nim" name="nim" readonly
                            value="{{ $data->registration_number }}"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-gray-200 text-gray-800 focus:outline-none">
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" name="name" readonly value="{{ $data->name }}"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-gray-200 text-gray-800 focus:outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="email" name="email" readonly value="{{ $data->email }}"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-gray-200 text-gray-800 focus:outline-none">
                    </div>
                </div>
                {{-- SECTION VALUE PROFIL --}}

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const btn = document.getElementById("btn");
        const form = document.getElementById("form");
        const helpText = document.getElementById("text-help");

        btn.addEventListener("click", function() {
            form.classList.toggle("hidden");
            helpText.classList.toggle("hidden");
        });
    </script>
@endpush
