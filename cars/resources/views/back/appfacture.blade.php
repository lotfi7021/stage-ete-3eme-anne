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


         <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/back/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/back/css/theleth.css') }}">


  

    @stack('css') 
</head>
  






<body  class="hold-transition @if (!Auth::guard('admin')->check()) login-page @endif">
 @if (Auth::guard('admin')->check())
      

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


    
    @stack('js')
  
</body>

</html>