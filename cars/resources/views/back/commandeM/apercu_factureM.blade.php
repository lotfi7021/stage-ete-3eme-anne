@extends('back.appfacture')

@push('css') 
     <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets/back/plugins/ekko-lightbox/ekko-lightbox.css')}}">

  <style type="text/css">



@media print
{
 .no-print{display:none;}
   
    #print {       background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;}
}
</style>
@endpush

@section('content')


 

    <section class="content" id="print">
     
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                        <div class="row no-print">
                            <div class="col-12">
                          
                                <a href="#"  onclick="PrintDiv('print')"  class="btn btn-default"><i class="fas fa-print"></i> Imprimer</a>
                               
                            </div>
                     
                        </div>
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Coffe-Shop
                                    <small class="float-right">Date: {{ $commande->created_at->format('d/m/Y') }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                de
                                <address>
                                    <strong>Hatem</strong><br>
                                    Rue des Entrepreneurs Z.I <br>Charguia II - 2035 Ariana, Tunisie<br>
                                    Telephone: 71433369<br>
                                    Email: hatemdridi@yahoo.com
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                A
                                <address>
                                    <strong>  Entreprise {{ $client->nom_de_la_societe }}</strong><br>

                                  Adresse :  {{ $client->adresse }}<br>

                                    Telephone: {{ $client->telephone }}<br>
                                    Email: {{ $client->Email }} <br>
                                    <b>Num de Compte:</b> {{ $client->id }}

                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Ref_commande : #{{ $commande->ref_commande }}</b><br>
                                <br>
                                <b>Livreur :</b>{{$commande->nom}} <br>
                                <b>Commande ID:</b> {{ $commande->id }}<br>
                                <b>Payment Due:</b> {{ $commande->created_at->addDays(30)->format('d/m/Y') }}<br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Quantite</th>
                                            <th>Produit</th>
                                            <th>P.U</th>
                                            <th>Prix total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <thead>

                                    <tbody>
                                        @foreach($details as $detail)
                                            <tr>
                                                <td>{{ $detail->qte }}</td>
                                                <td>
                                                
                                                {{ App\Models\Produit::where('id',$detail->id_produit)->first()->titre }}</td>
                                                <td>{{ $detail->prix }} dt</td>
                                                <td>{{ $detail->qte * $detail->prix }} DT</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
</thead>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <p class="lead">Date de Livraison {{ $commande->date_livraison }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                    @php
                                            $netAPayer = $commande->tva; 

                                            // Calculer le net à payer en fonction du paiement choisi
                                            if ($commande->paiement == 20) {
                                                $netAPayer = $commande->tva * 0.80;
                                            } elseif ($commande->paiement == 50) {
                                                $netAPayer = $commande->tva * 0.50;
                                            }
                                        @endphp
                                        <tr>
                                            <th style="width:50%">Prix HT</th>
                                            <td>{{ $commande->prix  }} DT</td>
                                        </tr>
                                        <tr>   

                                            <th>Tax (TVA):</th>
                                            <td>{{ $commande->tva-$commande->prix }} DT</td>
                                        </tr>
                                        <tr>
                                            <th>Prix TTC:</th>
                                            <td>{{ $commande->tva }} DT</td>
                                        </tr>
                                        <tr>
                                            <th>Net a payer:</th>
                                            <td>{{  $netAPayer }} DT</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                       

                    </div>
                </div>
            </div>
        </div>
    </section>


@stop
@Push('js')
<script>
function PrintDiv(el){
var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}
</script>
@endPush