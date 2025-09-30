<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class DashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Support()
    {
        return view('back.Dashboard.support');
    }
    public function machine()
    {
        return view('back.Dashboard.machine');
    }
    public function produit()
    {
        return view('back.Dashboard.produit');
    }
    

   
}
