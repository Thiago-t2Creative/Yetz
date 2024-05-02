<?php

namespace App\Http\Controllers;

use App\Models\Jogador;

class SorteiosController extends Controller
{
    public function index()
    {
        $records = Jogador::all();
        //dd($records);

        return view('sorteios/index', compact("records"));
    }
}
