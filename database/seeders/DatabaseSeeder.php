<?php

namespace Database\Seeders;

use App\Models\{User,Tag,Event,Image};
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

        $events = Event::factory()->hasImages(4)->count(15)->hasAuthor(User::factory()->create())->create();
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
                $event->tags()->attach($tags[rand(0, 15)]);
            }
            $n = rand(0, 100);
            for ($i = 0; $i < $n; $i++) {
                $event->registeredUsers()->attach($users[rand(0, 99)]);
            }
        }
    }
}
