 <!-- Navigation -->
 <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
     <div class="container">

         <!-- Image Logo -->
         <a class="navbar-brand logo-image" href="{{ url('mahasiswa') }}">IISMEE</a>

         <!-- Text Logo - Use this if you don't have a graphic logo -->
         <!-- <a class="navbar-brand logo-text" href="index.html">Zinc</a> -->

         <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse"
             aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
             <ul class="navbar-nav ms-auto me-auto navbar-nav-scroll">
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
             <span class="navbar-nav nav-item">
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                         aria-expanded="false">
                         <i class="fa fa-user"></i>
                         <span class="d-sm-inline d-none"> {{ auth()->user()->name }}</span>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end">
                         <li>
                             <a class="dropdown-item" href="{{ url('profile') }}-user">
                                 <i class="fas fa-user fa-sm me-2"></i>Profil
                             </a>
                         </li>
                         <li>
                             <a class="dropdown-item" href="{{ url('gantiPassword') }}">
                                 <i class="fas fa-key fa-sm me-2"></i>Ubah Password
                             </a>
                         </li>
                         <hr>
                         <li>
                             <form action="{{ url('logout') }}" method="POST">
                                 @csrf
                                 <button type="submit" class="dropdown-item">
                                     <i class="fas fa-sign-out-alt fa-sm me-2"></i>Logout
                                 </button>
                             </form>
                         </li>
                     </ul>
                 </li>
             </span>
         </div> <!-- end of navbar-collapse -->
     </div> <!-- end of container -->
 </nav> <!-- end of navbar -->
 <!-- end of navigation -->
