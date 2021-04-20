<?php
namespace App\Http\Controllers;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting;
use App\Models\Country;
use App\Mail\OrderShipped;
use Session;
use Response;
use Embed\Embed;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        if (Session::has('user')){
            $user = Session::get('user');
        }else{
            $user = Auth::user();
        }
        return view('settings', compact('user'));
    }
    
    public function siteSettings(){
        if(Auth::User() && Auth::User()->role == 'Admin'){
            $settings = Setting::find(1);
            return view('site_settings')->with('settings', $settings);
        }
        else {
            abort('404');
        }
    }
    public function saveSiteSettings(Request $request){

        $data = $request->all();
        $input = json_decode($data['data']);
        unset($data['data']);
        $response = array();
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";


        if(Auth::User() && Auth::User()->role == 'Admin'){
            $settings = Setting::find(1);
            
            if(!$settings){
                $settings = new Setting();
                $json = new \stdClass();
            }else{
                $json = $settings->json;
            }
                $json->youtube1 = $input->youtube1;
                $youtube1info = Embed::create($input->youtube1);
                $json->youtube1Code = $youtube1info->code;
                $json->youtube1Title = $youtube1info->title;
                $json->youtube2 = $input->youtube2;
                $youtube2info = Embed::create($input->youtube2);
                $json->youtube2Code = $youtube2info->code;
                $json->youtube2Title = $youtube2info->title;
                $json->youtube3 = $input->youtube3;
                $youtube3info = Embed::create($input->youtube3);
                $json->youtube3Code = $youtube3info->code;
                $json->youtube3Title = $youtube3info->title;
                $json->youtube4 = $input->youtube4;
                $youtube4info = Embed::create($input->youtube4);
                $json->youtube4Code = $youtube4info->code;
                $json->youtube4Title = $youtube4info->title;
                $json->youtube5 = $input->youtube5;
                $youtube5info = Embed::create($input->youtube5);
                $json->youtube5Code = $youtube5info->code;
                $json->youtube5Title = $youtube5info->title;
                $json->youtube6 = $input->youtube6;
                $youtube6info = Embed::create($input->youtube6);
                $json->youtube6Code = $youtube6info->code;
                $json->youtube6Title = $youtube6info->title;
                $json->youtube7 = $input->youtube7;
                $youtube7info = Embed::create($input->youtube7);
                $json->youtube7Code = $youtube7info->code;
                $json->youtube7Title = $youtube7info->title;
                $json->youtube8 = $input->youtube8;
                $youtube8info = Embed::create($input->youtube8);
                $json->youtube8Code = $youtube8info->code;
                $json->youtube8Title = $youtube8info->title;
                $json->youtube9 = $input->youtube9;
                $youtube9info = Embed::create($input->youtube9);
                $json->youtube9Code = $youtube9info->code;
                $json->youtube9Title = $youtube9info->title;
                $json->youtube10 = $input->youtube10;
                $youtube10info = Embed::create($input->youtube10);
                $json->youtube10Code = $youtube10info->code;
                $json->youtube10Title = $youtube10info->title;
                $json->youtube11 = $input->youtube11;
                $youtube11info = Embed::create($input->youtube11);
                $json->youtube11Code = $youtube11info->code;
                $json->youtube11Title = $youtube11info->title;
                $json->youtube12 = $input->youtube12;
                $youtube12info = Embed::create($input->youtube12);
                $json->youtube12Code = $youtube12info->code;
                $json->youtube12Title = $youtube12info->title;
                
                $settings->json = json_encode($json);
                $settings->save();
                $response['code'] = 200;
                $response['message'] = "Settings saved successfully!";
        }else{
            $response = array();
            $response['code'] = 400;
            $response['message'] = "You are not authorized!";
        }
        return Response::json($response);
    }
    public function saveCelebritySettings(Request $request){

        $data = $request->all();
        $input = json_decode($data['data']);
        unset($data['data']);
        $response = array();
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";


        if(Auth::User() && Auth::User()->role == 'Admin'){
            $settings = Setting::find(1);
            
            if(!$settings){
                $settings = new Setting();
                $json = new \stdClass();
            }else{
                $json = $settings->json;
            }
                $json->instagram = $input->instagram;
                $json->fb = $input->fb;
                $json->twitter = $input->twitter;
                $json->youtube = $input->youtube;
                 
                $settings->json = json_encode($json);
                $settings->save();
                $response['code'] = 200;
                $response['message'] = "Settings saved successfully!";
        }else{
            $response = array();
            $response['code'] = 400;
            $response['message'] = "You are not authorized!";
        }
        return Response::json($response);
    }
    public function countrySettings(){
        if(Auth::User() && Auth::User()->role == 'Admin'){
            $countries = Country::all();
            return view('country_settings')->with('countries', $countries);
        }
        else {
            abort('404');
        }
    }
    public function countrySettingsPartial($id){
        if(Auth::User() && Auth::User()->role == 'Admin'){
            $settings = Country::findOrFail($id);
            return view('country_settings_partial')->with('settings', $settings);
        }
        else {
            abort('404');
        }
    }
    public function saveCountrySettings(Request $request){

        $data = $request->all();
        $json = json_decode($data['data']);
        unset($data['data']);

        $response = array();
        $response['code'] = 400;
        $response['message'] = "Something went wrong!";


        if(Auth::User() && Auth::User()->role == 'Admin'){
            $country = Country::findOrFail($json->country_id);
            
            if(!$country){
                return Response::json($response);
            }
            unset($json->_token);
            $country->json = json_encode($json);
            $country->save();
            $response['code'] = 200;
            $response['message'] = "Settings saved successfully!";

        }else{
            $response['code'] = 400;
            $response['message'] = "You are not authorized!";
        }
        return Response::json($response);
    }


    public function update(Request $request){
        if($request->has('infoupdate')){

            if($request->has('name')){
                Auth::user()->name = $request->get('name');
            }
            if($request->has('email')){
                Auth::user()->email = $request->get('email');
            }
            if($request->has('sex')){
                Auth::user()->sex = $request->get('sex');
            }
            if($request->has('phone')){
                Auth::user()->phone = $request->get('phone');
            }
            if($request->has('bio')){
                Auth::user()->bio = $request->get('bio');
            }
            if($request->has('marital_status')){
                Auth::user()->marital_status = $request->get('marital_status');
            }
            if($request->has('skills')){
                Auth::user()->skills = $request->get('skills');
            }
            if($request->has('current_city')){
                Auth::user()->current_city = $request->get('current_city');
            }
            if($request->has('nationality')){
                Auth::user()->nationality = $request->get('nationality');
            }
            if($request->has('interested_in')){
                Auth::user()->interested_in = $request->get('interested_in');
            }
            if($request->has('category')){
                Auth::user()->category = $request->get('category');
            }
            if($request->has('private')){
                // Auth::user()->private = $request->get('private');
                Auth::user()->private = 0;
            }

            $save = Auth::user()->save();   

        }elseif ($request->has('usernameupdate')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:191|unique:users,username,' . Auth::user()->id
            ]);
            if ($validator->fails()) {
            
                $save = false;
            }else {
                Auth::user()->username = $request->get('username');
                if (Auth::user()->validateUsername()) {
                    $save = Auth::user()->save();
                }else{
                    $save = false;
                    $additional_msg = "Username can't contain special character and space";
                }
            }
        }elseif ($request->has('passwordupdate')) {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|passcheck',
                'password' => 'required|min:6|confirmed'
            ]);
            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->password = \Hash::make($request->input("password"));
                $save = Auth::user()->save();
            }
        }

        if ($save){
            $request->session()->flash('alert-success', 'Your settings have been successfully updated!');
            $content = [
                'title'=> 'Password Changed', 
                'body'=> 'Hello '.Auth::user()->name.' your password is changed successfully!',
                'button' => 'Click Here'
                ];
                 
            $receiverAddress = Auth::User()->email;
    
    
            Mail::to($receiverAddress)->send(new OrderShipped($content));
        }
        else{
            $request->session()->flash('alert-danger', ($additional_msg)?$additional_msg:'There was a problem saving your settings!');
        }

        return redirect('settings');
    }


    public function update_old(Request $request){

        $additional_msg = false;
        if ($request->input("type") == "password") {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|passcheck',
                'password' => 'required|min:6|confirmed'
            ]);
            if ($validator->fails()) {
                $save = false;
            } else {
                Auth::user()->password = \Hash::make($request->input("password"));
                $save = Auth::user()->save();
            }
        }elseif ($request->input("type") == "username"){
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:191|unique:users,username,' . Auth::user()->id
            ]);
            $user = [
                'username' => $request->input("username"),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email
            ];
            if ($validator->fails()) {
                $save = false;
            }else {
                Auth::user()->username = $user['username'];
                if (Auth::user()->validateUsername()) {
                    $save = Auth::user()->save();
                }else{
                    $save = false;
                    $additional_msg = "Username can't contain special character and space";
                }
            }
        }else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:191',
                'email' => 'required|email|max:191|unique:users,email,' . Auth::user()->id
            ]);
            $user = [
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'private' => $request->input("private"),
            ];
            if ($validator->fails()) {
                $save = false;
            }else {
                Auth::user()->name = $user['name'];
                Auth::user()->email = $user['email'];
                Auth::user()->private = $user['private'];
                $save = Auth::user()->save();
            }
        }
        if ($save){
            $request->session()->flash('alert-success', 'Your settings have been successfully updated!');
        }else{
            $request->session()->flash('alert-danger', ($additional_msg)?$additional_msg:'There was a problem saving your settings!');
        }

        if ($request->input("type") == "password") {
            if ($save){
                return redirect('settings');
            }else{
                return redirect('settings')
                    ->withErrors($validator);
            }
        }else{
            if ($save){
                return redirect('settings');
            }else{
                return redirect('settings')
                    ->withErrors($validator)
                    ->with('user', $user);
            }
        }

    }
}