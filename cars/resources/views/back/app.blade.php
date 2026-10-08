<!DOCTYPE html>
<html lang="fr_FR">

<head>

 

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Hatem Dridi">

       <!-- Site Title -->
       <title>{{ $titleSeo }}</title>
       <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Anti-FOUC : applique le thème (localStorage > OS) avant le premier paint --}}
    <script>(function(){try{var s=localStorage.getItem('rm-theme');var d=s?s==='dark':window.matchMedia('(prefers-color-scheme: dark)').matches;document.documentElement.setAttribute('data-theme',d?'dark':'light');}catch(e){}})();</script>


         <!-- Google Font: Source Sans Pro + Oswald (titres Red Motorsport) -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style (AdminLTE 3 / Bootstrap 4 : seule coquille) -->
  <link rel="stylesheet" href="{{ asset('assets/back/css/adminlte.min.css') }}">


  

    @stack('css') 
    <!-- Red Motorsport : tokens partagés puis thème back (chargés en dernier = autorité de cascade) -->
    <link rel="stylesheet" href="{{ asset('assets/css/rm-tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back/css/rm-back.css') }}">
</head>
  






<body  class="hold-transition @if (!Auth::guard('admin')->check()) login-page @else sidebar-mini layout-fixed @endif">
 <script>if(document.documentElement.getAttribute('data-theme')==='dark'){document.body.classList.add('dark-mode');}</script>
 @if (Auth::guard('admin')->check())
        @include('layouts/back/header')
        @include('back.sidebar')

 @endif

    @yield('content')


    @if (Auth::guard('admin')->check())
    @endif



    <!-- jQuery -->
<script src="{{asset('assets/back/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/back/js/adminlte.min.js') }}"></script>


    
    <!-- Bascule de thème (clair / sombre) -->
    <script src="{{ asset('assets/js/rm-theme.js') }}"></script>
    @stack('js')
  
</body>

</html>