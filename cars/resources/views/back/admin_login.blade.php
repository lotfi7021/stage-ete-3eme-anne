@extends('back.app')

@push('css')
<style>
/* Ensures the image covers the full screen and is fixed during scroll */
.background-image {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Places the image behind other content */
    object-fit: cover; /* Covers the full area without stretching the image */
}


.login-box {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    background-color: rgba(200, 200, 200, 0.3); /* Increased transparency */
    backdrop-filter: blur(5px); /* Stronger blur effect */
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 1, 5, 0.1);
    width: 360px;
    padding: 2rem;
}

.card-header {
    margin-bottom: 20px; /* Space below the header */
    font-size: 24px; /* Larger font size for the header */
    font-weight: bold; /* Bold font for the header */
}

.input-group {
    margin-bottom: 15px; /* Space below each input group */
}

.input-group-text {
    background-color: #ccc; /* Gray background for the icon */
    border: none; /* Remove border */
}

.form-control {
    border: 2px solid #ccc; /* Slightly thicker border with gray color */
}

.btn-primary {
    background-color: #d7b9b5ff; /* Rich red color */
    border-color: #bf908aff;
    width: 100%;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #a93226;
}

::placeholder {
    color: #bbb;
    opacity: 1;
}

/* Remove image and align text to center */
.login-box-msg {
    text-align: center;
    margin-bottom: 20px; /* Space before the form starts */
}

</style>
@endpush

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
