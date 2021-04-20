<?php 
namespace App\Http\Controllers;
 
//use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Vinelab\Rss\Rss;
use Response;

class RssController extends Controller
{
    public function index()
    {
        $rss = new Rss();
		$feed = $rss->feed('http://rss.cnn.com/rss/edition_world.rss');
		$articles = $feed->articles();
        return view('rss')->with('articles',$articles);
    }

    public function index1()
    {
        $rss = new Rss();
		$feed = $rss->feed('http://rss.cnn.com/rss/edition_world.rss','json');
		$items = $feed->channel->item;

		return Response::json($items);
    }
}