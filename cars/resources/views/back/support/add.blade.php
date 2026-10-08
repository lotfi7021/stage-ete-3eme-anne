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
            <h1>Support</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Listes Support</li>
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
                <h3 class="card-title">Ajouter Support</h3>
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
                @php
    $admin = App\Models\Admin::where('id', session('user'))->first();
    @endphp
            <form name="add" method="POST" action="{{ route('admin.list_support.store')}}"  enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row">
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                  
                  
        <h2>Créer une nouvelle demande</h2>
        <p>Utilisez ce formulaire pour créer une demande de travail pour votre équipe</p>

       
            <input type='hidden' name='id_client' value="{{ $admin->nom_de_la_societe }}">

            <div class="form-group">
                <label for="sujet">Sujet</label>
                <input type="text" id="sujet" name="sujet"  placeholder="Ce sera le nom de la tâche.">
                @error('sujet')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
            </div>

            <select name="support" class="form-group" id="support">
                <option value="">Support</option>
                <option value="commercial">Service Commerciale</option>
                <option value="technical">Service Technique</option>
            </select>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message"  placeholder="Ce qui doit être fait?"></textarea>
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

@Push('js')

@endpush
