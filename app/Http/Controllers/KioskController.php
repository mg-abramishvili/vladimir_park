<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index()
    {
        return Kiosk::all();
    }
}
