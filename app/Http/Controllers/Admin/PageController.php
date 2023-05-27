<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return Page::where('parent_id', null)->orderBy('order', 'asc')->get();
    }

    public function page($id)
    {
        return Page::query()
            ->with([
                'blocks' => function ($query) {
                    $query->orderBy('order', 'asc');
                },
                'children' => function ($query) {
                    $query->orderBy('order', 'asc');
                }
            ])
            ->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $page = new Page();
        
        $page->name = $request->name;
        $page->icon_id = $request->icon_id;
        $page->is_folder = $request->is_folder;
        $page->parent_id = $request->parent_id;

        $page->save();
        
        if(isset($request->blocks)) {
            foreach($request->blocks as $b)
            {
                $block = Block::find($b['id']);
    
                if(!$block) {
                    $block = new Block();
                }
    
                $block->page_id = $page->id;
                $block->type = $b['type'];
                $block->content = $b['content'];
                $block->order = $b['order'];
    
                $block->save();
            }
        }

        return $page->id;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $page = Page::find($id);
        
        $page->name = $request->name;
        $page->icon_id = $request->icon_id;
        $page->is_folder = $request->is_folder;
        $page->parent_id = $request->parent_id;

        $page->save();
        
        if(isset($page->blocks))
        {
            foreach($page->blocks as $block)
            {
                if(!in_array($block->id, array_column($request->blocks, 'id'))) {
                    $block->delete();
                }
            }
        }

        if(isset($request->blocks)) {
            foreach($request->blocks as $b)
            {
                $block = Block::find($b['id']);

                if(!$block) {
                    $block = new Block();
                }

                $block->page_id = $page->id;
                $block->type = $b['type'];
                $block->content = $b['content'];
                $block->order = $b['order'];

                $block->save();
            }
        }
    }

    public function delete($id)
    {
        $page = Page::find($id);

        if(count($page->children))
        {
            return response('Папку нельзя удалить - внутри есть страницы', 500);
        }

        foreach($page->blocks as $block)
        {
            $block->delete();
        }

        $page->delete();
    }

    public function reorderPages(Request $request)
    {
        $this->validate($request, [
            'pages' => 'required',
        ]);

        foreach($request->pages as $p)
        {
            $page = Page::find($p['id']);

            $page->order = $p['order'];

            $page->save();
        }
    }
}
