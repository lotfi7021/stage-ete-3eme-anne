<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\MarqueMachine;
use App\Models\GestionMachine;
use App\Models\Banner;
use App\Models\ModelMachine;





class HomeController extends Controller
{
  public function index(){
    $titleBreadcrumbs = 'Accueil';
    $titleSeo = 'Accueil - SelectCars';
    $descriptionSeo ='Accueil';

    $marques = Cache::remember('front.marques', 600, fn () => MarqueMachine::get());
    $modele = Cache::remember('front.models', 600, fn () => ModelMachine::get());
    $banner = Cache::remember('front.banners', 600, fn () => Banner::get());

return view('front.home',compact('titleBreadcrumbs','titleSeo','descriptionSeo','marques','banner','modele')); 
  }  





  public function search(Request $request)
  {
    $titleSeo = 'Recherche - SelectCars';
    $search = GestionMachine::with('marque');

    if ($request->filled('marque')) {
      $search->where('marque_id', $request->input('marque'));
    }

    if ($request->filled('modele')) {
      $search->where('model_id', $request->input('modele'));
    }

    if ($request->filled('prix_min') && $request->filled('prix_max')) {
      $search->whereBetween('prix', [number_format($request->prix_min,0,'',''), number_format($request->prix_max,0,'','')]);
    }

    $query = $search->paginate(6)->withQueryString();

    return view('front.search',compact('titleSeo','query'));
  }
}
