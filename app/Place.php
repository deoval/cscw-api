<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['facebook_place_id',
				            'name',
				            'city',
				            'country',
				            'latitude',
				            'longitude',
				            'state',
				            'street',
				            'zip'
				          ];
}
