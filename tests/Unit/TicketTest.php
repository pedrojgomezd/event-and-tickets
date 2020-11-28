<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Meetup;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('tickets', [
                'id', 'customer_id', 'meetup_id', 'code', 'is_used', 'sold_by'
            ]), 
        1);
    }

    public function test_a_tickect_can_has_a_meetups_assign()
    {
        $meetup = Meetup::factory()->create();

        $ticket = Ticket::factory()->create([
            'meetup_id' => $meetup->id
        ]);

        $this->assertEquals($meetup->toArray(), $ticket->meetup->toArray());
    }

    public function test_a_tickect_can_has_a_customer_assign()
    {
        $customer = Customer::factory()->create();

        $ticket = Ticket::factory()->create([
            'customer_id' => $customer->id
        ]);

        $this->assertEquals($customer->toArray(), $ticket->customer->toArray());
    }
    
    public function test_a_tickect_can_has_a_seller()
    {
        $seller = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'sold_by' => $seller->id
        ]);

        $this->assertEquals($seller->toArray(), $ticket->seller->toArray());
    }
}
