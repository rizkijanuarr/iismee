<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        IISMEE
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <!-- Nucleo Icons -->
    <link href="{{ URL::asset('/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ URL::asset('/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/trix.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/trix.js') }}"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ URL::asset('/css/soft-ui-dashboard.css') }}" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>

</head>

<body class="g-sidenav-show  bg-gray-100">
    @include('components.side-bar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('components.navbar-admin')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('konten')
            @include('components.footer-admin')
        </div>

    </main>
    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ URL::asset('/js/core/popper.min.js') }}"></script>
    <script src="{{ URL::asset('/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script>
        flatpickr("input[type=date]", {});
    </script>
    <script>
        $('.btn-detail').click(function() {
            var target = $(this).data('target');
            $(target).toggle();
        });
    </script>

    <!-- SweetAlert2 Success Notification -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745',
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    <!-- SweetAlert2 Error Notification -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    <!-- SweetAlert2 Validation Error -->
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
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ffc107',
                customClass: {
                    content: 'text-left'
                }
            });
        </script>
    @endif

    <!-- SweetAlert2 Info Notification -->
    @if (session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#17a2b8'
            });
        </script>
    @endif

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ URL::asset('/js/soft-ui-dashboard.min.js') }}"></script>
    @stack('script')
</body>

</html>
