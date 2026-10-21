@extends('front.app')

@section('content')

<!-- Page title start -->
<div class="page-title-area pb-100 bg-img bg-s-cover" data-bg-image="{{ asset('assets/front/images/echange.jpg') }}" style="height: 500px;">
    <div class="overlay opacity-70"></div>
    <div class="container">
        <div class="content">
            <h2>{{ ucfirst($titleBreadcrumbs) }}</h2>
            <ul class="list-unstyled">
                <li class="d-inline"><a href="{{ url('/') }}">Accueil</a></li>
                <li class="d-inline">/</li>
                <li class="d-inline active opacity-75">{{ ucfirst($titleBreadcrumbs) }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Page title end -->

<!-- car-list-area start -->
<div class="car-list-area pt-100 pb-60">
    <div class="container">
        <div class="row gx-xl-5">
            <div class="col-lg-12">
                <div class="product-sort-area" data-aos="fade-up">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h4 class="mb-20">{{ $count_machine }}+ machines disponible</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <span class="badge badge-light mr-2">{{ $marquefetch->count() }} marques</span>
                            <span class="badge badge-light mr-2">{{ $modelfetch->count() }} modèles</span>
                            <span class="badge badge-light">{{ $categorieslist->count() }} catégories</span>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="row">
                    @if($machine->count() == 0)
                        <div class="col-md-6" data-aos="fade-up">
                            <h4 class="mb-20">Pas de résultat disponible</h4>
                        </div>
                    @endif
                    @foreach ($machine as $listProduit)
                        <div class="col-xl-3 col-md-6" data-aos="fade-up">
                            <div class="product-default border p-10 mb-25">
                                <figure class="product-img mb-15">
                                    <a href="{{ route('machine') }}" target="_self" title="Voir le catalogue" class="lazy-container ratio ratio-2-3">
                                        <img class="lazyload" src="{{ asset('assets/front/images/placeholder.png') }}" data-src="{{ url('/images/produits', $listProduit->image1) }}" alt="{{ $listProduit->titre }}">
                                    </a>
                                </figure>
                                <div class="product-details">
                                    <span class="product-category font-xsm">
                                        {{ $listProduit->marque?->titre ?? '—' }}
                                    </span>
                                    <div class="d-flex align-items-center justify-content-between mb-15">
                                        <h5 class="product-title lc-1 mb-0">{{ $listProduit->titre }}</h5>
                                    </div>
                                    <div class="product-price">
                                        <h5 class="new-price">Prix: {{ number_format($listProduit->prix, 2) }} DT</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- product-default -->
                        </div>
                    @endforeach
                </div>

                {{ $machine->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
<!-- car-list-area end -->

@stop

@Push('js')

@endpush
