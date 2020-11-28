<?php

namespace Tests\Unit;

use App\Models\Meetup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_user_can_has_many_meetups()
    {
        $user = User::factory()->create();

        $meetups = [
            Meetup::factory()->make(),
            Meetup::factory()->make(),
            Meetup::factory()->make(),
        ];

        $user->meetups()->saveMany($meetups);

        $this->assertInstanceOf(Meetup::class, $user->meetups->first());

        $this->assertCount(3, $user->meetups);
    }
}
