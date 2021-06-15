<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Chat extends Model
{
    use HasFactory;

    public function sender(): Relation
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): Relation
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
