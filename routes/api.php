<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('/v1/movies', [ApiController::class, 'apiMovie']);