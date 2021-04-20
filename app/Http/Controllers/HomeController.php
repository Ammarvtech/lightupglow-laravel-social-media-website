<?php

namespace App\Http\Controllers;

use App\Library\IPAPI;
use App\Library\sHelper;
use App\Models\Group;
use App\Models\Hobby;
use App\Models\Post;
use App\Models\User;
use App\Models\UserFollowing;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Storage;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use App\Models\SocialPost;
use App\Models\PostImage;
use App\Models\PostVidoe;
use Twitter;
use Session;
use Alaouy\Youtube\Facades\Youtube;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function starterIndex(Request $request)
    {
        $likeEachOther = UserFollowing::whereAllow(1)->groupBy('following_user_id')->get();
        $like_list = array();
        foreach ($likeEachOther as $value) {
            $results = UserFollowing::whereAllow(1)->whereFollowerUserId($value->following_user_id)->get()->take(2);
            if($results->count()>0 && $results->count() == 2){
                $json = new \stdClass();
                $json->{'common'} = User::find($value->following_user_id);
                foreach ($results as $key => $value) {
                    if($key==0){
                        $json->{'first'} = User::find($value->following_user_id);
                    }else{
                        $json->{'second'} = User::find($value->following_user_id);
                    }
                }
                    $like_list[] = $json;
            }
        }
        $user = Auth::user();

        $wall = [
            'new_post_group_id' => 0
        ];

        $this->user = $user;
        $this->my_profile = (Auth::id() == $this->user->id)?true:false;
        $list = $user->following()->where('allow', 1)->with('following')->orderBy('id')->take(2)->get();

        $my_profile = $this->my_profile;

        $can_see = ($my_profile)?true:$user->canSeeProfile(Auth::id());

        return view('profile.getting_started', compact('user', 'wall', 'list', 'my_profile', 'can_see','like_list'));

    }

    public function postStarterIndex(Request $request){
        $data = $request->all();
        $input = json_decode($data['data']);

        $response = array();
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";


        if($data['image-type'] == 1 && $request->hasFile('image')){
                $file = $request->file('image');

                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/profile_photos', $file_name)){
                    Auth::user()->profile_path = $file_name;
                    Auth::user()->save();
                }else{
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                }
        }elseif($data['image-type'] == 2 && $data['image'] != ''){
            $contents = file_get_contents($data['image']);
            if(stripos($data['image'],'.jpg')){
                $file_name = md5(uniqid() . time()) . '.jpg';
            }

            if(stripos($data['image'],'.png')){
                $file_name = md5(uniqid() . time()) . '.png';
            }

            if(stripos($data['image'],'.jpeg')){
                $file_name = md5(uniqid() . time()) . '.jpeg';
            }

            if(stripos($data['image'],'.gif')){
                $file_name = md5(uniqid() . time()) . '.gif';
            }

            if ( File::put('storage/uploads/profile_photos/'.$file_name, $contents)){
                Auth::user()->profile_path = $file_name;
                Auth::user()->save();
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }
        }


            if(isset($input->name)){
                Auth::user()->name = $input->name;
            }

            if(isset($input->username)){
                Auth::user()->username = $input->username;
            }

            if(isset($input->phone)){
                Auth::user()->phone = $input->phone;
            }
            if(isset($input->bio)){
                Auth::user()->bio = $input->bio;
            }
            if(isset($input->marital_status)){
                Auth::user()->marital_status = $input->marital_status;
            }
            if(isset($input->skills)){
                Auth::user()->skills = $input->skills;
            }
            if(isset($input->current_city)){
                Auth::user()->current_city = $input->current_city;
            }
            if(isset($input->nationality)){
                Auth::user()->nationality = $input->nationality;
            }
            if(isset($input->interested_in)){
                Auth::user()->interested_in = $input->interested_in;
            }
            if(isset($input->category)){
                Auth::user()->category = $input->category;
            }


            $save = Auth::user()->save();

            if($save){
                $response['code'] = 200;
                $response['message'] = 'Saved Successfully';
            }

        return Response::json($response);
    }
    public function getProfilePicture(Request $request)
    {
        $client = new \GuzzleHttp\Client;
        $fbpagename = $request->input('fbpage');
        $fbPageUrl = 'https://graph.facebook.com/v2.12/'.$fbpagename.'/picture?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&format=json&redirect=false&type=large';
        $fbResponse = $client->get($fbPageUrl);
        $fbpage = $fbResponse->getBody();
        $fbpage = json_decode($fbpage);
        return Response::json($fbpage);

    }
    public function index(Request $request){
        $likeEachOther = UserFollowing::whereAllow(1)->groupBy('following_user_id')->get();
        $like_list = array();
        foreach ($likeEachOther as $value) {
            $results = UserFollowing::whereAllow(1)->whereFollowerUserId($value->following_user_id)->get()->take(2);
            if($results->count()>0 && $results->count() == 2){
                $json = new \stdClass();
                $json->{'common'} = User::find($value->following_user_id);
                foreach ($results as $key => $value) {
                    if($key==0){
                        $json->{'first'} = User::find($value->following_user_id);
                    }else{
                        $json->{'second'} = User::find($value->following_user_id);
                    }
                }
                    $like_list[] = $json;
            }
        }
        $user = Auth::user();

        $wall = [
            'new_post_group_id' => 0
        ];

        $this->user = $user;
        
        $this->my_profile = (Auth::id() == $this->user->id)?true:false;
        
        $list = $user->following()->where('allow', 1)->with('following')->orderBy('id','desc')->limit(3)->get();

        $my_profile = $this->my_profile;
        
        $can_see = ($my_profile)?true:$user->canSeeProfile(Auth::id());

        $user = Auth::user();
        
        $user_list = $user->messagePeopleList();

        $show = false;
        if ($id != null){
            $friend = User::find($id);
            if ($friend){
                $show = true;
            }
        }
        
        // twitter and youtube
        return view('home', compact('user','user_list', 'show', 'id','wall', 'list', 'my_profile', 'can_see','like_list'));

    }

    public function search(Request $request){

        $s = $request->input('s');
        if (empty($s)) return redirect('/');


        $user = Auth::user();

        $posts = Post::leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where(function($query) use ($user) {

                $query->where('users.private', 0)->orWhere(function($query) use ($user){
                    $query->whereExists(function ($query) use($user){
                        $query->select(DB::raw(1))
                            ->from('user_following')
                            ->whereRaw('user_following.following_user_id = users.id and user_following.follower_user_id = '.$user->id);
                    });
                })->orWhere(function($query) use ($user){
                    $query->where('users.private', 1)->where('users.id', $user->id);
                });

            })->where('posts.content', 'like', '%'.$s.'%')->where('posts.group_id', 0)
            ->groupBy('posts.id')->select('posts.*')->orderBy('posts.id', 'DESC')->get();

        $comment_count = 2;

        $users = User::where('name', 'like', '%'.$s.'%')->orWhere('username', 'like', '%'.$s.'%')->orderBy('name', 'ASC')->get();

        return view('search', compact('users', 'posts', 'user', 'comment_count'));

    }

    public function searchUser(Request $request){

        $keyword = $request->input('keyword');

        $Admin = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Admin' ORDER BY `created_at` DESC");
        $Celebrity = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Celebrity' ORDER BY `created_at` DESC");
        $Follower = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Follower' ORDER BY `created_at` DESC");
        $Fanpage = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Fanpage' ORDER BY `created_at` DESC");
        return View("widgets.searchuser", compact('Admin', 'Celebrity', 'Follower', 'Fanpage','keyword'))->render();

    }

    public function searchCelebrity(Request $request){

        $keyword = $request->input('keyword');

        $Admin = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Admin' ORDER BY `created_at` DESC");
        $Celebrity = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Celebrity' ORDER BY `created_at` DESC");
        $Follower = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Follower' ORDER BY `created_at` DESC");
        $Fanpage = DB::select("select * from users WHERE (`name` LIKE '%$keyword%' or `username` LIKE '%$keyword%' or `email` LIKE '%$keyword%' or `nickname` LIKE '%$keyword%') AND `role` = 'Fanpage' ORDER BY `created_at` DESC");
        return View("widgets.searchcelebrity", compact('Admin', 'Celebrity', 'Follower', 'Fanpage','keyword'))->render();

    }

    public function searchCelebrityNearMe(){
        $user = Auth::user();
        $current_city = $user->current_city;
        $nationality = $user->nationality;
        $celebrities = DB::select("select * from users WHERE (`current_city` LIKE '%$current_city%' or `nationality` LIKE '%$nationality%') AND `role` = 'Celebrity' ORDER BY `created_at` DESC");
        return View("celebrities.nearme", compact('celebrities'));

    }
    public function searchCountry(Request $request){

        $keyword = $request->input('keyword');

        $countries = DB::select("select * from countries WHERE (`name` LIKE '%$keyword%') ORDER BY `name` ASC");
        //dd($countries);
        return View("widgets.searchcountry", compact('countries','keyword'))->render();

    }

    public function autocomplete(){
        $term = Input::get('term');
        $results = array();
        $queries = DB::table('users')
        ->where('first_name', 'LIKE', '%'.$term.'%')
        ->orWhere('last_name', 'LIKE', '%'.$term.'%')
        ->take(5)->get();

        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->first_name.' '.$query->last_name ];
        }
        return Response::json($results);
    }

    // twitter
    public function twitterFeed() {
        
        $sign_in_twitter = true;
        $force_login = false;
    
        Twitter::reconfig(['token' => '', 'secret' => '']);
        $token = Twitter::getRequestToken(route('twitter_callback'));
    
        if (isset($token['oauth_token_secret'])) {
            
            $url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);
            
            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);
            
            return Redirect::to($url);
        }
    }

