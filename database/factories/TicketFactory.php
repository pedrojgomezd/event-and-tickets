<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Meetup;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory()->create(),
            'meetup_id' => Meetup::factory()->create(), 
            'code' => $this->faker->numerify('####-####'), 
            'is_used' => $this->faker->boolean(), 
            'sold_by' => User::factory()->create(),
        ];
    }
}
