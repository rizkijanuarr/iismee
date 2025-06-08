<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Your description">
    <meta name="author" content="Your name">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta name="twitter:card" content="summary_large_image"> <!-- to have large image post format in Twitter -->

    <!-- Webpage Title -->
    <title>IISMEE | {{ $title }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/styles.css') }}" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="images/favicon.png">
</head>

<body data-bs-spy="scroll" data-bs-target="#navbarExample">

    @include('components.navbar-user')


    @yield('konten')


    <!-- Footer -->
    {{-- @include('components.footer-user') --}}


    <!-- Back To Top Button -->
    <button onclick="topFunction()" id="myBtn">
        <img src="{{ URL::asset('/img/up-arrow.png') }}" alt="alternative">
    </button>
    <!-- end of back to top button -->

    <!-- Scripts -->
    <script src="{{ URL::asset('/js/bootstrap.min.js') }}"></script> <!-- Bootstrap framework -->
    <script src="{{ URL::asset('/js/swiper.min.js') }}"></script> <!-- Swiper for image and text sliders -->
    <script src="{{ URL::asset('/js/purecounter.min.js') }}"></script> <!-- Purecounter counter for statistics numbers -->
    <script src="{{ URL::asset('/js/isotope.pkgd.min.js') }}"></script> <!-- Isotope for filter -->
    <script src="{{ URL::asset('/js/scripts.js') }}"></script> <!-- Custom scripts -->
    @stack('script')
</body>

</html>
