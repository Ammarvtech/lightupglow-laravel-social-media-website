<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SocialComment extends Model
{

    protected $table = 'social_comments';

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    private $like_count = null;
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'comment_user_id');
    }

    public function post() {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    public function newCollection(array $models = [])
    {
        return new CommentCollection($models);
    }

    public function likes(){
        return $this->hasMany('App\Models\CommentLike', 'comment_id', 'id');
    }
    public function getLikeCount(){
        if ($this->like_count == null){
            $this->like_count = $this->likes()->count();
        }
        return $this->like_count;
    }
    public function checkLike($user_id){
        if ($this->likes()->where('like_user_id', $user_id)->get()->first()){
            return true;
        }else{
            return false;
        }
    }
}