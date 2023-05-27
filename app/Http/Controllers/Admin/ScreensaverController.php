<?php

namespace App\Http\Controllers\Admin;

use App\Models\Screensaver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScreensaverController extends Controller
{
    public function index()
    {
        return Screensaver::all();
    }

    public function screensaver($id)
    {
        return Screensaver::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);

        $screensaver = new Screensaver();
        
        $screensaver->name = $request->name;
        $screensaver->type = $request->type;
        $screensaver->content = $request->content;

        $screensaver->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);

        $screensaver = Screensaver::find($id);
        
        $screensaver->name = $request->name;
        $screensaver->type = $request->type;
        $screensaver->content = $request->content;

        $screensaver->save();
    }

    public function delete($id)
    {
        $screensaver = Screensaver::find($id);

        $screensaver->delete();
    }
}
