<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kiosk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index()
    {
        return Kiosk::all();
    }

    public function kiosk($id)
    {
        return Kiosk::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scheme_id' => 'required',
            'x' => 'required',
            'y' => 'required',
        ]);

        $kiosk = new Kiosk();
        
        $kiosk->name = $request->name;
        $kiosk->scheme_id = $request->scheme_id;
        $kiosk->x = $request->x;
        $kiosk->y = $request->y;

        $kiosk->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'scheme_id' => 'required',
            'x' => 'required',
            'y' => 'required',
        ]);

        $kiosk = Kiosk::find($id);
        
        $kiosk->name = $request->name;
        $kiosk->scheme_id = $request->scheme_id;
        $kiosk->x = $request->x;
        $kiosk->y = $request->y;

        $kiosk->save();
    }
}