// Callback url for successful auth twitter user

public function twitterCallback() {
        
        if (Session::has('oauth_request_token')) {
            
            $request_token = [
                'token'  => Session::get('oauth_request_token'),
                'secret' => Session::get('oauth_request_token_secret'),
            ];
            
            Twitter::reconfig($request_token);
            
            $oauth_verifier = false;
            
            if (Input::has('oauth_verifier')) {
                
                $oauth_verifier = Input::get('oauth_verifier');
            }
            
            // getAccessToken() will reset the token for you
            $token = Twitter::getAccessToken($oauth_verifier);
            
            if (!isset($token['oauth_token_secret'])) {
                
                return Redirect::route('twitter.login')->with('flash_error', 'We could not log you in on Twitter.');
            }
            
            $credentials = Twitter::getCredentials();
            
            if (is_object($credentials) && !isset($credentials->error)) {
                
                Session::put('access_token', $token);
                
                //return Redirect::route('twitter_page')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
            }
            
            //return Redirect::route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
        }
    }
	
	public function tweet_test($tweet,$tweet_id = null){
		$params = array();
		$params['status'] = $tweet;
		$params['format'] = "json";
		if($tweet_id != null)
			$params['in_reply_to_status_id'] = $tweet_id;
		//print_r($params); die;
		$post = Twitter::postTweet($params);
		echo "<pre>";
		print_r($post);
		echo "</pre>";
		die();
	}           
}
