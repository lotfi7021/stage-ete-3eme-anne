<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Categorie;
use App\Models\CommandeM;
use App\Models\Contact;
use App\Models\DetailCommandeM;
use App\Models\GestionMachine;
use App\Models\MarqueMachine;
use App\Models\ModelMachine;
use App\Models\StockMachine;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
{
    public function support()
    {
        $titleSeo = 'Tableau de bord';
        $admin = Auth::guard('admin')->user();
        $isLivreur = $admin->role === 'livreur';

        $nbTotal = null;
        $nbCommandes = null;

        if ($isLivreur) {
            $scope = CommandeM::with('client')->where('id_livreur', $admin->id);
            $nbTotal = (clone $scope)->count();
            $nbAttente = (clone $scope)->where('etat', 'en attente')->count();
            $nbCours = (clone $scope)->where('etat', 'confirmée')->count();
            $nbLivrees = (clone $scope)->where('etat', 'Livrée')->count();
            $dernieres = (clone $scope)->orderBy('id', 'desc')->limit(8)->get();
        } else {
            $nbCommandes = CommandeM::count();
            $nbAttente = CommandeM::where('etat', 'en attente')->count();
            $nbCours = CommandeM::where('etat', 'confirmée')->count();
            $nbLivrees = CommandeM::where('etat', 'Livrée')->count();
            $nbClients = Admin::where('role', 'client')->count();
            $nbTickets = Support::count();
            $nbMessages = Contact::count();
            $dernieres = CommandeM::with('client')->orderBy('id', 'desc')->limit(8)->get();
        }

        $badge = fn ($etat) => match ($etat) {
            'Livrée' => 'success',
            'confirmée' => 'info',
            'en attente' => 'warning',
            default => 'secondary',
        };

        return view('back.Dashboard.support', compact(
            'titleSeo', 'isLivreur', 'nbTotal', 'nbCommandes', 'nbAttente',
            'nbCours', 'nbLivrees', 'nbClients', 'nbTickets', 'nbMessages', 'dernieres', 'badge'
        ));
    }

    public function machine()
    {
        $titleSeo = 'Ventes machines';
        $nbCommandes = CommandeM::count();
        $caTotal = CommandeM::sum('prix');
        $nbLivrees = CommandeM::where('etat', 'Livrée')->count();
        $nbCours = CommandeM::where('etat', 'confirmée')->count();
        $nbAttente = CommandeM::where('etat', 'en attente')->count();
        $qteVendue = DetailCommandeM::sum('qte');

        $topVentes = DetailCommandeM::selectRaw('id_produit, SUM(qte) as total')
            ->groupBy('id_produit')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $alertes = StockMachine::where('qte_final', '<=', 3)
            ->orderBy('qte_final')
            ->limit(8)
            ->get();

        $produits = GestionMachine::whereIn(
            'id',
            $topVentes->pluck('id_produit')->merge($alertes->pluck('id_produit'))->unique()
        )->get()->keyBy('id');

        $dernieres = CommandeM::with('client')->orderBy('id', 'desc')->limit(6)->get();

        $badge = fn ($etat) => match ($etat) {
            'Livrée' => 'success',
            'confirmée' => 'info',
            'en attente' => 'warning',
            default => 'secondary',
        };

        return view('back.Dashboard.machine', compact(
            'titleSeo', 'nbCommandes', 'caTotal', 'nbLivrees', 'nbCours',
            'nbAttente', 'qteVendue', 'topVentes', 'alertes', 'produits', 'dernieres', 'badge'
        ));
    }

    public function produit()
    {
        $titleSeo = 'Statistiques catalogue';
        $nbMachines = GestionMachine::count();
        $nbMarques = MarqueMachine::count();
        $nbModeles = ModelMachine::count();
        $nbCategories = Categorie::count();
        $valeurCatalogue = GestionMachine::sum('prix');
        $qteEnStock = StockMachine::sum('qte_final');

        $parMarque = MarqueMachine::withCount('gestionMachines as nb')
            ->orderByDesc('nb')
            ->limit(8)
            ->get();

        $dernieres = GestionMachine::orderBy('id', 'desc')->limit(8)->get();

        return view('back.Dashboard.produit', compact(
            'titleSeo', 'nbMachines', 'nbMarques', 'nbModeles', 'nbCategories',
            'valeurCatalogue', 'qteEnStock', 'parMarque', 'dernieres'
        ));
    }
}
