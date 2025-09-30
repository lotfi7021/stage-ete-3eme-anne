<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMail;

use Illuminate\Http\RedirectResponse;
use DataTables;

use Mail;
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

                        $btn = '<a href="contact-US/'.$row->id.'/detail" class="badge  bg-primary" style="padding:5px;margin-right:2px;"><i class="fa fa-eye"></i></a>';

                        $btn .= '<a onclick="return confirm(\'Vous êtes sûr de supprimer contact?\')" href="contact-US/'.$row->id.'/delete" class="badge  bg-danger" style="padding:5px;margin-right:2px;"><i class="fa fa-trash"></i></a>';
                  
                        return $btn;
                })
                ->rawColumns(['action'])
                    ->make(true);
        }
    return view('back.contact.list', compact('titleSeo'));
}

public function show($id){
    $contact = Contact::where('id', $id)->first();
    $titleSeo = 'detail support';

    return view('back.contact.show',compact('contact','titleSeo')); 
    }



    public function store(Request $request)
    {
       
       $request->validate([
            'nom' => 'required',
            'telephone' => 'required|numeric',
            'sujet' =>'required',
        ]);

        $nom = $request->nom;
        $email = $request->email;

        $telephone = $request->telephone;
        $sujet = $request->sujet;
        $contenu = $request->contenu;


       

            Contact::create($request->all());
            
            return redirect()->back()
                             ->with(['success'=>'Merci de nous avoir contacté. nous vous répondrons sous peu']);
        
        
    }
  
    public function create()
    {
        $titleSeo = 'Contact-US';
        return view('front.contact',compact('titleSeo'));
    }
   



    public function destroy($id)
    {
        $contact = Contact::where('id',$id)->firstOrFail()->delete();
    
        return redirect()->route('list_contact')->with('success','Demande Supprimer');
    }
   

}
