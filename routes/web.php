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

$this->post('record_employee_view', 'Navigation\NavigationController@record_employee_view')->middleware('verify.user')->name('view.insert.records.employee');
$this->post('edit_employee_record', 'Navigation\NavigationController@edit_employee_record')->middleware('verify.user')->name('edit.records.employee');
$this->get('dashboard', 'Navigation\NavigationController@index')->middleware('verify.user')->name('navigation.home');
$this->get('personal_record', 'Navigation\NavigationController@personal_record')->middleware('verify.user')->name('navigation.personal.records');
$this->get('employee_record', 'Navigation\NavigationController@employee_record')->middleware('verify.user')->name('navigation.personal.records');
$this->get('personal_history', 'Navigation\NavigationController@personal_history')->middleware('verify.user')->name('navigation.personal.records');
$this->get('history_employees', 'Navigation\NavigationController@history_employees')->middleware('verify.user')->name('navigation.personal.records');
$this->get('admin_record_history', 'Navigation\NavigationController@admin_record_history')->middleware('verify.user')->name('view.admin.history.records');
$this->get('view_detailed_historic_employee', 'Navigation\NavigationController@view_detailed_historic_employee')->middleware('verify.user')->name('view.detailed.historic.employee');
$this->get('view_record_historic_employee', 'Navigation\NavigationController@view_record_historic_employee')->middleware('verify.user')->name('view.record.historic.employee');


$this->post('record_current_time', 'Record\RecordController@record_current_time')->middleware('verify.user')->name('records.personal.current');
$this->post('record_time', 'Record\RecordController@record_time')->middleware('verify.user')->name('records.personal');
$this->post('historic_personal_record', 'Record\RecordController@historic_personal_record')->middleware('verify.user')->name('record.historic');
$this->post('insert_employee_record', 'Record\RecordController@insert_employee_record')->middleware('verify.user')->name('insert.employee.records');
$this->post('detailed_records_employee', 'Record\RecordController@detailed_records_employee')->middleware('verify.user')->name('view.detailed.records.employee');
$this->any('records_employee', 'Record\RecordController@records_employee')->middleware('verify.user')->name('view.records.employee');
$this->post('save_record', 'Record\RecordController@save_record')->middleware('verify.user')->name('save.edit.records.employee');
$this->any('search_personal_records', 'Record\RecordController@search_personal_records')->middleware('verify.user')->name('records.personal.search');

$this->get('login', function (){return view('auth.login');});

$this->group(['middleware' => ['auth']], function() {
    Route::get('/', function(){
        return redirect()->route('navigation.home');
    });
});

Auth::routes();
