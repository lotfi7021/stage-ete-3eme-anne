<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;  

class CacheController extends Controller
{
    public function clear()
    {
        Artisan::call('optimize:clear');
        return redirect()->back()->with('status', 'Cache cleared successfully!');
    }
}
