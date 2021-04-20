<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

use DB;
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{

    protected $table = 'post_comments';

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    private $like_count = null;
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'comment_user_id');
    }

    public function socialUser($id, $social){
        if($social == 1){
            // instagram
            $user = PostComment::find($id);

            $userData = SocialUser::where('user_id',$user->comment_user_id)
            ->where('social_no',1)->first();
            return $userData;            
        }else if($social == 2){
            // facebook
            $user = PostComment::find($id);

            $userData = SocialUser::where('user_id',$user->comment_user_id)
            ->where('social_no',2)->first();
            return $userData;            
        }else if($social == 3){
            // twitter
            $user = PostComment::find($id);

            $userData = SocialUser::where('user_id',$user->comment_user_id)
            ->where('social_no',3)->first();
            return $userData;            
        }else{
            // 
        }
    }
    
    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    public function commentUser($id){
        $data = PostComment::join('users','users.id','post_comments.comment_user_id')
        ->select('post_comments.id as commentId','post_comments.comment','users.id as userId','users.name as username','users.profile_path as profile')
        ->where('post_comments.post_id',$id)->get();

        return $data;
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