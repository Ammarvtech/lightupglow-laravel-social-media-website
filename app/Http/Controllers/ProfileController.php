<?php
namespace App\Http\Controllers;


use App\Models\City;
use App\Models\Country;
use App\Models\Hobby;
use App\Models\User;
use App\Models\UserHobby;
use App\Models\UserLocation;
use App\Models\UserRelationship;
use App\Models\UserFollowing;
use Auth;
use DB;
use View;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;

class ProfileController extends Controller
{
    private $user;
    private $my_profile = false;


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function secure($username, $is_owner = false){
        $user = User::where('username', $username)->first();

        if ($user){
            $this->user = $user;
            $this->my_profile = (Auth::id() == $this->user->id)?true:false;
            if ($is_owner && !$this->my_profile){
                return false;
            }
            if($user->isBlocked(Auth::id())){
                return false;
            }
            return true;
        }
        return false;
    }

    public function index($username){
        set_time_limit(60);
        if (!$this->secure($username)) return redirect('/404');

        $user = $this->user;


        $my_profile = $this->my_profile;


        $wall = [
            'new_post_group_id' => 0
        ];

        $can_see = ($my_profile)?true:$user->canSeeProfile(Auth::id());


        $hobbies = Hobby::all();
        $list = $user->following()->where('allow', 1)->with('following')->orderBy('id')->take(2)->get();
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
        $relationship = $user->relatives()->with('relative')->where('allow', 1)->get();
        $relationship2 = $user->relatives2()->with('main')->where('allow', 1)->get();


        return view('profile.index', compact('user', 'my_profile', 'wall', 'list', 'like_list','can_see', 'hobbies', 'relationship', 'relationship2'));
    }

    public function moreMedia(Request $request){

        $response = array();
        $response['code'] = 400;

        if (!$this->secure($request->username)) return redirect('/404');

        $id = $request->id;
        $type = $request->type;
        $user = $this->user;
        if($type =='photos'){
            $posts = $user->posts()->where('has_image',1)->where('id','<',$id)->orderBy('id','desc')->limit(8)->get();
            $response['code'] = 200;
            $html = View::make('widgets.suggested_more_media')->with('posts',$posts);
            $response['content'] = $html->render();
        }
        if($type =='videos'){
            $posts = $user->posts()->where('has_video',1)->where('id','<',$id)->orderBy('id','desc')->limit(8)->get();
            $response['code'] = 200;
            $html = View::make('widgets.suggested_more_media')->with('posts',$posts);
            $response['content'] = $html->render();
        }
        if($type =='attachment'){
            $posts = $user->posts()->where('has_attachment',1)->where('id','<',$id)->orderBy('id','desc')->limit(8)->get();
            $response['code'] = 200;
            $html = View::make('widgets.suggested_more_media')->with('posts',$posts);
            $response['content'] = $html->render();
        }
        if($type =='link'){
            $posts = $user->posts()->where('has_link',1)->where('id','<',$id)->orderBy('id','desc')->limit(8)->get();
            $response['code'] = 200;
            $html = View::make('widgets.suggested_more_media')->with('posts',$posts);
            $response['content'] = $html->render();
        }

        return Response::json($response);
    }

    public function following(Request $request, $username){

        if (!$this->secure($username)) return redirect('/404');

        $user = $this->user;

        $list = $user->following()->where('allow', 1)->with('following')->get();

        $my_profile = $this->my_profile;

        $can_see = ($my_profile)?true:$user->canSeeProfile(Auth::id());

        return view('profile.following', compact('user', 'list', 'my_profile', 'can_see'));
    }


    public function followers(Request $request, $username){

        if (!$this->secure($username)) return redirect('/404');

        $user = $this->user;

        $list = $user->follower()->where('allow', 1)->with('follower')->get();


        $my_profile = $this->my_profile;

        $can_see = ($my_profile)?true:$user->canSeeProfile(Auth::id());

        return view('profile.followers', compact('user', 'list', 'my_profile', 'can_see'));
    }


    public function saveSocialids(Request $request, $username){
        $response = array();
        $response['code'] = 400;
        if (!$this->secure($username, true)) return Response::json($response);

        $data = json_decode($request->input('information'), true);


        $validator = Validator::make($data, [
            'facebook_uid' => 'max:255',
            'twitter_uid' => 'max:255',
            'instagram_uid' => 'max:255',
            'youtube_uid' => 'max:255',
            'linkedin_uid' => 'max:255',
        ]);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $user = $this->user;
            if(isset($data['facebook_uid']))
            $user->facebook_uid = $data['facebook_uid'];
            if(isset($data['twitter_uid']))
            $user->twitter_uid = $data['twitter_uid'];
            if(isset($data['instagram_uid']))
            $user->instagram_uid = $data['instagram_uid'];
            if(isset($data['youtube_uid']))
            $user->youtube_uid = $data['youtube_uid'];
            if(isset($data['linkedin_uid']))
            $user->linkedin_uid = $data['linkedin_uid'];
            $save = $user->save();
            if ($save){
                $response['code'] = 200;
            }

        }

