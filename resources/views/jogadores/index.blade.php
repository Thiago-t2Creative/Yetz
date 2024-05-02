
@extends('layout.site')

@section('content')

    <div class="row">
        <div class="col s12">

            <h5>Jogadores</h5>
            <br>

            <a href="{{ route("jogadores.manage") }}" class="waves-effect waves-light btn pink darken-3">Novo Cadastro</a>
            <a href="#modal-cadastrar-ficticios" class="waves-effect waves-light btn modal-trigger pink darken-3">Cadastrar Fictícios</a>
            <a href="#modal-deletar-todos" class="waves-effect waves-light btn modal-trigger red">Deletar todos</a>

            <br>
            <br>

            @if ($records->count() == 0)

                <p>Nenhum cadastro encontrado.</p>

            @else

                <table class="striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Nível</th>
                            <th>Goleiro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $r)

                            <tr>
                                <td>{{ $r->nome }}</td>
                                <td>{{ $r->nivel }}</td>
                                <td>{{ $r->goleiro == 1 ? "Sim" : "Não" }}</td>
                                <td>
                                    <a href="{{ route('jogadores.manage', $r->id) }}"
                                        class="waves-effect waves-light btn pink darken-3">
                                        EDITAR
                                    </a>
                                    <a href="#modal-deletar-{{ $r->id }}"
                                        class="waves-effect waves-light btn red modal-trigger">
                                        DELETAR
                                    </a>
                                </td>
                            </tr>
                            <div id="modal-deletar-{{ $r->id }}" class="modal">
                                <form method="POST" action="{{ route('jogadores.delete', $r->id) }}">
                                    @csrf
                                    <div class="modal-content">
                                        <h4>Confirmação</h4>
                                        <p>Confirma a exclusão do cadastro?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancelar</a>
                                        <button class="waves-effect waves-green btn-flat" id="btn-confirmar-editar">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </tbody>
                </table>

            @endif

        </div>
    </div>

    <div id="modal-deletar-todos" class="modal">
        <form method="GET" action="{{ route('jogadores.deleteAll') }}">
            @csrf
            <div class="modal-content">
                <h4>Confirmação</h4>
                <p>Confirma a exclusão de TODOS os cadastros?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancelar</a>
                <button class="waves-effect waves-green btn-flat" id="btn-confirmar-editar">Confirmar</button>
            </div>
        </form>
    </div>

    <div id="modal-cadastrar-ficticios" class="modal">
        <form method="GET" action="{{ route('jogadores.criarJogadoresFicticios') }}">
            @csrf
            <div class="modal-content">
                <h4>Confirmação</h4>
                <p>Confirma a criação de 25 jogadores fictícios, sendo 4 goleiros?</p>
                <p><i>Obs.: Todos os cadastros atuais serão primeiramente deletados.</i></p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cancelar</a>
                <button class="waves-effect waves-green btn-flat" id="btn-confirmar-editar">Confirmar</button>
            </div>
        </form>
    </div>

@endsection
