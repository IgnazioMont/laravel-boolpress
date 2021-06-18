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
Auth::routes(); // route generate da laravel per l'autenticazione

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home'); 
// Creata in automatico, la risettiamo a piacimento
// Aggiungiamo il middleware preso dall'HomeController
