<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class Gmv extends Model {

    protected $table = 'gmv';

    public function brand()
    {
        return $this->belongsTo('App\Model\Brand');
    }

    public function getDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
}