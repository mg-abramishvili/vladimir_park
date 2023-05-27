<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        return Config::find(1);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'logo' => 'required',
        ]);

        $config = Config::find(1);
        
        $config->title = $request->title;
        $config->logo = $request->logo;

        $config->save();
    }
}
