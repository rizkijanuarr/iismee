<header class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <nav class="max-w-7xl mx-auto flex items-center justify-between p-4 lg:px-8" aria-label="Global">
        <!-- Logo -->
        <div class="flex flex-1">
            <a href="{{ url('mahasiswa') }}" class="text-2xl font-bold text-pink-600">IISMEE</a>
        </div>

        <!-- Hamburger (mobile) -->
        <div class="flex lg:hidden">
            <button id="mobile-menu-button"
                class="inline-flex items-center justify-center p-2 text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        @php
            $active = request()->segment(1);
        @endphp

        <div class="hidden lg:flex lg:space-x-8">
            <a href="{{ url('mahasiswa') }}"
                class="text-sm font-semibold {{ $active == 'mahasiswa' ? 'text-pink-600 border-b-2 border-pink-600' : 'text-gray-700' }} hover:text-pink-600 hover:underline">
                {{ __('messages.home') }}
            </a>
            <a href="{{ url('logbook') }}"
                class="text-sm font-semibold {{ $active == 'logbook' ? 'text-pink-600 border-b-2 border-pink-600' : 'text-gray-700' }} hover:text-pink-600 hover:underline">
                {{ __('messages.logbook') }}
            </a>
            <a href="{{ url('laporan') }}"
                class="text-sm font-semibold {{ $active == 'laporan' ? 'text-pink-600 border-b-2 border-pink-600' : 'text-gray-700' }} hover:text-pink-600 hover:underline">
                {{ __('messages.report') }}
            </a>
        </div>


        <!-- User Dropdown pakai Alpine -->
        <div class="hidden lg:flex lg:flex-1 lg:justify-end relative" x-data="{ open: false }"
            @click.outside="open = false">
            <div class="relative">
                <button @click="open = !open"
                    class="text-sm font-semibold text-gray-700 hover:text-pink-600 flex items-center gap-1 focus:outline-none hover:underline">
                    {{ Auth::user()->name }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg z-50"
                    @click.away="open = false">
                    <a href="{{ route('profile-user') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-pink-600 hover:underline">{{ __('messages.profile') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-pink-600 hover:underline">{{ __('messages.logout') }}</button>
                    </form>
                </div>
            </div>
        </div>

    </nav>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="lg:hidden hidden px-4 pb-4 space-y-2 bg-white shadow-md">
        <a href="{{ url('mahasiswa') }}" class="block text-sm font-semibold text-gray-700 hover:text-blue-600">{{ __('messages.home') }}</a>
        <a href="{{ url('logbook') }}"
            class="block text-sm font-semibold text-gray-700 hover:text-blue-600">{{ __('messages.logbook') }}</a>
        <a href="{{ url('laporan') }}"
            class="block text-sm font-semibold text-gray-700 hover:text-blue-600">{{ __('messages.report') }}</a>
        <hr />
        <a href="{{ route('profile-user') }}"
            class="block text-sm font-semibold text-gray-700 hover:text-blue-600">{{ __('messages.profile') }}</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left text-sm font-semibold text-gray-700 hover:text-blue-600">{{ __('messages.logout') }}</button>
        </form>
    </div>
</header>
