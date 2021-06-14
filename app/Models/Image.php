<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'title',
        'event_id'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
