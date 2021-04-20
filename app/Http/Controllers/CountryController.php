<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;
use Twitter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Alaouy\Youtube\Facades\Youtube;
use Response;

class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$countries = Country::orderBy('id','ASC')->limit(8)->get();
        return view('countries.index')->with('countries',$countries);
    }

    public function countryMore(Request $request)
    {
    		$output = '';
        	$id = $request->id;
            $countries = DB::table('countries')->where('id','>',$id)->orderBy('name','ASC')->limit(8)->get();
            return view('widgets.suggested_more_country')->with('countries',$countries);
    }

    public function country($name){

        $country = Country::where('name', $name)->get()->first();
		$client = new \GuzzleHttp\Client;
		$tweets = array();
		$ychannel = array();
		$youtubeVideos = array();



	    return view('countries.country')->with('country',$country);
    }

    public function iCountryPartialPost($name)
    {
        $country = Country::where('name', $name)->get()->first();
		$client = new \GuzzleHttp\Client;
		$instafeeds = array();
		for($i=1;$i<7;$i++){
			try {
				if(isset($country->json->{'insta'.$i.'name'})){
					$url = 'https://apinsta.herokuapp.com/u/'.$country->json->{'insta'.$i};
					$response = $client->get($url);
					$items = json_decode($response->getBody());
					$instafeeds[] = $items->graphql->user;
				}

			}
		  	catch (\Exception $e) {
				$instafeeds[] = null;
			}
		}
		return View("countries.instagram_partial")->with('instagroup',$instafeeds)->render();

    }
    public function fCountryPartialPost($name)
    {
        $country = Country::where('name', $name)->get()->first();
		$client = new \GuzzleHttp\Client;
		$fbpage = array();
		$fbFeeds = array();
		for($i=1;$i<7;$i++){
			try {
				if(isset($country->json->{'fb'.$i.'name'})){
					$fbPageUrl = 'https://graph.facebook.com/v2.12/'.$country->json->{'fb'.$i}.'?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=picture%2Cname&format=json';
					$fbResponse = $client->get($fbPageUrl);
					$a = $fbResponse->getBody();
					$fbpage[] = json_decode($a);

				
					$fbUrl = 'https://graph.facebook.com/v2.12/'.$country->json->{'fb'.$i}.'/posts?access_token='.env("FACEBOOK_TOKEN",'1763978343622342|gpQBPZeXl3-1gOom099CHWGOydc').'&fields=message%2Cstory%2Cid%2Ccreated_time%2Cfull_picture%2Cpicture%2Ctype%2Clink&format=json';
					$fbResponse = $client->get($fbUrl);
					$b = $fbResponse->getBody();
					$fbFeeds[] = json_decode($b);
				}
				

			}
		  	catch (\Exception $e) {
				$fbpage[]= null; $fbFeeds[]= null; 
			}
		}
		return View("countries.facebook_partial")->with('fbpage',$fbpage)->with('fbgroup',$fbFeeds)->render();
    }

    public function tCountryPartialPost($name)
    {
        $country = Country::where('name', $name)->get()->first();
		$tweets = array();
		for($i=1;$i<7;$i++){
			try {
				if(isset($country->json->{'twi'.$i.'name'})){

					$tweets[] = Twitter::getUserTimeline([
			            'id' => $country->json->{'twi'.$i},
			            'count'       => 20,
			            'format'      => 'object'
		        	]);
				}
			}
		  	catch (\Exception $e) {
				$tweets[] = null;
			}
		}


		return View("countries.twitter_partial")->with('tweetgroup',$tweets)->render();
    }
    public function yCountryPartialPost($name)
    {
        $country = Country::where('name', $name)->get()->first();
		$ychannel = array();
		$youtubeVideos = array();
		for($i=1;$i<7;$i++){
			try {
				if(isset($country->json->{'you'.$i.'name'})){

					$ychannel[] = Youtube::getChannelById($country->json->{'you'.$i});
			    	$channelVideos = Youtube::listChannelVideos($country->json->{'you'.$i},12,'date');
			    	$arr = array();
			    	foreach ($channelVideos as $k) {
			    		$arr[] = $k->id->videoId;
			    	}
					$youtubeVideos[] = Youtube::getVideoInfo($arr);
				}
			}
			catch (\Exception $e) {
				$ychannel[] = null; $youtubeVideos[] = null;
			}
		}


		return View("countries.youtube_partial")->with('ychannel',$ychannel)->with('youtubeVideosgroup',$youtubeVideos)->render();

    }
}
