<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Event;
use App\Place;
use App\Checkin;

class UserEventController extends Controller
{
    /**
     * Display a listing of user's events .
     *
     * @return \Illuminate\Http\Response
     */
    /*public function getUserEvents(Request $request)
    {
        //$user_id = $request->get('user_id');
        $access_token = $request->get('access_token');
        //return $access_token;
        //$url = '/' . $user_id . '/events';
        $url = '/me/events';
        //dd($url);
        $fb = new \Facebook\Facebook(['app_id' => '1379982378719884',
		  'app_secret' => '6de34ab5bb6310b76e57cb18d677643b',
		  'default_graph_version' => 'v2.8',
		]);
		$response = $fb->get($url, $access_token);

		$arrayResult = json_decode($response->getBody(), true);
		
		return response()->json(['data'=>$arrayResult['data']]);		
    }*/

    public function getUserEvents(Request $request)
    {
        //$access_token = $request->get('access_token');
        $access_token = 'EAATnFi962owBALwZChcQmJz2BX0X3FzebBi7YCaVELqtIjI7Dj4SCqTHGwvzxbPjuRN0XoaOfTbYkNnjpz9BJ2De2ViK52OheIUDNhfqEhkEFQXcdjudn2X3WIUhW0L5M8WGDrKxh6R8PGwoC6SErIllsfR3e6Q7ccT313wZDZD';
        $url = '/me/events';
        $fb = new \Facebook\Facebook(['app_id' => '1379982378719884',
		  'app_secret' => '6de34ab5bb6310b76e57cb18d677643b',
		  'default_graph_version' => 'v2.8',
		]);
		$response = $fb->get($url, $access_token);

		$arrayResult = json_decode($response->getBody(), true);

		$i = 0;
		foreach ($arrayResult['data'] as $event) {
			$event_exists = Event::where('facebook_event_id', '=', $event['id'])->first();
			if (is_null($event_exists)) {
				$events[$i] = $event;
			}
			$i++;
		}		
		return response()->json(['data'=>$events]);		
    }

    /**
     * Display a listing of user's events .
     *
     * @return \Illuminate\Http\Response
     */
    public function setUserEventCheckin(Request $request)
    {
		$facebook_event_id = $request->get('facebook_event_id');		
		$facebook_user_id = $request->get('facebook_user_id');
        $event = Event::where('facebook_event_id', '=', $facebook_event_id)->firstOrFail();
        
        $data = ['facebook_user_id' => $facebook_user_id,
        			'facebook_event_id' => $facebook_event_id,
        			'event_id' => $event->id];
        $checkin = Checkin::create($data);

        return response()->json(['data'=>$checkin]);
    }
}
