<?php

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

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'welcome'])->name('welcome');


Route::get("/fixture", [\App\Http\Controllers\FixtureController::class, 'index'])->name('fixture');
Route::get("/fixture/generate", [\App\Http\Controllers\FixtureController::class, 'generate'])->name('fixture.generate');

Route::get("/simulation", [\App\Http\Controllers\SimulationController::class, 'index'])->name('simulation');
Route::get("/simulation/play", [\App\Http\Controllers\SimulationController::class, 'play'])->name('simulation.play');
Route::get("/simulation/reset", [\App\Http\Controllers\SimulationController::class, 'reset'])->name('simulation.reset');
Route::get("/simulation/playAll", [\App\Http\Controllers\SimulationController::class, 'playAll'])->name('simulation.playAll');
