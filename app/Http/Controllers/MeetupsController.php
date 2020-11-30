<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetupRequest;
use App\Http\Resources\Meetups;
use App\Models\Meetup;
use App\QueryFilters\MeetupFilters;
use Illuminate\Http\Request;

class MeetupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function index(MeetupFilters $filter)
    {
        $meetups = Meetup::filter($filter)->get();

        $resource = Meetups::collection($meetups);

        return response()->json($resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMeetupRequest $request)
    {
        $data = $request->all();
        
        $meetup = $request->user()
            ->meetups()
            ->create($data);

        $resource = Meetups::make($meetup);

        return response()->json($resource, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function show($id, MeetupFilters $filter)
    {
        $meetup = Meetup::filter($filter)
            ->whereId($id)
            ->first();

        $resource = Meetups::make($meetup);

        return response()->json($resource);
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
