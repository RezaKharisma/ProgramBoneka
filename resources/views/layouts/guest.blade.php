<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $title ?? 'NO TITLE!' }} | {{ getJudul() }}</title>
    <meta :content="getDeskripsi()" name="description">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('logo/'.getFavicon()) }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/guest/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/guest/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/guest/css/style.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    @php
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
    @endphp

    @include('sweetalert::alert')

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1><a href="{{ route('guest') }}">{{ getJudul() }}</a></h1>
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto {{ request()->is('/') ? 'active' : '' }}" href="{{ route('guest') }}">Home</a></li>
                <li><a class="nav-link scrollto {{ request()->is('pesan') ? 'active' : '' }}" href="{{ route('guest.pesan') }}">Pesan</a></li>
                <li>
                    @if (Auth::check())
                        <a class="btn btn-primary scrollto" href="{{ route('dashboard') }}" style="color: white">Kembali ke dashboard</a>
                    @else
                        <a class="btn btn-primary scrollto" href="{{ route('login') }}" target="_blank"  style="color: white">Login</a>
                    @endif
                </li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    @yield('header')

    <main id="main">
        {{ $slot }}
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <h3>{{ getJudul() }}</h3>
            <p>{{ getDeskripsiPerusahaan() }}</p>
            <div class="social-links">
                {!! getSocMedPerusahaan('facebook') !!}
                {!! getSocMedPerusahaan('instagram') !!}
                {!! getSocMedPerusahaan('x') !!}
            </div>
            <div class="copyright">
                &copy; Copyright <strong><span>{{ getJudul() }}</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/guest/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/guest/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/guest/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/guest/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/guest/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/numberOnly.js') }}"></script>
    <script src="{{ asset('assets/guest/js/main.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @stack('script')
</body>
</html>
