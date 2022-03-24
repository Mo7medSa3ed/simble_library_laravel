<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/links', 'ImportantLinkController@getAllLinks');
Route::get('/links/{id}', 'ImportantLinkController@getOneLink');
Route::post('/links', 'ImportantLinkController@addLink');
Route::put('/links/{id}', 'ImportantLinkController@updateLink');
Route::delete('/links/{id}', 'ImportantLinkController@deleteLink');

Route::get('/files', 'FilesController@getAllFiles');
Route::get('/files/{id}', 'FilesController@getOneFile');
Route::get('/files/all/{relate_to}/{year}', 'FilesController@getOneFileByYearAndRelateTo');
Route::post('/files/upload', 'FilesController@addFile');
Route::post('/files/{id}', 'FilesController@updateFile');
Route::delete('/files/{id}', 'FilesController@deleteFile');

Route::get('/views', 'DevicesController@getViewsCount');
Route::post('/views', 'DevicesController@makeView');


