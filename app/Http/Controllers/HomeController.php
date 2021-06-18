<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/* Serve per prendere i dati dell'utente loggato */

class HomeController extends Controller
{
    /*  Troviamo prima il "middleware" viene chiamato quando il controller viene eseguito, 
        controlla che l'utente sia loggato/autenticato,
        solitamente lo si fa direttamente nella route.
        Lo cancelliamo da qui e lo inseriamo in "web.php"
    */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /* Qui inseriamo eventuali funzioni per l'id utente o controllare se è loggato ecc.. */
        return view('guest.home');
    }
}
