<!-- Navigation -->
<nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
    <div class="container">

        <!-- Image Logo -->
        <a class="navbar-brand logo-image" href="{{ url('mahasiswa') }}">IISMEE</a>

        <!-- Toggler -->
        <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <!-- Menu Navigation (Center) -->
            <ul class="navbar-nav mx-auto navbar-nav-scroll">
                <li class="nav-item">
                    <a class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}" aria-current="page"
                        href="{{ url('mahasiswa') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $title == 'Magang' ? 'active' : '' }}" href="{{ url('magang') }}">Magang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $title == 'Logbook' ? 'active' : '' }}"
                        href="{{ url('logbook') }}">Logbook</a>
                </li>
            </ul>

            <!-- User Dropdown (Right) -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-user"></i>
                        <span class="d-sm-inline d-none">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ url('profile') }}-user">
                                <i class="fas fa-user fa-sm me-2"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('gantiPassword') }}">
                                <i class="fas fa-key fa-sm me-2"></i> Ubah Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ url('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt fa-sm me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div> <!-- end of navbar-collapse -->
    </div> <!-- end of container -->
</nav> <!-- end of navbar -->

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mencegah dropdown tertutup saat klik isi dropdown
            document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });
    </script>
@endpush