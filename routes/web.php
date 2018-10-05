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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


Route::group(['middleware' => ['web', 'auth']], function(){
//    Route::get('/', function(){
//       return view('welcome');
//    });

    Route::get('/', function(){
        if(Auth::user()->is_admin == 0){
           return view('collaborator');
        } else {
            $users['users'] = \App\User::all();
            return view('admin', $users);
        }
    });
});