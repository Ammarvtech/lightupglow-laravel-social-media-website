<?php

namespace App\Http\Controllers;

use Hash, Validator, Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Language;
use App\Models\Verse;
use App\Http\Requests;      
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VersesController extends Controller
{
 	public function __construct( Request $request)
    {
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index(Request $request){
    	
        $data = Verse::paginate(20);

       $per_pg =  count($data->items());
        return view('verses.verses', compact('data','per_pg'));
    }

    public function create(){
        $book = Book::all();
        $lan = Language::get();
        $chapter  = ['0' =>'Select Book First'];

    	return view('verses.create_verse', compact('book','lan','chapter'));
    }

    public function chapters()
    {   $id = $this->request->id;

        $data = Chapter::where('book_id', $id)
        ->pluck('chapter_name', 'id');
        
        return $data;
    }

    public function store(Request $request){
    	$data = $request->except('_token');
       
    	Verse::updateOrCreate(['id' => $data['id']], $data);
		return redirect('/manage-verses')->with('success', 'save successfully');
    }

    public function edit($id = null){

        $book = Book::all();
    	$data = Verse::where('id',$id)->first();
        $lan = Language::get();
        $chapter = Chapter::where('book_id', $data->book_id)->pluck('chapter_name', 'id');

    	return view('verses.create_verse', compact('book','data', 'chapter','lan'));
    }
    
    public function delete($id = null){

        verse::where('id',$id)
        ->delete();

        return redirect('/manage-verses')->with('success', 'delete successfully !!');     
    }
}
