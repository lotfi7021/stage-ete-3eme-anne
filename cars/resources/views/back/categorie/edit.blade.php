
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
            <h1>Gestion des prix</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Gestion des prix</li>
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
                <h3 class="card-title">Ajouter les prix {{ $titleSeo}}</h3>
              </div>
             
              <!-- /.card-header -->
              <div class="card-body">
              @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->get('danger'))
                    <div class="alert alert-danger">
                        {{ session()->get('danger') }}
                    </div>
                @endif
            <form name="update" method="POST" action="{{ route('admin.list_categories.update',$categorie->id)}}"  enctype="multipart/form-data">
            {{method_field('post')}}
        {{csrf_field()}}
        <input type='hidden' name='categorie_id' value='{{$categorie->id}}'>
            <div class="row">
                <div class="col-md-8">
               
                           
                            <div class="form-group">
                                <label for="titre">Titre de catégorie</label>
                                <input type="text" class="form-control" id="titre" placeholder="" name="titre"  value="{{$categorie->titre}}">
                                 @error('titre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @php
                        $if_exist = App\Models\Gestion_pri::where('categorie_id',$categorie->id)->get();

                        @endphp
                        @if($if_exist->count()!=null)

                       
                            <table class="table table-responsive table-bordred">
                           <thead> 
                           <tr>
                            <td>#</td>
                             <td>Produit</td>
                             <td>Prix</td>
                            </tr> 
                            </thead>
                            <tbody>
                             @php 
                             $i=0;
                             $liste_produit = App\Models\Produit::where("status",1)->get();
                             @endphp
                             
                             @foreach($liste_produit as $liste)
                             @php $i++; @endphp


                             @php 
                             $prix_afficher=0;
                              $if_exist = App\Models\Gestion_pri::where('produit_id',$liste->id)->where('categorie_id',$categorie->id)->get();
                              @endphp
                            
                              @if($if_exist->count()!=0)

                                      @php
                                      $prix= App\Models\Gestion_pri::where('produit_id',$liste->id)->where('categorie_id',$categorie->id)->first();
                                    $prix_afficher= $prix->prix;
                                   $id_table = $prix->id;            
                                      @endphp 

                              @else
                              @php
                              $id_table = 0;
                              @endphp
                              

                              @endif
                           
                             <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $liste->titre }}
                              <input type='hidden' name='id_categorie[]' value='{{$categorie->id}}'>
                              <input type='hidden' name='id[]' value='{{$id_table}}'></td>
                                <input type='hidden' name='produit_id[]' value='{{ $liste->id }}'></td>
                              <td><input type="number" min=0 max=999999  step="0.01" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="prix[]" class="form-control" value="{{$prix_afficher}}" title="Le prix doit contenir uniquement des chiffre et maximum 6 nombre et 2 num apres vergule."required></td>
                             </tr>
                             @endforeach
                            </tbody>
                           </table>
                           @else
                           <a href="{{route('admin.list_prix.add')}}" class="btn btn-sm btn-default">Ajouter des prix</a><br><br><br>
                           @endif

                            <button class="btn btn-primary btn-sm"  type="submit">Ajouter prix</button>
                    </div>
                    

               
            </div>    
                               

            </form>
             
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
            </div>
            </div>
</section>
</div>



            

@stop

@Push('js')



@endpush
