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
}
