<div class="wrapper">



  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('assets/back/img/latino.webp') }}" alt="{{$titleSeo}}" height="150" width="150">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>
    <ul class="navbar-nav ml-auto">

    <!-- Right navbar links -->
  
      @php
      $admin = App\Models\Admin::where('id',session('user'))->first();

      @endphp    
        @if(Auth::guard('admin')->check() &&  $admin->role=='admin')
        @elseif(Auth::guard('admin')->check() && $admin->role=='client')
        @elseif(Auth::guard('admin')->check() && $admin->role=='livreur')
      @endif


      @if($admin->role=="admin")

<!-------------------   notification ta contact   --------------------->
      <!-- Navbar Search -->
      
      <li class="nav-item">
        <a href="{{ url('/')}}" target="_blank"  class="nav-link" title="Vers le site web"><i class='fa fa-globe'></i></a>
      </li>
<a class="nav-link" data-toggle="dropdown" href="#">
        <span class="far fa-comment">{{ $demande = \App\Models\Contact::count()}}</span>

        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ $demande = \App\Models\Contact::count()}} contact</span>
          <div class="dropdown-divider"></div>
          
         
          <div class="dropdown-divider"></div>
          <a href="{{route('list_contact')}}" class="dropdown-item dropdown-footer">Voir les contact</a>
        </div>
<!------------------- end   notification ta contact   --------------------->

      
       
      <!-- Notifications des tikets  -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="fa fa-ticket">{{ $demande = \App\Models\Support::count()}}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ $demande = \App\Models\Support::count()}} Tickets</span>
        <div class="dropdown-divider"></div>
          
         
        <div class="dropdown-divider"></div>
          <a href="{{route('admin.list_support')}}" class="dropdown-item dropdown-footer">Voir les Tickets</a>
        </div>
      <!-- END Notifications des tikets  -->




      </li>
          <a href="{{ route('cache.clear') }}" class="btn btn-warning">nettoyer le cache</a>
              <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
          </a>
      </li>
      
     



      
    </ul>
  </nav>

  <!-- /.Client -->
      @elseif($admin->role=="client")

      <!-- Navbar Search -->
      
      <li class="nav-item">
        <a href="{{ url('/')}}" target="_blank"  class="nav-link" title="Vers le site web"><i class='fa fa-globe'></i></a>
      </li>
      <div class="item">
         <a href="{{route('admin.list_support.add')}}" class="btn btn-danger" title="Service après vente" target="_self" >SAV </a>
       </div>
       

      
      

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>



 

   @elseif($admin->role=="livreur")

      <a href="{{ route('cache.clear') }}" class="btn btn-warning">nettoyer le cache</a>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
     
    </ul>
  </nav>
  @endif
  <!-- /.navbar -->