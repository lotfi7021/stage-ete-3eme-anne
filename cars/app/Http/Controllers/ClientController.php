<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        $titleSeo = 'Liste des Clients'; 
        return view ('back.Client.list', compact('titleSeo'));
    }


    public function adminlist_client(Request $request){
        $titleSeo = 'Liste des clients'; 
        if ($request->ajax()) {
            $data = Client::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                   
                    ->addColumn('action', function($row){
       
                         
                            $btn = '<a href="list_client/'.$row->id.'/edit" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le client?\')" href="list_client/'.$row->id.'/destroy" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.Client.list', compact('titleSeo'));
}

   
    public function create()
    {
        $titleSeo = 'Ajouter Client';
        return view('back.Client.add',compact('titleSeo'));
    }

   
  
    public function store(Request $request)
    {
        $request->validate([

            'nom'=>'required',
            'prenom'=>'required',
            'nom_de_la_societe'=>'required',
            'code_TVA'=>'required',
            'adresse'=>'required',
            'telephone'=>['required', 'regex:/^\d{8}$/'],

            'Email'=>'required',
        ]);
        $client = new Client();

        $client->nom = $request->nom;
       $client->prenom = $request->prenom;
       $client->nom_de_la_societe = $request->nom_de_la_societe;
       $client->code_TVA = $request->code_TVA;
       $client->adresse = $request->adresse;
       $client->telephone = $request->telephone;

       $client->Email = $request->Email;
         
       $client->save();
          
          return redirect()->route('admin.list_client')->with('success', 'Client ajouter avec succèes');

    }

    
    public function edit($id)
    {
        $client = Client::where('id',$id)->first();
        $titleSeo=$client->titre;
        if(is_null($client)){
                    return abort(404);
                }
                return view('back.Client.edit',compact('titleSeo','client'));
    }

  
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
       
        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->nom_de_la_societe = $request->nom_de_la_societe;
        $client->code_TVA = $request->code_TVA;
        $client->adresse = $request->adresse;
        $client->telephone = $request->telephone;
        $client->Email = $request->Email;
          $client->save();
          return redirect()->route('admin.list_client')->with('success','Merci!');


    }
  
 
}
