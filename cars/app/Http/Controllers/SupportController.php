<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use App\Models\Support;
use Illuminate\Http\Request;
use DataTables;
class SupportController extends Controller
{
    public function adminlist_support(Request $request){
        $titleSeo = 'Liste des Tickets'; 
        if ($request->ajax()) {
            $data = Support::select('*')->orderBy('id','desc');
            
            return Datatables::of($data)
                    ->addIndexColumn()

                 ->addColumn('action', function($row){
       
                         
                            $btn = '<a href="support/'.$row->id.'/show" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le ticket?\')" href="support/'.$row->id.'/destroy" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.support.list', compact('titleSeo'));
}


public function show($id){
    $support = Support::where('id', $id)->first();
    $titleSeo = 'detail support';
 
    return view('back.support.show',compact('support','titleSeo')); 
    }

   
public function create(){
$admin=Admin::get();
    $titleBreadcrumbs = 'Contact';
    $titleSeo = 'contact - Us';
    $descriptionSeo ='contact';

return view('back.support.add',compact('titleBreadcrumbs','titleSeo','descriptionSeo','admin')); 
}

public function store(Request $request)
{
    $request->validate([
        'sujet'  => 'required',
        'support'  => 'required',
        'message'  => 'required',

    ]);

    $support  = new Support;
    $support->id_client = $request->id_client;
    $support->sujet = $request->sujet;
    $support->support = $request->support;
    $support->message = $request->message;
    $support->save();
       
        return redirect()->route('dashboard') ->with(['success'=>'Reclamation confirmé ! Un e-mail récapitulatif des détails vous sera bientôt envoyé. Merci de choisir us.']);
}
public function destroy($id)
{
    $support = Support::where('id',$id)->firstOrFail()->delete();
  

    return redirect()->route('admin.list_support')->with('success','Support Supprimer');
}

   
   
}
