<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // demo toastr
        toastr()->warning('Mensagem de Teste!', 'Titulo da Mensagem', ["timeOut" => "3000"])->success('BEM-VINDO');
        return view('home');
    }
}
