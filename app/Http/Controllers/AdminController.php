<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use App\Models\PostVideo;
use App\Models\PostAttachment;
use App\Models\PostLink;
use App\Models\PostShare;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function settingPost(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        \App\Models\User::where("id",Auth::user()->id)->update(['email'=>$request->email,'name'=>$request->name,'password'=>bcrypt($request->password)]);
        return redirect("/admin/settings");
    }

    public function settingShowForm()
    {
        return view('admin.setting');
    }

    public function loginFormShow()
    {
        return view('auth.admin.login');
    }

    public function loginPost(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        $rememberMe = $request->remember == "on" ? true : false;
        if (!Auth::attempt(array('email' => $request->email, 'password' => $request->password, 'role' => \App\Models\UserTypes::USER_TYPE_ADMIN), $rememberMe)) {
            return redirect('/admin/login')->with('error', 'Invalid Administrator username and password!');;
        }
        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $totalComments = PostComment::select('id')->get()->count();   
        $totalPosts = Post::select('id')->where('is_delete',0)->get()->count();
        $totalUsers = \App\Models\User::select('id')->where('is_delete',0)->get()->count();
        $onlineUsers = \App\Models\User::select('id')->where('loginCount',1)->get()->count();
        return view('admin.dashboard',[
            'totalComments' => $totalComments,
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'onlineUsers' => $onlineUsers,
        ]);
    }


    // show posts page
    public function postsTable(){
        return view('posts.posts');
    }

    // posts data
    public function postsData(){
     
        $postsDatas = DB::select('SELECT p.id,pl.likes,pc.comments,CONCAT(p.has_image,p.has_video,p.has_attachment,p.has_link,has_shared) AS post_type 
        ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
        FROM posts p
        LEFT JOIN (SELECT post_id,COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
        LEFT JOIN (SELECT post_id, COUNT(post_id) AS comments FROM post_comments GROUP BY post_id) pc ON p.id = pc.post_id
        WHERE p.is_delete = 0');

        $datas = [];
        foreach($postsDatas as $postData){
            if($postData->post_type == '10000'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Image Post',
                    'date' => $postData->date,
                ];
            }else if($postData->post_type == '01000'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Video Post',
                    'date' => $postData->date,
                ];
            }else if($postData->post_type == '00100'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Attachment Post',
                    'date' => $postData->date,
                ];
            }else if($postData->post_type == '00010'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Link Post',
                    'date' => $postData->date,
                ];
            }else if($postData->post_type == '00001'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Shared Post',
                    'date' => $postData->date,
                ];
            }else if($postData->post_type == '00000'){
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Content Post',
                    'date' => $postData->date,
                ];
            }else{
                $datas[] = [
                    'id' => $postData->id,
                    'likes' => $postData->likes,
                    'comments' => $postData->comments,
                    'post_type' => 'Social Media Shared Post',
                    'date' => $postData->date,
                ];
            }
        }


        
        // print_r($datas);die;
        
        return Datatables::of($datas)
        ->addColumn('action',function($datas){
            return '<button class="btn btn-xs btn-success PostsViewBtn" title="view post" postId="'.$datas['id'].'"><i class="fas fa-binoculars"></i></button>'.
            '<button class="btn btn-xs btn-danger PostDeleteBtn" title="delete post" postId="'.$datas['id'].'"><i class="fas fa-trash-alt"></i></button>';
        })
        ->make(true);
    }

    // post like data
    public function postLikesData(Request $req){
        // print_r($req->all());die;
        $data = DB::select('SELECT u.name
        FROM post_likes pl
        JOIN users u ON u.id = pl.like_user_id
        WHERE pl.post_id ='.$req->id);
        if($data){
            return response([
                'data' => $data,
            ]);
        }
        
    }
    
    // posts Individual data
    public function postIndividualData(Request $req){
        // print_r($req->all());die;
        $id = $req->id;

        // check its on post whether its image,video,link or attachemnt
        $image = Post::where('id',$id)->where('has_image',1)->where('has_shared',0)->get();
        $video = Post::where('id',$id)->where('has_video',1)->where('has_shared',0)->get();
        $attachment = Post::where('id',$id)->where('has_attachment',1)->where('has_shared',0)->get();
        $link = Post::where('id',$id)->where('has_link',1)->where('has_shared',0)->get();
        $shared = Post::where('id',$id)->where('has_shared',1)->get();

        if(count($image) > 0){
            // image post
            $id = $req->id;
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$id)->where('posts.has_image',1)->get();

            $user_name = $user_data[0]['name'];

            // get posts data
            $data = DB::select('SELECT p.id,p.content,pc.id AS comment_id,p.id,pim.image_path,pc.comment,pl.likes,us.name,p.has_image
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
            FROM posts p
            RIGHT OUTER JOIN post_images pim ON p.id = pim.post_id
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            WHERE p.id ='.$id);
            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }else if(count($video) > 0){
            // video post
            $id = $req->id;
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$id)->where('posts.has_video',1)->get();
    
            $user_name = $user_data[0]['name'];
    
            // get posts data
            $data = DB::select('SELECT p.id,p.content,p.id,pv.video_path,pc.comment,pc.id AS comment_id,pl.likes,us.name,p.has_video
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
            FROM posts p
            RIGHT OUTER JOIN post_videos pv ON p.id = pv.post_id
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            WHERE p.id ='.$id);
            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }else if(count($attachment) > 0){
            // attachment posts
            $id = $req->id;
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$id)->where('posts.has_attachment',1)->get();
    
            $user_name = $user_data[0]['name'];
    
            // get posts data
            $data = DB::select('SELECT p.id,p.content,p.id,pa.attachment_path,pa.attachment_name,pc.comment,pc.id AS comment_id,pl.likes,us.name,p.has_attachment
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
            FROM posts p
            RIGHT OUTER JOIN post_attachments pa ON p.id = pa.post_id
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            WHERE p.id ='.$id);
            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }else if(count($link) > 0){
            // link posts
            $id = $req->id;
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$id)->where('posts.has_link',1)->get();
    
            $user_name = $user_data[0]['name'];
    
            // get posts data
            $data = DB::select('SELECT p.id,p.content,pli.link_url,pc.comment,pc.id AS comment_id,pl.likes,us.name,p.has_link
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
            FROM posts p
            JOIN post_links pli ON p.id = pli.post_id
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            WHERE p.has_link = 1
            AND p.id ='.$id);
            
            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }else if(count($shared) > 0){
            // shared post
            
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$req->id)->where('posts.has_shared',1)->get();
    
            $user_name = $user_data[0]['name'];

            // get shared post id
            $sharedPosts = DB::select('SELECT shared_post_id AS id FROM post_shares WHERE post_id ='.$req->id);
            foreach($sharedPosts as $sharedPost){
                $id = $sharedPost->id;
            }

            $data = [];
            
            if(starts_with($id,'F')){
                echo "facebook";
            }else if(starts_with($id,'I')){
                $postId = PostShare::where('shared_post_id',$id)->select('post_id')->get();
                foreach($postId as $postID){
                    echo $postID->post_id;
                }
            }else if(starts_with($id,'T')){
                echo "twitter";
            }else if(starts_with($id,'Y')){
                echo "youtube";
            }else{
                $postsDatas = DB::select('SELECT CONCAT(has_image,has_video,has_attachment,has_link,has_shared)
                AS post_type, DATE_FORMAT(created_at,"%d-%b-%Y %r") AS date
                FROM posts WHERE id ='.$id);                
            }
            // get posts data
            $dataWithComments = DB::select('SELECT p.id,p.content,pc.comment,pc.id AS comment_id,pl.likes,us.name
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS DATE
            FROM posts p
            JOIN post_shares ps ON p.id = ps.post_id
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            WHERE p.is_delete = 0
            AND p.id ='.$req->id);

            // print_r($postsDatas);die;
            
            foreach($postsDatas as $postsData){
                
                foreach($dataWithComments as $dataWithComment){
                    if($postsData->post_type == '10000'){
                        $data[] = [
                            'id' => $dataWithComment->id,
                            'content' => $dataWithComment->content,
                            'shared_post' => 'shared an image posted on '.$postsData->date,
                            'comment' => $dataWithComment->comment,
                            'comment_id' => $dataWithComment->comment_id,
                            'likes' => $dataWithComment->likes,
                            'name'  => $dataWithComment->name,
                            'has_shared' => 1,
                            'date' => $dataWithComment->date,
                        ];
                    }else if($postsData->post_type == '01000'){
                        $data[] = [
                            'id' => $dataWithComment->id,
                            'content' => $dataWithComment->content,
                            'shared_post' => 'Shared a video posted on '.$postsData->date,
                            'comment' => $dataWithComment->comment,
                            'comment_id' => $dataWithComment->comment_id,
                            'likes' => $dataWithComment->likes,
                            'name'  => $dataWithComment->name,
                            'has_shared' => 1,
                            'date' => $dataWithComment->date,
                        ];
                    }else if($postsData->post_type == '00100'){
                        $data[] = [
                            'id' => $dataWithComment->id,
                            'content' => $dataWithComment->content,
                            'shared_post' => 'Shared an attachment posted on '.$postsData->date,
                            'comment' => $dataWithComment->comment,
                            'comment_id' => $dataWithComment->comment_id,
                            'likes' => $dataWithComment->likes,
                            'name'  => $dataWithComment->name,
                            'has_shared' => 1,
                            'date' => $dataWithComment->date,
                        ];
                    }else if($postsData->post_type == '00010'){
                        $data[] = [
                            'id' => $dataWithComment->id,
                            'content' => $dataWithComment->content,
                            'shared_post' => 'Shared a link posted on '.$postsData->date,
                            'comment' => $dataWithComment->comment,
                            'comment_id' => $dataWithComment->comment_id,
                            'likes' => $dataWithComment->likes,
                            'name'  => $dataWithComment->name,
                            'has_shared' => 1,
                            'date' => $dataWithComment->date,
                        ];
                    }else if($postsData->post_type == '00000'){
                        $data[] = [
                            'id' => $dataWithComment->id,
                            'content' => $dataWithComment->content,
                            'shared_post' => 'Shared a content posted on '.$postsData->date,
                            'comment' => $dataWithComment->comment,
                            'comment_id' => $dataWithComment->comment_id,
                            'likes' => $dataWithComment->likes,
                            'name'  => $dataWithComment->name,
                            'has_shared' => 1,
                            'date' => $dataWithComment->date,
                        ];
                    }
                }
            }
            
            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }else{
            // other posts
            $id = $req->id;
            // get posted by
            $user_data = Post::join('users','users.id','=','posts.user_id')
            ->select('users.name')->where('posts.id',$id)->get();
    
            if(count($user_data)> 0){
                $user_name = $user_data[0]['name'];
            }else{
                $user_name = "";
            }
    
            // get posts data
            $data = DB::select('SELECT p.id,p.id,p.content,pc.comment,pc.id AS comment_id,pl.likes,us.name
            ,DATE_FORMAT(p.created_at,"%d-%b-%Y %r") AS date
            FROM posts p
            LEFT JOIN (SELECT post_id , COUNT(post_id) AS likes FROM post_likes GROUP BY post_id) pl ON p.id = pl.post_id
            LEFT JOIN post_comments pc ON p.id = pc.post_id
            LEFT JOIN users us ON pc.comment_user_id = us.id
            where p.id ='.$id);

            return response([
                'data' => $data,
                'user_name' => $user_name,
            ]);
        }
    }
    // post content update
    public function postContentUpdate(Request $req){
        // print_r($req->all());die;
        // update posts
        $update = Post::where('id',$req->id)->update([
            'content' => $req->content,
        ]);
        if($update){
            $success = 0;
            return response([
                'success' => $success,
                'content' => $req->content,
            ]);
        }
    }
    // post comments update
    public function postCommentUpdate(Request $req){
        // print_r($req->all());die;
        $update = PostComment::where('id',$req->id)->update([
            'comment' => $req->comment,
        ]);
        if($update){
            $success = 0;

            return response([
                'success' => $success,
            ]);
        }
    }
    // post image update using form
    public function postImageUpdate(Request $req){
        // print_r($req->all());die;
        $id = $req->id;
        $image = $req->image;
        $error = 0;
        $msg = "";
        $validator = Validator::make($req->all(),[
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ], [
            'image.required' => 'Image post should contain an image',
            'image.image' => 'Image post should contain an image',
            'image.mimes' => 'Image post should contain an image',
            ]);

        if ($validator->fails()) {
            $error = 1;
            $messages = $validator->messages();
            foreach ($messages->all() as $m) {
                $msg .= $m;
            }
            return response([
                'msg' => $msg,
                'error' => $error,
            ]);
        }else{
            $imageName = $image->getClientOriginalName();
            $detination = 'storage/uploads/posts';

            // update post image
            $update = PostImage::where('post_id',$id)->update([
                'image_path' => $imageName,
            ]);
            if($update){
                $image->move($detination,$imageName);
                $error = 0;
            }

            return response([
                'error' => $error,
                'id' => $req->id,
                'image' => $imageName
            ]);
        }
    }

    // video update
    public function postVideoUpdate(Request $req){
        // print_r($req->all());die;
        $id = $req->id;
        $video = $req->video;
        $error = 0;
        $msg = "";
        $validator = Validator::make($req->all(),[
            'video' => 'required|mimes:mp4,mov,ogg | max:20000',
                ], [
            'video.required' => 'Video post must contain a video',
            'video.image' => 'Video post must contain a video',
            'video.mimes' => 'Video post must contain a video',
            'video.max' => 'Video leangth is too large',
            ]);

        if ($validator->fails()) {
            $error = 1;
            $messages = $validator->messages();
            foreach ($messages->all() as $m) {
                $msg .= $m;
            }
            return response([
                'msg' => $msg,
                'error' => $error,
            ]);
        }else{
            $VideoName = $video->getClientOriginalName();
            $detination = 'storage/uploads/posts';

            // update post image
            $update = PostVideo::where('post_id',$id)->update([
                'video_path' => $VideoName,
            ]);
            if($update){
                $video->move($detination,$VideoName);
                $error = 0;
            }

            return response([
                'error' => $error,
                'id' => $req->id,
                'video' => $VideoName
            ]);
        }
    }
    // video update
    public function postAttachmentUpdate(Request $req){
        // print_r($req->all());die;
        $id = $req->id;
        $attachment = $req->attachment;
        $error = 0;
        $msg = "";
        $validator = Validator::make($req->all(),[
            'attachment' => 'required|mimes:txt,xlsx,xls,csv,bmp,doc,docx,pdf,tif,tiff|max:1000',
                ], [
            'attachment.required' => 'Attachment must be a document',
            'attachment.image' => 'Attachment must be a document',
            'attachment.mimes' => 'Attachment must be a document',
            'attachment.max' => 'Attachment must be a document',
            ]);

        if ($validator->fails()) {
            $error = 1;
            $messages = $validator->messages();
            foreach ($messages->all() as $m) {
                $msg .= $m;
            }
            return response([
                'msg' => $msg,
                'error' => $error,
            ]);
        }else{
            $attachmentName = $attachment->getClientOriginalName();
            $detination = 'storage/uploads/posts';

            // update post image
            $update = PostAttachment::where('post_id',$id)->update([
                'attachment_path' => $attachmentName,
            ]);
            if($update){
                $attachment->move($detination,$attachmentName);
                $error = 0;
                $postAttachment = PostAttachment::where('post_id',$id)->select('attachment_name')->get();
                $name = $postAttachment[0]['attachment_name'];
            }

            return response([
                'error' => $error,
                'id' => $req->id,
                'name' => $name,
                'attachment' => $attachmentName
            ]);
        }
    }
    // video update
    public function linkUpdate(Request $req){
        // print_r($req->all());die;
        $linkCode = '<iframe width="480" height="270" src="'+$req->link+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        
        $update = PostLink::where('post_id',$req->id)->update([
            'link_url' => $req->link,
            'link_code' => $linkCode
        ]);
        if($update){
            $error = 0;

            return response([
                'error' => $error,
                'link' => $req->link,
                'id' => $req->id
            ]);
        }
    }

    public function postDelete(Request $req){
        // print_r($req->all());die;
        $delete = Post::where('id',$req->id)->update([
            'is_delete' => 1,
        ]);
        if($delete){
            return response([
                'delete' => 0,
            ]);
        }
    }

    // get comments data for chart
    public function getCommnetsChart(Request $req){
        // print_r($req->all());die;
        if($req->value == "week"){
            // week 
            $weekDatas = DB::select('SELECT COUNT(id) AS comment, DAYNAME(created_at) AS day
            FROM post_comments 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)
            GROUP BY (day)
            ORDER BY(id) ASC');

            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            
            $data = [];
            if(count($weekDatas) > 0){
                foreach($days as $day){
                    $match = 0;
                    foreach($weekDatas as $week){
                        
                        if($day == $week->day){
                            $match++;
                            $data[] = ['comment'=>$week->comment, 'day'=>$week->day];
                        }
                    }
    
                    if($match == 0){
                        $data[] = ['comment' => 0, 'day' => $day];
                    }
                }
            }else{
                foreach($days as $day){
                    $data[] = ['comment' => 0, 'day' => $day];
                }
            }
            $total = DB::select('SELECT COUNT(id) AS total
            FROM post_comments 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "this month"){
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS comment, DATE_FORMAT(created_at,'%e') AS day
            FROM post_comments 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }

            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['comment' => $thisMonth->comment,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['comment'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['comment'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM post_comments 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "month"){
            $monthDatas = DB::select('SELECT COUNT(id) AS comment, DATE_FORMAT(created_at,"%b") AS day, YEAR(created_at) AS YEAR 
            FROM post_comments 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            GROUP BY (DAY)
            ORDER BY(id) ASC');

            $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug',
            'Sep','Oct','Nov','Dec'];
            
            $data = [];

            if(count($monthDatas) > 0){
                foreach($months as $month){
                    $match = 0;
    
                    foreach($monthDatas as $monthData){
                        if($month == $monthData->day){
                            $match++;
                            $data[] = ['comment'=>$monthData->comment,'day'=>$monthData->day];
                        }
                    }
    
                    if($match == 0){
                        $data[] = ['comment'=>0,'day'=>$month];
                    }
                }
            }else{
                foreach($months as $month){
                    $data[] = ['comment'=>0,'day'=>$month];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total
            FROM post_comments 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)');
            
            // print_r($data);die;
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "year"){
            $yearDatas = DB::select('SELECT COUNT(id) AS comment, YEAR(created_at) AS day
            FROM post_comments 
            GROUP BY(day)
            ORDER BY(id) ASC');

            // echo count($yearDatas);die;
            
            $year_2 = date('Y',strtotime('-2 years'));
            $year_1 = date('Y',strtotime('-1 years'));
            $thisYear = date('Y');
            $year1 = date('Y',strtotime('+1 years'));
            $year2 = date('Y',strtotime('+2 years'));
            $year3 = date('Y',strtotime('+3 years'));
            $years = [$year_2,$year_1,$thisYear,$year1,$year2,$year3];
            
            $data = [];

            if(count($yearDatas) > 1){
                $total = DB::select('SELECT COUNT(id) AS total
                FROM post_comments');

                return response([
                    'data' => $yearDatas,
                    'total' => $total,
                ]);
            }else if(count($yearDatas) == 1){
                foreach($years as $year){
                    $match = 0;
                    
                    foreach($yearDatas as $yearsData){
                        if($year == $yearsData->day){
                            $match++;
                            $data[] = ['comment'=>$yearsData->comment,'day'=>$yearsData->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['comment'=>0,'day'=>$year];
                    }
                }
            }else{
                foreach($years as $year){
                    $data[] = ['comment'=>0,'day'=>$year];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total
            FROM post_comments');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else{
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS comment, DATE_FORMAT(created_at,'%e') AS day
            FROM post_comments 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }

            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['comment' => $thisMonth->comment,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['comment'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['comment'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM post_comments 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }
    }

    // get posts data for chart
    public function getPostsChart(Request $req){
        // print_r($req->all());die;
        if($req->value == "week"){
            // week
            $weekDatas = DB::select('SELECT COUNT(id) AS post, DAYNAME(created_at) AS day
            FROM posts 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        
            $data = [];

            if(count($weekDatas) > 0){
                foreach($days as $day){
                    $match = 0;
                    foreach($weekDatas as $week){
                        
                        if($day == $week->day){
                            $match++;
                            $data[] = ['post'=>$week->post, 'day'=>$week->day];
                        }
                    }
    
                    if($match == 0){
                        $data[] = ['post' => 0, 'day' => $day];
                    }
                }
            }else{
                foreach($days as $day){
                    $data[] = ['post' => 0, 'day' => $day];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total, DAYNAME(created_at) AS MONTH, YEAR(created_at) AS YEAR 
            FROM posts 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)
            AND is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "this month"){
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS post, DATE_FORMAT(created_at,'%e') AS day
            FROM posts 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }

            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['post' => $thisMonth->post,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['post'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['post'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM posts 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "month"){
            // month
            $monthDatas = DB::select('SELECT COUNT(id) AS post, DATE_FORMAT(created_at,"%b") AS day
            FROM posts 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

    

            $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug',
            'Sep','Oct','Nov','Dec'];

            $data = [];

            if(count($monthDatas) > 0){
                foreach($months as $month){
                    $match = 0;
                    foreach($monthDatas as $monthData){
                        if($month == $monthData->day){
                            $match++;
                            $data[] = ['post'=>$monthData->post,'day'=>$monthData->day];
                        }
                    }
    
                    if($match == 0){
                        $data[] = ['post'=>0,'day'=>$month];
                    }
                }
            }else{
                foreach($months as $month){
                    $data[] = ['post'=>0,'day'=>$month];
                }
            }
            
            $total = DB::select('SELECT COUNT(id) AS total, MONTHNAME(created_at) AS MONTH, YEAR(created_at) AS YEAR 
            FROM posts 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "year"){
            $yearDatas = DB::select('SELECT COUNT(id) AS post, YEAR(created_at) AS day 
            FROM posts 
            WHERE is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

            $year_2 = date('Y',strtotime('-2 years'));
            $year_1 = date('Y',strtotime('-1 years'));
            $thisYear = date('Y');
            $year1 = date('Y',strtotime('+1 years'));
            $year2 = date('Y',strtotime('+2 years'));
            $year3 = date('Y',strtotime('+3 years'));
            $years = [$year_2,$year_1,$thisYear,$year1,$year2,$year3];

            $data = [];
            
            if(count($yearDatas) > 1){
                $yearsDatas;

                $total = DB::select('SELECT COUNT(id) AS total
                FROM posts
                WHERE is_delete = 0');

                return response([
                    'data' => $yearDatas,
                    'total' => $total,
                ]);
                
            }else if(count($yearDatas) == 1){
                foreach($years as $year){
                    $match = 0;

                    foreach($yearDatas as $yearsData){
                        if($year == $yearsData->day){
                            $match++;
                            $data[] = ['post'=>$yearsData->post,'day'=>$yearsData->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['post'=>0,'day'=>$year];
                    }
                }
            }else{
                foreach($yearDatas as $yearsData){
                    $data[] = ['post'=>0,'day'=>$year];
                }
            }
            
            $total = DB::select('SELECT COUNT(id) AS total
            FROM posts
            WHERE is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else{
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS post, DATE_FORMAT(created_at,'%e') AS day
            FROM posts 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }

            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['post' => $thisMonth->post,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['post'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['post'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM posts 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }
    }

    // get users data for chart
    public function getUsersChart(Request $req){
        // print_r($req->all());die;
        if($req->value == "week"){
            // week
            $usersData = DB::select('SELECT COUNT(id) AS users, DAYNAME(created_at) AS day
            FROM users 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)
            AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

            $days = ['Monday','Tuesday',
            'Wednesday','Thursday','Friday','Saturday','Sunday'];
            
            $data = [];

            if(count($usersData) > 0){
                foreach($days as $day){
                    $match = 0;
                    foreach($usersData as $user){
    
                        if( $day == $user->day ){
                            $match++;
                            $data[] = ['users' =>  $user->users, 'day' => $day];
                        }
    
                    }
    
                    if($match == 0){
                        $data[] = ['users' => 0, 'day' => $day];
                    }
                }
            }else{
                foreach($days as $day){
                    $data[] = ['users' => 0, 'day' => $day];
                }
            }
            
            $total = DB::select('SELECT COUNT(id) AS total
            FROM users 
            WHERE yearweek(DATE(created_at), 1) = yearweek(curdate(), 1)
            AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "this month"){
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS users, DATE_FORMAT(created_at,'%e') AS day
            FROM users 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }
            
            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['users' => $thisMonth->users,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['users'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['users'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM users 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "month"){
            $monthData = DB::select('SELECT COUNT(id) AS users, DATE_FORMAT(created_at,"%b") AS day, YEAR(created_at) AS YEAR 
            FROM users 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

            $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug',
                            'Sep','Oct','Nov','Dec'];
            $data = [];

            if(count($monthData) > 0){
                foreach($months as $month){
                    $match = 0;
                    foreach($monthData as $m_data){
    
                        if($month == $m_data->day){
                            $match++;
                            $data[] = ['users'=>$m_data->users,'day'=>$m_data->day];
                        }
                    }
    
                    if($match == 0){
                        $data[] = ['users' =>0, 'day'=>$month ];
                    }
                }
            }else{
                foreach($months as $month){
                    $data[] = ['users' =>0, 'day'=>$month ];
                }
            }

            
            $total = DB::select('SELECT COUNT(id) AS total, MONTHNAME(created_at) AS MONTH, YEAR(created_at) AS YEAR 
            FROM users 
            WHERE YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else if($req->value == "year"){
            $yearDatas = DB::select('SELECT COUNT(id) AS users, YEAR(created_at) AS day
            FROM users 
            WHERE is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC');

            $year_2 = date('Y',strtotime('-2 years'));
            $year_1 = date('Y',strtotime('-1 years'));
            $thisYear = date('Y');
            $year1 = date('Y',strtotime('+1 years'));
            $year2 = date('Y',strtotime('+2 years'));
            $year3 = date('Y',strtotime('+3 years'));
            $years = [$year_2,$year_1,$thisYear,$year1,$year2,$year3];

            $data = [];

            if(count($yearDatas) > 1){
                $total = DB::select('SELECT COUNT(id) AS total
                FROM users 
                WHERE is_delete = 0');

                return response([
                    'data' => $yearDatas,
                    'total' => $total,
                ]);
            }else if(count($yearDatas) == 1){
                foreach($years as $year){
                    $match = 0;
                    foreach($yearsDatas as $yearsData){
                        if($year == $yearsData->day){
                            $match++;
                            $data[] = ['users'=>$yearsData->users,'day'=>$yearsData->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['users'=>0,'day'=>$year];
                    }
                }
            }else{
                foreach($years as $year){
                    $data[] = ['users'=>0,'day'=>$year];
                }
            }
            
            $total = DB::select('SELECT COUNT(id) AS total
            FROM users 
            WHERE is_delete = 0');

            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }else{
            // current month data
            $thisMonths = DB::select("SELECT COUNT(id) AS users, DATE_FORMAT(created_at,'%e') AS day
            FROM users 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0
            GROUP BY (day)
            ORDER BY(id) ASC");

            $dates = [];
            $currentDate = date('t');
            for($i = 1;$i <= $currentDate;$i++){
                $dates[] = $i;
            }

            $data = [];
            
            if(count($thisMonths) > 0){
                foreach($dates as $date){
                    $match = 0;
                    foreach($thisMonths as $thisMonth){
                        if($date == $thisMonth->day){
                            $match++;
                            $data[] = ['users' => $thisMonth->users,'day'=>$thisMonth->day];
                        }
                    }

                    if($match == 0){
                        $data[] = ['users'=>0,'day'=>$date];
                    }
                }
            }else{
                foreach($dates as $date){
                    $data[] = ['users'=>0,'day'=>$date];
                }
            }

            $total = DB::select('SELECT COUNT(id) AS total FROM users 
            WHERE MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)
            AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)
            AND is_delete = 0');
            
            return response([
                'data' => $data,
                'total' => $total,
            ]);
        }
    }
}
