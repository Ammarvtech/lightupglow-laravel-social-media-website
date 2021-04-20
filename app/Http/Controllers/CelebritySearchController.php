<?php 
namespace App\Http\Controllers;
 
use Auth;
use Hash;
use Twitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
class CelebritySearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
	    $client = new \GuzzleHttp\Client;

    	$tag = 'bae';
		$instaUrl = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?access_token=2671473351.3a81a9f.43027f28bb9947eb9300c6f795ba9c8d&count=15';
		$instaResponse = $client->get($instaUrl);
		$instaFeeds = $instaResponse->getBody();
		$instaFeeds = json_decode($instaFeeds);

		$fbpagename = 'JustWannaBeWithYou';
		
		$fbPageUrl = 'https://graph.facebook.com/v2.12/'.$fbpagename.'?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=picture%2Cname&format=json';
		$fbResponse = $client->get($fbPageUrl);
		$fbpage = $fbResponse->getBody();
		$fbpage = json_decode($fbpage);


		$fbUrl = 'https://graph.facebook.com/v2.12/'.$fbpagename.'/posts?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
		$fbResponse = $client->get($fbUrl);
		$fbFeeds = $fbResponse->getBody();
		$fbFeeds = json_decode($fbFeeds);

		$twpagename = 'JustWannaBeWithYou';

		$tweets = Twitter::getUserTimeline([
            'id' => $twpagename,
            'count'  => 20,
            'format' => 'object'
        ]);
        $twFeeds = json_decode($tweets);

        return view('celebrity')->with('instafeeds',$instaFeeds)->with('fbpage',$fbpage)->with('fbFeeds',$fbFeeds)->with('twFeeds',$twFeeds);
    }

	public function userIndex($id)
    {
		$client = new \GuzzleHttp\Client;
		$url = 'https://api.instagram.com/v1/users/search?q='.$id.'&access_token=2671473351.3a81a9f.43027f28bb9947eb9300c6f795ba9c8d';
		$response = $client->get($url);
		$items = json_decode($response->getBody());
	    $uid =   $items->data[0]->id;
		$url = sprintf('https://api.instagram.com/v1/users/'.$uid.'/media/recent?access_token=2671473351.3a81a9f.43027f28bb9947eb9300c6f795ba9c8d&count=15');
		$response = $client->get($url);
		$instafeeds = $response->getBody();
		$instafeeds = json_decode($instafeeds);
		return view('celebrity')->with('instafeeds',$instafeeds);
    }
    public function instaMore(Request $request)
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

    public function Tweet(Request $request)
    {

    	  $tweets = Twitter::getUserTimeline([
            'id' => 'pragnesh2601',
            'count'  => 20,
            'format' => 'object'
        ]);
    	dd($tweets);

        //return view('celebrity');
    }
    
}