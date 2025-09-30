
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('#')}}" class="brand-link">
      <img src="{{asset('assets/back/img/avatar5.png')}}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">
        
      @php
      $admin = App\Models\Admin::where('id',session('user'))->first();

      @endphp
          @if(Auth::guard('admin')->check() &&  $admin->role=='admin')
        Administrateur
        @elseif(Auth::guard('admin')->check() && $admin->role=='client')
        Client
        @elseif(Auth::guard('admin')->check() && $admin->role=='livreur')
        Livreur
        @endif  
      </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/back/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ $admin->nom }}</a>
          <a href="{{ route('logoutSession') }}" style="color:red;"><i class="fas fa-sign-out-alt"></i> Déconnecter</a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    
          @if($admin->role=="admin")

          <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'menu-open' : '' }} ">
            <a href="{{route('dashboard')}}" class="nav-link  {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>  Tableau de bord  </p>
              </a>       
          </li>



          <li class="nav-item  {{ (request()->is('admin/list_produit') || (request()->is('admin/list_categories')) || (request()->is('admin/list_marques'))  || (request()->is('admin/list_modeles')) ) ? 'menu-open' : '' }}">
          

         

             

            <!--- Inventaires produit--------->
            <li class="nav-item {{ (request()->is('admin/list_vendues') || request()->is('admin/list_disponibles')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
        stock   <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           

        
              <li class="nav-item">
                <a href="{{route('admin.list_stock.machine')}}" class="nav-link {{ (request()->is('admin/list_stock/machine')) ? 'active' : '' }}">    
                  <p>Mouvement de Stock </p>
                </a>
              </li>
          </ul>
     

          <li class="nav-item  {{ (request()->is('admin/list_machine') || (request()->is('admin/list_categories'))  || (request()->is('admin/list_marques'))  || (request()->is('admin/list_modeles')) ) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('admin/list_machine')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-hot-tub	"></i>
                               <p>Liste des produits </p>

            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item ">
                <a href="{{route('admin.list_machine')}}" class="nav-link {{ (request()->is('admin/list_machine')) ? 'active' : '' }}">
                  
                  <p>Liste des pièces</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('list_marque.machine')}}" class="nav-link {{ (request()->is('admin/list_marque')) ? 'active' : '' }}">
                
                  <p>Marques</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('list_model.machine')}}" class="nav-link {{ (request()->is('admin/list_model')) ? 'active' : '' }}">
                
                  <p>Modele</p>
                </a>
              </li>
              </ul>

 

    
            
            
             
       


  <li class="nav-item">

              <a href="{{route('admin.list_commandeM')}}" class="nav-link   {{ (request()->is('admin/support')) ? 'active' : '' }}">  
                <i style="font-size:21px" class="fa">&#xf007;</i>

                <p>Liste des commande</p>
              </a>
          </li>






      

   <li class="nav-item">

              <a href="{{route('admin.list_client')}}" class="nav-link   {{ (request()->is('admin/support')) ? 'active' : '' }}">  
                <i style="font-size:21px" class="fa">&#xf007;</i>

                <p>Gestion Client</p>
              </a>
          </li>




           





          <li class="nav-item">

              <a href="{{route('admin.list_support')}}" class="nav-link   {{ (request()->is('admin/support')) ? 'active' : '' }}">  
                <i class="nav-icon fa fa-calendar"></i>
                <p>Supports</p>
              </a>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
              création des comptes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('compte')}}" class="nav-link">
                 <i class="nav-icon fa fa-cog"></i>
               <p>liste des comptes</p>
              </a>
          </li> 
      
            </ul>
            


          <li class="nav-item {{ (request()->is('admin/list_faq')) ? 'active' : '' }}">
          
              <a href="{{route('admin.list_faq')}}" class="nav-link  {{ (request()->is('admin/list_faq')) ? 'active' : '' }}">
                <i class="nav-icon fa fa-question-circle" title="Foire Aux Questions"></i>
                   <p>FAQ's</p>
              </a>
          </li>

          <li class="nav-item {{ (request()->is('admin/list_banners')) ? 'active' : '' }}">
              <a href="{{route('admin.list_banners')}}" class="nav-link {{ (request()->is('admin/list_banners')) ? 'active' : '' }}">
                <i class="nav-icon fa fa-photo-video"></i>
               <p> Banniéres</p>
              </a>
          </li>


          <li class="nav-item {{ (request()->is('list_contact')) ? 'active' : '' }}">
              <a href="{{route('list_contact')}}" class="nav-link {{ (request()->is('list_contact')) ? 'active' : '' }}">
                <i class="nav-icon fa fa-phone"></i>
               <p> contact</p>
              </a>
          </li>
      </li>
        </ul>
      </nav>




      @else($admin->role=="client")

    

          <li class="nav-item  {{ (request()->is('admin/list_commandeM')  ) ? 'menu-open' : '' }}">
            <a href="{{route('client.list_machine')}}" class="nav-link {{ (request()->is('admin/list_commande')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-paper-plane"></i>
              <p>listes des pièce 
              </p>
            </a>
          </li>



         
          @endif



         



          
    @if($admin->groupe != 0)
          <li class="nav-item  {{ (request()->is('admin/list_commandeM')  ) ? 'menu-open' : '' }}">
            <a href="{{route('admin.list_commandeM')}}" class="nav-link {{ (request()->is('admin/list_commande')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-paper-plane"></i>
              <p>Commande 
              </p>
            </a>
          </li>
          @endif



       


    </div>
  </aside>