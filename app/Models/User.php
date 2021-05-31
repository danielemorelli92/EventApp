<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'event_id', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'author_id');
    }
}
