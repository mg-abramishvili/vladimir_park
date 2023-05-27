<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::orderBy('date', 'asc')->get();
    }

    public function event($id)
    {
        return Event::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'image' => 'required',
        ]);

        $event = new Event();
        
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->image = $request->image;

        $event->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'image' => 'required',
        ]);

        $event = Event::find($id);
        
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->image = $request->image;

        $event->save();
    }

    public function delete($id)
    {
        $event = Event::find($id);

        $event->delete();
    }
}
