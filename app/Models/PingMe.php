<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PingMe extends Model
{
    protected $table = 'ping_me';

    public function pinged_user(){
        return $this->belongsTo('App\Models\User', 'pinged_id');
    }

    public function pingedBy(){
        return $this->belongsTo('App\Models\User', 'pingedby_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'pingedby_id');
    }
}
