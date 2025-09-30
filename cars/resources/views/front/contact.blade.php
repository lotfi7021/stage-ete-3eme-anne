

@extends('front.app')

@Push('css') 

@endpush

@section('content')



    <!-- Page title start-->
    <div class="page-title-area pb-100 bg-img bg-s-cover" data-bg-image="{{asset('assets/front/images/contact.webp')}}" style="height:300px">
        <div class="container">
            <div class="content">
                <h2>{{ $titleSeo }}</h2>
                <ul class="list-unstyled">
                    <li class="d-inline"><a href="{{ url('/')}}">Accueil</a></li>
                    <li class="d-inline active opacity-75"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page title end-->
<!-- Contact-area start -->
<div class="contact-area pt-100">
        <div class="container">
           
          
            <div class="row gx-xl-5">

            <div class="col-md-6">
                     <div class="map" data-aos="fade-up">
                <!-- Background Image -->
            </div>
            </div>
            </div>

            <div class="pb-70"></div>
            <div class="row gx-xl-5">
                <div class="col-lg-6 mb-30" data-aos="fade-left">
                    <div class="content-title">
                       
                        <h3 class="mb-20">Vous avez une question,  ou un commentaire ?</h3>
                        <p class="mb-20">Nous sommes à votre écoute ! Pour toute question, réclamation ou commentaire, n'hésitez pas à nous contacter. Nous nous engageons à répondre à votre demande par email dans un délai maximum de 24 heures. Merci de remplir le formulaire de contact ci-dessous et nous vous assurons une réponse rapide et efficace. <br>Notre équipe s'engage à traiter chaque demande avec la plus grande attention.<br>
Merci de remplir le formulaire de contact, et nous vous assurons une réponse rapide et efficace.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 mb-30 order-lg-first" data-aos="fade-right">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success')  }}
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

               
                    <form   method="POST" action="{{ route('contact.us.store')}}"  id="contactUSForm">
                   
                        {{method_field('post')}}
        {{csrf_field()}}

                     
                          
        
                   <div class="col-md-6">
                                <div class="form-group mb-20">
                                    <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom')}}" placeholder="nom*" onkeypress="return validateAlphabets(event);"  pattern="[A-Za-zÀ-ÿ\s]+" title="Le nom doit contenir uniquement des lettres."required>

                                    @if($errors->has('nom'))
                                  <span class="text-danger">{{ $errors->first('nom')}}</span>
                                  @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group mb-20">
                                    <input type="text" name="sujet" class="form-control" id="sujet" value="{{ old('sujet')}}" placeholder="sujet*">
                                    @if($errors->has('sujet'))
                                  <span class="text-danger">{{ $errors->first('sujet')}}</span>
                                  @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-20">
                                    <input type="number" name="telephone" class="form-control" id="telephone" value="{{ old('telephone')}}" placeholder="telephone*"  min="10000000" max="99999999"
         oninput="if(this.value.length > 8) this.value = this.value.slice(0, 8);"
           title="Le numéro de téléphone doit contenir exactement 8 chiffres.">
                                    
                                    @if($errors->has('telephone'))
                                  <span class="text-danger">{{ $errors->first('telephone')}}</span>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-20">
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email')}}" placeholder="exemple@gmail.com">
                                    @if($errors->has('email'))
                                  <span class="text-danger">{{ $errors->first('sujet')}}</span>
                                  @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-primary" title="Envoyer">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pb-70"></div>

        </div>
        
    </div>
    <!-- Contact-area end -->
    @stop

@Push('js')
@endpush
