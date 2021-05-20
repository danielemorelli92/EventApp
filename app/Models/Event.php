<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {  //utenti registrati all'evento
        return $this->belongsToMany(User::class);
    }

    public function images()
    { //immagini della pagina evento
        return $this->hasMany(Image::class);
    }

    public function tags()
    { //tag dell'evento
        return $this->belongsToMany(Tag::class);
    }

    public function externalRegistrations()
    { //registrazioni esterne per l'evento
        return $this->hasMany(ExternalRegistration::class);
    }
}
