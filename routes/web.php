<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JsonDataController;
use App\Http\Controllers\CSVDataController;

use App\Http\Resources\EventsResource;
use App\Models\Events;
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
//default
Route::get('/', function () {
    return view('welcome');
});
//view for uploading excel sheet
Route::get('/csvdata', function () {
    return view('csvdata');
});

//route for uploading excel sheet
Route::post('/upload-csv', 'App\Http\Controllers\CSVDataController@upload');


//route for json data that makes the request - eventually needs to be made into a cron
Route::get('/jsondata', 'App\Http\Controllers\JsonDataController@fetch');


//route for api
Route::get('/api', function () {
    return EventsResource::collection(Events::all());
});
