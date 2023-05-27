<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $casts = [
        'route_code_floor1' => 'json',
        'route_code_floor2' => 'json'
    ];

    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class);
    }
}
