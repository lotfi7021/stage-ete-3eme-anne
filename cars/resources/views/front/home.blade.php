@extends('front.app')

@Push('css') 
<style>
.cover-ribbon {
  height: 115px;
  width: 115px;
  position: absolute;
  right: -1px;
  top: -8px;
  z-index: 99;
  overflow: hidden;
}
.cover-ribbon .cover-ribbon-inside {
  background: #ff002d;
  color: #FFF;
  transform: rotate(45deg);
  position: absolute;
  right: -35px;
  top: 15px;
  padding: 10px;
  min-width: 127px;
  text-align: center;
}
.cover-ribbon {
    /* existing styles */
}
.choose-area .image img {
    width: 100%;
    height: auto;
    display: block;
}




</style>
@endpush

@section('content')


 <!-- Home-area start-->
 <section class="hero-banner hero-banner-1">
        <div class="container">
            <div class="swiper home-slider" id="home-slider-1">
                <div class="swiper-wrapper">
                @foreach ($banner as $imagebanner )
                <div class="swiper-slide" data-aos="fade-up">
                        <div class="banner-content" data-swiper-parallax="-300">
                            <h1 class="title color-white mb-20">{!! $imagebanner->titre!!}</h1>
                        </div>
                    </div>

                @endforeach
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xl-10">
                    <div class="banner-filter-form mt-40" data-aos="fade-up" data-aos-delay="100">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item">
                                <button class="nav-link radius-0 active" data-bs-toggle="tab" data-bs-target="#all" type="button">Je recherche</button>
                            </li>
                            
                        </ul>
                        <div class="tab-content form-wrapper p-30">
                            <div class="tab-pane fade active show" id="all">
                                <form action="{{ route('search')}}" method="GET">
                                  
                                    <div class="row align-items-center gx-xl-3">
                                        <div class="col-lg-11">
                                            <div class="row">
                                                <div class="col-md col-sm-6">
                                                    <div class="form-group border-end">
                                                        <label for="location" class="font-sm">Modele </label>
                                                        <select class="nice-select" id="modele" name="modele">
                                                        <option value="">---</option>
                                                        @foreach ($modele as $listModel)
                                                                <option value="{{ $listModel->id}}">{{ $listModel->titre}}</option>  
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md col-sm-6">
                                                    <div class="form-group border-end">
                                                        <label for="marque" class="font-sm">Marque</label>
                                                        
                                                        <select class="nice-select" id="marque" name="marque">
                                                        <option value="">---</option>
                                                        @foreach ($marques as $listMarque)
                                                                <option value="{{ $listMarque->id}}">{{ $listMarque->titre}}</option>  
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md col-sm-6" id="showmodel" style="display:none;">
                                                    <div class="form-group border-end">
                                                        <label for="model" class="font-sm">Model</label>
                                                        <select class="nice-select" id="model" name="model">
                                                          
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-sm mb-2">{{ trans('generale.prix')}}</label>
                                                        <div class="price-slider mb-2" data-range-slider="priceSlider"></div>
                                                        <span class="filter-price-range" data-range-value="priceSliderValue"></span>
                                                        <input type="hidden" name="prix_min" id="min_value"> 
                                                        <input type="hidden" name="prix_max" id="max_value">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 text-md-end">
                                            <button type="submit" class="btn btn-icon bg-primary color-white">
                                                <i class="fal fa-search"></i>
                                                <span class="me-1 d-inline-block d-lg-none"></span>
                                                <span class="d-inline-block d-lg-none">{{ trans('generale.trouver')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 align-self-end" data-aos="fade-up" data-aos-delay="100">
                    <div class="slider-navigation position-static text-end mt-2 mt-lg-0">
                        <button type="button" title="Slide prev" class="slider-btn radius-0" id="home-slider-1-prev">
                            <i class="fal fa-angle-left"></i>
                        </button>
                        <button type="button" title="Slide next" class="slider-btn radius-0" id="home-slider-1-next">
                            <i class="fal fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper home-img-slider" id="home-img-slider-1">
            <div class="swiper-wrapper">
               
                    @foreach ($banner as $imagebanner )
                    <div class="swiper-slide">
                    <div class="bg-img" data-bg-image="{{url('images/banners/',$imagebanner->image) }}"></div>
                </div>
                    @endforeach
                   
                
            </div>
        </div>
        <!--<div class="swiper-pagination pagination-fraction" id="home-slider-1-pagination"></div>-->
    </section>
    <!-- Home-area end -->

   

    
  <!-- Choose-area start -->
<section class="choose-area choose-1 pt-100 pb-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="slide-right" data-aos-duration="1000">
                <div class="image mb-40">
                    <!-- Update the data-src attribute to point to choose-1.jpg -->
                    <img class="lazyload blur-up" src="{{ asset('assets/front/images/placeholder.png') }}" data-src="{{ asset('assets/front/images/background.jpg') }}" alt="Pourquoi choisir Lavazza Coffee?">
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-up">
                <div class="content-title mb-40">
                    <h2 class="title mb-20">Livraison Rapide et Fiable de Café

</h2>
                    <p>Notre service de livraison est à l'image de votre journée : rapide, efficace et fiable. Que vous ayez besoin d'une recharge matinale ou d'un supplément d'énergie l'après-midi, notre équipe de livraison dédiée veille à ce que votre café préféré vous soit livré avec la plus grande célérité, tout en préservant l'arôme et la chaleur de chaque tasse. Chez Coffe Shop, nous comprenons que le temps est précieux, c'est pourquoi nous avons affiné notre service pour garantir une livraison qui n'est pas seulement rapide, mais toujours à l'heure, à chaque fois. Faites l'expérience de la commodité à son meilleur, avec notre promesse d'excellence en matière de livraison.

.</p>
                </div>
            </div>
        </div>
    </div>
  
</section>
<!-- Choose-area end -->


    
    <!-- Blog-area end -->



@stop

@Push('js')
<script type="text/javascript">
    $(document).ready(function ()
    {
        
        $('select[name="marque"]').on('change',function(){
           
            var marqueID = $(this).val();
            if(marqueID){
                $.ajax({
                    url: '/getModels/'+marqueID,
                    type: "GET",
                    dataType:"json",
                    success:function(data)
                {
                    if(data.length != 0){
                      $('#showmodel').show();
                    $('select[name="model"]').empty();
                    
                    $.each(data, function(key,value){

                        $('select[name="model"]').append('<option value="'+value+'">'+value+'</option>');
                    });
                    $(".nice-select").niceSelect('destroy');
                    $(".nice-select").niceSelect();  
                    }
                    else{
                        $('#showmodel').hide();
                    }
                    
                    
                }

                });
            }
            else {
                $('select[name="model"]').empty();
               
            }
        });

    });
    
</script>
@endpush