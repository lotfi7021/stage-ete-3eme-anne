
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
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin')}}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Gestion des stock</li>
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
                <h3 class="card-title">Modifier Stock machine</h3>
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


            <form name="add" method="POST" action="{{ route('admin.list_stock.machine.update',$stock->id)}}"  enctype="multipart/form-data">
            @method('POST')
            @csrf
      

            <div class="row">
                <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                  
                    
                    <div class="form-group">
                    
                          
                            <div class="form-group row">
                             <div class="col-md-4"> <label for="{{$stock->qte_initial}}">qte_initial</label></div>
                             <div class="col-md-3">
      
                             <input type="number" id='qte_initial' min=0 max=999999 value="{{$stock->qte_initial}}" class=" form-control" id="qte_initial" name="qte_initial" title="Le nom doit contenir uniquement des chiffre et maximum 999999 article."required></div>
                          @error('qte_initial')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                               
                            </div>
              
                            <div class="form-group row">
                             <div class="col-md-4"> <label for="{{$stock->mouvement}}">Mouvement</label></div>
                             <div class="col-md-3">
      
                             <input type="number" id='mouvement' min=0 max=999999 value="{{$stock->mouvement}}" class=" form-control" id="mouvement" name="mouvement" title="Le nom doit contenir uniquement des chiffre et maximum 999999 article."required></div>
                          @error('mouvement')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                               
                            </div>
              
                            <div class="form-group row">
                             <div class="col-md-4"> <label for="{{$stock->qte_final}}">qte_final</label></div>
                             <div class="col-md-3">
      
                             <input type="number" id='qte_final' min=0 max=999999 value="{{$stock->qte_final}}" class=" form-control" id="qte_final" name="qte_final" title="Le nom doit contenir uniquement des chiffre et maximum 999999 article."required></div>
                          @error('qte_final')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                               
                            </div>
              

                           
                           


                            <button class="btn btn-primary btn-sm"  type="submit">Modifier</button>
                
                               

            </form>
             
    
</section>
</div>


@stop
@Push('js')
@endpush
