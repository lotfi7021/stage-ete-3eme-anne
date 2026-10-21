<?php

namespace App\Http\Controllers;
use App\Models\GestionMachine;
use App\Models\MarqueMachine;
use App\Models\StockMachine;
use App\Models\ModelMachine;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GestionMachineController extends Controller

{
  
  
  public function index()
  {
      $titleBreadcrumbs = 'machines';
      $titleSeo = 'Machines - SelectCars';
      $descriptionSeo ='machines';
      $count_machine = GestionMachine::count();    
      $machine = GestionMachine::with('marque')->orderBy('created_at','desc')->paginate(6);
      $marquefetch = Cache::remember('front.marques', 600, fn () => MarqueMachine::get());
      $modelfetch = Cache::remember('front.models', 600, fn () => ModelMachine::get());

      $categorieslist = Categorie::get();
      return view('front.recherche.chercherm',compact('titleBreadcrumbs','titleSeo','descriptionSeo','machine','count_machine','marquefetch','modelfetch','categorieslist'));
  }

 



    public function adminlist_machine(Request $request){
        $titleSeo = 'Liste des pièces'; 
        if ($request->ajax()) {
            $data = GestionMachine::with(['marque', 'model', 'stock'])->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('marque_id', function($data){   
                      return $data->marque?->titre ?? '—';
                })
                ->addColumn('model_id', function($data){
                  return $data->model?->titre ?? '—';
            })
            ->addColumn('stock', function($data) {
              return $data->stock ? $data->stock->qte_final : 0;
          })
          
                    ->addColumn('image', function ($image) {
                        $url= $image->image1;
                        return $url;
                    }) 
                  
               
                    ->addColumn('prix', function ($prix) {

                        $prix= number_format($prix->prix,2).' DT';
                        return $prix;
                    })  
                  
                
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="'.route('admin.list_machine.detail', $row->id).'" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a href="'.route('admin.list_machine.edit', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer la machine?\')" href="'.route('admin.list_machine.delete', $row->id).'" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.gestion_machine.list', compact('titleSeo'));
}



public function create()
{
    $titleSeo = 'Ajouter une machine';
    $marque_machine = MarqueMachine::get();
    $model_machine = ModelMachine::get();
    $ref = 'C-'.Str::random(5);

    return view('back.gestion_machine.add',compact('titleSeo','marque_machine','ref','model_machine'));
}


public function store(Request $request)
{
    $request->validate([
        'reference' => 'required|string|max:255',
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'qte' => 'required|integer|min:1',
        'prix' => 'required|numeric|min:0',
        'marque_id' => 'required|integer|exists:marque_machines,id',
        'model_id' => 'required|integer|exists:model_machines,id',
    ]);

    DB::transaction(function () use ($request) {
        $gestion_machine = new GestionMachine();

        if ($request->file('image1')) {
            $file = $request->file('image1');
            $filename1 = time() . '_' . $file->getClientOriginalName();
            $location = public_path('/images/produits');
            $file->move($location, $filename1);
            $gestion_machine->image1 = $filename1;
        }

        $gestion_machine->fill($request->only([
            'reference', 'titre', 'description', 'prix', 'marque_id', 'model_id', 'qte'
        ]));
        $gestion_machine->save();

        StockMachine::create([
            'id_produit' => $gestion_machine->id,
            'qte_initial' => $request->qte,
            'mouvement' => 0,
            'qte_final' => $request->qte,
        ]);
    });

    return redirect()->route('admin.list_machine')->with('success', 'Machine ajoutée avec succès');
}



 

    public function destroy($id)
    {
        $gestion_machine = GestionMachine::where('id', $id)->firstOrFail();

        DB::transaction(function () use ($gestion_machine) {
            StockMachine::where('id_produit', $gestion_machine->id)->delete();
            $gestion_machine->delete();
        });

        return redirect()->route('admin.list_machine')->with('success', 'Machine supprimée');
    }



    public function edit($id)
    {
        $gestion_machine = GestionMachine::where('id',$id)->first();
        if(is_null($gestion_machine)){
           return abort(404);  }
        $titleSeo=$gestion_machine->titre;
        $marque_machine = MarqueMachine::get();
        $model_machine = ModelMachine::get();
        $stock = StockMachine::where("id_produit",$gestion_machine->id)->first();
        return view('back.gestion_machine.edit',compact('titleSeo','gestion_machine', 'marque_machine','model_machine','stock'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qte' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
            'marque_id' => 'required|integer|exists:marque_machines,id',
            'model_id' => 'required|integer|exists:model_machines,id',
        ]);

        $gestion_machine = GestionMachine::findOrFail($id);

        if ($request->file('image1')) {
            $file = $request->file('image1');
            $filename1 = time() . '_' . $file->getClientOriginalName();
            $location = public_path('/images/produits');
            $file->move($location, $filename1);
            $gestion_machine->image1 = $filename1;
        }

        $gestion_machine->fill($request->only([
            'reference', 'titre', 'description', 'prix', 'marque_id', 'model_id', 'qte'
        ]));
        $gestion_machine->save();

        $stock = StockMachine::where('id_produit', $gestion_machine->id)->first();
        if ($stock) {
            $stock->qte_initial += $request->qte;
            $stock->qte_final += $request->qte;
            $stock->save();
        }

        return redirect()->route('admin.list_machine')->with('success', 'Machine mise à jour avec succès');
    }

    
    public function show($id)
    {
        $gestion_machine = GestionMachine::with('marque')->where('id',$id)->first();

        if(is_null($gestion_machine)){
            return abort(404);
         }
          $titleSeo=$gestion_machine->titre;

        return view('back.gestion_machine.show',compact('titleSeo','gestion_machine'));
    }



    public function checkReference(Request $request){
        $reference = $request->input('reference');
        $isExists = GestionMachine::where('reference','LIKE',"%{$reference}%")->first();
        if($isExists){
            return 'Référence existe déjà';
        }else{
            return '';
        }
    }

   


public function clientlist_machine(Request $request){
        
  $titleSeo = 'Liste des machines'; 
  if ($request->ajax()) {
      $data = GestionMachine::with(['marque', 'model', 'stock'])->select('*');
      return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('marque_id', function($data){
                return $data->marque?->titre ?? '—';
          })
          ->addColumn('model_id', function($data){
            return $data->model?->titre ?? '—';
      })

      
    
      ->addColumn('image', function ($image) {
        $url= $image->image1;
        return $url;
    }) 
           ->addColumn('prix', function ($prix) {

                  $prix= number_format($prix->prix,2).' DT';
                  return $prix;
              })  
              ->addColumn('stock', function($data) {
                return $data->stock ? $data->stock->qte_final : 0;
            })
          
              ->addColumn('action', function($row){
 
                      $btn = '<a href="'.route('client.show.machine', $row->id).'" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';

                      $btn .= '<a href="'.route('admin.list_commandeM.add').'" class="badge  bg-success" style="padding:5px;margin-right:2px;" title="Lancer une commande"><i class="fa fa-shopping-cart"></i></a>';

                      return $btn;
              })
              ->rawColumns(['action'])
              ->make(true);
  }
return view('back.gestion_machine.clientlist', compact('titleSeo'));
}


public function clientshow_machine($id)
{
    $gestion_machine = GestionMachine::with('marque')->where('id',$id)->first();

    if(is_null($gestion_machine)){
        return abort(404);
     }
      $titleSeo=$gestion_machine->titre;
    return view('back.gestion_machine.show',compact('titleSeo','gestion_machine'));
}


}
