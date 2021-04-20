<?php
namespace App\Library;


use App\Models\City;
use App\Models\Country;
use App\Models\PostComment;
use App\Models\Post;
use App\Models\CommentLike;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserFollowing;
use App\Models\UserLocation;
use App\Models\PingMe;
use App\Models\SocialPost;
use App\Models\MediaMessage;
use App\Models\FollowAccept;
use Auth;

class sHelper
{

    static $notifications = null;



    public static function followButton($following, $follower, $element, $size = ''){

        if ($following  == $follower) return "This is me";

        $relation = UserFollowing::where('following_user_id', $following)->where('follower_user_id', $follower)->get()->first();

        if ($relation){
            if ($relation->allow == 0) {
                return '<a href="javascript:;" class="btn btn-xs request-button '.$size.'" onclick="follow(' . $following . ', ' . $follower . ', \''.$element.'\', \''.$size.'\')"></a>';
            }elseif ($relation->allow == 1){
                return '<a href="javascript:;" class="btn btn-xs following-button '.$size.'" onclick="follow('.$following.', '.$follower.', \''.$element.'\', \''.$size.'\')"></a>';
            }
        }

        return '<a href="javascript:;" class="btn btn-default follow-button '.$size.'" onclick="follow('.$following.', '.$follower.', \''.$element.'\', \''.$size.'\')"><i class="fa fa-plus-circle"></i> Follow</a>';

    }

    // public function PingMe()

    public static function deniedButton($me, $follower, $element, $size = ''){
        if ($me  == $follower) return "";

        $relation = UserFollowing::where('following_user_id', $me)->where('follower_user_id', $follower)->get()->first();

        if ($relation){
            if ($relation->allow == 1) {
                return '<a href="javascript:;" class="btn btn-xs btn-danger '.$size.'" onclick="deniedFollow('.$me.', '.$follower.', \''.$element.'\', \''.$size.'\')" title="Block">
                <i class="fa fa-times"></i>
                </a>';
            }
        }
    }

    public static function isPinged($id){
        $check = PingMe::where('pingedby_id',Auth::user()->id)->where('post_id',$id)->where('public_post',1)->first();
        if($check){
            return 'pinged';
        }else{
            return 'not pinged';
        }
    }

    public static function isAvailablePost($id){
        $post = Post::find($id);
        if($post){
            return true;
        }
    }

    public static function getPostCount($id){
        $userId = Post::find($id)->user_id;
        $count = Post::where('user_id',$userId)->count();

        return $count;
    }

    public static function getFollowingCount($id){
        $userId = Post::find($id)->user_id;
        $following = UserFollowing::where('follower_user_id',$userId)->where('allow',1)->count();

        return $following;
    }
    
    public static function isPingedPublicly($id){
        $check = PingMe::where('post_id',$id)->where('public_post',1)->first();
        if($check){
            return true;
        }
    }
    
    public static function socialPostId($id){
        $post = SocialPost::where('social_post_id',$id)->first();
        return $post->post_id;
    }

    public static function pingedByName($id){
        $ping = PingMe::where('post_id',$id)->where('public_post',1)->first();
        $user_id = $ping->pingedby_id;
        $myId = Auth::user()->id;
        $follower = UserFollowing::where('following_user_id',$myId)->where('follower_user_id',$user_id)->first();
        $following = UserFollowing::where('following_user_id',$user_id)->where('follower_user_id',$myId)->first();
        if($following || $follower){
            $user = User::find($user_id);
            return $user->name;
        }
    }
    
    public static function pingedByMe($id){
        $me = Auth::user()->id;
        $ping = PingMe::where('pingedby_id',$me)->where('post_id',$id)->where('public_post',1)->first();
        if($ping){
            return true;
        }
    }
    
    public static function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad(
            $lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $km = $miles * 1.609344;

        if ($km < 1){
            return round($miles * 1609.344).' Meter';
        }

        return round($km, 2).' Km';

    }

