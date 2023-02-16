@extends('layout.main-layout')

@section('content')
    <h1>MOVIES</h1> 
    <a href="{{route('movie.create')}}">ADD NEW MOVIE</a>
    <ul>
        @foreach ($movies as $movie)
        <li>
            {{$movie -> name}}

        </li>
        @endforeach
    </ul>
    
@endsection