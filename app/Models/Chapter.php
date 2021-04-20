<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $guarded = [];

    public function Book ()
    {
    	return $this->hasOne('App\Models\Book','id','book_id');
    }
}
