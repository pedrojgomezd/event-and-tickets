<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Meetup;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('customers', [
                'id', 'name', 'document', 'birth_day', 'email', 'phone', 'created_by'
            ]), 
        1);
    }

    public function test_a_customer_can_has_many_tickets_for_meetups_asigns()
    {
        $customer = Customer::factory()->create();

        $tickets = [
            Ticket::factory()->make(),
            Ticket::factory()->make(),
            Ticket::factory()->make(),
        ];

        $customer->tickets()->saveMany($tickets);

        $this->assertEquals($tickets[0]->toArray(), $customer->tickets->load('meetup')->first()->toArray());
    }

    public function test_a_customer_can_has_many_meetups_through_tickets()
    {
        $customer = Customer::factory()->create();

        $meetups = Meetup::factory()->count(3)->create();

        $tickets = [
            Ticket::factory()->make(['meetup_id' => $meetups[0]]),
            Ticket::factory()->make(['meetup_id' => $meetups[1]]),
            Ticket::factory()->make(['meetup_id' => $meetups[2]]),
        ];

        $customer->tickets()->saveMany($tickets);

        $this->assertCount(3, $customer->tickets);

        $this->assertCount(3, $customer->meetups->toArray());
        
    }
}
