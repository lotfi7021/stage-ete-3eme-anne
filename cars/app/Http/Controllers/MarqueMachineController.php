<?php

namespace App\Http\Controllers;

use App\Models\MarqueMachine;
use Illuminate\Http\Request;
use DataTables;
class MarqueMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

    public function adminlist_marque(Request $request){
       
        
        $titleSeo = 'Liste Constructeurs '; 
        if ($request->ajax()) {
            $data = MarqueMachine::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                         
                            $btn = '<a href="list_marque/'.$row->id.'/editmachine" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer la marque?\')" href="list_marque/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.gestion_machine.listmarque', compact('titleSeo'));
}

public function create()
{
    $titleSeo = 'Ajouter une marque';
    return view('back.gestion_machine.addmarque',compact('titleSeo'));
}



public function store(Request $request)
{
    $request->validate([
        'titre' => 'required',

    ]);
    $marque = new MarqueMachine();

    

      $marque->titre = $request->titre;

      $marque->save();
    
      return redirect()->route('list_marque.machine')->with('success', 'Marque ajouter avec succèe');
}






public function destroy($id)
{
    $marque = MarqueMachine::where('id',$id)->firstOrFail()->delete();
    return redirect()->route('list_marque.machine')->with('success','machine  Supprimer');
}



public function edit($id)
{
    $marque = MarqueMachine::where('id',$id)->first();
    if(is_null($marque)){
                return abort(404);  }
          
    $titleSeo=$marque->titre;
    return view('back.gestion_machine.editmarque',compact('titleSeo','marque'));
}

   

public function update(Request $request, $id)
{ $request->validate([
    'titre' => 'required',

]);
    $marque = MarqueMachine::find($id);
    
        $marque->titre = $request->titre;
               
    $marque->save();
    return redirect()->route('list_marque.machine')->with('success','Merci!');
    
}
  
}
