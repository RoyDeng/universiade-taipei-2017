<?php
Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/item', 'ItemController@index');
Route::get('/item/viewItem', 'ItemController@viewItem');
Route::post('/item/createItem', 'ItemController@createItem');
Route::post('/item/updateItem', 'ItemController@updateItem');
Route::post('/item/removeItem', 'ItemController@removeItem');

Route::get('/item_detail/{id}', 'ItemController@itemDetail');
Route::get('/item/viewItemDetail', 'ItemController@viewItemDetail');
Route::post('/item/createItemDetail', 'ItemController@createItemDetail');
Route::post('/item/updateItemDetail', 'ItemController@updateItemDetail');
Route::post('/item/removeItemDetail', 'ItemController@removeItemDetail');
Route::post('/item/applyItemDetail', 'ItemController@applyItemDetail');

Route::get('/location', 'LocationController@index');
Route::get('/location/viewLocation', 'LocationController@viewLocation');
Route::post('/location/createLocation', 'LocationController@createLocation');
Route::post('/location/updateLocation', 'LocationController@updateLocation');
Route::post('/location/removeLocation', 'LocationController@removeLocation');

Route::get('/eqpt', 'EqptController@index');
Route::get('/eqpt_detail/{id}', 'EqptController@eqptDetail');
Route::get('/eqpt/viewEqpt', 'EqptController@viewEqpt');
Route::post('/eqpt/createEqpt', 'EqptController@createEqpt');
Route::post('/eqpt/updateEqpt', 'EqptController@updateEqpt');
Route::post('/eqpt/removeEqpt', 'EqptController@removeEqpt');

Route::get('/note', 'NoteController@index');
Route::get('/note_detail/{id}', 'NoteController@noteDetail');
Route::get('/note/viewNote', 'NoteController@viewNote');
Route::post('/note/createNote', 'NoteController@createNote');
Route::post('/note/updateNote', 'NoteController@updateNote');
Route::post('/note/removeNote', 'NoteController@removeNote');

Route::get('/form', 'FormController@index');
Route::get('/form_detail/{id}', 'FormController@formDetail');

Route::get('/user', 'UserController@index');
Route::get('/user/viewUser', 'UserController@viewUser');
Route::post('/user/createUser', 'UserController@createUser');
Route::post('/user/createAdmin', 'UserController@createAdmin');
Route::post('/user/updateUser', 'UserController@updateUser');
Route::post('/user/updatePassword', 'UserController@updatePassword');
Route::post('/user/removeUser', 'UserController@removeUser');
Route::post('/user/applyUser', 'UserController@applyUser');
Route::get('/check_log', 'UserController@checkLog');
Route::get('/check_log/viewLog', 'UserController@viewLog');
Route::post('/check_log/updateLog', 'UserController@updateLog');

Route::post('/api/Login', 'DBController@Login');
Route::post('/api/LoadData', 'DBController@LoadData');
Route::post('/api/CheckIn', 'DBController@CheckIn');
Route::post('/api/CheckOut', 'DBController@CheckOut');
Route::post('/api/EquipCheckLoad', 'DBController@EquipCheckLoad');
Route::post('/api/EquipCheck', 'DBController@EquipCheck');
Route::post('/api/ReportLoad', 'DBController@ReportLoad');
Route::post('/api/Report', 'DBController@Report');
Route::post('/api/Logout', 'DBController@Logout');

Route::get('/api/ReportPage/{eqpt_id}/{form_id}/{username}/{token}', 'DBController@ReportPage');
Route::post('/api/Sign', 'DBController@Sign');