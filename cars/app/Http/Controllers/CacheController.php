<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function clear()
    {
        Artisan::call('optimize:clear');
        Cache::flush();
        return redirect()->back()->with('status', 'Cache cleared successfully!');
    }
}
