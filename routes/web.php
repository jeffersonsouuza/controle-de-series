<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Autenticador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', static function () {
    return redirect('/series');
})->middleware(Autenticador::class);

Route::resource('/series', SeriesController::class)
    ->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);

Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])
    ->name('seasons.index')
    ->middleware('autenticador');


Route::middleware('autenticador')->group( function () {
Route::get('/series/{season}/episodes', [EpisodesController::class, 'index'])
    ->name('episodes.index');
Route::post('/series/{season}/episodes', [EpisodesController::class, 'update'])
    ->name('episodes.update');
});


Route::get('/login', [LoginController::class, 'index'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->name('sigin');
Route::get('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

Route::get('/register', [UsersController::class, 'create'])
    ->name('users.create');
Route::post('/register', [UsersController::class, 'store'])
    ->name('users.store');

Route::get('/email', function () {
    return new \App\Mail\SeriesCreated(
        'Série de Teste',
        15,
        5,
        8
    );
});




//Route::post('/series/destroy/{serie}', [SeriesController::class, 'destroy'])
//    ->name('series.destroy');

//Route::controller(SeriesController::class)->group(function () {
//    Route::get('/series', 'index')->name('series.index');
//    Route::get('/series/criar','create')->name('series.create');
//    Route::post('/series/salvar', 'store')->name('series.store');;
//});

//Route::get('/series', [SeriesController::class, 'index']);
//Route::get('/series/criar', [SeriesController::class, 'create']);
//Route::post('/series/salvar', [SeriesController::class, 'store']);

