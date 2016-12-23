<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['facebook_event_id', 'name', 'picture_url', 'description',
    						'start_time', 'end_time', 'place_id'];

    public function checkins(){
    	return $this->hasMany('App\Checkin');;
    }
}
