<?php

namespace App\Http\Controllers;

use App\Http\Resources\Meetups;
use App\Models\Meetup;
use Illuminate\Http\Request;

class MeetupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function index(Meetup $meetup)
    {
        $resource = Meetups::collection($meetup->get());

        return response()->json(['data' => $resource]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $file = $request->file('cover');
        $coverPath = $file->storeAs('covers', $file->getClientOriginalName());
        
        $meetup = $request->user()
            ->meetups()
            ->create([
                'name' => $data['name'],
                'date' => $data['date'],
                'place' => $data['place'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'cover_path' => $coverPath
            ]);

        return response()->json($meetup, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function show(Meetup $meetup)
    {
        $resource = Meetups::make($meetup->load('tickets'));

        return response()->json(['data' => $resource]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function availability(Meetup $meetup)
    {
        $response = [
            'availability' => $meetup->availability,
            'message' => $meetup->availability ? 'There is availability' : 'No availability'
        ];

        return response()->json(['data' => $response]);
        
    }
}
