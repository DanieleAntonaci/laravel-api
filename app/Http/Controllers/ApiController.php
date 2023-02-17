<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Tag;
use App\Models\Genre;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiMovie (){
        $movies = Movie::all();
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
        return response() ->json([
            'success' => true,
            'response'=>$movie
        ]);
    }
}
