<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SocialLike extends Model
{

    protected $table = 'social_likes';

    public $incrementing = false;

    protected $primaryKey = ['post_id', 'like_user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function user(){
        return $this->belongsTo('App\Models\User', 'like_user_id');
    }
}
