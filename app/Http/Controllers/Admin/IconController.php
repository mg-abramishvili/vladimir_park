<?php

namespace App\Http\Controllers\Admin;

use App\Models\Icon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function index()
    {
        return Icon::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
        ]);

        $icon = new Icon();
        
        $icon->image = $request->image;

        $icon->save();
    }
}
