<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Resources\Customers;
use App\Http\Requests\CustomerRequest;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $resource = Customers::collection($customer->get());

        return response()->json(['data' => $resource]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();

        $customer = $request->user()
            ->customers()
            ->create($data);

        $resource = Customers::make($customer);
            
        return response()->json($resource, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $resource = Customers::make($customer->load('tickets'));

        return response()->json(['data' => $resource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->all();

        $customer->update($data);

        $resource = Customers::make($customer->fresh());

        return response()->json(['data' => $resource], 204);
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        response()->json(['data' => 'deleted']);
    }
}
