<?php 
namespace App\Http\Controllers;
 
use Auth;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
        return view('create_page');
    }

  	public function switchUser(Request $request, $id) {


        if(strpos(Auth::User()->email, '_fanpage')){
        $email = strstr(Auth::User()->email, '_fanpage');
        $email = str_replace("_fanpage","",$email);
        }else{
            $email = Auth::User()->email;
        }
        $users = User::where('email', 'like', '%' . $email . '%')->get();
        foreach ($users as $user) {
            if($user->id == $id){
                Auth::logout(); 
                Auth::login($user);
            }
        }
        
        return redirect('home');

    }

    public function create(Request $request){

        $data = $request->all();
        $input = json_decode($data['data']);
        unset($data['data']);

        $response = array();
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";

		if($input->page_name != ''){
	        $email = trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $input->page_name)).'_fanpage'.Auth::User()->email;

	        $user_exists = User::whereEmail($email)->first();
	        if(!$user_exists){
	        	$user = New User();
	        		$user->name = $input->page_name;
	        		$user->email = $email;
	        		$user->username = preg_replace('/[^A-Za-z0-9-]+/', '-', $input->page_name);
	        		$user->password = Auth::user()->password;
	        		$user->role = 'Fanpage';
					
					if(isset($input->category))
	        			$user->category = $input->category;
	        		$user->save();
	        		$response['code'] = 200;
        			$response['message'] = "Page Created Successfully..!";
        			Auth::logout(); 
        			Auth::login($user);
	        }
	    }

        return Response::json($response);
    }

}