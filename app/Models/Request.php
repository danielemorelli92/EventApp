<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static make(array $array)
 */
class Request extends Model
{
    use HasFactory;

    protected $guarded = ['type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equals(Request $other): bool
    {
        return $this->nome == $other->nome &&
            $this->cognome == $other->cognome &&
            $this->data_nascita == $other->data_nascita &&
            $this->codice_documento == $other->codice_documento &&
            $this->tipo_documento == $other->tipo_documento;
    }
}
