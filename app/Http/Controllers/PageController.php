<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return Page::where('parent_id', null)->orderBy('order', 'asc')->with('blocks', 'icon')->get();
    }

    public function page($id)
    {
        return Page::query()
            ->with([
                'blocks' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'children' => function ($query) {
                    $query->orderBy('order', 'asc')->with('blocks', 'icon');
                },
                'parent' => function ($query) {
                    $query->with('blocks');
                },
                'icon'
            ])
            ->find($id);
    }
}
