<?php

use Illuminate\Support\Facades\Route;

// Movies
Route::get('/', 'MoviesController@index')->name('movies.index');
Route::get('/movies/{movie}', 'MoviesController@show')->name('movies.show');

// Actors
Route::get('/actors', 'ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page?}', 'ActorsController@index');
Route::get('/actors/{actor}', 'ActorsController@show')->name('actors.show');
