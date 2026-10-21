<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $titleBreadcrumbs = 'FAQ';
            $titleSeo = 'FAQ - SelectCars';
            $descriptionSeo ='faq';

            $faq = Cache::remember('front.faq.list', 600, fn () => Faq::orderByDesc('created_at')->get());
        
        return view('front.faq',compact('titleBreadcrumbs','titleSeo','descriptionSeo','faq')); 
        
    }

    public function adminlist_faq(Request $request)
    {
        $titleSeo = 'Liste des FAQ'; 
        if ($request->ajax()) {
            $data = Faq::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.route('admin.list_faq.edit', $row->id).'" class="badge  bg-success" style="padding:5px;margin-right:2px;"><i class="fa fa-pencil-alt"></i></a>';
                            $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer le Faq?\')" href="'.route('admin.list_faq.delete', $row->id).'" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.faq.list', compact('titleSeo'));
    }

  
    public function create()
    {
        $titleSeo = 'Ajouter une Faq';
        return view('back.faq.add',compact('titleSeo'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'reponse' => 'required'
        ]);
        $faq = new Faq();
        $faq->question = $request->question;
        $faq->reponse = $request->reponse;
        $faq->save();
        Cache::forget('front.faq.list');
        return redirect()->route('admin.list_faq')->with('success', 'Faq ajouter avec succèes');

    }

    

    public function edit($id)
    {
        $titleSeo="Détail de FAQ";
        $faq = Faq::where('id',$id)->first();
        return view('back.faq.edit',compact('titleSeo','faq'));
    }

   

    public function update(Request $request, $id)
    {  $request->validate([
        'question' => 'required',
        'reponse' => 'required'
    ]);
        $faq = Faq::find($id);   
          $faq->question = $request->question;
          $faq->reponse = $request->reponse;
          $faq->save();
          Cache::forget('front.faq.list');
          return redirect()->route('admin.list_faq')->with('success','Merci!');
    }

   
    public function destroy($id)
    {
        $faq = Faq::where('id',$id)->firstOrFail()->delete();
        Cache::forget('front.faq.list');
        return redirect()->route('admin.list_faq')->with('success','Faq Supprimer');
    }
}
