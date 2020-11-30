<?php

namespace Tests\Feature;

use App\Http\Resources\Customers;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerUpdateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_guest_cant_update_customer()
    {
        $this->putJson('api/customers/1')
            ->assertUnauthorized();
    }

    public function test_a_user_can_update_customer()
    {
        $this->singInApi();

        $customer = Customer::factory()->create();

        $data = [
            'name' => 'Glexis A Gomez',
            'email' => 'glexis@gmail.com'
        ];

        $response = $this->putJson("api/customers/{$customer->id}", $data);
        
        $resourceCustomer = Customers::make($customer->fresh())->response()->getData(true);

        $response->assertStatus(204);

        $this->assertDatabaseHas('customers', $data);
    }

    public function test_name_and_email_are_required_for_update()
    {
        $this->singInApi();

        $customer = Customer::factory()->create();

        $this->putJson("api/customers/{$customer->id}")
            ->assertJsonValidationErrors(['name', 'email']);
    }
}
