@extends('back.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Statistiques catalogue</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Produits</li>
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
                        <div class="inner"><h3>{{ $nbMachines }}</h3><p>Machines au catalogue</p></div>
                        <div class="icon"><i class="fas fa-cogs"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner"><h3>{{ $nbMarques }}</h3><p>Marques</p></div>
                        <div class="icon"><i class="fas fa-tags"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner"><h3>{{ $nbModeles }}</h3><p>Modèles</p></div>
                        <div class="icon"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner"><h3>{{ $nbCategories }}</h3><p>Catégories</p></div>
                        <div class="icon"><i class="fas fa-sitemap"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Valeur du catalogue (prix affichés)</span>
                            <span class="info-box-number">{{ number_format($valeurCatalogue, 0, ',', ' ') }} DT</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-warning"><i class="fas fa-warehouse"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Quantité totale en stock</span>
                            <span class="info-box-number">{{ $qteEnStock }} unités</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Répartition par marque</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead><tr><th>Marque</th><th>Nombre de machines</th></tr></thead>
                                <tbody>
                                    @forelse($parMarque as $marque)
                                        <tr>
                                            <td>{{ $marque->titre }}</td>
                                            <td><span class="badge badge-info">{{ $marque->nb }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">Aucune marque enregistrée.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Derniers produits ajoutés</h3></div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead><tr><th>Référence</th><th>Titre</th><th>Prix</th></tr></thead>
                                <tbody>
                                    @forelse($dernieres as $produit)
                                        <tr>
                                            <td>{{ $produit->reference }}</td>
                                            <td>{{ $produit->titre }}</td>
                                            <td>{{ number_format($produit->prix, 2) }} DT</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted">Aucun produit.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.list_machine') }}" class="btn btn-sm btn-outline-primary">
                                Gérer les pièces
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop
