<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = ['facebook_user_id', 'facebook_event_id', 'event_id'];
}
