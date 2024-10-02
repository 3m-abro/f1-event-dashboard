<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\F1Controller;

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


Route::get('/schedule', [F1Controller::class, 'getRaceSchedule']);
Route::get('/standings', [F1Controller::class, 'getTeamStandings']);
Route::get('/live', [F1Controller::class, 'getLiveRaceUpdates']);

