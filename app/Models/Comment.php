<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author(): Relation
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parent(): Relation
    {
        return $this->belongsTo(Comment::class, 'foreign_id');
    }

    public function comments(): Relation
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function event(): Relation
    {
        return $this->belongsTo(Event::class);
    }
}
