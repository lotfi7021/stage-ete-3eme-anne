@extends('back.app')

@section('content')
<img src="{{ asset('assets/back/img/background.webp') }}" alt="Background" class="background-image">

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            Connectez-vous pour démarrer votre session
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('error-message'))
                <p class="alert alert-info">{{ Session::get('error-message') }}</p>
            @endif

            <form action="{{ route('login.functionality') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="login" placeholder="Login">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe">


                    
<label>
  <input type="checkbox" onclick="togglePassword()"> 
</label>

<script>
  function togglePassword() {
    const passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
    } else {
      passwordField.type = 'password';
    }
  }
</script>          
            
    
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
        </div>
    </div>
</div>
@stop

@push('js')
@endpush
