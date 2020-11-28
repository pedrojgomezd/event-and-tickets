<?php

namespace Database\Factories;

use App\Models\Meetup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meetup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 10);

        return [
            'name' => $this->faker->name,
            'cover_path' => 'cover-meetup.png',
            'date' => $this->faker->date(),
            'place' => $this->faker->city,
            'description' => $this->faker->paragraph(),
            'quantity' => $quantity ,
            'sold' => $quantity ,
            'created_by' => User::factory()->create(),
        ];
    }
}
