<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Gestion_pri;
use DataTables;

class CategorieController extends Controller
{
   
    public function create()
    {
        $titleSeo = 'Ajouter une catégorie';
        return view('back.categorie.add',compact('titleSeo'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
        ]);
        $categorie = new Categorie();
          $categorie->titre = $request->titre;
          $categorie->save();
          return redirect()->route('admin.list_categories')->with('success', 'Catégorie ajouter avec succèes');
    }

   

    public function adminlist_categorie(Request $request){
        $titleSeo = 'Liste des catégories'; 
        if ($request->ajax()) {
            $data = Categorie::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="list_categories/'.$row->id.'/edit" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.categorie.list', compact('titleSeo'));
}



    public function edit($id)
    {   $gestion_pri=Gestion_pri::get();
        $categorie = Categorie::where('id',$id)->first();
        $titleSeo=$categorie->titre;
        if(is_null($categorie)){
                    return abort(404);
                }
                return view('back.categorie.edit',compact('titleSeo','categorie','gestion_pri'));
    }
 

   

    public function update(Request $request, $id)
{
    $categorie = Categorie::find($id);
    if (!$categorie) {
        return back()->withErrors('Catégorie non trouvée.');
    }
    $categorie->titre = $request->input('titre');
    $categorie->save();

    $prix_ids = $request->input('id', []); // IDs des prix
    $prix_values = $request->input('prix', []); // Valeurs des prix

    foreach ($prix_ids as $index => $prix_id) {
        $gestion_pri = Gestion_pri::find($prix_id);
        if ($gestion_pri) {
            $gestion_pri->prix = $prix_values[$index] ?? 0;
            $gestion_pri->save();
        }
    }

    return redirect()->route('admin.list_categories')->with('success', 'Catégorie mise à jour avec succès.');
}

    public function destroy($id)
    {
        $categorie = Categorie::where('id',$id)->firstOrFail()->delete();
        return redirect()->route('admin.list_categories')->with('success','Catégorie Supprimer');
    }
}
