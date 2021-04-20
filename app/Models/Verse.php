<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Verse extends Model
{
	Protected $guarded = [];
	
	public function Book ()
    {
    	return $this->hasOne('App\Models\Book','id','book_id');
    }

    public function Chapter ()
    {
    	return $this->hasOne('App\Models\Chapter','id','chapter_id');
    }

    public function Language ()
    {
    	return $this->hasOne('App\Models\Language','id','language_id');
    }
  
}
