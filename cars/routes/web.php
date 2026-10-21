<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\CategorieController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Front\BannerController;
use App\Http\Controllers\StockmachineController;
use App\Http\Controllers\ModelMachineController;
use App\Http\Controllers\GestionMachineController;
use App\Http\Controllers\MarqueMachineController;
use App\Http\Controllers\Front\DashController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeMachineController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/FAQ', [FaqController::class, 'index'])->name('faq');
Route::get('contact-US', [ContactController::class, 'index'])->name('contact.us.add');
Route::post('contact-US/add', [ContactController::class, 'store'])->name('contact.us.store');
Route::get('search', [HomeController::class, 'search'])->name('search');
Route::get('/machine', [GestionMachineController::class, 'index'])->name('machine');

// Admin login (anti-brute-force : 5 tentatives / minute par login + IP)
Route::get('/admin', [AdminController::class, 'login_form'])->name('login.form');
Route::post('/admin/login-functionality', [AdminController::class, 'login_functionality'])
    ->middleware('throttle:login')
    ->name('login.functionality');

// Protected area (authentification requise)
Route::middleware(['admin', 'revalidate'])->group(function () {

    /* ─────────────────────────────────────────────
     |  Routes partagées (tous rôles authentifiés)
     ───────────────────────────────────────────── */
    Route::get('logoutSession', [AdminController::class, 'logoutadmin'])->name('logoutSession');

    /* ─────────────────────────────────────────────
     |  ADMIN
     ───────────────────────────────────────────── */
    Route::middleware('role:admin')->group(function () {

        // Dashboard
        Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('admin/dashboard/support', [DashController::class, 'support'])->name('admin.support.dashboard');
        Route::get('admin/dashboard/vente/machine', [DashController::class, 'machine'])->name('admin.machine.dashboard');
        Route::get('admin/dashboard/produit', [DashController::class, 'produit'])->name('admin.produit.dashboard');

        // Gestion des pièces/machines
        Route::get('admin/list_machine', [GestionMachineController::class, 'adminlist_machine'])->name('admin.list_machine');
        Route::get('admin/list_machine/add', [GestionMachineController::class, 'create'])->name('admin.list_machine.add');
        Route::post('admin/list_machine/add', [GestionMachineController::class, 'store'])->name('admin.list_machine.store');
        Route::get('admin/list_machine/{id}/detail', [GestionMachineController::class, 'show'])->name('admin.list_machine.detail');
        Route::get('admin/list_machine/{id}/edit', [GestionMachineController::class, 'edit'])->name('admin.list_machine.edit');
        Route::post('admin/list_machine/{id}/update', [GestionMachineController::class, 'update'])->name('admin.list_machine.update');
        Route::get('admin/list_machine/{id}/delete', [GestionMachineController::class, 'destroy'])->name('admin.list_machine.delete');
        Route::post('admin/checkreference', [GestionMachineController::class, 'checkReference'])->name('admin.checkreference');

        // Gestion des marques machines
        Route::get('admin/list_marque', [MarqueMachineController::class, 'adminlist_marque'])->name('list_marque.machine');
        Route::get('admin/list_marque/add', [MarqueMachineController::class, 'create'])->name('list_marque.machine.add');
        Route::post('admin/list_marque/add', [MarqueMachineController::class, 'store'])->name('list_marque.machine.store');
        Route::get('admin/list_marque/{id}/delete', [MarqueMachineController::class, 'destroy'])->name('list_marque.machine.delete');
        Route::get('admin/list_marque/{id}/editmachine', [MarqueMachineController::class, 'edit'])->name('list_marque.machine.edit');
        Route::post('admin/list_marque/{id}/update', [MarqueMachineController::class, 'update'])->name('list_marque.update');

        // Gestion des modèles machines
        Route::get('admin/list_model', [ModelMachineController::class, 'adminlist_model'])->name('list_model.machine');
        Route::get('admin/list_model/add', [ModelMachineController::class, 'create'])->name('list_model.machine.add');
        Route::post('admin/list_model/add', [ModelMachineController::class, 'store'])->name('list_model.machine.store');
        Route::get('admin/list_model/{id}/delete', [ModelMachineController::class, 'destroy'])->name('list_model.machine.delete');
        Route::get('admin/list_model/{id}/edit', [ModelMachineController::class, 'edit'])->name('list_model.machine.edit');
        Route::post('admin/list_model/{id}/update', [ModelMachineController::class, 'update'])->name('list_model.update');

        // Gestion des catégories
        Route::get('admin/list_categories', [CategorieController::class, 'adminlist_categorie'])->name('admin.list_categories');
        Route::get('admin/list_categories/add', [CategorieController::class, 'create'])->name('admin.list_categories.add');
        Route::post('admin/list_categories/add', [CategorieController::class, 'store'])->name('admin.list_categories.store');
        Route::post('admin/list_categories/{id}/update', [CategorieController::class, 'update'])->name('admin.list_categories.update');
        Route::get('admin/list_categories/{id}/edit', [CategorieController::class, 'edit'])->name('admin.list_categories.edit');
        Route::get('admin/list_categories/{id}/delete', [CategorieController::class, 'destroy'])->name('admin.list_categories.delete');

        // Stock
        Route::get('admin/list_stock/machine', [StockmachineController::class, 'adminlist_stockM'])->name('admin.list_stock.machine');
        Route::get('admin/list_stock/{id}/edit_machine', [StockmachineController::class, 'edit'])->name('admin.list_stock.machine.edit');
        Route::post('admin/list_stock/{id}/update_machine', [StockmachineController::class, 'update'])->name('admin.list_stock.machine.update');

        // Clients
        Route::get('admin/list_client', [ClientController::class, 'adminlist_client'])->name('admin.list_client');
        Route::get('admin/list_client/add', [ClientController::class, 'create'])->name('admin.list_client.add');

        // Gestion des livreurs
        Route::get('admin/list_livreurs', [AdminController::class, 'livreurlist_compte'])->name('admin.list_livreur');
        Route::get('admin/list_livreurs/add', [AdminController::class, 'create_livreur'])->name('admin.list_livreurs.add');
        Route::post('admin/list_livreurs/add', [AdminController::class, 'store_livreur'])->name('admin.list_livreurs.store');
        Route::get('admin/list_livreurs/{id}/edit', [AdminController::class, 'edit_livreur'])->name('admin.list_livreur.edit');
        Route::post('admin/list_livreurs/{id}/update', [AdminController::class, 'update_livreur'])->name('admin.list_livreur.update');
        Route::get('admin/list_compte/{id}/delete_livreur', [AdminController::class, 'destroy_livreur'])->name('admin.list_compte.delete_livreur');

        // SAV / Support (gestion par l'admin)
        Route::get('admin/support', [SupportController::class, 'adminlist_support'])->name('admin.list_support');
        Route::get('admin/support/{id}/show', [SupportController::class, 'show'])->name('admin.list_support.show');
        Route::get('admin/support/{id}/destroy', [SupportController::class, 'destroy'])->name('admin.list_support.delete');

        // Commandes machines (actions de gestion)
        Route::get('admin/list_commandeM/{id}/maj', [CommandeMachineController::class, 'maj'])->name('admin.list_commandeM.updateLivreur');
        Route::post('admin/list_commandeM/{id}/updateLivreur', [CommandeMachineController::class, 'updateLivreur'])->name('admin.list_commandeM.edit');
        Route::get('admin/list_commandeM/{id}/delete', [CommandeMachineController::class, 'destroy'])->name('admin.list_commandeM.machine.delete');
        Route::get('admin/list_commandeM/{id}/destroy', [CommandeMachineController::class, 'destroy'])->name('admin.list_commandeM.delete');

        // Gestion des comptes admin
        Route::get('admin/list_compte/list', [AdminController::class, 'adminlist_compte'])->name('compte');
        Route::get('admin/list_compte/add', [AdminController::class, 'create'])->name('admin.list_compte.add');
        Route::post('admin/list_compte/add', [AdminController::class, 'store'])->name('admin.list_compte.store');
        Route::get('admin/list_compte/{id}/edit', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('admin/list_compte/{id}/update', [AdminController::class, 'update'])->name('admin.settings.update');
        Route::get('admin/list_compte/{id}/delete', [AdminController::class, 'destroy'])->name('admin.list_compte.delete');

        // Gestion des comptes client
        Route::post('admin/list_compte/add_client', [AdminController::class, 'store_client'])->name('admin.store_client');
        Route::get('admin/list_compte', [AdminController::class, 'clientlist_compte'])->name('admin.client_compte');
        Route::get('admin/list_compte/{id}/edit_client', [AdminController::class, 'edit_client'])->name('admin.list_client.edit');
        Route::post('admin/list_compte/{id}/edit_client', [AdminController::class, 'update_client'])->name('admin.list_client.update');
        Route::get('admin/list_compte/{id}/delete_client', [AdminController::class, 'destroy_client'])->name('admin.list_compte.delete_client');

        // FAQ
        Route::get('admin/list_faq', [FaqController::class, 'adminlist_faq'])->name('admin.list_faq');
        Route::get('admin/list_faq/add', [FaqController::class, 'create'])->name('admin.list_faq.add');
        Route::post('admin/list_faq/add', [FaqController::class, 'store'])->name('admin.list_faq.store');
        Route::get('admin/list_faq/{id}/edit', [FaqController::class, 'edit'])->name('admin.list_faq.edit');
        Route::post('admin/list_faq/{id}/update', [FaqController::class, 'update'])->name('admin.list_faq.update');
        Route::get('admin/list_faq/{id}/delete', [FaqController::class, 'destroy'])->name('admin.list_faq.delete');

        // Bannières
        Route::get('admin/list_banners', [BannerController::class, 'adminlist_banner'])->name('admin.list_banners');
        Route::get('admin/list_banners/add', [BannerController::class, 'create'])->name('admin.list_banners.add');
        Route::post('admin/list_banners/add', [BannerController::class, 'store'])->name('admin.list_banners.store');
        Route::get('admin/list_banners/{id}/edit', [BannerController::class, 'edit'])->name('admin.list_banners.edit');
        Route::post('admin/list_banners/{id}/update', [BannerController::class, 'update'])->name('admin.list_banners.update');
        Route::get('admin/list_banners/{id}/delete', [BannerController::class, 'destroy'])->name('admin.banners.delete');

        // Contacts
        Route::get('admin/list_contact', [ContactController::class, 'list_contac'])->name('list_contact');
        Route::get('admin/contact-US/{id}/detail', [ContactController::class, 'show'])->name('contactjj.us.show');
        Route::get('admin/contact-US/{id}/delete', [ContactController::class, 'destroy'])->name('contact.us.destroy');
    });

    /* ─────────────────────────────────────────────
     |  ADMIN + LIVREUR
     ───────────────────────────────────────────── */
    Route::middleware('role:admin,livreur')->group(function () {
        Route::post('/clear-cache', [CacheController::class, 'clear'])->name('cache.clear');
    });

    /* ─────────────────────────────────────────────
     |  ADMIN + CLIENT + LIVREUR (consultation des commandes)
     ───────────────────────────────────────────── */
    Route::middleware('role:admin,client,livreur')->group(function () {
        Route::get('admin/list_commandeM', [CommandeMachineController::class, 'adminlist_commande_machine'])->name('admin.list_commandeM');
        Route::get('admin/list_commandeM/{id}/facture', [CommandeMachineController::class, 'facture'])->name('admin.list_commandeM.facture');
        Route::get('admin/list_commandeM/{id}/facture/apercu', [CommandeMachineController::class, 'apercufacture_machine'])->name('admin.list_commandeM.facture.apercu');
    });

    /* ─────────────────────────────────────────────
     |  ADMIN + CLIENT (création d'un ticket SAV)
     ───────────────────────────────────────────── */
    Route::middleware('role:admin,client')->group(function () {
        Route::get('admin/support/add', [SupportController::class, 'create'])->name('admin.list_support.add');
        Route::post('admin/support/add', [SupportController::class, 'store'])->name('admin.list_support.store');
    });

    /* ─────────────────────────────────────────────
     |  ADMIN + CLIENT (création d'une commande)
     ───────────────────────────────────────────── */
    Route::middleware('role:admin,client')->group(function () {
        Route::get('admin/list_commandeM/add', [CommandeMachineController::class, 'create_commande'])->name('admin.list_commandeM.add');
        Route::post('admin/list_commandeM/add', [CommandeMachineController::class, 'store'])->name('admin.list_commandeM.store');
    });

    /* ─────────────────────────────────────────────
     |  CLIENT
     ───────────────────────────────────────────── */
    Route::middleware('role:client')->group(function () {
        Route::get('client/list_machine', [GestionMachineController::class, 'clientlist_machine'])->name('client.list_machine');
        Route::get('client/list_machine/{id}/detail', [GestionMachineController::class, 'clientshow_machine'])->name('client.show.machine');
    });

    /* ─────────────────────────────────────────────
     |  LIVREUR
     ───────────────────────────────────────────── */
    Route::middleware('role:livreur')->group(function () {
        Route::get('admin/dashboardL', [AdminController::class, 'dashboard'])->name('dashboardL');
        Route::get('admin/list_commandeM/{id}/mark-as-delivered', [CommandeMachineController::class, 'statut_livre'])->name('admin.list_commandeM.markAsDelivered');
    });
});
