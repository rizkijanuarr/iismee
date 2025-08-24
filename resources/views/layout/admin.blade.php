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
    <!-- Font Awesome CDN (CSS) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
    <!-- Bootstrap 5.2.2 - KONSISTEN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <!-- Nucleo Icons -->
    <link href="{{ URL::asset('/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons (Kit, opsional) -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
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
        /* FIX SIDEBAR Z-INDEX ISSUES */
        .sidenav {
            position: fixed !important;
            z-index: 1040 !important;
        }
        /* Saat modal aktif, sidebar di bawah modal */
        body.modal-open .sidenav {
            z-index: 1040 !important;
            padding-right: 0 !important;
            overflow: visible !important;
        }
        /* Modal backdrop di atas sidebar */
        .modal-backdrop {
            z-index: 1050 !important;
            position: fixed !important;
        }
        /* Modal di atas backdrop dan sidebar */
        .modal {
            z-index: 1060 !important;
            position: fixed !important;
        }
        /* Navbar tetap di atas sidebar jika perlu */
            /* Navbar selalu di belakang modal saat modal aktif */
            body.modal-open .navbar-main {
                z-index: 1030 !important;
            }
        /* Fix potential scrollbar issues */
        body.modal-open {
            overflow: hidden;
        }
        body.modal-open .sidenav {
            overflow-y: auto;
        }
    </style>

    @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('components.side-bar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @include('components.navbar-admin')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('konten')
            @include('components.footer-admin')
        </div>
    </main>

    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5.2.2 JS - KONSISTEN dengan CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
            crossorigin="anonymous"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <!-- Soft UI Dashboard JS -->
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

    <!-- MODAL EVENT HANDLERS TO PREVENT SIDEBAR ISSUES -->
    <script>
        $(document).ready(function() {
            // Handle all modals to prevent sidebar issues
            $('.modal').on('show.bs.modal', function() {
                console.log('Modal opening, preserving sidebar');
                $('body').addClass('modal-opening');
                
                // Ensure sidebar stays visible and functional
                $('.sidenav').css({
                    'z-index': '1070',
                    'position': 'fixed',
                    'overflow-y': 'auto'
                });
            });
            
            $('.modal').on('shown.bs.modal', function() {
                $('body').removeClass('modal-opening');
            });
            
            $('.modal').on('hidden.bs.modal', function() {
                console.log('Modal closed, restoring sidebar');
                // Reset any inline styles
                $('.sidenav').css('z-index', '');
            });
        });
    </script>

    <!-- SweetAlert2 Success Notification -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.success_title') }}',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonText: '{{ __('messages.ok') }}',
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
                title: '{{ __('messages.error_title') }}',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonText: '{{ __('messages.ok') }}',
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
                title: '{{ __('messages.validation_title') }}',
                text: errorMessages,
                showConfirmButton: true,
                confirmButtonText: '{{ __('messages.ok') }}',
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
                title: '{{ __('messages.info_title') }}',
                text: '{{ session('info') }}',
                showConfirmButton: true,
                confirmButtonText: '{{ __('messages.ok') }}',
                confirmButtonColor: '#17a2b8'
            });
        </script>
    @endif

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    
    <!-- Control Center for Soft Dashboard -->
    <script src="{{ URL::asset('/js/soft-ui-dashboard.min.js') }}"></script>
    
    @stack('scripts')
</body>

</html>