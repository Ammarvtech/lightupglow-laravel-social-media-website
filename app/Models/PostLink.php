<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostLink extends Model
{

    protected $table = 'post_links';

    public $timestamps = false;
    
    public function getURL(){
        return $this->link_url;
    }

    public function getCode(){
		return $this->link_code;
    }
    
    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}