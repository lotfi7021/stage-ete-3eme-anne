@extends('back.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tableau de bord</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session()->get('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif

            <div class="row">
                @if($isLivreur)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner"><h3>{{ $nbTotal }}</h3><p>Livraisons affectées</p></div>
                            <div class="icon"><i class="fas fa-truck"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner"><h3>{{ $nbAttente }}</h3><p>En attente</p></div>
                            <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner"><h3>{{ $nbCours }}</h3><p>En cours</p></div>
                            <div class="icon"><i class="fas fa-dolly"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner"><h3>{{ $nbLivrees }}</h3><p>Livrées</p></div>
                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner"><h3>{{ $nbCommandes }}</h3><p>Commandes</p></div>
                            <div class="icon"><i class="fas fa-file-invoice"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner"><h3>{{ $nbAttente }}</h3><p>Commandes en attente</p></div>
                            <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner"><h3>{{ $nbLivrees }}</h3><p>Commandes livrées</p></div>
                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner"><h3>{{ $nbClients }}</h3><p>Clients</p></div>
                            <div class="icon"><i class="fas fa-users"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner"><h3>{{ $nbTickets }}</h3><p>Tickets SAV</p></div>
                            <div class="icon"><i class="fas fa-headset"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner"><h3>{{ $nbMessages }}</h3><p>Messages reçus</p></div>
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $isLivreur ? 'Mes dernières livraisons' : 'Dernières commandes' }}
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Client</th>
                                        <th>Prix</th>
                                        <th>État</th>
                                        <th>Livraison prévue</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dernieres as $commande)
                                        <tr>
                                            <td>{{ $commande->ref_commande }}</td>
                                            <td>{{ $commande->client?->nom ?? '—' }} {{ $commande->client?->prenom ?? '' }}</td>
                                            <td>{{ number_format($commande->prix, 2) }} DT</td>
                                            <td><span class="badge badge-{{ $badge($commande->etat) }}">{{ $commande->etat }}</span></td>
                                            <td>{{ $commande->date_livraison }}</td>
                                            <td>
                                                <a href="{{ route('admin.list_commandeM.facture', $commande->id) }}" class="badge bg-primary">
                                                    <i class="fa fa-eye"></i> Facture
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center text-muted">Aucune commande pour le moment.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.list_commandeM') }}" class="btn btn-sm btn-outline-primary">
                                Voir toutes les commandes
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@stop
