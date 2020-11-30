<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Meetup;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MeetupTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('meetups', [
                'id', 'name', 'cover_path', 'date', 'place', 'description', 'quantity', 'sold', 'created_by'
            ]), 
        1);
    }

    public function test_a_meetup_can_has_a_user_creator()
    {
        $user = User::factory()->create();

        $meetup = Meetup::factory()->create([
            'created_by' => $user->id
        ]);

        $this->assertEquals($user->toArray(), $meetup->creator->toArray());
    }

    public function test_a_meetup_can_has_many_tickets()
    {
        $meetup = Meetup::factory()->create();

        $tickets = [
            Ticket::factory()->make(),
            Ticket::factory()->make(),
            Ticket::factory()->make(),
        ];

        $meetup->tickets()->saveMany($tickets);

        $this->assertCount(3, $meetup->tickets);
        
        $this->assertEquals($tickets[0]->fresh()->load('meetup')->toArray(), $meetup->fresh()->load('tickets.meetup')->tickets->first()->toArray());
    }

    public function test_a_meetup_can_has_many_customer_through_tickets()
    {
        $meetup = Meetup::factory()->create();

        $customers = Customer::factory()->count(3)->create();

        $tickets = [
            Ticket::factory()->make(['customer_id' => $customers[0]]),
            Ticket::factory()->make(['customer_id' => $customers[1]]),
            Ticket::factory()->make(['customer_id' => $customers[2]]),
        ];

        $meetup->tickets()->saveMany($tickets);

        $this->assertCount(3, $meetup->tickets);

        $this->assertCount(3, $meetup->customers->toArray());   
    }

    public function test_meetups_availability_can_be_counted()
    {
        $meetup = Meetup::factory()->create([
            'quantity' => 4,
            'sold' => 2
        ]);

        $this->assertEquals(2, $meetup->availability);
    }

}
