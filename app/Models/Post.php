<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;

use Auth;
use App\Models\SocialUser;
use App\Models\PostImage;
use App\Models\PostVideo;
use App\Models\SocialPost;
use DB;


use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    private $like_count = null;
    private $comment_count = null;

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function images(){
        return $this->hasMany('App\Models\PostImage', 'post_id', 'id');
    }
    public function videos(){
        return $this->hasMany('App\Models\PostVideo', 'post_id', 'id');
    }
    public function attachments(){
        return $this->hasMany('App\Models\PostAttachment', 'post_id', 'id');
    }

    public function socialPost(){
        return $this->hasOne('App\Models\SocialPost','post_id','id','name');
    }
    
    public function links(){
        return $this->hasMany('App\Models\PostLink', 'post_id', 'id');
    }
    public function sharedObject(){
        return $this->hasOne('App\Models\PostShare', 'post_id', 'id', 'shared_post_id');
    }

    public function pingedObject(){
        return $this->hasOne('App\Models\PingMe');
    }
    
    public function comments(){
        return $this->hasMany('App\Models\PostComment', 'post_id', 'id');
    }

    public function getThreadedComments()
    {
        return $this->comments()->with('user')->latest()->get()->threaded();
    }

    public function likes(){
        return $this->hasMany('App\Models\PostLike', 'post_id', 'id');
    }

    public function nextPost($sameUser = false){
        $obj = Post::oldest();
        $obj->where('has_image',$this->has_image);
        $obj->where('has_video',$this->has_video);
        $obj->where('has_attachment',$this->has_attachment);
        $obj->where('has_link',$this->has_link);
        $obj->where('id','>',$this->id);

        if($sameUser)
        $obj->where('user_id',$this->user_id);

        $post = $obj->pluck('id')->first();
        return $post;
    }

    public function prevPost($sameUser = false){
        $obj = Post::latest();
        $obj->where('has_image',$this->has_image);
        $obj->where('has_video',$this->has_video);
        $obj->where('has_attachment',$this->has_attachment);
        $obj->where('has_link',$this->has_link);
        $obj->where('id','<',$this->id);

        if($sameUser)
        $obj->where('user_id',$this->user_id);

        $post = $obj->pluck('id')->first();
        return $post;
    }

    public function nextPostImage($post){
        $user = Post::find($post)->user_id;
        $id = Post::orderBy('id','DESC')->where('id','<',$post)->where('user_id',$user)->where('has_image',1)->first()->id;
        return $id;
    }

    public function prevPostImage($post){
        $user = Post::find($post)->user_id;
        $id = Post::orderBy('created_at')->where('id','>',$post)->where('user_id',$user)->where('has_image',1)->first()->id;
        return $id;
    }
    
    public function getLikeCount(){
        if ($this->like_count == null){
            $this->like_count = $this->likes()->count();
        }
        return $this->like_count;
    }

    public function getCommentCount(){
        if ($this->comment_count == null){
            $this->comment_count = $this->comments()->count();
        }
        return $this->comment_count;
    }
    public function getThreadedCommentCount(){
        if ($this->comment_count == null){
            $this->comment_count = $this->comments()->whereNull('parent_id')->count();
        }
        return $this->comment_count;
    }

    public function checkOwner($user_id){
        if ($this->user_id == $user_id)return true;
        return false;
    }

    public function hasImage(){
        return $this->has_image;
    }

    public function hasShared(){
        return $this->has_shared;
    }

    public function hasPinged(){
        return $this->ping_post;
    }
    
    public function hasVideo(){
        return $this->has_video;
    }
    public function hasAttachment(){
        return $this->has_attachment;
    }
    public function hasLink(){
        return $this->has_link;
    }

    public function checkLike($user_id){
        if ($this->likes()->where('like_user_id', $user_id)->get()->first()){
            return true;
        }else{
            return false;
        }
    }

    public function checkInstagram($id){
        $posts = SocialPost::join('posts','posts.id','social_media.post_id')
        ->where('posts.user_id',$id)
        ->where('social_media.name','instagram')
        ->where('social_media.is_old',0)
        ->select('social_media.id as s_id','social_media.post_id as p_id')
        ->get();

        return $this->deletePrePost($posts);
    }

    private function deletePrePost($posts){

        foreach($posts as $post){
            $socialPost = $post->s_id;
            $postId = $post->p_id;

            PostComment::where('post_id',$postId)->delete();
            PostLike::where('post_id',$postId)->delete();
            PostImage::where('post_id',$postId)->delete();
            PingMe::where('post_id',$postId)->delete();
            SocialPost::where('post_id',$postId)->delete();
            Post::find($postId)->delete();
        }

        return true;
    }

    // create instagram posts
    public function createInstagramPost($posts,$accessToken,$userId){
        $datas = $posts;
        $user = Auth::user()->id;
        $media = 'instagram';
        $ids = $this->createIdArray($media,$datas);
        

        foreach($posts as $post){
            $id = $post['id'];
            $username = $post['u_name'];
            $caption = $post['caption'];
            $type = $post['type'];
            $url = $post['url'];
            
            $check = $this->checkSocialUser($media,$user,$accessToken,$username);
            if(!$check){
                // create a new instagram user..
                $create = $this->createSocialUser($user,$media,$username,$accessToken,$userId);
                if($create){
                    // create instagram post..
                    $this->createSocielPost($user,$caption,$type,$url,$media,$id);
                }
            }else{
                // create instagram posts..
                $checkSocial = $this->checkSocialPost($id);
                if(!$checkSocial){
                    $this->createSocielPost($user,$caption,$type,$url,$media,$id);
                }
            }
        }

        // $delete = $this->deleteSocialPost($user,$media,$ids);

        return true;
    }

    // create twitter posts
    public function createTwitter($tweets){

        $user = Auth::user()->id;
        $media = 'twitter';
        $datas = $tweets;
        $ids = $this->createIdArray($media,$datas);
        
        foreach($tweets as $tweet){
            // caption of the post
            $content =  $tweet->text;
            // check the post is exists or not..
            $id = $tweet->id;
            $socialPost = $this->checkSocialPost($id);

            if(!$socialPost){
                if($tweet->entities->media == 0){
                    // content posts
                    if(starts_with($content,'@')){
                           
                    }else{
                        /**
                         * Content post
                         * create create SocielPost
                         * parameters : user_id, caption, type, url, media(socialmedia, id(social post id))
                         * return true if added to  the db(social_media)
                        */
                        $caption = $content;
                        $type = 'content';
                        $url = '';
                        $id = $tweet->id;
                        $create = $this->createSocielPost($user,$caption,$type,$url,$media,$id);
                    }
                }else{
                    // media posts
                    $content =  $tweet->text;
                    foreach($tweet->entities->media as $tweetPost){
                        if($tweetPost->type == 'photo'){

                            /**
                             * Image post
                             * create create SocielPost
                             * parameters : user_id, caption, type, url, media(socialmedia, id(social post id))
                             * return true if added to  the db(social_media)
                                 */
                            $caption = starts_with($content,'https') ? '' : substr($content,0, strpos($content,"htt")) ; 
                            $type = 'image';
                            $url = $tweetPost->media_url_https;

                            $id = $tweet->id;
                            $create = $this->createSocielPost($user,$caption,$type,$url,$media,$id);
                        }else{
                            // video
                        }
                    }
                }
            }
        }

        // delete posts already deleted from social media
        $delete = $this->deleteSocialPost($user,$media,$ids);

        return true;
    }

    /**
     * check socialpost is available or not
     * if available returns true
     * else returns false
     */
    private function checkSocialPost($id){
        // check availablity
        $check = SocialPost::where('social_post_id',$id)->first();
        
        if($check){
            return true;
        }else{
            return false;
        }
    }

    /**
     * make id array
     * parameter : media(social media), data array
     * returns id in an array
     */

    private function createIdArray($media,$datas){

        $id = array();
        if($media == 'twitter'){
            foreach($datas as $data){
                array_push($id,$data->id);
            }
        }else if($media == 'instagram'){
            foreach($datas as $data){
                array_push($id,$data['id']);
            }
        }
        return $id;
    }
    
    /**
     * Delete post which are already deleted from social medias
     * parameter : social media posts (array)
     * rerturn true when the work done
     */
    public function deleteSocialPost($user,$media,$ids){
        
        $id = implode($ids,",");
        $sql = "SELECT sm.post_id 
        FROM posts p 
        join social_media sm ON p.id = sm.post_id 
        WHERE sm.social_post_id NOT IN (".$id.") 
        AND p.user_id = ".$user."
        AND sm.name = '".$media."'";
        
        $datas = DB::select($sql);

        foreach($datas as $data){
            $id = $data->post_id;
            $type = $this->checkPostType($id);
            // delete from social media
            SocialPost::where('post_id',$id)->delete();
            if($type == 'image'){
                PostImage::where('post_id',$id)->delete();
            }else if($type == 'video'){
                PostVideo::where('post_id',$id)->delete();
            }

            Post::find($id)->delete();
        }
    }

    private function checkPostType($id){
        $post = Post::find($id);
        if($post->has_image == 1){
            return 'image';
        }else if($post->has_video == 1){
            return 'video';
        }else{
            return 'content';
        }
    }
    
    /**
     * check social user whether he/she is new or aleready has an account
     * update profile, username, userid, accesstoken
     * rerturns true 
     */
    public function checkSocialUser($media,$user,$accessToken,$username){
        $socialUser = SocialUser::where('user_id',$user)->where('name',$media)->first();
        if($socialUser){
            // check access token
            $checkToken = $this->checkToken($media,$user,$accessToken);
            $checkName = $this->checkName($media,$user,$username);
            $socialUser = SocialUser::where('user_id',$user)->where('name',$media)->first();

            if(!$checkToken){
                // update token
                $socialUser->access_token = $accessToken;
                $socialUser->save();
            }else if(!$checkName){
                // update username
                $socialUser->username = $username;
                $socialUser->save();
            }
            return true;
        }
    }
    
    // check socialmedia user access token
    public function checkToken($media,$user,$accessToken){
        $check = SocialUser::where('name',$media)->where('user_id',$user)->where('access_token',$accessToken)->first();
        if($check){
            return true;
        }
    }

    // check socialmedia user name
    public function checkName($media,$user,$username){
        $check = SocialUser::where('name',$media)->where('user_id',$user)->where('username',$username)->first();
        if($check){
            return true;
        }
    }

    // create socialuser
    private function createSocialUser($user,$media,$username,$accessToken,$userId){
        // create social user
        $create = new SocialUser;
        $create->name = $media; // name
        $create->user_id = $user; // user_id
        $create->username = $username;
        if($media == 'instagram'){
            $create->social_no = 1; 
        }else if($media == 'twitter'){
            $create->social_no = 3;
        }else if($media == 'facebook'){
            $create->social_no = 2;
        }
        $create->social_user_id = $userId; // social user id
        $create->access_token = $accessToken; 
        if($create->save()){
            return true;
        }
    }

    // create a social post
    private function createSocielPost($user,$caption,$type,$url,$media,$id){
        if($media == 'instagram'){
            if($type == 'IMAGE'){
               return $this->createImagePost($user,$caption,$type,$url,$media,$id);
            }else if($type == 'VIDEO'){
                return $this->createVideoPost($user,$caption,$type,$url,$media,$id);
            }else{
                // return true;
                // carousal album
            }
        }else if($media == 'twitter'){
            if($type == 'image'){
                return $this->createImagePost($user,$caption,$type,$url,$media,$id);
            }else if($type == 'content'){
                return $this->createContentPost($user,$caption,$media,$id);
            }
        }
    }

    /**
     * create social contetnt post
     * parameters : user_id,content,media(name of socialmedia),social_post_id
     * return true if added to db(post,social_media)
     */
    private function createContentPost($user,$caption,$media,$id){
        $addPost = new Post;
        $addPost->user_id = $user;
        $addPost->group_id = 0;
        $addPost->content = $caption;
        if($addPost->save()){
            // add to social media table
            $addSocial = new SocialPost;
            $addSocial->post_id = $addPost->id;
            $addSocial->social_post_id = $id;
            $addSocial->name = $media;
            if($addSocial->save()){
                return true;
            }
        }
    }

    /**
     * create social image post
     * parameters : user_id, caption, type, url, media(socialmedia, id(social post id))
     * return true after added to  the DB
     */
    private function createImagePost($user,$caption,$type,$url,$media,$id){
        // create post
        $post = new Post;
        $post->user_id = $user;
        $post->group_id = 0;
        $post->has_image = 1;
        $post->has_video = 0;
        $post->has_attachment = 0;
        $post->has_link = 0;
        $post->has_shared = 0;
        $post->content = $caption;
        $post->has_link = 0;
        if($post->save()){
            // create post image
            $image = new PostImage;
            $image->post_id = $post->id;
            $image->image_path = $url;
            if($image->save()){
                // create social post
                $social = new SocialPost;
                $social->post_id = $post->id;
                $social->social_post_id = $id;
                $social->name = $media;
                $social->is_old = 1;
                if($social->save()){
                    return true;
                }
            }
        }
    }

    private function createVideoPost($user,$caption,$type,$url,$media,$id){
        // create post
        $post = new Post;
        $post->user_id = $user;
        $post->group_id = 0;
        $post->has_image = 0;
        $post->has_video = 1;
        $post->has_attachment = 0;
        $post->has_link = 0;
        $post->has_shared = 0;
        $post->content = $caption;
        $post->has_link = 0;
        if($post->save()){
            // create post image
            $image = new PostVideo;
            $image->post_id = $post->id;
            $image->video_path = $url;
            if($image->save()){
                // create social post
                $social = new SocialPost;
                $social->post_id = $post->id;
                $social->social_post_id = $id;
                $social->name = $media;
                $social->is_old = 1;
                if($social->save()){
                    return true;
                }
            }
        }
    }
}