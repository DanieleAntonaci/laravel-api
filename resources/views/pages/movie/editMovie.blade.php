@extends('layout.main-layout')

@section('content')
    <h1>ADD NEW MOVIE</h1> 
    <form action="{{route('movie.store')}}" method="post">
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

        
        <select name="genres" >
            @foreach ($genres as $genre)
            <option value="{{$genre -> id}}">
                {{$genre -> name}}
            </option>
                
            @endforeach
        </select>


            @foreach ($tags as $tag)
            <div>

                <input type="checkbox" name="tags[]" value="{{$tag-> id}}">
                <label for="tags">{{$tag-> name}}</label>
            </div>
            @endforeach

        <input type="submit" value="CREATE NEW MOVIE">
    </form>
    
@endsection