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
        $events = Event::factory()->hasImages(4)->count(20)->create();
        $tags = Tag::factory()->count(16)->create();
        $users = User::factory()->count(100)->create();

        foreach ($events as $event) {
            $n = rand(0, 8);
            for ($i = 0; $i < $n; $i++) { // associa da 0 a 8 tag
                $event->tags()->attach($tags[rand(0, 15)]);
            }
            $n = rand(0, 100);
            for ($i = 0; $i < $n; $i++) {
                $event->users()->attach($users[rand(0, 99)]);
            }
        }
    }
}
