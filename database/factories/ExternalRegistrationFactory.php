<?php

namespace Database\Factories;

use App\Models\ExternalRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExternalRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExternalRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cf' => $this->faker->bothify('######??#??#???#'),
        ];
    }
}
