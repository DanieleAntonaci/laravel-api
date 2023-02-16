<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(){

        $genres = Genre::all();

        return view('pages.home', compact('genres'));
    }
    public function movie(){
        $movies = Movie::all();
        return view('pages.movie.movie', compact('movies'));
    }
    public function movieDelete(Movie $movie){

        $movie -> tags() -> sync([]);
        $movie -> delete();
        return redirect()-> route('home');
    }
    public function movieCreate(){
        $tags = Tag::all();
        $genres = Genre::all();
        return view('pages.movie.createMovie', compact('tags', 'genres'));
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
        return redirect() -> route('home.movie');
    }
    public function movieEdit(Movie $movie){
        $genres = Genre::all();
        $tags =Tag::all();
        return view('pages.movie.editMovie', compact('tags', 'genres', 'movie'));
    }

}
