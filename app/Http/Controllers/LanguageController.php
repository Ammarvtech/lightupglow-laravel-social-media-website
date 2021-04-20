<?php

namespace App\Http\Controllers;

use Hash, Validator, Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Language;
use App\Models\Chapter;
use App\Http\Requests;      
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
 	public function __construct( Request $request)
    {
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index(Request $request){
    	
        $data= Language::orderBy('sorting', 'asc')
        ->get();

        return view('languages.languages', compact('data'));
    }

    public function create(){
    	return view('languages.create_language');
    }

    public function store(Request $request){
    	$data = $request->except('_token');
        
    	Language::updateOrCreate(['id' => $data['id']], $data);
		return redirect('/manage-languages')->with('success', 'save successfully');
    }

    public function edit($id = null){
        
    	$data = Language::where('id',$id)->first();
    	return view('languages.create_language', compact('data'));
    }

    public function delete($id = null){

        Language::where('id',$id)
        ->delete();

        return redirect('/manage-languages')->with('success', 'delete successfully !!');     
    }
}
