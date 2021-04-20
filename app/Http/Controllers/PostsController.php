<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\SocialComment;
use App\Models\PostImage;
use App\Models\PostVideo;
use App\Models\PostShare;
use App\Models\PostAttachment;
use App\Models\PostLink;
use App\Models\SocialPost;
use App\Models\SocialLike;
use App\Models\PostLike;
use App\Models\CommentLike;
use App\Models\PingMe;
use Auth;
use App\Models\User;
use App\Models\UserFollowing;
use Twitter;
use App\Models\Setting;
use Alaouy\Youtube\Facades\Youtube;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;
use Embed\Embed;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function fetch(Request $request){
        // print_r($request->all()); die;
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

        if ($wall_type == 1){
            // $posts = $posts->where('user_id', $optional_id)->where('group_id', 0);
            $postsData = DB::select('SELECT pm.post_id as id
            FROM ping_me pm 
            JOIN posts p ON pm.post_id = p.id
            WHERE p.pvt_ping = 1
            AND pm.pinged_id = '.$optional_id.'
            UNION
            SELECT id FROM posts WHERE user_id ='.$optional_id.'
            AND group_id = 0
            ');
            $id = [];
            foreach($postsData as $data){
                $id[] = [$data->id];
            }
            $posts = Post::orderBy('id','DESC')->whereIn('id',$id);
        }else if ($wall_type == 2){

            $city = $user->location->city;

            $posts = $posts->where('group_id', $optional_id)->whereExists(function ($query) use($city) {
                $query->select(DB::raw(1))
                    ->from('user_locations')
                    ->whereRaw('posts.user_id = user_locations.user_id and user_locations.city_id = '.$city->id);
            });
        }else{
            $posts = $posts->where(function($query) use ($user) {
                $query->whereIn('user_id', function ($q) use ($user) {
                    $q->select('following_user_id')->from('user_following')->where('follower_user_id', $user->id)->where('allow', 1);
                });
                $query->orWhere('user_id', $user->id);
            })->where('group_id', 0);

            $followings = UserFollowing::where('follower_user_id',$user->id)->select('following_user_id')->get();
            foreach($followings as $following){
                $followingId[] = [$following->following_user_id];
            }
            $pings = PingMe::where('public_post',1)->whereIn('pingedby_id',$followingId)->get();

            $ids = [];
            foreach($posts->get() as $post){
                $ids[] = [$post->id];
            }

            foreach($pings as $ping){
                $ids[] = [$ping->post_id];
            }

            $posts = Post::whereIn('id',$ids);
        }

        // die;
        
        if ($list_type == 1){
            $posts = $posts->where('has_image', 1);
        }else if ($list_type == 2) {
            $posts = $posts->where('has_image', 2);
        }

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
        
        return view('widgets.wall_posts', compact('posts', 'user', 'wall_type', 'list_type', 'optional_id', 'limit', 'div_location', 'comment_count'));
    }

    public function single(Request $request, $id){
        // echo $id; die;
        $post = Post::find($id);
        if (!$post) return redirect('/404');
        $user = Auth::user();
        $comment_count = 2000000;

        // make seen 1
        $post->post_seen = 1;
        $post->save();
        
        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }

        $commentlikes = CommentLike::with('user')->join('post_comments', 'post_comments.id', '=', 'comment_likes.comment_id')
                        ->join('users', 'users.id', '=', 'comment_likes.like_user_id')
                        ->where('post_comments.comment_user_id', $user->id)
                        ->where('comment_likes.like_user_id', '!=', $user->id)
                        ->where('post_comments.post_id', $id)
                        ->where('comment_likes.seen', 0)->get();

        if ($commentlikes || $commentlikes != '' || !empty($commentlikes)) {
            foreach ($commentlikes as $commentlike) {
                CommentLike::where('comment_id', $commentlike->comment_id)->update([ 'seen' => 1]);
            }
        }
        // update ping_me
        $pingPublicPost = PingMe::where('post_id',$id)->where('pinged_id',$user->id)->first();
        if($pingPublicPost){
            $pingPublicPost->ping_seen = 0;
            $pingPublicPost->save();
        }
        

        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);


        return view('post', compact('post', 'user', 'comment_count', 'can_see'));
    }

    public function singlePostComments($id){
        $response = array();
        $data = new PostComment;
        $datas = $data->commentUser($id);

        $data = json_decode($datas,true);
        $response['comments'] = $data;
        return Response::json($response);
    }

    public function delete(Request $request){

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));



        if ($post){
            if ($post->user_id == Auth::id() || Auth::user()->role == 'Admin') {
                if ($post->delete()) {
                    // delete from ping_posts
                    PingMe::where('post_id',$request->input('id'))->delete();
                    $response['code'] = 200;
                }
            }
        }

        return Response::json($response);
    }


    public function like(Request $request){
        // print_r($request->all()); die;
        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));
        if ($post){
            $post_like = PostLike::where('post_id', $post->id)->where('like_user_id', $user->id)->get()->first();

            if ($post_like) { // UnLike
                if ($post_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from post_likes where post_id='.$post_like->post_id.' and like_user_id='.$post_like->like_user_id);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $post_like = new PostLike();
                $post_like->post_id = $post->id;
                $post_like->like_user_id = $user->id;
                if ($post_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $post->getLikeCount();
            }
        }
        $id = $request->input('id');
        if($id){
            $post_like = SocialLike::where('post_id', $id)->where('like_user_id', $user->id)->get()->first();

            if ($post_like) { // UnLike
                if ($post_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from social_likes where post_id="'.$post_like->post_id.'" and like_user_id='.$post_like->like_user_id);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $post_like = new SocialLike();
                $post_like->post_id = $id;
                $post_like->like_user_id = $user->id;
                if ($post_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = SocialLike::where('post_id', $id)->count();
            }
        }

        return Response::json($response);
    }

    public function commentsociallike(Request $request) {
        $user = Auth::user();
        $response = array();
        $response['code'] = 400;

        $comment = SocialComment::find($request->input('id'));

        $comment->id . '--' . $user->id . '===' . $request->input('id');

        if ($comment) {
            $comment_like = CommentLike::where('comment_id', $comment->id)->where('like_user_id', $user->id)->get()->first();

            if ($comment_like) {
                if ($comment_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from comment_likes where comment_id=' . $comment_like->comment_id . ' and like_user_id=' . $comment_like->like_user_id);
                    if ($deleted) {
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            } else {
                // Like
                $comment_like = new CommentLike();
                $comment_like->comment_id = $comment->id;
                $comment_like->like_user_id = $user->id;
                if ($comment_like->save()) {
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200) {
                $response['like_count'] = $comment->getLikeCount();
            }
        }

        return Response::json($response);
    }

    public function commentlike(Request $request) {
        // echo $request->id; die;
        $user = Auth::user();
        $response = array();
        $response['code'] = 400;

        $comment = PostComment::find($request->id);
        // echo'id= '.$comment->id; die;
        if ($comment){
            $comment_like = CommentLike::where('comment_id', $comment->id)->where('like_user_id', $user->id)->get()->first();

            if ($comment_like) { // UnLike
                if ($comment_like->like_user_id == $user->id) {
                    $deleted = DB::delete('delete from comment_likes where comment_id='.$comment_like->comment_id.' and like_user_id='.$comment_like->like_user_id);
                    if ($deleted){
                        $response['code'] = 200;
                        $response['type'] = 'unlike';
                    }
                }
            }else{
                // Like
                $comment_like = new CommentLike();
                $comment_like->comment_id = $comment->id;
                $comment_like->like_user_id = $user->id;
                if ($comment_like->save()){
                    $response['code'] = 200;
                    $response['type'] = 'like';
                }
            }
            if ($response['code'] == 200){
                $response['like_count'] = $comment->getLikeCount();
            }
        }

        return Response::json($response);
    }


    public function commentSocial(Request $request){
        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));
        $text = $request->input('comment');


        if($request->name == 'instagram'){
            // 1
            if ($post && !empty($text)){
            
                $comment = new PostComment();
                $comment->post_id = $post->id;
                $comment->comment_user_id = $user->id;
                $comment->comment = $text;
                $comment->social = 1;
                if ($comment->save()){
                    $response['code'] = 200;
                        $comment_count = 2000000;
                        $can_see = true;
                        $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                        $response['comment'] = $html->render();
                }
            }
        }else if($request->name == 'facebook'){
            // 2
            if ($post && !empty($text)){
            
                $comment = new PostComment();
                $comment->post_id = $post->id;
                $comment->comment_user_id = $user->id;
                $comment->comment = $text;
                $comment->social = 2;
                if ($comment->save()){
                    $response['code'] = 200;
                        $comment_count = 2000000;
                        $can_see = true;
                        $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                        $response['comment'] = $html->render();
                }
            }
        }else if($request->name == 'twitter'){
            // 3
            if ($post && !empty($text)){
            
                $comment = new PostComment();
                $comment->post_id = $post->id;
                $comment->comment_user_id = $user->id;
                $comment->comment = $text;
                $comment->social = 3;
                if ($comment->save()){
                    $response['code'] = 200;
                        $comment_count = 2000000;
                        $can_see = true;
                        $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                        $response['comment'] = $html->render();
                }
            }
        }else if($request->name == 'youtube'){
            // 4
        }else{
            // 
        }        

        return Response::json($response);
    }
    
    public function comment(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));
        $text = $request->input('comment');



        if ($post && !empty($text)){
            
            $comment = new PostComment();
            $comment->post_id = $post->id;
            $comment->comment_user_id = $user->id;
            $comment->comment = $text;
            if ($comment->save()){
                $response['code'] = 200;
                    $comment_count = 2000000;
                    $can_see = true;
                    $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
                    $response['id'] = $comment->post_id;
            }
        }

        // echo $response['id']; die;
        
        return Response::json($response);
    }

    public function subsocailcomment(Request $request) {

        $user = Auth::user();
        $response = array();
        $response['code'] = 400;
        $post_comment = SocialComment::find($request->input('comment_id'));
        $parent_id = $post_comment->id;
        $p_id = $post_comment->post_id;

        $text = $request->input('comment');
        if ($post_comment && !empty($text)) {

            $comment = new SocialComment();
            $comment->post_id = $p_id;
            $comment->parent_id = $post_comment->id;
            $comment->comment_user_id = $user->id;
            $comment->comment = $text;

            if ($comment->save()) {
                $post_comment = SocialComment::find($request->input('comment_id'));
                $post_id = $post_comment->post_id;
                $subcomments = SocialComment::where('post_id', $post_id)->where('parent_id', $parent_id)->get();

                $comment = $post_comment;
                $user = Auth::user();

                $response['code'] = 200;
                $user = Auth::user();
                $comment_count = 2000000;
                $can_see = true;
                $html = View::make('celebrities.social_single_comment', compact('subcomments', 'post_id', 'comment', 'user', 'comment_count', 'can_see'));
                $response['comment'] = $html->render();
            }
        }

        return Response::json($response);
    }
    public function subcomment(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('post_id'));
        $post_comment = PostComment::find($request->input('comment_id'));
        $text = $request->input('comment');



        if ($post && $post_comment && !empty($text)){


            $comment = new PostComment();
            $comment->post_id = $post->id;
            $comment->parent_id = $post_comment->id;
            $comment->comment_user_id = $user->id;
            $comment->comment = $text;
            if ($comment->save()){
                $response['code'] = 200;
                    $comment_count = 2000000;
                    $can_see = true;
                    $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
            }
        }

        return Response::json($response);
    }

    public function deleteSocialComment(Request $request) {

        $response = array();
        $response['code'] = 400;
        $user = Auth::user();
        $post_comment = SocialComment::find($request->input('id'));


        if ($post_comment) {
            $post = $post_comment->post;
            if ($post_comment->comment_user_id == Auth::id() || $post_comment->post->user_id == Auth::id()) {
                if ($post_comment->delete()) {
                    $response['code'] = 200;
                    $response['id'] = $request->input('id');
                }
            }
        }

        return Response::json($response);
    }

    public function deleteComment(Request $request){

        $response = array();
        $response['code'] = 400;
        $user = Auth::user();
        $post_comment = PostComment::find($request->input('id'));


        if ($post_comment){
            $post = $post_comment->post;
            if ($post_comment->comment_user_id == Auth::id() || $post_comment->post->user_id == Auth::id()) {
                if ($post_comment->delete()) {
                    $response['code'] = 200;
                    $comment_count = 2000000;
                    $can_see = true;
                    $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
                }
            }
        }

        return Response::json($response);
    }

    public function partialPost(Request $request, $id){

        $post = Post::find($id);
        if (!$post) return redirect('/404');

        $user = Auth::user();
        $comment_count = 2000000;

        if ($post->group_id == 0) {
            $can_see = $post->user->canSeeProfile(Auth::id());
            if (!$can_see) return redirect('/404');
        }


        $update_all = $post->comments()->where('seen', 0)->update(['seen' => 1]);
        $update_all = $post->likes()->where('seen', 0)->update(['seen' => 1]);



        return view('widgets.postpopupmodal', compact('post', 'user', 'comment_count', 'can_see'));
    }

    public function editComment(Request $request){

        $response = array();
        $response['code'] = 400;
        $post_comment = PostComment::find($request->input('comment_id'));


        if ($post_comment){
            $post = $post_comment->post;
            if ($post_comment->comment_user_id == Auth::id() && $request->input('comment') !='') {
                 $update_all = $post->comments()->where('id', $request->input('comment_id'))->update(['comment' => $request->input('comment')]);
                if ($update_all) {
                    $response['code'] = 200;
                    $user = Auth::user();
                    $comment_count = 2000000;
                    $can_see = true;
                    $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
                }
            }
        }

        return Response::json($response);
    }

    public function editSocialComment(Request $request) {

        $response = array();
        $response['code'] = 400;
        $post_comment = SocialComment::find($request->input('comment_id'));

        if ($post_comment) {
            if ($post_comment->comment_user_id == Auth::id() && $request->input('comment') != '') {
                $update_all = SocialComment::where('id', $request->input('comment_id'))->update(['comment' => $request->input('comment')]);

                if ($update_all) {
                    try {
                        $post_comment = SocialComment::find($request->input('comment_id'));

                        $post_id = $post_comment->post_id;
                        $comment = $post_comment;
                        $user = Auth::user();

                        $response['code'] = 200;
                        $user = Auth::user();
                        $comment_count = 2000000;
                        $can_see = true;
                        $html = View::make('celebrities.social_single_comment', compact('post_id', 'comment', 'user', 'comment_count', 'can_see'));
                        $response['comment'] = $html->render();
                    } catch (\Exception $ex) {
                        echo $ex->getMessage();
                    }
                }
            }
        }

        return Response::json($response);
    }

    public function likes(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post = Post::find($request->input('id'));

        if ($post){
            $response['code'] = 200;
            $html = View::make('widgets.post_detail.likes', compact('post'));
            $response['likes'] = $html->render();
        }

        return Response::json($response);
    }

    public function commentlikes(Request $request){

        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $comment = PostComment::find($request->input('id'));

        if ($comment){
            $response['code'] = 200;
            $html = View::make('widgets.post_detail.commentlikes', compact('comment'));
            $response['likes'] = $html->render();
        }

        return Response::json($response);
    }



    public function share(Request $request){
        // print_r($request->all());die;

        $user = Auth::user();
        
        $data = $request->all();
        $input = json_decode($data['data']);
        $response = array();

        if($input->socialName == "facebook"){
            // facebook
            $post = new Post();
            $post->content = !empty($input->content)?$input->content:'';
            $post->group_id = 0;
            $post->user_id = Auth::user()->id;
            $post->has_shared = 1;
            $post->has_image = 1;
            $save = $post->save();
            if($save){
                // image post
                $imagePost = new PostImage();
                $imagePost->post_id = $post->id;
                $imagePost->image_path = $input->imgUrl;
                $imagePost->save();

                // share post
                $share = new PostShare();
                $share->post_id = $post->id;
                $share->shared_post_id = 'F'.$input->shared_post_id;
                $share->save();
                if(!$share || !$imagePost){
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    return Response::json($response);
                }
    
                    $response['code'] = 200;
                    $response['message'] = "Post shared successfully!";
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                return Response::json($response);
            }

        }else if($input->socialName == "instagram"){
            //  instagram
            $post = new Post();
            $post->content = !empty($input->content)?$input->content:'';
            $post->group_id = 0;
            $post->user_id = Auth::user()->id;
            $post->has_shared = 1;
            $post->has_image = 1;
            $save = $post->save();
            if($save){
                // image post
                $imagePost = new PostImage();
                $imagePost->post_id = $post->id;
                $imagePost->image_path = $input->imgUrl;
                $imagePost->save();

                // share post
                $share = new PostShare();
                $share->post_id = $post->id;
                $share->shared_post_id = 'I'.$input->shared_post_id;
                $share->save();
                if(!$share || !$imagePost){
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    return Response::json($response);
                }
    
                    $response['code'] = 200;
                    $response['message'] = "Post shared successfully!";
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                return Response::json($response);
            }
        }else if($input->socialName == "twitter"){
            // twitter
            $post = new Post();
            $post->content = !empty($input->content)?$input->content:'';
            $post->group_id = 0;
            $post->user_id = Auth::user()->id;
            $post->has_shared = 1;
            $post->has_image = 1;
            $save = $post->save();
            if($save){
                // image post
                $imagePost = new PostImage();
                $imagePost->post_id = $post->id;
                $imagePost->image_path = $input->imgUrl;
                $imagePost->save();

                // share post
                $share = new PostShare();
                $share->post_id = $post->id;
                $share->shared_post_id = 'T'.$input->shared_post_id;
                $share->save();
                if(!$share || !$imagePost){
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    return Response::json($response);
                }

                    $response['code'] = 200;
                    $response['message'] = "Post shared successfully!";
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                return Response::json($response);
            }            
        }else if($input->socialName == "youtube"){
            // you tube
            $post = new Post();
            $post->content = !empty($input->content)?$input->content:'';
            $post->group_id = 0;
            $post->user_id = Auth::user()->id;
            $post->has_shared = 1;
            $post->has_video = 1;
            $save = $post->save();
            if($save){
                // video post
                $videoPost = new PostVideo();
                $videoPost->post_id = $post->id;
                $videoPost->video_path = $input->imgUrl;
                $videoPost->save();

                // share post
                $share = new PostShare();
                $share->post_id = $post->id;
                $share->shared_post_id = 'Y'.$input->shared_post_id;
                $share->save();
                if(!$share || !$videoPost){
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    return Response::json($response);
                }

                    $response['code'] = 200;
                    $response['message'] = "Post shared successfully!";
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                return Response::json($response);
            }            
        }else{
            $post = new Post();
            $post->content = !empty($input->content)?$input->content:'';
            $post->group_id = 0;
            $post->user_id = Auth::user()->id;
            $post->has_shared = 1;
            $save = $post->save();
            if($save){
                $share = new PostShare();
                $share->post_id = $post->id;
                $share->shared_post_id = $input->shared_post_id;
                $share->save();
                if(!$share){
                    $response['code'] = 400;
                    $response['message'] = "Something went wrong!";
                    return Response::json($response);
                }
    
                    $response['code'] = 200;
                    $response['message'] = "Post shared successfully!";
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
                return Response::json($response);
            }
        }

        return Response::json($response);
    }


    public function create(Request $request){
        $data = $request->all();
        $input = json_decode($data['data'], true);
        unset($data['data']);
        foreach ($input as $key => $value) $data[$key] = $value;
        $response = array();
        $response['code'] = 400;


        if ($request->hasFile('image')){
            $validator_data['image'] = 'required|mimes:jpeg,jpg,png,gif|max:2048';
        }elseif ($request->hasFile('video')){
            $validator_data['video'] = 'required';
        }elseif ($request->hasFile('attachment')){
            $validator_data['attachment'] = 'required';
        }elseif (!empty($data['link'])){
            $validator_data['link'] = 'required';
        }else{
            $validator_data['content'] = 'required';
        }

        $validator = Validator::make($data, $validator_data);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{

            $post = new Post();
            $post->content = !empty($data['content'])?$data['content']:'';
            $post->group_id = $data['group_id'];
            $post->user_id = Auth::user()->id;

            $file_name = '';

            if ($request->hasFile('image')) {
                $post->has_image = 1;
                $file = $request->file('image');

                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                // $path = 'assets/img/patners/';
                // $file->move($path,$name);
                // $destination = $path.$name;
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
                // die;
            }elseif ($request->hasFile('video')) {
                $post->has_video = 1;
                $file = $request->file('video');

                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }elseif ($request->hasFile('attachment')) {
                $post->has_attachment = 1;
                $file = $request->file('attachment');
                $file_original_name = $file->getClientOriginalName();
                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }elseif (!empty($data['link']) && $data['link']!='') {
                $link = $data['link'];
                $post->has_link = 1;
                $process = true;
            }else{
                $process = true;
            }

            if ($process){
                if ($post->save()) {
                    if ($post->has_image == 1) {
                        $post_image = new PostImage();
                        $post_image->image_path = $file_name;
                        $post_image->post_id = $post->id;
                        if ($post_image->save()){
                            $response['code'] = 200;
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($post->has_video == 1) {
                        $post_video = new PostVideo();
                        $post_video->video_path = $file_name;
                        $post_video->post_id = $post->id;
                        if ($post_video->save()){
                            $response['code'] = 200;
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($post->has_attachment == 1) {
                        $post_attachment = new PostAttachment();
                        $post_attachment->attachment_path = $file_name;
                        $post_attachment->attachment_name = $file_original_name;
                        $post_attachment->post_id = $post->id;
                        if ($post_attachment->save()){
                            $response['code'] = 200;
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($post->has_link == 1) {
                        $post_link = new PostLink();
                        $post_link->link_url = $link;
                        $info = Embed::create($link);
                        $post_link->link_code = $info->code;
                        $post_link->post_id = $post->id;
                        if ($post_link->save()){
                            $response['code'] = 200;
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }else{
                        $response['code'] = 200;
                    }
                }
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }


        }
        
        return Response::json([
            'code' => $response['code'],
            'msg' => $response['message']
        ]);

    }
    public function edit(Request $request){
        $data = $request->all();
        $input = json_decode($data['data'], true);
        unset($data['data']);
        foreach ($input as $key => $value) $data[$key] = $value;
        $response = array();
        $response['code'] = 400;

        $user = Auth::user();
        $validator_data['post_id'] = 'required';
        if ($request->hasFile('image')){
            $validator_data['image'] = 'required|mimes:jpeg,jpg,png,gif|max:2048';
        }elseif ($request->hasFile('video')){
            $validator_data['video'] = 'required';
        }elseif ($request->hasFile('attachment')){
            $validator_data['attachment'] = 'required';
        }elseif (!empty($data['link'])){
            $validator_data['link'] = 'required';
        }else{
            $validator_data['content'] = 'required';
        }
        $validator = Validator::make($data, $validator_data);

        if ($validator->fails()) {
            $response['code'] = 400;
            $response['message'] = implode(' ', $validator->errors()->all());
        }else{

            $post = Post::findOrFail($data['post_id']);

            $old_type = '';
            $new_type = '';

            if($post->has_image){
                $old_type = 'image';
            }
            if($post->has_video){
                $old_type = 'video';
            }
            if($post->has_attachment){
                $old_type = 'attachment';
            }
            if($post->has_link){
                $old_type = 'link';
            }

            $post->content = !empty($data['content'])?$data['content']:'';
            $post->group_id = $data['group_id'];
            $post->user_id = Auth::user()->id;

            $file_name = '';

            if ($request->hasFile('image')) {
                $post->has_image = 1;
                $new_type = 'image';
                $file = $request->file('image');

                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }elseif ($request->hasFile('video')) {
                $post->has_video = 1;
                $new_type = 'video';
                $file = $request->file('video');

                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }elseif ($request->hasFile('attachment')) {
                $post->has_attachment = 1;
                $new_type = 'attachment';
                $file = $request->file('attachment');
                $file_original_name = $file->getClientOriginalName();
                $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
                if ($file->move('storage/uploads/posts', $file_name)) {
                    $process = true;
                } else {
                    $process = false;
                }
            }elseif (!empty($data['link']) && $data['link']!='') {
                $link = $data['link'];
                $post->has_link = 1;
                $new_type = 'link';
                $process = true;
            }else{
                $process = true;
            }

            if ($process){
                if ($post->save()) {
                    if(($new_type != '' && $old_type != '') || $data['delete_old'] == 'true'){
                        if($old_type == 'image'){
                            $post->images[0]->delete();
                            $post->has_image = 0;
                        }
                        if($old_type == 'video'){
                            $post->videos[0]->delete();
                            $post->has_video = 0;
                        }
                        if($old_type == 'attachment'){
                            $post->attachments[0]->delete();
                            $post->has_attachment = 0;
                        }
                        if($old_type == 'link'){
                            $post->links[0]->delete();
                            $post->has_link = 0;
                        }
                        $post->save();
                    }
                    if ($new_type == 'image') {

                        $post_image = new PostImage();
                        $post_image->image_path = $file_name;
                        $post_image->post_id = $post->id;
                        if ($post_image->save()){
                            $response['code'] = 200;
                            $post->has_video = 0;
                            $post->has_attachment = 0;
                            $post->has_link = 0;
                            $post->save();
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($new_type == 'video') {

                        $post_video = new PostVideo();
                        $post_video->video_path = $file_name;
                        $post_video->post_id = $post->id;
                        if ($post_video->save()){
                            $response['code'] = 200;
                            $post->has_image = 0;
                            $post->has_attachment = 0;
                            $post->has_link = 0;
                            $post->save();
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($new_type == 'attachment') {

                        $post_attachment = new PostAttachment();
                        $post_attachment->attachment_path = $file_name;
                        $post_attachment->attachment_name = $file_original_name;
                        $post_attachment->post_id = $post->id;
                        if ($post_attachment->save()){
                            $response['code'] = 200;
                            $post->has_image = 0;
                            $post->has_video = 0;
                            $post->has_link = 0;
                            $post->save();
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }elseif ($new_type == 'link') {

                        $post_link = new PostLink();
                        $post_link->link_url = $link;
                        $info = Embed::create($link);
                        $post_link->link_code = $info->code;
                        $post_link->post_id = $post->id;
                        if ($post_link->save()){
                            $response['code'] = 200;
                            $post->has_image = 0;
                            $post->has_video = 0;
                            $post->has_attachment = 0;
                            $post->save();
                        }else{
                            $response['code'] = 400;
                            $response['message'] = "Something went wrong!";
                            $post->delete();
                        }
                    }else{
                        $response['code'] = 200;
                    }
                    $response['message'] = "Post Updated Successfully!";
                    $html = View::make('widgets.post_detail.single_post', compact('post', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
                }
            }else{
                $response['code'] = 400;
                $response['message'] = "Something went wrong!";
            }


        }

        return Response::json($response);

    }
    public function hidePost(Request $request){
        // print_r($request->all());die;
        $response = array();
        $response['code'] = 200;

        $pId = $request->input('pId');
        $userId = Auth::id();
        if(Auth::User()->hidepost == '' || Auth::User()->hidepost == null){
            Auth::User()->hidepost = $pId;
            Auth::User()->save();
        }else{
            Auth::User()->hidepost = Auth::User()->hidepost .','. $pId;
            Auth::User()->save();
        }
        return Response::json($response);
    }

    public function pingMePost(Request $req){
        $content = $req->content;
        $pingedby = $req->pingedby;
        $pinged = $req->pinged;

        $validator = Validator::make($req->all(),[
            'content' => 'required'
        ]);
        if($validator->fails()){
            
            return response([
                'response' => 400,
                'msg' => 'Enter something'
            ]);
        }else{
            // add to post
            $add = new Post();
            $add->content = $content;
            $add->ping_post = 1;
            $add->group_id = 0;
            $add->user_id = $pingedby;
            $add->save();
            if($add){
                // add to ping
                $ping = new PingMe();
                $ping->pingedby_id = $pingedby;
                $ping->pinged_id = $pinged;
                $ping->post_id = $add->id;
                $ping->save();

                return response([
                    'response' => 200
                ]);
            }
        }
    }

    public function pingMeImagePost(Request $req){
        $content = $req->content;
        $pingedby = $req->pingedby;
        $pinged = $req->pinged;
        $validator = Validator::make($req->all(),[
            'photo' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            
        ]);
        if($validator->fails()){
            
            return response([
                'response' => 400,
                'msg' => 'Upload an image'
            ]);
        }else{
            // upload image
            $file = $req->photo;
            $file_name = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move('storage/uploads/posts', $file_name);
            // add to post
            $add = new Post();
            $add->content = $content;
            $add->ping_post = 1;
            $add->has_image = 1;
            $add->group_id = 0;
            $add->user_id = $pingedby;
            $add->save();
            if($add){
                // add to ping
                $ping = new PingMe();
                $ping->pingedby_id = $pingedby;
                $ping->pinged_id = $pinged;
                $ping->post_id = $add->id;
                $ping->save();

                // add image post
                $image = new PostImage;
                $image->post_id = $add->id;
                $image->image_path = $file_name;
                $image->save();

                return response([
                    'response' => 200
                ]);
            }
        }
    }

    /**
     * private ping post
     */
    public function pvtPingPost(Request $req){
        // print_r($req->all()); die;
        $pinged = $req->pinged;
        $pingedby = $req->pingedby;
        $post_id = $req->post;

        if(empty($post_id)){
            return response([
                'error' => 1
            ]);
        }
        
        if($req->status == 'ping'){
            $post = Post::find($post_id);
            $post->pvt_ping = 1;
            if($post->save()){
                $pingMe = new PingMe;
                $pingMe->pingedby_id = $pingedby;
                $pingMe->pinged_id = $pinged;
                $pingMe->post_id = $post_id;
                $pingMe->ping_seen = 1;
                if($pingMe->save()){
                    return response([
                        'error' => 0
                    ]);
                }
            }else{
                return response([
                    'error' => 1
                ]);
            }
        }else{
            $ping = PingMe::where('pinged_id',$pinged)->where('pingedby_id',$pingedby)->where('post_id',$post_id)->first();
            if($ping){
                $post = Post::find($ping->post_id);
                if($post->ping_post == 1 || $post->pvt_ping == 1){
                    $post->pvt_ping = 0;
                    if($post->save()){
                        if(PingMe::where('pinged_id',$pinged)->where('pingedby_id',$pingedby)->where('post_id',$post_id)->where('public_post',0)->delete()){
                            return response([
                                'error' => 0
                            ]);
                        }
                    }
                }else{
                    $delete = PingMe::find($ping->id)->delete();
                    if($delete){
                        return response([
                            'error' => 0
                        ]);
                    }
                }
            }else{
                return response([
                    'error' => 1
                ]);
            }
        }
    }

    // ping public user post
    public function pingPublicUserPost(Request $req){
        // print_r($req->all()); die;
        $post = Post::find($req->post_id);
        $pinged_id = $post->user_id;

        // add to pingMe
        if($req->status == 'ping'){
            $ping = new PingMe;
            $ping->pingedby_id = $req->user_id;
            $ping->pinged_id = $pinged_id;
            $ping->post_id = $req->post_id;
            $ping->public_post = 1;
            if($ping->save()){
                return response([
                    'error' => 0
                ]);
            }
        }else{
           $ping = PingMe::where('pingedby_id',$req->user_id)->where('pinged_id',$pinged_id)->where('post_id',$req->post_id)->where('public_post',1);
           if($ping->delete()){
               return response([
                   'error' => 0
               ]);
           }
        }
    }
}