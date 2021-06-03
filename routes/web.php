<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::get('/', 'AuthController@LoginPage');
Route::get('/register', 'AuthController@RegisterPage');
Route::post('/create', 'AuthController@CreateUser');
Route::post('/check', 'AuthController@CheckUser');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/todo', 'TodoController@index');
    Route::post('/add', 'TodoController@Add');
    Route::post('/changeStatus', 'TodoController@ChangeStatus');
    Route::post('/show', 'TodoController@Show');
    Route::get('/profile', 'AuthController@ShowProfile');
    Route::post('/updatedata', 'AuthController@UpdateDetails');
    Route::get('/completed', 'TodoController@Completed');
    Route::post('/showCompleted', 'TodoController@ShowCompleted');
    Route::post('/delete', 'TodoController@Delete');
    Route::post('/deleteCompleted', 'TodoController@DeleteCompleted');
    Route::get('/logout', 'AuthController@Logout');



});

