<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

}

