<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function events() { //eventi che hanno questo tag
        return $this->belongsToMany(Event::class);
    }
}
