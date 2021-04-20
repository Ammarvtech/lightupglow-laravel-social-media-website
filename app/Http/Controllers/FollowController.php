<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Library\sHelper;
use App\Models\User;
use App\Models\UserFollowing;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;
use Mail;
use App\Models\FollowAccept;
use App\Mail\FollowerNotificationMail;

class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function follow(Request $request){

        $response = array();
        $response['code'] = 400;

        $following_user_id = $request->input('following');
        $follower_user_id = $request->input('follower');
        $element = $request->input('element');
        $size = $request->input('size');
        
        $following = User::find($following_user_id);
        $follower = User::find($follower_user_id);
        
        if ($following && $follower && ($following_user_id == Auth::id() || $follower_user_id == Auth::id())){



            $relation = UserFollowing::where('following_user_id', $following_user_id)->where('follower_user_id', $follower_user_id)->whereIn('allow',[0,1,])->get()->first();

            if ($relation){
                if ($relation->delete()){
                    $response['code'] = 200;
                    if ($following->isPrivate()) {
                        $response['refresh'] = 1;
                    }
                    $response['slideInLeft'] = 0;
                }
            }else{
                // send message notification
                if($this->followAccept($follower_user_id,$following_user_id));
                // send email to followback the user
                $email = $this->sendEmail($following,$follower);
                if($email){
                    $follow = $this->followHim($following_user_id,$follower_user_id);

                    if($follow){
                        $response['code'] = 200;
                        $response['refresh'] = 0;
                    }
                }
            }
            if ($size == 'refresh'){
                $response['refresh'] = 1;
            }
            if ($response['code'] == 200){
                $response['button'] = sHelper::followButton($following_user_id, $follower_user_id, $element, $size);
            }
        }


        return Response::json($response);

    }

    public function followAccept($user_one,$user_two){
        $check = FollowAccept::where('user_one',$user_one)->where('user_two',$user_two)->where('allow',1)->first();
        if(!$check){
            $add = new FollowAccept;
            $add->user_one = $user_one;
            $add->user_two = $user_two;
            $add->save();
        }

        return true;
    }

    public function followAccepted($user_one,$user_two){
        $update = FollowAccept::where('user_one',$user_one)->where('user_two',$user_two)->where('allow',1)->first();
        $update->allow = 0;
        if($update->save());

        return true;
    }
    
    public function block(Request $request){

        $response = array();
        $response['code'] = 400;

        $blockId = $request->input('bId');
        $userId = Auth::id();

        $following = User::find($blockId);
        $follower = User::find($userId);

        if ($following && $follower && ($blockId == Auth::id() || $userId == Auth::id())){
            $relation = UserFollowing::where('following_user_id', $blockId)->where('follower_user_id', $userId)->get()->first();

            if ($relation){
                $relation->allow = 3;
                if ($relation->save()){
                    $response['code'] = 200;
                }
            }else{
                $relation = new UserFollowing();
                $relation->following_user_id = $blockId;
                $relation->follower_user_id = $userId;
                $relation->allow = 3;

                if ($relation->save()){
                    $response['code'] = 200;
                }
            }
        }
        return Response::json($response);
    }

    public function PingUnfollow(Request $req){
        // print_r($req->all()); die;
        $following = $req->following;
        $follower = $req->follower;

        $delete = UserFollowing::where('following_user_id',$following)
        ->where('follower_user_id',$follower)
        ->where('allow',1)
        ->delete();
        if($delete){
            return Response::json([
                'status' => 'delete'
            ]);
        }
    }

    public function unblock(Request $request){

        $response = array();
        $response['code'] = 200;

        $blockId = $request->input('bId');
        $userId = Auth::id();

        $following = User::find($blockId);
        $follower = User::find($userId);

        if ($following && $follower && ($blockId == Auth::id() || $userId == Auth::id())){
            $relation = UserFollowing::where('following_user_id', $blockId)->where('follower_user_id', $userId)->where('allow',3)->get()->first();

            if ($relation){
                if ($relation->delete()){
                    $response['code'] = 200;
                }
            }
        }
        return Response::json($response);
    }

    public function followerRequest(Request $request){


        $response = array();
        $response['code'] = 400;

        $type = $request->input('type');
        $id = $request->input('id');



        $following = UserFollowing::find($id);



        if ($following){

            if ($following->following_user_id = Auth::id()){

                if ($type == 2){
                    if ($following->delete()){
                        $response['code'] = 200;
                    }
                }else{
                    $following->allow = 1;
                    if ($following->save()){
                        $response['code'] = 200;
                    }
                }


            }


        }


        return Response::json($response);

    }

    public function followDenied(Request $request){


        $response = array();
        $response['code'] = 400;

        $me = $request->input('me');
        $follower = $request->input('follower');



        $relation = UserFollowing::where('following_user_id', $me)->where('follower_user_id', $follower)->get()->first();



        if ($relation){


            if ($relation->delete()){
                $response['code'] = 200;
            }


        }


        return Response::json($response);

    }


    public function pending(Request $request){


        $user = Auth::user();

        $list = $user->follower()->where('allow', 0)->with('follower')->get();


        return view('followers_pending', compact('user', 'list'));
    }

    public function FollowBackEmail($following,$follower){
        
        $user = User::find($following);
        $name = $user->name;

        if($this->followAccepted($following,$follower));

        if($this->followHim($following,$follower)){
            echo "<h3 style='text-align:center;'>You're following ".$name." now</h3>";
            echo "<script>
                setTimeout('window.close();', 2000);
            </script>";
        }
    }

    private function sendEmail($following,$follower){

        $following_email = $following->email;
        $notificatioMail = new FollowerNotificationMail($following,$follower);
        $mail = Mail::to($following_email)->send($notificatioMail);

        return true;
    }

    private function followHim($following_user_id,$follower_user_id){
        $following = User::find($following_user_id);
        
        $relation = new UserFollowing();
        $relation->following_user_id = $following_user_id;
        $relation->follower_user_id = $follower_user_id;
        if ($following->isPrivate()){
            $relation->allow = 0;
        }else{
            $relation->allow = 1;
        }

        if($relation->save()){
            return true;
        }
    }
}