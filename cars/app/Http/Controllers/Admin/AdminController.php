<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Client;

use App\Models\Produit;
use App\Models\Commande;
use App\Models\Commande_M;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use DataTables;

class AdminController extends Controller
{
    public function __construct(){
        if(!Auth::guard('admin')->check()){
            return redirect()->route('login.form'); 
        }
    }
   

  public function login_form()
{
    $titleSeo = 'Admin Login Form';

    if (!Auth::guard('admin')->check()) {
        return view('back.admin_login', compact('titleSeo'));
    } else {
        return view('back.gestion_machine.list', compact('titleSeo'));
    }
}

    

















    // admin login functionality
    public function login_functionality(Request $request)
    {
        // Valider les champs de la requête
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
    
        // Tenter de se connecter en tant qu'administrateur
        if (Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password, 'status' => 1])) {
            // Récupérer l'utilisateur connecté
            $admin = Admin::where('login', $request->login)->first();
            
            // Stocker l'ID de l'utilisateur dans la session
            Session::put('user', $admin->id);
            
            // Rediriger en fonction du rôle de l'utilisateur
            switch ($admin->role) {
                case 'admin':
                    return redirect()->route('admin.list_machine');
                case 'client':
                    return redirect()->route('client.list_machine');
                case 'livreur':
                    return redirect()->route('dashboardL');
                default:
                    // Si le rôle n'est pas reconnu, rediriger vers une page par défaut ou une page d'erreur
                    return redirect()->route('defaultRoute');
            }
        } else {
            // Si la tentative de connexion échoue, afficher un message d'erreur
            Session::flash('error-message', 'Login ou mot de passe incorrect.');
            return back();
        }
    }
    
    public function dashboard()
    {
        $titleSeo = 'Tableau de bord';
        if(Auth::guard('admin')->check()){
            return redirect()->route('login.form');
        }
      
    }


    public function calendar(Request $request){
        if(Auth::guard('admin')->check()){

            $data = Commande::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title','start','end']);
                $data1 = Commande_M::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title','start','end']);
                
            return response()->json(array_merge(json_decode($data, true),json_decode($data1, true)));
    }
    else{
        return redirect()->route('login.form');
    }
    }

    
        public function settings(Request $request){

            $titleSeo = 'Settings';
            $admin = Admin::where("id",$request->id)->first();
            
            return view('back.settings',compact('admin','titleSeo'));
        }



    public function logoutadmin(){
        Auth::guard('admin')->logout();
        return redirect()->route('login.form');
    }







    
    public function adminlist_compte(Request $request){
        $titleSeo = 'Liste des Comptes'; 
        if ($request->ajax()) {
            $data = Admin::select('*')->where("status",1)->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                  
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.$row->id.'/edit" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            
                            if($row->role!="admin")
                            {
                                if($row->status==1){
                                    $btn .= '<a onclick="return confirm(\'Vous êtes sûr de descativer le compte?\')" href="'.$row->id.'/delete" class="badge  bg-danger" title="Descativer le compte"  style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                                }
                                else
                                {
                                    $btn .= '<a onclick="return confirm(\'Vous êtes sûr d\'activer le compte?\')" href="'.$row->id.'/delete" class="badge  bg-info" title="Activer le compte" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                                }
                               
                            }
                           

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.compte.list', compact('titleSeo'));
}



public function clientlist_compte(Request $request){
    $titleSeo = 'Liste des Comptes'; 
    if ($request->ajax()) {
        $data = Admin::where('role', 'client')
        ->where('status', 1)
        ->select('*')
        ->orderBy('id', 'desc')
        ->get();

                return Datatables::of($data)
                ->addIndexColumn()
               
              
                ->addColumn('action', function($row){
                        $btn = '<a href="list_compte/'.$row->id.'/edit_client" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                        $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le compte?\')" href="list_compte/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
    
return view('back.Client.list', compact('titleSeo'));
}


//-----------------------------------------livreur------------------------------------------------------------------------------











//-----------------------------------------Client------------------------------------------------------------------------------

public function create_client()
{
    $titleSeo = 'Ajouter un compte';
     // Assurez-vous que vous avez un modèle Client et qu'il est correctement importé
    return view('back.compte.add_client', compact('titleSeo', 'clients'));
}
public function store_client(Request $request)
{
    // Valider les données de la requête
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'nom_de_la_societe' => 'required|string|max:255',
        'code_TVA' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'telephone' => ['required', 'regex:/^\d{8}$/'],
        'Email' => 'required|email|max:255',
        'login' => 'required|unique:admins,login',
        'groupe'=> 'required|string|max:255',
        'password' => ['required', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
    ]);

    // Créer une nouvelle instance de Admin
    $client = new Admin();
    $client->nom = $request->nom;
    $client->prenom = $request->prenom;
    $client->nom_de_la_societe = $request->nom_de_la_societe;
    $client->code_TVA = $request->code_TVA;
    $client->adresse = $request->adresse;
    $client->telephone = $request->telephone;
    $client->Email = $request->Email;
    $client->type = 1;
    $client->login = $request->login;
    $client->role = 'client';
    $client->status =  1;
    $client->groupe = $request->groupe;
    $client->password = Hash::make($request->password);
    $client->save();

    return redirect()->route('admin.client_compte')->with('success', 'Succès');
}



public function edit_client($id)
{
    $client = Admin::where('id',$id)->first();
    $titleSeo=$client->titre;
    if(is_null($client)){
                return abort(404);
            }
            return view('back.Client.edit',compact('titleSeo','client'));
}


public function update_client(Request $request, $id)
{
    $client = Admin::find($id);
   
    $client->nom = $request->nom;
    $client->prenom = $request->prenom;
    $client->nom_de_la_societe = $request->nom_de_la_societe;
    $client->code_TVA = $request->code_TVA;
    $client->adresse = $request->adresse;
    $client->telephone = $request->telephone;
    $client->login =  $request->login;

    $client->Email = $request->Email;

      $client->save();
      return redirect()->route('admin.client_compte')->with('success','Merci!');
}
//-------------------------------------Adminn-------------------------------------------------------------------------------------------
public function create()
{
    $titleSeo = 'Ajouter un compte';
    return view('back.compte.add', compact('titleSeo',));
}


    public function store(Request $request)
    {

        $request->validate([
            'nom' => 'required|string|max:255',
            'login' => 'required|unique:admins,login',
            'password' => ['required', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()]
        ]);

        $admin = new Admin();
        $admin->nom= $request->nom;

        $admin->telephone = 0;
        $admin->type=1;
        $admin->login =  $request->login;
        $admin->role =  $request->role;
        $admin->groupe = 0;
        $admin->password = Hash::make( $request->password);
        $admin->prenom = '';
        $admin->nom_de_la_societe ='';
        $admin->code_TVA = '';
        $admin->adresse = '';
        $admin->status =  1;
      $admin->Email = '';
     $admin->groupe =  0;

        $admin->save();
        return redirect()->route('compte')->with('success','Succès');
    }
   
    public function update(Request $request,$id)
    {

        $request->validate([
            'nom' => 'required',
            'login' => 'required',
        
        ]);

        $admin = Admin::find($id);
        $admin->nom= $request->nom;
        $admin->prenom= $request->prenom;
        $admin->telephone = $request->telephone;
        $admin->type=1;
        $admin->login =  $request->login;
        $admin->role =  $request->role;
        $admin->password = Hash::make( $request->password);
        $admin->save();
        return redirect()->route('compte')->with('success','Succès');
    }

     
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if($admin->status==0){
            $admin->status=1;
        }
        else{
            $admin->status=0;
        }
        
        $admin->save();
        return redirect()->back()->with('success','Compte supprimer');
    }
 

    public function destroy_livreur($id_livreur)
    {
        $livreur = Admin::where('id',$id_livreur)->first()->delete();
        return redirect()->back()->with('success','Compte Supprimer');
    }


    public function destroy_client($id_client)
    {
        $client = Admin::where('id',$id_client)->first()->delete();
        return redirect()->back()->with('success','Compte Supprimer');
    }


}
