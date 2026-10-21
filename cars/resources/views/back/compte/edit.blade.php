@extends('back.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Modifier un livreur</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.list_livreur') }}">Livreurs</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier le livreur</h3>
                        </div>
                        <div class="card-body">
                            @if(session()->get('success'))
                                <div class="alert alert-success">{{ session()->get('success') }}</div>
                            @endif
                            @if(session()->get('danger'))
                                <div class="alert alert-danger">{{ session()->get('danger') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form name="update" method="POST" action="{{ route('admin.list_livreur.update', $admin->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $admin->nom) }}" onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres." required>
                                            @error('nom')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="prenom">Prénom</label>
                                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $admin->prenom) }}" onkeypress="return validateAlphabets(event);" pattern="[A-Za-zÀ-ÿ\s]+" title="Le prénom doit contenir uniquement des lettres." required>
                                            @error('prenom')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="telephone">Téléphone</label>
                                            <input type="number" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $admin->telephone) }}" min="10000000" max="99999999"
                                                oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);"
                                                title="Le numéro de téléphone doit contenir exactement 8 chiffres." required>
                                            @error('telephone')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="region">Région</label>
                                            <input type="text" class="form-control" id="region" name="region" value="{{ old('region', $admin->region) }}" required>
                                            @error('region')<div class="alert alert-danger mt-1">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="login">Nom d'utilisateur</label>
                                            <input type="text" class="form-control" id="login" value="{{ $admin->login }}" disabled>
                                            <small class="text-muted">Le nom d'utilisateur ne peut pas être modifié ici.</small>
                                        </div>

                                        <button class="btn btn-primary btn-sm" type="submit">Modifier le livreur</button>
                                        <a href="{{ route('admin.list_livreur') }}" class="btn btn-secondary btn-sm">Annuler</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop

@Push('js')
<script>
    function validateAlphabets(event) {
        var char = String.fromCharCode(event.which);
        if (!char.match(/[a-zA-Z]/)) {
            event.preventDefault();
        }
    }
</script>
@endpush
