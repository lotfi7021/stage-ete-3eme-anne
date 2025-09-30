@extends('front.app')

@Push('css') 

@endpush

@section('content')



    <!-- Page title start-->
    <div class="page-title-area pb-100 bg-img bg-s-cover" data-bg-image="{{asset('images/banners/hero-banner-3.jpg')}}">
        <div class="container">
            <div class="content">
                <h2>{{ $titleBreadcrumbs }}</h2>
                <ul class="list-unstyled">
                    <li class="d-inline"><a href="{{ url('/')}}">Accueil</a></li>
                    <li class="d-inline">/</li>
                    <li class="d-inline active opacity-75">{{ $titleBreadcrumbs }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page title end-->

    <!-- Faq-area start -->
    <div class="faq-area pt-100 pb-70">
        <div class="container">
            <div class="accordion" id="faqAccordion">
                <div class="row justify-content-center">
                    <div class="col-lg-8" data-aos="fade-up">

                    @foreach ($faq as $key =>$listfaq )

                    <div class="accordion-item radius-0 mb-30">
                            <h6 class="accordion-header" id="heading{{ $key+1 }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key+1 }}" aria-expanded="true"
                                    aria-controls="collapse{{ $key+1 }}">
                                    {{ $key+1 }}. {{ $listfaq->question }}
                                </button>
                            </h6>
                            <div id="collapse{{ $key+1 }}" class="accordion-collapse collapse  @if ($key+1 == 1) show  @endif"
                                aria-labelledby="heading{{ $key+1 }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                    {!! $listfaq->reponse !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                        
                        
                        
                        
                       
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq-area end -->


 

@stop

@Push('js')

@endpush