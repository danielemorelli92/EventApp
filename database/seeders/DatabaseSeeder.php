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
        Event::factory(10)->hasTags(2)->hasImages(3)->hasUsers(3)->create();
    }
}
