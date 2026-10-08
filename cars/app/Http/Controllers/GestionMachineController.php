<?php

namespace App\Http\Controllers;
use App\Models\Gestion_machine;
use App\Models\MarqueMachine;
use App\Models\stock_machine;
use App\Models\Model_machine;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class GestionMachineController extends Controller

{
  
  
  public function index()
  {
      $titleBreadcrumbs = 'machines';
      $titleSeo = 'SD-AUTO';
      $descriptionSeo ='machines';
      $count_machine = Gestion_machine::count();    
      $machine = Gestion_machine::orderBy('created_at','desc')->paginate(6);
      $marquefetch = MarqueMachine::get();
      $modelfetch = Model_machine::get();

      $categorieslist = Categorie::get();
      return view('front.recherche.chercherm',compact('titleBreadcrumbs','titleSeo','descriptionSeo','machine','count_machine','marquefetch','modelfetch','categorieslist'));
  }

 



    public function adminlist_machine(Request $request){
        $titleSeo = 'Liste des pièces'; 
        if ($request->ajax()) {
            $data = Gestion_machine::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('marque_id', function($data){   
                      $marque_machine = MarqueMachine::where('id',$data->marque_id)->first()->titre;
                      $titlemarque = $marque_machine;
                      return $titlemarque;
                })
                ->addColumn('model_id', function($data){
                  $model_machine = Model_Machine::where('id',$data->model_id)->first()->titre;
                  $titleModel = $model_machine;
                  return $titleModel;
            })
            ->addColumn('stock', function($data) {
              $stockItem = stock_Machine::where('id_produit', $data->id)->first();
              // Return qte_final directly for processing in the DataTables render function
              return $stockItem->qte_final; // Return '0' if nothing found
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
       
                            $btn = '<a href="list_machine/'.$row->id.'/detail" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a href="list_machine/'.$row->id.'/edit" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer la machine?\')" href="list_machine/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
      
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
    $stock = stock_Machine::get();
    $model_machine = Model_Machine::get();
    $ref = 'C-'.Str::random(5);

    return view('back.gestion_machine.add',compact('titleSeo','marque_machine','ref','model_machine','stock'));
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
        $gestion_machine = new Gestion_machine();

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

        stock_machine::create([
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
        $gestion_machine = Gestion_machine::where('id',$id)->first();
        $gestion_machine->status=0;
        $gestion_machine->save();
        //$gestion_pri= Gestion_pri::where('produit_id',$id)->delete();
        //$stock= Stock::where('id_produit',$id)->delete();
        return redirect()->route('admin.list_machine')->with('success','machine Supprimer');
    }



    public function edit($id)
    {
        $gestion_machine = Gestion_machine::where('id',$id)->first();
        if(is_null($gestion_machine)){
           return abort(404);  }
        $titleSeo=$gestion_machine->titre;
        $marque_machine = MarqueMachine::get();
        $model_machine = Model_Machine::get();
        $stock = stock_machine::where("id_produit",$gestion_machine->id)->first();
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

        $gestion_machine = Gestion_machine::findOrFail($id);

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

        $stock = stock_machine::where('id_produit', $gestion_machine->id)->first();
        if ($stock) {
            $stock->qte_initial += $request->qte;
            $stock->qte_final += $request->qte;
            $stock->save();
        }

        return redirect()->route('admin.list_machine')->with('success', 'Machine mise à jour avec succès');
    }

    
    public function show($id)
    {
        $gestion_machine = Gestion_machine::where('id',$id)->first();
        $stock = stock_machine::where("id_produit", $gestion_machine->id)->first();

        if(is_null($gestion_machine)){
            return abort(404);
         }
          $titleSeo=$gestion_machine->titre;

        return view('back.gestion_machine.show',compact('titleSeo','gestion_machine','stock'));
    }



    public function checkReference(Request $request){
        $reference = $request->input('reference');
        $isExists = Gestion_machine::where('reference','LIKE',"%{$reference}%")->first();
        if($isExists){
            return 'Référence existe déjà';
        }else{
            return '';
        }
    }

   


public function clientlist_machine(Request $request){
        
  $titleSeo = 'Liste des machines'; 
  if ($request->ajax()) {
      $data = Gestion_machine::select('*');
      return Datatables::of($data)
              ->addIndexColumn()
              ->addColumn('marque_id', function($marque_id){
                $marque_machine = MarqueMachine::where('id',$marque_id->marque_id)->first();
                return $marque_machine->titre;
          })
          ->addColumn('model_id', function($model_id){
            $model_machine = Model_Machine::where('id',$model_id->model_id)->first();
            return $model_machine->titre;
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
                $stockItem = stock_Machine::where('id_produit', $data->id)->first();
                // Return qte_final directly for processing in the DataTables render function
                return $stockItem->qte_final; // Return '0' if nothing found
            })
          
              ->addColumn('action', function($row){
 
                      $btn = '<a href="list_machine/'.$row->id.'/detail" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';

                      return $btn;
              })
              ->rawColumns(['action'])
              ->make(true);
  }
return view('back.gestion_machine.clientlist', compact('titleSeo'));
}


public function clientshow_machine($id)
{
    $gestion_machine = Gestion_machine::where('id',$id)->first();

    if(is_null($gestion_machine)){
        return abort(404);
     }
      $titleSeo=$gestion_machine->titre;
    return view('back.gestion_machine.show',compact('titleSeo','gestion_machine'));
}


}
