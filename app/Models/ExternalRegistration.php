<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExternalRegistration Registrazioni ad un evento per un utente non registrato
 *  al portale.
 * @package App\Models
 */
class ExternalRegistration extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
