<?php

namespace App\Http\Controllers;

use App\Http\Requests\JogadorRequest;
use App\Models\Jogador;

class JogadoresController extends Controller
{
    public function index()
    {
        $records = Jogador::all();
        //dd($records);

        return view('jogadores/index', compact('records'));
    }

    public function manage($id = null)
    {
        if($id == null)
            $jogador = null;
        else
            $jogador = Jogador::find($id);

        return view('jogadores/manage', compact('jogador'));
    }

    public function save(JogadorRequest $req)
    {
        $dados = $req->all();
        //dd($dados);

        //Se estiver adicionando um novo jogador
        if($dados['jogador_id'] == 0){
            $jogador = Jogador::create($dados);
        }

        //Senão (estiver editando)
        else{
            $jogador = Jogador::find($dados['jogador_id']);
            $jogador->update($dados);
        }

        return redirect()->route('jogadores');
    }

    public function delete($id)
    {
        //dd($id);

        $jogador = Jogador::find($id);
        $jogador->delete($id);

        return redirect()->route('jogadores');
    }

    public function deleteAll()
    {
        Jogador::truncate();

        return redirect()->route('jogadores');
    }

    public function criarJogadoresFicticios()
    {
        Jogador::truncate();

        Jogador::create(['nome' => 'Lucas Silva', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Gabriel Oliveira', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Pedro Almeida', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Matheus Santos', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Guilherme Costa', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Gustavo Pereira', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'João Ferreira', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Rafael Martins', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Daniel Souza', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Paulo Lima', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Vinícius Barbosa', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Felipe Rodrigues', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Henrique Nunes', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Diego Carvalho', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Fernando Rocha', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Thiago Gonçalves', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Bruno Cardoso', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Marcelo Ribeiro', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Leonardo Silva', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Eduardo Oliveira', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Vitor Martins', 'nivel' => rand(1, 5), 'goleiro' => 0]);
        Jogador::create(['nome' => 'Arthur Costa', 'nivel' => rand(1, 5), 'goleiro' => 1]);
        Jogador::create(['nome' => 'Carlos Ferreira', 'nivel' => rand(1, 5), 'goleiro' => 1]);
        Jogador::create(['nome' => 'Márcio Oliveira', 'nivel' => rand(1, 5), 'goleiro' => 1]);
        Jogador::create(['nome' => 'Rodrigo Almeida', 'nivel' => rand(1, 5), 'goleiro' => 1]);

        return redirect()->route('jogadores');
    }
}
