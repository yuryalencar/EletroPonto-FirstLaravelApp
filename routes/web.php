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

$this->get('dashboard', 'Navigation\NavigationController@index')->name('navigation.home');
$this->get('login', function (){return view('auth.login');});


$this->group(['middleware' => ['auth']], function() {
    Route::get('/', function(){
        return redirect()->route('navigation.home');
    });
});

Auth::routes();
