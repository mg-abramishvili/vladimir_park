<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(Page::class);
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }
}
