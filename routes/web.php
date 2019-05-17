<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/questions/store', 'QuestionController@store')->name('questions_store');
Route::get('/questions/edit/{id}', 'QuestionController@edit')->name('questions_edit');
Route::put('/questions/update/{id}', 'QuestionController@update')->name('questions_update');
Route::delete('/questions/destroy/{id}', 'QuestionController@destroy')->name('questions_destroy');

Route::get('/games/top', 'GameController@top')->name('games_top');
Route::post('/games/store', 'GameController@store')->name('games_store');
Route::post('/games/answer', 'GameController@answer')->name('games_answer');