    public static function notifications(){
        if (self::$notifications == null){
            $notifications = [];

            $user = Auth::user();

            $followers = $user->follower()->where('allow', 0)->count();
            if ($followers > 0){
                $notifications[] = [
                    'url' => url('/followers/pending'),
                    'icon' => 'fa-user-plus',
                    'time' => '',
                    'text' => $followers.' follower requests'
                ];
            }

            $relatives = $user->relatives()->where('allow', 0)->count();
            if ($relatives > 0){
                $notifications[] = [
                    'url' => url('/relatives/pending'),
                    'icon' => 'fa-user-circle-o',
                    'time' => '',
                    'text' => $relatives.' relatives requests'
                ];
            }

            $pingedDatas = PingMe::join('users','users.id','ping_me.pingedby_id')
            ->join('posts','posts.id','ping_me.post_id')
            ->select('users.name','users.profile_path','ping_me.post_id','ping_me.pingedby_id','ping_me.created_at')
            ->where('ping_me.pinged_id',$user->id)
            ->where('posts.ping_post',1)
            ->where('posts.pvt_ping',0)
            ->where('posts.post_seen',0)
            ->orderBy('ping_me.id','DESC')
            ->get();

            if(count($pingedDatas) > 0){
                foreach($pingedDatas as $pingedBy){
                    $notifications[] = [
                        'url' => '/post/'.$pingedBy->post_id,
                        'icon' => $pingedBy->user->getPhoto(30,30),
                        'time' => $pingedBy->created_at,
                        'text' => $pingedBy->name.' pinged you'
                    ];
                }
            }

            $publicPingPosts = PingMe::join('users','users.id','ping_me.pingedby_id')
            ->join('posts','posts.id','ping_me.post_id')
            ->select('users.name','users.profile_path','ping_me.post_id','ping_me.pingedby_id','ping_me.created_at')
            ->where('ping_me.pinged_id',$user->id)
            ->where('posts.pvt_ping',1)
            ->where('ping_me.ping_seen',1)
            ->orderBy('ping_me.id','DESC')
            ->get();
            if(count($publicPingPosts) > 0){
                foreach($publicPingPosts as $publicPing){
                    $notifications[] = [
                        'url' => '/post/'.$publicPing->post_id,
                        'icon' => $publicPing->user->getPhoto(30,30),
                        'time' => $publicPing->created_at,
                        'text' => $publicPing->name.' pinged a post with you as private'
                    ];
                }
            }
            
            $comments = PostComment::where('seen', 0)->with('user')->join('posts', 'posts.id', '=', 'post_comments.post_id')
                ->where('posts.user_id', $user->id)->where('comment_user_id', '!=', $user->id)->select('post_comments.*')->orderBy('id', 'DESC');
            if ($comments->count() > 0){
                foreach ($comments->get() as $comment){
                    $notifications[] = [
                        'url' => url('/post/'.$comment->post_id),
                        'icon' => $comment->user->getPhoto(30,30),
                        'time' => $comment->created_at,
                        'text' => $comment->user->name.' left a comment on your post.'
                    ];
                }

            }
            $Clikes = CommentLike::with('user')->join('post_comments', 'post_comments.id', '=', 'comment_likes.comment_id')
                    ->join('users', 'users.id', '=', 'comment_likes.like_user_id')
                    ->where('post_comments.comment_user_id', $user->id)
                    ->where('comment_likes.like_user_id', '!=', $user->id)
                    ->where('comment_likes.seen', 0)
                    ->orderBy('post_comments.id', 'DESC');

            
            if ($Clikes->count() > 0){
                foreach ($Clikes->get() as $liken){
                    
                    
                    
                    $notifications[] = [
                        'url' => url('/post/'.$liken->post_id),
                        'icon' => $liken->user->getPhoto(30,30),
                        'time' => $liken->created_at,
                        'text' => $liken->user->name.' liked your post.'
                    ];
                }

            }
           
            
            $likes = PostLike::where('seen', 0)->with('user')->join('posts', 'posts.id', '=', 'post_likes.post_id')
                ->where('posts.user_id', $user->id)->where('like_user_id', '!=', $user->id)->select('post_likes.*')->orderBy('id', 'DESC');
            if ($likes->count() > 0){
                foreach ($likes->get() as $liken){
                    $notifications[] = [
                        'url' => url('/post/'.$liken->post_id),
                        'icon' => $liken->user->getPhoto(30,30),
                        'time' => $liken->created_at,
                        'text' => $liken->user->name.' liked your post.'
                    ];
                }

            }
            usort($notifications, function ($a, $b) {
                    return $b['time'] = $a['time'];
                });
            self::$notifications = $notifications;
            
        }

        return self::$notifications;
    }

    public static function ip($request){
        $ip = $request->headers->get('CF_CONNECTING_IP');
        if (empty($ip))$ip = $request->ip();
        return $ip;
    }

    public static function alternativeAddress($ip, $id){
        $query = IPAPI::query($ip);

        if ($query->status == "success") {



            $country_name = $query->country;
            $lat = $query->lat;
            $lon = $query->lon;
            $city = $query->city;
            $country_code = $query->countryCode;

            $find_country = Country::where('shortname', $country_code)->first();
            $country_id = 0;
            if ($find_country) {
                $country_id = $find_country->id;
            } else {
                $country = new Country();
                $country->name = $country_name;
                $country->shortname = $country_code;
                if ($country->save()) {
                    $country_id = $country->id;
                }
            }

            $city_id = 0;
            if ($country_id > 0) {
                $find_city = City::where('name', $city)->where('country_id', $country_id)->first();
                if ($find_city) {
                    $city_id = $find_city->id;
                } else {
                    $city = new City();
                    $city->name = $city;
                    $city->zip = "1";
                    $city->country_id = $country_id;
                    if ($city->save()) {
                        $city_id = $city->id;
                    }
                }
            }


            if (!empty($lat) && !empty($lon) && !empty($city) && !empty($country_code) && !empty($city_id) && !empty($country_id)) {

                self::updateLocation($id, $city_id, $lat, $lon, $city);
            }
        }

    }

    public static function updateLocation($id, $city_id, $lat, $long, $address){
        $find_location = UserLocation::where('user_id', $id)->first();


        if (!$find_location) {

            $find_location = new UserLocation();
            $find_location->user_id = $id;

        }


        $find_location->city_id = $city_id;
        $find_location->latitud = $lat;
        $find_location->longitud = $long;
        $find_location->address = $address;

        $find_location->save();
    }

    // get profile image
    public static function userProfileImg($id){
        $user = User::find($id);
        return $user->profile_path;
    }

    public static function mediaMessage($id){
        $media = MediaMessage::find($id);
        return $media;
    }

    public static function showMessageNotification($id){
        $user = FollowAccept::where('user_two',$id)->where('allow',1)->get();

        return $user;
    }

    public static function userDetails($id){
        $user = User::find($id);

        return $user;
    }
}