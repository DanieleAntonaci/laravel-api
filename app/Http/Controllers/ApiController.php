<?php

namespace App\Http\Controllers;

use App\Mail\NewMovie;
use App\Models\Movie;
use App\Models\Tag;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function apiMovie (){
        $movies = Movie::with('tags') -> orderBy('created_at', 'desc') -> get();;
        $tags= Tag ::all();
        $genres= Genre::all();
        return response() -> json([
            'success' => 'true',
            'response'=>[
                'movies' => $movies,
                'genres' => $genres,
                'tags' => $tags
                ]
        ]);
    }
    public function movieDelete(Movie $movie){
        $movie -> tags() -> sync([]);
        $movie -> delete();

        return response() -> json([
            'success' => true
        ]);
    }
    public function movieStore(Request $request){
        $data = $request -> validate([
            'name' => 'required|string',
            'year' => 'required|integer',
            'cashOut' => 'required|integer',
            'genres' => 'required|integer',
            'tags' => 'required|array'
        ]);
        
        $movie = Movie::make($data);
        $genre = Genre::find($data['genres']);

        $movie -> genre() -> associate($genre);
        $movie->save();

        $tags = Tag::find($data['tags']);
        $movie -> tags() ->attach($tags);

        Mail::to('email@movie.com')
            -> send(new NewMovie($movie));

        return response() ->json([
            'success' => true,
            'response'=>$movie
        ]);
    }
    public function movieUpdate(Request $request, Movie $movie) {

        $data = $request -> validate([
            'name' => 'required|string|min:3',
            'year' => 'required|integer|min:0',
            'cashOut' => 'required|integer|min:0',
            'genre_id' => 'required|integer|min:1',
            'tags_id' => 'required|array'
        ]);

        $genre = Genre :: find($data['genre_id']);
        $movie -> update($data);
        $movie -> genre() -> associate($genre);
        $movie -> save();

        $tags = Tag :: find($data['tags_id']);
        $movie -> tags() -> sync($tags);
    
        return response() -> json([
            'success' => true,
            'response' => $movie
        ]);
    }
}
