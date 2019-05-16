<?php

namespace App\Http\Controllers\API;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Book::all();
        return $books;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * 
         * Recomend user authentication for verifying user has permission for 
         * creating entries
         *
         * See 'GATES'
         * 
         * if (Gate::allows('store')) {
         * // The current user can create an entry...
         * // use code below 'else' return fault response
         * }
        */
        
        $verify = $this->verify_book($request);
        if (count($verify)>0){
            return response($verify,500);
        }

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->blurb = $request->blurb;
        $book->ISBN = $request->ISBN;
        $book->release_year = $request->release_year;
        $book->number_pages = $request->number_pages;
        $book->save();
        return "New Book: " . $request->title . " added";
    }


    // Shortened version for retrieving titles
    public function titles()
    {
        $books = Book::all();
        foreach($books as $book){
            $books_response[$book->id] = $book->title;
        }
        return $books_response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        // Return RAW data for front end
        return $book;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        /**
         * 
         * Recomend user authentication for verifying user has permission for 
         * editing entries
         *
         * See 'GATES'
         * 
        */
        $verify = $this->verify_book($request);
        if (count($verify)>0){
            return response($verify,500);
        }
        
        $book->title = $request->title;
        $book->author = $request->author;
        $book->blurb = $request->blurb;
        $book->ISBN = $request->ISBN;
        $book->release_year = $request->release_year;
        $book->number_pages = $request->number_pages;
        $book->save();
        
        return "Confirm update of: id=". $book->id . ",title=" . $book->title;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        /**
         * 
         * Recomend user authentication for verifying user has permission for 
         * deleting entries
         * 
         * See 'GATES'
         * 
        */

        Book::destroy($book->id);
        return "Book Deleted";
    }

    private function verify_book(Request $request)
    {
        $fault = array();
        // Verify data has been provided
        if (!$request->has('title')){
            array_push($fault,"No title provided");
        }
        if (!$request->has('author')){
            array_push($fault,"No author provided");
        }
        if (!$request->has('blurb')){
            array_push($fault,"No blurb provided");
        }
        if (!$request->has('ISBN')){
            array_push($fault,"No ISBN provided");
        }
        if (!$request->has('release_year')){
            array_push($fault,"No release year provided");
        }
        if (!$request->has('number_pages')){
            array_push($fault,"No number of pages provided");
        }
        // Verify suitabillity of data
        if (strlen($request->title)>200){
            array_push($fault,"Title too long");
        }
        if (strlen($request->author)>100){
            array_push($fault,"Author name too long");
        }
        if (strlen($request->release_year)>4){
            array_push($fault,"Year not valid");
        }
        if (!is_numeric($request->number_pages)){
            array_push($fault,"No number of pages provided");
        }
        return $fault;
    }
}
