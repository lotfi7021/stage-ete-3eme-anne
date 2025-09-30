<?php

namespace App\Http\Controllers;
use App\Models\Gestion_machine;
use DataTables;

use App\Models\stock_machine;
use Illuminate\Http\Request;

class StockMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminlist_stockM(Request $request){
       
        $titleSeo = 'Liste de stocks'; 
        $array =array();     
    $produit = Gestion_machine::all();
        foreach($produit as $list_produit)
        {
           $array[] =$list_produit->id;
        }
     



        if ($request->ajax()) {
            $data = stock_machine::whereIn('id_produit',$array)->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                   
                    ->addColumn('id_produit', function($id_produit){
                             $produit = Gestion_machine::where('id',$id_produit->id_produit)->first();
                        return $produit->titre;
                        }
                    )
                        
                    ->addColumn('action', function($row){
           
                        $btn = '<a href="'.$row->id.'/edit_machine" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
        
                        return $btn;
                })
                ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.gestion_machine.Stock.list', compact('titleSeo'));
}




  
public function edit($id)
{    
    $Stock = stock_machine::where('id',$id)->first();
    if(is_null($Stock)){
                return abort(404);
            }
    $titleSeo="Modifier stock";
    
    return view('back.gestion_machine.Stock.edit',compact('titleSeo','Stock'));
}


public function update(Request $request, $id)

{ $request->validate([
   'qte_initial' => 'required|integer|min:0|max:99999999',
'mouvement' => 'required|integer|min:0|max:99999999',
'qte_final' => 'required|integer|min:0|max:99999999',

]);
    $Stock = stock_machine::find($id);
  

        $Stock->qte_initial = $request->qte_initial;
        $Stock->mouvement = $request->mouvement;
        $Stock->qte_final = $request->qte_final;
  
    $Stock->save();

    return redirect()->route('admin.list_stock.machine')->with('success','Merci!');

}




  
}