        return Response::json($response);
    }

    public function saveInformation(Request $request, $username){
        $response = array();
        $response['code'] = 400;
        if (!$this->secure($username, true)) return Response::json($response);

        $data = json_decode($request->input('information'), true);


        $validator = Validator::make($data, [
            'sex' => 'in:0,1',
            'birthday' => 'date',
            'phone' => 'max:20',
            'bio' => 'max:255',
            'skills' => 'max:255',
        ]);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $user = $this->user;
            if(isset($data['sex']))
            $user->sex = $data['sex'];
            if(isset($data['birthday']))
            $user->birthday = $data['birthday'];
            if(isset($data['phone']))
            $user->phone = $data['phone'];
            if(isset($data['bio']))
            $user->bio = $data['bio'];
            if(isset($data['skills']))
            $user->skills = $data['skills'];
            $save = $user->save();
            if ($save){
                $response['code'] = 200;
            }

        }

        return Response::json($response);
    }

    public function saveHobbies(Request $request, $username){

        if (!$this->secure($username)) return redirect('/404');


        $my_hobbies = Auth::user()->hobbies()->get();


        $list = [];

        foreach($request->input('hobbies') as $i => $id){
            $list[$id] = 1;
        }



        foreach($my_hobbies as $hobby){
            $hobby_id = $hobby->hobby_id;
            if (!array_key_exists($hobby_id, $list)){
                $deleted = DB::delete('delete from user_hobbies where user_id='.Auth::id().' and hobby_id='.$hobby_id);
            }
            unset($list[$hobby_id]);
        }



        foreach($list as $id => $status){
            $hobby = new UserHobby();
            $hobby->user_id = Auth::id();
            $hobby->hobby_id = $id;
            $hobby->save();
        }

        $request->session()->flash('alert-success', 'Your hobbies have been successfully updated!');

        return redirect('/'.Auth::user()->username);

    }

    public function saveRelationship(Request $request, $username){

        if (!$this->secure($username)) return redirect('/404');


        $relationship = $request->input('relation');
        $person = $request->input('person');


        $relation = new UserRelationship();
        $relation->main_user_id = $person;
        $relation->relation_type = $relationship;
        $relation->related_user_id = Auth::id();

        if ($relation->save()) {

            $request->session()->flash('alert-success', 'Your relationship have been successfully requested! He/She needs to accept relationship with you to publish.');

        }else{
            $request->session()->flash('alert-danger', 'Something wents wrong!');
        }

        return redirect('/'.Auth::user()->username);
    }

    public function uploadProfilePhoto(Request $request, $username){
        // print_r($request->all()); die;
        $response = array();
        $response['code'] = 400;
        if (!$this->secure($username, true)) return Response::json($response);

        $messages = [
            'image.required' => trans('validation.required'),
            'image.mimes' => trans('validation.mimes'),
            'image.max.file' => trans('validation.max.file'),
        ];
        $validator = Validator::make(array('image' => $request->file('image')), [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
        ], $messages);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $file = $request->image;

            $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            // echo $file_name;
            if ($file->move('storage/uploads/profile_photos', $file_name)){
                $response['code'] = 200;
                $this->user->profile_path = $file_name;
                $this->user->save();
                $response['image_big'] = $this->user->getPhoto();
                $response['image_thumb'] = $this->user->getPhoto(200, 200);
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }
        }
        return Response::json($response);
    }

    public function uploadCover(Request $request, $username){

        $response = array();
        $response['code'] = 400;
        if (!$this->secure($username, true)) return Response::json($response);

        $messages = [
            'image.required' => trans('validation.required'),
            'image.mimes' => trans('validation.mimes'),
            'image.max.file' => trans('validation.max.file'),
        ];
        $validator = Validator::make(array('image' => $request->file('image')), [
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
        ], $messages);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{
            $file = $request->file('image');

            $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            if ($file->move('storage/uploads/covers', $file_name)){
                $response['code'] = 200;
                $this->user->cover_path = $file_name;
                $this->user->save();
                $response['image'] = $this->user->getCover();
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }
        }
        return Response::json($response);

    }
}
