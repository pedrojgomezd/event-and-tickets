<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;

class TicketsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Requests\StoreTicketRequest
     */
    public function store(StoreTicketRequest $request)
    {
        $data = $request->all();

        Ticket::create([
            'sold_by' => $request->user()->id,
            'customer_id' => $data['customer_id'],
            'meetup_id' => $data['meetup_id'],
        ]);
        
        return response()->json(['data' => 'success'], 201);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function confirm(Ticket $ticket)
    {
        $data = [
            'message' => $ticket->switchUsed() ? 'success' : 'used'
        ];

        return response()->json(['data' => $data]);
    }
}
