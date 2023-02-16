<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::factory() -> count(100) -> make() -> each(function($movie){
            $genre = Genre::inRandomOrder() -> first();
            $movie -> genre() -> associate($genre);

            $movie -> save();

            $tags = Tag :: inRandomOrder() -> limit(rand(2, 4)) -> get();
            $movie -> tags() -> attach($tags);
        });

    }
}
