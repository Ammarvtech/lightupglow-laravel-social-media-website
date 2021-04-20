<?php 
namespace App\Http\Controllers;
 
use App\Library\IPAPI;
use App\Library\sHelper;
use App\Models\Group;
use App\Models\Hobby;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserFollowing;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

 
class GuestController extends Controller
{
 
    public function guestIndex(Request $request)
    {
        $user = Auth::user();
        if($user)
            return Redirect('/home');
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
        

        $wall = [
            'new_post_group_id' => 0
        ];

        $this->user = $user;
        $this->my_profile = true;
        
        $suggestedpeople = User::oldest()->take(12)->get();

        $my_profile = $this->my_profile;
        $settings = Setting::find(1);

        $can_see = true;
        return view('guest.index', compact('user', 'wall', 'my_profile','suggestedpeople', 'settings' , 'can_see','like_list'));
    }

    public function fetch(Request $request){
        $wall_type = $request->input('wall_type'); // 0 => all posts, 1 => profile posts, 2 => group posts
        $list_type = $request->input('list_type'); // 0 => all, 1 => only text, 2 => only image
        $optional_id = $request->input('optional_id'); // Group ID, User ID, or empty
        $limit = intval($request->input('limit'));
        if (empty($limit)) $limit = 20;
        $post_min_id = intval($request->input('post_min_id')); // If not empty, post_id < post_min_id
        $post_max_id = intval($request->input('post_max_id')); // If not empty, post_id > post_max_id
        $div_location = $request->input('div_location');

        $user = Auth::user();

        $posts = Post::with('user');

        if ($post_min_id > -1){
            $posts = $posts->where('id', '<', $post_min_id);
        }else if ($post_max_id > -1){
            $posts = $posts->where('id', '>', $post_max_id);
        }

        $posts = $posts->limit($limit)->orderBy('id', 'DESC')->get();




        if ($div_location == 'initialize'){
            $div_location = ['top', 'bottom'];
        }else{
            $div_location = [$div_location];
            if (count($posts) == 0) return "";
        }

        $comment_count = 2;

        return view('guest.wall_posts', compact('posts', 'user', 'wall_type', 'list_type', 'optional_id', 'limit', 'div_location', 'comment_count'));
    }
    public function single(Request $request, $id){

        $post = Post::find($id);
        if (!$post) return redirect('/404');
        $comment_count = 2000000;
        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }
        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);

        return view('widgets.guestpostpopupmodal', compact('post', 'user', 'comment_count', 'can_see'));
    }
    public function terms(Request $request){
        return view('terms');
    }
 
}