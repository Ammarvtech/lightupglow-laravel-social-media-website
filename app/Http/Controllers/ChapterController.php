<?php

namespace App\Http\Controllers;

use Hash, Validator, Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Chapter;
use App\Http\Requests;      
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
 	public function __construct( Request $request)
    {
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index(Request $request){
    	
        $data = Chapter::paginate(20);

       $per_pg =  count($data->items());
        return view('chapters.chapters', compact('data', 'per_pg'));
    }

    public function create(){
        $book = Book::all();

    	return view('chapters.create_chapter', compact('book'));
    }

    public function store(Request $request){
    	$data = $request->except('_token');
        
    	Chapter::updateOrCreate(['id' => $data['id']], $data);
		return redirect('/manage-chapters')->with('success', 'save successfully');
    }

    public function edit($id = null){

        $book = Book::all();
    	$data = Chapter::where('id',$id)->first();
    	return view('chapters.create_chapter', compact('book','data'));
    }
    
    public function delete($id = null){

        Book::where('id',$id)
        ->delete();

        return redirect('/manage-books')->with('success', 'delete successfully !!');     
    }
}
