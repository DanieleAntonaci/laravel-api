@extends('layout.main-layout')

@section('content')
    <h1>GENRE WITH MOVIES</h1> 
    <a href="{{route('home.movie')}}">SEE MOVIE</a>
    <ul>
        @foreach ($genres as $genre)
            <li>
                <h2>{{$genre -> name}}</h2>
                <ul>
                    @foreach ($genre -> movies as $movie)
                    <li>
                        {{$movie -> name}}
                        ----
                        <a href="{{route('movie.delete', $movie)}}">DELETE</a>
                        <a href="{{route('movie.edit', $movie)}}">edit</a>
                    </li>
                    @endforeach
                </ul>
            </li>
        
        @endforeach
    </ul>
    
@endsection