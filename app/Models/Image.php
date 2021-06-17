<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function delete()
    {
        Storage::delete('/public/images/' . $this->file_name);
        return parent::delete();
    }
}
