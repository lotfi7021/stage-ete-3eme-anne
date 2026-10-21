
    <!-- Footer-area start -->
    <footer class="footer-area bg-img bg-s-cover" data-bg-image="{{ asset('assets/front/images/footer-bg-3.jpg') }}" style="height: 400px;">
        <div class="overlay opacity-70"></div>
        <div class="footer-top pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="footer-widget" data-aos="fade-up">
                            <div class="navbar-brand">
                                <a href="{{ url('/')}}">
                                </a>
                            </div>
                            <p>Chez SelectCars, nous comprenons l'importance de trouver la machine et le produit parfaits qui répondent à vos besoins et à votre budget.</p>
                            
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm">
                        <div class="footer-widget" data-aos="fade-up">
                            <h4>Navigation</h4>
                            <ul class="footer-links">
                                <li>
                                    <a href="{{ url('/') }}">Accueil</a>
                                </li>
                                <li>
                                    <a href="{{ route('faq') }}">Politique de vente</a>
                                </li>
                               
                                
                                <li>
                                    <a href="{{ route('admin.list_support.add') }}">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm">
                        <div class="footer-widget" data-aos="fade-up">
                            <h4>Marques</h4>
                            <ul class="footer-links">
                                @php
                                    $marque = \App\Models\MarqueMachine::take(6)->get();
                                    
                                @endphp
                                @foreach ($marque as $list_marque )
                                <li>
                                    <a href="{{ route('search')}}?marque={{ $list_marque->id}}">{{ $list_marque->titre}}</a>
                                </li>
                                    
                                @endforeach
                               
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="footer-widget" data-aos="fade-up">
                            <h4>Contacts</h4>
                     
                                
                                <li>
                                    <i class="fal fa-headset"></i>
                                    <a href="tel:0033075109866">56547785</a>
                                </li>
                                <li>
                                    <i class="fal fa-headset"></i>
                                  
                                    <a href="tel:0033676318489">22547963</a>
                                </li>
                                <li>
                                    <i class="fal fa-envelope"></i>
                                    <a href="mailto:info@selectcarsauto.fr">info@sd-auto.tn</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
       
    </footer>
