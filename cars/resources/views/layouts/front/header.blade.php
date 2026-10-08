  <!-- Header-area start -->
  <header class="header-area header-1" data-aos="slide-down">
        <!-- Start mobile menu -->
        <div class="mobile-menu">
            <div class="container">
                <div class="mobile-menu-wrapper"></div>
            </div>
        </div>
        <!-- End mobile menu -->

        <div class="main-responsive-nav">
            <div class="container">
                <!-- Mobile Logo -->
                <div class="logo">
                    <a href="{{ url('/')}}">
                        <img src="{{asset('assets/front/images/logo/logo.png')}}" alt="logo">
                    </a>
                </div>
                <!-- Menu toggle button -->
                <button class="menu-toggler" type="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <div class="main-navbar">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <!-- Logo -->
                    <a class="navbar-brand" href="{{ url('/')}}">
                        <img src="{{asset('assets/front/images/logo/logo-header.png')}}"  width="70" height="70" alt="Logo">
                    </a>
                    <!-- Navigation items -->
                    <div class="collapse navbar-collapse">
                        <ul id="mainMenu" class="navbar-nav mobile-item mx-auto">
                            <li class="nav-item">
                                <a href="{{ url('/')}}" class="nav-link">Accueil</a>
                               
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('faq')}}">FAQ et politique de vente</a>
                                
                            </li>
                           
                            
                          
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('contact.us.add')}}">Contact</a>
                            </li>

                         
                        </ul>
                    </div>
                    <div class="more-option mobile-item">
                       
                        <!--<div class="item">
                            <a href="" class="btn-icon">
                                <i class="far fa-user-circle"></i>
                            </a>
                        </div>-->

                        <div class="item">
                            <button type="button" class="btn-icon rm-theme-toggle" aria-label="Basculer le thème clair / sombre" title="Thème clair / sombre">
                                <i class="fal fa-moon"></i>
                            </button>
                        </div>
                       
                        <div class="item">
                            <a href="{{route('login.form')}}" class="btn btn-md btn-primary" title="login" target="_self">login  </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- Header-area end -->
