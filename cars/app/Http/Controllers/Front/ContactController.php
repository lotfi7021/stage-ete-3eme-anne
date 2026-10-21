<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use DataTables;
class ContactController extends Controller
{
    public function index(){

            $titleBreadcrumbs = 'Contact';
            $titleSeo = 'contact';
            $descriptionSeo ='contact';
        
        return view('front.contact',compact('titleBreadcrumbs','titleSeo','descriptionSeo')); 
    }

    public function list_contac(Request $request){
        $titleSeo = 'Liste des contact'; 
        if ($request->ajax()) {
            $data = Contact::select('*')->orderBy('id','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="'.route('contactjj.us.show', $row->id).'" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';

                        $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer contact?\')" href="'.route('contact.us.destroy', $row->id).'" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                  
                        return $btn;
                })
                ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.contact.list', compact('titleSeo'));
}

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $titleSeo = 'Détail contact';
        return view('back.contact.show', compact('contact', 'titleSeo'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'required|numeric',
            'sujet' => 'required|string|max:255',
            'contenu' => 'nullable|string',
        ]);

        Contact::create($request->only('nom', 'email', 'telephone', 'sujet', 'contenu'));

        return redirect()->back()->with('success', 'Merci de nous avoir contacté. Nous vous répondrons sous peu.');
    }
  
    public function destroy($id)
    {
        $contact = Contact::where('id',$id)->firstOrFail()->delete();
    
        return redirect()->route('list_contact')->with('success','Demande Supprimer');
    }
   

}
