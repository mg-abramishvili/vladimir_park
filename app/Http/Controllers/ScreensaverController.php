<?php

namespace App\Http\Controllers;

use App\Models\Screensaver;
use Illuminate\Http\Request;

class ScreensaverController extends Controller
{
    public function index()
    {
        return Screensaver::all();
    }
}
