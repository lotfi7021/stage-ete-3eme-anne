<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
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
                            $btn = '<a href="'.route('admin.list_categories.edit', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.categorie.list', compact('titleSeo'));
}



    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        $titleSeo = $categorie->titre;

        return view('back.categorie.edit', compact('titleSeo', 'categorie'));
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->titre = $request->input('titre');
        $categorie->save();

        return redirect()->route('admin.list_categories')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $categorie = Categorie::where('id',$id)->firstOrFail()->delete();
        return redirect()->route('admin.list_categories')->with('success','Catégorie Supprimer');
    }
}
