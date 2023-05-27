<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scheme;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    public function index()
    {
        return Scheme::all();
    }

    public function scheme($id)
    {
        return Scheme::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
        ]);

        $scheme = new Scheme();
        
        $scheme->name = $request->name;
        $scheme->image = $request->image;

        $scheme->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required',
        ]);

        $scheme = Scheme::find($id);
        
        $scheme->name = $request->name;
        $scheme->image = $request->image;

        $scheme->save();
    }
}
