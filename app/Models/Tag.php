<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['body'];

    public function events()
    { //eventi che hanno questo tag
        return $this->belongsToMany(Event::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
