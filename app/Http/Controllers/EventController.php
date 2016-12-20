<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Event;
use App\Place;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = Event::all();
        return response()->json($eventos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return response()->json(['_token'=>csrf_token()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $facebook_event_id = $request->get('facebook_event_id');
        $event = Event::where('facebook_event_id', '=', $facebook_event_id)->first();
        if (!(is_null($event))) {
            return response()->json(['message'=>'tudo ok', 'data'=>$event]);
        }
        
        $place_id = $request->get('facebook_place_id');
        $place = Place::where('facebook_place_id', '=', $place_id)->first();
        if (is_null($place)){
            $place = $request->only('facebook_place_id', 'place_name','city', 'country',
                                    'latitude','longitude','state','street','zip');
            $place['name'] = $place['place_name'];
            unset($place['place_name']);
            $place = Place::create($place);
        }

        $event = $request->only('facebook_event_id', 'name', 'picture_url', 'description',
                                'start_time', 'end_time');
        $event['place_id'] = $place->id;
        $event = Event::create($event);
        return response()->json(['message'=>'tudo ok', 'data'=>$event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
