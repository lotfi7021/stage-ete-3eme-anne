@extends('back.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modifier la catégorie</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Modifier la catégorie</li>
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
                <h3 class="card-title">Catégorie : {{ $titleSeo }}</h3>
              </div>

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

                <form name="update" method="POST" action="{{ route('admin.list_categories.update', $categorie->id) }}">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="titre">Titre de catégorie</label>
                        <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre', $categorie->titre) }}">
                        @error('titre')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary btn-sm" type="submit">Enregistrer</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@stop
