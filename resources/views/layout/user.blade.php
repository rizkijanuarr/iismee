<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>IISMEE | {{ $title }}</title>

    <meta name="description" content="Your description" />
    <meta name="author" content="Your name" />
    <meta property="og:site_name" content="" />
    <meta property="og:site" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {}
            }
        }
    </script>
    <link href="{{ URL::asset('/css/fontawesome-all.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/swiper.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ URL::asset('images/favicon.png') }}" />
</head>

<body>

    @include('components.navbar-user')
    @yield('konten')
    <button onclick="topFunction()" id="myBtn">
        <img src="{{ URL::asset('/img/up-arrow.png') }}" alt="up" />
    </button>

    <script src="{{ URL::asset('/js/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('/js/purecounter.min.js') }}"></script>
    <script src="{{ URL::asset('/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('/js/scripts.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '• {{ $error }}\n';
            @endforeach

            Swal.fire({
                icon: 'warning',
                title: 'Periksa Form Anda!',
                text: errorMessages,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffc107',
                customClass: {
                    content: 'text-left'
                }
            });
        </script>
    @endif

    @if (session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#17a2b8'
            });
        </script>
    @endif

</body>

</html>
