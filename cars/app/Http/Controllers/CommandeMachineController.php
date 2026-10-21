<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CommandeM;
use App\Models\GestionMachine;
use App\Models\DetailCommandeM;
use App\Models\StockMachine;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class CommandeMachineController extends Controller
{


    /*  liste commande machine*/ 
    public function adminlist_commande_machine(Request $request){
        $titleSeo = 'Liste des Commandes'; 
        if ($request->ajax()) {
            $admin = Auth::guard('admin')->user();
            if($admin->role=='admin')
            {
                $data = CommandeM::with(['client', 'livreur'])->select('*')->orderBy('id', 'desc');
            }
            elseif($admin->role=='client')
            {
                $data = CommandeM::with(['client', 'livreur'])->select('*')->where('id_client',$admin->id)->orderBy('id', 'desc');
            }
            elseif($admin->role=='livreur')
            {
                $data = CommandeM::with(['client', 'livreur'])->select('*')->where('id_livreur',$admin->id)->orderBy('id', 'desc');
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id_client', function($commande){
                        return $commande->client?->nom ?? '';
                  })
                  ->addColumn('id_livreur', function($commande){
                    return $commande->livreur ? $commande->livreur->nom.' '.$commande->livreur->prenom : '';
              })
                    ->addColumn('action', function($row) use ($admin){
                        if(Gate::forUser($admin)->allows('role', 'admin'))
                        {
                            $btn = '<a href="'.route('admin.list_commandeM.facture', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer la Commande?\')" href="'.route('admin.list_commandeM.machine.delete', $row->id).'" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            $btn .= '<a href="'.route('admin.list_commandeM.updateLivreur', $row->id).'" class="badge  bg-warning" style="padding:5px;margin-right:2px;"><i class="fa fa-truck"></i></a>';
                            return $btn;
                        }
                        if(Gate::forUser($admin)->allows('role', 'livreur'))
                        {
                            $btn = '<a href="'.route('admin.list_commandeM.facture', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a href="'.route('admin.list_commandeM.markAsDelivered', $row->id).'" class="badge bg-primary" style="padding:5px;margin-right:2px;">Marquée  livrée</a>';
                            return $btn;
                        }
                        return '<a href="'.route('admin.list_commandeM.facture', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.commandeM.list', compact('titleSeo'));
}



public function statut_livre($id)
{
    $commande = CommandeM::findOrFail($id);
    $this->authorizeCommande('markDelivered', $commande);
    $commande->etat = 'Livrée';
    $commande->save();
    return redirect()->route('admin.list_commandeM')->with('success', 'Commande marquée comme livrée');
}



public function create_commande()
{
    $ref = 'pièce-'.Str::random(5);
    $titleSeo = 'Ajouter une Commande';
    $machine = GestionMachine::with('stock')->get();
    return view('back.commandeM.ajout',compact('titleSeo','ref','machine'));
}



public function store(Request $request)
{
    $request->validate([
        'ref_commande' => 'required|string',
        'date_livraison' => 'required|date',
        'id_client' => 'required|integer|exists:admins,id',
        'paiement' => 'required|string',
        'id' => 'required|array',
        'qte' => 'required|array',
        'prix' => 'required|array',
    ]);

    DB::transaction(function () use ($request) {
        $total_prix = 0;

        foreach ($request->qte as $key => $value) {
            if ($request->qte[$key] != 0) {
                DetailCommandeM::create([
                    'ref_commande' => $request->ref_commande,
                    'id_produit' => $request->id[$key],
                    'prix' => $request->prix[$key],
                    'qte' => $request->qte[$key],
                ]);
                $total_prix += $request->prix[$key] * $request->qte[$key];
            }
        }

        CommandeM::create([
            'ref_commande' => $request->ref_commande,
            'id_client' => $request->id_client,
            'prix' => $total_prix,
            'tva' => $total_prix * 1.19,
            'date_livraison' => $request->date_livraison,
            'title' => $request->ref_commande,
            'start' => Carbon::now(),
            'end' => Carbon::now()->addHour(),
            'id_livreur' => 0,
            'etat' => 'en attente',
            'paiement' => $request->paiement,
        ]);
    });

    return redirect()->route('admin.list_commandeM')->with('success', 'Commande ajoutée avec succès.');
}


public function maj(Request $request, $id)
{
    $titleSeo = 'Affecter un livreur';
    $commande = CommandeM::find($id);
    if (!$commande) {
        abort(404, 'Commande non trouvée.');
    }
    $this->authorizeCommande('assignLivreur', $commande);
    $livreurs = Admin::where('role','livreur')  ->where('status', 1)->get();
return view('back.commandeM.edit',compact('commande','livreurs','titleSeo'));
}




public function updateLivreur(Request $request, $id)
{
    $request->validate([
        'id_livreur' => ['required', 'integer', Rule::exists('admins', 'id')->where(fn ($q) => $q->where('role', 'livreur'))],
    ]);

    $commande = CommandeM::find($id);
    if (!$commande) {
        return back()->with('error', 'Commande non trouvée.');
    }

    $this->authorizeCommande('assignLivreur', $commande);

    DB::transaction(function () use ($commande, $request) {
        $commande->id_livreur = $request->input('id_livreur');
        $commande->etat = 'confirmée';
        $commande->save();

        $details = DetailCommandeM::where('ref_commande', $commande->ref_commande)->get();
        foreach ($details as $detail) {
            $stock = StockMachine::where('id_produit', $detail->id_produit)->first();
            if ($stock) {
                $stock->mouvement += $detail->qte;
                $stock->qte_final = $stock->qte_initial - $stock->mouvement;
                $stock->save();
            }
        }
    });

    return redirect()->route('admin.list_commandeM')->with('success', 'Livreur assigné et commande confirmée avec succès.');
}
   


public function facture($ref_commande)
{
    $commande = CommandeM::where("id",$ref_commande)->first();
    if (!$commande) {
        abort(404, 'Commande non trouvée.');
    }
    $this->authorizeCommande('view', $commande);
    $client = Admin::find($commande->id_client);
    $livreur = Admin::find($commande->id_livreur);
    $details = DetailCommandeM::with('produit')->where('ref_commande', $commande->ref_commande)->get();
    $titleSeo = 'Facture';
    return view('back.commandeM.factureM', compact('titleSeo', 'client', 'livreur','commande', 'details'));
}



public function apercufacture_machine($ref_commande)
{
    $commande = CommandeM::where("id",$ref_commande)->first();
    if (!$commande) {
        abort(404, 'Commande non trouvée.');
    }
    $this->authorizeCommande('view', $commande);
    $client = Admin::find($commande->id_client);
    $livreur = Admin::find($commande->id_livreur);
    $details = DetailCommandeM::with('produit')->where('ref_commande', $commande->ref_commande)->get();
    $titleSeo = 'Facture';
    return view('back.commandeM.apercu_factureM', compact('titleSeo', 'client', 'livreur','commande', 'details'));
}



public function destroy($id)
{
    $commande = CommandeM::where('id', $id)->firstOrFail();
    $this->authorizeCommande('delete', $commande);

    DB::transaction(function () use ($commande) {
        DetailCommandeM::where('ref_commande', $commande->ref_commande)->delete();
        $commande->delete();
    });
    return redirect()->route('admin.list_commandeM')->with('success', 'Commande supprimée');
}

/**
 * Vérifie la Policy Commande avec l'utilisateur du guard 'admin'.
 */
private function authorizeCommande(string $ability, CommandeM $commande): void
{
    Gate::forUser(Auth::guard('admin')->user())->authorize($ability, $commande);
}
}
