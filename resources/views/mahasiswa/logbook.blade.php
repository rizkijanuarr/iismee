@extends('layout.user')

@section('konten')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-20">

        {{-- SECTION INFORMASI LOGBOOK --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">📋 {{ __('messages.logbook_information') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $fields = [
                        __('messages.student_id_number') => $data->registration_number ?? __('messages.no_student_id'),
                        __('messages.name') => $data->name ?? __('messages.no_name'),
                        __('messages.class') => $data->class ?? __('messages.no_class'),
                        __('messages.company') => $data->company->company_name ?? __('messages.no_company'),
                        __('messages.division') => $data->division ?? __('messages.no_division'),
                        __('messages.internship_type') => $data->internship_type ?? __('messages.no_internship_type'),
                        __('messages.start_date') => $data->date_start ?? __('messages.no_start_date'),
                        __('messages.end_date') => $data->date_end ?? __('messages.no_end_date'),
                        __('messages.supervisor') => $data->internship->lecturer->name ?? __('messages.no_supervisor'),
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
                <h2 class="text-xl font-semibold text-gray-800">{{ __('messages.internship_approval_letter') }}</h2>
                @php
                    $sertifikat = \App\Models\Document::where('student_id', $data->id)
                        ->where('type', 'Sertifikat Magang')
                        ->first();
                @endphp

                @if ($suratMagang != null)
                    <a href="{{ '/storage/' . $suratMagang->document_path }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                        <i class="fas fa-eye"></i> {{ __('messages.view_sptjm_letter') }}
                    </a>
                @endif
            </div>

            <p class="text-sm text-gray-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                <strong>{{ __('messages.attention') }}:</strong> {{ __('messages.sptjm_requirement_notice') }}
            </p>

            <form action="{{ url('upload-dokumen') }}" method="POST" enctype="multipart/form-data" id="uploadSuratForm"
                class="flex flex-col md:flex-row items-stretch gap-3">
                @csrf
                <input type="hidden" name="student_id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="{{ __('messages.internship_approval_letter_type') }}">

                <input type="file" name="document_path" accept=".pdf,.png,.jpg,.jpeg,.svg"
                    class="flex-1 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-100 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700
                        hover:file:bg-gray-50 cursor-pointer transition"
                    required>

                <button type="submit"
                    class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow transition">
                    {{ __('messages.submit') }}
                </button>
            </form>

            <p class="text-xs text-gray-400 mt-2">{{ __('messages.pdf_format_info') }}</p>
        </div>

        {{-- SECTION KEGIATAN --}}
        <div class="bg-white shadow-2xl hover:shadow-[0_8px_30px_rgba(0,0,0,0.15)] transition-shadow rounded-2xl p-6 mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800 ">📌 {{ __('messages.activities') }}</h2>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ $hasLogbookToday ? 'javascript:void(0)' : url('logbook/create') }}"
                        class="inline-flex items-center gap-2 
                        {{ $hasLogbookToday ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }} 
                         text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white"
                        {{ $hasLogbookToday ? 'onclick="showAlreadyExistsAlert()"' : '' }}>
                        <i class="fas fa-plus"></i>
                        {{ $hasLogbookToday ? __('messages.logbook_exists_today') : __('messages.add_logbook') }}
                    </a>

                    <a href="{{ url('print-logbook') }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                        <i class="fas fa-file-pdf"></i> {{ __('messages.print_logbook') }}
                    </a>

                    @if ($cekAbsensiDatang == true)
                        <a href="{{ url('absensi') }}"
                            class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-md transition hover:no-underline hover:text-white">
                            <i class="fas fa-clipboard-check "></i> {{ __('messages.checkout_attendance') }}
                        </a>
                    @endif
                </div>
            </div>
            <p class="text-sm text-black-700 bg-red-100 border border-red-200 rounded-lg p-3 mb-4">
                <strong>💡 {{ __('messages.attention') }}:</strong> {{ __('messages.logbook_daily_notice') }}
            </p>




            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">{{ __('messages.number') }}</th>
                            <th class="px-4 py-3">{{ __('messages.activity_name') }}</th>
                            <th class="px-4 py-3">{{ __('messages.activity_date') }}</th>
                            <th class="px-4 py-3">{{ __('messages.activity_proof') }}</th>
                            <th class="px-4 py-3">{{ __('messages.supervisor_feedback') }}</th>
                            <th class="px-4 py-3">{{ __('messages.action') }}</th>
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
                                        <img src="{{ asset('storage/' . $data->img) }}" alt="{{ __('messages.activity_proof') }}"
                                            class="h-24 object-cover rounded-md border">
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">-</td>
                                    <td class="px-4 py-3 space-x-2">
                                        <a href="{{ url('logbook/' . $data->id . '/edit') }}"
                                            class="inline-block hover:text-white hover:no-underline px-4 py-2 text-xs font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                            {{ __('messages.edit') }}
                                        </a>
                                        <button
                                            class="inline-block hover:text-white hover:no-underline px-4 py-2 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-600 delete-logbook"
                                            data-id="{{ $data->id }}">
                                            {{ __('messages.delete') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm font-bold text-red-600">
                                    {{ __('messages.no_logbook_data_available') }}
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
                    title: '{{ __('messages.delete_logbook_title') }}',
                    text: "{{ __('messages.delete_logbook_text') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '{{ __('messages.yes_delete') }}',
                    cancelButtonText: '{{ __('messages.cancel') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: '{{ __('messages.deleting_data') }}',
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
                title: '{{ __('messages.cannot_add_title') }}',
                text: '{{ __('messages.logbook_already_exists_today') }}',
                icon: 'info',
                confirmButtonText: '{{ __('messages.ok') }}',
                timer: 3000,
                timerProgressBar: true
            });
        }
    </script>
@endsection
