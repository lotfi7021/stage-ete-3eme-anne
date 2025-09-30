<?php

use Illuminate\Support\Facades\Route;
//Controller Front
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\CategorieController;
use App\Http\Controllers\Front\ProduitController;
use App\Http\Controllers\Front\MarqueController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Front\BannerController;
use App\Http\Controllers\LivreurController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockmachineController;
use App\Http\Controllers\ModelMachineController;
use App\Http\Controllers\GestionMachineController;
use App\Http\Controllers\MarqueMachineController;
use App\Http\Controllers\ModeleMachineController;
use App\Http\Controllers\Front\DashController;


use App\Http\Controllers\CacheController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GestionPriController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeMachineController;
use App\Http\Controllers\Admin\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
// Route for menu nav



    Route::get('/', [HomeController::class, 'index']);
    
    Route::get('/FAQ', [FaqController::class, 'index'])->name('faq');

    Route::post('contact-US/add',[ContactController::class,'store'])->name('contact.us.store');
    Route::get('contact-US',[ContactController::class,'index'])->name('contact.us.add');
   
    //Ajax search bar
    Route::get('/getModels/{id}',[HomeController::class,'getModels'])->name('getModels');


    //Route Search action

    Route::get('search',[HomeController::class,'search'])->name('search');
   

    //Route Marque
    Route::get('/marques',[MarqueController::class,'index'])->name('marques');
    Route::get('/marques/{slug}',[MarqueController::class,'show']);

    

    /*Admin Route*/
    Route::get('/admin',[AdminController::class,'login_form'])->name('login.form');
    Route::post('/admin/login-functionality',[AdminController::class,'login_functionality'])->name('login.functionality');
    Route::middleware(['admin','revalidate'])->group(function(){

    Auth::routes();

    Route::get('logoutSession',[AdminController::class,'logoutadmin'])->name('logoutSession');
    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('admin/dashboardL',[LivreurController::class,'dashboardL'])->name('dashboardL');
    Route::get('admin/calendar',[AdminController::class,'calendar'])->name('admin.calendar');


/*    button convivialle*/ 
    Route::get('/clear-cache', [CacheController::class,'clear'])->name('cache.clear');



    /*--------------------------gestion produit-------------------------------*/
    Route::get('admin/list_produit',[ProduitController::class,'adminlist_Produit'])->name('admin.list_produit');
    Route::get('admin/list_produit/add',[ProduitController::class,'create'])->name('admin.list_produit.add');
    Route::post('admin/list_produit/add',[ProduitController::class,'store'])->name('admin.list_Produit.store');
    Route::get('admin/list_produit/{id}/detail',[ProduitController::class,'show'])->name('admin.list_voitures.detail');
    Route::post('admin/list_produit/{id}/update',[ProduitController::class,'update'])->name('admin.list_produit.update');
    Route::get('admin/list_produit/{id}/edit',[ProduitController::class,'edit'])->name('admin.list_produit.edit');
    Route::post('admin/checkreference',[ProduitController::class,'checkReference'])->name('admin.checkreference');
    Route::get('admin/list_produit/{id}/delete',[ProduitController::class,'destroy'])->name('admin.list_produit.delete');
    Route::get('admin/list_voitures/{id}/deleteimage1',[ProduitController::class,'deleteimage1'])->name('admin.produit.deleteimage1');
    Route::get('/produit',[ProduitController::class,'index'])->name('produit');
    Route::get('/produit/{reference}',[ProduitController::class,'detail']);


  

 //Route for contact POST
 Route::get('admin/list_contact',[ContactController::class,'list_contac'])->name('list_contact');
 Route::get('admin/contact-US/{id}/delete',[ContactController::class,'destroy'])->name('contact.us.destroy');
 Route::get('admin/contact-US/{id}/detail', [ContactController::class, 'show'])->name('contactjj.us.show');





/*-----------------interface client--------------------------------*/
Route::get('client/list_produit',[ProduitController::class,'clientlist_Produit'])->name('client.listcafe');
Route::get('client/list_produit/{id}/detail',[ProduitController::class,'clientshow_produit'])->name('client.show');


Route::get('client/list_machine',[GestionMachineController::class,'clientlist_machine'])->name('client.list_machine');
Route::get('client/list_machine/{id}/detail',[GestionMachineController::class,'clientshow_machine'])->name('client.show.machine');

/*-----------------fin interface client--------------------------------*/





/*--------------------------gestion machine-------------------------------*/
Route::get('admin/list_machine',[GestionMachineController::class,'adminlist_machine'])->name('admin.list_machine');
Route::get('admin/list_machine/add',[GestionMachineController::class,'create'])->name('admin.list_machine.add');
Route::post('admin/list_machine/add',[GestionMachineController::class,'store'])->name('admin.list_machine.store');
Route::get('admin/list_machine/{id}/delete',[GestionMachineController::class,'destroy'])->name('admin.list_machine.delete');
Route::post('admin/list_machine/{id}/update',[GestionMachineController::class,'update'])->name('admin.list_machine.update');
Route::get('admin/list_machine/{id}/edit',[GestionMachineController::class,'edit'])->name('admin.list_machine.edit');
Route::get('admin/list_machine/{id}/detail',[GestionMachineController::class,'show'])->name('admin.list_machine.detail');
Route::post('admin/checkreference',[GestionMachineController::class,'checkReference'])->name('admin.checkreference');
Route::get('admin/list_machine/{id}/deleteimage1',[GestionMachineController::class,'deleteimage1'])->name('admin.gestion_machine.deleteimage1');
Route::get('admin/list_machine/{id}/deleteimage2',[GestionMachineController::class,'deleteimage2'])->name('admin.gestion_machine.deleteimage2');
Route::get('admin/list_machine/{id}/deleteimage3',[GestionMachineController::class,'deleteimage3'])->name('admin.gestion_machine.deleteimage3');
Route::get('admin/list_machine/{id}/deleteimage4',[GestionMachineController::class,'deleteimage4'])->name('admin.gestion_machine.deleteimage4');
Route::get('/machine',[GestionMachineController::class,'index'])->name('machine');


/*-------------------------- gestion machine Marque-------------------------------*/
Route::get('admin/list_marque',[MarqueMachineController::class,'adminlist_marque'])->name('list_marque.machine');
Route::get('admin/list_marque/add',[MarqueMachineController::class,'create'])->name('list_marque.machine.add');
Route::post('admin/list_marque/add',[MarqueMachineController::class,'store'])->name('list_marque.machine.store');
Route::get('admin/list_marque/{id}/delete',[MarqueMachineController::class,'destroy'])->name('list_marque.machine.delete');
Route::get('admin/list_marque/{id}/editmachine',[MarqueMachineController::class,'edit'])->name('list_marque.machine.edit');
Route::post('admin/list_marque/{id}/update',[MarqueMachineController::class,'update'])->name('list_marque.update');
/*--------------------------END gestion machine-------------------------------*/

/*-------------------------- gestion machine Model-------------------------------*/
Route::get('admin/list_model',[ModelMachineController::class,'adminlist_model'])->name('list_model.machine');
Route::get('admin/list_model/add',[ModelMachineController::class,'create'])->name('list_model.machine.add');
Route::post('admin/list_model/add',[ModelMachineController::class,'store'])->name('list_model.machine.store');
Route::get('admin/list_model/{id}/delete',[ModelMachineController::class,'destroy'])->name('list_model.machine.delete');
Route::get('admin/list_model/{id}/edit',[ModelMachineController::class,'edit'])->name('list_model.machine.edit');
Route::post('admin/list_model/{id}/update',[ModelMachineController::class,'update'])->name('list_model.update');

/*--------------------------END gestion Model-------------------------------*/



/*---------------------------------------------gestion prix  ------------------------------------------------------------ */
    Route::get('admin/gestion_prix',[GestionPriController::class,'gestion_prix'])->name('gestion_prix');
    Route::get('admin/list_prix/add',[GestionPriController::class,'create'])->name('admin.list_prix.add');
    Route::post('admin/list_prix/add',[GestionPriController::class,'store'])->name('admin.list_prix.store');
/*++++++++++++++++++++++fin gestion prix---------------------------*/




/*-----------------------------------gestion categorie-------------------------------------*/
    Route::get('admin/list_categories',[CategorieController::class,'adminlist_categorie'])->name('admin.list_categories');
    Route::get('admin/list_categories/add',[CategorieController::class,'create'])->name('admin.list_categories.add');
    Route::post('admin/list_categories/add',[CategorieController::class,'store'])->name('admin.list_categories.store');
    Route::post('admin/list_categories/{id}/update',[CategorieController::class,'update'])->name('admin.list_categories.update');
    Route::get('admin/list_categories/{id}/edit',[CategorieController::class,'edit'])->name('admin.list_categories.edit');
    Route::get('admin/list_categories/{id}/delete',[CategorieController::class,'destroy'])->name('admin.list_categories.delete');
    Route::get('admin/list_categories/{id}/deleteimage',[CategorieController::class,'deleteimage'])->name('admin.categories.deleteimage');
/*-----------------------------------fin gestion categorie-------------------------------------*/



/*-----------------------------------gestion marque-------------------------------------*/
    Route::get('admin/list_marques',[MarqueController::class,'adminlist_marque'])->name('admin.list_marques');
    Route::get('admin/list_marques/add',[MarqueController::class,'create'])->name('admin.list_marques.add');
    Route::post('admin/list_marques/add',[MarqueController::class,'store'])->name('admin.list_marques.store');
    Route::get('admin/list_marques/{id}/detail',[MarqueController::class,'show'])->name('admin.list_marques.detail');
    Route::get('admin/list_marques/{id}/edit',[MarqueController::class,'edit'])->name('admin.list_marques.edit');
    Route::post('admin/list_marques/{id}/update',[MarqueController::class,'update'])->name('admin.list_marques.update');
    Route::get('admin/list_marques/{id}/delete',[MarqueController::class,'destroy'])->name('admin.list_marques.delete');
    Route::get('admin/list_marques/{id}/deleteimage',[MarqueController::class,'deleteimage1'])->name('admin.marques.deleteimage');
/*----------------------------------- fin gestion marque-------------------------------------*/



/*-----------------------------------stock-------------------------------------*/
Route::get('admin/list_stock/produi',[StockController::class,'adminlist_stock'])->name('admin.list_stock');
Route::get('admin/list_stock/{id}/edit',[StockController::class,'edit'])->name('admin.list_stock.edit');
Route::post('admin/list_stock/{id}/update',[StockController::class,'update'])->name('admin.list_stock.update');

Route::get('admin/list_stock/machine',[StockmachineController::class,'adminlist_stockM'])->name('admin.list_stock.machine');
Route::get('admin/list_stock/{id}/edit_machine',[StockmachineController::class,'edit'])->name('admin.list_stock.machine.edit');
Route::post('admin/list_stock/{id}/update_machine',[StockmachineController::class,'update'])->name('admin.list_stock.machine.update');

/*----------------------------------- fin stock-------------------------------------*/



                                    /* /*gestion client*/
Route::get('admin/list_client',[ClientController::class,'adminlist_client'])->name('admin.list_client');
Route::get('admin/list_client/add',[ClientController::class,'create'])->name('admin.list_client.add');;  
Route::post('admin/list_client/add',[ClientController::class,'store'])->name('admin.list_client.store');
Route::post('admin/list_client/{id}/update',[ClientController::class,'update'])->name('admin.list_client.update');
Route::get('admin/list_client/{id}/destroy',[ClientController::class,'destroy'])->name('admin.list_client.delete');
                                    /*fin gestion client*/


                              /* /*gestion livreur*/
    Route::get('admin/list_livreurs',[AdminController::class,'livreurlist_compte'])->name('admin.list_livreur');
    Route::get('admin/list_livreurs/add',[AdminController::class,'create_livreur'])->name('admin.list_livreurs.add');
    Route::post('admin/list_livreurs/add',[AdminController::class,'store_livreur'])->name('admin.list_livreurs.store');
    Route::get('admin/list_livreurs/{id}/edit',[AdminController::class,'edit_livreur'])->name('admin.list_livreur.edit');
    Route::post('admin/list_livreurs/{id}/update',[AdminController::class,'update_livreur'])->name('admin.list_livreur.update');
    Route::get('admin/list_compte/{id}/delete_livreur',[AdminController::class,'destroy_livreur'])->name('admin.list_compte.delete_livreur');

/*----------------------------------- fin gestion livreur-------------------------------------*/


Route::get('admin/dashboard/support',[DashController::class,'support'])->name('admin.support.dashboard');

Route::get('admin/dashboard/vente/machine',[DashController::class,'machine'])->name('admin.machine.dashboard');

Route::get('admin/dashboard/produit',[DashController::class,'produit'])->name('admin.produit.dashboard');





   
                                                    /* SAV */
    Route::get('admin/support',[SupportController::class,'adminlist_support'])->name('admin.list_support');
    Route::get('admin/support/add', [SupportController::class, 'create'])->name('admin.list_support.add');
    Route::get('admin/support/{id}/show', [SupportController::class, 'show'])->name('admin.list_support.show');
    Route::post('admin/support/add', [SupportController::class, 'store'])->name('admin.list_support.store');
    Route::get('admin/support/{id}/destroy', [SupportController::class, 'destroy'])->name('admin.list_support.delete');

                                                      /*finSAV */


//*******************************/*gestion commande produit -------------------------*/
Route::get('admin/list_commande',[CommandeController::class,'adminlist_commande'])->name('admin.list_commande');
Route::get('admin/list_commande/{id}/facture',[CommandeController::class,'facture'])->name('admin.list_commande.facture');
Route::get('admin/list_commande/{id}/facture/apercu',[CommandeController::class,'apercufacture'])->name('admin.list_commande.facture.apercu');
Route::get('admin/list_commande/{id}/delete',[CommandeController::class,'destroy'])->name('admin.list_commande.delete');
Route::get('admin/list_commande/add',[CommandeController::class,'create'])->name('admin.list_commande.add');
Route::post('admin/list_commande/store',[CommandeController::class,'store'])->name('admin.list_commande.store');
Route::get('admin/list_commande/{id}/updateLivreur',[CommandeController::class,'updateLivreur'])->name('admin.updateLivreur');
Route::get('admin/list_commande/{id}/destroy',[CommandeController::class,'destroy'])->name('admin.list_commande.delete');
Route::get('client/list_commande', [CommandeController::class, 'client_commande'])->name('client.commande');;


  /*--------------------------gestion commande-------------------------------*/
  Route::get('admin/commande/{id}/edit',[CommandeController::class,'edit'])->name('admin.list_commande.edit');
  Route::get('admin/commande/{id}/maj',[CommandeController::class,'maj'])->name('admin.maj');
  Route::post('admin/commande/{id}/updateLivreur',[CommandeController::class,'updateLivreur'])->name('admin.updateLivreur');
  Route::get('admin/list_commande/{id}/mark-as-delivered', [CommandeController::class, 'statut_livre'])->name('commande.markAsDelivered');

/*--------------------------facture-------------------------------*/
Route::get('admin/facture',[CommandeController::class,'facture'])->name('admin.facture.add');

//*******************************/*gestion commande machine-------------------------*/
Route::get('admin/list_commandeM',[CommandeMachineController::class,'adminlist_commande_machine'])->name('admin.list_commandeM');
Route::get('admin/list_commandeM/{id}/detail',[CommandeMachineController::class,'show'])->name('admin.list_commandeM.machine.show');
Route::get('admin/list_commandeM/{id}/delete',[CommandeMachineController::class,'destroy'])->name('admin.list_commandeM.machine.delete');
Route::get('admin/list_commandeM/add',[CommandeMachineController::class,'create_commande'])->name('admin.list_commandeM.add');
Route::post('admin/list_commandeM/add',[CommandeMachineController::class,'store'])->name('admin.list_commandeM.store');
Route::get('admin/list_commandeM/{id}/maj',[CommandeMachineController::class,'maj'])->name('admin.list_commandeM.updateLivreur');
Route::post('admin/list_commandeM/{id}/updateLivreur',[CommandeMachineController::class,'updateLivreur'])->name('admin.list_commandeM.edit');
Route::get('admin/list_commandeM/{id}/facture',[CommandeMachineController::class,'facture'])->name('admin.list_commandeM.facture');
Route::get('admin/list_commandeM/{id}/destroy',[CommandeMachineController::class,'destroy'])->name('admin.list_commandeM.delete');
Route::get('admin/list_commandeM/{id}/mark-as-delivered', [CommandeMachineController::class, 'statut_livre'])->name('commande.markAsDelivered');
Route::get('admin/list_commandeM/{id}/facture/apercu',[CommandeMachineController::class,'apercufacture_machine'])->name('admin.list_commandeM.facture.apercu');

//*******************************/* fin  gestion commande machine-------------------------*/






                       //*******************************    gestion settings-------------------------*/

    Route::get('admin/list_compte/list',[AdminController::class,'adminlist_compte'])->name('compte');
    Route::get('admin/list_compte/add',[AdminController::class,'create'])->name('admin.list_compte.add');
    Route::post('admin/list_compte/add',[AdminController::class,'store'])->name('admin.list_compte.store');
    Route::get('admin/list_compte/{id}/edit',[AdminController::class,'settings'])->name('admin.settings');
    Route::post('admin/list_compte/{id}/update',[AdminController::class,'update'])->name('admin.settings.update');

    Route::get('admin/list_compte/{id}/delete',[AdminController::class,'destroy'])->name('admin.list_compte.delete');
   
   
   
    Route::get('admin/list_compte/add_client',[AdminController::class,'create_client'])->name('admin.list_compte.add_client');
    Route::post('admin/list_compte/add_client',[AdminController::class,'store_client'])->name('admin.store_client');
    Route::get('admin/list_compte',[AdminController::class,'clientlist_compte'])->name('admin.client_compte');
    Route::get('admin/list_compte/{id}/edit_client',[AdminController::class,'edit_client'])->name('admin.list_client.edit');
    Route::post('admin/list_compte/{id}/edit_client',[AdminController::class,'update_client'])->name('admin.list_client.update');
    Route::get('admin/list_compte/{id}/delete_client',[AdminController::class,'destroy_client'])->name('admin.list_compte.delete_client');

                       //*******************************   fin gestion settings-------------------------*/



//*******************************/*gestion fac-------------------------*/
Route::get('admin/list_faq',[FaqController::class,'adminlist_faq'])->name('admin.list_faq');
Route::get('admin/list_faq/add',[FaqController::class,'create'])->name('admin.list_faq.add');
Route::post('admin/list_faq/add',[FaqController::class,'store'])->name('admin.list_faq.store');
Route::get('admin/list_faq/{id}/edit',[FaqController::class,'edit'])->name('admin.list_faq.edit');
Route::post('admin/list_faq/{id}/update',[FaqController::class,'update'])->name('admin.list_faq.update');
Route::get('admin/list_faq/{id}/delete',[FaqController::class,'destroy'])->name('admin.list_faq.delete');
                                /*fin gestion fac*/

                   //*******************************/*gestion banner-------------------------*/
Route::get('admin/list_banners',[BannerController::class,'adminlist_banner'])->name('admin.list_banners');
Route::get('admin/list_banners/add',[BannerController::class,'create'])->name('admin.list_banners.add');
Route::post('admin/list_banners/add',[BannerController::class,'store'])->name('admin.list_banners.store');
Route::get('admin/list_banners/{id}/edit',[BannerController::class,'edit'])->name('admin.list_banners.edit');
Route::post('admin/list_banners/{id}/update',[BannerController::class,'update'])->name('admin.list_banners.update');
Route::get('admin/list_banners/{id}/deleteimage',[BannerController::class,'deleteimage'])->name('admin.banners.deleteimage');
Route::get('admin/list_banners/{id}/delete',[BannerController::class,'destroy'])->name('admin.banners.delete');
                   //*******************************   fin gestion banner-------------------------*/

});
/*-----------------------------------Commade-----------------------------------------------------*/
Route::post('/ajouter-au-panier', [CommandeController::class, 'ajouterAuPanier'])->name('ajouter-au-panier');





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');