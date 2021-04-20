<?php
namespace App\Http\Controllers;

use Auth;
use Hash;
use DB;
use App\Models\Setting;
use App\Models\SocialComment;
use App\Models\Post;
use App\Models\SocialPost;
use App\Models\User;
use App\Models\PostImage;
use App\Models\PostVideo;
use Twitter;
use App\Models\SocialUser;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Alaouy\Youtube\Facades\Youtube;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class CelebrityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('celebrity');
    }

	public function userIndex($id)
    {
	    return view('celebrity');
    }

    public function instaMore1(Request $request)
    {
    	$url1 = $request->get('url');
    	$max_id = $request->get('max_id');
    	$count = $request->get('count');
    	if($request->has('max_id')){
    		$max_id = $request->get('max_id');
    		$url  = $url1.'&count='.$count.'&max_id='.$max_id;
		}
		if($request->has('max_tag_id')){
    		$max_tag_id = $request->get('max_tag_id');
    		$url  = $url1.'&count='.$count.'&max_tag_id='.$max_tag_id;
		}

	    $client = new \GuzzleHttp\Client;
		$response = $client->get($url);
		$instafeeds = $response->getBody();
		return $instafeeds;
    }

    public function instaMore(Request $request)
    {
    	$client = new \GuzzleHttp\Client;
    	$username = $request->get('name');
    	$max_id = $request->get('url');
		$url = 'https://www.instagram.com/'.$username.'/?__a=1&count=20&max_id='.$max_id;
		$response = $client->get($url);
		$items = json_decode($response->getBody());
		$instafeeds = $items->graphql->user;
		return Response::json($instafeeds);
    }
	
    public function iPartialPost(){
		$settings = Setting::find(1);
 		$client = new \GuzzleHttp\Client;
		$tag = $settings->json->instagram;
		$instaUrl = 'https://www.instagram.com/explore/tags/'.$tag.'/?__a=1';
		$instaResponse = $client->get($instaUrl);
		$items = json_decode($instaResponse->getBody());
		// print_r($items); die;
		$instaFeeds = $items->graphql->hashtag;
		$insta_profile_pic = $instaFeeds->profile_pic_url;
		foreach($instaFeeds->edge_hashtag_to_media->edges as $insta){
			// check that there is facebook is available in name
			$video = $insta->node->is_video;
			if($video){
				// echo $insta->node->id.'</br>';
			}
			// continue;
			$checkFbName = User::where('name','Lightupglo latest update')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'Lightupglo latest update';
				$adduser->email = 'instagram@insta.com';
				$adduser->password = bcrypt('instagrampost');
				$adduser->profile_path = 'logo.png';
				$adduser->username = 'Lightupglo latest update';
				$adduser->first_name = 'instagram';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'instagrampost';
				$adduser->save();
			}
			$userId = User::where('name','Lightupglo latest update')->first();
			
			// check if this id is available or not inthe table
			$checkposts = SocialPost::where('social_post_id',$insta->node->id)->first();
			if(!$checkposts){
				// add post in the posts table
				$addPost = new Post;
				$addPost->user_id = $userId->id;
				$addPost->has_image = 1;
				$addPost->group_id = 0;
				$addPost->content = $insta->node->edge_media_to_caption->edges[0]->node->text;
				$addPost->save();

				$lastPostId = $addPost->id;
				if($addPost){
					// add post in the post image table
					$postImage = new PostImage;
					$postImage->post_id = $lastPostId;
					$postImage->image_path = $insta->node->display_url;
					$postImage->save();
					
					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $insta->node->id;
					$socialPost->name = "instagram";
					$socialPost->save();
				}
			}
		}
 		return View("celebrities.instagram_partial")->with('instafeeds',$instaFeeds)->with('tag', $tag,'true')->render();
	}
	
	// social media auto update
	public function autoSocialUpdate(){
		// instagram
		// set_time_limit(60);
		$settings = Setting::find(1);
 		$client = new \GuzzleHttp\Client;
		$tag = $settings->json->instagram;
		$instaUrl = 'https://www.instagram.com/explore/tags/'.$tag.'/?__a=1';
		$instaResponse = $client->get($instaUrl);
		$items = json_decode($instaResponse->getBody());
		$instaFeeds = $items->graphql->hashtag;
		$insta_profile_pic = $instaFeeds->profile_pic_url;

		// delete exist posts
		$posts = DB::select('SELECT social_post_id FROM social_media
		GROUP BY social_post_id
		HAVING COUNT(social_post_id) > 1');

		foreach($posts as $post){
			$id = $post->social_post_id;			
			// count how many times it is in the database
			$count_data = SocialPost::where('social_post_id',$id)->limit(10)->get();
			$count_data = count($count_data);
			$delete_data_times = ($count_data - 1);

			// get post id
			$postDatas = SocialPOst::where('social_post_id',$id)->limit($delete_data_times)->get();
			foreach($postDatas as $postData){
				// delete from posts
				$deletePost = Post::where('id',$postData->post_id)->delete();
				if($deletePost){
					// delete from post images
					PostImage::where('post_id',$postData->post_id)->delete();
					// delet from post video
					PostVideo::where('post_id',$postData->post_id)->delete();
					// delete from social media posts
					SocialPost::where('post_id',$postData->post_id)->delete();
				}
			}
		}
		
		foreach($instaFeeds->edge_hashtag_to_media->edges as $insta){
			// echo $insta->node->id;die;
			// check that there is facebook is available in name
			$checkFbName = User::where('name','Lightupglo latest update')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'Lightupglo latest update';
				$adduser->email = 'instagram@insta.com';
				$adduser->password = bcrypt('instagrampost');
				$adduser->profile_path = 'logo.png';
				$adduser->username = 'Lightupglo latest update';
				$adduser->first_name = 'instagram';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'instagrampost';
				$adduser->save();
			}
			$userId = User::where('name','Lightupglo latest update')->first();
			// check if this id is available or not inthe table
			// $checkposts = SocialPost::where('social_post_id',$insta->node->id)->first();
			$checkposts = SocialPost::where('social_post_id',$insta->node->id)->get();
			if(count($checkposts) == 0){
				// add post in the posts table
				$addPost = new Post;
				$addPost->user_id = $userId->id;
				$addPost->has_image = 1;
				$addPost->group_id = 0;
				$addPost->content = $insta->node->edge_media_to_caption->edges[0]->node->text;
				$addPost->save();

				$lastPostId = $addPost->id;
				if($addPost){
					// add post in the post image table
					$postImage = new PostImage;
					$postImage->post_id = $lastPostId;
					$postImage->image_path = $insta->node->display_url;
					$postImage->save();
					
					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $insta->node->id;
					$socialPost->name = "instagram";
					$socialPost->save();
				}
			}
		}

		// instagram user posts auto update
		$userToken = SocialUser::where('user_id',Auth::user()->id)->where('name','instagram')->first();
		$token = $userToken->access_token;
		die;
		if($token){
			$instaAuth = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$token;
				// $client = new \GuzzleHttp\Client();
				// $response = $client->get($instaAuth);
				// $datas = json_decode($response->getbody()->getContents(),true);

				// print_r($datas);
				// die;
				$post_data_array = [];
				try{
					$response = $client->get($instaAuth);
					$datas = json_decode($response->getbody()->getContents(),true);
					$userId = Auth::user()->id;
					foreach($datas['data'] as $data){
						$postContent = $data['caption']['text'];
						$type = $data['type'];
						$id = $data['id'];
						$post_data_array[] = $id;
						
						// check post is exist or not
						$checkPost = SocialPost::where('social_post_id',$id)->first();
						if($checkPost){
							// echo "Thank you for login with Instagram";
						}else{
							// no posts
							if($type == 'image'){
								// image post
								$instaImageUrl = $data['images']['standard_resolution']['url'];
								// if(!empty($instaImageUrl)){
									// add to post
									$addPost = new Post;
									$addPost->user_id = $userId;
									$addPost->has_image = 1;
									$addPost->group_id = 0;
									$addPost->content = $postContent;
									$addPost->save();
		
									$postLastId = $addPost->id;
									
									// add image post
									$postImage = new PostImage;
									$postImage->post_id = $postLastId;
									$postImage->image_path = $instaImageUrl;
									$postImage->save();
			
									// add to social media
									$socialPost = new SocialPost;
									$socialPost->post_id = $addPost->id;
									$socialPost->social_post_id = $id;
									$socialPost->name = 'instagram';
									$socialPost->save();
								// }
		
							}else if($type == 'video'){
								// video post
								$insta_video_url = $data['videos']['standard_resolution']['url'];
								// add to post
								$addPost = new Post;
								$addPost->user_id = $userId;
								$addPost->has_video = 1;
								$addPost->group_id = 0;
								$addPost->content = $postContent;
								$addPost->save();
	
								$postLastId = $addPost->id;
								
								// add image post
								$postVideo = new PostVideo;
								$postVideo->post_id = $postLastId;
								$postVideo->video_path = $insta_video_url;
								$postVideo->save();
		
								// add to social media
								$socialPost = new SocialPost;
								$socialPost->post_id = $addPost->id;
								$socialPost->social_post_id = $id;
								$socialPost->name = 'instagram';
								$socialPost->save();                            
							}else if($type == 'carousel'){
								// foreach($data['carousel_media'] as $carousel){
								// 	// extract image name for using as social_post_id
								// 	$instaImageUrl = $carousel['images']['standard_resolution']['url'];
								// 	$path = $insta_video_url;
								// 	// $path = 'https://scontent.cdninstagram.com/vp/a7615f92b912de977f4a8057db4e80d8/5E21DCF3/t51.2885-15/sh0.08/e35/s640x640/71339851_2796354373730444_219400028303521621_n.jpg?_nc_ht=scontent.cdninstagram.com';
								// 	$getFilename = pathinfo($path);
								// 	$filename = $getFilename['filename'];
								// 	$imageId = preg_replace('/[^0-9]/','',$filename);								

								// 	// check carousal social_id inthe social media post which is available or not..
								// 	$checkId = SocialPost::where('social_post_id',$imageId)->where('name','instagram')->first();
								// 	// echo $checkId;die;
								// 	if(empty($checkId)){

								// 		// add to post
								// 		$addPost = new Post;
								// 		$addPost->user_id = $userId;
								// 		$addPost->has_image = 1;
								// 		$addPost->group_id = 0;
								// 		$addPost->content = $postContent;
								// 		$addPost->save();
			
								// 		$postLastId = $addPost->id;
										
								// 		// add image post
								// 		$postImage = new PostImage;
								// 		$postImage->post_id = $postLastId;
								// 		$postImage->image_path = $instaImageUrl;
								// 		$postImage->save();
				
								// 		// add to social media
								// 		$socialPost = new SocialPost;
								// 		$socialPost->post_id = $addPost->id;
								// 		$socialPost->social_post_id = $imageId;
								// 		$socialPost->name = 'instagram';
								// 		$socialPost->save();											
								// 	}else{
								// 		//  the carousal images are already there..
								// 	}
								// }							
							}
							
						}
					}
					// check the post is deleted or not from instagram
					$datas_id = implode("','",$post_data_array);
					$postDatas = DB::select("SELECT sm.social_post_id
					FROM users u
					RIGHT JOIN posts p ON p.user_id = u.id
					RIGHT JOIN social_media sm ON sm.post_id = p.id
					WHERE sm.name = 'instagram'
					AND u.id = '$userId'
					AND sm.social_post_id NOT IN('$datas_id')");
					foreach($postDatas as $data_id){
						$id = $data_id->social_post_id;
						$post = SocialPost::where('social_post_id',$id)->first();
						$post->post_id;
						// DELETE from posts
						Post::where('id',$post->post_id)->delete();
						// DELETE from social media
						SocialPost::where('post_id',$post->post_id)->delete();
						// DELETE from image
						PostImage::where('post_id',$post->post_id)->delete();
						// DELETE from video
						PostVideo::where('post_id',$post->post_id)->delete();
					}
				}catch(RequestException $e){
					return response([
						'code' => 400,
					]);
				}
		}else{
			// no access_token in the socialUsers..
		}

		// nollywood updates
		$settings = Setting::find(1);
 		$client = new \GuzzleHttp\Client;
		$tag = $settings->json->instagram;
		$instaUrl = 'https://www.instagram.com/explore/tags/'.$tag.'/?__a=1';
		$instaResponse = $client->get($instaUrl);
		$datas = json_decode($instaResponse->getBody(),true);
		echo $instaUrl.'</br>';
		print_r($datas); die;

		
		// facebook
		// $settings = Setting::find(1);
 		// $client = new \GuzzleHttp\Client;
		// $fbpagename = $settings->json->fb;
		// // echo $fbpagename;die;
		// // echo $fbpagename;die;
		// $fbPageUrl = 'https://graph.facebook.com/v4.0/'.$fbpagename.'?access_token=EAAFKenjhcZB4BAGji5DQEba8M2EU19rd0GaAq3LF1pJDGbTyr4KNT4gouIu7cIvE8s9ZAnw27bOiZAovv5kiyPTMBpZB2L2ERF50ZAkc2uGALDmID2PEGq7TwOxKgn6GLZBsPrvfY4KdM2BPvbJVsbdVxDiOTwsWjSXjkfjwat6wZDZD&fields=picture%2Cname&format=json';
		// $fbResponse = $client->get($fbPageUrl);
		// $fbpage = $fbResponse->getBody();
		// $fbpage = json_decode($fbpage);
		
		// $fbUrl = 'https://graph.facebook.com/v4.0'.$fbpagename.'/posts?access_token=EAAFKenjhcZB4BAGji5DQEba8M2EU19rd0GaAq3LF1pJDGbTyr4KNT4gouIu7cIvE8s9ZAnw27bOiZAovv5kiyPTMBpZB2L2ERF50ZAkc2uGALDmID2PEGq7TwOxKgn6GLZBsPrvfY4KdM2BPvbJVsbdVxDiOTwsWjSXjkfjwat6wZDZD&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
		// $fbResponse = $client->get($fbUrl);
		// $fbFeeds = $fbResponse->getBody();
		// $fbFeeds = json_decode($fbFeeds);
		
		// foreach($fbFeeds->data as $fb_feed){
		// 	// echo $fb_feed->full_picture;
		// 	// check that there is facebook is available in name
		// 	$checkFbName = User::where('name','facebook post')->first();
		// 	if(!$checkFbName){
		// 		$adduser = new User;
		// 		$adduser->name = 'facebook post';
		// 		$adduser->email = 'facebook@fb.com';
		// 		$adduser->password = bcrypt('facebookpost');
		// 		$adduser->profile_path = $fbpage->picture->data->url;
		// 		$adduser->username = 'facebook post';
		// 		$adduser->first_name = 'facebook';
		// 		$adduser->last_name = 'post';
		// 		$adduser->current_city = 'USA';
		// 		$adduser->nationality = 'California';
		// 		$adduser->interested_in = 'both';
		// 		$adduser->marital_status = 'none';
		// 		$adduser->skills = 'social media';
		// 		$adduser->category = 'social media';
		// 		$adduser->role = 'Follower';
		// 		$adduser->password_clear = 'facebookpost';
		// 		$adduser->save();
		// 	}
		// 	// $userdata = User::where('name','facebook post')->select('id')->get();
		// 	$userId = User::where('name','facebook post')->first();
		// 	// check if this id is available or not inthe table
		// 	// $checkposts = SocialPost::where('social_post_id',$fb_feed->id)->first();
		// 	$checkposts = SocialPost::where('social_post_id',$fb_feed->id)->get();
		// 	if(count($checkposts) == 0){
		// 		if(empty($fb_feed->full_picture)){
		// 			// add post in the posts table
		// 			$addPost = new Post;
		// 			$addPost->user_id = $userId->id;
		// 			$addPost->group_id = 0;
		// 			$addPost->content = 'this post shared on facebook '.$fbpage->name;
		// 			$addPost->save();
					
		// 			$lastPostId = $addPost->id;

		// 			// social post table
		// 			$socialPost = new SocialPost;
		// 			$socialPost->post_id = $lastPostId;
		// 			$socialPost->social_post_id = $fb_feed->id;
		// 			$socialPost->name = "facebook";
		// 			$socialPost->save();
		// 		}else{
		// 			// add post in the posts table
		// 			$addPost = new Post;
		// 			$addPost->user_id = $userId->id;
		// 			$addPost->has_image = 1;
		// 			$addPost->group_id = 0;
		// 			$addPost->content = 'this post shared on facebook '.$fbpage->name;
		// 			$addPost->save();

		// 			$lastPostId = $addPost->id;
		// 			if($addPost){
		// 				// add post in the post image table
		// 				$postImage = new PostImage;
		// 				$postImage->post_id = $lastPostId;
		// 				$postImage->image_path = $fb_feed->full_picture;
		// 				$postImage->save();
						
		// 				// social post table
		// 				$socialPost = new SocialPost;
		// 				$socialPost->post_id = $lastPostId;
		// 				$socialPost->social_post_id = $fb_feed->id;
		// 				$socialPost->name = "facebook";
		// 				$socialPost->save();
		// 			}
		// 		}
		// 	}
		// }

		// twitter
		$settings = Setting::find(1);
		$tweets = Twitter::getUserTimeline([
            'id' => $settings->json->twitter,
            'count'       => 30,
            'format'      => 'object'
		]);

		foreach($tweets as $tweet){
			// echo $fb_feed->full_picture;
			// check that there is facebook is available in name
			$checkFbName = User::where('name','Nollywood tweet')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'Nollywood tweet';
				$adduser->email = 'twitter@tw.com';
				$adduser->password = bcrypt('twitterpost');
				$adduser->profile_path = $tweet->user->profile_image_url;
				$adduser->username = 'Nollywood tweet';
				$adduser->first_name = 'twitter';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'twitterpost';
				$adduser->save();
			}
			// $userdata = User::where('name','facebook post')->select('id')->get();
			$userId = User::where('name','Nollywood tweet')->first();
			// check if this id is available or not inthe table
			// $checkposts = SocialPost::where('social_post_id',$tweet->id)->first();
			$checkposts = SocialPost::where('social_post_id',$tweet->id)->get();
			if(count($checkposts) == 0){
				if(empty($tweet->extended_entities->media[0]->media_url)){
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->group_id = 0;
					$addPost->content = $tweet->text;
					$addPost->save();
					
					$lastPostId = $addPost->id;

					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $tweet->id;
					$socialPost->name = "twitter";
					$socialPost->save();
				}else{
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->has_image = 1;
					$addPost->group_id = 0;
					$addPost->content = $tweet->text;
					$addPost->save();

					$lastPostId = $addPost->id;
					if($addPost){
						// add post in the post image table
						$postImage = new PostImage;
						$postImage->post_id = $lastPostId;
						$postImage->image_path = $tweet->extended_entities->media[0]->media_url;
						$postImage->save();
						
						// social post table
						$socialPost = new SocialPost;
						$socialPost->post_id = $lastPostId;
						$socialPost->social_post_id = $tweet->id;
						$socialPost->name = "twitter";
						$socialPost->save();
					}
				}
			}
		}

		// twitter user auto update
		$socialUser  = SocialUser::where('user_id',Auth::user()->id)->where('name','twitter')->first();

		if($socialUser->social_user_id){
			$tweets = Twitter::getUserTimeline([
				'user_id' => $socialUser->social_user_id,
				'count'       => 20,
				'format'      => 'object'
			]);
			
			// foreach($tweets as $tweet){
			// 	echo $tweet->id.'</br>';
			// }
			// die;
			$twitterId = [];
			foreach($tweets as $tweet){
				$name = $tweet->user->name;
				$twitterId[] = $tweet->id;
				
				if($socialUser->username == $name){
					// same name
					
					// update new posts
					// check if posts are exists
					// socialPost
					$socialPost = SocialPost::where('social_post_id',$tweet->id)->first();
					if($socialPost){
						// id is exists
					}else{
						// check that which are what kind of posts
						if($tweet->entities->media == 0){
							// content posts
							$content = $tweet->text;
							if(starts_with($content,'@')){
                                   
                            }else{
                                // add to post
                                $addPost = new Post;
                                $addPost->user_id = Auth::user()->id;
                                $addPost->group_id = 0;
                                $addPost->content = $content;
                                $addPost->save();

                                // add to social post
                                $addSocial = new SocialPost;
                                $addSocial->post_id = $addPost->id;
                                $addSocial->social_post_id = $tweet->id;
                                $addSocial->name = 'twitter';
                                $addSocial->save();
                            }							
						}else{
							// media posts
							$content =  $tweet->text;
                            foreach($tweet->entities->media as $tweetPost){
                                if($tweetPost->type == 'photo'){
                                    // image
                                    if(starts_with($content,'https')){
                                        // worst content
                                        $content = substr($content,0, strpos($content,"htt"));
                                        // add to post
                                        $addPost = new Post;
                                        $addPost->user_id = Auth::user()->id;
                                        $addPost->has_image = 1;
                                        $addPost->group_id = 0;
                                        $addPost->content = '';
                                        $addPost->save();

                                        // add to image post
                                        $postImage = new PostImage;
                                        $postImage->post_id = $addPost->id;
                                        $postImage->image_path = $tweetPost->media_url_https;
                                        $postImage->save();


                                        // add to social media
                                        $socialPost = new SocialPost;
                                        $socialPost->post_id = $addPost->id;
                                        $socialPost->social_post_id = $tweet->id;
                                        $socialPost->name = 'twitter';
                                        $socialPost->save();
                                    }else{
                                        $content = substr($content,0, strpos($content,"htt"));
                                        // add to post
                                        $addPost = new Post;
                                        $addPost->user_id = Auth::user()->id;
                                        $addPost->has_image = 1;
                                        $addPost->group_id = 0;
                                        $addPost->content = $content;
                                        $addPost->save();

                                        // add to image post
                                        $postImage = new PostImage;
                                        $postImage->post_id = $addPost->id;
                                        $postImage->image_path = $tweetPost->media_url_https;
                                        $postImage->save();


                                        // add to social media
                                        $socialPost = new SocialPost;
                                        $socialPost->post_id = $addPost->id;
                                        $socialPost->social_post_id = $tweet->id;
                                        $socialPost->name = 'twitter';
                                        $socialPost->save();
                                    }
                                }else{
                                    // video
                                }
                            }							
						}
					}
				}else{
					//  when name is not same make the user to login again with twitter..
					return response([
						'code' => 'twitterError',
					]);
				}
			}
		}else{

		}
		// delete Nollywood tweet which is already deleted on the twitter
		$twitterId = implode("','",$twitterId);
		$userId = Auth::user()->id;

		$postDatas = DB::select("SELECT sm.social_post_id
		FROM users u
		RIGHT JOIN posts p ON p.user_id = u.id
		RIGHT JOIN social_media sm ON sm.post_id = p.id
		WHERE sm.name = 'twitter'
		AND u.id = '$userId'
		AND sm.social_post_id NOT IN('$twitterId')");
		
		foreach($postDatas as $postId){
			// get post id
			$id = $postId->social_post_id;
			$socialPost = SocialPost::where('social_post_id',$id)->first();
			$p_id = $socialPost->post_id;

			// delete on post
			Post::find($p_id)->delete();
			// delete on image post
			PostImage::where('post_id',$p_id)->delete();
			// delete on video post
			PostVideo::where('post_id',$p_id)->delete();
			// delete on social post
			SocialPost::where('post_id',$p_id)->delete();
		}
		// youtube
		$settings = Setting::find(1);
		$ychannel = Youtube::getChannelById($settings->json->youtube);
    	$channelVideos = Youtube::listChannelVideos($settings->json->youtube,12,'date');
    	$arr = array();
    	foreach ($channelVideos as $k) {
    		$arr[] = $k->id->videoId;
    	}
		$youtubeVideos = Youtube::getVideoInfo($arr);
		$youtube_profile_pic = $ychannel->snippet->thumbnails->default->url;
		foreach($youtubeVideos as $youtube){
			// check that there is facebook is available in name
			$checkFbName = User::where('name','youtube post')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'youtube post';
				$adduser->email = 'youtube@you.com';
				$adduser->password = bcrypt('youtubempost');
				$adduser->profile_path = $youtube_profile_pic;
				$adduser->username = 'youtube post';
				$adduser->first_name = 'youtube';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'instagrampost';
				$adduser->save();
			}
			$userId = User::where('name','youtube post')->first();
			// check if this id is available or not inthe table
			// $checkposts = SocialPost::where('social_post_id',$youtube->id)->first();
			$checkposts = SocialPost::where('social_post_id',$youtube->id)->get();
			if(count($checkposts) == 0){
				// add post in the posts table
				$addPost = new Post;
				$addPost->user_id = $userId->id;
				$addPost->has_video = 1;
				$addPost->group_id = 0;
				$addPost->content = $youtube->snippet->title;
				$addPost->save();

				$lastPostId = $addPost->id;
				if($addPost){
					// add post in the post image table
					$postVideo = new PostVideo;
					$postVideo->post_id = $lastPostId;
					$postVideo->video_path = $youtube->player->embedHtml ;
					$postVideo->save();
					
					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $youtube->id;
					$socialPost->name = "youtube";
					$socialPost->save();
				}
			}
		}

	}

    public function fPartialPost()
    {
 		$settings = Setting::find(1);
 		$client = new \GuzzleHttp\Client;
		$fbpagename = $settings->json->fb;
		// echo $fbpagename;die;
		// echo $fbpagename;die;
		$fbPageUrl = 'https://graph.facebook.com/v4.0/'.$fbpagename.'?access_token=EAAFKenjhcZB4BAGji5DQEba8M2EU19rd0GaAq3LF1pJDGbTyr4KNT4gouIu7cIvE8s9ZAnw27bOiZAovv5kiyPTMBpZB2L2ERF50ZAkc2uGALDmID2PEGq7TwOxKgn6GLZBsPrvfY4KdM2BPvbJVsbdVxDiOTwsWjSXjkfjwat6wZDZD&fields=picture%2Cname&format=json';
		$fbResponse = $client->get($fbPageUrl);
		$fbpage = $fbResponse->getBody();
		$fbpage = json_decode($fbpage);
		
		$fbUrl = 'https://graph.facebook.com/v4.0'.$fbpagename.'/posts?access_token=EAAFKenjhcZB4BAGji5DQEba8M2EU19rd0GaAq3LF1pJDGbTyr4KNT4gouIu7cIvE8s9ZAnw27bOiZAovv5kiyPTMBpZB2L2ERF50ZAkc2uGALDmID2PEGq7TwOxKgn6GLZBsPrvfY4KdM2BPvbJVsbdVxDiOTwsWjSXjkfjwat6wZDZD&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
		$fbResponse = $client->get($fbUrl);
		$fbFeeds = $fbResponse->getBody();
		$fbFeeds = json_decode($fbFeeds);
		
		foreach($fbFeeds->data as $fb_feed){
			// echo $fb_feed->full_picture;
			// check that there is facebook is available in name
			$checkFbName = User::where('name','facebook post')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'facebook post';
				$adduser->email = 'facebook@fb.com';
				$adduser->password = bcrypt('facebookpost');
				$adduser->profile_path = $fbpage->picture->data->url;
				$adduser->username = 'facebook post';
				$adduser->first_name = 'facebook';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'facebookpost';
				$adduser->save();
			}
			// $userdata = User::where('name','facebook post')->select('id')->get();
			$userId = User::where('name','facebook post')->first();
			// check if this id is available or not inthe table
			$checkposts = SocialPost::where('social_post_id',$fb_feed->id)->first();
			if(!$checkposts){
				if(empty($fb_feed->full_picture)){
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->group_id = 0;
					$addPost->content = 'this post shared on facebook '.$fbpage->name;
					$addPost->save();
					
					$lastPostId = $addPost->id;

					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $fb_feed->id;
					$socialPost->name = "facebook";
					$socialPost->save();
				}else{
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->has_image = 1;
					$addPost->group_id = 0;
					$addPost->content = 'this post shared on facebook '.$fbpage->name;
					$addPost->save();

					$lastPostId = $addPost->id;
					if($addPost){
						// add post in the post image table
						$postImage = new PostImage;
						$postImage->post_id = $lastPostId;
						$postImage->image_path = $fb_feed->full_picture;
						$postImage->save();
						
						// social post table
						$socialPost = new SocialPost;
						$socialPost->post_id = $lastPostId;
						$socialPost->social_post_id = $fb_feed->id;
						$socialPost->name = "facebook";
						$socialPost->save();
					}
				}
			}
		}
 		return View("celebrities.facebook_partial")->with('fbpage',$fbpage)->with('fbFeeds',$fbFeeds)->render();
    }

    public function tPartialPost(Request $request)
    {
		// print_r($request->all());die;
 		$settings = Setting::find(1);
		$tweets = Twitter::getUserTimeline([
            'id' => $settings->json->twitter,
            'count'       => 20,
            'format'      => 'object'
		]);

		foreach($tweets as $tweet){
			// echo $fb_feed->full_picture;
			// check that there is facebook is available in name
			$checkFbName = User::where('name','Nollywood tweet')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'Nollywood tweet';
				$adduser->email = 'twitter@tw.com';
				$adduser->password = bcrypt('twitterpost');
				$adduser->profile_path = $tweet->user->profile_image_url;
				$adduser->username = 'Nollywood tweet';
				$adduser->first_name = 'twitter';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'twitterpost';
				$adduser->save();
			}
			// $userdata = User::where('name','facebook post')->select('id')->get();
			$userId = User::where('name','Nollywood tweet')->first();
			// check if this id is available or not inthe table
			// $checkposts = SocialPost::where('social_post_id',$tweet->id)->first();
			$checkposts = SocialPost::where('social_post_id',$tweet->id)->get();
			if(count($checkposts) == 0){
				if(empty($tweet->extended_entities->media[0]->media_url)){
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->group_id = 0;
					$addPost->content = $tweet->text;
					$addPost->save();
					
					$lastPostId = $addPost->id;

					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $tweet->id;
					$socialPost->name = "twitter";
					$socialPost->save();
				}else{
					// add post in the posts table
					$addPost = new Post;
					$addPost->user_id = $userId->id;
					$addPost->has_image = 1;
					$addPost->group_id = 0;
					$addPost->content = $tweet->text;
					$addPost->save();

					$lastPostId = $addPost->id;
					if($addPost){
						// add post in the post image table
						$postImage = new PostImage;
						$postImage->post_id = $lastPostId;
						$postImage->image_path = $tweet->extended_entities->media[0]->media_url;
						$postImage->save();
						
						// social post table
						$socialPost = new SocialPost;
						$socialPost->post_id = $lastPostId;
						$socialPost->social_post_id = $tweet->id;
						$socialPost->name = "twitter";
						$socialPost->save();
					}
				}
			}
		}
 		return View("celebrities.twitter_partial")->with('tweets',$tweets)->render();
    }

    public function yPartialPost(Request $request)
    {
 		$settings = Setting::find(1);
		$ychannel = Youtube::getChannelById($settings->json->youtube);
    	$channelVideos = Youtube::listChannelVideos($settings->json->youtube,12,'date');
    	$arr = array();
    	foreach ($channelVideos as $k) {
    		$arr[] = $k->id->videoId;
    	}
		$youtubeVideos = Youtube::getVideoInfo($arr);
		$youtube_profile_pic = $ychannel->snippet->thumbnails->default->url;
		foreach($youtubeVideos as $youtube){
			// check that there is facebook is available in name
			$checkFbName = User::where('name','youtube post')->first();
			if(!$checkFbName){
				$adduser = new User;
				$adduser->name = 'youtube post';
				$adduser->email = 'youtube@you.com';
				$adduser->password = bcrypt('youtubempost');
				$adduser->profile_path = $youtube_profile_pic;
				$adduser->username = 'youtube post';
				$adduser->first_name = 'youtube';
				$adduser->last_name = 'post';
				$adduser->current_city = 'USA';
				$adduser->nationality = 'California';
				$adduser->interested_in = 'both';
				$adduser->marital_status = 'none';
				$adduser->skills = 'social media';
				$adduser->category = 'social media';
				$adduser->role = 'Follower';
				$adduser->password_clear = 'instagrampost';
				$adduser->save();
			}
			$userId = User::where('name','youtube post')->first();
			// check if this id is available or not inthe table
			// $checkposts = SocialPost::where('social_post_id',$youtube->id)->first();
			$checkposts = SocialPost::where('social_post_id',$youtube->id)->get();
			if(count($checkposts) == 0){
				// add post in the posts table
				$addPost = new Post;
				$addPost->user_id = $userId->id;
				$addPost->has_video = 1;
				$addPost->group_id = 0;
				$addPost->content = $youtube->snippet->title;
				$addPost->save();

				$lastPostId = $addPost->id;
				if($addPost){
					// add post in the post image table
					$postVideo = new PostVideo;
					$postVideo->post_id = $lastPostId;
					$postVideo->video_path = $youtube->player->embedHtml ;
					$postVideo->save();
					
					// social post table
					$socialPost = new SocialPost;
					$socialPost->post_id = $lastPostId;
					$socialPost->social_post_id = $youtube->id;
					$socialPost->name = "youtube";
					$socialPost->save();
				}
			}
		}

 		return View("celebrities.youtube_partial")->with('youtubeVideos',$youtubeVideos)->with('ychannel',$ychannel)->render();
    }

    public function iUserPartialPost($id)
    {
    	$user = DB::table('users')->where('username', $id)->get()->first();
		$instagram_uid = $user->instagram_uid;
		$client = new \GuzzleHttp\Client;
		if($instagram_uid){
			try {
				$url = 'https://apinsta.herokuapp.com/u/'.$instagram_uid;
				$response = $client->get($url);
				$items = json_decode($response->getBody());
				$instaFeeds = $items->graphql->user;
				}
				catch (\Exception $e) {
					$instaFeeds = null;
				}
			}else{ $instaFeeds = null; }
 		return View("celebrities.instagram_partial")->with('instafeeds',$instaFeeds)->render();
    }

    public function fUserPartialPost($id)
    {
		$user = DB::table('users')->where('username', $id)->get()->first();
		$facebook_uid = $user->facebook_uid;
		$client = new \GuzzleHttp\Client;
		if($facebook_uid){
			try {
				$fbPageUrl = 'https://graph.facebook.com/v2.12/'.$facebook_uid.'?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=picture%2Cname&format=json';
				$fbResponse = $client->get($fbPageUrl);
				$fbpage = $fbResponse->getBody();
				$fbpage = json_decode($fbpage);


				$fbUrl = 'https://graph.facebook.com/v2.12/'.$facebook_uid.'/posts?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
				$fbResponse = $client->get($fbUrl);
				$fbFeeds = $fbResponse->getBody();
				$fbFeeds = json_decode($fbFeeds);
			}
		  	catch (\Exception $e) {
				try {
					$fbPageUrl = 'https://graph.facebook.com/v2.12/'.$facebook_uid.'?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=picture%2Cname&format=json';
					$fbResponse = $client->get($fbPageUrl);
					$fbpage = $fbResponse->getBody();
					$fbpage = json_decode($fbpage);


					$fbUrl = 'https://graph.facebook.com/v2.12/'.$facebook_uid.'/posts?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
					$fbResponse = $client->get($fbUrl);
					$fbFeeds = $fbResponse->getBody();
					$fbFeeds = json_decode($fbFeeds);
 					}
				catch (\Exception $e) {
					$fbpage= null;
					$fbFeeds= null;
					}
				}
			}else{ $fbpage= null;$fbFeeds= null; }
 		return View("celebrities.facebook_partial")->with('fbpage',$fbpage)->with('fbFeeds',$fbFeeds)->render();
    }

    public function tUserPartialPost($id)
    {	
    	$user = DB::table('users')->where('username', $id)->get()->first();
		$twitter_uid = $user->twitter_uid;
		if($twitter_uid){
			try {
				$tweets = Twitter::getUserTimeline([
			            'id' => $twitter_uid,
			            'count'       => 20,
			            'format'      => 'object'
		        	]);
				}catch (\Exception $e) {
					$tweets = null;
				}
				}else{ $tweets = null; }
		return	 View("celebrities.twitter_partial")->with('tweets',$tweets)->render();
    }

    public function yUserPartialPost($id)
    {
    	$user = DB::table('users')->where('username', $id)->get()->first();
		$youtube_uid = $user->youtube_uid;
		if($youtube_uid){
			try {
					$ychannel = Youtube::getChannelById($youtube_uid);
    				$channelVideos = Youtube::listChannelVideos($youtube_uid,10,'date');
    				$arr = array();
	    				foreach ($channelVideos as $k) {
	    					$arr[] = $k->id->videoId;
	    				}
					$youtubeVideos = Youtube::getVideoInfo($arr);
				}
		  	catch (\Exception $e) {
		  			$ychannel= null;
					$youtubeVideos = null;
			}

		}
		else{
			$ychannel= null;
			$youtubeVideos = null;
		}
 		return View("celebrities.youtube_partial")->with('youtubeVideos',$youtubeVideos)->with('ychannel',$ychannel)->render();
    }

    public function comment(Request $request){
        $user = Auth::user();

        $response = array();
        $response['code'] = 400;

        $post_id = $request->input('id');
        $text = $request->input('comment');



        if (!empty($post_id) && !empty($text)){

            $comment = new SocialComment();
            $comment->post_id = $post_id;
            $comment->comment_user_id = $user->id;
            $comment->comment = $text;
            if ($comment->save()){
                $response['code'] = 200;
                    $comment_count = 2000000;
                    $can_see = true;
                    $html = View::make('celebrities.single_comment', compact('post_id', 'comment', 'user', 'comment_count', 'can_see'));
                    $response['comment'] = $html->render();
            }
        }

        return Response::json($response);
    }
}
