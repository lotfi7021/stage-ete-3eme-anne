
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
            <h1>Gestion des machine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Gestion des machine</li>
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
                <h3 class="card-title">Modifier la machine</h3>
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
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form name="update" method="POST" action="{{ route('admin.list_machine.update',$gestion_machine->id)}}"  enctype="multipart/form-data">
            {{method_field('post')}}
        {{csrf_field()}}

            <div class="row">
              <div class="col-md-8">
                            <div class="form-group">
                                <label for="reference">Référence de Produit</label>
                                <input type="text" class="form-control" id="reference" placeholder="" name="reference" value="{{$gestion_machine->reference}}"><div id="referenceStatus" style="color:red;"></div>
                                @error('reference')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="titre">Titre de produit</label>
                                <input type="text" class="form-control" id="titre" placeholder="" name="titre"  value="{{$gestion_machine->titre}}">
                                 @error('titre')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Déscription</label>
                                <textarea class="" id="description" name="description">{{$gestion_machine->description}}</textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image1">Image 1</label>
                               <input type="file" name="image1" class="form-control" id="image1">
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                         


                            <button class="btn btn-primary btn-sm"  type="submit">Modifier</button>
                    </div>
                    

                <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                               

                                <div class="form-group">
                                <label for="prix">Prix</label>
                                <div class="input-group">
                                
                                        <input type="number" class="form-control" name="prix" id="prix" value="{{ $gestion_machine->prix }}"    min="1" step="0.01" placeholder="prix"
           oninput="validity.valid||(value='');"
           title="Le prix doit être un nombre positif.">
                                        <div class="input-group-append">
                                            <span class="input-group-text">DT</span>
                                        </div>
                                </div>
                                @error('prix')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                        
                        <div class="form-group">
                                <label for="qte">Ajouter quantité au stock</label>
                               
                                
                                        <input type="number" class="form-control" required name="qte" id="qte" value=0    min="0" step="1" placeholder="Quantité"
           oninput="validity.valid||(value='');"
           title="La quantité doit être un nombre positif.">
                                       
                               
                                @error('qte')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            
                 
                        <div class="form-group">
                                                <label for="marque_machine">Marque</label>
                                                <select name="marque_id" class="form-control" id="marque_machine">
                                                <option value=''>...</option>
                                                   @foreach ($marque_machine as $list_marque )
                                                   <option value="{{ $list_marque->id}}" {{$gestion_machine->marque_id == $list_marque->id  ? 'selected' : ''}}>{{ $list_marque->titre}}</option>
                                                       
                                                   @endforeach
                                                </select>
                                @error('marque_machine')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div> 

                                <div class="form-group">
                                                <label for="marque_machine">Modele</label>
                                                <select name="model_id" class="form-control" id="model_machine">
                                                <option value=''>...</option>
                                                   @foreach ($model_machine as $list_model )
                                                   <option value="{{ $list_model->id}}" {{$gestion_machine->model_id == $list_model->id  ? 'selected' : ''}}>{{ $list_model->titre}}</option>
                                                       
                                                   @endforeach
                                                </select>
                                @error('model_machine')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div> 
                      </div> </div>

          
            </form>

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
            </div>
            </div>
</section>
</div>



            

@stop

@Push('js')

<script type="text/javascript">
$(document).on('input','#reference',function(e){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let referenceInput = $('#reference').val();
 
    $.ajax({
        method:"POST",
        url: "{{route('admin.checkreference')}}",
        data:{reference:referenceInput},
        success: function(data){
          
          $('#referenceStatus').html(data);
        }
      });

});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
        </script>

<script type="text/javascript">
    $(document).ready(function ()
    {
        
        $('select[name="marque_id"]').on('change',function(){
           
            var marqueID = $(this).val();
            if(marqueID){
                $.ajax({
                    url: '/getModels/'+marqueID,
                    type: "GET",
                    dataType:"json",
                    success:function(data)
                {
                    if(data.length != 0){
                      $('#showmodel').show();
                    $('select[name="model"]').empty();
                    
                    $.each(data, function(key,value){
                        console.log(value);

                        $('select[name="model"]').append('<option value="'+value+'">'+value+'</option>');
                    });
                   
                    }
                    else{
                        $('#showmodel').hide();
                    }
                    
                    
                }

                });
            }
            else {
                $('select[name="model"]').empty();
               
            }
        });

        



       


    });
    
</script>

@endpush
