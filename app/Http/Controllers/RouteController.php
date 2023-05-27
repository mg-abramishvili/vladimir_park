<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index($kiosk)
    {
        return Route::where('kiosk_id', $kiosk)->with('kiosk')->get();
    }

    public function route($id)
    {
        return Route::find($id);
    }
}
