<?php

namespace App\Http\Controllers;

use App\Models\ModelMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DataTables;

class ModelMachineController extends Controller
{

    
    
    
        public function adminlist_model(Request $request){
           
            
            $titleSeo = 'Liste des model'; 
            if ($request->ajax()) {
                $data = ModelMachine::select('*')->orderBy('id','desc');
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                                $btn = '<a href="'.route('list_model.machine.edit', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                                $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le Model?\')" href="'.route('list_model.machine.delete', $row->id).'" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                                return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
        return view('back.gestion_machine.model.list', compact('titleSeo'));
    }
    
    public function create()
    {
        $titleSeo = 'Ajouter un Modele';
        return view('back.gestion_machine.model.add',compact('titleSeo'));
    }
    
    
    
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
        ]);
        $model = new ModelMachine();
          $model->titre = $request->titre;
          $model->save();
          Cache::forget('front.models');
          return redirect()->route('list_model.machine')->with('success', 'Model ajouter avec succèe');
    }

    
    public function destroy($id)
    {
        $model = ModelMachine::where('id',$id)->firstOrFail()->delete();
        Cache::forget('front.models');
        return redirect()->route('list_model.machine')->with('success','machine  Supprimer');
    }


    public function edit($id)
    {
        $model = ModelMachine::where('id',$id)->first();
        if(is_null($model)){
                    return abort(404);  }
        $titleSeo=$model->titre;
        return view('back.gestion_machine.model.edit',compact('titleSeo','model'));
    }
    
       
    public function update(Request $request, $id)
    { $request->validate([
        'titre' => 'required',
    ]);
        $model = ModelMachine::find($id);
            $model->titre = $request->titre;
        $model->save();
        Cache::forget('front.models');
        return redirect()->route('list_model.machine')->with('success','Merci!');
        
    }
      
    }
    

