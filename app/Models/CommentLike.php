<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{

    protected $table = 'comment_likes';

    public $incrementing = false;

    protected $primaryKey = ['comment_id', 'like_user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function comment(){
        return $this->belongsTo('App\Models\PostComment', 'comment_id');
    }


    public function user(){
        return $this->belongsTo('App\Models\User', 'like_user_id');
    }

}