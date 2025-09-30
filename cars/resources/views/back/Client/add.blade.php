
@extends('back.app')

@Push('css') 
     <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.css')}}">

@endpush

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion des clients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Gestion des clients</li>
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
                <h3 class="card-title">Ajouter client</h3>
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
                <form name="add" method="POST" action="{{ route('admin.store_client')}}"  enctype="multipart/form-data">
            @method('POST')
            @csrf

            <div class="row">
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                   
             
       <div class="form-group">
    <label for="nom">Nom</label>
    <input type="text" class="form-control" id="nom" placeholder="" name="nom" value="{{ old('nom') }}" onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres."
    required>
    @error('nom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

                            <div class="form-group">
                                <label for="prenom">Prenom</label>
                                <input type="text" class="form-control" id="prenom" placeholder="" name="prenom"  value="{{old('prenom')}} " onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres."required>
                                 @error('prenom')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        


                            <div class="form-group">
                                <label for="login">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="login" placeholder="" name="login"  value="">
                                 @error('login')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
    <label for="password">Nouveau mot de passe</label>
    <input type="password" class="form-control" id="password" name="password" title="Le mot de passe doit contenir letters numbers symbols min(8)" value="">
    <input type="checkbox" id="showPassword" onclick="togglePassword()"> Afficher le mot de passe
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
                            <div class="form-group">
                                <label for="nom_de_la_societe">nom_de_la_societe</label>
                                <input type="nom_de_la_societe" class="form-control" id="nom_de_la_societe" placeholder="" name="nom_de_la_societe"  value="{{old('nom_de_la_societe')}}">
                                 @error('nom_de_la_societe')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label for="code_TVA">code_TVA</label>
                               <input type="text" name="code_TVA" class="form-control" id="code_TVA" placeholder="" value="{{old('code_TVA')}}">
                                @error('code_TVA')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                               <input type="text" name="adresse" class="form-control" id="adresse" placeholder="" value="{{old('adresse')}}">
                                @error('adresse')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                         
                            <div class="form-group">
    <label for="telephone">Téléphone</label>
    <input type="number" class="form-control" id="telephone" name="telephone"
           placeholder="" value="{{ old('telephone') }}"
           min="10000000" max="99999999"
           oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);"
           title="Le numéro de téléphone doit contenir exactement 8 chiffres.">
    @error('telephone')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                               <input type="email" name="Email" class="form-control" id="Email" placeholder="" value="{{old('Email')}}"  title=" email doit contenir 'jjjjj@exemple.com' "required>
                                @error('Email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                           


                            <button class="btn btn-primary btn-sm"  type="submit">Ajouter</button>
                    </div>
                </div>
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
<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        var showPassword = document.getElementById('showPassword');
        if (showPassword.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
</script>


@Push('js')

@endpush
