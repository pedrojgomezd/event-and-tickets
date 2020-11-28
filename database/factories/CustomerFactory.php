<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'document' => $this->faker->numerify('##.###.###'),
            'birth_day' => $this->faker->date(),
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'created_by' => User::factory()->create(),
        ];
    }
}
