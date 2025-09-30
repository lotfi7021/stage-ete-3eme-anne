<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Commande_M;
use App\Models\Gestion_machine;
use App\Models\Detail_commandeM;
use App\Models\stock_machine;
use Auth;

use App\Models\Admin;
use App\Models\Livreur;
use Illuminate\Support\Str;
use DataTables;
Use Carbon\Carbon;
class CommandeMachineController extends Controller
{


    /*  liste commande machine*/ 
    public function adminlist_commande_machine(Request $request){
        $titleSeo = 'Liste des Commandes'; 
        if ($request->ajax()) {
            $admin = Admin::where('id',session('user'))->first();
            if(Auth::guard('admin')->check() &&  $admin->role=='admin')
            {
                $data = Commande_M::select('*')->orderBy('id', 'desc');
            }
            elseif(Auth::guard('admin')->check() &&  $admin->role=='client')
            {
                $data = Commande_M::select('*')->where('id_client',$admin->id)->orderBy('id', 'desc');
            }
            elseif(Auth::guard('admin')->check() &&  $admin->role=='livreur')
            {
                $data = Commande_M::select('*')->where('id_livreur',$admin->id)->orderBy('id', 'desc');
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('id_client', function($id_client){
                        $client = Admin::where('id',$id_client->id_client)->first();
                        return $client->nom;
                  })
                  ->addColumn('id_livreur', function($id_livreur){
                    $livreur = Admin::where('id',$id_livreur->id_livreur)->count();
                    if($livreur>0){
                         $livreur1 = Admin::where('id',$id_livreur->id_livreur)->first();
                    return $livreur1->nom. ' '.$livreur1->prenom;
                    }
                    else {
                        return '';
                    }
                   
              })
                    ->addColumn('action', function($row){
                        $admin = Admin::where('id',session('user'))->first();
                        if(Auth::guard('admin')->check() &&  $admin->role=='admin')
                        {
                            $btn = '<a href="list_commandeM/'.$row->id.'/facture" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer la Commande?\')" href="list_commandeM/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            $btn .= '<a  href="list_commandeM/'.$row->id.'/maj" class="badge  bg-warning" style="padding:5px;margin-right:2px;"><i class="fa fa-truck"></i></a>';
                            return $btn;
                        }
                        elseif(Auth::guard('admin')->check() &&  $admin->role=='client')
                        {
                            $btn = '<a href="list_commandeM/'.$row->id.'/facture" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            
                        }
                        elseif(Auth::guard('admin')->check() &&  $admin->role=='livreur')
                        {
                            $btn = '<a href="list_commandeM/'.$row->id.'/facture" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a href="list_commandeM/'.$row->id.'/mark-as-delivered" class="badge bg-primary" style="padding:5px;margin-right:2px;">Marquée  livrée</a>';

                           
                            
                        }
                return $btn;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.commandeM.list', compact('titleSeo'));
}



public function statut_livre($id)
{
    $commande = Commande_M::findOrFail($id);
    $commande->etat = 'Livrée';
    $commande->save();
    return redirect()->route('admin.list_commandeM')->with('success', 'Commande marquée comme livrée');
}



public function create_commande()
{
    $ref = 'pièce-'.Str::random(5);
    $titleSeo = 'Ajouter une Commande';
    $machine = Gestion_machine::get();
    return view('back.commandeM.ajout',compact('titleSeo','ref','machine'));
}



public function store(Request $request)
{
    $request->validate([
        'ref_commande'=>'required',
         'date_livraison'=>'required',
    ]);
    $commande = new Commande_M();
    $total_prix=0;

    foreach($request->qte as $key=>$value)
    {    
        $detail_commande = new Detail_commandeM();
        $detail_commande->ref_commande = $request->ref_commande;
        $detail_commande->id_produit = $request->id[$key];
        $detail_commande->prix = $request->prix[$key];
        $detail_commande->qte = $request->qte[$key];
        $total_prix +=$request->prix[$key]*$request->qte[$key];
        if($request->qte[$key]!=0){
        $detail_commande->save();
} 
    }
    $commande->ref_commande = $request->ref_commande;
    $commande->id_client = $request->id_client;
    $commande->prix = $total_prix;
    $commande->tva = $total_prix*1.19;
    $commande->date_livraison = $request->date_livraison;
    $commande->title = $request->ref_commande;
    $commande->start = Carbon::now();
    $commande->end = Carbon::now()->addHour();
    $commande->id_livreur = 0;
    $commande->etat = 'en attente';
    $commande->paiement = $request->paiement;
   $commande->save();
      return redirect()->route('admin.list_commandeM')->with('success', 'Commande ajouter avec succèes');

}


public function maj(Request $request, $id)
{
    $titleSeo = 'Affecter un livreur';
    $commande = Commande_M::find($id);
    $livreurs = Admin::where('role','livreur')  ->where('status', 1)->get();
return view('back.commandeM.edit',compact('commande','livreurs','titleSeo'));
}




public function updateLivreur(Request $request, $id)
{
    $commande = Commande_M::find($id);
    if (!$commande) {
        return back()->with('error', 'Commande non trouvée.');
    }
    $commande->etat = 'confirmée'; 
    $commande->save();
    $detail_commande = Detail_commandeM::where('ref_commande',$commande->ref_commande)->get();
    foreach($detail_commande as $list_detail){

    $stock = stock_machine::where('id_produit', $list_detail->id_produit)->first();
    $mouvement_ancien = $stock->mouvement;
    $qte_initial = $stock->qte_initial;
    $ajouter_stock = $list_detail->qte+ $mouvement_ancien;
    $stock->mouvement = $ajouter_stock;
    $stock->qte_final = ($qte_initial-$stock->mouvement);
    $stock->save();
}
    return redirect()->route('admin.list_commandeM')->with('success', 'Livreur assigné et commande confirmée avec succès.');
}
   


public function facture($ref_commande)
{
    $commande = Commande_M::where("id",$ref_commande)->first();
    if (!$commande) {
        abort(404, 'Commande non trouvée.');
    }
    $client = Admin::find($commande->id_client);
    $livreur = Admin::find($commande->id_livreur);
    $details = Detail_commandeM::where('ref_commande', $commande->ref_commande)->get();
    $titleSeo = 'Facture';
    return view('back.commandeM.factureM', compact('titleSeo', 'client', 'livreur','commande', 'details'));
}



public function apercufacture_machine($ref_commande)
{
    $commande = Commande_M::where("id",$ref_commande)->first();
    if (!$commande) {
        abort(404, 'Commande non trouvée.');
    }
    $client = Admin::find($commande->id_client);
    $livreur = Admin::find($commande->id_livreur);
    $details = Detail_commandeM::where('ref_commande', $commande->ref_commande)->get();
    $titleSeo = 'Facture';
    return view('back.commandeM.apercu_factureM', compact('titleSeo', 'client', 'livreur','commande', 'details'));
}



public function destroy($id)
{
    $commande = Commande_M::where('id', $id)->firstOrFail();
    Detail_commandeM::where('ref_commande', $commande->ref_commande)->delete();
    $commande->delete();
    return redirect()->route('admin.list_commandeM')->with('success', 'Commande supprimée');
}
}
