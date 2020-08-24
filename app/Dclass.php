<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dclass extends Model
{
    protected $table = 'classes';


    public function lectures(){
        return $this->hasMany('App\Lecture','class_id');

    }


    public function questions(){
        return $this->hasMany('App\Question','class_id');

    }



}
