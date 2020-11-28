<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_validate_a_ticket_if_it_was_used_and_change_status()
    {
        $this->singInApi();

        $ticket = Ticket::factory()->create([
            'is_used' => false
        ]);

        $response = $this->postJson("api/tickets/{$ticket->id}/confirm");
        
        $response->assertSuccessful();
        
        $response->assertExactJson([
            'data' => [
                'message' => 'success'
            ]
        ]);

        $response = $this->postJson("api/tickets/{$ticket->id}/confirm");

        $response->assertSuccessful();
        
        $response->assertExactJson([
            'data' => [
                'message' => 'used'
            ]
        ]);
    }
}
