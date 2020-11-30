<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Meetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTicketsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_asign_tickets_to_customer()
    {
        $this->singInApi();

        $customer = Customer::factory()->create();

        $meetup = Meetup::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'meetup_id' => $meetup->id,
        ];

        $response = $this->postJson('api/tickets/', $data);

        $response->assertCreated();

        $this->assertCount(1, $customer->tickets);

        $this->assertDatabaseHas('tickets', $data);

        $response->assertExactJson(['data' => 'success']);
    }

    public function test_when_a_ticket_is_register_meetup_update_quantity()
    {
        $this->singInApi();

        $customer = Customer::factory()->create();

        $meetup = Meetup::factory()->create([
            'quantity' => 10,
            'sold' => 0
        ]);

        $data = [
            'customer_id' => $customer->id,
            'meetup_id' => $meetup->id,
        ];

        $this->postJson('api/tickets/', $data);

        $meetup = $meetup->fresh();
        $this->assertEquals($meetup->availability, 9);
        $this->assertEquals($meetup->sold, 1);

    }
}
