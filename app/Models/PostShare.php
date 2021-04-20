<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostShare extends Model
{

    protected $table = 'post_shares';

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    public function shared_post(){
        return $this->belongsTo('App\Models\Post', 'shared_post_id');
    }

}