<?php
/**
 * Created by aiyash ahmed/srilanka.
 * Date: 03/09/2020.
 */
namespace App\Library;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostVideo;
use Twitter;
use Auth;
use App\Models\SocialUser;
use App\Models\SocialPost;
use App\Models\User;

class TwitterClass
{
    /**
     * connect twitter
     * return true when it is saved on the db
     */
    public function connect($user){
        Auth::user()->twitter_uid = $user->id;
        Auth::user()->save();
        if(Auth::user()->save()){
            $accessToken = $user->token;
            $media = 'twitter';
            $username = $user->name;
            $userId = Auth::user()->id;
            $post = new Post;
            // check socialuser 
            $check = $post->checkSocialUser($media,$userId,$accessToken,$username);
            // $check = SocialUser::where('user_id',Auth::user()->id)->where('name','twitter')->first();
            
            //  get twitter user posts
            $twitter_user = SocialUser::where('user_id',Auth::user()->id)->where('social_no',3)->first();

            $tweets = Twitter::getUserTimeline([
                'user_id' => $twitter_user->social_user_id,
                'count'       => 20,
                'format'      => 'object'
            ]);
            
            // create posts
            $tweet = $post->createTwitter($tweets);
            if($tweet){
                return true;   
            }
        }


    }
}
?>