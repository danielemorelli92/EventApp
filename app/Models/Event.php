<?php

namespace App\Models;

use Carbon\Traits\Creator;
use Database\Factories\UserFactory;
use Faker\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getImage()
    {
        $image = $this->images->first();
        if ($image != null) {
            return $image->file_name;
        } else {
            return 'stock.svg';
        }
    }

    public function getImages()
    {
        return $this->images;
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

    public function offer()
    {
        return $this->hasOne(Offer::class);
    }

    /**
     *
     * @param string|Carbon $date La data fornita
     *
     * @return bool :true: se l'evento inizia prima della data fornita, altrimenti :false:
     */
    public function start_before($date)
    {
        return (new Carbon($this->starting_time))->isBefore(new Carbon($date));
    }

    /**
     * @param string|Carbon $date La data fornita
     * @return bool :true: se l'evento inizia dopo della data fornita, altrimenti :false:
     */
    public function start_after($date)
    {
        return (new Carbon($this->starting_time))->isAfter(new Carbon($date));
    }

    /**
     * Restituisce true se l'evento inizia tra le due date fornite.
     *
     * @param string|Carbon $first_date La prima data fornita
     * @param string|Carbon $second_date La seconda data fornita
     * @return bool :true: se l'evento inizia in mezzo alle due date fornite, :false: altrimenti
     */
    public function start_between($first_date, $second_date)
    {
        return $this->start_after($first_date) && $this->start_before($second_date);
    }

    /**
     * @param int $day Il giorno fornito
     * @return bool :true: se l'evento inizia in quel giorno, :false: altrimenti
     */
    public function isThisDay(int $day)
    {
        return (new Carbon($this->starting_time))->day == $day;
    }
}
