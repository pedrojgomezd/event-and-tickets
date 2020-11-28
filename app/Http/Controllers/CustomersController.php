<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customers;
use App\Models\Customer;
use App\Models\Meetup;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $customers = Customers::collection($customer->get());

        return response()->json(['data' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'string',
            'document' => 'string|max:20',
            'birth_day' => 'nullable|date'
        ]);

        $customer = $request->user()
            ->customers()
            ->create($data);

        $resourceCustomer = Customers::make($customer);
            
        return response()->json($resourceCustomer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $resourceCustomer = Customers::make($customer->load('tickets'));

        return response()->json(['data' => $resourceCustomer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'string',
            'document' => 'string|max:20',
            'birth_day' => 'nullable|date'
        ]);

        $customer->update($data);

        $resourceCustomer = Customers::make($customer->fresh());

        return response()->json(['data' => $resourceCustomer], 204);
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        response()->json(['data' => 'deleted']);
    }
}
