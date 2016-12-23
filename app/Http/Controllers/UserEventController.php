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
    public function getUserEvents(Request $request)
    {
        $access_token = $request->get('access_token');
        $url = '/me/events?fields=id,name,description,start_time,end_time,place,cover';
        $fb = new \Facebook\Facebook(['app_id' => '1379982378719884',
		  'app_secret' => '6de34ab5bb6310b76e57cb18d677643b',
		  'default_graph_version' => 'v2.8',
		]);
		$response = $fb->get($url, $access_token);

		$arrayResult = $response->getDecodedBody();
		//$arrayResult = json_decode($response->getBody(), true);

		$i = 0;
		foreach ($arrayResult['data'] as $event) {
			$event_exists = Event::where('facebook_event_id', '=', $event['id'])->first();
			if (is_null($event_exists)) {
				$events[$i] = $event;
				$i++;
			}
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

    public function getUserFriendsCheckin(Request $request){
    	$access_token = $request->get('access_token');
    	$event_id = $request->get('event_id');

    	$fb = new \Facebook\Facebook([
		  'app_id' => '1379982378719884',
		  'app_secret' => '6de34ab5bb6310b76e57cb18d677643b',
		  'default_graph_version' => 'v2.8',
		  ]);

		// Since all the requests will be sent on behalf of the same user,
		// we'll set the default fallback access token here.
		$fb->setDefaultAccessToken($access_token);

		$event = Event::with('checkins')->findOrFail($event_id);

		$i = 0;
		$batch= array();
		foreach ($event->checkins as $checkin) {
			$url = '/me/friends/'.$checkin->facebook_user_id;
			$batch[$i] = $fb->request('GET', $url);
			$i++;
		}	
	    
		$responses = $fb->sendBatchRequest($batch);

		$i = 0;
		$friends = array();
		foreach ($responses as $key => $response) {
			$aux = $response->getDecodedBody();
			if (!(is_null($aux['data']))) {
				$friends[$i] = $aux['data'];
				$i++;					
			}
		}
		return response()->json(['data'=>$friends]);
    }
}
