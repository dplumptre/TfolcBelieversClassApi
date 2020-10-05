<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = [
        'id',
    ];


    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function classes(){
        return $this->belongsTo('App\Dclass','class_id');
    }

}
