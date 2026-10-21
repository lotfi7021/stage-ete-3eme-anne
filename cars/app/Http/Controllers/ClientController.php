<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function adminlist_client()
    {
        $titleSeo = 'Liste des clients';
        // La table (comptes admins rôle client) est servie par AdminController::clientlist_compte
        return view('back.Client.list', compact('titleSeo'));
    }

    public function create()
    {
        $titleSeo = 'Ajouter Client';
        return view('back.Client.add', compact('titleSeo'));
    }
}
