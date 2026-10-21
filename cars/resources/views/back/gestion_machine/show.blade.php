
@extends('back.app')

@Push('css') 
     <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endpush

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des pièce</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Gestion des pièces</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Détail des pièces</h3>
              </div>
             
              <!-- /.card-header -->
              <div class="card-body">

              <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Prix</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ number_format($gestion_machine->prix,2)}} DT</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Nombre de visite</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $gestion_machine->viewer}}</span>
                    </div>
                  </div>
                </div>


                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Quantité</span>
                    </div>
                  </div>
                </div>
             
              </div>
              <div class="row">
                <div class="col-12">
                  <h4>Détail</h4>
                    <div class="post">
                      
                        {!! $gestion_machine->description !!}
                    
                    </div>

                    

                    
                </div>

              </div>
              <div class="row">
              <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Galeries</h4>
              </div>
              <div class="card-body">
                <div class="row">
                    @if (!is_null($gestion_machine->image1))
                    <div class="col-sm-2">
                    <a href="{{ url('../images/produits',$gestion_machine->image1) }}" data-toggle="lightbox" data-gallery="gallery">
                      <img src="{{ url('../images/produits',$gestion_machine->image1) }}" class="img-fluid mb-2"/>
                    </a>
                  </div>
                  @endif
         
                  
              

                

                </div>
              </div>
            </div>
         </div> 
        </div>   

            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
            <h6>Titre de l'annonce:</h6>  
            <h3 class="text-primary">{{$gestion_machine->titre}}</h3>
            <div class="row">
                <div class="col-md-6">
              <div class="text-muted">
                <p class="text-sm">Marque:
                  <b class="d-block">{{ $gestion_machine->marque->titre }}</b>
                </p>
            
              
             
              </div>
            </div>
             
            </div>

              
            </div>

            


          </div>

  
            </div>
            </div>
            </div>
            </div>
            </div>
</section>
</div>



            

@stop

@Push('js')
<script src="{{asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

  })
</script>

@endpush
