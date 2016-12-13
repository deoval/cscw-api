<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserEvents(Request $request)
    {
        //$user_id = $request->get('user_id');
        return response()->json(['req'=>$request]);
        $access_token = $request->get('access_token');
        //$url = '/' . $user_id . '/events';
        $url = '/me/events';
        dd($url);
        $fb = new \Facebook\Facebook(['app_id' => '1379982378719884',
		  'app_secret' => '6de34ab5bb6310b76e57cb18d677643b',
		  'default_graph_version' => 'v2.8',
		]);
		$response = $fb->get($url, $access_token);

		$arrayResult = json_decode($response->getBody(), true);
		
		return response()->json(['data'=>$arrayResult['data']]);		
    }
}
