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


/* inseriamo la route per la sezione pubblica/utenti loggati */
Route::prefix('admin')
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function () {
    /* questa route invece verrà chiamata dalla cartella admin,
    tutte quelle create saranno protette da autenticazione.
    Si possono anche aggiungere le route alle CRUD ( Route::resource(); ) */
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('posts', 'PostController');
});

/* La route dell'homepage pubblica chiamerà il controller che si trova nel solito file HomeController */
Route::get('/', 'HomeController@index')->name('home'); 
// Creata in automatico, la risettiamo a piacimento
// Volendo aggiungiamo il middleware preso dall'HomeController


/* Gestione blog pubblico */
Route::get('/blog', 'PostController@index')->name('blog');

/* Route per lo SLUG */
Route::get('/blog/{slug}', 'PostController@show')->name('blog-page');
/* verrà passato a show quando viene chiamato il controller */