<?php

namespace App\Http\Controllers\Admin;

use App\Models\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index($kiosk)
    {
        return Route::where('kiosk_id', $kiosk)->with('kiosk')->get();
    }

    public function route($id)
    {
        return Route::with('kiosk')->find($id);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'kiosk_id' => 'required',
            'name' => 'required',
            'scheme1_id' => 'required',
            'route_code_floor1' => 'required',
        ]);

        $route = new Route();
        
        $route->kiosk_id = $request->kiosk_id;
        $route->name = $request->name;
        $route->scheme1_id = $request->scheme1_id;
        $route->route_code_floor1 = $request->route_code_floor1;

        if($request->scheme2_id) {
            $route->scheme2_id = $request->scheme2_id;
        }

        $route->floor1_text_begin = $request->floor1_text_begin;
        $route->floor1_text_end = $request->floor1_text_end;

        $route->floor2_text_begin = $request->floor2_text_begin;
        $route->floor2_text_end = $request->floor2_text_end;

        if (!isset($request->route_code_floor1)) {
            $request->route_code_floor1 = [];
        }
        $route->route_code_floor1 = $request->route_code_floor1;

        if (!isset($request->route_code_floor2)) {
            $request->route_code_floor2 = [];
        }
        $route->route_code_floor2 = $request->route_code_floor2;

        $route->save();
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'kiosk_id' => 'required',
            'name' => 'required',
            'scheme1_id' => 'required',
            'route_code_floor1' => 'required',
        ]);

        $route = Route::find($id);
        
        $route->kiosk_id = $request->kiosk_id;
        $route->name = $request->name;
        $route->scheme1_id = $request->scheme1_id;
        $route->route_code_floor1 = $request->route_code_floor1;

        if($request->scheme2_id) {
            $route->scheme2_id = $request->scheme2_id;
        }

        $route->floor1_text_begin = $request->floor1_text_begin;
        $route->floor1_text_end = $request->floor1_text_end;

        $route->floor2_text_begin = $request->floor2_text_begin;
        $route->floor2_text_end = $request->floor2_text_end;

        if (!isset($request->route_code_floor1)) {
            $request->route_code_floor1 = [];
        }
        $route->route_code_floor1 = $request->route_code_floor1;

        if (!isset($request->route_code_floor2)) {
            $request->route_code_floor2 = [];
        }
        $route->route_code_floor2 = $request->route_code_floor2;

        $route->save();
    }

    public function delete($id)
    {
        $route = Route::find($id);

        $route->delete();
    }
}
