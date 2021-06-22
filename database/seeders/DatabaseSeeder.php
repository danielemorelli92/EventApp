<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\{Comment, User, Tag, Event, Image};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'user@email.com'
        ]);
        User::factory()->create([
            'email' => 'admin@email.com'
        ]);

        DB::table('users')
            ->where('email', '=', 'admin@email.com')
            ->update(['type' => 'admin']);

        $events = collect();

        for ($i = 1; $i <= 20; $i++) {
            $coordinates = $this->generate_random_point([42.4612, 14.2111], 120.0);
            $events->push(
                Event::factory()->hasImages(3)->hasAuthor()->create([
                    'latitude' => $coordinates[0],
                    'longitude' => $coordinates[1]
                ])
            );
        }

        $events->push(Event::factory()->hasImages(4)->create([
            'latitude' => 42.529336,
            'longitude' => 14.1420603,
            'starting_time' => date(now()->addDays(rand(1, 120)))
        ]));
        $events->push(Event::factory()->hasImages(4)->hasAuthor()->create([
            'latitude' => 42.473373,
            'longitude' => 14.079042,
            'starting_time' => date(now()->addDays(rand(1, 120)))
        ]));
        $events->push(Event::factory()->hasImages(4)->hasAuthor()->create([
            'latitude' => 42.362286,
            'longitude' => 14.152149,
            'starting_time' => date(now()->addDays(rand(1, 120)))
        ]));
        $events->push(Event::factory()->hasImages(4)->hasAuthor()->create([
            'latitude' => 42.394787,
            'longitude' => 14.296755,
            'starting_time' => date(now()->addDays(rand(1, 120)))
        ]));
        $events->push(Event::factory()->hasImages(4)->hasAuthor()->create([
            'latitude' => 42.405689,
            'longitude' => 14.290663,
            'starting_time' => date(now()->addDays(rand(1, 120)))
        ]));

        $tags = Tag::factory()->count(16)->create();
        $users = User::factory()->count(100)->create();

        foreach ($events as $event) {
            $n = rand(0, 8);
            for ($i = 0; $i < $n; $i++) { // associa da 0 a 8 tag
                $tag = $tags[rand(0, 15)];
                $event->load('tags');
                if (!$event->tags->contains($tag)) {
                    $event->tags()->attach($tag);
                }
            }
            $n = rand(0, 100);
            for ($i = 0; $i < $n; $i++) {
                $user = $users[rand(0, 99)];
                $event->load('registeredUsers');
                if (!$event->registeredUsers->contains($user)) {
                    $event->registeredUsers()->attach($user);
                }
            }
            $n = rand(0, 8);
            $last_comment = null;
            for ($i = 0; $i < $n; $i++) {
                $comment = null;
                if (rand(0, 1) == 0) {
                    $comment = Comment::factory()->create([
                        'event_id' => $event->id,
                        'author_id' => $users[rand(0, 99)]->id,
                        'parent_id' => $last_comment
                    ]);

                } else {
                    $comment = Comment::factory()->create([
                        'event_id' => $event->id,
                        'author_id' => $users[rand(0, 99)]->id,
                        'parent_id' => null
                    ]);
                }
                $last_comment = $comment;
            }
        }
    }

    /**
     * Given a $centre (latitude, longitude) co-ordinates and a
     * distance $radius (miles), returns a random point (latitude,longtitude)
     * which is within $radius miles of $centre.
     *
     * @param array $centre Numeric array of floats. First element is
     *                       latitude, second is longitude.
     * @param float $radius The radius (in miles).
     * @return array         Numeric array of floats (lat/lng). First
     *                       element is latitude, second is longitude.
     */
    protected function generate_random_point($centre, $radius)
    {

        $radius_earth = 6371; //km

        //Pick random distance within $distance;
        $distance = lcg_value() * $radius;

        //Convert degrees to radians.
        $centre_rads = array_map('deg2rad', $centre);

        //First suppose our point is the north pole.
        //Find a random point $distance miles away
        $lat_rads = (pi() / 2) - $distance / $radius_earth;
        $lng_rads = lcg_value() * 2 * pi();


        //($lat_rads,$lng_rads) is a point on the circle which is
        //$distance miles from the north pole. Convert to Cartesian
        $x1 = cos($lat_rads) * sin($lng_rads);
        $y1 = cos($lat_rads) * cos($lng_rads);
        $z1 = sin($lat_rads);


        //Rotate that sphere so that the north pole is now at $centre.

        //Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
        $rot = (pi() / 2) - $centre_rads[0];
        $x2 = $x1;
        $y2 = $y1 * cos($rot) + $z1 * sin($rot);
        $z2 = -$y1 * sin($rot) + $z1 * cos($rot);

        //Rotate in z axis by $rot = $centre_rads[1]
        $rot = $centre_rads[1];
        $x3 = $x2 * cos($rot) + $y2 * sin($rot);
        $y3 = -$x2 * sin($rot) + $y2 * cos($rot);
        $z3 = $z2;


        //Finally convert this point to polar co-ords
        $lng_rads = atan2($x3, $y3);
        $lat_rads = asin($z3);

        return array_map('rad2deg', array($lat_rads, $lng_rads));
    }
}
