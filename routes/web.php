<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\PlayerController;
use App\Http\Middleware\RedirectToLogin;

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



Route::get('/', [LoginController::class, 'getLogin'])->name('/');
Route::post('log-in', [LoginController::class, 'login'])->name('log-in');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('validate', [LoginController::class, 'getValidation'])->name('validate');
Route::post('validateToken', [LoginController::class, 'validateToken'])->name('validateToken');
Route::post('importFile', [AdminController::class, 'importFile'])->name('importFile');
Route::post('importResults', [AdminController::class, 'importResults'])->name('importResults');
Route::get('index/', [PlayerController::class, 'index'])->name('index');


Route::resource('tournaments', TournamentController::class);

Route::middleware([RedirectToLogin::class])->group(function () {
    Route::get('getPanel/', [AdminController::class, 'getPanel'])->name('getPanel');
    Route::get('Registration', [AdminController::class, 'getRegistration'])->name('Registration');
    Route::get('Results', [AdminController::class, 'getResults'])->name('Results');
    Route::get('RedirectToPersonal', [PlayerController::class, 'RedirectToPersonal'])->name('RedirectToPersonal');
    Route::get('getStandingsPage/', [PlayerController::class, 'getStandingsPage'])->name('getStandingsPage');
    Route::get('getPairingsPage/', [PlayerController::class, 'getPairingsPage'])->name('getPairingsPage');
});
