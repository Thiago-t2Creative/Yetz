<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JogadorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => 'required',
            'nivel' => 'required',
            'goleiro' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Nome não informado!',
            'nivel.required' => 'Nível não informado!',
            'goleiro.required' => 'Goleiro (sim ou não informado!',
        ];
    }
}
