<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/tournament/scheduler', [TournamentController::class, 'scheduler'])->name('tournament.scheduler');
Route::get('/tournament/{id}', [TournamentController::class, 'view'])->name('tournament.view');
