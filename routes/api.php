<?php

use App\Models\Note;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::get('/notes', 'App\Http\Controllers\NotesController@getNotes');
Route::get('/note/{id}', 'App\Http\Controllers\NotesController@getNote');
Route::get('/get-note-history/{id}', 'App\Http\Controllers\notesController@getNoteHistory');
Route::post('/create-note', 'App\Http\Controllers\NotesController@createNote');
Route::put('/update-note', 'App\Http\Controllers\NotesController@updateNote');
Route::delete('/delete-note/{id}', 'App\Http\Controllers\NotesController@deleteNote');
