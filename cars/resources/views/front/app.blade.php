<!DOCTYPE html>
<html lang="fr_FR">

<head>

 

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="lotfi">

       <!-- Site Title -->
       <title>{{ $titleSeo }}</title>
       <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Anti-FOUC : applique le thème (localStorage > OS) avant le premier paint --}}
    <script>(function(){try{var s=localStorage.getItem('rm-theme');var d=s?s==='dark':window.matchMedia('(prefers-color-scheme: dark)').matches;document.documentElement.setAttribute('data-theme',d?'dark':'light');}catch(e){}})();</script>
    <link rel="shortcut icon" href="{{ asset('assets/front/images/logo/fav.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/bootstrap.min.css') }}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/fonts/fontawesome/css/all.min.css') }}">
    <!-- Icomoon Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/fonts/icomoon/style.css') }}">
    <!-- NoUi Range Slider -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/nouislider.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/magnific-popup.min.css') }}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/swiper-bundle.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/nice-select.css') }}">
    <!-- AOS Animation CSS-->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/aos.min.css') }}"> 
 
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors/animate.min.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
    @stack('css') 
    <!-- Red Motorsport : tokens partagés puis thème front (chargés en dernier = autorité de cascade) -->
    <link rel="stylesheet" href="{{ asset('assets/css/rm-tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/rm-front.css') }}">
</head>
  






<body class="theme-color-1">
   <!-- Start preloader -->
  <div id="preLoader">
        <div class="loader"></div>
  </div>
    @include('layouts/front/header')
    @yield('content')
    @include('layouts/front/footer') 
  
    <!-- Go to Top -->
    <div class="go-top"><i class="fal fa-angle-up"></i></div>
    <!-- Go to Top -->

    <!-- Jquery JS -->
    <script src="{{asset('assets/front/js/vendors/jquery.min.js') }}"  type="text/javascript"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('assets/front/js/vendors/bootstrap.min.js') }}"  type="text/javascript"></script>
    <!-- Counter JS -->
    <script src="{{asset('assets/front/js/vendors/jquery.counterup.min.js') }}"  type="text/javascript"></script>
    <!-- Nice Select JS -->
    <script src="{{asset('assets/front/js/vendors/jquery.nice-select.min.js') }}" type="text/javascript"></script>
    <!-- Magnific Popup JS -->
    <script src="{{asset('assets/front/js/vendors/jquery.magnific-popup.min.js') }}"  type="text/javascript"></script>
    <!-- Swiper Slider JS -->
    <script src="{{asset('assets/front/js/vendors/swiper-bundle.min.js') }}"  type="text/javascript"></script>
    <!-- Lazysizes -->
    <script src="{{asset('assets/front/js/vendors/lazysizes.min.js') }}"  type="text/javascript"></script>
    <!-- Noui Range Slider JS -->
    <script src="{{asset('assets/front/js/vendors/nouislider.min.js') }}" type="text/javascript"></script>
    <!-- AOS JS -->
    <script src="{{asset('assets/front/js/vendors/aos.min.js') }}" type="text/javascript"></script>
    
    <!-- Mouse Hover JS -->
    <script src="{{asset('assets/front/js/vendors/mouse-hover-move.js') }}" type="text/javascript"></script>
    <!-- Main script JS -->
    <script src="{{asset('assets/front/js/script.js') }}"  type="text/javascript"></script>
    
    <!-- Bascule de thème (clair / sombre) -->
    <script src="{{ asset('assets/js/rm-theme.js') }}"></script>
    @stack('js')
  
</body>

</html>