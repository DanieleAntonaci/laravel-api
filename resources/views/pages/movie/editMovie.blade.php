@extends('layout.main-layout')

@section('content')
    <h1>EDIT MOVIE</h1> 
    <form action="{{route('movie.update', $movie)}}" method="post">
        @csrf
        <div>

            <label for="name">Name</label>
            <input type="text" name='name' value="{{$movie -> name}}">
        </div>

        <div>

            <label for="year">year</label>
            <input type="text" name='year' value="{{$movie -> year}}">
        </div>
        <div>

            <label for="cashOut">cashOut</label>
            <input type="text" name='cashOut' value="{{$movie -> cashOut}}">
        </div>

        <label for="genres">Genre</label>
        <select name="genres" >
            @foreach ($genres as $genre)
            <option value="{{$genre -> id}}" @selected ($movie -> genre -> id == $genre -> id)>
                {{$genre -> name}}
            </option>
                
            @endforeach
        </select>


        <h3>Tag</h3>
            @foreach ($tags as $tag)
            <div>

                <input type="checkbox" name="tags[]" value="{{$tag-> id}}" 
                    @foreach ($movie -> tags as $movieTag)
                        @checked ($movieTag -> id == $tag -> id)
                    @endforeach>
                <label for="tags">{{$tag-> name}}</label>
            </div>
            @endforeach



        <input type="submit" value="EDIT MOVIE">
    </form>
    
@endsection