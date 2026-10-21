@extends('back.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ventes machines</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Ventes machines</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner"><h3>{{ $nbCommandes }}</h3><p>Commandes totales</p></div>
                        <div class="icon"><i class="fas fa-file-invoice"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner"><h3>{{ number_format($caTotal, 0, ',', ' ') }} DT</h3><p>Chiffre d'affaires</p></div>
                        <div class="icon"><i class="fas fa-coins"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner"><h3>{{ $qteVendue }}</h3><p>Unités vendues</p></div>
                        <div class="icon"><i class="fas fa-box-open"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner"><h3>{{ $nbAttente }} / {{ $nbCours }} / {{ $nbLivrees }}</h3><p>Attente / Cours / Livrées</p></div>
                        <div class="icon"><i class="fas fa-stream"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Produits les plus vendus</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr><th>#</th><th>Machine</th><th>Unités vendues</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($topVentes as $i => $vente)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $produits->get($vente->id_produit)?->titre ?? 'Produit supprimé (#' . $vente->id_produit . ')' }}</td>
                                            <td>{{ $vente->total }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted">Aucune vente enregistrée.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Alertes de stock (≤ 3)</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr><th>Machine</th><th>Stock restant</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($alertes as $alerte)
                                        <tr>
                                            <td>{{ $produits->get($alerte->id_produit)?->titre ?? 'Produit supprimé (#' . $alerte->id_produit . ')' }}</td>
                                            <td><span class="badge badge-danger">{{ $alerte->qte_final }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Aucune alerte de stock.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Dernières commandes</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr><th>Référence</th><th>Client</th><th>Prix</th><th>État</th><th>Livraison</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($dernieres as $commande)
                                        <tr>
                                            <td>{{ $commande->ref_commande }}</td>
                                            <td>{{ $commande->client?->nom ?? '—' }} {{ $commande->client?->prenom ?? '' }}</td>
                                            <td>{{ number_format($commande->prix, 2) }} DT</td>
                                            <td><span class="badge badge-{{ $badge($commande->etat) }}">{{ $commande->etat }}</span></td>
                                            <td>{{ $commande->date_livraison }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted">Aucune commande.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
