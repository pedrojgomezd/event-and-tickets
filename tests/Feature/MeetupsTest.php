<?php

namespace Tests\Feature;

use App\Http\Resources\Meetups;
use App\Models\Meetup;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetupsTest extends TestCase
{
   use RefreshDatabase;

   public function test_guest_cant_see_list_meetups()
   {
       $this->getJson('api/meetups')->assertUnauthorized();
   }

   public function test_a_user_can_see_list_meetups()
   {
       $this->singInApi();

       $meetups = Meetup::factory()->count(10)->create();

       $meetupsResource = Meetups::collection($meetups->fresh())->response()->getData(true);

       $response = $this->getJson('api/meetups');

       $response->assertExactJson($meetupsResource);
   }

   public function test_a_user_can_see_details_meetup()
   {
       $this->singInApi();

       $meetup = Meetup::factory()->create();

       Ticket::factory()->count(3)->create([
           'meetup_id' => $meetup->id
       ]);

       $meetupResource = Meetups::make($meetup->fresh())
        ->response()
        ->getData(true);

       $response = $this->getJson("api/meetups/{$meetup->id}");

       $response->assertExactJson($meetupResource);
   }

   public function test_a_user_can_see_details_meetup_and_conatins_list_tickets()
   {
       $this->singInApi();

       $meetup = Meetup::factory()->create();

       Ticket::factory()->count(3)->create([
           'meetup_id' => $meetup->id
       ]);

       $meetupResource = Meetups::make($meetup->fresh()->load('tickets'))
        ->response()
        ->getData(true);

       $response = $this->getJson("api/meetups/{$meetup->id}?tickets=1");

       $response->assertExactJson($meetupResource);
   }
   
   public function test_a_user_can_see_details_meetup_and_conatins_list_tickets_with_customer()
   {
       $this->singInApi();

       $meetup = Meetup::factory()->create();

       Ticket::factory()->count(3)->create([
           'meetup_id' => $meetup->id
       ]);

       $meetupResource = Meetups::make($meetup->fresh()->load('tickets.customer'))
        ->response()
        ->getData(true);

       $response = $this->getJson("api/meetups/{$meetup->id}?tickets=1&customer=true");

       $response->assertExactJson($meetupResource);
   }

   public function test_a_user_can_validate_ticket_availability()
   {
       $this->singInApi();

       $meetup = Meetup::factory()->create([
           'quantity' => 1,
           'sold' => 0
       ]);
       
       $responseAvailable = $this->getJson("api/meetups/{$meetup->id}/availability");
       
       $responseAvailable->assertSuccessful();

       $responseAvailable->assertExactJson(['data' => [
        'availability' => 1,
        'message' => 'There is availability'
       ]]);

       Ticket::factory()->create([
           'meetup_id' => $meetup->id
       ]);
       
       $responseNoAvailable = $this->getJson("api/meetups/{$meetup->id}/availability");

       $responseNoAvailable->assertSuccessful();

       $responseNoAvailable->assertExactJson(['data' => [
        'availability' => 0,
        'message' => 'No availability'
       ]]);
   }
}
