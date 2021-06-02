<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function registeredUsers()
    {  //utenti registrati all'evento
        return $this->belongsToMany(User::class, 'registrations', 'event_id', 'user_id');
    }

    public function images()
    { //immagini della pagina evento
        return $this->hasMany(Image::class);
    }

    public function tags()
    { //tag dell'evento
        return $this->belongsToMany(Tag::class);
    }

    public function externalRegistrations()
    { //registrazioni esterne per l'evento
        return $this->hasMany(ExternalRegistration::class);
    }

    public function author()
    {   // creatore dell'evento
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getImage()
    {
        $image = $this->images->first();
        if ($image != null) {
            return $image->url;
        } else {
            return url('/images/event-stock.jpg');
        }
    }

    public function getDistanceToMe(): float
    {
        // Coordinate di Pescara
        $myLatitude = 42.4612;
        $myLongitude = 14.2111;

        return Event::getDistance($this->latitude, $this->longitude, $myLatitude, $myLongitude);
    }

    public static function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo): float
    {
        $rad = M_PI / 180;
        //Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin($latitudeFrom * $rad)
            * sin($latitudeTo * $rad) + cos($latitudeFrom * $rad)
            * cos($latitudeTo * $rad) * cos($theta * $rad);

        return acos($dist) / $rad * 60 * 1.853;
    }
}
