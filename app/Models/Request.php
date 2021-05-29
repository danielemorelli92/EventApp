<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $guarded= ['accettazione'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
