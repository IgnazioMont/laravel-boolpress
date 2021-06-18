<?php
/* CONTROLLER SOLO PER UTENTI LOGGATI, CHE SI TROVANO NELLA CARTELLA ADMIN */
/* namespace differente */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // dovrà chiamare la pagina principale in cui gli utenti arrivano una volta loggati ("welcome" ecc...)
    public function index() {
        return view('admin.home');
    }
}