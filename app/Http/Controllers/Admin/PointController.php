<?php

namespace App\Http\Controllers\Admin;

use App\Models\Point;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        return Point::all();
    }

    public function point($id)
    {
        return Point::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scheme_id' => 'required',
            'object' => 'required',
        ]);

        $point = new Point();
        
        $point->name = $request->name;
        $point->scheme_id = $request->scheme_id;
        $point->object = $request->object;

        $point->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scheme_id' => 'required',
            'object' => 'required',
        ]);

        $point = Point::find($id);
        
        $point->name = $request->name;
        $point->scheme_id = $request->scheme_id;
        $point->object = $request->object;

        $point->save();
    }
}
