<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function users() {  //utenti registrati all'evento
        return $this->hasMany(User::class);
    }
    public function images() { //immagini della pagina evento
        return $this->hasMany(Image::class);
    }
    public function tags() { //tag dell'evento
        return $this->hasMany(Tag::class);
    }
}
