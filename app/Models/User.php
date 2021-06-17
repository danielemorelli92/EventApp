<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function registeredEvents(): Relation
    {
        return $this->belongsToMany(Event::class, 'event_user', 'event_id', 'user_id');
    }

    public function tags(): Relation
    {
        return $this->belongsToMany(Tag::class);
    }


    public function request(): Relation
    {
        return $this->hasOne(Request::class);
    }

    public function createdEvents(): Relation
    {
        return $this->hasMany(Event::class, 'author_id');
    }

    public function comments(): Relation
    {
        return $this->hasMany(Comment::class, 'author_id');
    }
}
