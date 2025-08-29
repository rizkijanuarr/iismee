@extends('layout.user')

@section('konten')
    <header class="bg-white py-12 pt-[200px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12">

                <!-- KIRI: Informasi Text -->
                <div class="w-full lg:w-1/2 space-y-6">
                    <div>
                        <span class="inline-block bg-pink-100 text-pink-600 text-sm font-bold px-4 py-1 rounded-full">
                            {{ __('messages.welcome') }} {{ auth()->user()->name }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                        {{ __('messages.system_title') }}
                    </h1>

                    <p class="text-gray-600 text-lg">
                        {{ __('messages.system_description') }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-4">
                        <a href="{{ url('magang') }}"
                            class="bg-pink-500 hover:no-underline hover:bg-pink-600 hover:text-white text-white font-semibold py-2 px-6 rounded-full shadow transition">
                            <i class="fas fa-book mr-2"></i> {{ __('messages.internship') }}
                        </a>

                        @if (!$cekAbsensiDatang)
                            <a href="{{ url('absensi') }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-6 rounded-full shadow transition hover:no-underline hover:text-white">
                                <i class="fas fa-clipboard-check mr-2"></i> {{ __('messages.attendance') }}
                            </a>
                        @else
                            <a href="{{ url('logbook') }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-full shadow transition">
                                <i class="fas fa-book mr-2"></i> {{ __('messages.fill_logbook') }}
                            </a>
                        @endif

                        <button onclick="showPanduan()"
                            class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 px-6 rounded-full shadow transition">
                            <i class="fas fa-info-circle mr-2"></i> {{ __('messages.view_guide') }}
                        </button>
                    </div>
                </div>

                <!-- KANAN: Gambar -->
                <div class="w-full lg:w-1/2">
                    <img src="{{ URL::asset('img/header-illustration.svg') }}" alt="{{ __('messages.header_illustration') }}" class="w-full h-auto">
                </div>

            </div>
        </div>
    </header>

    <script>
        function showPanduan() {
            Swal.fire({
                icon: 'info',
                title: '{{ __('messages.usage_guide') }}',
                html: `
                    <div style='text-align:left;'>
                        <b>{{ __('messages.during_internship') }}</b>
                        <ul class="list-disc pl-5">
                            <li>{{ __('messages.guide_click_attendance') }}</li>
                            <li>{{ __('messages.guide_daily_checkin') }}</li>
                            <li>{{ __('messages.guide_fill_logbook') }}</li>
                            <li>{{ __('messages.guide_checkout') }}</li>
                            <li>{{ __('messages.guide_repeat_daily') }}</li>
                            <li>{{ __('messages.guide_approval_letter') }}</li>
                        </ul>
                        <br/>
                        <b>{{ __('messages.after_internship') }}</b>
                        <ul class="list-disc pl-5">
                            <li>{{ __('messages.guide_click_report') }}</li>
                            <li>{{ __('messages.guide_upload_report') }}</li>
                            <li>{{ __('messages.guide_wait_validation') }}</li>
                            <li>{{ __('messages.guide_upload_certificate') }}</li>
                            <li>{{ __('messages.guide_grade_conversion') }}</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: '{{ __('messages.ok') }}'
            });
        }
    </script>
@endsection
