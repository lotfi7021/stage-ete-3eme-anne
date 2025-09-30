<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\MarqueMachine;
use App\Models\Gestion_machine;
use App\Models\Banner;

use App\Models\ModelVoiture;
use App\Models\Model_machine;





class HomeController extends Controller
{
  public function index(){
    $titleBreadcrumbs = 'Accueil';
    $titleSeo = 'Accueil - Coffe-shop';
    $descriptionSeo ='Accueil';

    $marques = MarqueMachine::get(); 
    $modele = Model_machine::get(); 
    $banner = Banner::get();

return view('front.home',compact('titleBreadcrumbs','titleSeo','descriptionSeo','marques','banner','modele')); 
  }  





  public function search(Request $request)
  {
    $titleSeo = 'Recherche - Coffe Shop';
    $search = Gestion_machine::query();

   
    if(request()->has('marque')) {
      $search->where('marque_id',  $request->marque);
    }
  
    if(request()->has('prix_min') && request()->has('prix_max')) {
      $search->whereBetween('prix', [number_format($request->prix_min,0,'',''), number_format($request->prix_max,0,'','')]);
    }
 

    $query = $search->paginate(6);
   


    return view('front.search',compact('titleSeo','query'));
  }
}
