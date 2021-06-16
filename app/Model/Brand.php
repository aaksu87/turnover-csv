<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;

class Brand extends Model {

    protected $table = 'brands';

    public function turnovers()
    {
        return $this->hasMany('App\Model\Gmv');
    }

}