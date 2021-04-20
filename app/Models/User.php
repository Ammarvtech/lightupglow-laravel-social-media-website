<?php

namespace App\Models;

use App\Library\sHelper;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use App\Models\Post;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'username', 
        'password',
        'role',
        'sex',
        'first_name',
        'last_name',
        'birthday',
        'facebook_uid',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'birthday'
    ];

    public function location(){
        return $this->hasOne('App\Models\UserLocation', 'user_id', 'id');
    }

    public function followingUsers($id){
        $data = UserFollowing::join('users','users.id','user_following.follower_user_id')
        ->where('following_user_id',$id)
        ->select('users.*')
        ->get();
        return $data;
    }
    
    public function relatives(){
        return $this->hasMany('App\Models\UserRelationship', 'main_user_id', 'id');
    }

    public function relatives2(){
        return $this->hasMany('App\Models\UserRelationship', 'related_user_id', 'id');
    }

    public function follower(){
        return $this->hasMany('App\Models\UserFollowing', 'following_user_id', 'id');
    }

    public function following(){
        return $this->hasMany('App\Models\UserFollowing', 'follower_user_id', 'id');
    }

    public function pingedBy(){
        return $this->hasMany('App\Models\PingMe','pinged_id','id');        
    }
    
    public function hobbies(){
        return $this->hasMany('App\Models\UserHobby', 'user_id', 'id');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post', 'user_id', 'id')->latest();
    }

    public function socialUser(){
        return $this->belongsTo('App\Models\SocialUser','id','username');
    }

    // public function socialPosts($userid){
    //     $postid = Post::where('user_id',$user_id)->first();
    //     return $postid;
    // }
    
    public function has($Model){
        if (count($this->$Model) > 0) return true;
        return false;
    }

    public function getPhoto($w = null, $h = null){
        if (!empty($this->profile_path)){
            $path = 'storage/uploads/profile_photos/'.$this->profile_path;
        }else {
            $path = "images/profile-picture.png";
        }
        if ($w == null && $h == null){
            return url('/'.$path);
        }
        $image = '/resizer.php?';
        if ($w > -1) $image .= '&w='.$w;
        if ($h > -1) $image .= '&h='.$h;
        $image .= '&zc=1';
        $image .= '&src='.$path;
        return url($image);
    }

    public function getCover($w = null, $h = null){
        if (!empty($this->cover_path)){
            $path = 'storage/uploads/covers/'.$this->cover_path;
        }else {
            return "";
        }
        if ($w == null && $h == null){
            return url('/'.$path);
        }
        $image = '/resizer.php?';
        if ($w > -1) $image .= '&w='.$w;
        if ($h > -1) $image .= '&h='.$h;
        $image .= '&zc=1';
        $image .= '&src='.$path;
        return url($image);
    }

    public function getSex(){
        if ($this->sex == 0) return "Male";
        return "Female";
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getAge(){
        if ($this->birthday) return date('Y') - $this->birthday->format('Y');
    }

    public function getLocation(){
        return "";
    }

    public function getAddress(){
        $location = $this->location()->first();
        if ($location){
            return $location->address;
        }
    }

    public function getAssociatedPages(){
        if(strpos($this->email, '_fanpage')){
        $email = strstr($this->email, '_fanpage');
        $email = str_replace("_fanpage","",$email);
        }else{
            $email = $this->email;
        }
        $users = User::where('email', 'like', '%' . $email . '%')->get(['id', 'name', 'username']);
        return $users;
    }

    public function suggestedPeople($limit = 5, $city_id = null, $hobby_id = null, $all = null){
        $list = User::where('id', '!=', $this->id);

        if ($all == null) {
            $list = $list->whereNotIn('id', function ($q) {
                $q->select('following_user_id')->from('user_following')->where('follower_user_id', $this->id);
            });
        }

        if ($city_id != null && $hobby_id != null){
            $list = $list->whereExists(function ($query) use($city_id) {
                $query->select(DB::raw(1))
                    ->from('user_locations')
                    ->whereRaw('users.id = user_locations.user_id and user_locations.city_id = '.$city_id);
            })->whereExists(function ($query) use($hobby_id) {
                $query->select(DB::raw(1))
                    ->from('user_hobbies')
                    ->whereRaw('users.id = user_hobbies.user_id and user_hobbies.hobby_id = '.$hobby_id);
            });
        }

        $list = $list->limit($limit)->oldest()->get();
        return $list;
    }

    public function validateUsername($filter = "[^a-zA-Z0-9\-\_\.]"){
        return preg_match("~" . $filter . "~iU", $this->username) ? false : true;
    }

    public function isPrivate(){
        if ($this->private == 1) return true;
        return false;
    }

    public function canSeeProfile($user_id){
        if ($this->id == $user_id || !$this->isPrivate()) return true;
        $relation = $this->follower()->where('follower_user_id', $user_id)->where('allow', 1)->get()->first();
        if ($relation){
            return true;
        }
        return false;
    }

    public function distance($user){
        if ($this->id == $user->id) return "";
        if ($user){
            $user_location = $user->location()->get()->first();
            $my_location = $this->location()->get()->first();
            if ($user_location && $my_location){
                return sHelper::distance($my_location->latitud, $my_location->longitud, $user_location->latitud, $user_location->longitud);
            }
        }
        return "";
    }

    public function findNearby(){
        $location = $this->location()->get()->first();
        if (!$location) return false;
        $lat = $location->latitud;
        $long = $location->longitud;

        if (empty($lat) || empty($long)) return false;

        $raw = '111.045 * DEGREES(ACOS(COS(RADIANS('.$lat.')) * COS(RADIANS(latitud)) * COS(RADIANS(longitud) - RADIANS('.$long.')) + SIN(RADIANS('.$lat.')) * SIN(RADIANS(latitud))))';
        $users = UserLocation::select('user_id', 'latitud', 'longitud', 'address',
            DB::raw($raw.' AS distance'))->with('user')->where('user_id', '!=', $this->id)
            ->havingRaw('distance < 50')->orderBy('distance', 'ASC')->get();


        return $users;
    }

    public function messagePeopleList(){
        $list = $this->follower()->where('allow',1)->with('follower')->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('user_following as f')
                ->whereRaw('f.following_user_id = user_following.follower_user_id')
                ->whereRaw('f.follower_user_id = '.$this->id)
                ->whereRaw('f.allow = 1');
        });

        return $list;
    }

    public function hasHobby($hobby_id){
        $check = $this->hobbies()->where('hobby_id', $hobby_id)->get()->first();
        if ($check) return true;
        return false;
    }

    public function isBlocked($blockId){
        $relation = UserFollowing::where('following_user_id', $this->id)->where('follower_user_id', $blockId)->where('allow',3)->get()->first();
        if($relation){
            return true;
        }
        $relation = UserFollowing::where('following_user_id', $blockId)->where('follower_user_id', $this->id)->where('allow',3)->get()->first();
        if($relation){
            return true;
        }
        return false;
    }
    public function isHidden($pId){
        $a = explode(',', $this->hidepost);
        $ab = in_array($pId, $a);
        return $ab;
    }

    public static function isAdmin()
    {
        if (Auth::check()) {
            $u = Auth::user();
            if ($u->role == \App\Models\UserTypes::USER_TYPE_ADMIN) {
                return true;
            }
        }
        return false;
    }
    public function online(){
        return Cache ::has('online-users'.$this->id);
    }
}
