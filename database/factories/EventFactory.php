<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'host' => $this->faker->name(),
            'type' => $this->faker->word(),
            'max_partecipants' => $this->faker->numberBetween(10, 10000),
            'price' => $this->faker->numberBetween(0, 50000),
            'ticket_office' => $this->faker->url(),
            'website' => $this->faker->url(),
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'starting_time' => $this->faker->dateTimeBetween('-1 year', '1 year'),
            'ending_time' => $this->faker->dateTimeBetween('now', '1 year')
        ];
    }
}
