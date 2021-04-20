<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\SocialUser;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostVideo;
use App\Models\SocialPost;
use App\Models\PingMe;
use App\Models\PostComment;
use App\Models\PostLike;
use Auth;
use Illuminate\Http\Request;
use Socialite;
use Yajra\Datatables\Datatables;
use Twitter;
use TwitterClass;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Library\Instagram;

class UserController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//        $this->middleware('auth.admin', ['only' => [
//            'userDelete'
//        ]]);
//    }

    public function suggestMore(Request $request)
	{
    	$offset = $request->get('offset');
        if(Auth::check()){
    		$list = User::where('id', '!=', Auth::User()->id);
            $list = $list->whereNotIn('id', function ($q) {
                $q->select('following_user_id')->from('user_following')->where('follower_user_id', Auth::User()->id);
            });
            $list = $list->offset($offset)->limit(12)->oldest()->get();
        }else{
            $list = User::offset($offset)->limit(12)->oldest()->get();
        }
        return View("widgets.suggested_more_people")->with('list', $list)->render();
    }
    public function suggestFollowMore(Request $request)
    {
        // print_r($request->all()); die;
        $slideInLeft = $request->get('slideInLeft');
        $offset = $request->get('offset');
        $id = $request->get('uid');
        if(Auth::check()){
            $user = User::find($id);
            $list = $user->following()->where('allow', 1)->with('following')->orderBy('id','desc')->offset($offset)->limit(3)->get();
        }
        return View("widgets.following_home_more")->with('list', $list)->with('slideInLeft', $slideInLeft)->render();
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
	//return Socialite::driver($provider)->scope('basic')->redirect();
    }

    public function handleProviderCallback($provider){
        if($provider == 'twitter'){
            $user = Socialite::driver($provider)->user();
            $twitter = new TwitterClass;
            $success = $twitter->connect($user);
            if($success){
                echo "<h4 style='text-align:center;'>Thank you for login with Twitter</h4>";
                echo "<script type='text/javascript'>
                setTimeout('window.close();', 1000);
                </script>";
            }

        }elseif ($provider == 'facebook') {
            // print_r($user);die;
            Auth::user()->facebook_uid = $user->id;
            Auth::user()->save();
            if(Auth::user()->save()){
                $check = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')->first();
                $checkToken = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')->where('access_token',$user->token)->first();
                $checkName = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')
                ->where('username',$user->name)->first();
                $checkProfile = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')
                ->where('profile_url',$user->avatar)->first();
                $checkSocialUserId = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')
                ->where('social_user_id',0)->first();
                if(!$check){
                    $socialUser = new SocialUser;
                    $socialUser->user_id = Auth::user()->id;
                    $socialUser->name = 'facebook';
                    $socialUser->access_token = $user->token;
                    $socialUser->profile_url = $user->avatar;
                    $socialUser->username = $user->name;
                    $socialUser->social_no = 2;    
                    $socialUser->social_user_id = $user->id;
                    $socialUser->save();
                }else if(!$checkToken || !$checkName || !$checkProfile || $checkSocialUserId){
                    $updateSocialUser = SocialUser::where('user_id',Auth::user()->id)->where('name','facebook')->first();
                    $updateSocialUser->access_token = $user->token;
                    $updateSocialUser->username = $user->name;
                    $updateSocialUser->profile_url = $user->avatar;
                    $updateSocialUser->social_user_id = $user->id;
                    $updateSocialUser->save();
                }
                // echo $user->token.' '.$user->id;
                // die;
                $facebookAuth = 'https://graph.facebook.com/v4.0/'.$user->id.'/feed?access_token='.$user->token;
                $client = new \GuzzleHttp\Client();
                $response = $client->get($facebookAuth);
                $datas = json_decode($response->getbody()->getContents());
                print_r($datas);
            }
        }elseif ($provider == 'youtube') {
            Auth::user()->youtube_uid = $user->id;
            Auth::user()->save();
            if(Auth::user()->save()){
                echo 'Connected';
            }
        }elseif ($provider == 'instagram'){
            // instagram code
            $code = trim($_SERVER['QUERY_STRING'],'code=');
            /**
             * delete old instgram posts
             * brought by instagram API
             * now using instagram_basic_display ang instagram _graph_api
             * from facebook developer account.
             */
            $post = new Post;
            $posts = $post->checkInstagram(Auth::user()->id);
            if($posts){
                $instagram = new Instagram;
                $success = $instagram->connect($code);
                if($success){
                    echo '<h4 style="text-align:center;">Thank you for login with Instagram</h4>';
                    echo "<script type='text/javascript'>
                    setTimeout('window.close();', 1000);
                    </script>";
                }
            }
        }


    }

    // insta coomment and authanticate insta users
    public function socialAuthanticate($name){
        if($name == 'instagram'){
            $socialUser = SocialUser::where('user_id',Auth::user()->id)->where('name',$name)->first();
            $token = $socialUser->access_token;
            $instaAuth = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$token;
            $client = new \GuzzleHttp\Client();

            try {
                $client->request('GET', $instaAuth);
                $response = $client->get($instaAuth);
                $datas = json_decode($response->getbody()->getContents(),true);
                // print_r($datas);die;
                $username = $datas['data'][0]['user']['full_name'];
                $profile = $datas['data'][0]['user']['profile_picture'];                    
                if($socialUser->username !== $username || $socialUser->profile_url !== $profile){
                    return response([
                        'code' => 400,
                    ]);
                }else{
                    return response([
                        'code' => 200,
                        'profile' => $socialUser->profile_url,
                    ]);
                }
            } catch (RequestException $e) {
                return response([
                    'code' => 400,
                ]);
            }         
        }else if($name == 'facebook'){
            $socialUser = SocialUser::where('user_id',Auth::user()->id)->where('name',$name)->first();
            $userId = User::where('id',Auth::user()->id)->first();
            $id = $userId->facebook_uid;
            $token = $socialUser->access_token;
            $fbAuth = 'https://graph.facebook.com/v4.0/'.$id.'?
            fields=id,name&access_token='.$token;
            $client = new \GuzzleHttp\Client();            
            // $response = $client->get($fbAuth);
            // print_r($response);die;
            // $datas = json_decode($response->getbody());
            // print_r($datas);die;
            // $statusCode = $response->getStatusCode();
    
            try {
                $client->request('GET', $fbAuth);
                return response([
                    'code' => 200,
                    'profile' => $socialUser->profile_url,
                ]);
            } catch (RequestException $e) {
                return response([
                    'code' => 400,
                ]);
            }            
        }else if($name == 'twitter'){
            $socialUser = SocialUser::where('user_id',Auth::user()->id)->where('name',$name)->first();
            $userId = User::where('id',Auth::user()->id)->first();
            $id = $userId->twitter_uid;
            $token = $socialUser->access_token;
            $username = $socialUser->username;
            $profile = $socialUser->profile_url;

            if(!$id){
                return response([
                    'code' => 400,
                ]);
            }

            $tweetUser = Twitter::getUsers([
                'user_id' => $id,
            ]);

            // echo $profile.'</br>'.$tweetUser->profile_image_url;die;

            if($tweetUser->name != $username || $tweetUser->profile_image_url != $profile){
                
                return response([
                    'code' => 400,
                ]);
            }else{
                return response([
                    'code' => 200,
                    'profile' => $socialUser->profile_url,
                ]);
            }
            
        }
    }

    // show all data in users data table
    public function showUser(){
        // fetch user data
        $users = User::select('id','name','username','current_city','nationality')
            ->get();
        return view('users.users',[
            // 'users' => $users,
        ]);
    }

    // fetch data for show on user more details modal table
    public function userMoreDetails(Request $request){
        //    print_r($request->id);die;
        $id = $request->id;
        $users = User::where('id',$id)->get();

        return response()->json([
            'users' => $users,
        ]);

    }

    // get user data for ajax
    public function getDataUsers(){
        $users = User::select('id', 'name', 'username', 'current_city', 'nationality')->where('is_delete',0)->get();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<button userId="' . $user->id . '" class="btn btn-xs btn-primary userMoreDetailBtn" title="user update" style="margin-right:1px;"><i class="far fa-edit"></i></button>' .
                    '<button userId="' . $user->id . '" class="btn btn-xs btn-danger userDeleteBtn" title="delete user" style="margin-right:1px;"><i class="fas fa-trash-alt"></i></button>';
            })
            ->make(true);
    }

    // user email validation
    public function userEmailValidate(Request $request){
        // print_r($request->email.' '.$request->id);die;
        $id = $request->id;
        $email = $request->email;
        $error = 1;
        $msg = "";


        // check if email is already exists or not
        $userEmail = User::where('id',$id)->where('email',$email)->get();
        $existsEmail = User::where('email',$email)->get();

        if(count($userEmail) > 0 && count($existsEmail) == 0){
            $error = 0;
            $msg = "";
        }else if(count($existsEmail) > 0 && count($userEmail) == 0){
            $error = 1;
            $msg = "This email has already exists";
        }else{
            $error = 0;
            $msg = "";
        }

        return response([
            'error' => $error,
            'msg' => $msg,
        ]);
    }

    // user update
    public function userUpdate(Request $request){
        // print_r($_POST);die;
        
        $id = $request->userId;
        $name = $request->userName;
        $usernName = $request->user_name;
        $currentCity = $request->userCurrentCity;
        $nationality = $request->nationality;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $nickName = $request->userNickname;
        $email = $request->userEmail;
        $phone = $request->userPhone;
        $sex = $request->userSex;
        $birthday = $request->userBirthday;
        $userRole = $request->userRole;
        $category = $request->userCategory;
        $skills = $request->userSkills;
        $interested = $request->userInterested;
        $marital = $request->userMarital;
        $bio = $request->userBio;

        $birthday = date('Y-m-d',strtotime($birthday));
        $error = 1;
        $msg = "";

        // when profile and cover files are available
        if($request->hasFile('profileImage') && $request->hasFile('coverImage')){
            
            $coverImage = $request->file('coverImage');
            $profileImage = $request->file('profileImage');

            $validator = Validator::make($request->all(), [
                'profileImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'coverImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                    ], [
                'profileImage.required' => 'profile image is not a profile image',
                'coverImage.required' => 'cover image is not an image',
                ]);

            if ($validator->fails()) {
                $error = 1;
                $messages = $validator->messages();
                foreach ($messages->all() as $m) {
                    $msg = $m;
                }
            }else{
                $userEmail = User::where('id',$id)->where('email',$email)->get();
                $existsEmail = User::where('email',$email)->get();

                if(count($existsEmail) > 0 && count($userEmail) == 0){
                    $error = 1;
                    $msg = "This email has already exists";
                }else{
                    //  update profile and and cover
                    $pro_extension = $profileImage->getClientOriginalExtension();
                    $cover_extension = $coverImage->getClientOriginalExtension();

                    $profiledestination = 'storage/uploads/profile_photos';
                    $coverdestination = 'storage/uploads/covers';

                    $profileName = $id.'.'.$pro_extension;
                    $coverName = $id.'.'.$cover_extension;
                    
                    $profileImage->move($profiledestination,$profileName); 
                    $coverImage->move($coverdestination,$coverName);

                    $update = User::where('id',$id)->update([
                        'name' => $name,
                        'email' => $email,
                        'username' => $usernName,
                        'role' => $userRole,
                        'sex' => $sex,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'birthday' => $birthday,
                        'bio' => $bio,
                        'phone' => $phone,
                        'current_city' => $currentCity,
                        'nationality' => $nationality,
                        'marital_status' => $marital,
                        'skills' => $skills,
                        'category' => $category,
                        'nickname' => $nickName,
                        'profile_path' => $profileName,
                        'cover_path' => $coverName,
                        'interested_in' => $interested,
                    ]);

                    if($update){
                        $error = 0;
                    }
                }
            }
        // when cover file only available..
        }else if($request->hasFile('coverImage') && !$request->hasFile('profileImage')){
            $coverImage = $request->file('coverImage');

            $validator = Validator::make($request->all(), [
                'coverImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                    ], [
                'coverImage.required' => 'cover image is not an image',
                ]);

            if ($validator->fails()) {
                $error = 1;
                $messages = $validator->messages();
                foreach ($messages->all() as $m) {
                    $msg = $m;
                }
            }else{
                $userEmail = User::where('id',$id)->where('email',$email)->get();
                $existsEmail = User::where('email',$email)->get();

                if(count($existsEmail) > 0 && count($userEmail) == 0){
                    $error = 1;
                    $msg = "This email has already exists";
                }else{
                    //  update profile and and cover
                    $cover_extension = $coverImage->getClientOriginalExtension();

                    $coverdestination = 'storage/uploads/covers';

                    $coverName = $id.'.'.$cover_extension;

                    $coverImage->move($coverdestination,$coverName);

                    $update = User::where('id',$id)->update([
                        'name' => $name,
                        'email' => $email,
                        'username' => $usernName,
                        'role' => $userRole,
                        'sex' => $sex,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'birthday' => $birthday,
                        'bio' => $bio,
                        'phone' => $phone,
                        'current_city' => $currentCity,
                        'nationality' => $nationality,
                        'marital_status' => $marital,
                        'skills' => $skills,
                        'category' => $category,
                        'nickname' => $nickName,
                        'cover_path' => $coverName,
                        'interested_in' => $interested,
                    ]);

                    if($update){
                        $error = 0;
                    }
                }
            }
        // whne profile file only available
        }else if($request->hasFile('profileImage') && !$request->hasFile('coverImage')){
            $profileImage = $request->file('profileImage');

            $validator = Validator::make($request->all(), [
                'profileImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                    ], [
                'profileImage.required' => 'profile image is not a profile image',
                ]);

            if ($validator->fails()) {
                $error = 1;
                $messages = $validator->messages();
                foreach ($messages->all() as $m) {
                    $msg = $m;
                }
            }else{
                $userEmail = User::where('id',$id)->where('email',$email)->get();
                $existsEmail = User::where('email',$email)->get();

                if(count($existsEmail) > 0 && count($userEmail) == 0){
                    $error = 1;
                    $msg = "This email has already exists";
                }else{
                    //  update profile and and cover
                    $pro_extension = $profileImage->getClientOriginalExtension();

                    $profiledestination = 'storage/uploads/profile_photos';

                    $profileName = $id.'.'.$pro_extension;
                    
                    $profileImage->move($profiledestination,$profileName); 

                    $update = User::where('id',$id)->update([
                        'name' => $name,
                        'email' => $email,
                        'username' => $usernName,
                        'role' => $userRole,
                        'sex' => $sex,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'birthday' => $birthday,
                        'bio' => $bio,
                        'phone' => $phone,
                        'current_city' => $currentCity,
                        'nationality' => $nationality,
                        'marital_status' => $marital,
                        'skills' => $skills,
                        'category' => $category,
                        'nickname' => $nickName,
                        'profile_path' => $profileName,
                        'interested_in' => $interested,
                    ]);

                    if($update){
                        $error = 0;
                    }
                }
            }
        // when no files selected
        }else{
            $userEmail = User::where('id',$id)->where('email',$email)->get();
            $existsEmail = User::where('email',$email)->get();

            if(count($existsEmail) > 0 && count($userEmail) == 0){
                $error = 1;
                $msg = "This email has already exists";
            }else{
                $update = User::where('id',$id)->update([
                    'name' => $name,
                    'email' => $email,
                    'username' => $usernName,
                    'role' => $userRole,
                    'sex' => $sex,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'birthday' => $birthday,
                    'bio' => $bio,
                    'phone' => $phone,
                    'current_city' => $currentCity,
                    'nationality' => $nationality,
                    'marital_status' => $marital,
                    'skills' => $skills,
                    'category' => $category,
                    'interested_in' => $interested,
                    'nickname' => $nickName,
                ]);

                if($update){
                    $error = 0;
                }
            }
        }

        return response([
            'error' => $error,
            'msg' => $msg,
        ]);
    }

    // user block function
    public function userBlock(Request $request){
        // print_r($request->id);die;
        $id = $request->id;

        // check if this user is active or block
        $checkUser = User::where('id',$id)->get();
        foreach($checkUser as $user)

            if ($user->is_active == 0) {
                // if user is active make him to block
                $block = User::where('id', $id)->update([
                    'is_active' => 1,
                ]);
                if ($block) {
                    $success = 1;
                }
            } else {
                // if user is block make him to active
                $active = User::where('id', $id)->update([
                    'is_active' => 0,
                ]);
                if ($active) {
                    $success = 0;
                }
            }

        return response([
            'success' => $success,
        ]);
    }

    // user Delete
    public function userDelete(Request $request){
        // print_r($request->id);die;
        $id = $request->id;

        // delete user from database
        $delete = User::where('id',$id)->update([
            'is_delete' => 1,
        ]);
        if($delete){
            $delete = 0;
            return response([
                'delete' => $delete,
            ]);
        }
    }


    // user add

    // add user email validation
    public function addUserEmailValidation(Request $request){
        // print_r($request->all());die;
        $email = $request->email;
        $error = 1;
        $msg = "";

        $userData = User::where('email',$email)->get();
        if(count($userData) > 0){
            $error = 1;
            $msg = "this email has already exists";
        }else{
            $error = 0;
            $msg = "";
        }

        return response([
            'error' => $error,
            'msg' => $msg,
        ]);
    }

    public function storeUser(Request $request){
        // print_r($request->all());die;
        $admin = Auth::user();
        $adminId = $admin->id;
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:users',
            'user_name' => 'required',
            'password' => 'required',
            'userName' => 'required',
            'userCurrentCity' => 'required',
            'nationality' => 'required',
            'userInterested' => 'required',
            'userMarital' => 'required',
            'userSkills' => 'required',
            'userCategory' => 'required',
            'userRole' => 'required',
            'userAddProfile' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'userAddCover' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ], [
            'firstName.required' => 'First name is required',
            'lastName.required' => 'Last name is required',
            'email.required' => 'Email is required  ',
            'email.unique' => 'this email has already exists',
            'user_name.required' => 'User Name is requied',
            'password.required' => 'Please enter password',
            'userName.required' => 'Name is required',
            'userCurrentCity.required' => 'Current City is required',
            'nationality.required' => 'Nationality is required',
            'userInterested.required' => 'Interested In is required',
            'userMarital.required' => 'Marital status is required',
            'userSkills.required' => 'Skills is required',
            'userCategory.required' => 'Category is required',
            'userRole.required' => 'Role is required',
        ]);

        if ($validator->fails()) {
            $error = 1;
            $msg="";
            $msg = $validator->messages();
            //  foreach ( $messages->all() as $m) {
            //      $msg_text .= $m . "<br>";
            // }
        } else{
            $birthday = $request->userBirthday;
            $birthdayData = date('Y-m-d',strtotime($birthday));
    
            $user = new User();
    
            $user->first_name = request('firstName');
            $user->last_name = request('lastName');
            $user->username = request('user_name');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));
            $user->password_clear = request('password');
            $user->name = request('userName');
            $user->phone = request('userPhone');
            $user->birthday = $birthdayData;
            $user->sex = request('userSex');
            $user->role = request('userRole');
            $user->current_city = request('userCurrentCity');
            $user->nationality = request('nationality');
            $user->interested_in = request('userInterested');
            $user->marital_status = request('userMarital');
            $user->skills = request('userSkills');
            $user->nickname = request('userNickname');
            $user->category = request('userCategory');
            $user->bio = request('userBio');
            $user->entered_by = $adminId;
    
    
            if($user->save()){
                $error = 0;
                $msg = "Succesfull Added";
            }
        }
        
        
        return response([
            'error' => $error,
            'msg' => $msg,
        ]);
    }

    public function followingUserList(Request $req){
        // print_r($req->all()); die;
        $id = $req->id;
        $postId = $req->postId;
        $user = new User;
        $datas = $user->followingUsers($id);

        $checkPinged = PingMe::join('posts','posts.id','ping_me.post_id')
        ->select('ping_me.pinged_id')
        ->where('posts.pvt_ping',1)
        ->where('ping_me.post_id',$postId)->where('ping_me.pingedby_id',$id)->get();

        // print_r($checkPinged);

        return response([
            'data' => $datas,
            'ping' => $checkPinged
        ]);
    }
}