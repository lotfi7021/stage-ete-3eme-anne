
@extends('front.app')

@section('content') 


<div class="page-title-area pb-100 bg-img bg-s-cover" data-bg-image="{{asset('assets/front/images/echange.jpg')}}" style="height: 500px;" >
    <div class="overlay opacity-70"></div>
<div class="container">
            <div class="content">
            <h2></h2>
                <ul class="list-unstyled">
                    <li class="d-inline"><a href="{{ url('/')}}">Accueil</a></li>
                    <li class="d-inline">/</li>
                    <li class="d-inline active opacity-75"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page title end-->
<!-- car-list-area start -->
<div class="car-list-area pt-100 pb-60">
        <div class="container">
            <div class="row gx-xl-5">
           

                
                <div class="col-lg-12">
                    <div class="product-sort-area" data-aos="fade-up">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="mb-20">{{ $query->count() }}+ machines disponible</h4>
                            </div>
                           
                        </div>
                    </div>
                    <!-- Products -->
                    <div class="row">
                        @if($query->count() ==0 )
                            <div class="col-md-6" data-aos="fade-up">
                               <h4 class="mb-20"> Pas de resultat disponible</h4>
                            </div>
                        @endif
                            @foreach ($query as $listProduit)
                            <div class="col-xl-3 col-md-6" data-aos="fade-up">
                            <div class="product-default border p-10 mb-25">
                                <figure class="product-img mb-15">
                                
                                    <a href="{{ url('produit',$listProduit->reference,$listProduit->slug)}}" target="_self" title="Link" class="lazy-container ratio ratio-2-3">
                                    <img class="lazyload" src="{{asset('assets/front/images/placeholder.png')}}" data-src="{{url('/images/produits',$listProduit->image1)}}" alt="{{ $listProduit->titre }}">
                                    </a>
                                </figure>
                                <div class="product-details">
                                    <span class="product-category font-xsm">@php
                                        $marque = \App\Models\MarqueMachine::where('id',$listProduit->marque_id)->first(); echo $marque->titre;
                                    @endphp</span>
                                    <div class="d-flex align-items-center justify-content-between mb-15">
                                        <h5 class="product-title lc-1 mb-0">{{ $listProduit->titre }}</h5>
                                       
                                    </div>
                                   
                                    <div class="product-price">
                                        <h5 class="new-price">Prix: {{ number_format($listProduit->prix,2)}} DT</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- product-default -->
                        </div>

@endforeach
      
                    </div>

                    {{ $query->withQueryString()->links() }}
                   
                </div>
            </div>
        </div>
    </div>


@stop

@Push('js')

@endpush