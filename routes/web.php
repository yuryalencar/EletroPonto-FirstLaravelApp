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

$this->get('admin', 'Admin\AdminController@index')->name('admin.home');
$this->get('collaborator', 'Collaborator\CollaboratorController@index')->name('collaborator.home');
$this->get('login', function (){return view('auth.login');})->name('auth.login');

$this->group(['middleware' => ['web', 'auth']], function() {
    Route::get('/', function(){
        if(Auth::user()->is_admin == 0){
            return redirect()->route('collaborator.home');
        } else {
            return redirect()->route('admin.home');
        }
    });
});

Auth::routes();
