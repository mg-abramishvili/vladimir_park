<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return Banner::all();
    }

    public function banner($id)
    {
        return Banner::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);

        $banner = new Banner();
        
        $banner->name = $request->name;
        $banner->type = $request->type;
        $banner->content = $request->content;

        $banner->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);

        $banner = Banner::find($id);
        
        $banner->name = $request->name;
        $banner->type = $request->type;
        $banner->content = $request->content;

        $banner->save();
    }

    public function delete($id)
    {
        $banner = Banner::find($id);

        $banner->delete();
    }
}
