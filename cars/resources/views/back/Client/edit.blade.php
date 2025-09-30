
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
            <h1>modifier clients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">modifier clients</li>
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
                <h3 class="card-title"> Modifier votre Client</h3>
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

            <form name="update" method="POST" action="{{ route('admin.list_client.update',$client->id)}}"  enctype="multipart/form-data">
            {{method_field('post')}}
        {{csrf_field()}}

            <div class="row">
                <div class="col-md-8">
        
                            <div class="form-group">
                                <label for="nom"> nom</label>
                                <input type="text" class="form-control" id="nom" placeholder="" name="nom"  value="{{$client->nom}}" onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres."required>
                                 @error('nom')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="prenom">prenom</label>
                               <input type="text" name="prenom" class="form-control" id="prenom "  value="{{$client->prenom}}" onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres."required>
                                @error('prenom')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                         


                            <div class="form-group">
                                <label for="login">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="login" placeholder="" name="login"  value="{{$client->login}}">
                                 @error('login')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($client->password!='')
                                

                            @else
 <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" id="titre" placeholder="" name="password"  value="">
                                 
                            </div>
                            @endif
                           



                            <div class="form-group">
                                <label for="nom_de_la_societe">nom_de_la_societe</label>
                               <input type="text" name="nom_de_la_societe" class="form-control" id="nom_de_la_societe" value="{{$client->nom_de_la_societe}}">
                                @error('nom_de_la_societe')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="code_TVA">code_TVA</label>
                               <input type="text" name="code_TVA" class="form-control" id="code_TVA" value="{{$client->code_TVA}}">
                                @error('code_TVA')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="adresse">adresse</label>
                               <input type="text" name="adresse" class="form-control" id="adresse" value="{{$client->adresse}}">
                                @error('adresse')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telephone">telephone</label>
                               <input type="number" name="telephone" class="form-control" id="telephone" value="{{$client->telephone}}"  min="10000000" max="99999999"
         oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);"
           title="Le numéro de téléphone doit contenir exactement 8 chiffres.">
                                @error('telephone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                               <input type="email" name="Email" class="form-control" id="Email" value="{{$client->Email}}"  title="email doit contenir 'jjjjj@exemple.com'"required>
                                @error('Email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                           
                           

                            <button class="btn btn-primary btn-sm"  type="submit">Modifier Clients</button>
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
</section>
</div>



            

@stop
<script>
    function validateAlphabets(event) {
        var char = String.fromCharCode(event.which);
        // Regex to allow only alphabetic characters
        if (!char.match(/[a-zA-Z]/)) {
            event.preventDefault();
        }
    }
</script>
@Push('js')



@endpush
