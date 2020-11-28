<?php

namespace Tests\Feature;

use App\Http\Resources\Customers;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomersTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cant_see_list_customers()
    {
        $this->getJson('api/customers')->assertUnauthorized();
    }

    public function test_a_user_can_see_list_customers()
    {
        $user = $this->singInApi();

        $customers = Customer::factory()->count(10)->create();

        $resourceCustomer = Customers::collection($customers)->response()->getData(true);

        $response = $this->getJson('/api/customers');

        $response->assertSuccessful();

        $response->assertExactJson($resourceCustomer);
    }

    public function test_guest_cant_see_details_customers_by_id()
    {
        $this->getJson('api/customers/1')
            ->assertUnauthorized();
    }

    public function test_a_user_can_see_details_customers_by_id()
    {
        $this->singInApi();

        $customer = Customer::factory()->create();

        Ticket::factory()->count(3)->create([
            'customer_id' => $customer->id
        ]);

        $customer->load('tickets');

        $resourceCustomer = Customers::make($customer)->response()->getData(true);

        $response = $this->getJson("api/customers/{$customer->id}");

        $response->assertSuccessful();

        $response->assertExactJson($resourceCustomer);        
    }
}
