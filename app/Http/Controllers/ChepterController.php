<?php

namespace App\Http\Controllers;

use Hash, Validator, Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Chepter;
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
    	$data['books'] = Book::paginate(10);
    	return view('books.books', $data);
    }

    public function create(){
    	return view('books.create_books');
    }

    public function store(Request $request){
    	$data = $request->all();
    	$book = New Book();
		$book->name = $data['book_name'];
		$book->save();
		return redirect('/manage-books');
    }

    public function edit($id = null){

    	$data['details'] = Book::where('id',$id)->first();
    	return view('books.edit_book',$data);
    }

    public function update(Request $request){
    	$data = $this->request->except('_token');
       
         $this->validate($request,[
            'name' => 'required|string|max:50',
        ]);

        Book::where('id',$data['id'])
        ->update($data);

        return redirect('/manage-books')->with('success', 'updated successfully !!'); 
    }

    public function delete($id = null){

        Book::where('id',$id)
        ->delete();

        return redirect('/manage-books')->with('success', 'delete successfully !!');     
    }
}
