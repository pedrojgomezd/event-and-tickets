<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cant_register_customer()
    {
        $this->postJson('/api/customers')
            ->assertUnauthorized();
    }

    public function test_a_user_can_register_customer()
    {
        $this->singInApi();

        $data = [
            'name' => 'Allison Gomez', 
            'document' => '12990390', 
            'birth_day' => '1990-08-30', 
            'email' => 'allison@gmail.com', 
            'phone' => '57300909999', 
        ];

        $response = $this->postJson('api/customers', $data);

        $response->assertCreated();

        $response->assertJson($data);
    }

    public function test_name_and_email_are_required()
    {
        $this->singInApi();
        
        $respons = $this->postJson('api/customers');

        $respons->assertJsonValidationErrors(['email', 'name']);
    }
}
